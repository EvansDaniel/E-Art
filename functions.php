
<?php



function a($array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
function getURL() {
	return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
function dump($var) {


	echo "</pre>";
	var_dump($var);
	echo "</pre>";
}
function myQ($q,$con) {
    
  $r = $con->query($q);
  if(!$r) die($con->error);
    
  return $r;
}
function getHomeURL() {
	return "http://hive.sewanee.edu/evansdb0/eArt/pHome.php";
}
function getArtistName($artistId,$con) {
	$q = "select fName from people where artistId = $artistId";
	$r = myQ($q,$con);
	$artist_arr = getAssocArr(1,$r);
	return $artist_arr['fName'];
}
function getCategoryName($categoryId,$con) {
	$q = "select category from category where categoryId = $categoryId";
	$r = myQ($q,$con);
	$category_arr = getAssocArr(1,$r);
	return $category_arr['category'];
}
function getAssocArr($index=1,$result) {
  $result->data_seek($index);
  return $result->fetch_array(MYSQLI_ASSOC);
}
function loggedIn() {
  
  return $_SESSION['user_logged_in'] == 1;
}
function getUsername() {
	return $_SESSION['userName'];
}
function isArtist() {
	return $_SESSION['isArtist'] == 1;
}
function getName() {
	return $_SESSION['fName'];
}
function getEmail() {
	return $_SESSION['user_email'];
}
function getLastSearch() {
	if(isset($_SESSION['lastSearch'])) {
		return $_SESSION['lastSearch'];
	}
	else {
		return "user hasn't searched anything yet";
	}
}
function getPeopleId() {
	return $_SESSION['people_id'];
}