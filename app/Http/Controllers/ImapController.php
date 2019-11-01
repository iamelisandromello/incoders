<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\PostInvoiceJob;
use App\Contracts\InvoiceService;
use App\Services\EmailExtratorService;
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

      //Obter todas as pastas de correio
      $aFolder = $oClient->getFolders();

      //Percorrer todas as pastas de correio
      foreach($aFolder as $oFolder)
      {

         //Obter todas as mensagens da pasta Mailbox atual
         $aMessage = $oFolder->messages()->all()->get();         
         $i = 0;
         $l = 0;

         foreach($aMessage as $oMessage)
         {
            
            //Captura o conteudo corpo do e-mail
            $content = $oMessage->getTextBody(true);
            //Requisição de Serviço para realizar o tratamento dos dados do e-mail
            $data[$l] = $serviceExtrator->extract($content);
            $l++;
            
            // Estudar Jobs
            //dispatch(new PostInvoiceJob($data));

            /*
            echo 'Attachments: '.$oMessage->getAttachments()->count().'<br />';
            */
            
            $i++;
            $marks[$i] = array(
               'nome'         => $oMessage->getFrom()[0]->mail,
               'assunto'      => $oMessage->getSubject(),
               'dateReceived' => $oMessage->getDate()->format(DATE_RFC2822),
               'data'         => $data
            ); 

            //Mova a mensagem atual para 'Emails Lidos'
            /*if($oMessage->moveToFolder('INBOX.read') == true){
                  echo 'Message has ben moved';
            }else{
                  echo 'Não foi possível mover a mensagem';
            }*/
         }
      }

      for ($i=0; $i < count($data); $i++) { 
         $dataRow[$i] = implode("|", $data[$i]);
      }

      return view('mail', array(
         'userSummaries'   => $marks,
         'data'            => $data,
         'dataRow'         => $dataRow,
      ));
   }

   public function email(EmailExtratorService $extrator)
   {
      $email = '
      Bom dia,
      Segue meus dados de contato e informações para pagamento 
      
      Nome: Guarida Imóveis
      Endereço: Protásio alves, 1309
      Valor: R$ 1.800,50
      Vencimento:12/19
      
      Att.
      ';

      $data = $extrator->extract($email);

      dispatch(new PostInvoiceJob($data));

      dd($data);
   }


   public function send()
   {
      dd('entrou no controller');
      $email = '
      Bom dia,
      Segue meus dados de contato e informações para pagamento 
      
      Nome: Guarida Imóveis
      Endereço: Protásio alves, 1309
      Valor: R$ 1.800,50
      Vencimento:12/19
      
      Att.
      ';

      $data = $extrator->extract($email);
      dispatch(new PostInvoiceJob($data));
      dd($data);
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
   public function ajaxRequestPost(EmailExtratorService $serviceExtrator, Request $request)
   {
      /*echo("ajaxrequestpost");
      die;*/
      $input = $request->all();

      $data = $extrator->extract($input);

      dd($data);
      dispatch(new PostInvoiceJob($data));

      dd($input);
      $response = array(
         'status' => 'success',
         'msg'    => 'Setting created successfully',
      );
      return response()->json(['success'=>'Got Simple Ajax Request.']);
   }

}