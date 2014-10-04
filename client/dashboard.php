<?php
	session_start();
	$title = "Dashboard";
	include("includes/header.php");
	include("includes/connect.php");
?>
<?php include("includes/connect.php"); ?>
	<body>
			<?php if($_SESSION['login_user'] == "") {
				echo "Login with proper credentials";
			}
			else {
			?>	
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid" style="float: left; font-size: large;">
					Welcome <?php echo $_SESSION['login_user'];?>
				</div>
				<div class="text-right">
	          		<a href="./logout.php" class="btn btn-default" >Logout</a>
	        	</div>
			</nav>

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
			  <li class="active"><a href="#dashboard" role="tab" data-toggle="tab">Dashboard</a></li>
			  <li><a href="#pre-recorded-videos" role="tab" data-toggle="tab">Pre-Recorded Videos</a></li>
			  <li><a href="#user-profile" role="tab" data-toggle="tab">User Profile</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane active" id="dashboard">
			  	<p> Broadcast currently Live ! </p>
				<a href="./broadcast.html?room=test"><img src="./images/video_poster.png"></a>
			  </div>
			  
			  <div class="tab-pane" id="pre-recorded-videos">
		  			
			  </div>
			  
			  <div class="tab-pane" id="user-profile">
			  	<?php
			  		$username = $_SESSION['login_user'];
			  		$result = mysqli_query($conn, "SELECT * FROM user WHERE user_name='$username'");

			  		if (!$result) {
			          die('Invalid query: ' . mysqli_error());
			        }

					$row = mysqli_fetch_array($result);
				?>
		  		<form role="form" method="post" action="dashboard.php">
		  		  <div class="row">
				    <label class="col-md-2 margin-top-01" for="first-name">First Name</label>
				    <input type="text" class="form-control col-md-4" id="first-name" value="<?php echo $row[2]; ?>" disabled>
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn btn-default" id="edit-first-name">Edit</a>
		  		  </div>
				  
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="last-name">Last Name</label>
				    <input type="text" class="form-control col-md-4" id="last-name" value="<?php echo $row[3]; ?>" disabled>
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn" id="edit-last-name">Edit</a>
				  </div>
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="email">E Mail</label>
				    <input type="email" class="form-control col-md-4" id="email" value="<?php echo $row[4]; ?>" disabled>
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn" id="edit-email">Edit</a>
				  </div>
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="password">Password</label>
				    <input type="password" class="form-control col-md-4" id="password" value="<?php echo $row[5]; ?>" disabled> 
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn" id="edit-password">Edit</a>
				  </div>
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="confirm-password">Confirm Password</label>
				    <input type="password" class="form-control col-md-4" id="confirm-password" value="<?php echo $row[5]; ?>" disabled> 
				  </div>
				  <br><br>
				  <div class="col-md-6 text-center">
				  	<button type="submit" name="save" class="btn btn-default">Save</button>
				  </div>
				</form>
			  </div>

			  <?php
			  	if (isset($_POST['save']})) {
			  		$result = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name='$username'");
					if (!$result) {
						die('Invalid query: ' . mysql_error());
					}
			  	}
			  ?>
			</div>
			<?php } ?>
			<script type="text/javascript" src="js/dashboard.js"></script>
	</body>
</html>