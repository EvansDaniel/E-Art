<?php 

  error_reporting(E_ALL);

    header('Content-Type: application/json');
  
    $uploaded = array();
  
    if(!empty($_FILES['file']['name'][0])) {
  
      // loops through the files that have been sent by AJAX request
      foreach($_FILES['file']['name'] as $position => $name) {
    
         echo $name, '<br>';
    
          $destination = "/home/evansdb0/html/" . "uploads/" . $name;
        
          if(move_uploaded_file($_FILES['file']['tmp_name'][$position], $destination)) {
            $uploaded[] = array(
               'name' => $name,
               'file' => 'uploads/' . $name
            );
          }
       }
  
    }
  
    echo json_encode($uploaded); 


?>
