var app = require('express')(),
    server = require('http').Server(app),
    io = require('socket.io')(server);


var redis = require('redis');
    redis = redis.createClient();
var requestify = require('requestify');

function log(log) { console.log('[APP] ' + log) }

server.listen(8081);
log('Локальный сервер запущен на порте 8081');
 
/* USERS ONLINE SITE */

io.sockets.on('connection', function(socket) {

    updateOnline();

    socket.on('disconnect', function(){
        updateOnline();
    })
});

function updateOnline(){
    io.sockets.emit('online', Object.keys(io.sockets.adapter.rooms).length);
    console.info('Connected ' + Object.keys(io.sockets.adapter.rooms).length + ' clients');
}

/* USERS ONLINE SITE END */

redis.subscribe('update_balance');
redis.subscribe('update_balance_after');
redis.subscribe('live_drops');

redis.on('message', function(channel, message) {
    if(channel == 'live_drops') setTimeout(function() {
        io.sockets.emit('live_drops', JSON.parse(message));
    }, 8000);
    
    if(channel == 'update_balance') io.sockets.emit('update_balance', JSON.parse(message));
    
    if(channel == 'update_balance_after') setTimeout(function() {
        io.sockets.emit('update_balance', JSON.parse(message));
    }, 8000);
});