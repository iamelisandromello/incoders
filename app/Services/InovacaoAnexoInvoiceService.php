<?php

namespace App\Services;

use App\Contracts\InvoiceService;
use Guzzle\Client;
use Throwable;

class InovacaoAnexoInvoiceService extends InovacaoInvoiceService implements InvoiceService
{
   public function postInvoice($data)
   {
      $data['anexo'] = base64_encode($data['anexo']);
      
      return $this->postInvoice($data);
   }
}