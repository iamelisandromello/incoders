<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EmailExtratorService
{
   private function isLine($line, $field)
   {
      $lenght = strlen($field);

      if (Str::startsWith($line, $field)) {
         return [Str::slug($field) => trim(Str::substr($line, $lenght + 1))];
      }

      return [];
   }

   public function extract($content)
   {
      return (new Collection(explode("\n", $content)))->mapWithKeys(function ($line) {
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
   }
}