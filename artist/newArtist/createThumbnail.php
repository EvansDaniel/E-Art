<?php


  ini_set('display_errors', 1);
  error_reporting(E_ALL);

function createThumbnail($filename) {
     
    if(preg_match('/[.](jpg)$/', $filename)) {
        $im = imagecreatefromjpeg($filename);
    } else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif($path_to_image_directory . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($path_to_image_directory . $filename);
    }
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = $final_width_of_image = 6000;
    $ny = floor($oy * ($final_width_of_image / $ox));
     
    $nm = imagecreatetruecolor($nx, $ny);
     
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
     
    /*if(!file_exists($path_to_thumbs_directory)) {
      if(!mkdir($path_to_thumbs_directory)) {
           die("There was a problem. Please try again!");
      } 
       } */
    // need to make sure privileges are good on the image saved 
       // or else imagejpeg fails 
    imagejpeg($nm, $filename,100);
    $tn = $filename;
    
    return $tn;
}
function getProduct($artistId) {

  $con = new mysqli("crisler.sewanee.edu","user","csci","eArt");

  $select = "select name,price,imgPath from products 

  where artistId = '$artistId'";

  $r = $con->query($select);
/*
  $imgs[] = array();
  $prices[] = array();
  $names[] = array();
*/
  //print_r($prices);

  // controls products displayed 
  // all right now
  for($i=0;$i<$r->num_rows;$i++) {

    $r->data_seek($i);
    $temp = $r->fetch_array(MYSQLI_NUM);
    $names[]  = $temp[0];
    $prices[] = $temp[1];
    $imgs[]   = $temp[2];
    //echo "<td><img src='" . $temp[2] . "'> <br><p class='text'>" . $temp[0] . " for $" . $temp[1] . "</p></td>";
  }

  echo "var imgs = ";
  echo json_encode($imgs);
  echo ";";
  echo "<br><br>";
  echo "var names = ";
  echo json_encode($names);
  echo ";";
  echo "<br><br>";
  echo "var prices = ";
  echo json_encode($prices);
  echo ";";

}


?>