<?php require_once 'engine/infused_cogs.php'; adminSecurity(''); logOut('');?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://unpkg.com/tippy.js@2.5.2/dist/tippy.all.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
  </head>

  <?php print_r($current_user->get_user_data()); ?>

  <!-- Top Menu -->
  <section>
    <div class="top-menu">
      <ul>
        <a href=""><li style="width:50%;font-size:16px;"><i class="material-icons left"> account_balance</i>&nbsp;&nbsp;writepad</li></a>
        <span>
          <a href=""><li><i class="material-icons top" title="notifications">notifications_none</i></li></a>
          <a href="security"><li><i class="material-icons top" title="security">security</i></li></a>
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
          <a href="security">
            <div class="profile">
              <?php echo getProfilePic(); ?>
              <p>@<?php echo strtolower($_COOKIE['Theadmin']); ?></p>
            </div>
          </a>
          <!-- our menu -->
          <ul>
            <a href=""><li class="current"><i class="material-icons">dashboard</i>dashboard</li></a>
            <a href="new-post"><li><i class="material-icons">queue</i>new post</li></a>
            <a href="my-posts"><li><i class="material-icons">collections</i>my posts</li></a>
            <a href="subscribers"><li><i class="material-icons">group</i>subscribers</li></a>
            <a href="security"><li><i class="material-icons">security</i>security</li></a>
          </ul>
        </div>

        <div class="col-sm-10 right-side">
          <div class="row">
            <div class="col-sm-8">
              <div class="row">
                <div class="col-sm-12 top">
                  <!--<button class="btn" title="I'm a tooltip!">Text</button>
                  <script>tippy('.btn')</script>-->
                  <h3>Today's Counts</h3>
                  <div class="col-sm-2 count">
                    <i class="material-icons">comments</i>
                    <p><span><?php echo getCommentsCount(); ?></span><br>COMMENT<?php echo addS(getCommentsCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count" >
                    <i class="material-icons">favorite</i>
                    <p><span><?php echo getLikesCount(); ?></span><br>LIKE<?php echo addS(getLikesCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count">
                    <i class="material-icons">remove_red_eye</i>
                    <p><span><?php echo getReadsCount(); ?></span><br>READ<?php echo addS(getReadsCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count">
                    <i class="material-icons">email</i>
                    <p><span><?php echo getFeedbackCount(); ?></span><br>MESSAGE<?php echo addS(getFeedbackCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count">
                    <i class="material-icons">group</i>
                    <p><span><?php echo getSubscriberCount(); ?></span><br>SUBSCRIBER<?php echo addS(getSubscriberCount()); ?></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 bottom">
                  <h3>Overall Counts</h3>
                  <div class="col-sm-2 count">
                    <i class="material-icons">comments</i>
                    <p><span><?php echo getTotalCommentsCount(); ?></span><br>COMMENT<?php echo addS(getTotalCommentsCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count" >
                    <i class="material-icons">favorite</i>
                    <p><span><?php echo getTotalLikesCount(); ?></span><br>LIKE<?php echo addS(getTotalLikesCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count">
                    <i class="material-icons">remove_red_eye</i>
                    <p><span><?php echo getTotalReadsCount(); ?></span><br>READ<?php echo addS(getTotalReadsCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count">
                    <i class="material-icons">email</i>
                    <p><span><?php echo getTotalFeedbackCount(); ?></span><br>MESSAGE<?php echo addS(getTotalFeedbackCount()); ?></p>
                  </div>
                  <div class="col-sm-2 count">
                    <i class="material-icons">group</i>
                    <p><span><?php echo getTotalSubscriberCount(); ?></span><br>SUBSCRIBER<?php echo addS(getTotalSubscriberCount()); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <h3>Popular Post</h3>
              <?php popularPost(); ?>
            </div>
          </div>
          <br><br><br>

          <div class="row">
            <div class="col-sm-6">
              <h3>Comments</h3>
              <div class="message-holder">
                <?php getCommentMessages(); ?>
              </div>
            </div>
            <div class="col-sm-6">
              <h3>Feedback</h3>
              <div class="message-holder">
                <?php getFeedbackMessages(); ?>
              </div>
            </div>
          </div>

          <p>&nbsp</p>
        </div>


      </div>
    </div>
  </body>
</html>
