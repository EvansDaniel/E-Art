
<html lang="en-US">

<head>

  <?php 
    session_start();
  ?>
  <title>Life in Haiti</title>
  <link rel="stylesheet" href="styles/item.css">
  <script src="scripts/jquery-1.12.3.min.js"></script>
  <script >
      function el(i){
        return document.getElementById(i);

      }
      jQuery(function(){
      el("search").addEventListener('focus', function(){
      
      el("nav7").setAttribute("style","visibility: hidden");
    
    
    }, false);
      el("search").addEventListener('blur', function(){
      
      el("nav7").setAttribute("style","visibility: visible");
    
    
    }, false);

      var images = jQuery("#listings li div a img");


      /*function showQuickLook(){
        'document.getElementById('myview').setAttribute("style", "visibility:visible")';
      } */
     




  });
      
  </script>
   <meta charset="UTF-8">

</head>
   
<body class="body" id="body">

    
    

<!--<header class="header"> -->

<nav id="navs">

  <ul>
  
    <li id="nav1">
      <div class="icon"><a class="haiti" title="Back to Home."
      href="pHome.php"><img src="images/logo.png"></a></div>
    </li>
    
    <li id="nav2"><a href=<?php echo "{$_SERVER['PHP_SELF']}?category=paintings"; ?> >Paintings</a>                      
    </li>
    
    <li id="nav3"><a href=<?php echo "{$_SERVER['PHP_SELF']}?category=photography"; ?>>Photography</a></li>
    </li>
    
    <li id="nav4"><a href=<?php echo "{$_SERVER['PHP_SELF']}?category=sculptures"; ?>>Sculpture</a>
    </li>
    
    <li id="nav6" style="margin-left:15px">
      <a href=<?php echo "{$_SERVER['PHP_SELF']}?category=videos"; ?>>Videos & Films
      </a>
    </li>
    
    <li id="nav5"><form><input id="search" type="search"  class="Search" method="get" name="search"
        placeholder="Photos, paintings, art..."></form>
    </li>
    
    <li id="nav7">
      <?php if($_SESSION['user_logged_in'] != 1) { ?>
      <a href="SignUp.php">Sign Up</a>
      <?php } else { ?>
      <a href="./buyer/newBuyer/checkout.php">Cart</a>
      <?php } ?>
    </li>
    
    <li class="liSignIn" id="nav8">  
      <button id="signIn" onclick="login()">Sign In
      </button>
    </li>    
  </ul>
</nav>
<!-- new shit -->

<div class="login" id="login34">
  <div class="login-outer">
    <div class="login-inner">
      <div class="login-box">
        <h2 class="box-heading">
                 Login to your 
        </h2>
        <p id="hline">  <p>
        <div class="login-wrapper">

          <div class="box-bottom">

            <form class="login-form" name="login-form" action="i.php" method="post" >
              <div class="manage-login-fields-wrapper">
                <div class="email-form-item">
                  <input type="text" id="email" name="user_email" placeholder="Email Address" 
                  class = "email-input"/>
                </div>
                <div class="password-form-item">
                  <input type="text" name="user_password" placeholder="Password" 
                  class = "pass-input"/>
                </div>
                
                <div class="rememberme" id="rememberme">
                  <br>
                  <label>rememeber me</label><br>
                  <input type="checkbox" name="user_rememberme"
                  class = "rememberme"/>
                </div>
              </div> <!-- manage-fields -->
              <div class="form-actions">
                <div class="submit-row">
                  <button type="submit" name="login" value="login" class="login-primary">Login
                  </button>
                  <span id="or">or<br> </span>
                  <a id="forgot" href="password_reset.php">Forgot Password</a>
                </div> <!-- submit-row -->
              </div> <!-- form-actions -->
            </form> <!-- login-form -->
          </div> <!-- box-bottom -->
        </div> <!-- login-wrapper -->
        <div class="box-footer">
          Don't have an account? <a href="SignUp.php">Sign up</a> 
        </div> <!-- box-footer -->
      </div> <!-- login-box -->
    </div> <!-- login-inner -->
  </div> <!-- login-outer --> 
</div> <!-- login-skin -->
<div id="fade" class="black_overlay"></div>

<!-- end new shit-->
  <?php 
    require_once('dbLogin.php');
    require_once("searchFunctions.php");


    $con = new mysqli($host,$u,$p,$db);
    if(isset($_GET['itemId'])) {
      $itemId = $_GET['itemId'];

      $q = "select name,price,description,imgPath from products 
      where itemId = $itemId";
      $r = $con->query($q); 
      if(!$r) die($con->error);

      $r_arr = $r->fetch_array(MYSQLI_ASSOC);

   echo  "<div id='myview'>
    
    <div id='img'>
      <img src='{$r_arr['imgPath']}'>
    </div>
    <div id='next'>
      <h1 id='title'>{$r_arr['name']}</h1>
      <p id='rating'></p>
      <p id='price'>\${$r_arr['price']}</p>
      <div id='itemDes'>
        <ul>
          <li><button id='selection'>Item selection</button></li>
          <li><button id='description'>Description</button></li>
          
        </ul><br>
        <div id='box'>
          <p>{$r_arr['description']}</p>
        </div>
        <button id='cart'>Add to Cart</button>
      </div>
    </div>
    <style>
      #listings{

      }
      #fade, .black_overlay{
    visibility: visible; display: block; z-index:1 
    }
    #myview{
      z-index:999;
    }
    </style> 
    "; 
    }
  ?>

</div>
<div id="body">

  <ul id="listings">
<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['search'])) {
  
  $s = $_GET['search'];
  header("Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php?search=" . $s);

}
else {
 // search(get_new_words(),$con);
}
?>

    <li ="myitem"> 
       <div>
        <div id="image">
          <img id="pic" src="http://hive.sewanee.edu/evansdb0/evansdb0/City_Life.jpg">
        </div>

        <div id="wording">
        
        <p id="product">City Life</p>
        <p id="author">by Daniel</p><br>
        <p id="finance">Price: $100</p>
        <p id="category">Photography</p>
        <p id="descr"> DESCRIPTION: </p>
        <div id="aboutit"> 
          <aside>fsaghdavfavfdsvaidfiugdafggfa;ugfdahguohfuoafabgufdbi;faugsdfdaaASDAAdsfadsfgsadagfsafdsigfudguagugdufgau
          </aside>
          </div>
        <button id="cart">Add to Cart</button>
      
      </div>
      </div>
    </li><br><hr id="myline">
    
      <p id="relate">Related to this item</p>
      <hr id="myline">
      <br id="thebr">
<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['search'])) {
  
  $s = $_GET['search'];
  search(get_new_words($s),$con);
}
else {
  search(get_new_words("star wars cities london"),$con);
}
?>
</ul>


</div>







<script>

var fade =  $('fade');
// adds onclick to the fade overlay, makes login disappear and fade go away
fade.addEventListener('click', function (event) {

      
      $('fade').style.visibility='hidden';
      $('login34').style.visibility = 'hidden';
      $('body').style.overflow='visible';
      document.getElementById('myview').setAttribute('style','visibility:hidden');

 });
    // leave 1st line while working on pop up, then erase.. its in the sign up onclick
  function remove(){

        $('fade').style.visibility='hidden';
      $('login34').style.visibility = 'hidden';
      $('body').style.overflow='visible';
      document.getElementById('myview').setAttribute('style','visibility:hidden');
      }  
function login() {
      // makes login form pop up 
      $('fade').style.visibility='visible';
      $('login34').style.visibility = 'visible';
      document.getElementById('fade').style.display='block';
      document.getElementById('login34').style.display='block';
      document.getElementById('body').style.overflow='hidden';
      document.getElementById("email").focus();
      window.scrollTo(0,0);
    }
function $(id) {
  return document.getElementById(id);
}
</script>






</body>
 
</html>


















