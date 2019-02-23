<?php require_once '../engine/infused_cogs.php'; ob_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/png" href="../favicon.png">
    <style media="screen">
      .login-ui{
        padding:5% 0%;
      }
    </style>
  </head>
  <body>
    <div class="login-ui">
      <h1>Writer's Pad <img src='../image-backgrounds/quilt.png'></h1>
      <form class="ui-form" action="" method="post">
        <h2>Login</h2><br>
        <?php userLogin(); ob_end_flush();?>
        <input type="text" name="username" placeholder="username"><br><br>
        <input type="password" name="password" placeholder="password"><br><br><br>
        <input type="submit" name="login" value="login"><br><br>

        <footer>
          Designed with <i class="material-icons">favorite</i> by <a href="http://www.evanswanjau.codydevelopers.co.ke" target="_blank">evanswanjau</a>
        </footer>
      </form>
    </div>
  </body>
</html>
