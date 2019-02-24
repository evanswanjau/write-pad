<?php require_once '../engine/infused_cogs.php'; $current_user->admin_security(); $current_user->logout();?>
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
            <img src="../image-backgrounds/<?php echo $current_user->get_user_data()['image'] ?>" alt="Profile Image">
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
              <?php $posts = $current_post->get_posts();?>

              <?php if ($posts): ?>

              <?php foreach ($posts as $key => $value): ?>

                <?php $style = ($posts[$key]['status'] == 0) ? "style='-webkit-filter:grayscale(100%);'" : NULL; ?>
                <?php $echo = ($posts[$key]['status'] == 0) ? "<span>draft</span>" : NULL; ?>
                <?php $article = substr(strip_tags(str_replace("`", "'", $posts[$key]['blog'])), 0, strrpos(substr(strip_tags(str_replace("`", "'", $posts[$key]['blog'])), 0, 150), ' ')) . '...'; ?>

                <a href='?article=<?php echo str_replace(" ", "-", str_replace("'", "", str_replace("`", "'", $posts[$key]['title']) ));?>&article-post=<?php echo $posts[$key]['post_id']; ?>' style='color:#333;'>
                  <div class='article-post col-sm-3' <?php echo $style ?>>
                    <div style='background: url(../image-backgrounds/<?php echo $posts[$key]['image'] ?>) no-repeat center center;background-size: cover;' class='post-image'>
                      <?php echo $echo; ?>
                    </div>
                    <h4 class='cap'><?php echo str_replace("`", "'", $posts[$key]['title']); ?></h4>
                    <p><?php echo $article ?></p>
                    <ul class='list right'>
                      <li title='reads'><i class='material-icons'>remove_red_eye</i>&nbsp <?php echo $posts[$key]['reads'] ?></li>
                      <li title='likes'><i class='material-icons'>favorite</i>&nbsp <?php echo $posts[$key]['likes'] ?></li>
                      <li title='edit'><a href='../new-post/?<?php echo str_replace(" ", "-", str_replace("'", "", str_replace("`", "'", $posts[$key]['title']) ))?>&article-post=<?php echo $posts[$key]['post_id']; ?>'><i class='material-icons'>edit</i>&nbsp</a></li>
                      <li title='delete'><i class='material-icons'>delete</i>&nbsp</li>
                    </ul>
                    <br><br>
                    <span class='right'><b>posted <?php echo timeSpan($posts[$key]['image']) ?></b></span>
                  </div>
                </a>

              <?php endforeach; ?>

              <?php else: ?>
                <div class="add-items">
                  <h1>Write your first artcle</h1>
                  <a href="../new-post"><button>new post</button></a>
                </div>
              <?php endif; ?>             
            </div>
          <?php endif; ?>
          <p>&nbsp</p>
        </div>
      </div>
    </div>
  </body>
</html>
