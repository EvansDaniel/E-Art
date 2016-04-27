
<?php

  session_start();



  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  require_once("../../dbLogin.php");
  require_once('createThumbnail.php');
  

  
  header('Content-Type: application/json');

  $uploaded = array(); 

  $uploadDir = "../../../evansdb0/";
  $uploadDir = "../../../" . $_SESSION['userName']."/";

// works 
  $tempDir = "planes.jpg";

  createThumbnail($tempDir);



  if(!empty($_FILES['file']['name'][0])) {

    
    foreach($_FILES['file']['name'] as $position => $name) {

      $imageFileType = pathinfo($uploadDir . $name,PATHINFO_EXTENSION);

       // $_SESSION['current_img'] . "." . $imageFileType;

      echo $uploadedFile = $uploadDir . $_SESSION['product_name'] . ".". $imageFileType;

      if(move_uploaded_file($_FILES['file']['tmp_name'][$position], $uploadedFile)) {
         $uploaded[] = array(
            'name' => $_SESSION['product_name'], 
            'file' => $uploadedFile
          );
         
         // big security problem, but I'm not root
         // so can't change group privileges 
         // and don't know if www-data is a group member 
         shell_exec("chmod 0666 " . $uploadedFile);

         echo createThumbnail($uploadedFile);
         $con = new mysqli($host,$u,$p,$db);
         
         $img = "http://hive.sewanee.edu/evansdb0/" . $_SESSION['userName'] . "/" . $_SESSION['product_name'] . ".". $imageFileType;
         $imgPath = $uploadDir . $_SESSION['product_name'] . ".". $imageFileType;
         $itemId = $_SESSION['product_id'];

        $update = "update products set imgPath='$img' where itemId='$itemId'";

        $con->query($update);

        $q = "select imgPath from products where itemId='$itemId'";
        $r = $con->query($q);
        $r_object = $r->fetch_object();

        //echo $r_object->imgPath;

        echo $r_object->imgPath;

      }
      else {
        echo "Failed to upload file";
      }
    }
  }

  //echo json_encode($uploaded);

 /* require_once("functions.php");N

  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  
  //a($_SESSION);
  echo "dsafdsad";
  
 if(!empty($_FILES['file']['name'][0])) {

    //header('Content-Type: application/json');

    echo $path = $_FILES['file']['name'][0];
    var_dump($ext = pathinfo($path, PATHINFO_EXTENSION));
  
    $uploaded = array();

        // this works right here
        /* rename($_SESSION['path_to_artist_dir'] . "/" . $name

          ,$_SESSION['path_to_artist_dir'] . "/" . $_name); 
        *
    
    
  // loops through the files that have been sent by AJAX request
  foreach($_FILES['file']['name'] as $position => $name) {
         
    if(move_uploaded_file($_FILES['file']['tmp_name'][$position],$_SESSION['current_img'].".".$ext)) {
      $uploaded[] = array(
                          'name' => $name,
                          'file' => 'uploads/' . $name
      );
    }
  }
      
 } */

?>