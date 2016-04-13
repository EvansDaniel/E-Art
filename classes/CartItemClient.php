<!DOCTYPE html>


<?php 
  session_start();
?>
<html>
  <head> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/dropZone.css">
    <title>Drag and Drop Demo</title>
  </head>
  <body>
  <?php 
    require_once('Item.php');
    $item = new Item();
  ?>
<form> 

</form> 
    <div id="uploads"></div>
    <div class="dropzone" id="dropzone">Drop files here to upload</div>
    <script>
      (function() {
         var dropzone = $('dropzone');
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
              console.log(data);
           }
           xhr.open('post', '../addItemUpload.php');
           xhr.send(formData);
         }
         dropzone.ondrop = function(event) {
           event.preventDefault();
           this.className = 'dropzone';
           //console.log(event.dataTransfer.files);
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
      function $(id) {
        return document.getElementById(id);
      }
    </script>
  </body>
</html>

