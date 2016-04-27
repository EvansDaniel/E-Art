<html>
	<head>
    <title>Upload Your Art</title>
		<link rel="stylesheet" href="../../styles/dropZone.css">
    <link rel="stylesheet" type="text/css" href="../../styles/nav.css">
		<script src="../../scripts/jquery-1.12.3.min.js"></script>
	</head>



	<body>
    <nav id="navs">

        <ul>
        
          <li id="nav1">
          <?php 
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


    <div><img id="uploadedPic" src="" height="200px"></div>
    
   <div class="dropzone" id="dropzone">Drop files here to upload</div>

<script>


  // ondrop changes the page when you drop stuff on the drop zone
  // it calls the upload function which is passed the file portion 
  // of whatever was dropped on the drop zone 

  // next we loop through the files that were 'dropped' 
  // and append them to the formData object 

  // we then open a connection with uploadPic.php (the upload handler)
  // and send it the php script 

  (function() {
     
      
      var dropzone = document.getElementById("dropzone");

      var upload = function (files) {
      	
      	 var formData = new FormData(),
      	      xhr = new XMLHttpRequest(),
      	      x;

      	 for(x = 0; x < files.length; x++) {

      	 formData.append("file[]",files[x]);
      	 }
      	 xhr.open('post','uploadPic.php');
      	 xhr.send(formData);


      	xhr.onload = function() {
      	  var data = this.responseText;
          console.log(data);
      	  document.getElementById('uploadedPic').src= data;
          /*var btn = document.createElement("BUTTON");        
          var t = document.createTextNode
          ("Upload successful! Back to your store");       
          btn.appendChild(t);                              
          document.body.appendChild(btn);        

          */
          // the commented stuff is for a button taking them 
          // back to the products page
        };
      }

      dropzone.ondrop = function(e) {
        e.preventDefault();
        this.className = 'dropzone';
        this.innerHTML = "Uploading... "
        upload(e.dataTransfer.files);

      };


      dropzone.ondragover = function() {

        this.className = 'dropzone dragover';
      	return false;
      };

      dropzone.ondragleave = function() {

        this.className = 'dropzone';
      	return false;
      };
  }());



</script>


<!--- UPLOAD WORKS PERFECTLY DO NOT TOUCH THIS CODE -> IT SENDS THE XMLHTTPREQUEST TO testUpload.php