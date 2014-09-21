
<!DOCTYPE html>
<html>
<head>
	<title>Login Page </title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="/webRTC/client/js/login.js"></script>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>



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
<?php
if($_GET['auth']=='fail')
{
	echo "error";
	//echo '<script type=\"text/javascript\">document.getElementById(\"loginerror\").innerHTML=\"error\";</script>';
}
?>
						</span> 
					</div>

					

					<div class="modal fade" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">

									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title">Sign Up Form</h4>
								</div>
								<div class="modal-body">
									<form role="form" name="form2" action="login_page.php" method="post" id="signupForm">
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
												$conn=false;
												$dbhost = "localhost";
												$dbuser = "root";
												$dbpass = "admin123";
												$db_name= "rtcdatabase";
												$conn = mysql_connect($dbhost, $dbuser, $dbpass, $db_name);
												$error="";
												$exists="";
												if(!$conn)
												{
													die('Could not connect: ' . mysql_error());
													echo '<script type="text/javascript">alert("not sucess"); </script>';
												}
												mysql_query('use rtcdatabase');
												if(isset($_POST['uname']))
												{
													$result = mysql_query("SELECT user_id FROM user WHERE user_name='{$_POST['uname']}'");

													if (!$result)
													{
														die('Invalid query: ' . mysql_error());
													}
													$count1=mysql_num_rows($result);
													echo "<script type=\"text/javascript\">console.log($count1); </script>";
													
													if($count1==0)
													{
														header( 'Location: http://localhost:80/webRTC/client/new_usrpage.html' ) ;
														$exists="";
													}
														else
														$exists="Error";												
												}
												?>

												<script type="text/javascript">
												
												if(<?php echo $exists; ?>=="")
												//document.getElementById('usrexists').innerHTML="User Name Exists.Try a different one!";
												//alert("User Name Exists.Try a different one!");
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
	</body>
	</html>
