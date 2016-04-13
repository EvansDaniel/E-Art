<!DOCTYPE html>

<?php 
  
  session_start();
  error_reporting(E_ALL);
?>
<html>
  <head> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../styles/dropZone.css">
    <link rel="stylesheet" href="../../styles/aweLabels.css">
  </head>
  <body>
  <?php 
    require_once('../../classes/Item.php');
    $item = new Item();
  ?>

<form class="awesome-form">
  
  <div class="input-group">
    <input type="text" id="name">
    <label>Name of Art</label>
  </div>
  
  <div class="input-group">
    <input type="text" id="price">
    <label>Price</label>
  </div>
  
  <!-- This button must be name=submit or else the the php won't work -->
  <input type="submit">
</form>
    
      
    </script>
    <div id="uploads"></div>
    <div class="dropzone" id="dropzone">Drop files image files here to upload</div>
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
    
    <script src="../../scripts/jquery-1.12.3.min.js"></script>
    <script>
    
      $(function(){
  
  $('.awesome-form .input-group input').focusout(function(){
    
    var text_val = $(this).val();
    
    if(text_val === "") {
      
      $(this).removeClass('has-value');
      
    } else {
      
      $(this).addClass('has-value');
      
    }
    
  });
  
});
</script>
  </body>
</html>
