<?php

/*
  
  The css file will be appended to later when $_SESSION['userName']
  makes changes to the look and feel of his/her product 
  page 


  Thus, the rules saved in the $_SESSION['userName'].css file
  will not be read after this happens.

  Instead, the most recent changes to the page will be displayed 
  because of how css files are read by the browser

*/

   
  session_start();



  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  echo $cssFile = "../../../"

  	. $_SESSION['userName'] ."/"

  	. $_SESSION['userName'] .".css";

 if(isset($_POST['data'])) {

  // echo $_POST['data']; -> echo the data received, will be sent to the page that 

 	// performed the ajax request
  
  // this requires append as is 
  // or else data will be overwritten when they change one thing
  $file = file_put_contents($cssFile,$_POST['data'],FILE_APPEND);
  echo shell_exec("cat " . $cssFile);
 }

?>