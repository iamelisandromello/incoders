<?php
namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Webklex\IMAP\Client;   
use App\Contracts\ConnectionService;
use Throwable;

class ImapConnectionService implements ConnectionService
{
   private $oClient;

   public function __construct(Client $oClient)
   {
      $this->oClient = $oClient;
   }

   public function connectionImap()
   {
      
      try {
         $this->oClient->connect();
      } catch (Throwable $throwable) {
         return false;
      }

      return $this->oClient;
   }
}