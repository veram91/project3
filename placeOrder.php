<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
//ob_start();
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$customer_ID = $_GET['customer_ID'];
$order_price = $_GET['order_price'];
$content="";
$error="";

//check if cookie is set and set session
if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}
//if user is not logged in, give an error message
if(empty($_SESSION['username'])){
	$content.="<p>Sorry, this page has expired</p>";
	$content.="<p>Click <a href='login.php'> here</a> to login</p>";
}



function inStock($id){
	global $error;
	global $content;


$query = "SELECT * FROM tbl_cart WHERE customer_ID = $id AND expired=0";
$result = mysql_query($query);

if($result){
	while($rows = mysql_fetch_array($result)){
		$product_ID = $rows['product_ID'];
		$quantity = $rows['quantity'];
			$q = "SELECT * FROM tbl_inventory WHERE product_ID = $product_ID";
			$res = mysql_query($q);
			$row = mysql_fetch_array($res);
			$amount_available = $row['quantity'];
			$product_name = $row['name'];

			$formatted_a = number_format($amount_available,2);
			$formatted_q = number_format($quantity,2);

				if($formatted_a < $formatted_q){
				$error.= "<p>".$product_name.": There are not enough items in stock. Please Remove from cart</p>";
				$error .= "<p>Ammount available in stock: ".$amount_available."</p>";
				$error .= "<p>Amount in Cart: ".$quantity."</p>";
				$content.= "Click <a href='shoppingCart.php?customer_ID=$id'> here</a> to return to your shopping Cart";
				return false;
				
			}

	}//end while
}//end if
return true;
}//end function



$availability = instock($customer_ID);
if($availability){
	//update tbl_orders. 
mysql_query("INSERT INTO tbl_orders (customer_ID, price, date)
			VALUES ($customer_ID, $order_price, now())") or die(mysql_error());

//NEED TO ADD ANOTHER CONDITION BCS A CUSTOMER CAN HAVE SEVERAL ORDER IN TBL_ORDERS
$query = "SELECT order_ID FROM tbl_orders WHERE customer_ID = $customer_ID AND price = $order_price";
$result = mysql_query($query);
if($result){
	$row = mysql_fetch_array($result);
	$order_ID = $row['order_ID'];
}


//update tbl_order_items
$query = "SELECT * FROM tbl_cart WHERE customer_ID = $customer_ID AND expired=0";
$result = mysql_query($query);
if($result){
	while($rows = mysql_fetch_array($result)){
		$product_ID = $rows['product_ID'];
		$quantity = $rows['quantity'];


			$q = "SELECT * FROM tbl_inventory WHERE product_ID = $product_ID";
			$res = mysql_query($q);
			$row = mysql_fetch_array($res);
			$amount_available = $row['quantity'];
			$product_name = $row['name'];


				mysql_query("INSERT INTO tbl_order_items (order_ID, product_ID, quantity)
					VALUES ($order_ID, $product_ID, $quantity)") or die(mysql_error());


				$newStockValue = $amount_available - $quantity;
				mysql_query("UPDATE tbl_inventory SET quantity = $newStockValue 
					WHERE product_ID = $product_ID");
				


			

	
	}
	if($availability){
	mysql_query("UPDATE tbl_cart SET expired = 1
			WHERE customer_ID = $customer_ID");

	$content.="<p>Your order was placed successfully!</p>";
	$content.="<p>A confirmation email has been sent to you.</p>";
}
	else{

				$query = "DELETE FROM tbl_orders WHERE order_ID=$order_ID";
				mysql_query($query);
	}
}

}

ob_end_flush();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="cssprueba.css"></link>
</head>
<body>
	<div class='header'>EcomSite</div>
<div class="enclosing">
	
	
	<div class='display_menu'>
		<?php echo $menu ?>
	</div>
	<div class="content">
		<div class="display_errors">
			<?php echo $error ?>
		</div>
	<?php echo $content ?>
	</div>
</div>
</body>
</html>
