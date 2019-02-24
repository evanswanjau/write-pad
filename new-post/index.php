<?php require_once '../engine/infused_cogs.php'; $current_user->admin_security(); $current_user->logout();
ob_start();

if (isset($_GET['article-post']) && $_GET['article-post'] != '') {

  $post = $current_post->get_posts($_GET['article-post']);

  $id = $post['post_id'];
  $title = str_replace("`", "'", $post['title']);
  $article = str_replace("`", "'", $post['blog']);
  $dbimage = $post['image'];

}else{
  $id = NULL; $dbimage = NULL;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>New Post</title>
    <link rel="icon" type="image/png" href="../favicon.png">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/css/froala_style.min.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.6.4/js/froala_editor.pkgd.min.js"></script>
   <link rel="stylesheet" type="text/css" href="../css/main.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style media="screen">
   .success, .error{
     margin-left:0px!important;
   }
   </style>
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
            <a href="../new-post"><li class="current"><i class="material-icons">queue</i>new post</li></a>
            <a href="../my-posts"><li><i class="material-icons">collections</i>my posts</li></a>
            <a href="../subscribers"><li><i class="material-icons">group</i>subscribers</li></a>
            <a href="../security"><li><i class="material-icons">security</i>security</li></a>
          </ul>
        </div>

        <div class="col-sm-10 right-side">
          <form class="ui-form" action="" method="post" enctype="multipart/form-data">
            <?php 
            
            if (isset($_POST['publish'])) {

              $current_post->new_post($_POST['title'], $_POST['post'], 'publish');

            }else if (isset($_POST['draft'])){

              $current_post->new_post($_POST['title'], $_POST['post'], 'draft');

            }else if (isset($_POST['edit-publish'])){

              $current_post->edit_post($id, $dbimage, $_POST['title'], $_POST['post'], 'edit-publish');

            }else if (isset($_POST['edit-draft'])){

              $current_post->edit_post($id, $dbimage, $_POST['title'], $_POST['post'], 'edit-draft');

            }
            
            ?>

            <input type="text" name="title" placeholder="Title" value="<?php if (isset($_SESSION['title'])) {echo $_SESSION['title'];} if (empty($title)) {echo null;}else {echo $title;}?>"><br><br>
            <textarea class="edit" name="post" placeholder="Write your story..."><?php if (isset($_SESSION['post'])) {echo $_SESSION['post'];} if (empty($article)) {echo null;}else {echo $article;}?></textarea><br>

            <!-- Initialize the editor. -->
            <script> $(function() { $('.edit').froalaEditor() }); </script>
            <p>Upload Image</p>

            <?php if (isset($_GET['article-post']) && $_GET['article-post'] != ''): ?>
              <div class="update-image">
                <img src="../image-backgrounds/<?php echo $dbimage; ?>" alt=""><br><br>
              </div>
            <?php endif; ?>
            <input type="file" name="image"><br><br>

            <?php if (isset($_GET['article-post']) && $_GET['article-post'] != ''): ?>
              <input type="submit" name="edit-publish" value="edit publish">&nbsp
              <input type="submit" name="edit-draft" value="edit save as draft">
            <?php else: ?>
              <input type="submit" name="publish" value="publish">&nbsp
              <input type="submit" name="draft" value="save as draft">
            <?php endif; ?>
          </form>
          <p>&nbsp</p>
        </div>
      </div>
    </div>
  </body>
</html>
<?php ob_end_flush(); ?>
