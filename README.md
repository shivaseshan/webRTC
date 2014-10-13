Social broadcasting using WebRTC
================================

This lets the users do a video broadcast where other people can also join in. The project uses star topology so the originator of the video would be able to see everybody but all others could just see themeselves and the originator. There is also a live chat features which lets users chat realtime as the video is being broadcasted. The originator has a provision to record his video, which would be stored in the server and made available in the videos section for everybody to see.

project url: http://54.69.168.130/webRTC/client/

**How to deploy**

 - Place all the files inside client folder inside the htdocs folder of wamp/xampp.
 - Copy paste the files in the server folder into a corresponding folder in local.
 - Get the node modules by giving command of "npm install". it would take the information from package.json and install the dependencies.
 - Start the node server by giving command of "node server.js"

**Files** 

 - 3rd party files :
	 - Adapter.js - JS library used as a shim to insulate the app from browser differences. As the  API has not yet been made a standard so every browser has difference objects.
	 - RecordRTC.js - JS library used for recording audio and video tracks. As the the specs is still in draft not yet implemented by the browsers as an API.
	
 - Our files:
	 - index.php
	 - login.php
	 - logout.php
	 - process.php
	 - broadcast.php
	 - combineAudioVideo.php [using code from Mauz's webRTC-expirements ]
	 - facebook.js [using facebook's javascript sdk for using fb login]
	 - login.js [validations for sign up page]
	 - main.js [making RTCPeerConnection and using ICE. 
	EventHandlers for buttons on broadcast page.]
