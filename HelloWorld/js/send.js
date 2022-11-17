const amqp = require("amqplib/callback_api");

const connStr = "amqp://guest:guest@localhost:5672/"
amqp.connect(connStr, function(error0, connection) {
    if(error0) {
        throw error0;
    }

    connection.createChannel(function(error1, channel) {
        if(error1) {
            throw error1;
        }

        var queue = "hello";
        var msg = "Hello World from JS!";

        channel.assertQueue(queue, {
            durable: false
        });
        channel.sendToQueue(queue, Buffer.from(msg));

        console.log(" [JS]: Sent %s", msg)
    });
    setTimeout(function() {
        connection.close();
        process.exit(0);
    }, 500);
});