<?php require_once '../engine/infused_cogs.php';  adminSecurity(); logOut();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>My Posts</title>
    <link rel="icon" type="image/png" href="../favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <link rel="stylesheet" type="text/css" href="../css/main.css">
   <script type="text/javascript" src="../js/script.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <!-- Top Menu -->
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

    <div class="container-fluid">
      <div class="row">
        <!-- menu side -->
        <div class="col-sm-2 side-menu">
          <a href="../security">
            <div class="profile">
              <?php echo getProfilePic('../'); ?>
              <p>@<?php echo strtolower($_COOKIE['Theadmin']); ?></p>
            </div>
          </a>
          <!-- our menu -->
          <ul>
            <a href="../"><li><i class="material-icons">dashboard</i>dashboard</li></a>
            <a href="../new-post"><li><i class="material-icons">queue</i>new post</li></a>
            <a href="../my-posts"><li class="current"><i class="material-icons">collections</i>my posts</li></a>
            <a href="../subscribers"><li><i class="material-icons">group</i>subscribers</li></a>
            <a href="../security"><li><i class="material-icons">security</i>security</li></a>
          </ul>
        </div>

        <div class="col-sm-10 right-side">

          <?php if (isset($_GET['article-post']) && $_GET['article-post'] != ''): ?>
            <?php echo 'er' ?>
          <?php else: ?>
            <a href="../new-post"class='material-icons right show-form add-new' title='new post' style='cursor:pointer;font-size:20px;'>add_circle</a>
            <div class="col-sm-12">
              <?php myPosts(); ?>
            </div>
          <?php endif; ?>
          <p>&nbsp</p>
        </div>
      </div>
    </div>
  </body>
</html>
