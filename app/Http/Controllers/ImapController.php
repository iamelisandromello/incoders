<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\PostInvoiceJob;
use App\Contracts\InvoiceService;
use App\Services\EmailExtratorService;
use App\Services\TestJsonService;
use App\Services\ImapConnectionService;
use Webklex\IMAP\Client;
use App\Http\Controllers\Controller;

class ImapController extends Controller
{
   public function signin(EmailExtratorService $serviceExtrator, ImapConnectionService $serviceConnection)
   {
      if (session_status() == PHP_SESSION_NONE)
      {
         session_start();
      }

      //Requisição de Serviço para conectar Caixa postal via IMAP
      $oClient = $serviceConnection->connectionImap();
      $oClient == false ? $nMensagens = 0 : $nMensagens = $oClient->countMessages();

      //verifica se existem mensagens para serem tratadas      
      if($nMensagens === 0)
      {
         return view('mail', array(
            "username"     => 'Incoders Tecnologia',
            'mensagens'    => '',
            'connection'   => $oClient == false ? false : true
         ));
      }

      //Definir diretorio de downloads anexos
      $savedir = public_path('imap-anexos/');

      //Obter todas as pastas de correio
      $aFolder = $oClient->getFolders();
      //Percorrer todas as pastas do correio
      foreach($aFolder as $oFolder)
      {

         //Obter todas as mensagens da pasta Mailbox atual
         $aMessage = $oFolder->messages()->all()->get();         
         $i = 0;
         $l = 0;
         $x = 0;

         foreach($aMessage as $oMessage)
         {
            $nAnexos = $oMessage->getAttachments()->count();
            if ($nAnexos === 0) { // pula email sem anexo
               continue;
            }
            
            //Obtem anexos da mensagem
            $aAttachments =  $oMessage->getAttachments();
            //percorre os anexos
            foreach($aAttachments as $attachment)
            {
               
               //Realiza o download do anexo e salva no diretório temporário
               $anexo = $attachment->getFilename();
               $attachment->save($savedir, $anexo, true);

               //Converte o arquivo salvo em base64
               $nomeAnexo  = $attachment->getName();
               $localPath  = $savedir . $nomeAnexo;
               $b64[$x]    = base64_encode(file_get_contents($localPath));

               //Excluir arquivo temporário
               unlink($localPath);

            }

            //Captura o conteudo corpo do e-mail
            $content    = $oMessage->getTextBody(true);
            //Requisição de Serviço para realizar o tratamento dos dados do e-mail
            $data[$l]   = $serviceExtrator->extract($content);
            //Incremento contadores
            $l++;
            $x++;
            $i++;
            $mensagens[$i] = array(
               'nome'         => $oMessage->getFrom()[0]->mail,
               'assunto'      => $oMessage->getSubject(),
               'dateReceived' => $oMessage->getDate()->format(DATE_RFC2822)
            ); 

            //Move a mensagem atual para 'Emails Lidos'
            /* if($oMessage->moveToFolder('INBOX.read') == true){
               echo 'Message has ben moved';
            }else{
               echo 'Não foi possível mover a mensagem';
            }*/

         }
      }

      return view('mail', array(
         'mensagens'    => isset($mensagens) ? $mensagens : '',
         'data'         => isset($data)      ? $data : '',
         'anexo'        => isset($b64)       ? $b64 : '',
         "username"     => 'Incoders Tecnologia',
         'connection'   => true
      ));
   }

   /**
   * Create a new controller instance.
   *
   * @return void
   */
   public function ajaxRequest()
   {
      return view('ajaxRequest');
   }

   /**
   * Create a new controller instance.
   *
   * @return void
   */
   public function ajaxRequestPost(EmailExtratorService $serviceExtrator, TestJsonService $serviceJson, Request $request)
   {
      $input         = $request->all();
      $string_json   = json_encode($input);

      $returnJson = $serviceJson->isJson($string_json);
      //verifica se retornou mensagem de erro da validacao do Parsing Json
      if(is_string ( $returnJson )) 
      {
         $response = array(
            'status' => 'fail',
            'msg'    => $returnJson,
         );         
         return response()->json(['success'=>$returnJson]);
      }

      $returnJson = json_decode($string_json, true);
      //envia dados para fila de job de execução, liberando o usuário
      dispatch(new PostInvoiceJob($returnJson));
 
      $response = array(
         'status' => 'success',
         'msg'    => 'Processo de Envio',
      );
      return response()->json(['success'=>'Processo de Envio para API Rest Realizado com Sucesso.']);
   }

}