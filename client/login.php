<?php
$conn=false;
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "admin123";
$db_name= "rtcdatabase";
$conn = mysql_connect($dbhost, $dbuser, $dbpass, $db_name);

if(!$conn)
{
	die('Could not connect: ' . mysql_error());
	echo '<script type="text/javascript">alert("not sucess"); </script>';
}
else
{
if(isset($_POST['login']))
{
	$password=$_POST['pwd'];
	echo '<script type="text/javascript">alert("success"); </script>';
	mysql_query('use rtcdatabase');
	$result = mysql_query("SELECT user_id FROM user WHERE user_name='{$_POST['userdomain']}'");
	if (!$result)
	{
		die('Invalid query: ' . mysql_error());
	}
	$count1=mysql_num_rows($result);
	$result2=mysql_query("SELECT password FROM user  WHERE user_name='{$_POST['userdomain']}'");
	$row = mysql_fetch_array($result2);
	$count2=mysql_num_rows($result2);
	if($count1==1 && $count2==1 && $password==$row[0])
		echo '<script type="text/javascript">alert("Login sucess"); </script>';
	else
	{
		echo "erro";
		echo '<script type=\"text/javascript\">document.getElementById(\"loginerror\").innerHTML=\"error\";</script>';
	header( 'Location: http://localhost:80/webRTC/client/login_page.php?auth=fail');
		//echo '<script type="text/javascript">alert("Login not sucess"); </script>';
		
	}
}
	mysql_close($conn);
}
?> 