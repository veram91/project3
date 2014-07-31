<?php
session_start();
include('connect.php');
mysql_select_db('ecom_db');
$menu="";
if(!empty($_GET['customer_ID'])){
	$customer_ID = $_GET['customer_ID'];
}


/*else if(!empty($_POST['customer_ID'])){
	$customer_ID = $_POST['customer_ID'];
}*/


//check if cookie is set and set session
if(isset($_COOKIE['username'] )){
	$_SESSION['username'] = $_COOKIE['username'];
}

$query = "SELECT * FROM tbl_customers WHERE customer_ID = $customer_ID";
$result = mysql_query($query);
if($result){
	while($rows = mysql_fetch_array($result)){
		$f_name = $rows['f_name'];
	}
}
	


if(empty($_SESSION['username'])){
$menu.="
			<a href='index.php'>Home</a>
			<p>Categories</p>
			<ul class='category_list'>
				<li><a href='index.php?customer_ID=$customer_ID'>All Categories</a></li>
				<li><a href='index.php?customer_ID=$customer_ID&category=books'>Books</a></li>
				<li><a href='index.php?customer_ID=$customer_ID&category=computers'>Computers</a></li>
				<li><a href='index.php?customer_ID=$customer_ID&category=electronics'>Electronics</a></li>
			</ul>
			<a href='shoppingCart.php?customer_ID=$customer_ID'>Shopping Cart</a><br/>
			<a href='login.php'>Login</a><br/>
			<a href='Register.php'>Register</a><br/>
			<br/>
			<form name='search' action='index.php' method='get'>
				<label for='search_query'>Search for an item:</label><br/>
				<input type='text' name='search_query' id='search_query' size='17' /required>
				<input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
				<input type='submit' value='Search'></input>
			</form>
			
";
}
else{
$menu.="
			<p id='welcome'>Welcome <span id='welcome_name'>".$f_name."</span>!</p>
			<p class = 'stripe'><a href='index.php?customer_ID=$customer_ID'>Home</a></p>
			<p><a href='profile.php?customer_ID=$customer_ID'>Profile</a></p>
			<p class = 'stripe'>Categories</p>
			<ul class='category_list'>
				<li><a href='index.php?customer_ID=$customer_ID'>All Categories</a></li>
				<li><a href='index.php?customer_ID=$customer_ID&category=books'>Books</a></li>
				<li><a href='index.php?customer_ID=$customer_ID&category=computers'>Computers</a></li>
				<li><a href='index.php?customer_ID=$customer_ID&category=electronics'>Electronics</a></li>
			</ul>
			<p class = 'stripe'><a href='shoppingCart.php?customer_ID=$customer_ID'>Shopping Cart</a></p>
			<p><a href='Logout.php'>Logout</a></p>
			<form class = 'stripe' name='search' action='index.php' method='get'>
				<label for='search_query'>Search for an item:</label><br/>
				<input type='text' name='search_query' id='search_query' size='17' /required>
				<input type = 'hidden' name = 'customer_ID' value='$customer_ID'></input>
				<input type='submit' value='Search'></input>
			</form>
";

}

?>
<html>
<head>

</head>
<body>
</body>
</html?
