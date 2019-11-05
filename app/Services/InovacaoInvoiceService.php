<?php

namespace App\Services;

use App\Contracts\InvoiceService;
use GuzzleHttp\Client;
use Throwable;

class InovacaoInvoiceService implements InvoiceService
{
   private $http;

   public function __construct(Client $http)
   {
      $this->http = $http;
   }

   public function postInvoice($data)
   {
      
      //return true;
      try 
      {     
         
         $res= $this->http->request('POST', 'http://localhost:3000/email', $data);

      } catch (Throwable $throwable) 
      {
         
         return false;
         
      }

      return true;
   }

}