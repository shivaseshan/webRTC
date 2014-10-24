<?php
	$title = "Logout Page";
  	include("includes/header.php");   // for html declaration 
?>
</head>

<?php
	// Destryoing the session on logout
	session_destroy();
	// Redirecting to login page after logout
	header( 'Location: ./login.php' ) ;
?>