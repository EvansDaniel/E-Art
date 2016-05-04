<?php 

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

class shoppingCart {

  private $con = null; 

  private $cartName = null;

  public function __construct($userName) {

  	session_start();

    $userName;

  	$this->databaseConnection();

  	$this->cartName = $userName . "Cart";

  	$q = "create table if not exists " . $this->cartName . 

  	"(

  	  cartId int not null auto_increment primary key,
  	  itemId int
      
  	)";

    // create new table for user cart
    $this->myQ($q); 
    $this->numItems = 0;

  }
  public function addItem($itemId) {

    $num_rows = $this->countRows($this->cartName,true,'itemId',$itemId);
    
    if($num_rows < 1) {
      $q = "insert into " . $this->cartName . 
         
           "(itemId) VALUE(" . $itemId . ")";

      $this->myQ($q);
      header("Location: http://hive.sewanee.edu/evansdb0/eArt/buyer/newBuyer/checkout.php");
    } 
    else {
    	$this->displayMessage("This item is already in your cart.");
    }
  }
  private function myQ($q) {
    
    $r = $this->con->query($q);
    if(!$r) die($this->con->error);
    
    return $r;
  }
  public function removeItem($itemId) {

  	$q  = "delete from " . $this->cartName . " where itemId = '$itemId'";

  	$this->myQ($q); 
    
    // reset auto_increment
  	$aI = $this->countRows($this->cartName);

    echo "<br><br>";

  	// $this->myQ($q);

  }
  public function displayCart() {

    // get count of rows on this table name 
  	$rows = $this->countRows($this->cartName);
    if($rows == 0) {
      echo "<h3>You have nothing in your cart </h3>";
      echo "<a href='http://hive.sewanee.edu/evansdb0/eArt/pHome.php'>

      Back to Home Page</a>";
      return;
    }
    
    $q = "select itemId from " . $this->cartName;
    $res = $this->myQ($q);
    // loop that humber of rows
    for($i = 0; $i<$res->num_rows; $i++) {
      
      // get itemId of products in shopping cart
      $res->data_seek($i);
      $res_arr = $res->fetch_array(MYSQLI_ASSOC); 

      $item = $res_arr['itemId'];
      
      // get the corresponding products detail from products with above itemId 
      $q = "select name, description,imgPath,inStock,productRank,categoryId,price,itemId from products where itemId='$item'"; 
      
      $r = $this->myQ($q);

      $r->data_seek($i);
      $r_arr = $r->fetch_array(MYSQLI_ASSOC);

      if($r_arr['inStock'] === 0) {
      	$this->displayMessage("This item " . $r_arr['name'] . "has recently been sold");
      }
      else {
      	$q = 

      	"select category from category where categoryId='{$r_arr['categoryId']}'";

      	$cat = $this->myQ($q);
        $cat_arr = $cat->fetch_array(MYSQLI_ASSOC);
        // <a href=" . $_SERVER['PHP_SELF']. "?del=1>
        echo "<tr>
			  	<td><img src='{$r_arr['imgPath']}'>
					<p id='category'>{$cat_arr['category']}</p>
					<p id='name'>{$r_arr['name']}</p>
          <input type='hidden' name='delete' value='$item'>
          <form action=" . $_SERVER['PHP_SELF']. " method='post'>
          <button class='mydelete' type='submit' name='submit' value='{$r_arr['itemId']}'>Delete item</button>
          </form>
					</td>
				<td id='prc'>{$r_arr['price']}</td>

			  </tr>"; 
      }  
    } 
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

    $q = "drop table " . $this->cartName;
    
    $this->myQ($q);
  }

  private function displayMessage($m) {

    echo "<p style='color: #a10909'>" . $m . "</p>";
  }
  public function getCartName() {
  	return $this->cartName;
  }

}