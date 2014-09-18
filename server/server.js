var static = require('node-static');
var http = require('http');
var file = new(static.Server)();
var app = http.createServer(function (req, res) {
  file.serve(req, res);
}).listen(2013);

var io = require('socket.io').listen(app);

var getUsersInRoomNumber = function(roomName, namespace) {
    if (!namespace) namespace = '/';
    var room = io.nsps[namespace].adapter.rooms[roomName];
    if (!room) return 0;
    return Object.keys(room).length;
}

io.sockets.on('connection', function (socket){

  // convenience function to log server messages on the client
	function log(){
		var array = [">>> Message from server: "];
	  for (var i = 0; i < arguments.length; i++) {
	  	array.push(arguments[i]);
	  }
	    socket.emit('log', array);
	}

	socket.on('message', function (message) {
		log('Got message:', message);
    // for a real app, would be room only (not broadcast)
		socket.broadcast.emit('message', message);
	});

	socket.on('create or join', function (room) {
		var numClients = getUsersInRoomNumber(room) + 1;
		
		log('Room ' + room + ' has ' + numClients + ' client(s)');
		log('Request to create or join room ' + room);

		if (numClients === 1){
			socket.join(room);
			socket.emit('created', room);
		} else if (numClients <= 5) {
			io.sockets.in(room).emit('join', room);
			io.sockets.in(room).emit('participantIDs', numClients);
			socket.join(room);
			socket.emit('joined', room);
			socket.emit('participantID', numClients);
		} else { // max five clients
			socket.emit('full', room);
		}
		socket.emit('emit(): client ' + socket.id + ' joined room ' + room);
		socket.broadcast.emit('broadcast(): client ' + socket.id + ' joined room ' + room);

	});

});

