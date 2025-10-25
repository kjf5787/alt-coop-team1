import http from 'http';
import fs from 'fs';
import { SerialPort, ReadlineParser } from 'serialport';
import { Server } from 'socket.io';

const index = fs.readFileSync('index.html');
const arduinoPort = 'COM5' //change as need

const parser = new ReadlineParser({ delimiter: '\r\n' });
var port = new SerialPort({ 
    path: arduinoPort,
    baudRate: 9600,
    dataBits: 8,
    parity: 'none',
    stopBits: 1,
    flowControl: false
});

port.pipe(parser);

var app = http.createServer(function(req, res) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.end(index);
});

const io = new Server(app, {
  cors: { origin: '*' }
});

io.on('connection', function(socket) {
    
    console.log('Node is listening to port');
    
});

parser.on('data', function(data) {
    
    console.log('Received data from port: ' + data);
    
    io.emit('data', data);
    
});

app.listen(3000);