<?php 
include 'includes/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/styles.css">
	
</head>

<body>

<div class="container">
  <div class="row">
  	<div  class="col-md-12">
  <form class="navbar-form navbar-right navbar-static-top" role="search" style="margin-right:3%;">
  
  <button type="submit" class="btn btn-default" >Login</button>
</form>
</div></div></div>
<div class="container">
  <div class="row">
  	<div  class="col-md-12">
  		<ol class="breadcrumb">
  			<li style="font-size:18px;"> GENERAL </li>
  		</ol>

  		</div></div></div>

<div class="container">
  <div class="row">
  	<?php
  	$category="general";
$result = mysqli_query($conn, "SELECT * FROM video WHERE category='general'");
if (!$result)
{
die('Invalid query: ' . mysqli_error());
}

while($row = mysqli_fetch_array($result)) {
  $src="./videos/".$row['source'];

	echo '<div class="col-md-4">';

	echo '<div class="flex-video widescreen" style="margin: 0 auto;">';
	echo '<video width="320" height="240" poster="./images/video_poster.png" controls >';
	echo '<source src='.$src.' type="video/mp4">';
	echo '</video>';
	echo '</div> </div>';
}
?>
</div></div>
<br>
<div class="container">
  <div class="row">
  	<div  class="col-md-12">
  		<ol class="breadcrumb">
  			<li style="font-size:18px;"> MUSIC </li>
  		</ol>

  		</div></div></div>

  		<div class="container">
  <div class="row">
  	<?php
  	$i=1;
$result = mysqli_query($conn, "SELECT * FROM video WHERE category='music'");
if (!$result)
{
die('Invalid query: ' . mysqli_error());
}
while($row = mysqli_fetch_array($result)) 
{
  $src="./videos/".$row['source'];

$id="video_".$i;

	echo '<div class="col-md-4">';

	echo '<div class="flex-video widescreen" style="margin: 0 auto;">';
	echo '<video id='.$id.'. width="320" height="240" poster="./images/video_poster.png" controls onclick="gofullscreen(this.id);"  >';
	echo '<source  src='.$src.' type="video/mp4">';
	echo '</video>';
	echo '</div> </div>';
	$i++;
}
?>
	
</body>
<script type="text/javascript">

  	function gofullscreen(id)
  	{
  		var element=document.getElementById(id);


  		if (element.mozRequestFullScreen) 
  	{
    element.mozRequestFullScreen();
  	} else if (element.webkitRequestFullScreen) 
  	{
    element.webkitRequestFullScreen();
  	}  
  	element.play();

  }
</script>
</html>