
<?php 
session_start();
include('menu.php');
session_destroy();
$_SESSION = array();
if(isset($_COOKIE['username'])){
	setcookie('username', '', 0);
}
 $content="<p><h3 class='title1'>You have been successfully logged out of EcomSite.<br> Have a great day!</h3></p>";
 $content.="<div class='return'><a style=align:'center' href='index.php'>Return to the Home Page</a></div>";
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
	<?php echo $content ?>
	</div>
</div>
</body>
</html>
