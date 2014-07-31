<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
//opcache_reset();
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$error="";
$content="<h1>Items in Stock</h1>";
$continue=true;
$count=0;

if(!empty($_GET['search_query'])){
	$continue=false;
	$search_query = $_GET['search_query'];
	$get_products = "SELECT * FROM tbl_inventory WHERE name LIKE '%$search_query%'";
	$result = mysql_query($get_products);
	if($result){
	while($row = mysql_fetch_array($result)){
		$count++;
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
						<div class = 'display_product_image'><img src='images/$image' width='300' height='300'/></div>
						<div class = 'display_product_name'>$name</div>
						<div class = 'display_product_price'>$$price</div>
					


		";

		//show add to cart only if it is in the inventory
		if($quantity!=0){
			$content.="
				<form name='addtocart' action='addToCart.php' method='post'>
							 <input type = 'hidden' name = 'product_ID' value='$product_ID'></input>
							 <input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
							  <input type='submit' value='Add to Cart'></input>
						</form>
				</div>

			";
		}
		//if the quantity is zero, state that the product is sold out
		else{
			$content.="Sold Out</div>";
		}
		if($count===3){
			$count=0;
			$content.="<div style='clear:both;'></div>";
		}

	}
	$content.="<div style='clear:both;'></div>";

}




}


else if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];

}

if(!empty($_GET['customer_ID'])){
	$customer_ID = $_GET['customer_ID'];
}


//show only the products specified by the category in URL
if(!empty($_GET['category'])){
	if($continue){
		$menu_category = $_GET['category'];
	$get_products = "SELECT * FROM tbl_inventory WHERE category= '$menu_category'";
	$result = mysql_query($get_products);
	if($result){
	while($row = mysql_fetch_array($result)){
		$count++;
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
						<div class = 'display_product_image'><img src='images/$image' width='300' height='300'/></div>
						<div class = 'display_product_name'>$name</div>
						<div class = 'display_product_price'>$$price</div>
					


		";

		//show add to cart only if it is in the inventory
		if($quantity!=0){
			$content.="
				<form name='addtocart' action='addToCart.php' method='post'>
							 <input type = 'hidden' name = 'product_ID' value='$product_ID'></input>
							 <input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
							 <input type = 'hidden' name = 'menu_category' value='$menu_category'></input>
							  <input type='submit' value='Add to Cart'></input>
						</form>
				</div>

			";
		}
		//if the quantity is zero, state that the product is sold out
		else{
			$content.="Sold Out</div>";

		}
		if($count===3){
			$count=0;
			$content.="<div style='clear:both;'></div>";
		}

	}
	$content.="<div style='clear:both;'></div>";

	}
	}
	
}


//show all products
else if($continue){
	$menu_category="";
	$get_products = "SELECT * from tbl_inventory";
$result = mysql_query($get_products);
if($result){
	while($row = mysql_fetch_array($result)){
		$count++;
		$product_ID = $row['product_ID'];
		$name = $row['name'];
		$price = $row['price'];
		$quantity = $row['quantity'];
		//$quantity = number_format($quantity, 2);
		$category = $row['category'];
		$image = $row['image'];
		$description =$row['description'];
		$link = "viewProduct.php?category=".$category;
		$content.= "<div class ='display_product'>
						<div class = 'display_product_image'><img src= 'images/$image' width='300' height='300'/></div>
						<div class = 'display_product_name'>$name</div>
						<div class = 'display_product_price'>$$price</div>
					




		";

		if($quantity!=0){
			$content.="
				<form name='addtocart' action='addToCart.php' method='post'>
							 <input type = 'hidden' name = 'product_ID' value='$product_ID'></input>
							 <input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
							 <input type = 'hidden' name = 'menu_category' value='$menu_category'></input>
							  <input type='submit' value='Add to Cart'></input>
						</form>
			</div>


			";
		}
		else{
			$content.="Sold Out</div>";
		}
		if($count===3){
			$count=0;
			$content.="<div style='clear:both;'></div>";
		}

	}
	$content.="<div style='clear:both;'></div>";

}


}


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
