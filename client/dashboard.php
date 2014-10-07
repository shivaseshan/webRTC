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
				$user_name=$_SESSION['login_user'];
		      	$result_userid = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name='$user_name'");
		      	while($row_userid = mysqli_fetch_array($result_userid)) {
		      	 		$user_id=$row_userid['user_id'];	      
		      	}
				
				if(isset($_POST['create_event'])) 
				{
					$s_date=$_POST['sdate'];
					 $s_time=$_POST['stime'];
					 $e_time=$_POST['etime']; 
					 $event_name=$_POST['ename'];
					$insert=mysqli_query($conn,"INSERT INTO `Events`(`event_name`,`start_date`,`start_time`, `end_time`, `user_id`, `event_description`, `event_room`) VALUES ('$event_name','$s_date','$s_time','$e_time','$user_id','{$_POST['edesc']}','$event_name')");
					if (!$insert)
						{
						 	die('Invalid query: ' . mysql_error());
						}
					else
					{
						echo "<p class='bg-success'> Congratulations.....Event Created</p>";
					}	
				}
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
			  <li><a href="#your-videos" role="tab" data-toggle="tab">Your Videos</a></li>
			  <li><a href="#user-profile" role="tab" data-toggle="tab">User Profile</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane active" id="dashboard">
			  	<a href="" data-toggle="modal" data-target="#myModal" class="btn btn-default" style="float:right; margin-right:2%; margin-top:1%;">Create Event</a>
			  	<br>
			  	<p> Upcoming Events! </p>
				<?php  	 
			        $result = mysqli_query($conn, "SELECT * FROM Events WHERE user_id='$user_id'");
			        if (!$result)
			        {
			          die('Invalid query: ' . mysqli_error());
			        }

			        while($row = mysqli_fetch_array($result)) 
			        {

			        	if (time() < strtotime($row[start_time]))
			        	{
				        	$room_redirect="./broadcast.php?room=".$row[event_room];
					        echo "<div class=' col-md-6 well' >";
							echo "<a href=".$room_redirect.">".$row[event_name]." ".$row[start_date]." ".$row[start_time]."</a>";
					        echo "</div>";
			        	}
			        }
		         ?>
			  	
			  	<div class="modal fade" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title">Event Creation Form</h4>
								</div>
								<div class="modal-body">
									<form role="form" name="form_event" method="post" id="signupForm" >
										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="Event name" id="ename" name="ename" >
												<span id="fnameglyph" class=""></span>
											</div>
										</div>
										<div class="row">
											<div class="col-md-10">
										<div class="input-append date form_datetime">
										    <input class="form-control" type="date" placeholder="Start Date" id="sdate" name="sdate" value="" >
										    <span class="add-on"><i class="icon-th"></i></span>
										</div></div></div>

										<div class="row">
											<div class="col-md-10">
										<div class="input-append date form_datetime">
										    <input class="form-control" type="time" placeholder="Start time" id="stime" name="stime" value="" >
										    <span class="add-on"><i class="icon-th"></i></span>
										</div></div></div>
   
																													

										<div class="row">
											<div class="col-md-10">
										<div class="input-append date form_datetime">
										    <input class="form-control" type="time" placeholder="end time" id="etime" name="etime" value="" >
										    <span class="add-on"><i class="icon-th"></i></span>
										</div></div></div>
										<div class="row">
											<div class="col-md-10">
												<input  class="form-control" type="text" placeholder="Event Description" id="edesc" name="edesc" size="48">
												<span id="fnameglyph" class=""></span>
											</div>
										</div>
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary" id="create_event" name="create_event" >Create Event</button>
									</div>
										
									</form>
								</div>
							</div>
						</div>
			  	
			  </div>

			  <div class="tab-pane" id="your-videos">
		  			<div class="container">
					    <div class="row">
					    	<div  class="col-md-12">
					    			<ol class="breadcrumb">
					    				<li style="font-size:18px;"> Your Videos </li>
					    		</ol>
					    	</div>
					    		</div>
					    			</div>

					    			<div class="container">
					    <div class="row">
					    	<?php
					    	$y=1;
					      	$user_name=$_SESSION['login_user'];
					      	$result_userid = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name='$user_name'");
					      	while($row_userid = mysqli_fetch_array($result_userid))
					      	{
					      	 		$user_id=$row_userid['user_id'];					      	 		
					      	}
					        $result = mysqli_query($conn, "SELECT * FROM video WHERE user_id='$user_id'");
					        if (!$result)
					        {
					          die('Invalid query: ' . mysqli_error());
					        }

					        while($row = mysqli_fetch_array($result)) 
					        {
					          $src="./videos/".$row['source'];

					        $id="your_video".$i;

					        	echo '<div class="col-md-4">';

					        	echo '<div class="flex-video widescreen" style="margin: 0 auto;">';
					        	echo '<video id='.$id.' width="320" height="240" poster="./images/video_poster.png" controls onclick="gofullscreen(this.id);"  >';
					        	echo '<source  src='.$src.' type="video/mp4">';
					        	echo '</video>';
					        	echo '</div>';
					          	echo '</div>'; 
					        	$i++;
					        }
					      ?>
					    </div>
					  </div>
 					 <br>

			</div>


			  
			  <div class="tab-pane" id="pre-recorded-videos">
		  			<div class="container">
					    <div class="row">
					    	<div  class="col-md-12">
					    		<ol class="breadcrumb">
					    			<li style="font-size:18px;"> Pre-recorded Videos </li>
					    		</ol>
					    	</div>
					    </div>
					  </div>

					  <div class="container">
					    <div class="row">
					    	<?php
					    	$y=1;
					      	
					        $result = mysqli_query($conn, "SELECT * FROM video ");
					        if (!$result)
					        {
					          die('Invalid query: ' . mysqli_error());
					        }

					        while($row = mysqli_fetch_array($result)) 
					        {
					          $src="./videos/".$row['source'];

					        $id="video_music".$i;

					        	echo '<div class="col-md-4">';

					        	echo '<div class="flex-video widescreen" style="margin: 0 auto;">';
					        	echo '<video id='.$id.' width="320" height="240" poster="./images/video_poster.png" controls onclick="gofullscreen(this.id);"  >';
					        	echo '<source  src='.$src.' type="video/mp4">';
					        	echo '</video>';
					        	echo '</div>';
					          	echo '</div>'; 
					        	$i++;
					        }
					      ?>
					    </div>
					  </div>
 					 <br>
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