<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
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
	$content.="<p>Sorry, you must login to view your cart</p>";
	$content.="<p>Click <a href='login.php'> here</a> to login</p>";
}

$customer_ID = $_GET['customer_ID'];

$query = "SELECT * FROM tbl_cart WHERE customer_ID=$customer_ID AND expired=0";
$result = mysql_query($query);
if($result){
	while($rows = mysql_fetch_array($result)){
		if(empty($rows)){//if the cart is empty
		$content.="There are no items on your cart";
	}
	else{//get product name from tbl_inventory and quantity from tbl_cart
		$product_ID = $rows['product_ID'];
			$product_name = mysql_query("SELECT name, price FROM tbl_inventory WHERE product_ID = $product_ID");
			if($product_name){
				$r = mysql_fetch_array($product_name);
				$p_name = $r['name'];
				$p_price = $r['price'];
			}

		$quantity = $rows['quantity'];
		$product_total_price = $p_price*$quantity;
		$cart_total_price+=$p_price*$quantity;
		

		if($quantity>0){
				$content.="
			<div class='display_cart'>
				<p>Product: $p_name</p>
				<p>Amount: $quantity</p>
				<p>Unit Price: $$p_price</p>
				<p>Total: $product_total_price</p>
			</div>
			
		";
		$content.="
	<form name='remove' action='removeItem.php' method='get'>
		<input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
		<input type = 'hidden' name = 'product_ID' value='$product_ID'></input>
		<input type='submit' value='Remove (1) from cart'></input>
	</form>
	<hr/>
	";


		}
	


	}

	}
	if($cart_total_price>0){
			$content.="Order Total: $" .$cart_total_price;
	}
	

	
}

if($cart_total_price>0){
	$content.="
		<form name='checkout' action='checkout.php' method='get'>
			<input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
			<input type = 'hidden' name = 'order_price' value='$cart_total_price'></input>
			<input type='submit' value='Checkout'></input>
		</form>
	";
}

else{
	$content.="There are no items on your cart";
}


?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="cssprueba.css"></link>
</head>
<body>
	<div class='header'>EcomSite</div>
	<div class='display_menu'>
		<?php echo $menu ?>
	</div>
	<div class="content">
		<div class="display_errors">
			<?php echo $error ?>
		</div>
	<?php echo $content ?>
	</div>
</body>
</html>
