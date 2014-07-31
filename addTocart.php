<?php
ob_start();
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');


//check if cookie is set and set session
if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}
//if user is not logged in, give an error message
if(empty($_SESSION['username'])){
	$content.="<p>Sorry, you must login to add an item to your cart</p>";
	$content.="<p>Click <a href='login.php'> here</a> to login</p>";
}
$customer_ID = $_POST['customer_ID'];
$product_ID = $_POST['product_ID'];
$menu_category = $_POST['menu_category'];

//check if the item is already in the cart
$query = "SELECT * FROM tbl_cart WHERE customer_ID = $customer_ID AND product_ID = $product_ID AND expired = 0";
$result = mysql_query($query);

if($result){
	$row = mysql_fetch_array($result);
	if(!empty($row)){
		$quantity = $row['quantity'];
		$quantity++;

		mysql_query("UPDATE tbl_cart SET quantity = $quantity 
			WHERE customer_ID = $customer_ID AND product_ID = $product_ID");
	}

	else{
		mysql_query("INSERT INTO tbl_cart (cart_ID, customer_ID, product_ID, date_added)
		VALUES ($customer_ID, $customer_ID, $product_ID, now())") or die(mysql_error());

	}
	
}

if($menu_category!=""){
	$redirect = "Location: index.php?customer_ID=".$customer_ID."&category=".$menu_category;
	header($redirect);
}
else{
	$redirect = "Location: index.php?customer_ID=".$customer_ID;
	header($redirect);

}
ob_end_flush();
?>
