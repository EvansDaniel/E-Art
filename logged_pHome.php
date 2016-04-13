
<?php
  session_start();
?>
<html lang="en-US">

<head>
  <title>Life in Haiti</title>
  <link rel="stylesheet" type="text/css" href="styles/pHome.css">
   <meta charset="UTF-8">

</head>
   
<body class="body" id="body" onload="changeImage(); translate()">
    
    

<!--<header class="header"> -->

<nav id="navs">

  <ul>
  
    <li id="nav1">
      <div class="icon"><a class="haiti" title="This will take you back to Haiti."
      href="pHome.php">Haiti</a></div>
    </li>
    
    <li id="nav2"><a href="https://www.flickr.com/explore">Explore</a>
      <ul>
        <li><a href="https://www.flickr.com/explore">Recent Photos</a></div>Daniel Evans
        <li><a href="https://www.flickr.com/vr">Flickr VR</a></li>
        <li><a href="https://www.flickr.com/commons">The Commons</a></li>
        <li><a href="https://www.flickr.com/20under20">20under20</a></li>
        <li><a href="https://www.flickr.com/photos/flickr/galleries">Galleries</a></li>
        <li><a href="https://www.flickr.com/map">World Map</a></li>
        <li><a href="https://www.flickr.com/services/">App Garden</a></li>
        <li><a href="https://www.flickr.com/cameras">Camera Finder</a></li>
        <li><a href="https://www.flickr.com/photos/flickr/albums/72157639868074114/">
        The Weekly Finder</a></li>
        <li><a href="https://blog.flickr.net/en">Flickr Blog</a></li>
      </ul>                      
    </li>
    
    <li id="nav3"><a href="https://www.flickr.com/create">Create</a></li>
    </li>
    
    <li id="nav4">
    </li>
    <li id="nav5"><form><input type="search"  class="Search" method="get" name="Search"
        placeholder="Photos, people, places..."></form>
    </li>
    
    <li id="nav6" style="margin-left:15px">
      <a href="upload.php">Upload
      </a>
    </li>
    
    <li id="nav7">
      <a href="../..i.php?logout">Log out
      </a>
    </li>
    
    <li class="liSignIn" id="nav8"> 
      <!-- make name appear top right --> 
      <a href=""><?php $fName = $_SESSION['firstName']; 
                       $lName = $_SESSION['lastName']; 
                       echo $fName ." ". $lName;
                 ?>
      </a>
    </li>   
  </ul>
</nav>

<div id="HomeImg1" position= "relative">
  <img id ="hmImg" src="images/21H.jpg"   width=100% height=100% position= "absolute">
  <img id="img1"   src="images/blue.png"  width=25px>
  <img id="img2"   src="images/white3.gif" width=25px>
  <img id="img3"   src="images/white3.gif" width=25px>
  <img id="img4"   src="images/white3.gif" width=25px>
  <img id="img5"   src="images/white3.gif" width=25px>
  <img id="img6"   src="images/white3.gif" width=25px>
  <img id="img7"   src="images/white3.gif" width=25px>
  <img id="img8"   src="images/white3.gif" width=25px>
</div><!--
-->
<div id="HomeImg2"><img id="secDiv" src="images/homeImg1" width=100%>

<span id="butt"><button id="inspire" onClick="amaze()">Electrify me</span>



<!---------------------------------  Danny's Scripts  ------------------------------------------->

<!-- we need to separate logged_pHome.php scripts from pHome.php scripts -->

<script>
// leave 1st line while working on pop up, then erase.. its in the sign up onclick    
function signUp(eleID,newClassName) {
      
      document.getElementById(eleID).className = newClassName;
      
      document.getElementById('fade').style.display='block';
      document.getElementById('fade').style.display='block';
      document.getElementById('body').style.overflow='hidden';
      
      window.scrollTo(0,0);
}
function signUp(eleID,newClassName) {
      
      document.getElementById(eleID).className = newClassName;
      
      document.getElementById('fade').style.display='hidden';
      document.getElementById('body').style.overflow='visible';
      
      window.scrollTo(0,0);
}
</script>

<!---------------------------------  Blaise's Scripts ------------------------------------------->

<script>

  //accessing the width and height of the screen  
  var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth,
    y = w.innerHeight|| e.clientHeight|| g.clientHeight;


  // half the screen width
  var width= (x/2) - 100;   

  // the 8 moving images
  var images = ["images/21H.jpg" 
               ,"images/95H.jpg"
               , "images/257H.jpg"
               , "images/274H.jpg"
               ,"images/285H.jpg"
               , "images/31H.jpg"
               , "images/138H.jpg"
               ,"images/187H.jpg"];

  
  // moving all small white and blue icons in the center
  function translate(){ 
    for ( var i=0; i<ids.length; i++){
      if (x<400) {
        document.getElementById(ids[i]).setAttribute
        ("style", "transform: translate("+ 3*width +"px, -100px); position:absolute ; z-index: 1;");
        width +=35;
      }
      else if(x<700 && x >= 400) {
        document.getElementById(ids[i]).setAttribute
        ("style", "transform: translate("+ 1.5*width +"px, -100px); position:absolute ; z-index: 1;");
        width +=35;
      }
      else if (x>=800) {
        document.getElementById(ids[i]).setAttribute
        ("style", "transform: translate("+ width +"px, -100px); position:absolute ; z-index: 1;");
        width +=35;
      }
   }
  }
  // inspire me
  var cnt= 0;
  var button = document.getElementById("inspire");
  button.setAttribute("style", "transform: translate("+ width +"px, -100px); position:absolute ; z-index: 1;"); 
  function amaze(){
    var inspire = document.getElementById("secDiv");
    inspire.setAttribute('src', images[cnt]);
    cnt++;
    if (cnt == 8){
      cnt=0;
    }   
  }

  // white and blue images their tag ids
  var im = ["images/blue.png","images/white3.gif"];
  var ids = [ "img1", "img2", "img3", "img4", "img5", "img6", "img7", "img8"];
  
  
  // function that changes the images and the white and blue icons
  var count = 0;
  function image(){
  
    // image changing
    var div = document.getElementById("hmImg");
    div.setAttribute('src',images[count]);
  
    // white and blue icon changing
    document.getElementById(ids[count]).setAttribute('src', im[0]);
    if (count != 0)
      document.getElementById(ids[count-1]).setAttribute('src', im[1]);
    if (count == 0)
      document.getElementById(ids[7]).setAttribute('src', im[1]);
      
    count++;
    
    if (count == images.length){
      count = 0;
    }
}

  // the image fading function
  var op =1;
  function opac(){
    var div = document.getElementById("hmImg");
    div.style.display = "block";
    div.style.opacity = op;
    op--;
    if (op == 0){
      image();
      op=1;
      clearInterval(interval);
    }
  }

  // the interval function to fade
  var interval;
  function fade(){
    interval = setInterval(opac, 50);
  }

  // the interval to chenge the images and Icon
  function changeImage(){
    setInterval(fade, 2500);
  }
  
 
 
 
/*
var content1 = '<span><div id = "author1"> <p>Photo by Маthew Тасеr </p> </div></span>'+
                     '<style>  #author1:{ display:  block; width: 100px; }'+
                     '</stlye>';
                     
var content2 = '<span><div id = "author2"> <p>Photo by Маthew Тасer </p> </div></span>'+
                     '<style>  #author1:{ display:  block; width: 100px; }'+
                     '</stlye>';
var div1 = document.getElementById("HomeImg1");
var div2= document.getElementById("HomeImg2");
var bool1= true;
var bool2 = true;
var counter= 0;
var counter2= 0;

 function addSpan( ){
  if(bool1 && counter==0){
  div1.innerHTML += content1;
  bool1= !bool1;
  counter++ ;
   }
  }
 function remSpan(){
  if (!bool1 && counter == 1){
    
     var el = document.getElementById("author1");
     el.parentNode.removeChild(el);
     counter = 0;
     bool1 = !bool1;
   }
 }
 

div1.addEventListener("mouseover",addSpan);
div1.addEventListener("mouseout", remSpan);

/* div1.addEventListener("click", );
function addSpan2( ){
  if(bool2 && counter2==0){
  div2.innerHTML += content2;
  bool1= !bool1;
  counter++ ;
   }
  }
 
function remSpan2(){
  if (!bool2 && counter2 == 1){
    
     var el = document.getElementById("author2");
     el.parentNode.removeChild(el);
     counter2 = 0;
     bool2 = !bool2;
   }
 }
div2.addEventListener("mouseover", addSpan2);
div2.addEventListener("mouseout", remSpan2);

div2.addEventListener("click", );

*/

</script>



</body>
 
</html>


















