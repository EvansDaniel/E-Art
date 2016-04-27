
<?php
  session_start();
?>
<html lang="en-US">

<head>
  <link rel="stylesheet" type="text/css" href="../../styles/pHome.css">
   <meta charset="UTF-8">

</head>
   
<body class="body" id="body">
<nav id="navs">

  <ul>
  
    <li id="nav1">
      <a href="editProfile.php"><?php 
                      echo $_SESSION['fName']; 
                 ?>
      </a>
      <ul>
        <!--<li><a href="https://www.flickr.com/explore">Recent Photos</a></div>
        <li><a href="addItems.php">Add Your Art</a></li>-->
      </ul>
    </li>
    
    <li id="nav2"><a href="https://www.flickr.com/explore">Marketing</a>
      <ul>
      </ul>                      
    </li>
    
    <li id="nav3"><a href="https://www.flickr.com/create">Products</a>
      <ul>
        <li><a href="addNewProduct.php">Add a New Product to Your Store</a></div>
        <li><a href="editProduct.php">Edit an Existing Product</a></li>
      </ul>
    </li>
    
    <li id="nav4">
    </li>
    <li id="nav5"><form><input type="search"  class="Search" method="get" name="Search"
        placeholder="Photos, people, places..."></form>
    </li>
    
    <li id="nav6" style="margin-left:15px">
      <a href="orders.php">Orders
      </a>
    </li>
    
    <li id="nav7">
      <a href="../../i.php?logout">Log out
      </a>
    </li>
    
    <li class="liSignIn" id="nav8"> 
      <!-- make name appear top right --> 
      
    </li>   
  </ul>
</nav>

<?php 
 
  
      echo "<br><br><br><br><br><br><br><br><br><pre>";
      print_r($_SESSION);
      echo "</pre>";

?>
