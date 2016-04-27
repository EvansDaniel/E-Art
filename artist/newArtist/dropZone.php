<?php

    session_start();
?>
<html>
	<head>
		<link rel="stylesheet" href="../../styles/dropZone.css">
		<link rel="stylesheet" type="text/css" href="../../styles/awesomeInputs.css">
		<script src="../../scripts/jquery-1.12.3.min.js"></script>
	</head>

	<body>
<div id="uploads"></div>
    
   <div class="dropzone" id="dropzone">Drop files here to upload</div>


<script>
      (function() {
        
         var dropzone = document.getElementById('dropzone');
         
         var upload = function(files)  {
         
           var formData = new FormData(), 
               xhr = new XMLHttpRequest(),
               x;
           
           // loops through every file dropped on drop zone    
           for( x=0; x<files.length; x = x + 1) {
             
             formData.append('file[]', files[x]);
             
           }
           // upload.php will output a json string if the files are successfully uploaded
           xhr.onload = function() {
              var data = this.responseText;
              //console.log(data);
           }
           
           xhr.open('post', 'uploadPic.php');
           xhr.send(formData);
         }
         
         dropzone.ondrop = function(event) {
           event.preventDefault();
           this.className = 'dropzone';
           
           upload(event.dataTransfer.files);
           
           return false;
         }
         
         
         // changes the class name of dropzone when you drag over
         dropzone.ondragover = function() {
           
           this.className = 'dropzone dragover';         
           return false;
         }
         // changes the class name of dropzone when user leaves that area
         dropzone.ondragleave = function() {
           
           this.className = 'dropzone';         
           return false;
         }       
         
      }());
    
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