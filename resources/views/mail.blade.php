@extends('layout')

@section('content')
   <div id="inbox" class="panel panel-default">
      <div class="panel-heading">
         <h1 class="panel-title">Caixa Postal</h1>
      </div>
      <div class="panel-body">
         Aqui os 10 mais recentes emails.
      </div>
      <div class="list-group">
         <?php if (isset($userSummaries)) {
         $j=0;
         foreach($userSummaries as $message) { 
            ?>
            <div class="list-group-item">
               <h3 class="list-group-item-heading">
                  <?php echo $message["assunto"] ?>
               </h3>
               <h4 class="list-group-item-heading">
                  <?php echo $message["nome"] ?>
               </h4>
               <p class="list-group-item-heading text-muted">
                  <em>Received: <?php echo $message["dateReceived"] ?></em>
                  <?php $varSplit = implode("|", $data[$j]);?>
                  <span class="t-right">
                     <a class="btn btn-sm btn-primary btn-envio" role="button" id="enviarDados"  onclick="enviar('<?php echo $varSplit;?>',this)"  >Enviar</a>
                  </span>
               </p>

               <input type="hidden" name="nome"      id="nome"       value="<?php  echo $data[$j]['nome']; ?>" />
               <input type="hidden" name="endereco"  id="endereco"   value="<?php  echo $data[$j]['endereco']; ?>" />
               <input type="hidden" name="valor"     id="valor"      value="<?php  echo $data[$j]['valor']; ?>" />
               <input type="hidden" name="vencimento" id="vencimento" value="<?php  echo $data[$j]['vencimento']; ?>" />
               <?php $j++ ?>
               <hr>

            </div>
         <?php  }
         } ?>
      </div>
   </div>
@endsection