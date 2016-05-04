

<html>
  <head>
  </head>
  <body>
  
   
<?php

session_start();


require_once('classes/swiftmailer/lib/swift_required.php');

require_once('classes/LoginA.php');


  // show potential errors / feedback (from login object)
  
$login = new LoginA();



if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo "<br><br><br><br><br><br><br><br>" . $error;
            $error = '';
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
} 

// user is an artist 
if($login->isUserLoggedIn() == true && $_SESSION['isArtist'] == 1) {
  header('Location: http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/products.php');
}
// user is a buyer / logged out 
elseif(!($_SESSION['isArtist'] == 1)) {
  
 header('Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php'); 
} 


?>
  <body>

</html>

