<form><input type="search"  class="Search" method="get" name="search" size="100"
        placeholder="Photos, people, places..." value="star wars">
</form><hr>

<?php

session_start();


  ini_set('display_errors', 1);
  error_reporting(E_ALL);

$begin = microtime(true);

// BENCHMARKING 
// ------------------------------------------------------------------------------------------------------------------------
require_once('functions.php');
require_once('../../dbLogin.php');
$con = new mysqli($host,$u,$p,$db);
require_once('searchFunctions.php');
if(isset($_GET['search'])) {
  
  $s = $_GET['search'];
  search(get_new_words($s),$con);
}



// BENCHMARKING
// --------------------------------------------------------------------------------------------------------------------------
$end = microtime(true);

if($_SESSION['count'] == 4 || !isset($_SESSION['count'])) {
  $_SESSION['count'] = 0;
}

$_SESSION['time'][$_SESSION["count"]] = ($end - $begin);

$_SESSION['count'] = $_SESSION['count'] +1;
echo "<br><br><br><br><br><br><hr>BENCHMARKING";
a($_SESSION['time']);

?>

