<?php 
  session_start();
?>
<html>
<head>
<style type="text/css">
div#pagination_controls{font-size:21px;}
div#pagination_controls > a{ color:#06F; }
div#pagination_controls > a:visited{ color:#06F; }
</style>
</head>
<body>

<?php
// Script and tutorial written by Adam Khoury @ developphp.com
// Line by line explanation : youtube.com/watch?v=T2QFNu_mivw
 
 // WAS JUST WORKING ON THE PAGINATION FOR THIS 
 // LAST THING I DID WAS COPY THE HTML ABOVE 
 // NEXT I NEED TO FIGURE OUT HOW THIS SCRIPT DISPLAYS STUFF 
 // HERE WE GO!!!!!!!!!!!!
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  require_once("../../dbLogin.php");

  $con = new mysqli($host
                   ,$u
                   ,$p
                   ,$db); 


// This first query is just to get the total count of rows
$query = "SELECT COUNT(itemId) FROM products";
$result = $con->query($query);
// Here we have the total row count
$row = $result->fetch_array();
$rows = $row[0];
// This is the number of results we want displayed per page
$page_rows = 1;

// This tells us the page number of our last page
echo $last = ceil($rows/$page_rows);

// This makes sure $last cannot be less than 1
if($last < 1){
	$last = 1;
}

// Establish the $pagenum variable
$pagenum = 1;
// Get pagenum from URL vars if it is present, else it is = 1+
if(isset($_GET['pn'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}

// This makes sure the page number isn't below 1, or more than our $last page
if ($pagenum < 1) { 
    $pagenum = 1; 
} else if ($pagenum > $last) { 
    $pagenum = $last; 
}

// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
// This is your query again, it is for grabbing just one page worth of rows by applying $limit
$query = "SELECT name,imgPath,price,itemId  FROM products ORDER BY artistId DESC $limit";

// $result = $con->query($query);

// This shows the user what page they are on, and the total number of pages
echo $textline1 = "Testimonials (<b>$rows</b>)";
echo $textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
// Establish the $paginationCtrls variable
$paginationCtrls = '';

// If there is more than 1 page worth of results
if($last != 1){
	/* First we check if we are on page one. If we are then we don't need a link to 
	   the previous page or the first page so we do nothing. If we aren't then we
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a>  ';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> ';
			}
	    }
    }

	// Render the target page number, but without it being a link
	$paginationCtrls .= ''.$pagenum.' ';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}
	// This does the same as above, only checking if we are on the last page, and then generating the "Next"

    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
    }
}

$list = '';

// $query = "SELECT name,imgPath,price,itemId  FROM products 
// ORDER BY artistId DESC $limit";
$result = $con->query($query);
$i=0;
while($i < 3){
	$rows = $result->fetch_array(MYSQLI_ASSOC);
	$itemId   = $rows['itemId'];
	$artistId = $rows["name"];
	$price = $rows["price"];
	$imgPath = $rows["imgPath"];
	echo $list .= '<p><a href="pagination.php?id='.$itemId.'">'.$price.' '.$imgPath.'</a> Here is the link<br>Written '.'</p>';
	$i++;
}
echo "<br><br>" .$paginationCtrls;
?>

</body>
</html>