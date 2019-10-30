@extends('layout')

@section('content')
<div id="inbox" class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">Inbox</h1>
  </div>
  <div class="panel-body">
    Aqui os 10 mais recentes emails.
  </div>
  <div class="list-group">
    <?php if (isset($userSummaries)) {
      foreach($userSummaries as $message) { ?>
    <div class="list-group-item">
      <h3 class="list-group-item-heading">teste<?php echo $message["assunto"] ?></h3>
      <h4 class="list-group-item-heading">teste2<?php echo $message["nome"] ?></h4>
      <p class="list-group-item-heading text-muted">teste3<em>Received: <?php echo $message["body"] ?></em></p>
    </div>
    <?php  }
    } ?>
  </div>
</div>
@endsection