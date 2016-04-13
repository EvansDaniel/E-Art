<?php 

ini_set('display_errors', 1); 
error_reporting(E_ALL);

class Item {


  // connection to the database
  private $conn = null;
  
  // array of links to imgs the artist will upload 
  private $img = null;
  
  // @var  string for the name of the item 
  private $name = null;
  
  // @var string price of the item 
  private $price = null;
  
  public function __construct() {
        
        if(isset($_POST['submit'])) {
        
          $this->addNewItem($_POST['name']
                           ,$_POST['price']);
        }
  }
  public function __destruct() {
    
    // may or may not be used
  }
  private function dbConn()
  {
    // if connection already exists
    if ($this->conn != null) {

      return true;
    } 
    else {
           
      $this->conn = new mysqli('crisler.sewanee.edu'
                              ,'user'
                              ,'csci'
                              ,'artists');  
      // throw error if conn fails
      if ($this->conn->connect_error) die($this->conn->connect_error); 
      return true;
    }
    return false; 
  } // end dbConnection 
  }
  public function addNewItem($name,
                             $price,
                             $pathToImgDir,
                             $description,
                             $artistId) 
  {
    // the id of the item is just going to be the auto_increment id 
    $query = "insert into items(name, price, pathToImgDir, artistId) 
    
              VALUES('$name','$price','$pathToImgDir','$description','$artistId')";
              
    $r = $this->conn->query($query);
    
    var_dump($r);
    
    echo "I think we were successful"; 
  }    
}

?> 

