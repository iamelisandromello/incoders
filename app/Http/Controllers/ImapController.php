<?php
namespace App\Http\Controllers;

use Webklex\IMAP\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ImapController extends Controller
{
   public function signin()
   {
      if (session_status() == PHP_SESSION_NONE) {
      session_start();
      }

      $oClient = new Client([
         'host'          => 'mail.elisandromello.com.br',
         'port'          => 993,
         'encryption'    => 'ssl',
         'validate_cert' => true,
         'username'      => 'iam@elisandromello.com.br',
         'password'      => '@S3curi7y',
         'protocol'      => 'imap'
      ]);
      /* Alternative by using the Facade
      $oClient = Webklex\IMAP\Facades\Client::account('default');
      */


      //Connect to the IMAP Server
      $oClient->connect();

      //Get all Mailboxes
      /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
      $aFolder = $oClient->getFolders();

      //Loop through every Mailbox
      /** @var \Webklex\IMAP\Folder $oFolder */
      foreach($aFolder as $oFolder){

         //Get all Messages of the current Mailbox $oFolder
         /* @var \Webklex\IMAP\Support\MessageCollection $aMessage */
         $aMessage = $oFolder->messages()->all()->get();         
         $i = 0;

         /* @var \Webklex\IMAP\Message $oMessage */
         foreach($aMessage as $oMessage){
            /*echo $oMessage->getSubject().'<br />';
            echo 'Attachments: '.$oMessage->getAttachments()->count().'<br />';
            echo $oMessage->getHTMLBody(true);*/
                  $i++;
                  $marks[$i] = array('nome' => $oMessage->getFrom()[0]->mail, 'assunto' => $oMessage->getSubject(), 'body' => $oMessage->getHTMLBody(true));
                  /*$sumario["nome"]		= $oMessage->getFrom()[0]->mail;
                  $sumario["assunto"]	= $oMessage->getSubject();            
                  $sumario["body"]		= $oMessage->getHTMLBody(true);*/   

            //Move the current Message to 'INBOX.read'
            /*if($oMessage->moveToFolder('INBOX.read') == true){
                  echo 'Message has ben moved';
            }else{
                  echo 'Message could not be moved';
            }*/
         }
      }

      return view('mail', array(
         'userSummaries' => $marks
      ));
   }

   private function isLine($line, $field)
   {
      $lenght = strlen($field);

      if (Str::startsWith($line, $field)) {
         return [Str::slug($field) => trim(Str::substr($line, $lenght + 1))];
      }

      return [];
   }

   public function email()
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

      $data = (new Collection(explode("\n", $email)))->mapWithKeys(function ($line) {
         $line = trim($line);

         if ($name = $this->isLine($line, 'Nome')) {
            return $name;
         } 
         
         if ($address = $this->isLine($line, 'Endereço')) {
            return $address;
         } 
         
         if ($value = $this->isLine($line, 'Valor')) {
            return $value;
         } 
         
         if ($vencto = $this->isLine($line, 'Vencimento')) {
            return $vencto;
         } 
      
         return [];
      })->filter()->toArray();

      dd($data);
   }
}