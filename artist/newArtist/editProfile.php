<html> 
  
  <head>

  	<link rel="stylesheet" type="text/css" href="../../styles/pHome.css">
    <link rel="stylesheet" type="text/css" href="../../styles/awesomeInputs.css">
    <script src="../../scripts/jquery-1.12.3.min.js"></script>

  </head>

  <body>
    <?php 
      session_start();
    ?>
  	<!--<nav id="navs">

      <ul>
  
        <li id="nav1">
          <a href="editProfile.php"><?php 
                      echo $_SESSION['fName'] . " " . $_SESSION['lName']; 
                 ?>
        </a>
        <ul>
          <!--<li><a href="https://www.flickr.com/explore">Recent Photos</a></div>
          <li><a href="addItems.php">Add Your Art</a></li>
        </ul>
        </li
    
        <li id="nav2"><a href="https://www.flickr.com/explore">Marketing</a>
          <ul>
            <li><a href="https://www.flickr.com/explore">Recent Photos</a>
            <li><a href="https://www.flickr.com/vr">Flickr VR</a></li>
            <li><a href="https://www.flickr.com/commons">The Commons</a>
            <li><a href="https://blog.flickr.net/en">Flickr Blog</a></li>
          </ul>                      
        </li>
    
        <li id="nav3"><a href="https://www.flickr.com/create">Products</a>
          <ul>
            <li><a href="addNewProduct.php">Add a New Product to Your Store</a></div>
            <li><a href="editProduct.php">Edit an Existing Product</a></li>
          </ul>
        </li>
    
        <li id="nav4">       </li>
      
        <li id="nav5"><form><input type="search"  class="Search" method="get" name="Search"
          placeholder="Photos, people, places...">
        </li>
    
        <li id="nav6" style="margin-left:15px">
          <a href="orders.php">Orders</a>
        </li>
    
        <li id="nav7">
          <a href="../../i.php?logout">Log out </a>
        </li>
    
        <li class="liSignIn" id="nav8"> 
          <!-- make name appear top right 
      
        </li>   
      </ul>
    </nav>-->
    <div>
      <form class="awesome-form" id="form">
    
    <div class="input-group" id="input-group0"> 
  
    <input type="text" id="email" name="email">
    <label>Enter new email</label>
    </div>
    
    <div class="input-group" id="input-group1">
    
    
    <input type="text" id="password" name="password">
    <label>Enter new password</label>
    
   </div> 

   <div class="input-group" id="input-group3">
    
    
    <input type="text" id="cPassword" name="cPassword">
    <label>Repeat new password</label>
    
   </div> 

   <div class="input-group" id="input-group4">
    
    
    <input type="text" id="phone" name="phone">
    <label>Add or edit your phone number</label>
    
   </div>

   <div class="input-group" id="input-group5">
    
    
    <input type="text" id="fName" name="fName">
    <label>First Name</label>
    
   </div> 

   <div class="input-group" id="input-group6">
    
    
    <input type="text" id="lName" name="lName">
    <label>Last Name</label>
    
   </div> 

   <div class="input-group" id="input-group6">
    
    
    <input type="text" id="college" name="college">
    <label>Edit college</label>
    
   </div> 
    
    <input type="submit" id="submit">  
     
    </form>
    </div>

    <?php 

      $con = new mysqli()
      

      function enterNewInfo() {

        
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
  
  </body>

</html>