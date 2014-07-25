<?php
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$error="";
$content="";

if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];

}

if(!empty($_POST['customer_ID'])){
	$get_customer_ID = $_POST['customer_ID'];
}


//show only the products specified by the category in URL
if(!empty($_GET['category'])){
	$menu_category = $_GET['category'];
	$get_products = "SELECT * FROM tbl_inventory WHERE category= '$menu_category'";
	$result = mysql_query($get_products);
	if($result){
	while($row = mysql_fetch_array($result)){
		$product_ID = $row['product_ID'];
		$name = $row['name'];
		$price = $row['price'];
		$quantity = $row['quantity'];
		//$quantity = number_format($quantity, 2);
		$category = $row['category'];
		$image = $row['image'];
		$description =$row['description'];
		$link = "viewProduct.php?category=".$category;
		$content.= "<div class='display_product'>
						<div class = 'display_product_image'><img src=$image/></div>
						<div class = 'display_product_name'>$name</div>
						<div class = 'display_product_price'>$$price</div>
						<p>$customer_ID</p>
					</div>


		";

		//show add to cart only if it is in the inventory
		if($quantity!=0){
			$content.="
				<form name='addtocart' action='addToCart.php' method='post'>
							 <input type = 'hidden' name = 'product_ID' value='$product_ID'></input>
							 <input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
							  <input type='submit' value='Add to Cart'></input>
						</form>


			";
		}
		//if the quantity is zero, state that the product is sold out
		else{
			$content.="Sold Out";
		}

	}

}
}

//show all products
else{
	$get_products = "SELECT * from tbl_inventory";
$result = mysql_query($get_products);
if($result){
	while($row = mysql_fetch_array($result)){
		$product_ID = $row['product_ID'];
		$name = $row['name'];
		$price = $row['price'];
		$quantity = $row['quantity'];
		//$quantity = number_format($quantity, 2);
		$category = $row['category'];
		$image = $row['image'];
		$description =$row['description'];
		$link = "viewProduct.php?category=".$category;
		$content.= "<div class='display_product'>
						<div class = 'display_product_image'><img src=$image/></div>
						<div class = 'display_product_name'>$name</div>
						<div class = 'display_product_price'>$$price</div>
					</div>




		";

		if($quantity!=0){
			$content.="
				<form name='addtocart' action='addToCart.php' method='post'>
							 <input type = 'hidden' name = 'product_ID' value='$product_ID'></input>
							 <input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
							  <input type='submit' value='Add to Cart'></input>
						</form>


			";
		}
		else{
			$content.="Sold Out";
		}

	}

}


}


?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href=ecom.css></link>
</head>
<body>
	<h1 class="title1">EcomSite...</h1>
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
