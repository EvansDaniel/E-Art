<?php 

require_once('shoppingCart.php');
require_once('../dbLogin.php');



$cart = new shoppingCart('evansdb0');

$cart->addItem(1);
$cart->addItem(2);


$cart->deleteCart();



?>