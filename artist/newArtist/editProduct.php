<?php 
  
  session_start();
  // if the person isn't logged in, take them back to home page 
  if($_SESSION['user_logged_in'] != 1) {
    // header('Location: http://hive.sewanee.edu/evansdb0/eArt/i.php');
    //header('Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php');
  }  
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  require_once("../../dbLogin.php");
  require_once("functions.php");
  
  
?>

<nav id="navs">

        <ul>
        
          <li id="nav1">
          <?php 
          echo "<a href=
          'http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/editProfile.php'>"
          . $_SESSION['fName'] . "</a>";
          ?>
       
          </li>
          
          <li id="nav2"><a href="https://www.flickr.com/explore">Marketing</a>
                                 
          </li>
          
          <li id="nav3"><a 
          	href="http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/addNewProduct.php"
          	>Products</a></li>
            <!--<ul>
              <li><a href="addNewProduct.php">Add a New Product to Your Store</a></div>
              <li><a href="editProduct.php">Edit an Existing Product</a></li>
            </ul>    -->


            <!-- REALLY REALLY NEED BLAISE TO FIX CSS ON THIS -->
          </li>
          
          <li id="nav4">
          </li>
          <li id="nav5"><form><input type="search"  class="Search" method="get" name="Search"
              placeholder="Photos, people, places..."></form>
          </li>
          
          <li id="nav6" style="margin-left:15px">
            <a href="upload.php">Orders
            </a>
          </li>
          
          <li id="nav7">
            <a href="../../i.php?logout">Log out
            </a>
          </li>
          
       
        </ul>
      </nav>
