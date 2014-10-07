<?php
  session_start();
    if($_SESSION['login_user'] == "") {
      
        header('Location: ./login.php');
      }
  $title = "WebRTC client";
  include("includes/header.php"); 
?>
    <link rel='stylesheet' href='css/main.css' />
  </head>

  <body>
    <?php if($_SESSION['login_user'] == "") {

        header('Location: ./login.php');
      }
      else {
        include("includes/navbar-logged-in.php");
      ?>
      <div id='container'>
        <div id='participants'>
        </div>
        <canvas id="photo" style="display: none;"></canvas> 

        <button id="disable-audio" class="btn btn-default">Disable Audio</button>
        <button id="enable-audio" class="btn btn-default " style="display: none;">Enable Audio</button>
        <button id="disable-video" class="btn btn-default">Disable Video</button>
        <button id="enable-video" class="btn btn-default " style="display: none;">Enable Video</button>
        <button id="snapshot" class="btn btn-default">Snapshot</button>
        <button id="share-screen" class="btn btn-default">Share Screen</button>
        <button id="start-record" class="btn btn-default">Record Video</button>
        <button id="stop-record" class="btn btn-default" style="display: none;">Stop Video</button>
        <button id="hang-up" class="btn btn-default btn-danger">End</button>
        <br><br>

        <textarea id="chatbox"></textarea> <br>
        <input id="dataChannelSend" type="text" size="63" disabled placeholder="Enter some text, then press Send."/>
        <button id="sendButton" disabled>Send</button>
        
        <!--<textarea id="dataChannelReceive" disabled></textarea> -->
      </div>

      <script src='js/socket.io/socket.io.js'></script>
      <script src='js/lib/adapter.js'></script>
      <script src='js/main.js'></script>
      <script src="http://www.nihilogic.dk/labs/canvas2image/canvas2image.js"></script>
      <script src="//cdn.WebRTC-Experiment.com/RecordRTC.js"></script>

      <script type="text/javascript">
      $('#share-screen').click(function() {
            getUserMedia({
                      video: {
                          mandatory: {
                              chromeMediaSource: 'screen',
                              maxWidth: 1280,
                              maxHeight: 720
                          },
                          optional: []
                      }
                    }, function(stream) {
                          document.getElementById('video').src = window.URL.createObjectURL(stream);;
                          $('#share_screen').hide();
                      }, function() {
                          alert('Error, my friend. Screen stream is not available. Try in latest Chrome with Screen sharing enabled in about:flags.');
                        }
                  )
            });
      </script>


      <?php } ?>

  </body>
</html>
