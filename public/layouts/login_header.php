<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Thanks From Me</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo include_css("bootstrap.min.css"); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo include_css("admin-css.css"); ?>" rel="stylesheet">
    <link href="<?php echo include_css("main.css"); ?>" rel="stylesheet">
    <link href="<?php echo include_css("footer.css"); ?>" rel="stylesheet">
    <link href="<?php echo include_css("signin.css"); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">thanksfrom.me</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" action="login.php" method="POST">
                <div class="form-group">
                    <input type="text" id="username" class="form-control" placeholder="Username" name="username" required>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                </div>
                <button class="btn btn-primary" type="submit" name="submit">Sign in</button>
            </form>
        </div>
      </div>
    </nav>