<?php require_once '../engine/infused_cogs.php';ob_start(); adminSecurity(); logOut();?>
<!-- EVans Wanjau Website -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Security</title>
    <link rel="icon" type="image/png" href="../favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
  </head>

  <!-- Top Menu -->
  <section>
    <div class="top-menu">
      <ul>
        <a href="../"><li style="width:50%;font-size:16px;"><i class="material-icons left"> account_balance</i>&nbsp;&nbsp;writepad</li></a>
        <span>
          <a href="../"><li><i class="material-icons top" title="notifications">notifications_none</i></li></a>
          <a href="../security"><li><i class="material-icons top" title="security">security</i></li></a>
          <a href='?logout'><li><i class="material-icons top" title="logout">exit_to_app</i></li></a>
        </span>
      </ul>
    </div>
  </section>

  <body>
    <!-- Security -->
    <div class="container-fluid">
      <div class="row">

        <div class="col-sm-2 side-menu">
          <a href="">
            <div class="profile">
              <?php echo getProfilePic('../'); ?>
              <p>@<?php echo strtolower($_COOKIE['Theadmin']); ?></p>
            </div>
          </a>
          <!-- our menu -->
          <ul>
            <a href="../"><li><i class="material-icons">dashboard</i>dashboard</li></a>
            <a href="../new-post"><li><i class="material-icons">queue</i>new post</li></a>
            <a href="../my-posts"><li><i class="material-icons">collections</i>my posts</li></a>
            <a href="../subscribers"><li><i class="material-icons">group</i>subscribers</li></a>
            <a href="../security"><li class="current"><i class="material-icons">security</i>security</li></a>
          </ul>
        </div>

        <div class="col-sm-10 right-side">

          <div class="admin-ui">
            <form class="ui-form" action="" method="post" enctype="multipart/form-data">
              <h4>change profile picture</h4>
              <?php  echo getProfilePic('../'); ?><br><br>
              <?php changeProfilePic();?>
              <input type="file" name="image"><br>  <!-- Chane username -->
              <input type="submit" name="change-profile-pic" value="change profile picture">
            </form>
          </div>

          <div class="admin-ui">
            <form class="ui-form" action="" method="post">
              <h4>change username</h4>
              <?php changeUsername(); ?>
              <input type="text" name="username" value="<?php echo strtolower($_COOKIE['Theadmin']); ?>" placeholder="username"><br><br>  <!-- Chane username -->
              <input type="submit" name="change-username" value=" change username">
            </form>
          </div>

          <div class="admin-ui">
            <form class="ui-form" action="" method="post">
              <h4>change password</h4>
              <?php changePassword(); ob_end_flush();?>
              <input type="password" name="old-password" placeholder="old password"><br><br>
              <input type="password" name="new-password" placeholder="new password"><br><br>
              <input type="password" name="confirm-password" placeholder="confirm password"><br><br>
              <input type="submit" name="change-password" value=" change password">
            </form>
          </div>

          <p>&nbsp</p>
        </div>


      </div>
    </div>
  </body>
</html>
