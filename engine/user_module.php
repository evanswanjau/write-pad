<?php
# This module handles all user methods and attributes

class User{

  public $errors = array();

  # get user data
  public function get_user_data(){

    global $conn;

    $sql = "SELECT * FROM user WHERE user_id = 1";
    $result = $conn->query($sql);
    
    return $result->fetch_assoc();

  }
  
  # sign up user
  public function signin_user($username, $password){
    
    global $conn;

    # username
    if ($username == '') {
      $errors[] = "<p class='error'>please enter your username</p>";
    }else {
      $username = clean_data($username);
    }
  
    # password
    if ($password == '') {
      $errors[] = "<p class='error'>please enter your password</p>";
    }else {
      $password = clean_data($password);
    }
  
    if (empty($errors)) {
  
      $user = $this->get_user_data();
  
      if($user){
        # confirm password is correct
        if (password_verify($password, $user['password'])){
          setcookie('Theadmin', $username, time() + 43200, "/");
          header('Location: ../');
        }else {
          echo "<p class='error'>incorrect login details</p>";
        }
      }else {
        echo "<p class='error'>that user does not exist</p>";
      }
    }else {
      foreach ($errors as $error) {
        echo $error;
      }
    }
  }

  # change profile picture
  public function change_profile_pic(){
    
    global $conn;

    $user = $this->get_user_data();

    $dbimage = $user['image'];

    if(isset($_FILES['image'])){

      #Verify Image upload data
      $image_name = $_FILES['image']['name'];
      $image_size =$_FILES['image']['size'];
      $image_tmp =$_FILES['image']['tmp_name'];
      $image_type=$_FILES['image']['type'];
      $image_ext=strtolower(end((explode('.',$_FILES['image']['name']))));

      $extensions= array("jpeg","jpg","png");

      if ($image_name == '') {
        $errors[] = "<p class='error'>you have not uploaded an image</p>";
      }else {

        if(in_array($image_ext,$extensions)=== false){
           $errors[] = "<p class='error'>please choose a JPEG or PNG file</p>";
        }else {
          if($image_size > 4194304){
             $errors[]='<p class="error">image is too large</p>';
          }
        }
      }

    }


    if ($errors == []) {

      $image_name = 'profile-image'.'.'.$image_ext;

      if (unlink('../image-backgrounds/'.$dbimage) === true) {
        move_uploaded_file($image_tmp,'../image-backgrounds/'.$image_name.''); # move image to image folder
        echo "<p class='success' id='point'>picture updated successfully</p>"; # return successful message
        header('refresh:1; url=../security');
      }else {
        echo "<p>Try uploading the image again</p>";
      }
    }else {
      foreach ($errors as $error) {
        echo $error;
      }
    }
  }

  # change username
  public function change_username($username){

    global $conn;

    $user = $this->get_user_data();

    $dbusername = $user['username'];

    # username
    if ($username == '') {
      $errors[] = "<p class='error'>Your username can't be empty</p>";
    }else {
      $username = clean_data($username);

      # make sure username is not similar to old password
      if ($username == $dbusername) {
        $errors[] = "<p class='error'>".$username." is already your current username</p>";
      }else {
        #update username
        $sql = "UPDATE user SET username = '$username' WHERE user_id = 1";

        if ($conn->query($sql) === TRUE){
          echo "<p class='success'>username changed successfully</p>";
          setcookie('Theadmin', $username, time() + 43200, "/");
          header('refresh:1; url=../security');
        }else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    }

    foreach ($errors as $error) {
      echo $error;
    }
  }

  # change password
  public function change_password($oldpassword, $newpassword, $confirmpassword){

    global $conn;

    $user = $this->get_user_data();

    $dbpassword = $user['password'];

    # password
    if ($oldpassword == '') {
      $errors[] = "<p class='error'>please input your old password</p>";
    }else {
      $oldpassword = $oldpassword;

      if (password_verify($oldpassword, $dbpassword)) {
        if ($newpassword == '') {
          $errors[] = "<p class='error'>please input your new password</p>";
        }else {
          $newpassword = clean_data($newpassword);
          if (strlen($newpassword) < 6) {
            $errors[] = "<p class='error'>password can't be less than 6 characters</p>";
          }else {
            # confirm password
            if ($_POST['confirm-password'] == '') {
              $errors[] = "<p class='error'>please confirm your password</p>";
            }else {
              $confirmpassword = clean_data($confirmpassword);

              # confirm passwords are similar
              if ($newpassword == $confirmpassword) {
                $password = password_hash($newpassword, PASSWORD_BCRYPT);

                $sql = "UPDATE user SET password = '$password' WHERE user_id = 1";

                if ($conn->query($sql) === TRUE){
                  setcookie('Theadmin', "", time() - 43200, "/");
                  echo "<p class='success'>password changed successfully</p>";
                  header('refresh:1; url=../security');
                }else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
              }
            }
          }
        }
      }else {
        $errors[] = "<p class='error'>password is not similar to old password</p>";
      }
    }

    foreach ($errors as $error) {
      echo $error;
    }
  }

  # security
  public function admin_security($link='../'){
    if (!isset($_COOKIE['Theadmin'])) {
      header('location: '.$link.'login');
    }
  }

  # logout function
  function logout($link='../'){
    if (isset($_GET['logout'])) {
      setcookie('Theadmin', "", time() - 43200, "/");
      header('location: '.$link.'login');
    }
  }


}




$current_user = new User();

?>