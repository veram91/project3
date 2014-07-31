<?php
ob_start();
session_start();
include('menu.php');
include('connect.php');
mysql_select_db('ecom_db');
$content="";


if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}



if(!empty($_POST['username'])){
	//test login against database
	$username = $_POST['username'];
	$password = $_POST['pass'];
	

	$mysql_login_info = mysql_query("SELECT password FROM tbl_customers where username='$username'");
	if($mysql_login_info){
	    $row=mysql_fetch_array($mysql_login_info);
		$hash=$row['password'];
		if($hash===crypt($password, $hash)){
			$hour = time() + 3600;
			if(!empty($_POST['persist'])){
				setcookie('username', $username, $hour);
			}
			$_SESSION['username']=$username;
		}else{
		  $error="wrong password";
		}
	}else{
	  $error="Invalid Login";	
	}
}


$username = $_POST['username'];
$get_ID = "SELECT customer_ID FROM tbl_customers WHERE username= '$username'";
$result = mysql_query($get_ID);
if($result){
	$row = mysql_fetch_array($result);
	$customer_ID = $row['customer_ID'];
}


if(!empty($_SESSION['username'])){
	//$customer_ID=$_GET['customer_ID'];
	$link = "index.php?customer_ID=".$customer_ID;
	header("Location: $link");
	/*$content.="You are already logged in as " .$_SESSION['username']. 
			" Click <a href='$link'> here </a> to go to the Home Page<br/>
			Click <a href='logout.php'> here </a> to logout";*/

}

else{
	$content.='
				<!--Login Form-->
	<form id="login_form" method="post" action="login.php">
	<fieldset>
		<legend><h3>Login</h3></Legend>
		<div class="formcontent">
		<label for="username">Username: </label>
		<input class="floaty" type="text" name="username" size="10" required><br/>
		<label for="pass">Password:   </label>
		<input class="floaty" type="password" name="pass" size="10" required><br/>
		<label> Stay logged in?: </label>
		<input class="floaty" type="checkbox" name="persist"></input>
		<input class="floaty" type="submit" value="Submit">
		<input class="floaty" type = "reset" value = "Reset">
		<p class="floaty"><a href="register.php"> Create New Account </a> </br><?php echo $error ?></p>
		 </div>
	</fieldset>	
	</form>';

}
ob_end_flush();
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
