<?php
session_start();
include('connect.php');
mysql_select_db('ecom_db');
$menu="";

$menu.="
			<a href='index.php'>Home</a>
			<p>Categories</p>
			<ul class='category_list'>
				<li><a href='index.php'>All Categories</a></li>
				<li><a href='index.php?category=books'>Books</a></li>
				<li><a href='index.php?category=computers'>Computers</a></li>
				<li><a href='index.php?category=electronics'>Electronics</a></li>
			</ul>
			<a href='shoppingCart.php'>Shopping Cart</a><br/>
			<a href='login.php'>Login</a><br/>
			<a href='Register.php'>Register</a><br/>
			<a href='Logout.php'>Logout</a><br/>
";
?>
<html>
<head>

</head>
<body>
</body>
</html?
