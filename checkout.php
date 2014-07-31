<?php
ob_start();
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$content.="";
$customer_ID = $_GET['customer_ID'];
$order_price = $_GET['order_price'];
$content.="<h2>Order Total: $$order_price</h2>";

//check if cookie is set and set session
if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}
//if user is not logged in, give an error message
if(empty($_SESSION['username'])){
	$content.="<p>Sorry, this page has expired</p>";
	$content.="<p>Click <a href='login.php'> here</a> to login</p>";
}

$content.='
	<form name="place_order" cladd ="place_order" action="placeOrder.php" method="get">
		<fieldset>
		<legend>Enter credit card and mailing information</legend>
		<label for="cc_number">Credit Card Number*: </label> <br/>
		<input type="text" name="cc_number" id="cc_number" maxlength="16" required/><br/>
		<label for="cc_code">Security Code*: </label><br/>
		<input type="text" name="cc_code" id="cc_code" maxlength="4" required/><br/>
		<label for="cc_exp">Expiration Date (mm/dd/yyy)*: </label><br/>
		<input type="text" name="cc_exp" id="cc_exp" maxlength="9" required/><br/>
		<label for="address" >Mailing Address: </label><br/>
		<input type="text" name="address" id="address" maxlength="200" required/><br/>
		<input type = "hidden" name = "customer_ID" value='.$customer_ID.'></input>
		<input type = "hidden" name = "order_price" value='.$order_price.'></input>
		<input type="submit" value="Place Order"></input>
		</fieldset>
	</form>';

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
