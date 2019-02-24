<?php

require_once 'infused_cogs.php'; # request total control file

# mathod that cleans all data inputs
function clean_data($data) {
  $data = str_replace("'", "`", $data);
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

# funtion to shuffle string
function stringShuffle($divide = 4, $string='abcdefghijklmnopqrst0123456789'){

  $string = str_shuffle($string);

  $code = substr($string, 0, strlen($string)/$divide);

  return $code;
}

// FUNCTION TO ADD (S) IN THE END
function addS($time){
  if ($time != 1) {
    $s = 'S';
  }else {
    $s = '';
  }

  return $s;
}

# difference in time
function timeSpan($date){

  date_default_timezone_set('Africa/Nairobi');
  $current_date = date('Y-m-d H:i:s');

  $seconds  = strtotime(date($current_date)) - strtotime($date);

    $months = floor($seconds / (3600*24*30));
    $day = floor($seconds / (3600*24));
    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - ($hours*3600)) / 60);
    $secs = floor($seconds % 60);

    if($seconds < 60)
        $time = $secs." second".addS($secs)." ago";
    else if($seconds < 60*60 )
        $time = $mins." min".addS($mins)." ago";
    else if($seconds < 24*60*60)
        $time = $hours." hour".addS($hours)." ago";
    else if($seconds < 30*24*60*60)
        $time = $day." day".addS($day)." ago";
    else
        $time = $months." month".addS($months)." ago";

    return $time;
}



/*
-----------------------------------------------------
POST FUNCTIONS
-----------------------------------------------------
*/
# ADDING A NEW POST



# EDITING A POST



# SHOW ALL POSTS
function myPosts(){

  global $conn;

  $sql = "SELECT * FROM posts ORDER BY post_id DESC";
  $result = $conn->query($sql);

  # get fields into variables
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $post_id = $row['post_id'];
      $title = str_replace("`", "'", $row['title']);
      $article = $row['blog'];
      $article = str_replace("`", "'", $article);
      $article = strip_tags($article);
      $articleCut = substr($article, 0, 150);
      $article = substr($article, 0, strrpos($articleCut, ' ')) . '...';
      $image = $row['image'];
      $likes = $row['likes'];
      $reads = $row['reads'];
      $date_posted = $row['date_posted'];
      $status = $row['status'];

      if ($status == 0) {
        $style = "style='-webkit-filter:grayscale(100%);'";
        $echo = "<span>draft</span>";
      }else {
        $style = null;
        $echo = null;
      }

      echo "
      <a href='?".str_replace(" ", "-", str_replace("'", "", $title))."&article-post=$post_id' style='color:#333;'>
      <div class='article-post col-sm-3' $style>
        <div style='background: url(../image-backgrounds/".$image.") no-repeat center center;background-size: cover;' class='post-image'>
        $echo
        </div>
        <h4 class='cap'>$title</h4>
        <p>$article</p>
        <ul class='list right'>
          <li title='reads'><i class='material-icons'>remove_red_eye</i>&nbsp $reads</li>
          <li title='likes'><i class='material-icons'>favorite</i>&nbsp $likes</li>
          <li title='edit'><a href='../new-post/?".str_replace(" ", "-", str_replace("'", "", $title))."&article-post=$post_id'><i class='material-icons'>edit</i>&nbsp</a></li>
          <li title='delete'><i class='material-icons'>delete</i>&nbsp</li>
        </ul>
        <br><br>
        <span class='right'><b>posted ".timeSpan($date_posted)."</b></span>
      </div>
      </a>";
    }
  }else {
    echo '
    <div class="add-items">
      <h1>Write your first artcle</h1>
      <a href="../new-post"><button>new post</button></a>
    </div>';
  }

}


/*
---------------------------------------------------
SUBSCRIBER FUNCTIONS
---------------------------------------------------
*/
function getSubscribers(){

  global $conn;
  $count = 0;

  $sql = "SELECT * FROM subscribers ORDER BY name ASC";
  $result = $conn->query($sql);

  # get fields into variables
  if($result->num_rows > 0){
    echo '
    <div class="parent formal">
      <ul><b>
        <span> # </span>
        <li>name</li>
        <li>email</li>
        <li>email notifications</li>
      </ul></b>
    </div>';
    while($row = $result->fetch_assoc()) {
      $count += 1;
      $name = $row['name'];
      $email = $row['email'];
      $status = $row['status'];

      if ($status == 1) {
        $value = "<li class='material-icons status' style='color:#34ca66;'>check_box</li>";
      }else {
        $value = "<li class='material-icons status' style='color:red;'>cancel</li>";
      }

      echo "
      <div class='col-sm-12 parent'>
        <ul>
          <span>$count</span>
          <li class='cap'>$name</li>
          <li>$email</li>
          $value
        </ul>
      </div>";
    }
  }else {
    echo '
    <div class="add-items">
      <h1>Your subscriber list is empty</h1>
    </div>';
  }
}


/*
-----------------------------------------------
DASHBOARD FUNCTIONS
-----------------------------------------------
*/

# POPULAR POST
function popularPost(){

  global $conn;

  $sql = "SELECT * FROM posts WHERE status = 1 ORDER BY `reads` ASC";
  $result = $conn->query($sql);

  # get fields into variables
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $post_id = $row['post_id'];
      $title = str_replace("`", "'", $row['title']);
      $article = $row['blog'];
      $article = str_replace("`", "'", $article);
      $article = strip_tags($article);
      $articleCut = substr($article, 0, 150);
      $article = substr($article, 0, strrpos($articleCut, ' ')) . '...';
      $image = $row['image'];
      $likes = $row['likes'];
      $reads = $row['reads'];
      $date_posted = $row['date_posted'];
    }

    echo "
    <a href='../my-posts/?$title&article-post=$post_id' style='color:#333;'>
    <div class='article-post col-sm-12' style='width:100%!important;'>
      <div style='background: url(image-backgrounds/".$image.") no-repeat center center;background-size: cover;' class='post-image'>
      </div>
      <h4 class='cap'>$title</h4>
      <p>$article</p>
      <ul class='list right'>
        <li title='reads'><i class='material-icons'>remove_red_eye</i>&nbsp $reads</li>
        <li title='likes'><i class='material-icons'>favorite</i>&nbsp $likes</li>
        <li title='edit'><a href='new-post/?".str_replace(" ", "-", str_replace("'", "", $title))."&article-post=$post_id'><i class='material-icons'>edit</i>&nbsp</a></li>
        <li title='delete'><i class='material-icons'>delete</i>&nbsp</li>
      </ul>
      <br><br>
      <span class='right'><b>posted ".timeSpan($date_posted)."</b></span>
    </div>
    </a>";
  }else {
    echo "No articles posted";
  }
}


# DAILY FUNCTIONS COUNTS
function getCommentsCount(){

  global $conn;
  $current_day = date('j');

  $sql = "SELECT * FROM comments WHERE DAY(date_posted) = '$current_day'";
  $result = $conn->query($sql);

  # get fields into variables
  return $result->num_rows;
}

function getLikesCount(){

  $total = 0;

  global $conn;
  $current_day = date('j');

  $sql = "SELECT likes FROM posts WHERE DAY(date_posted) = '$current_day'";
  $result = $conn->query($sql);

  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $total += $row['likes'];
    }
  }

  # get fields into variables
  return $total;

  # get fields into variables
  return $result->num_rows;
}

function getReadsCount(){

  $total = 0;

  global $conn;
  $current_day = date('j');

  $sql = "SELECT `reads` FROM `posts` WHERE DAY(date_posted) = '$current_day'";
  $result = $conn->query($sql);

  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $total += $row['reads'];
    }
  }

  # get fields into variables
  return $total;
}

function getFeedbackCount(){

  global $conn;
  $current_day = date('j');

  $sql = "SELECT * FROM feedback WHERE DAY(date_posted) = '$current_day'";
  $result = $conn->query($sql);

  # get fields into variables
  return $result->num_rows;
}

function getSubscriberCount(){

  global $conn;
  $current_day = date('j');

  $sql = "SELECT * FROM subscribers WHERE DAY(date_subscribed) = '$current_day'";
  $result = $conn->query($sql);

  # get fields into variables
  return $result->num_rows;
}

function getTotalCommentsCount(){

  global $conn;
  $current_day = date('j');

  $sql = "SELECT * FROM comments";
  $result = $conn->query($sql);

  # get fields into variables
  return $result->num_rows;
}

function getTotalLikesCount(){

  $total = 0;

  global $conn;
  $current_day = date('j');

  $sql = "SELECT likes FROM posts";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $total += $row['likes'];
    }
  }

  # get fields into variables
  return $total;
}

function getTotalReadsCount(){

  $total = 0;

  global $conn;
  $current_day = date('j');

  $sql = "SELECT `reads` FROM `posts`";
  $result = $conn->query($sql);

  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $total += $row['reads'];
    }
  }

  # get fields into variables
  return $total;
}

function getTotalFeedbackCount(){

  global $conn;
  $current_day = date('j');

  $sql = "SELECT * FROM feedback";
  $result = $conn->query($sql);

  # get fields into variables
  return $result->num_rows;
}

function getTotalSubscriberCount(){

  global $conn;
  $current_day = date('j');

  $sql = "SELECT * FROM subscribers";
  $result = $conn->query($sql);

  # get fields into variables
  return $result->num_rows;
}


# get messages
function getFeedbackMessages(){
  global $conn;

  $sql = "SELECT * FROM feedback ORDER BY feedback_id DESC";
  $result = $conn->query($sql);

  # get fields into variables
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $name = str_replace(" ", "",$row['name']);
      $email = $row['email'];
      $message = str_replace("`","'",$row['message']);
      $date_posted = $row['date_posted'];

      echo "
      <div class='message' style='background-color:#efefef;'>
      <div class='tip' style='border-right: 10px solid #efefef;'></div>
        <p>Message from <b>@$name</b></p>
        <p>$message</p>
        <span>".timeSpan($date_posted)."</span>
        <br>
      </div>";
    }
  }else {
    echo "no new feedback";
  }
}

# get omments
function getCommentMessages(){
  global $conn;

  $sql = "SELECT * FROM comments ORDER BY comment_id DESC";
  $result = $conn->query($sql);

  # get fields into variables
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $name = str_replace(" ", "",$row['name']);
      $email = $row['email'];
      $message = str_replace("`","'",$row['comment']);
      $title = getTitle($row['post_id']);
      $date_posted = $row['date_posted'];

      echo "
      <div class='message' style='background-color:#c2ffe1;'>
      <div class='tip' style='border-right: 10px solid #c2ffe1;'></div>
        <p>Comment from <b>@$name</b></p>
        <p>ARTICLE: <b>$title</b></p>
        <p>$message</p>
        <span>".timeSpan($date_posted)."</span>
        <br>
      </div>";
    }
  }else {
    echo "no new comments";
  }
}

# get Title
function getTitle($id){

  global $conn;

  $sql = "SELECT title FROM posts WHERE post_id = $id";
  $result = $conn->query($sql);

  # get fields into variables
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      return $row['title'];
    }
  }else {
    return 'uncategorized';
  }
}
 ?>
