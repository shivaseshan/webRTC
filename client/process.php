<?php
    // Continuing the session
    session_start();

    // include section
	include('includes/connect.php');   // for database connection

	//user details
    $fullname = $_POST['first_name'].' '.$_POST['last_name'];
    $email = $_POST['email'];
    $fbid = $_POST['fbid'];

    //Check user id in our database 
    $result = mysqli_query($conn, "SELECT fbid FROM fbtable WHERE fbid='$fbid'");
    if (!$result)
	{
		die('Invalid query: ' . mysql_error());
	}

	$UserCount=mysqli_num_rows($result);
    if($UserCount)
    {   
        //User is now connected, log him in
        login_user(true,$_POST['first_name'].' '.$_POST['last_name']);
    }
    else
    {
        //User is new, Show connected message and store info in our Database
        mysqli_query($conn, "INSERT INTO fbtable (fbid, fullname, email) VALUES ('{$_POST['fbid']}', '$fullname','$email')");                
    }
    
    mysqli_close($conn);


function login_user($loggedin,$user_name)
{
    /*
    function stores some session variables to imitate user login. 
    We will use these session variables to keep user logged in, until s/he clicks log-out link.
    */
    $_SESSION['logged_in']=$loggedin;
    $_SESSION['login_user']=$user_name;
}
?>