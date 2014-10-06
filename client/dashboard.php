<?php
	session_start();
	$title = "Dashboard";
	include("includes/header.php");
	include("includes/connect.php");
?>
		<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	</head>
	
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
				<a href="./broadcast.php?room=test"><img src="./images/video_poster.png"></a>
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
				    <input type="text" class="form-control col-md-4" name="first-name" id="first-name" placeholder="Enter First Name" value="<?php echo $row[2]; ?>" disabled>
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn btn-default" id="edit-first-name">Edit</a>
		  		  </div>
				  
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="last-name">Last Name</label>
				    <input type="text" class="form-control col-md-4" name="last-name" id="last-name" placeholder="Enter Last Name" value="<?php echo $row[3]; ?>" disabled>
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn" id="edit-last-name">Edit</a>
				  </div>
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="email">E Mail</label>
				    <input type="email" class="form-control col-md-4" name="email" id="email" placeholder="Enter Email" value="<?php echo $row[4]; ?>" disabled>
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn" id="edit-email">Edit</a>
				  </div>
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="password">New Password</label>
				    <input type="password" class="form-control col-md-4" name="password" id="password" placeholder="Enter Password" disabled required> 
				    <a class="col-md-offset-1 col-md-1 margin-top-01" type="btn" id="edit-password">Edit</a>
				  </div>
				  <div class="row">
				    <label class="col-md-2 margin-top-01" for="confirm-password">Confirm Password</label>
				    <input type="password" class="form-control col-md-4" id="confirm-password" placeholder="Confirm Password" disabled required> 
				  </div>
				  <br><br>
				  <div class="col-md-6 text-center">
				  	<button type="submit" name="save" id="save" class="btn btn-default">Save</button>
				  </div>
				</form>
			  </div>

			  <?php
			  	if (isset($_POST['save'])) {
			  		$firstName = $_POST['first-name'];
			  		$lastName = $_POST['last-name'];
			  		$email = $_POST['email'];
			  		if ( isset($_POST['password']) ) {
			  			$password = md5($_POST['password']);
			  			$result = mysqli_query($conn, "UPDATE user SET first_name='$firstName', last_name='$lastName', email_id='$email', password='$password' WHERE user_name='$username'");
			  		}
			  		else
			  			$result = mysqli_query($conn, "UPDATE user SET first_name='$firstName', last_name='$lastName', email_id='$email' WHERE user_name='$username'");	

			  		
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