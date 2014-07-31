<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$content="";


//check if cookie is set and set session
if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}
//if user is not logged in, give an error message
if(empty($_SESSION['username'])){
	$content.="<p>Sorry, you must login to view your profile</p>";
	$content.="<p>Click <a href='login.php'> here</a> to login</p>";
}

$customer_ID = $_GET['customer_ID'];


$query = "SELECT * FROM tbl_customers WHERE customer_ID = $customer_ID";
$result = mysql_query($query);
if($result){
	while($rows = mysql_fetch_array($result)){
		$f_name = $rows['f_name'];
		$l_name = $rows['l_name'];
		$email = $rows['email'];
		$username = $rows['username'];
		$billing_a = $rows['billing_a'];
		$mailing_a = $rows['mailing_a'];
		$cc_number = $rows['cc_number'];

		$cc_display = substr($cc_number,13,15);

		$content.="
					<div class = 'profile_info'>
						<div><span class='style_info'>First Name: </span><span class='highlight'>" .$f_name. "</span></div>
						<div><span class='style_info'>Last Name: </span><span class='highlight'>" .$l_name. "</span></div>
						<div><span class='style_info'>Email: </span><span class='highlight'>" .$email. "</span></div>
						<div><span class='style_info'>Username: </span><span class='highlight'>" .$username. "</span></div>
						<div class = 'address'><span class='style_info'>Billing Address: </span><span class='highlight'>" .$billing_a. " </span></div>
						<div class = 'address'><span class='style_info'>Mailing Address: </span><span class='highlight'>" .$mailing_a. " </span></div>
						<p>Default Credit Card (last 3 dig):" .$cc_display. "</p>
						<form name='edit' action='editInfo.php' method='get'>
							<input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
							<input type = 'hidden' name = 'f_name' value='$f_name'></input>
							<input type='submit' value='Edit your information'></input>
						</form>
					</div>

		";

	}
}

$msg="<h2>Hi " .$f_name. "! Welcome to your profile.</h2>";
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
	<?php echo $msg ?>	
	<?php echo $content ?>
	</div>
</body>
</html>
