<?php
	session_start();
	$title = "Dashboard";
	include("header.php");
?>
<?php include("includes/connect.php"); ?>

	<body>
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid" style="float: left; font-size: large;">
					Welcome <?php echo $_SESSION['login_user'];?>
				</div>
				<div class="text-right">
	          		<a href="./logout.php" class="btn btn-default" >Logout</a>
	        	</div>
			</nav>

			<div class="container">
				<p> Broadcast currently Live ! </p>
				<a href="./broadcast.html?room=test"><img src="./images/video_poster.png"></a>
			</div>
	</body>
</html>