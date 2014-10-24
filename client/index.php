 <!-- This is the homepage for the website which will include pre-recorded videos of different categories-->
<?php 
  // include section
  include("includes/connect.php");  // for database connection
  $title = "Home Page";
  include("includes/header.php");   // for html declaration 
?>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

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
  
   <!-- This part shows the list of upcoming broadcasting events of different users -->
  
  <div class="container">
    <div class="row">
      <div  class="col-md-12">
        <ol class="breadcrumb">
          <li style="font-size:18px;"> Upcoming Events By Users </li>
        </ol>
         <?php          
        $result_eventlist = mysqli_query($conn, "SELECT * FROM Events ");
        if (!$result_eventlist) {
          die('Invalid query: ' . mysqli_error());
        }

        while($row_eventlist = mysqli_fetch_array($result_eventlist)) {
          $room_redirect="./broadcast.php?room=".$row_eventlist[event_room];
          $user_id=$row_eventlist[user_id];
          $result_userid = mysqli_query($conn, "SELECT user_name FROM user WHERE user_id='$user_id'");
          while($row_userid = mysqli_fetch_array($result_userid)) {
              $user_name=$row_userid['user_name'];        
          }
          echo '<div class="col-md-4">';
          echo "<a href=".$room_redirect.">".$row_eventlist[event_name]." ".$row_eventlist[start_date]." ".$row_eventlist[start_time]."by ".$user_name."</a>";
          echo '</div>';
         } 
         ?>
      </div>
    </div>
  </div>
  <!-- 
  This part will display the videos from the general category
  -->
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
  <!-- 
  This part will display the videos from the music category 
  -->
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
  <!-- 
  This function will play and open the video in fullscreen once the user will click on the video
  -->
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
