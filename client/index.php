<?php 
  include 'includes/connect.php';
  $title = "Home Page";
  include("header.php"); 
?>

<body>
  <!--<div class="container">
    <div class="row">
    	<div  class="col-md-12">
        <div class="navbar-form navbar-right navbar-static-top">
          <a href="./login.php" class="btn btn-default" >Login</a>
        </div>
      </div>
    </div>
  </div>
  -->
  <?php 
    $noLink = false;
    include("includes/navbar.php"); 
  ?>
  <div class="container">
    <div class="row">
    	<div  class="col-md-12">
    		<ol class="breadcrumb">
    			<li style="font-size:18px;"> GENERAL </li>
    		</ol>
    	</div>
    </div>
  </div>

  <div class="container">
    <div class="row">
    	<?php
    	$y=1;
      	$category="general";
        $result = mysqli_query($conn, "SELECT * FROM video WHERE category='general'");
        if (!$result)
        {
          die('Invalid query: ' . mysqli_error());
        }

        while($row = mysqli_fetch_array($result)) {
          $src="./videos/".$row['source'];
            $id_general="video_general".$y;
        	echo '<div class="col-md-4">';

        	echo '<div class="flex-video widescreen" style="margin: 0 auto;">';
        	echo '<video id='.$id_general.' width="320" height="240" poster="./images/video_poster.png" controls onclick="gofullscreen(this.id);"  >';
        	echo '<source src='.$src.' type="video/mp4">';
        	echo '</video>';
        	echo '</div>';
          echo '</div>';
          $y++;
        }
      ?>
    </div>
  </div>
  <br>
  
  <div class="container">
    <div class="row">
    	<div  class="col-md-12">
    		<ol class="breadcrumb">
    			<li style="font-size:18px;"> MUSIC </li>
    		</ol>
    	</div>
    </div>
  </div>

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
