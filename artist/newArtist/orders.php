<?php 


session_start();


// if the person isn't logged in, take them back to home page 
if($_SESSION['user_logged_in'] != 1) {
  // header('Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php');
}  


?>