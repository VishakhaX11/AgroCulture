const http = require('http');
const socketio = require('socket.io');

const server = http.createServer();
const io = socketio(server);

io.on('connection', (socket) => {
  console.log('New client connected');

  socket.on('message', (data) => {
    console.log('Received message: ' + data);

    socket.broadcast('message', data);
  });
});

server.listen(8080);
console.log('Listening on port 8080');
