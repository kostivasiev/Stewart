var server = require('http').Server();


// var fs = require( 'fs' );
// var app = require('express')();
// var https        = require('https');
// var server = https.createServer({
//     key: fs.readFileSync('./certs/server.key'),
//     cert: fs.readFileSync('./certs/server.crt'),
//     // ca: fs.readFileSync('./test_ca.crt'),
//     requestCert: false,
//     rejectUnauthorized: false
// },app);
// server.listen(8080);


var io = require('socket.io')(server);

var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('test-channel');

redis.on('message', function(channel,message) {
  console.log(message);
  message = JSON.parse(message);
  io.emit(channel + ":" + message.event, message.data);
  // io.emit('chat message', "A new user signed up!");
});

io.on('connection', function(socket){
  socket.on('chat message', function(msg){
    console.log(msg);
    io.emit('chat message', msg);
  });
});

server.listen(3000);
