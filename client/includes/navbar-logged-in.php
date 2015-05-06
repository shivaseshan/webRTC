<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid" style="float: left; font-size: large; position:fixed">
		<a class="navbar-brand" href="./">webRTC
</a>
		<span style="float: left; margin-right: 10px;">Welcome</span> <span id="username" style="float: left;"><?php echo $_SESSION['login_user'];?>
	</span>
	</div>
	
	<div class="text-right">
        <a href="../client?loggedout" class="btn btn-default" id="logout" name="logout">Logout</a>
    </div>
</nav>
