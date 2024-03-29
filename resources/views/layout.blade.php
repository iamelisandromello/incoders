<!DOCTYPE html>
<html>
  <head>
    <title>PHP Gerenciador de e-mails</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta id="token" name="token" content="{ { csrf_token() } }">
    
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">PHP - Gerenciar Emails</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="<?php echo ($_SERVER['REQUEST_URI'] == '/' ? 'active' : '');?>"><a href="/">Home</a></li>
          </ul>
          <?php if(isset($username)) { ?>
          <ul class="nav navbar-nav navbar-right">
            <li><p class="navbar-text">Hello <?php echo $username ?>!</p></li>
          </ul>
          <?php } ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" role="main">
      @yield('content')
    </div>
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo asset('js/envio.js')?>"></script>
  </body>
</html>