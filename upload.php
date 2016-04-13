<!DOCTYPE HTML>
<html>
 <head>
 </head>
 
 <body>
 
 <?php
  echo "I am "; 
  echo `whoami`;
 
  ini_set('display_errors', 1);error_reporting(E_ALL);
 
   session_start();
   
  debug($_SESSION);

 ?>


<!-- no need to check if the user is logged in because if they are not,
 they will be directed to the sign up page when they click the upload button --> 


<form action="upload.php" method="post" enctype="multipart/form-data">
<pre>                           Your Photo: <input type="file" name="image" size="25" />
                         Photographer: <input type="text" name="photographer" size="25" />
                          Description: <input type="text" name="descr" size="25" />
Tags Related to the Picture's Content: <input type="text" name="tags" size="25" />
  </pre>
	<input type="submit" name="submit" value="Submit" />
</form>

<?php

  debug($_FILES);
  
  // file properties
  $file_name = $_FILES['image']['name'];


  $file_tmp_name = $_FILES['image']['tmp_name'];
  $file_size = $_FILES['image']['size'];
  $file_error = $_FILES['image']['error'];
  
  // get the extension of the file
  $file_ext = explode('.', $file_name);
  $file_ext = strtolower(end($file_ext));

  // create random file name
  $file_name_new = uniqid('', true) . '.' . $file_ext;
  echo $user_folder = $_SESSION['userName'];
  echo $file_destination = "/home/evansdb0/html/" . "$user_folder/" . "$file_name_new";
   
  

  
  if(move_uploaded_file($file_tmp_name, $file_destination)) {
    echo "<br>$file_destination<br><br><br>";
    echo "File successfully uploaded!";
    // INCLUDE A REDIRECT HERE TO PREVENT FORM RESUBMISSION
  }
  else {
    echo "<br>file upload failed<br>";
  }


function debug($array) {
   echo "<pre>";
   print_r($array);
   echo "</pre>";
}

function info() {     echo phpinfo();    }
  // gets the absolute path of every users 
  // picture folder 
/*  function getAbsolutePath($user_dir = "") {
    $path_components = explode('/',__FILE__);
    print_r($path_components);
    $html = explode('/', $path_components);
    echo "<br>";
    $string = "/home/";
    for($i = 3; $i < count($path_components) -1; $i++) {
      if($i < count($path_components)-2) {
        $string .= $path_components[$i] . "/";

      }
      else {
        $string .= $path_components[$i]  . "/";
        $string .= "$user_dir";
      }  
    }
    return $string;
  } */
?>

</body>
</html>
