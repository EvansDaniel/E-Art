<!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="pragma" content="no-cache">
		<title><?php session_start(); echo $_SESSION['fName'] . "'s Store"; ?></title>
		<script src="../../scripts/jquery-1.12.3.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../../styles/page.css?" <?php 

           echo time();


		?>>
		<link rel="stylesheet" type="text/css" href="../../styles/nav.css?" <?php 

           echo time();

		?>>
		<link rel="stylesheet" type="text/css" href=
		<?php

		session_start();
		

        // if the person isn't logged in, take them back to home page 
	    if($_SESSION['user_logged_in'] != 1) {
			
			header('Location: http://hive.sewanee.edu/evansdb0/eArt/pHome.php');
		}  

		  // load the css file for the products page for this user
		  echo '"';  // gotta get those quotes for href

          echo "../../../"

  	      . $_SESSION['userName'] ."/"

  	      . $_SESSION['userName'] .".css?".time();   

  	      // time() prevents caching because it changes the name
  	      // the get request header each time the browser loads the page


  	      echo '"';  // gotta get those quotes for href

		?>>
		<script>
          /*



          */
          <?php 
          // outputs the shit blaise needs 
            //require_once('createThumbnail.php');

            //getProduct($_SESSION['artist_id']);

          ?> 


			var images =["../../images/21H.jpg", "../../images/138H.jpg", "../../images/187H.jpg"];
			var arrIm=[];
			function preload(){
	  			for (i=0; i<images.length ; i++){
		 			arrIm[i] =  new Image();
		 			arrIm[i].src = images[i];
	  			}
	  		}
    
 			preload();
 			function el(i){
				return document.getElementById(i);
			}
 			$(document).ready(function() {

 				var one= el("one");
 				var two=el("two");
 				var three = el("three");
 				var four = el("four");

 				showHide('#backM',1 );
 				showHide('#colM', 3);
 				showHide('#disM', 4);
 				showHide('#itemM', 2);

 				one=one.getElementsByTagName("img");
 				two=two.getElementsByTagName("img");
 				three=three.getElementsByTagName("img");
 				four=four.getElementsByTagName("img");
				
 				function source(image, div){
 					for(i=0; i<div.length; i++){
 						el("");

 					}
 				} 
			});


			function showDiv(arrow, element){
				var div = el(element);
				var style = "height:100px";
			}

			$("#dArr").click(function () {
               $("#backM").show( 1000 );
            });

			
			var count0=1;
			var count1=1;
			var count2=1;
			var count3=1;
			

			function showHide(divId, number){
				var divId = divId;
				if (number==1){
					if (count0==1){
						$(divId).hide(1000);
						count0=0;
						return;
					}
					if (count0==0){
						$(divId).show(1000);
						count0=1;
						return;
					}
				}
				if(number==2){
				  if (count1==1){
						$(divId).hide(1000);
						count1=0;
						return;
					}
					if (count1==0){
						$(divId).show(1000);
						count1=1;
						return;
					}
				}
				if(number==3){
					if (count2==1){
						$(divId).hide(1000);
						count=0;
						return;
					}
					if (count2==0){
						$(divId).show(1000);
						count2=1;
						return;
					}
				}
				if(number==4){
					if (count3==1){
						$(divId).hide(1000);
						count=0;
						return;
					}
					if (count3==0){
						$(divId).show(1000);
						count3=1;
						return;
					}
				}
			}
			
			function apply1(){
				var r= el("rgb").value;
				var g= el("rgb1").value;
				var b= el("rgb2").value;
				var o= el("rgb3").value;
				r = parseInt(r,10);
				g = parseInt(g,10);
				b = parseInt(b,10);
				o = parseFloat(o);
				var link = el("link").value;
				if(!isNaN(r) && !isNaN(g) && !isNaN(b) && !isNaN(o)){
					el("page").setAttribute("style", "background: rgba("+r+","+g+","+b+","+o+")");
					return "#page {background: rgba("+r+","+g+","+b+","+o+")}\n";
				}
				else if(link.length >0){
					el("page").setAttribute("style", "background:url("+link+");");
					return "#page {background: url("+link+");}\n";
				}
				return "";
			}
			function apply2(){
				var r= el("hrgb").value;
				var g= el("hrgb1").value;
				var b= el("hrgb2").value;
				var o= el("hrgb3").value;
				r = parseInt(r,10);
				g = parseInt(g,10);
				b = parseInt(b,10);
				o = parseFloat(o);
				//alert(r);
				if(!isNaN(r) && !isNaN(g) && !isNaN(b) && !isNaN(o)){
					$("#page h1").css( "color"," rgba("+r+","+g+","+b+","+o+")");
				  return "#page h1{ color: rgba("+r+","+g+","+b+","+o+")} \n ";
				}
				return "";
			}
			function apply3(){
				var r= el("crgb").value;
				var g= el("crgb1").value;
				var b= el("crgb2").value;
				var o= el("crgb3").value;
				r = parseInt(r,10);
				g = parseInt(g,10);
				b = parseInt(b,10);
				o = parseFloat(o);
				if(!isNaN(r) && !isNaN(g) && !isNaN(b) && !isNaN(o)){
					$("tr").css( "background"," rgba("+r+","+g+","+b+","+o+")");
					$("td button").css( "background"," rgba("+r+","+g+","+b+","+o+")");
					$("td button").css( "border","none");
					$("#leftArrow").css( "background"," rgba("+r+","+g+","+b+","+o+")");
					$("#rightArrow").css( "background"," rgba("+r+","+g+","+b+","+o+")");
					r=r+10;
					b=b+10;
					g=g+10;
					$("table tr td img").css("border", " rgba("+r+","+g+","+b+","+o+")");
					return "table tr td img{border: rgba("+r+","+g+","+b+","+o+")}\n";

				
				}
				return "";
			}

	function apply4(){

		var change;
		change = apply3();
		change += apply2();
		change += apply1();

		fd = new FormData();
		//alert(change);

        fd.append('data', change);
        request = new XMLHttpRequest();
        request.open("POST"
        , "http://hive.sewanee.edu/evansdb0/eArt/artist/newArtist/saveCSSFile.php");
        request.send(fd);

        request.onreadystatechange = function() {

        	if (request.readyState === 4) {
            	if (request.status === 200) {
                	// OK
                	//alert('response: '+request.responseText);
                    // here you can use the result (cli.responseText)
            	} else {
                    // not OK
                    alert('failure!');
                    alert(request.status);
            	}
        	}
        };	   
	}

		</script>
	</head>

	<body>
		<div id="container">

			<?php 

			  // load html for nav bar 
              require_once("navBar.php");
              
			?>


			<div id="settings">
				<ul>
					<li id="custom"> Customize your products page


					<br><hr></li>
					<li id="background"><p id="back">Background Color</p><img src="../../images/background.png"><button onclick="showHide('#backM',1)"><img id="dArr" src="http://cliparts.co/cliparts/ziX/5yr/ziX5yr5kT.png"></button>
						
						<div id="backM">
							<br>
							<form>
  								Red:<br>
  									<input id="rgb" type="text" name="red" 
  									placeholder="(0-255)" style="width:70px;"><br><br>
 								Blue:<br>
  									<input id="rgb1" type="text" name="blue"
  									placeholder="(0-255)" style="width:70px;"><br><br>
  								Green:<br>
  									<input id="rgb2" type="text" name="green"
  									placeholder="(0-255)" style="width:70px;"><br><br>
  								Opacity:<br>
  									<input id="rgb3" type="text" name="opacity"
  									placeholder="(0-1)" style="width:70px;">
							</form><br>
							or
							Set Backround w/ Image Link<br>
							<form>
  									<input type="text" name="link" id="link"
  									placeholder="https://..."><br>
  							</form><br>
  							<button id="apply1" onClick="apply1 ()"
  							>APPLY</button>
						</div>

					<hr></li>

					<li id="items"><p id="itm">Canvas Color</p><img src="../../images/numOfIt.png"><button onclick="showHide('#itemM',2)"><img id="dArr1" src="http://cliparts.co/cliparts/ziX/5yr/ziX5yr5kT.png"></button>
						<div id="itemM">
							<form>
  								<form>
								<br>
  								Red:<br>
  									<input id="crgb" type="text" name="red" 
  									placeholder="(0-255)" style="width:70px;"><br><br>
 								Blue:<br>
  									<input id="crgb1" type="text" name="blue"
  									placeholder="(0-255)" style="width:70px;"><br><br>
  								Green:<br>
  									<input id="crgb2" type="text" name="green"
  									placeholder="(0-255)" style="width:70px;"><br><br>
  								Opacity:<br>
  									<input id="crgb3" type="text" name="opacity"
  									placeholder="(0-1)" style="width:70px;">
								</form><br>
							
  							<button id="apply3" onClick="apply3()">APPLY</butto>
  							</form>
						</div>

					<hr></li>
					
					<li id="color"><p id="clr">Text Colors</p><img src="../../images/color.png"><button onclick="showHide('#colM',2)"><img id="dArr2" src="http://cliparts.co/cliparts/ziX/5yr/ziX5yr5kT.png"></button>
						<div id="colM">
							<form>
								<br>
  								Red:<br>
  									<input id="hrgb" type="text" name="red" 
  									placeholder="(0-255)" style="width:70px;"><br><br>
 								Blue:<br>
  									<input id="hrgb1" type="text" name="blue"
  									placeholder="(0-255)" style="width:70px;"><br><br>
  								Green:<br>
  									<input id="hrgb2" type="text" name="green"
  									placeholder="(0-255)" style="width:70px;"><br><br>
  								Opacity:<br>
  									<input id="hrgb3" type="text" name="opacity"
  									placeholder="(0-1)" style="width:70px;">
							</form><br>
							
  							<button id="apply2" onClick="apply2()">APPLY</button>
  							<button id="apply4" onClick="apply4()">APPLY</butto>



						</div>
					<br>

				</ul>
				
			</div>
			<div "content">
				<div id="page">

						

					<div id="one">
						<h1 class="text">Photography</h1>
						

					    <table>
							<tr>
								<td><button id="leftArrow"><img src="http://www.clker.com/cliparts/Z/n/k/Z/y/j/left-arrow-gray-hi.png" ></button></td>


 <!--<td><img src='http://hive.sewanee.edu/evansdb0/evansdb0/Space_Wars.jpg' width="500" height="190"><br>Space Wars for $250</td>
 <td><img src='http://hive.sewanee.edu/evansdb0/evansdb0/City.jpg'><br>City for $200</td>-->


<?php
$PHOTOGRAPHY = 1; 
getProduct($_SESSION['artist_id'],$PHOTOGRAPHY);
print_r($_SESSION);
?>
								<td><button id="rightArrow"><img src="https://www.zermattresort.com/wp-content/uploads/2015/04/arrowright1.png"></button></td>

							</tr>
						</table>

					</div>

					

					<div id="two">
						<h1 class="text">Painting</h1>
						<table>
							<tr>
								<td><button id="leftArrow"><img src="http://www.clker.com/cliparts/Z/n/k/Z/y/j/left-arrow-gray-hi.png"></button></td>
<?php
$PAINTING = 2;
getProduct($_SESSION['artist_id'],$PAINTING);
?>
								<td><button id="rightArrow"><img src="https://www.zermattresort.com/wp-content/uploads/2015/04/arrowright1.png"></button></td>
							</tr>
						</table>
					</div>

				    
					
						
						
						<div id="three">
							<h1 class="text">Sculpture</h1>
							<table>
								<tr>
									<td><button id="leftArrow"><img src="http://www.clker.com/cliparts/Z/n/k/Z/y/j/left-arrow-gray-hi.png"></button></td>
<?php
$SCULPTURES = 3;
getProduct($_SESSION['artist_id'],$SCULPTURES);
?>
									<td><button id="rightArrow"><img src="https://www.zermattresort.com/wp-content/uploads/2015/04/arrowright1.png"></button></td>
								</tr>
							</table>
						</div>
					    
					
					
						
						
						<div id="four">
							<h1 class="text">Films and Videos</h1>
							<table>
								<tr>
									<td><button id="leftArrow"><img src="http://www.clker.com/cliparts/Z/n/k/Z/y/j/left-arrow-gray-hi.png"></button></td>
<?php
$VIDEOS = 4;
getProduct($_SESSION['artist_id'],$VIDEOS);
?>
									<td><button id="rightArrow"><img src="https://www.zermattresort.com/wp-content/uploads/2015/04/arrowright1.png"></button></td>
								<tr>
							<table>
						</div>				
				</div>	
			</div>
		</div>
	<style>
					body,html {
  						margin:0;
  						padding:0;
  						background: rgba(0, 26, 46, 1);
					}
					#rgb, #rgb1, #rgb2, #rgb3,#crgb, #crgb1, #crgb2, #crgb3,#hrgb, #hrgb1, #hrgb2, #hrgb3{
						width: 40px;
					}
					#link{
						width: 120px;
					}
					#container{
						
						display:flex;
						
						
					}
					#content{
						order:1;

						
						
					}
					#dArr{
						width:25px;
						margin-left: 10px;
					}
					#dArr1{
						width:25px;
						margin-left: 10px;
					}
					#dArr2{
						width:25px;
						margin-left: 10px;
					}
					#dArr3{
						width:25px;
						margin-left: 10px;
					}
					#settings{

						background:rgba(0, 40, 71, 1);				
						color: white;
						order:0;
						width: 165px;
						position: absolute;
						margin-top: 100px;


					}
					#settings ul{
						display: flex;
						flex-direction: column;

					}
					
					ul{
						list-style:none;
					}
					
					img{
						width:50px;
					}
					
					button{
						background: rgba(0, 40, 71, 1);	
						border: 1px solid rgba(0, 40, 71, 1);	
						margin-left: 0.2em;
					}
				</style>
   <div id="editProductForm">
	<form method="post" action=<?php echo $_SERVER['PHP_SELF']; ?>>
       
       <div>
         <input type="text" placeholder="New name of piece" name="name">

         <input type="text" placeholder="New price of piece" name="price">

         <input type="text" placeholder="New description" name="description">

         <!--<input type="text" placeholder="" name="description">-->
       </div>


	</form>
  <div>

<?php

function getProduct($artistId,$categoryId) {

  $con = new mysqli("crisler.sewanee.edu","user","csci","eArt");

  $select = "select name,price,imgPath from products

  where artistId = '$artistId' and categoryId='$categoryId'";

  $r = $con->query($select);
  if(!$r) die($con->error);
  // controls products displayed 
  // all right now
  for($i=0;$i<$r->num_rows;$i++) {

    $r->data_seek($i);
    $temp = $r->fetch_array(MYSQLI_NUM);
    echo "<td><a href='?itemId=$i'><img src='" . $temp[2] . "'></a> <br><p class='text'>" . $temp[0] . " for $" . $temp[1] . "</p></td>";
  }
}
if(isset($_GET['itemId'])) {

	$itemId = $_GET['itemId'];


}

?> 
	</body>

</html>
