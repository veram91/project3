<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
ob_start();
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$content="<h2>Shopping Cart: </h2>";
$cart_total_price=0;
$error="";


//check if cookie is set and set session
if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}
//if user is not logged in, give an error message
if(empty($_SESSION['username'])){
	$content.="<p>Sorry, you must login to access this page</p>";
	$content.="<p>Click <a href='login.php'> here</a> to login</p>";
}

$customer_ID = $_GET['customer_ID'];
$product_ID = $_GET['product_ID'];

$query = "SELECT * FROM tbl_cart WHERE customer_ID=$customer_ID AND product_ID = $product_ID AND expired=0";

$result = mysql_query($query);
if($result){
	while($row = mysql_fetch_array($result)){
		$quantity = $row['quantity'];
		
		if($quantity>0){
			$quantity--;
		}
		


		mysql_query("UPDATE tbl_cart SET quantity = $quantity 
					WHERE product_ID = $product_ID AND customer_ID = $customer_ID AND expired = 0");


	}
}
/*
$query = "SELECT * FROM tbl_inventory WHERE product_ID = $product_ID";

$result = mysql_query($query);
if($result){
	while($row = mysql_fetch_array($result)){
		$quantity = $row['quantity'];
		
		if($quantity>0){
			$quantity--;
		}


	mysql_query("UPDATE tbl_inventory SET quantity = $quantity
					WHERE product_ID = $product_ID");

	}
}
*/
$redirect = "Location: shoppingCart.php?customer_ID=".$customer_ID;
	header($redirect);

ob_end_flush();
?>
