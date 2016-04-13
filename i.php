

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


if($login->isUserLoggedIn() == true) {
  header('Location: http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/newArtist.php');
}
else {
  // need to include this if i plan to debug it
  header('Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php');
}

?>
  <body>

</html>

