<?php 

require_once('functions.php');
session_start();
?>
<html>
	
	<head>
		<link rel="stylesheet" type="text/css"  href="styles/cartforProceed.css?" <?php 
		  echo time();
		?>>
		<link rel="stylesheet" type="text/css"  href="styles/navbar.css?" <?php 
		  echo time();
		?>>
		<link rel="stylesheet" type="text/css"  href="styles/proceed.css?" <?php 
		  echo time();
		?>>
		<script src="scripts/jquery-1.12.3.min.js"></script>
		<script> 
			$(function(){
				$("#changeadd").hide(50);
				$("#newcard").hide(50);
			});
		
		
		</script>
		
			
			
		
	</head>
	
	<body>
		<div id='container'>
		  
			<nav id="navs">

				  <ul>
				  
				    <li id="nav1">
				      <div class="icon"><a class="haiti" title="Back to Home."
				      href="pHome.php"><img src="images/logo.png"></a></div>
				    </li>
				    
				    <li id="nav2"><a href="../../pHome.php"> Paintings</a>                      
				    </li>
				    
				    <li id="nav3"><a href="../../pHome.php">Photography</a></li>
				    </li>
				    
				    <li id="nav4"><a href="../../pHome.php">Sculpture</a>
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
				      <a href="./buyer/newBuyer/checkout.php">Cart <?php 
				        
				      ?></a>
				      <?php } ?>
				    </li>
				    
				    <li class="liSignIn" id="nav8">
				      <?php if($_SESSION['user_logged_in'] != 1) { ?>
				        <button id="signIn" onclick="login()">Sign In
				        </button>
				      <?php } else { ?>
				        <a href="i.php?logout"><button id="signIn">Log Out
				        </button></a>
				      <?php } ?>
				    </li>    
				  </ul>
				</nav>
			<div id='content'>
			<div id='addresses'>
				<h1> 1. Shipping Address</h1>

				<p id='myaddress'>
				</p> 
				<button id='changeadd' onclick='
						$("#addAddress").show(100);				
				
				'>change address</button>
				<div id='addAddress'>
						<ul>
							
							<li><input type='text' name='name' id='names' placeholder='Full Name'></li>
							<li><input type='text' name='address1' id='add1' placeholder='Street address, P.O. box, company name, c/o'></li>
						 	<li><input type='text' name='address2' id='add2' placeholder='Apartment, suite, unit, building, floor, etc'> *</li>
						 	<li><input type='text' name='city' id='city' placeholder='City'></li>
						 	<li><input type='text' name='state' id='state' placeholder='State'></li>
							<li><input type='number' name='zip' id='zip' placeholder='zip'></li>
							<li><button id='save' name='addressSubmit'onclick='var name = $("#names").val();
																	var address = $("#add1").val();
																	var city = $("#city").val();
																	var state = $("#state").val();
																	var zip = $("#zip").val();
            													
            													if(name.length != 0 && address.length != 0 && city.length!=0 && zip.lenght!=0){
            															if(!isNaN(parseInt(zip,10)) && parseInt(zip,10) > 10000 && parseInt(zip,10) < 100000){
    
            															var str = "" + name +"<br>"+ city +" "+ city + ", "+ state+ " "+ zip;
            															$("#myaddress").html(str);
            															$("#addAddress").hide(500);
            															$("#changeadd").show(50);
            															$("#newcard").show(100);
            																}
            															else{
																				alert("invalid zip");            															
            															}
            														}
            													else{
																		alert("complete all the fields without a star");            													
            													}
            													'>Save</button></li>

						</ul>
					
				</div>
				<div>
					<h1> 2.  Payment Method </h1>
					<p id='mycard'></p>

					<div id='newcard'>
						<ul>
							<li>DO NOT ENTER VALID INFO<br> THIS IS A TRIAL!!<br></li>
							<li><input type='number' name='cardnum' id='cardnum' placeholder='card number'></li>
							<li><input type='text' name='name' id='names' placeholder='Name on Card'></li>
							<li><input type='text' name='name' id='names' placeholder='Full Name'></li>
							<li> Expiration Date: </li>
							<li><input type='date' name='date' id='date' placeholder='expiration date'></li>
							

						</ul>
						
					</div>

				</div>
				<div id='review'>
					<h1> 3. Review Order</h1>
						<div id="Cart">
							<table>

		

							
					<?php 
					require_once('./classes/shoppingCart.php');
					$cart = new shoppingCart(getUserName());
					echo "<div id='reviewCart' >";
					$cart->displayCart();
					echo "</div>";
					       if(isset($_POST['submit'])) {

         					echo $itemId = $_POST['submit'];
         
         		$cart->removeItem($itemId);
         		//header("Location: " . $_SERVER['PHP_SELF']);
       			}
					?>
					</table>
				</div>
			
			</div>
		  </div>
		</div>
	<?php 
      
      echo $_POST['name'];
	?>
	</body>
</html>
