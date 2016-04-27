<html>

<head>
<link rel="stylesheet" type="text/css"  href="checkout.css">
<script src="jquery-1.12.3.js"></script>
<script>
	$(function(){
		var stuff= $("#cart table tr td:nth-child(4)");
		var prices= [];
		var total=0;

		for (var i=0; i<stuff.length; i++){
			prices[i]= parseFloat(stuff[i].innerHTML);
			total += prices[i];
			
		}
		document.getElementById("total").innerHTML=total+"$";
	
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
		<div id="Cart">
			<h1> Cart </h1><hr>
			<table>
				<tr> 
					<th>Image</th><th>Type</th><th>Title</th> <th>Price in Dollars($)</th>
				</tr>
				<tr>
					<td><img src="21H.jpg"></td>
					<td>painting</td>
					<td>Mother Nature Call</td>
					<td id="price">32.99</td>
				</tr>
				<tr>
					<td><img src="21H.jpg"></td>
					<td>painting</td>
					<td>Mother Nature Call</td>
					<td id="price">35.99</td>
				</tr>
				<tr>
					<td><img src="21H.jpg"></td>
					<td>painting</td>
					<td>Mother Nature Call</td>
					<td id="price">35.99</td>
				</tr>
			</table>
		</div>
		<div id="price">
			<hr><h1> Cart Total</h1>
			<table>
				<tr>
					<td id="title">Number of Items</td>
					<td>1<td>
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
	</div>

	<style>
	
	</style>
</body>

</html>
