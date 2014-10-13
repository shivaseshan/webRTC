<?php
	session_start(); //start the session
	ob_start();
	error_reporting(0);
	$title = "Login Page";
	$_SESSION['login_user'] ="";
	include("includes/header.php"); 
	include("includes/connect.php");
?>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	
	<body>
	<?php 
		$noLink = true; 
		include("includes/navbar.php"); 
	?>
	
	<div class="container-fluid"> <!-- container for modal -->
		<div class="row-fluid">
			<div class="well col-md-4 col-md-offset-4 margin-top-05">
				<form role="form" name="form1" action="login.php" method="post">
					<div class="form-group input-group-lg">
						<input class="form-control transparent-input" type="text" name="userdomain" id="userdomain" placeholder="User Name" autofocus>
					</div>				
					<div class="form-group input-group-lg">
						<input class="form-control transparent-input" type="password" name="pwd" id="pwd" placeholder="Password">
					</div>

					<div class="inline">
						<button id="lgn-sbmt" class="btn btn-primary center" name="login" type="submit">Login</button>
						<br><br>
						<div class="fb-login-button" data-size="large" data-scope="email" data-show-faces="false" data-auto-logout-link="false">Sign in</div>
						<br><br><!-- facebook sign in -->
					<!--	<div id="signinButton">
						  <span
						    class="g-signin"
						    data-callback="signinCallback"
						    data-clientid="364658795193-l9ujs1947j350fgk45qlptkn28h7jhlf.apps.googleusercontent.com"
						    data-cookiepolicy="single_host_origin"
						    data-requestvisibleactions="http://schema.org/AddAction"
						    data-scope="https://www.googleapis.com/auth/plus.login">
						  </span>
						</div>-->
						<!-- <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div> -->
					</div>	
				</form>
					<div class="top inline">				
						<label>
							<a href="/forgot-password">Forgot Password?</a> | <a href="" data-toggle="modal" data-target="#myModal">Sign up</a>
						</label>
						

					</div>
					<div id="loginErr" class="top-inline">
					</div>
					<div id="regnsuccess" class="top-inline"></div>
					<?php
					if($_GET['isUserExist']=="YES") // if user exists prints a prompt sayin it already exists
					{
						echo '<script type="text/javascript">document.getElementById("regnsuccess").innerHTML="User Exists.Try a different user name";</script>';
					}	
					if($_GET['isUserExist']=="NO")	
					{ //if the user doesn't exist then he is asked to login with the credentials he signed up for
						echo '<script type="text/javascript">document.getElementById("regnsuccess").innerHTML="Registration Successful.Login with the username and password";</script>';
					}
					?>	
					<?php 
					if(isset($_POST['login'])) // this is to check if the user exists with that login id and password
					{
						$userdomain = $_POST['userdomain'];
						$password = md5($_POST['pwd']);
						$result = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name='{$userdomain}'");
						if (!$result)
						{
							die('Invalid query: ' . mysql_error());
						}
						$count1=mysqli_num_rows($result);
						$result2=mysqli_query($conn, "SELECT password FROM user WHERE user_name='{$userdomain}'");
						$row = mysqli_fetch_array($result2);
						$count2=mysqli_num_rows($result2);
						if($count1==1 && $count2==1 && $password==$row[0])
						{
							$_SESSION['login_user']=$userdomain;
							header( 'Location: ./dashboard.php' ) ;
						}
						else
						{ //If not successful, an error message is printed
							echo '<script type="text/javascript">document.getElementById("loginErr").innerHTML="Invalid User Name or Password";</script>';
						}
					}
					?>
					<div class="modal fade" id="myModal"><!--Form for all the text boxes in the sign up modal-->
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title">Sign Up Form</h4>
								</div>
								<div class="modal-body">
									<form role="form" name="form2" action="login.php" method="post" id="signupForm" >
										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="First Name" id="fname" name="fname" >
												<span id="fnameglyph" class=""></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="Last Name" id="lname" name="lname">
												<span id="lnameglyph" class=""></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="email" placeholder="Email ID" id="email" name="email" >
												<span id="emailglyph" class=""></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10">
												<input  placeholder="Age" class="form-control" type="number" id="age" name="userage" required = "required">
												<span id="ageglyph" class=""></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="User Name" id="uname" name="uname"  >
												<span id="unameglyph" class=""></span>

											</div>
										</div>	

										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="password" placeholder="Password" id="usrpwd" name="usrpwd">
												<span id="pwdglyph" class=""></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="password" placeholder="Confirm Password" id="cnfrmpwd" name="cnfrmpwd">
												<span id="cnfrmpwdglyph" class=""></span>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary" id="signup" name="signup" >Sign Up</button>
									</div>
									<?php
										$isUserExist ="";
										
										if(isset($_POST['signup'])) //checks on click of signup if the user name exists. If it doesnt, sign in is done successfully
										{
											$result = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name='{$_POST['uname']}'");
											if (!$result)
											{
												die('Invalid query: ' . mysql_error());
											}
											$count1=mysqli_num_rows($result);
											if($count1==0)
											{
												$user_name=$_POST['uname'];
												$isUserExist="NO";
												$password = md5($_POST['usrpwd']);
												$insert=mysqli_query($conn,"INSERT INTO user (user_name, first_name, last_name, email_id, age, password) VALUES('{$_POST['uname']}','{$_POST['fname']}','{$_POST['lname']}','{$_POST['email']}','{$_POST['userage']}','{$password}')");
												if (!$insert)
												{
													die('Invalid query: ' . mysql_error());
												}
												header( 'Location: ./login.php?isUserExist='.$isUserExist) ;			
											}
											else
											{
												$isUserExist="YES";		
												header( 'Location: ./login.php?isUserExist='.$isUserExist) ;										
											}
										}
									?>						
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php mysqli_close($conn); ?>
		<script type="text/javascript" src="js/login.js"></script>
		<script type="text/javascript" src="js/facebook.js"></script>
		<script type="text/javascript" src="js/google.js"></script>
	</body> 
</html>
<?php ob_flush() ?>
