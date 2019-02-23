<?php
# This module handles all user methods and attributes

class User{
    # This class contains all user methods

    private $username;
    private $password;
    public $errors = array();

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
  
        # get username and password
        $sql = "SELECT username, password FROM user WHERE username = '$username'";
        $result = $conn->query($sql);
  
        if($result->num_rows == 1){
  
          # get admin account username
          while($row = $result->fetch_assoc()){
            $dbpassword = $row['password'];
          }
          # confirm password is correct
          if (password_verify($password, $dbpassword)){
            # assign username session
            setcookie('Theadmin', $username, time() + 43200, "/");
            # redirect site
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
}

$current_user = new User();

?>