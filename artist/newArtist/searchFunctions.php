<?php 
function search($string,$con) {


  $search = $string;

  $q = "select tagId from tags where MATCH(tagName) 

  against('$search' IN BOOLEAN MODE)";  
  
  // returns 4->new york, 2->wars,9->evil
  $r = $con->query($q);
  if(!$r) die($con->error);
   
  
  for($i=0; $i<$r->num_rows; $i++) {
    $r->data_seek($i);
    $r_array = $r->fetch_array(MYSQLI_ASSOC);
    $tagId[] = $r_array['tagId'];
  }
  for($j=0; $j<$r->num_rows; $j++) {
    echo $tagId[$j];
    $q= "select itemId,imgPath,name,price,artistId from products where tagId1 = '" . 
    $tagId[$j] . "' or tagId2 = '" .$tagId[$j] . "' or tagId3 = '".$tagId[$j]. "'";
    $result = $con->query($q);
    if(!$result) die($con->error);
    $result->data_seek($i);
    $r_array = $result->fetch_array(MYSQLI_ASSOC);

    $imgPath[] = $r_array['imgPath'];
    $itemId[]  = $r_array['itemId'];
    $name[]    = $r_array['name'];
    $price[]   = $r_array['price'];
    $artistId[] = $r_array['artistId'];
  }
  $newItemId[] = array();
  for($j=0; $j<$r->num_rows; $j++) {
    
    // if we have already returned this from the database 
    if(in_array($itemId[$j], $newItemId)) continue;

    $newItemId[] = $itemId[$j];

    // $img = $imgPath[$j]

    //echo "<img src='" . $imgPath[$j] . "' height='200' width='320'/>";
    //echo "<br>";
    $q = "select name from people where artistId=$artistId[$j]}"; 

    $output = "<li id=$j> 
      <div>
        <div>
          <a href='http://www.yogakitty.com'><img src='{imgPath[$j]}' >
          <button class='quicklook'> Quick Look</button>
        </div>
      <aside>
        
        <p id='title'>{$name[$j]}</p>
        <p id='price'>{$price[$j]}</p>
        <p id='artist'>by </p>
        <p id='type'>   
        </a>
      </aside>  
      </div>
    </li>";
  }
}
function check_ies($str) {
  return substr($str,strlen($str)-3);
}
function build_no_ies($str) {
  $temp = substr($str,0,strlen($str)-3);
  $temp .= "y";
  return $temp;
}
function check_es($str) {
  return substr($str,strlen($str)-2);
}
function build_replace_e($str) {
  $temp =  substr($str,0,strlen($str)-2);
  $temp .= "e";
  return $temp;
}
function build_no_es($str) {
  return substr($str,0,strlen($str)-2);
} 
function check_s($str) {
  return substr($str, strlen($str)-1);
}
function check_ss($str) {
	return substr($str, strlen($str)-2);
}
function build_no_s($str) {
  return  substr($str,0, strlen($str)-1);
}
function get_new_words($str) {

  $split = explode(" ",$str);
  $split_len = count($split);
  
  $newWords = "";
  for($i=0; $i<$split_len; $i++) {
    // -> check_s returns last char
    if(check_s($split[$i]) == "y" || check_s($split[$i]) == "d") {
      $newWords .= " " . strrev($split[$i]);
    } 
    elseif(check_ies($split[$i]) == "ies") {
      $newWords .= " " . strrev(build_no_ies($split[$i]));
    }
    elseif(check_es($split[$i]) == "es") {
      if(check_s(build_replace_e($split[$i])) == "y") {
        $newWords .= " " .  strrev(build_replace_e($split[$i]));
      }
      else {
      	$newWords .= " ". build_replace_e($split[$i]);
      }
    }
    elseif(check_s($split[$i]) == "s"   && !(check_ss($split[$i]) == "ss")) {
      if(check_s(build_no_s($split[$i])) == "y") {
        $newWords .= " " . strrev(build_no_s($split[$i]));
      }
      else {
      	$newWords .= " ". build_no_s($split[$i]);
      }
    }
    else {
      $newWords .= " " . $split[$i];
    }
  }
  return $newWords;
}
function last($str) {
  
  return substr($str, strlen($str)-1);
}

?>