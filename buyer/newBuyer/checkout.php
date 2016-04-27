<html>

<head>
<link rel="stylesheet" type="text/css"  href="../../styles/cart.css">
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
	<div id ="container">
		<nav>
			<ul>
				<li>Home</li>
				<li>Departments</li>
				<li>Top 10's</li>
				<li>Cart</li>
				<li>Checkout</li>
			</ul>
		</nav>
		<div id"body">
		<div id="Cart">
			<h1> Cart </h1>
			<table>
				
				<tr>
					<td><img src="../../images/21H.jpg">
						<p id="category">painting </p>
					    <p id="name">Name: Mother Nature Call</p>
					</td>
					<td id="prc">32.99</td>
				</tr>
				<tr>
					<td><img src="../../images/21H.jpg">
						<p id="category">painting </p>
					    <p id="name">Name: Mother Nature Call</p>
					</td>
					<td id="prc">35.99</td>
				</tr><br>
				<tr>
					<td><img src="../../images/21H.jpg">
						<p id="category">painting </p>
					    <p id="name"> Mother Nature Call</p>
					</td>
					<td id="prc">35.99</td>
				</tr>
			</table>
		</div>
		<div id="business">
			<div id= 'placeHolder'></div>
			<did id="price" >
			<h1> Cart Total</h1>
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
					<td><button id="proceed" onClick="proceed()"> Proceed to checkout</button></td>
					
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
