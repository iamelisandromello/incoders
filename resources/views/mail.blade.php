@extends('layout')

@section('content')
   <div id="inbox" class="panel panel-default">
      <div class="panel-heading">
         <h1 class="panel-title">Caixa Postal</h1>
      </div>
      <div class="panel-body">
         Emails para Gerenciamento.
      </div>
      <div class="list-group">
         <?php if ($mensagens != '') {
         $j=0;
         foreach($mensagens as $message) { 
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
                  <?php 
                     $dadosSplit = implode("|", $data[$j]);?>
                  <span class="t-right">
                     <a class="btn btn-sm btn-primary btn-envio" role="button" id="enviarDados"  onclick="enviar('<?php echo $dadosSplit;?>', '<?php echo $anexo[$j];?>', this)">Enviar</a>
                  </span>
               </p>
               <?php $j++ ?>
               <hr>

            </div>
         <?php  }
         } else { ?>
            <div class="col-md-12">
               <div id="capaefectos" class="alert alert-primary">
                  <?php if ($connection == true) { ?>
                     Não existem mensagens para serem analisadas e enviadas <a href="./" class="alert-link">Clique aqui</a> para retornar.
                  <?php } else { ?>
                     Não foi possível realizar a conexão com a Caixa Postal, tente mais tarde. <a href="./" class="alert-link">Clique aqui</a> para retornar.
                  <?php ; } ?>   
               </div><!-- </capaefectos> -->
            </div>
         <?php } ?>

      </div>
   </div>
@endsection