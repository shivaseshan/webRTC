<?php
	$title = "Logout Page";
  	include("includes/header.php");   // for html declaration 
?>	

<?php
	// Destryoing the session on logout
	session_destroy();
	// Redirecting to login page after logout
	header( 'Location: ./login.php' ) ;
?>

<script type="text/javascript">
		if(response.status=== 'connected')
	        FB.logout(function(response){
	          alert("Logging out fb user");
        }); 
	</script>
</head>
</html>