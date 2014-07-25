<?php
	ob_start();
	session_start();
	include('menu.php');
	$errorname="";
	
	if(!empty($_POST['submitted'])){
		include('connect.php');
		mysql_select_db('ecom_db');
		$username = $_POST['username'];
		$password = $_POST['pass'];
		$email = $_POST['email'];
		$password = crypt($password);
		$toggle=true;

		
		$get_users = mysql_query("SELECT * FROM tbl_customers where email = '$email'");
		if($get_users){
			$row=mysql_fetch_array($get_users);
			if(!empty($row)){
				$errorname='Sorry, there is already a customer registered with the email: ' . $email . ' </br>';
				$toggle=false;
			}
		}
		

		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
		  $errorname = 'Invalid email format';
		  $toggle=false;
		}
		else{
			//get username from email
		$position = strpos($email, "@");
		
		$username = substr($email,0,$position);
		}
		
		
		if($toggle){
	
		mysql_query("INSERT into tbl_customers (f_name, l_name, email, username, password) 
			VALUES('".$_POST['fname']."','".$_POST['lname']."','".$email."','".$username."','".$password."')") or die(mysql_error());

		//get the customer_ID of this user
		$result=mysql_query("SELECT customer_ID FROM tbl_customers WHERE username='$username'");
		$row=mysql_fetch_array($result);

		$hour = time() + 3600;
		
		if(!empty($_POST['persist'])){
				setcookie('username', $username, $hour);
		}

		$_SESSION['username']= $username;
		
		//closes mysql
		mysql_close($link);

		//redirects user to index page
		$redirect="Location:home.php?customer_ID=".$row[0];
		header($redirect);
		exit;
		}
	}

ob_end_flush();
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
	<!--Registration Form-->
	<div class="display_errors">
	<?php echo $errorname ?>

	</div>
	<form id='register' action='register.php' method='post'
	    accept-charset='UTF-8'>
	<fieldset >
	<legend><h3 class="title1">Register</h3></legend>
	<div class="formcontent">
	<input type='hidden' name='submitted' id='submitted' value='1'/>
	<label for='fname' >First Name*: </label>
	<input type='text' name='fname' id='fname' maxlength="50" required/><br/>
	<label for='lname' >Last Name*: </label>
	<input type='text' name='lname' id='lname' maxlength="50" required/><br/>
	<label for='email' >Email*: </label>
	<input type='text' name='email' id='email' maxlength="50" required /><br/>
	<label for='pass' >Password*: </label>
	<input type='password' name='pass' id='pass' maxlength="50" required/><br/>
	<label> Stay logged in?: </label>
	<input type="checkbox" name="persist"></input><br/>
	<input type='submit' name='submit' value='Register' />
	</div>
	</fieldset>
	</form>
	</div>
</body>
</html>
