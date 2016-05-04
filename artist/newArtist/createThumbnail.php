<?php


  ini_set('display_errors', 1);
  error_reporting(E_ALL);

function createThumbnail($filename) {
     
    if(preg_match('/[.](jpg|jpeg)$/', $filename)) {
        $im = imagecreatefromjpeg($filename);
    } else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif($path_to_image_directory . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($path_to_image_directory . $filename);
    } else if (preg_match('/[.](bnp)$/', $filename)) {
        $im = imagecreatefromwbmp($path_to_image_directory . $filename);
    }
     
    $oldx = imagesx($im);
    $oldy = imagesy($im);


    // var_dump($oldx < $oldy);
    // this formula creates pictures that are 250px x 188.75px

    if($oldy > $oldx) {
      $newy = $final_height_of_image = 299;
      $newx = floor($oldy * ($final_height_of_image / $oldx)) + 26.3;
    }
    else {
      $newy = 299;
      $newx = ($newy*1.32775919);
    }
     
    // width, height 
    $nm = imagecreatetruecolor($newx, $newy);
     
    imagecopyresized($nm, $im, 0,0,0,0,$newx,$newy,$oldx,$oldy);
     
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
/*
  $photo = 1;
  $painting = 2;
  $sculptures = 3;
  $videos    = 4;
*/

  $con = new mysqli("crisler.sewanee.edu","user","csci","eArt");

for($j=1; $j<5; $j++) {

  $select = "select name,price,imgPath from products 

  where artistId = '$artistId' and categoryId = '$j'";

  $r = $con->query($select);
  if(!$r) die($con->error);

  // controls products displayed 
  // all right now
  for($i=0; $i<$r->num_rows; $i++) {
    
    $r->data_seek($i);
    $temp = $r->fetch_array(MYSQLI_NUM);
    
    $name[] = $temp[0];
    $price[] = $temp[1];
    $img[] = $temp[2];
    //echo "<td><img src='" . $temp[2] . "'> <br><p class='text'>" . $temp[0] . " for $" . $temp[1] . "</p></td>";
  }
//}

  echo "var cat" . $j ." = ";
  echo "[". json_encode($img)   . "," .
            json_encode($price) . "," . 
            json_encode($name)  . 
       "]";
  echo ";";

  $name = array();
  $price = array();
  $img = array();
  /*echo ";";
  echo "var price = ";
  echo json_encode($price);
  echo ";";
  echo "var name = ";
  echo json_encode($name);
  echo ";"; */

}
  /*echo "<br><br><br>javascript side: need to check that the length of first element 

  of every array looped through is not zero; if so, do stuff"; */
}
//getProduct(1);


?>