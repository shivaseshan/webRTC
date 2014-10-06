<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid" style="float: left; font-size: large;">
	  <p style="float: left; margin-right: 10px;">Welcome</p> <p id="username" style="float: left;"><?php echo $_SESSION['login_user'];?></p>
	</div>
	<div class="text-right">
        <a href="./logout.php" class="btn btn-default" >Logout</a>
    </div>
</nav>