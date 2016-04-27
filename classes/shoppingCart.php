<?php 

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

class shoppingCart {

  private $con = null; 

  private $cartName = null;

  private $numItems = null;

  public function __construct($userName) {

  	session_start();

  	$this->databaseConnection();

  	$this->cartName = $userName . "cart";

  	$this->numItems = 0;

  	$q = "create table if not exists " . $this->cartName . 

  	"(

  	  cartId int not null auto_increment primary key,
  	  itemId int
      
  	)";

    // create new table for user cart
    $this->myQ($q); 

  }
  public function addItem($itemId) {

    $num_rows = $this->countRows($this->cartName,true,'itemId',$itemId);
    
    if($num_rows < 1) {
      $q = "insert into " . $this->cartName . 
         
           "(itemId) VALUE(" . $itemId . ")";

      $this->myQ($q);
      $this->numItems++;
    } 
    else {
    	$this->displayMessage("This item is already in your cart.");
    }
  }
  public function removeItem($itemId) {

  	$q  = "delete from " . $this->cartName . " where itemId = '$itemId'";

  	$this->myQ($q); 
    
    // reset auto_increment
  	$aI = $this->countRows($this->cartName);
    
    if($aI > 1) $aI--;

  	$q = "alter table " . $this->cartName . " AUTO_INCREMENT = $aI";

  	$this->myQ($q);
    $this->numItems--;
  }
  public function displayCart($itemId) {
    
    for($i = 0; $i<$this->numItems; $i++) {

      $q = "select name, description, imgPath,inStock,productRank from products where itemId='$itemId'"; 
      
      $r = $this->myQ($q);

      $r->data_seek($i);
      $r_arr = fetch_array(MYSQLI_ASSOC);

      if($r_arr['inStock'] == 0) {
      	$this->displayMessage("This item " . $r_arr['name'] . 
        "has recently been bought.")
      }
      else {
        //
      }
    	
    }
  }

  private function myQ($q) {
    
    $r = $this->con->query($q);
    if(!$r) die($this->con->error);
    
    return $r;
  }
  private function countRows($tableName,$where = false,$col=null,$equals=null) {

  	if(!$where) {
  	  $q = "select itemId from " . $tableName;

  	  $r = $this->myQ($q);

  	  return $r->num_rows;
    }
    else {
      $q = "select itemId from " . $tableName . 

      " where $col='$equals'";

  	  $r = $this->myQ($q);

  	  return $r->num_rows;
    }
  }

  
  private function databaseConnection()
  
  {
    // if connection already exists
    if ($this->con != null) {
      return true;
    } 
    else {
           
      $this->con = new mysqli("crisler.sewanee.edu"
                              ,"user"
                              ,"csci"
                              ,"eArt");  
      // throw error if conn fails
      if ($this->con->connect_error) {
        die($this->con->connect_error); 
        return false;
      }
      return true;
    }
    return false; 
  } // end dbConnection

  public function deleteCart() {

  	$q

    $q = "drop table " . $this->cartName;
    
    $this->myQ($q);
  }

  private function displayMessage($m) {

    echo "<p style='color: #a10909'>" . $m . "</p>";
  }

}