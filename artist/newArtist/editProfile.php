
<html> 
  
  <head>

  	<link rel="stylesheet" type="text/css" href="../../styles/pHome.css">
    <link rel="stylesheet" type="text/css" href="../../styles/awesomeInputs.css">
    <script src="../../scripts/jquery-1.12.3.min.js"></script>

  </head>

  <body>
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
    <?php 
      // if the person isn't logged in, take them back to home page 
      if($_SESSION['user_logged_in'] != 1) {
      
      //header('Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php');
      }  
      ini_set('display_errors', 1);
      error_reporting(E_ALL);
      require_once("../../dbLogin.php");

    ?>
<div>


</div>
<div id="text-box-container">
    
    <form class="awesome-form" id="form" action="editProfile.php" method="post">
    
    <div class="input-group" id="input-group0"> 
  
    <input class="text-inputs" type="text" id="email" name="email">
    <label class="text-inputs">Enter new email</label>
    </div>
    
    <div class="input-group" id="input-group1">
    
    
    <input class="text-inputs" type="text" id="password" name="password">
    <label class="text-inputs">Enter new password</label>
    
   </div> 

   <div class="input-group" id="input-group3">
    
    
    <input class="text-inputs" type="text" id="cPassword" name="cPassword">
    <label class="text-inputs">Repeat new password</label>
    
   </div> 

   <div class="input-group" id="input-group5">
    
    
    <input class="text-inputs" type="text" id="fName" name="fName">
    <label class="text-inputs">First Name</label>
    
   </div> 

   <div class="input-group" id="input-group6">
    
    
    <input class="text-inputs" type="text" id="lName" name="lName">
    <label class="text-inputs">Add Your Last Name</label>
    
   </div> 

   <div class="input-group" id="input-group6">
    
    
    <input class="text-inputs" type="text" id="college" name="college">
    <label class="text-inputs">Edit college</label>
    
   </div>

   <div class="input-group" id="input-group6">
    
    <!-- gonna need to change this to a textarea tag -->
    <input class="text-inputs" type="text" id="biography" name="biography" size="50">
    <label class="text-inputs">Add a short biography</label>
    
   </div> 
    
    <input class="text-inputs" type="submit" id="submit">  
     
    </form>

    <span class=""><a href="" class="a-button-text" role="button">
          Done
        </a></span>
</div>

    <?php 
      
      $con = new mysqli($host
                        ,$u
                        ,$p
                        ,$db); 

      // --------------------------START EMAIL-----------------------------
      
      // proces the reset email request -- GOOD
      if(isset($_POST["email"]) && !empty($_POST['email'])) {
        
        $email = getPost($con,$_POST["email"]);
        
        if(strlen($email) > 50 || 
           !filter_var($email, FILTER_VALIDATE_EMAIL)) 
           echo "The email is either too long or invalid"; 
        else { 
          

          // if the insert succeeded, set the session var to new email
          if(enterNewInfo($con,'email',$email)) { 
            $_SESSION['user_email'] = $email;
            echo "Your email has been updated successfully!";
          } else echo "There was a problem processing your request";  
        }
      } 

      // -----------------------END EMAIL--------------------------------  

      // process the reset password request -- not good :(
      elseif(!empty($_POST['password']) && isset($_POST['password']) 

        &&  isset($_POST['cPassword']) && (!empty($_POST['cPassword']))
        )  {
        
          $pass  = getPost($con,$_POST['password']);
          $cPass = getPost($con,$_POST['cPassword']);

        if(($pass == $cPass) && (!empty($pass))) {
        
          $passHash = password_hash($pass,PASSWORD_DEFAULT);

          // check the insert
          if(enterNewInfo($con,'passHash',$passHash)) { 
            echo "Your password has been updated successfully!";
          } 
          // error entering data 
          else echo "There was a problem processing your request"; 
        }
        // error in inputs 
        else echo "The passwords either don't match or they are empty.";   
      } 

      // -----------------------END PASSWORD--------------------------- 

      elseif(isset($_POST['fName']) && !empty($_POST['fName'])) {
        
        $fName = getPost($con,$_POST['fName']);

        if(enterNewInfo($con,"fName",$fName)) {
          // write new name in session variable
          $_SESSION['fName'] = $fName;
          echo "The new phone number was entered successfully";
        }
        else {
          echo "There was a problem processing your request";
        }
      } 

      // ---------------------END FNAME------------------------
      
      
      elseif(isset($_POST['lName']) && !empty($_POST['lName'])) {
        $lName = getPost($con,$_POST['lName']);

        if(enterNewInfo($con,"lName",$lName)) {
          $_SESSION['lName'] = $lName;
          echo "Your last name was entered successfully";
        }
        else {
          echo "There was a problem processing your request";
        }
      } 

      // -----------------------END LNAME--------------------------- 
      
      elseif(isset($_POST['biography']) && !empty($_POST['biography'])) {
        $bio = getPost($con,$_POST['biography']);

        if(enterNewArtistInfo($con,'biography',$bio)) {


          echo "Your biography has been added to your profile"; 
        }
        // else echo "There was a problem processing your request"; 
      } 
      
      // -----------------------END BIOGRAPHY--------------------------- 

      elseif(isset($_POST['college']) && !empty($_POST['college'])) {
        $college = getPost($con,$_POST['college']);

        if(enterNewArtistInfo($con,'college',$college)) {

          echo "Your new college has been saved to your profile"; 
        }
        
        else echo "There was a problem processing your request"; 
      } 
      
      // -----------------------END COLLEGE--------------------------- 

      a($_SESSION);

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

    <?php

        function a($array) {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
      }
      function enterNewInfo($con,$col,$nC) {

        $peopleId = $_SESSION['people_id'];
        
        $q = "UPDATE people set $col='$nC' where peopleId = '$peopleId'";

        echo $q . "<br><br>";

        $r = $con->query($q);
        if(!$r) die($con->error);
        else return $r;
      }
      function getPost($con,$post) {
        return $con->real_escape_string($post);
      }
      function enterNewArtistInfo($con,$col,$nC) {

        $artistId = $_SESSION['artist_id'];
        
        $q = "UPDATE artists set $col='$nC' where artistId = '$artistId'";

        echo $q . "<br><br>";

        $r = $con->query($q);
        if(!$r) die($con->error);
        else return $r;
      }
    ?>
  
  </body>

</html>