<?php
	$title = "Login Page";
	include("header.php"); 
?>

<body>
	<?php include("includes/connect.php"); ?>
	<div class="container-fluid">
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
					</div>	</form>
					<div class="top inline">				
						<label>
							<a href="/forgot-password">Forgot Password?</a> | <a href="" data-toggle="modal" data-target="#myModal">Sign up</a>
						</label>
						<span id="loginerror">
						</span> 
						<?php 
							if(isset($_POST['login']))
							{
								$userdomain = $_POST['userdomain'];
								$password=$_POST['pwd'];
								echo '<script type="text/javascript">alert("success"); </script>';
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
									echo '<script type="text/javascript">alert("Login sucess"); </script>';
								else
								{
									echo '<script type="text/javascript">document.getElementById("loginerror").innerHTML="error";</script>';
								}
							}
						?>
					</div>

					<div class="modal fade" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">

									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title">Sign Up Form</h4>
								</div>
								<div class="modal-body">
									<form role="form" name="form2" action="login.php" method="post" id="signupForm">
										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="First Name" id="fname" >
												<span id="fnameglyph" class=""></span>
											</div>
										</div>


										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="Last Name" id="lname">
												<span id="lnameglyph" class=""></span>
											</div>
										</div>


										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="email" placeholder="Email ID" id="email" >
												<span id="emailglyph" class=""></span>
											</div>
										</div>


										<div class="row">
											<div class="col-md-10">
												<input  placeholder="BirthDate" class="form-control" type="text" onfocus="(this.type='date')"  id="date" required = "required">
												<span id="dateglyph" class=""></span>
											</div>
										</div>


										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="text" placeholder="User Name" id="uname" name="uname" >
												<span id="unameglyph" class=""></span>
												
												<?php
												$isUserExist ="NO";
												if(isset($_POST['uname']))
												{
													$result = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name='{$_POST['uname']}'");

													if (!$result)
													{
														die('Invalid query: ' . mysql_error());
													}
													$count1=mysql_num_rows($result);
													echo "<script type=\"text/javascript\">console.log($count1); </script>";
													
													if($count1==0)
													{
														header( 'Location: http://localhost:80/webRTC/client/dsahboard.php' ) ;
														$isUserExist="NO";
													}
														else
														$isUserExist="YES";												
												}
												?>

												<script type="text/javascript">
												
												if(<?php echo '"'. $isUserExist .'"'; ?>=="YES")
													//document.getElementById('usrexists').innerHTML="User Name Exists.Try a different one!";
													alert("User Name Exists.Try a different one!");
												</script>										
											</div>
										</div>							
										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="password" placeholder="Password" id="usrpwd">
												<span id="pwdglyph" class=""></span>
											</div>
										</div>
										<div class="row">
											<div class="col-md-10">
												<input required = "required" class="form-control" type="password" placeholder="Confirm Password" id="cnfrmpwd">
												<span id="cnfrmpwdglyph" class=""></span>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary" id="signup" >Sign Up</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php mysqli_close($conn); ?>
	</body> 
</html>
