<?php

namespace App\Services;

use App\Contracts\InvoiceService;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogInvoiceService implements InvoiceService
{
   public function postInvoice($data)
   {
      Log::info(json_encode($data));
   }
}