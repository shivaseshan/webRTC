'use strict';

var sendChannel;
var sendButton = document.getElementById("sendButton");
var sendTextarea = document.getElementById("dataChannelSend");
var receiveTextarea = document.getElementById("dataChannelReceive");
var chatbox = document.getElementById("chatbox");
sendButton.onclick = sendData;

var isChannelReady;
var isInitiator;
var isMember;
var participantID;
var isAlreadyOnCall;
var isStarted;
var localStream;
var pc;
var remoteStream;
var turnReady;
var localVideo;
var remoteVideo;
var obj = { hangupID: undefined } ;

var pc_config = webrtcDetectedBrowser === 'firefox' ?
  {'iceServers':[{'url':'stun:23.21.150.121'}]} : // number IP
  {'iceServers': [{'url': 'stun:stun.l.google.com:19302'}]};

var pc_constraints = {
  'optional': [
    {'DtlsSrtpKeyAgreement': true},
    {'RtpDataChannels': true}
  ]};

// Set up audio and video regardless of what devices are present.
var sdpConstraints = {'mandatory': {
  'OfferToReceiveAudio':true,
  'OfferToReceiveVideo':true }};

/////////////////////////////////////////////
function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}          

//var room = prompt('Enter room name:'); //location.pathname.substring(1);
var room = getUrlParameter('room');
if (room === '') {
  room = location.pathname.substring(1);
}

var socket = io.connect('http://54.69.168.130:8081');

if (room !== '') {
  console.log('Create or join room', room);
  socket.emit('create or join', room);
}

socket.on('created', function (room){
  console.log('Created room ' + room);
  isInitiator = true;
});

socket.on('full', function (room){
  console.log('Room ' + room + ' is full');
});

socket.on('join', function (room){
  console.log('Another peer made a request to join room ' + room);
  //console.log('This peer is the initiator of room ' + room + '!');
  isChannelReady = true;
  isStarted = false;
  if (!isInitiator)
    isMember = '2';
  else if (isInitiator)
    remoteVideo = document.createElement('video');
});

socket.on('joined', function (room){
  console.log('This peer has joined room ' + room);
  isChannelReady = true;
  isMember = '1';
  remoteVideo = document.createElement('video');
});

socket.on('log', function (array){
  console.log.apply(console, array);
});

////////////////////////////////////////////////

function sendMessage(message){
	console.log('Sending message: ', message);
  socket.emit('message', message);
}

function sendParticipantId(participantID) {
  console.log('Sending participantID: ', participantID);
  socket.emit('hangupID', participantID);
}

socket.on('message', function (message){
  console.log('Receive message:', message);
  if (message === 'got user media') {
  	maybeStart();
  } else if (message.type === 'offer') {
    if (!isInitiator && !isStarted) {
      maybeStart();
    }
    if (isMember === '1') {
      pc.setRemoteDescription(new RTCSessionDescription(message));
      doAnswer();
    }
  } else if (message.type === 'answer' && isStarted) {
    pc.setRemoteDescription(new RTCSessionDescription(message));
  } else if (message.type === 'candidate' && isStarted) {
    var candidate = new RTCIceCandidate({sdpMLineIndex:message.label,
      candidate:message.candidate});
    pc.addIceCandidate(candidate);
  } else if (message === 'bye' && isStarted) {
    handleRemoteHangup();
  }
});

socket.on('hangupID', function (participantID) {
  console.log('Receive message:', participantID);
  if (isInitiator){
    var removeVideo = $( 'video[participantid='+ participantID +']' );
    removeVideo.remove();
  }
});

socket.on('participantID', function (numClients) {
  if (typeof localVideo === "undefined") {
    localVideoParticipantID = numClients;
    obj.hangupID = numClients;
    Object.freeze(obj);   // Freezing the hangupID so that next connection doesn't change the value of hangupID
  }
  else 
    localVideo.setAttribute('participantID', numClients);

  if (typeof remoteVideo === "undefined")
    remoteVideoParticipantID = 1;
  else
    remoteVideo.setAttribute('participantID', 1);  
});

socket.on('participantIDs', function (numClients) {
  console.log("participantIDs " + numClients);
  //alert("participantIDs " + numClients);
  if (isInitiator) {  
    //alert("participantIDs " + numClients);   
    remoteVideo.setAttribute('participantID', numClients); 
  }
});

////////////////////////////////////////////////////

//var localVideo = document.querySelector('#localVideo');
//var remoteVideo = document.querySelector('#remoteVideo');
var participants = document.querySelector('#participants');
var localVideoParticipantID;
var remoteVideoParticipantID;

function handleUserMedia(stream) {
  localVideo = document.createElement('video');
  if (typeof localVideoParticipantID != "undefined")
    localVideo.setAttribute('participantID', localVideoParticipantID);
  if (isInitiator)
    localVideo.setAttribute('participantID', 1);
  localVideo.setAttribute('id','localVideo');
  localVideo.setAttribute('autoplay', true);
  localVideo.setAttribute('controls', true);
  participants.insertBefore(localVideo, participants.firstChild);

  localStream = stream;
  attachMediaStream(localVideo, stream);
  console.log('Adding local stream.');
  sendMessage('got user media');
  if (isInitiator) {
    maybeStart();
  }
}

function handleUserMediaError(error){
  console.log('getUserMedia error: ', error);
  alert('unable to get access to your webcam.');
}

var constraints = {audio: true, video: true};

getUserMedia(constraints, handleUserMedia, handleUserMediaError);
console.log('Getting user media with constraints', constraints);

/*if (location.hostname != "localhost") {
  requestTurn('https://computeengineondemand.appspot.com/turn?username=41784574&key=4080218913');
}*/

function maybeStart() {
  if (!isStarted && localStream && isChannelReady) {
    if (isInitiator || isMember === '1') {
      createPeerConnection();
      pc.addStream(localStream);
      isStarted = true;
      if (isInitiator) {
        doCall();
      }
    }
  }
}

window.onbeforeunload = function(e){
	sendMessage('bye');
  sendParticipantId(obj.hangupID);
}

/////////////////////////////////////////////////////////

function createPeerConnection() {
  try {
    pc = new RTCPeerConnection(pc_config, pc_constraints);
    pc.onicecandidate = handleIceCandidate;
    console.log('Created RTCPeerConnnection with:\n' +
      '  config: \'' + JSON.stringify(pc_config) + '\';\n' +
      '  constraints: \'' + JSON.stringify(pc_constraints) + '\'.');
  } catch (e) {
    console.log('Failed to create PeerConnection, exception: ' + e.message);
    alert('Cannot create RTCPeerConnection object.');
      return;
  }
  pc.onaddstream = handleRemoteStreamAdded;
  pc.onremovestream = handleRemoteStreamRemoved;

  if (isInitiator) {
    try {
      // Reliable Data Channels not yet supported in Chrome
      sendChannel = pc.createDataChannel("sendDataChannel",
        {reliable: false});
      sendChannel.onmessage = handleMessage;
      trace('Created send data channel');
    } catch (e) {
      alert('Failed to create data channel. ' +
            'You need Chrome M25 or later with RtpDataChannel enabled');
      trace('createDataChannel() failed with exception: ' + e.message);
    }
    sendChannel.onopen = handleSendChannelStateChange;
    sendChannel.onclose = handleSendChannelStateChange;
  } else {
    pc.ondatachannel = gotReceiveChannel;
  }
}

function sendData() {
  var data = document.getElementById("username").firstChild.nodeValue + ": " + sendTextarea.value;
  sendChannel.send(data);
  chatbox.value = chatbox.value + '\n' + data;
  sendTextarea.value = null;
  trace('Sent data: ' + data);
}

function closeDataChannels() {
  trace('Closing data channels');
  sendChannel.close();
  trace('Closed data channel with label: ' + sendChannel.label);
  receiveChannel.close();
  trace('Closed data channel with label: ' + receiveChannel.label);
  localPeerConnection.close();
  remotePeerConnection.close();
  localPeerConnection = null;
  remotePeerConnection = null;
  trace('Closed peer connections');
  startButton.disabled = false;
  sendButton.disabled = true;
  closeButton.disabled = true;
  dataChannelSend.value = "";
  dataChannelReceive.value = "";
  dataChannelSend.disabled = true;
  dataChannelSend.placeholder = "Press Start, enter some text, then press Send.";
 }

function gotReceiveChannel(event) {
  trace('Receive Channel Callback');
  sendChannel = event.channel;
  sendChannel.onmessage = handleMessage;
  sendChannel.onopen = handleReceiveChannelStateChange;
  sendChannel.onclose = handleReceiveChannelStateChange;
}

function handleMessage(event) {
  trace('Received message: ' + event.data);
  //receiveTextarea.value = event.data;
  chatbox.value = chatbox.value + '\n' + event.data;
}

function handleSendChannelStateChange() {
  var readyState = sendChannel.readyState;
  trace('Send channel state is: ' + readyState);
  enableMessageInterface(readyState == "open");
}

function handleReceiveChannelStateChange() {
  var readyState = sendChannel.readyState;
  trace('Receive channel state is: ' + readyState);
  enableMessageInterface(readyState == "open");
}

function enableMessageInterface(shouldEnable) {
    if (shouldEnable) {
    dataChannelSend.disabled = false;
    dataChannelSend.focus();
    dataChannelSend.placeholder = "";
    sendButton.disabled = false;
  } else {
    dataChannelSend.disabled = true;
    sendButton.disabled = true;
  }
}

function handleIceCandidate(event) {
  console.log('handleIceCandidate event: ', event);
  if (event.candidate) {
    sendMessage({
      type: 'candidate',
      label: event.candidate.sdpMLineIndex,
      id: event.candidate.sdpMid,
      candidate: event.candidate.candidate});
  } else {
    console.log('End of candidates.');
  }
}

function doCall() {
  var constraints = {'optional': [], 'mandatory': {'MozDontOfferDataChannel': true}};
  // temporary measure to remove Moz* constraints in Chrome
  if (webrtcDetectedBrowser === 'chrome') {
    for (var prop in constraints.mandatory) {
      if (prop.indexOf('Moz') !== -1) {
        delete constraints.mandatory[prop];
      }
     }
   }
  constraints = mergeConstraints(constraints, sdpConstraints);
  console.log('Sending offer to peer, with constraints: \n' +
    '  \'' + JSON.stringify(constraints) + '\'.');
  pc.createOffer(setLocalAndSendMessage, null, constraints);
}

function doAnswer() {
  console.log('Sending answer to peer.');
  pc.createAnswer(setLocalAndSendMessage, null, sdpConstraints);
}

function mergeConstraints(cons1, cons2) {
  var merged = cons1;
  for (var name in cons2.mandatory) {
    merged.mandatory[name] = cons2.mandatory[name];
  }
  merged.optional.concat(cons2.optional);
  return merged;
}

function setLocalAndSendMessage(sessionDescription) {
  // Set Opus as the preferred codec in SDP if Opus is present.
  sessionDescription.sdp = preferOpus(sessionDescription.sdp);
  pc.setLocalDescription(sessionDescription);
  sendMessage(sessionDescription);
}

function requestTurn(turn_url) {
  var turnExists = false;
  for (var i in pc_config.iceServers) {
    if (pc_config.iceServers[i].url.substr(0, 5) === 'turn:') {
      turnExists = true;
      turnReady = true;
      break;
    }
  }
  if (!turnExists) {
    console.log('Getting TURN server from ', turn_url);
    // No TURN server. Get one from computeengineondemand.appspot.com:
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if (xhr.readyState === 4 && xhr.status === 200) {
        var turnServer = JSON.parse(xhr.responseText);
      	console.log('Got TURN server: ', turnServer);
        pc_config.iceServers.push({
          'url': 'turn:' + turnServer.username + '@' + turnServer.turn,
          'credential': turnServer.password
        });
        turnReady = true;
      }
    };
    xhr.open('GET', turn_url, true);
    xhr.send();
  }
}

function handleRemoteStreamAdded(event) {
  console.log('Remote stream added.');
  if (typeof remoteVideoParticipantID != "undefined")
    remoteVideo.setAttribute('participantID', remoteVideoParticipantID);
  remoteVideo.setAttribute('id','remoteVideo');
  remoteVideo.setAttribute('autoplay', true);
  remoteVideo.setAttribute('controls', true);
  participants.insertBefore(remoteVideo, participants.firstChild);  

 // reattachMediaStream(miniVideo, localVideo);
  attachMediaStream(remoteVideo, event.stream);
  remoteStream = event.stream;
//  waitForRemoteVideo();
}
function handleRemoteStreamRemoved(event) {
  console.log('Remote stream removed. Event: ', event);
}

function hangup() {
  console.log('Hanging up.');
  stop();
  sendMessage('bye');
}

function handleRemoteHangup() {
  console.log('Session terminated.');
  /*var remoteVideo = document.getElementById('remoteVideo');
  remoteVideo.remove();*/
  stop();
  //isInitiator = false;
}

function stop() {
  isStarted = false;
  // isAudioMuted = false;
  // isVideoMuted = false;
  pc.close();
  pc = null;
}

///////////////////////////////////////////

// Set Opus as the default audio codec if it's present.
function preferOpus(sdp) {
  var sdpLines = sdp.split('\r\n');
  var mLineIndex;
  // Search for m line.
  for (var i = 0; i < sdpLines.length; i++) {
      if (sdpLines[i].search('m=audio') !== -1) {
        mLineIndex = i;
        break;
      }
  }
  if (mLineIndex === null) {
    return sdp;
  }

  // If Opus is available, set it as the default in m line.
  for (i = 0; i < sdpLines.length; i++) {
    if (sdpLines[i].search('opus/48000') !== -1) {
      var opusPayload = extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
      if (opusPayload) {
        sdpLines[mLineIndex] = setDefaultCodec(sdpLines[mLineIndex], opusPayload);
      }
      break;
    }
  }

  // Remove CN in m line and sdp.
  sdpLines = removeCN(sdpLines, mLineIndex);

  sdp = sdpLines.join('\r\n');
  return sdp;
}

function extractSdp(sdpLine, pattern) {
  var result = sdpLine.match(pattern);
  return result && result.length === 2 ? result[1] : null;
}

// Set the selected codec to the first in m line.
function setDefaultCodec(mLine, payload) {
  var elements = mLine.split(' ');
  var newLine = [];
  var index = 0;
  for (var i = 0; i < elements.length; i++) {
    if (index === 3) { // Format of media starts from the fourth.
      newLine[index++] = payload; // Put target payload to the first.
    }
    if (elements[i] !== payload) {
      newLine[index++] = elements[i];
    }
  }
  return newLine.join(' ');
}

// Strip CN from sdp before CN constraints is ready.
function removeCN(sdpLines, mLineIndex) {
  var mLineElements = sdpLines[mLineIndex].split(' ');
  // Scan from end for the convenience of removing an item.
  for (var i = sdpLines.length-1; i >= 0; i--) {
    var payload = extractSdp(sdpLines[i], /a=rtpmap:(\d+) CN\/\d+/i);
    if (payload) {
      var cnPos = mLineElements.indexOf(payload);
      if (cnPos !== -1) {
        // Remove CN payload from m line.
        mLineElements.splice(cnPos, 1);
      }
      // Remove CN line in sdp
      sdpLines.splice(i, 1);
    }
  }

  sdpLines[mLineIndex] = mLineElements.join(' ');
  return sdpLines;
}

$( document ).ready(function() {
  if (!isInitiator)
    document.getElementById("start-record").style.display = "none";

  if (localStream == "undefined") {
    document.getElementById("disable-audio").disabled = true;
    document.getElementById("disable-video").disabled = true;
  }
    
  $("#disable-audio").on("click", function(){
    if (localStream != "undefined") {
      localStream.getAudioTracks()[0].enabled = false;
      document.getElementById("enable-audio").style.display = 'inline-block';
      document.getElementById("disable-audio").style.display =  'none';
    }
  });

  $("#enable-audio").on("click", function(){
    if (localStream != "undefined") {
      localStream.getAudioTracks()[0].enabled = false;
      document.getElementById("enable-audio").style.display = 'none';
      document.getElementById("disable-audio").style.display =  'inline-block';
    }
  });

  $("#disable-video").on("click", function(){
    if (localStream != "undefined") {
      localStream.getVideoTracks()[0].enabled = false;
      document.getElementById("enable-video").style.display = 'inline-block';
      document.getElementById("disable-video").style.display =  'none';
    }
  });

  $("#enable-video").on("click", function(){
    if (localStream != "undefined") {
      localStream.getVideoTracks()[0].enabled = true;
      document.getElementById("enable-video").style.display = 'none';
      document.getElementById("disable-video").style.display =  'inline-block';
    }
  });

  $("#snapshot").on("click", function snapshot() {
    var video = document.getElementById('localVideo');
    var canvas = document.getElementById('photo');
    canvas.height = video.videoHeight;
    canvas.width = video.videoWidth;
    canvas.getContext('2d').drawImage(video, 0, 0);
    Canvas2Image.saveAsPNG(canvas);
  });

  $("#hang-up").on("click", function () {
    window.location.replace("dashboard.php");
  });
});
  
var audioRecorder;
var videoRecorder;

function PostBlob(audioblob, videoblob, fileName) {
  // FormData
  var formData = new FormData();
  formData.append('filename', fileName);
  formData.append('audio-blob', audioblob);
  formData.append('video-blob', videoblob);
  xhr('combineAudioVideo.php', formData);
}

function xhr(url, data) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          alert(xmlhttp.responseText);
      }
  };
  
  xmlhttp.open('POST', url);
  xmlhttp.send(data);
}

function recordVideo() {
  document.getElementById("stop-record").style.display = 'inline-block';
  document.getElementById("start-record").style.display = 'none';
  var video = document.getElementById('localVideo');
  var options = {
    type: 'video',
    video: {
        width: video.videoWidth,
        height: video.videoHeight
    },
    canvas: {
        width: video.videoWidth,
        height: video.videoHeight
    }
  };

  videoRecorder = window.RecordRTC(localStream, options);
  videoRecorder.startRecording();
}

function recordAudio() {
  var stream = new window.MediaStream(localStream.getAudioTracks());

  var options = {
    type: 'audio',
  };

  audioRecorder = window.RecordRTC(stream, options);
  audioRecorder.startRecording();
}

function stopRecording() {
  var fileName = Math.round(Math.random() * 99999999) + 99999999;

  if (audioRecorder)
      audioRecorder.stopRecording(function() {
          videoRecorder.stopRecording(function() {
            document.getElementById("stop-record").style.display = 'none';
            document.getElementById("start-record").style.display = 'inline-block';
            PostBlob(audioRecorder.getBlob(), videoRecorder.getBlob(), fileName);
          });
          
      });
}

function initEvents() {
  document.getElementById("start-record").addEventListener('click', recordAudio);
  document.getElementById("start-record").addEventListener('click', recordVideo);
  document.getElementById("stop-record").addEventListener('click', stopRecording);
}

initEvents(); 
