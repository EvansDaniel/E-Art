<html>

<head>
<link rel="stylesheet" type="text/css"  href="../../styles/cart.css?" <?php 
  echo time();
?>>
<?php 
  require_once('../../functions.php');
?>
<title>Checkout</title>
<script src="../../scripts/jquery-1.12.3.min.js"></script>
<script>
	$(function(){
		var stuff= $("#cart table tr td:nth-child(2)");
		var prices= [];
		var total=0;

		for (var i=0; i<stuff.length; i++){
			prices[i]= parseFloat(stuff[i].innerHTML);
			total += prices[i];
			
		}
		document.getElementById("total").innerHTML=total+"$";
		document.getElementById("numberofitems").innerHTML=stuff.length;
	
	});
</script>

</head>
<body>
	<?php 
	session_start();
	?>
	<div id ="container">
	<nav id="navs">

  <ul>
  
    <li id="nav1">
      <div class="icon"><a class="haiti" title="Back to Home."
      href="../../pHome.php"><img src="../../images/logo.png"></a></div>
    </li>
    
    <li id="nav2"><a href=<?php echo getHomeURL() ."?category=1"; ?> >Paintings</a>                      
    </li>
    
    <li id="nav3"><a href=<?php echo getHomeURL() ."?category=2"; ?>>Photography</a></li>
    </li>
    
    <li id="nav4"><a href=<?php echo getHomeURL() ."?category=3"; ?>>Sculpture</a>
    </li>
    
    <li id="nav6" style="margin-left:15px">
      <a href=<?php echo getHomeURL() ."?category=4"; ?>>Videos & Films
      </a>
    </li>
    
    <li id="nav7">
      <?php if($_SESSION['user_logged_in'] != 1) { ?>
      <a href="SignUp.php">Sign Up</a>
      <?php } else { ?>
      <a href="checkout.php">Cart <?php 
        
      ?></a>
      <?php } ?>
    </li>
    
    <li class="liSignIn" id="nav8">
      <?php if($_SESSION['user_logged_in'] != 1) { ?>
        <button id="signIn" onclick="login()">Sign In
        </button>
      <?php } else { ?>
        <a href="../../i.php?logout"><button id="signIn">Log Out
        </button></a>
      <?php } ?>
    </li>    
  </ul>
</nav>
			<?php 
	   
       require_once('../../classes/shoppingCart.php');
       $cart = new shoppingCart($_SESSION['userName']);
       if(isset($_POST['submit'])) {

         echo $itemId = $_POST['submit'];
         
         $cart->removeItem($itemId);
         //header("Location: " . $_SERVER['PHP_SELF']);
       }
	?>
		<div id"body">
		<div id="Cart">
			<h1> Cart </h1>
			<table>

		<?php 
          $cart->displayCart();
		?>

			</table>
		</div>
		<div id="business">
			<div id= 'placeHolder'></div>
			<did id="price" >
			<h1>  </h1>
			<table>
				<tr>
					<td id="title">Number of Items</td>
					<td id="numberofitems"><td>
				</tr>
				<tr>
					<td id="title">Cart Total</td>
					<td id="total"></td>
				</tr>
				<tr>
					<td></td>
					<td><a href="http://hive.sewanee.edu/evansdb0/eArt/proceed.php">

		<button id="proceed" onClick="proceed()"> Proceed to checkout</button></a></td>
					
				</tr>
			</table>
		</div>

		<div id="checkout">

		</div>

		</div>

		<div id"checkout">


		</div>
		
		</div>
	</div>
	<style>

	</style>
</body>

</html>
