<?php 

  function getPost($con,$post) {
  	return $con->real_escape_string($post);      
  }
  function a($array) {
  	echo "<pre>";
  	print_r($array);
  	echo "</pre>";
  }
  function dump($var) {
  	echo "<pre>";
  	var_dump($var);
  	echo "</pre>";
  }

?>