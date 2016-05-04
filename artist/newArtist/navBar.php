<nav id="navs">

        <ul>
        
          <li id="nav1">
          <?php 
          session_start();
          echo "<a href=
          'http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/editProfile.php'>"
          . $_SESSION['fName'] . "</a>";
          ?>
       
          </li>
          
          <li id="nav2"><a>Marketing</a>
                                 
          </li>
          
          <li id="nav3">
          <a href="http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/products.php"
          	>Products</a>
          
            <ul>
              <li id ="mystore"><a id ="mystore" href="http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/myProduct.php">My Products</li>
              
              <li id= "add"><a id= "add" href="http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/addNewProduct.php">Add New Product</a></li>
            </ul>	
            
          </li>
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
