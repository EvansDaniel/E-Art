<?php

    session_start();
?>

<html> 
  <head>
    <title>Add Your Product</title>
  	<link rel="stylesheet" type="text/css" href="../../styles/nav.css">
    <link rel="stylesheet" type="text/css" href="../../styles/awesomeInputs.css">
    <link rel="stylesheet" href="../../styles/dropZone.css">
    <script src="../../scripts/jquery-1.12.3.min.js"></script>
    <script src="../../scripts/jquery.autoSave.js"></script>
  </head>

  <body>
    <?php

    require_once("navBar.php");

    require_once('../../searchImproved.php');
    $con = new mysqli("crisler.sewanee.edu","user","csci","eArt");
    if(isset($_GET['Search'])) {
      $s = $_GET['Search'];
      search($s,$con);
    }

  $h ="<h4>Fill out the form below and drop a picture in the next page to 

  add a new product to your store   :) <h4>";
      
      // change the search bar's name to 'search' rather than 'Search'
      if(isset($_GET['search'])) {
        $s = $_GET['search'];
        header("Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php?search="

         . $s);
      }
 
   ?>



<div  id="div">
<form class="awesome-form" id="form" action="addNewProduct.php" method="post">
    
    <div class="input-group" id="input-group0"> 
  
    <input type="text" id="ProductName" name="productName">
    <label>Enter the title of your art</label>
    </div>
    
    <div class="input-group" id="input-group1">
    
    
    <input type="text" id="price" name="price">
    <label>Enter the price</label>
    
   </div> 

   <div class="input-group" id="input-group3">
    
    
    <input type="text" id="description" name="description" style=
    "width: 300px; height: 150px; border:1px solid #00688B;"></input>
    <label>Enter a description for your art (at least 70 characters long)</label>
   </div> 

   <div class="input-group" id="input-group5" >

    <input type="text" id="tag1" name="tag1" size="25">
    <label>Enter a tag (unique from the other tag fields, < 10 chars)</label>

   </div> 

    <div class="input-group" id="input-group5">

    <input type="text" id="tag2" name="tag2" size="25">
    <label id="dLabel">Enter a tag (unique from the other tag fields, < 10 chars)</label>

   </div> 

    <div class="input-group" id="input-group5" >

    <input type="text" id="tag3" name="tag3" size="25">
    <label>Enter a tag (unique from the other tag fields, < 10 chars)</label>

   </div> 

   <div class="input-group" id="input-group5" >

    <select type="select" id="Category" name="Category">
        <option value="1">Photography</option>
        <option value="2">Painting</option>
        <option value="3">Sculptures</option>
        <option value="4">Films and Videos</option>
   </div> 
    
   <input type="submit" id="submit" name="submit">  
     
</form>
</div>

<?php

  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  require_once("../../dbLogin.php");

    // define the issets for the form 

   /* echo "Use the before unload jquery function this page w

    hen you press back from dropZone.php"; */

    $con = new mysqli($host,$u,$p,$db);

    if(isset($_POST['productName']) &&
       
       isset($_POST['price']) &&
       isset($_POST['description']) &&
       isset($_POST['tag1']) &&
       isset($_POST['tag2']) &&
       isset($_POST['tag3']) &&
       isset($_POST['Category'])) {    

    
      if(!empty($_POST['productName']) &&
         !empty($_POST['price']) &&
         !empty($_POST['description']) &&
         !empty($_POST['tag1']) &&
         !empty($_POST['tag2']) &&
         !empty($_POST['tag3']) &&
         !empty($_POST['Category'])) {

        $name         = getPost($con,$_POST['productName']); 
        $price        = getPost($con,$_POST['price']);
        $description  = getPost($con,$_POST['description']);
        $tag1         = strtolower(getPost($con,$_POST['tag1']));
        $tag2         = strtolower(getPost($con,$_POST['tag2']));
        $tag3         = strtolower(getPost($con,$_POST['tag3']));
        $category     = getPost($con,$_POST['Category']);
        
        // if the tag fields are not unique 
        if($tag1 == $tag2 || 
           $tag2 == $tag3 ||
           $tag3 == $tag1) {
          echo "The tag fields must be unique";
        }
        else if(strlen($tag1) > 10 ||
                strlen($tag2) > 10 ||
                strlen($tag3) > 10) {
          echo "One of the tag fields is to long. It can't be more than 10 characters";
        }
        else if(!(is_numeric($price)) || $price < 0) {
          echo "Enter a valid price";
        }
        //else if()
    
        // manipulate the tags to help with search -> see the searchFunctions.php file
        echo $tag1 = get_new_words($tag1);
        echo $tag2 = get_new_words($tag2);
        echo $tag3 = get_new_words($tag3);

    
        // need to add the title of the art as the name of the image 
        // to the end of $imgPath -> need to process it so that there 
        // so that spaces are replace with underscores
    
        // remove leading and trailing spaces , THEN....
        // removes spaces and puts underscores 
        $n = trim($name);
        $_name = str_replace(" ", "_", $n); 
 
        $select = "select name from products where name='$_name'";
        $r = $con->query($select);

       if($r->num_rows > 0) {
           echo "One of your products is already named that. Pick a different name";
         } 

        // this is where all of this artists imgs will be stored
        $imgPath      = $_SESSION['path_to_artist_dir'] . "/" . $_name; // need file ext ???
        $artistId     = $_SESSION['artist_id'];
        $tableName    = "products";
        $_SESSION['product_name'] = $_name;

        // randomly generates #s for the top 10 artists thing 
        $productRank = mt_rand(1,10000);

          // check if the tag exists
          // if it doesn't, create it
          $select = "select tagName from tags where tagName='$tag1'";
          $r = $con->query($select);
          if($r->num_rows < 1) {
            $q = "insert into tags(tagName) VALUE('$tag1')";
            $r = $con->query($q); 
          }
          $select = "select tagName from tags where tagName='$tag2'";
          $r = $con->query($select);
          if($r->num_rows < 1) {
            $q = "insert into tags(tagName) VALUE('$tag2')";
            $r = $con->query($q); 
          }
          $select = "select tagName from tags where tagName='$tag3'";
          $r = $con->query($select);
          if($r->num_rows < 1) {
            $q = "insert into tags(tagName) VALUE('$tag3')";
            $r = $con->query($q); 
          }


        // insert product into the products table
        $query = "INSERT into " . $tableName . 
    
        "(name,artistId,categoryId,price,description,tagId1,tagId2,tagId3,inStock,productRank) 

        VALUES('$name'
        	  ,'$artistId'
    	      ,(select categoryId from category where categoryId='$category')
    	      ,'$price'
        	  ,'$description'
            ,(select tagId from tags where tagName='$tag1' Limit 1)
            ,(select tagId from tags where tagName='$tag2'  Limit 1)
            ,(select tagId from tags where tagName='$tag3' Limit 1)
        	  ,1
        	  ,'$productRank'
        	  )";
    
        $r = $con->query($query);

       $_SESSION['product_id'] = $con->insert_id;
        if(!$r) die($con->error); 
  
       // only works if the when all the fields are set
       if(isset($_POST['submit'])) {
          header("Location: ./testUpload.php");
       } 
    }
    else {
      echo "Please fill out all fields.";
    }  
  } 
  function getPost($con,$q) {
     return $con->real_escape_string($q);
  } 
?>

<script>
$(function() {

  $('.awesome-form .input-group input').focusout(function() {

    var text_val = $(this).val();

    if (text_val === "") {

      $(this).removeClass('has-value');

    } else {

      $(this).addClass('has-value');

    }

  });

 });
   </script>
   <style>
      #div{
      
      margin-left: 35%;
      margin-right: 35%;
      border: 1px solid black;
      padding: 30px;
      background: rgba(0, 173, 189, 0.08);
      
      
      }
    
   </style>

  </body>
<html>
