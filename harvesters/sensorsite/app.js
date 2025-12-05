import http from 'http';
import fs from 'fs';
import { SerialPort, ReadlineParser } from 'serialport';
import { Server } from 'socket.io';
import sendGrid from "@sendgrid/mail";


const index = fs.readFileSync('index.html');
const arduinoPort = 'COM5' //change as need
const parser = new ReadlineParser({ delimiter: '\r\n' });

const apiKey = "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"; //sendgrid api key
const emailTo = "mjt5552@g.rit.edu"  //change to desired email
const MoisturePref = 21;

sendGrid.setApiKey(apiKey)
const MessageData = { //email sent when moisture goes below threshold
    to: emailTo,
    from: "mjt5552@g.rit.edu",
    subject: "Low moisture detected",
    text: "please water your plant"
};


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

var lowCount= 0;

const io = new Server(app, {
  cors: { origin: '*' }
});

io.on('connection', function(socket) {
    
    console.log('Node is listening to port');
    
});

parser.on('data', function(data) {
    
    console.log('Received data from port: ' + data);

    io.emit('data', data);
    var intData = parseInt(data);

    if(intData<MoisturePref){
        lowCount++;
    }
    else if(intData>MoisturePref){
        lowCount=0;
    }
    if (lowCount>=3){
        sendGrid.send(MessageData);
        lowCount=0;
    }
    
});

app.listen(3000);
