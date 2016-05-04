<?php 
session_start();

require_once('functions.php');
function search($string,$con) {
  
  if(getURL() != "http://hive.sewanee.edu/evansdb0/eArt/pHome.php") {

    header("Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php?search=" . $string);
  }  
  // drop table with copied info from below select statement
  if(loggedIn()) {
    $q = "drop table if exists " . getUsername() . "RecentSearch";
    myQ($q,$con);
  }

  $search = $con->real_escape_string($string);
  $search = strip_tags($search);
  

  $q = "select 
        match(description) against('$search' IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION) as R1       
      , match(name) against('$search' IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION) as R2       
      , name
      , imgPath
      , price
      , artistId
      , description
      , tagId1
      , tagId2
      , tagId3
      , itemId
      , categoryId
       from products
       where inStock=1 having  R1 > 0 or R2 > 0";
   // usrName from session var
   // copying 5 unneeded columns over (nearly half the table)
   // could speed this up by removing those ... to be continued
   //if(isset($_SESSION[]))

   $product_res = myQ($q,$con);
   if(loggedIn()) {
     $createTempTable = "create table " . getUsername() . 'RecentSearch ' . $q;
     myQ($createTempTable,$con);

     $createTSearchHist = "create table if not exists " . getUsername() . "SearchHist     

     select itemId,name,imgPath,price,artistId,description from " 

     . getUsername() . "RecentSearch where itemId = " . mt_rand(1,$product_res->num_rows);
    myQ($createTSearchHist,$con);
   }
   // relevance will be sorted later 
   for($i=0; $i < $product_res->num_rows; $i++) {
     $product_arr = getAssocArr($i,$product_res);
     $rel_total[$product_arr['itemId']] = $product_arr['R2'] + $product_arr['R1'];

   }

    $q = "select tagName,tagId,match(tagName) against('$search' 

    ) as R3 from tags 

    HAVING R3 > 0"; 

    // get each word from the item's tags saved in an array
    // get the itemId of each item saved in an array 
    // if there is a match in the tags and that tag is in the tag array, 
    // and the item's itemId is in the itemId array, 
    // don't add the relevance, otherwise add the relevance .
    $tagResult = myQ($q,$con);

   $itemId = null;
   for($i = 0; $i < $tagResult->num_rows; $i++) {
     $tag_arr = getAssocArr($i,$tagResult);

     for($j=0; $j < $product_res->num_rows; $j++) {

       $tagName = $tag_arr['tagName'];

       // $rel_total[$product_arr['itemId']] += $tag_arr['R3']; 

       $temp = explode(" ",$tagName);

       $product_arr = getAssocArr($j,$product_res);
       
       // if the tags match 
       if($tag_arr['tagId'] == $product_arr['tagId1']) {

        // tagRelevance($temp,$product_arr,$itemId,$rel_total,$tag_arr); 
         foreach ($temp as $key => $val) {
           if($itemId[$product_arr['itemId']] != null && 

         in_array($val, $itemId[$product_arr['itemId']])) {

             continue;
           }
           else {
           
             $itemId[$product_arr['itemId']][] = $val;
             $rel_total[$product_arr['itemId']] += $tag_arr['R3'];
           }
         }
       } 
       elseif($tag_arr['tagId'] == $product_arr['tagId2']) {
         // tagRelevance($temp,$product_arr,$itemId,$rel_total,$tag_arr); 
         foreach ($temp as $key => $val) {

           // if the 
           if($itemId[$product_arr['itemId']] != null && 

         in_array($val, $itemId[$product_arr['itemId']])) {

             continue;
           }
           else {
           
             $itemId[$product_arr['itemId']][] = $val;
             $rel_total[$product_arr['itemId']] += $tag_arr['R3'];
           }
         }
       }
       elseif($tag_arr['tagId'] == $product_arr['tagId3'] ) {
         foreach ($temp as $key => $val) {
           if($itemId[$product_arr['itemId']] != null && 

         in_array($val, $itemId[$product_arr['itemId']])) {

             continue;
           }
           else {
           
             $itemId[$product_arr['itemId']][] = $val;
             $rel_total[$product_arr['itemId']] += $tag_arr['R3'];
           }
         }
       } 
     }
   }
   arsort($rel_total);

   $count = count($rel_total);
   $i =0;
   while ($relevance = current($rel_total)) {
    $product_arr = getAssocArr($i,$product_res);
    $p_itemId = $product_arr['itemId'];

    $key = key($rel_total);
    // get each row from the recentSearch table
    if(loggedIn()) { 
      $q = "select name,imgPath,price,artistId,description from " 

      . getUsername() . "RecentSearch where itemId = $key";
    }
    else {
      $q = "select name,imgPath,price,artistId,description from products

      where itemId = $key";
    }
    $res = myQ($q,$con);

    $res_s_arr = getAssocArr($i,$res);

    // done each time because each product is not made by same artist 
    $q = "select fName from people where artistId={$res_s_arr['artistId']}"; 
    $res = myQ($q,$con);
    $artist_arr = $res->fetch_array(MYSQLI_ASSOC);

    displayResults($res_s_arr,$i,$key,$artist_arr);

    next($rel_total);
    $i++;
    
   }
   return $product_res;
}

function displayResults($res_s_arr,$i=0,$key=0,$artist_arr) {
  echo $output = "<li id=strval($i)> 
      <div>
        <div>
          <a href='./item.php?item=$key'><img src='{$res_s_arr['imgPath']}'>
          <a href='{$_SERVER['PHP_SELF']}?itemId=$key'> 
          <button class='quicklook'>Quick Look</button></a>
        </div>
      <aside>
        
        <p id='title'>{$res_s_arr['name']}</p>
        <a href='http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/myProduct.php'>
        <p id='artist' style='text-decoration: underline;'>by {$artist_arr['fName']}</p></a>
        <p id='price'>\${$res_s_arr['price']}</p>
        <p id='type'>   
        </a>
      </aside>  
      </div>
    </li>";

}
function searchByCategory($categoryId,$con) {

  if(getURL() != "http://hive.sewanee.edu/evansdb0/eArt/pHome.php") {
header("Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php?category=" . $categoryId);
  }
   
   $q = "select price,itemId,name,description,imgPath,artistId from products

   where categoryId = $categoryId";

   $productInfo = myQ($q,$con);
   $productInfo_arr = getAssocArr(1,$productInfo);

   $q = "select fName from people where artistId={$productInfo_arr['artistId']}"; 
   $a = myQ($q,$con);
   $artistName_arr = $a->fetch_array(MYSQLI_ASSOC);

   for($i = 0; $i < $productInfo->num_rows; $i++) {
     $productInfo_arr = getAssocArr($i,$productInfo);

     displayResults($productInfo_arr,$i,$productInfo_arr['itemId'],$artistName_arr);
   }
   return $productInfo;
   
}
function tagRelevance($temp,$product_arr,$itemId,$rel_total,$tag_arr) {
  foreach ($temp as $key => $val) {
    if($itemId[$product_arr['itemId']] != null && 

      in_array($val, $itemId[$product_arr['itemId']])) {

      continue;
    }
    else {
      $itemId[$product_arr['itemId']][] = $val;
      $rel_total[$product_arr['itemId']] += $tag_arr['R3'];
    }
  }
}

























function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
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