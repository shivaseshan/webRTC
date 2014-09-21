<?php
session_start();
$title = "Dashboard";
include("header.php");
?>
<?php include("includes/connect.php"); ?>

<body>
<div class=" col-md-4 col-md-offset-4 margin-top-15">
Welcome <?php echo $_SESSION['login_user'];?>
</div></body>
</html>

