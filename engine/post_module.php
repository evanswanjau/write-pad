<?php
# This module handles all post functionality

class Post{
    # function that takes care of all post methods and attributes

    public $errors = array();

    # get posts
    public function get_posts($id=NULL){

        global $conn;

        if ($id){
            # get one post if it exists
            $sql = "SELECT * FROM posts WHERE post_id = $id";
            $result = $conn->query($sql);
        
            return $result->fetch_assoc();
        }else{
            # get all posts
            $posts = [];
            $sql = "SELECT * FROM posts ORDER BY post_id DESC";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    $posts[] = $row;
                }
            }else {
                return NULL;
            }
        
            return $posts;
        }

    }

    # create post
    public function new_post($title, $post, $action){

        global $conn;

        # title
        if($title != ''){
            
            $title = clean_data($title);
      
            $sql = "SELECT * FROM posts WHERE title = '$title'";
            $result = $conn->query($sql);
      
            # get fields into variables
            if($result->num_rows == 1){
              $errors[] = "<p class='error'>that title already exists</p>";
            }else {
              $_SESSION['title'] = $title;
            }
      
        }else {
            $errors[] = "<p class='error'>title can't be empty</p>";
        }
      
        # post
        if($post != ''){
            $post = str_replace("'", "`", $post);
            $_SESSION['post'] = $post;
        }else {
            $errors[] = "<p class='error'>post can't be empty</p>";
        }
      

        # image validation and upload
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
      
        # if no errors exist
        if ($errors == []) {
              
            
            # unset info sesions
            unset($_SESSION['title']);
            unset($_SESSION['post']);
      
            $image_name = stringShuffle($divide = 3, $string='abcdefghijklmnopqrst').'.'.$image_ext;
      
            if ($action == 'publish') {
                #Inserting the user's data into our database
                $sql = "INSERT INTO posts (title, blog, image, status)
                VALUES ('$title', '$post', '$image_name', 1)";
      
                if ($conn->query($sql) === TRUE) {
                    move_uploaded_file($image_tmp,'../image-backgrounds/'.$image_name.''); # move image to image folder
                    echo "<p class='success' id='point'>article published successfully</p>"; # return successful message
                    header('refresh:1; url=../my-posts');
                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }else {
                #Inserting the user's data into our database
                $sql = "INSERT INTO posts (title, blog, image)
                VALUES ('$title', '$post', '$image_name')";
      
                if ($conn->query($sql) === TRUE) {
                    move_uploaded_file($image_tmp,'../image-backgrounds/'.$image_name.''); # move image to image folder
                    echo "<p class='success' id='point'>article drafted successfully</p>"; # return successful message
                    header('refresh:1; url=../my-posts');
                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }else {
            # print out the errors
            foreach ($errors as $error) {
              echo $error;
            }
        }
      
    }


    # edit post
    public function edit_post($id, $dbimage, $title, $post, $action){

        global $conn;
        
        $change_image = null;
      
        # title
        if($title != ''){
            $title = clean_data($title);
        }else {
            $errors[] = "<p class='error'>title can't be empty</p>";
        }
      
        # post
        if($post != ''){
            $post = str_replace("'", "`", $post);
        }else {
            $errors[] = "<p class='error'>post can't be empty</p>";
        }
      
        # image upload
        if(isset($_FILES['image'])){
            #Verify Image upload data
            $image_name = $_FILES['image']['name'];
            $image_size =$_FILES['image']['size'];
            $image_tmp =$_FILES['image']['tmp_name'];
            $image_type=$_FILES['image']['type'];
            $image_ext=strtolower(end((explode('.',$_FILES['image']['name']))));
      
            $extensions= array("jpeg","jpg","png");
      
            if ($image_name != '') {
      
                $image_name = stringShuffle($divide = 3, $string='abcdefghijklmnopqrst').'.'.$image_ext;
                $change_image = true;
                if(in_array($image_ext,$extensions)=== false){
                    $errors[] = "<p class='error'>please choose a JPEG or PNG file</p>";
                }else {
                    if($image_size > 4194304){
                        $errors[]='<p class="error">image is too large</p>';
                    }
                }
            }else {
                $image_name = $dbimage;
            }
        }
      

        # if no errors exist
        if ($errors == []) {
      
            if ($action == 'edit-publish') {
                # update the user's data into our database
                $sql = "UPDATE posts SET `title` = '$title', `blog` = '$post', `image` = '$image_name', `status` = 1 WHERE post_id = $id";
      
                if ($conn->query($sql) === TRUE) {
                    if ($change_image == true) {
                        if (unlink('../image-backgrounds/'.$dbimage) === true){
                            move_uploaded_file($image_tmp,'../image-backgrounds/'.$image_name.''); # move image to image folder
                            header('location: ../my-posts');
                        }else {
                            echo "<p>Try uploading the image again</p>";
                        }
                    }else {
                        header('location: ../my-posts');
                    }
      
                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }else {
                # update the user's data into our database
                $sql = "UPDATE posts SET `title` = '$title', `blog` = '$post', `image` = '$image_name', `status` = 0 WHERE post_id = $id";
      
                if ($conn->query($sql) === TRUE) {
                    if ($change_image == true) {
                        if (unlink('../image-backgrounds/'.$dbimage) === true){
                            move_uploaded_file($image_tmp,'../image-backgrounds/'.$image_name.''); # move image to image folder
                            header('location: ../my-posts');
                        }else {
                            echo "<p>Try uploading the image again</p>";
                        }
                    }else {
                        header('location: ../my-posts');
                    }
                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
          }else {
            # print out the errors
            foreach ($errors as $error) {
              echo $error;
            }
        }
    }

    # delete post
    public function delete_post($id){

    }
}


$current_post = new Post();

?>