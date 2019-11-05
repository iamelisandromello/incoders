<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TestJsonService
{
   public function isJson($data)
   {
      $response = '';

      //esta string não está bem-formada, pois o valor M não está entre aspas
      //$json_str = '{"nome":"Jason Jones", "idade":38, "sexo": M}';
      
      //faz o parsing na string, gerando um objeto PHP
      $obj = json_decode($data);
      
      //testa se houve erro no parsing!
      if (json_last_error() == 0) 
      {       
         return $obj; //Retorna string objeto php
      }   
         
      //Retona Mensagem de erro de parsing identificado
      switch (json_last_error()) 
      {
      
         case JSON_ERROR_DEPTH:
            $response =  ' - profundidade maxima excedida';
         break;
         case JSON_ERROR_STATE_MISMATCH:
            $response =  ' - state mismatch';
         break;
         case JSON_ERROR_CTRL_CHAR:
            $response =  ' - Caracter de controle encontrado';
         break;
         case JSON_ERROR_SYNTAX:
            $response =  ' - Erro de sintaxe! String JSON mal-formada!';
         break;
         case JSON_ERROR_UTF8:
            $response = ' - Erro na codificação UTF-8';
         break;
         default:
               $response = ' – Erro desconhecido';
         break;
      }
      
      return ($response);
   }
}

