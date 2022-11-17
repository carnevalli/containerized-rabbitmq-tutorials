const amqp = require('amqplib/callback_api');

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

        channel.assertQueue(queue, {
            durable: false
        });

        console.log(" [JS] Waiting for messages in %s. To exit, press CTRL + C", queue);

        channel.consume(queue, function(msg) {
            console.log(" [JS] Received %s", msg.content.toString());
        }, { noAck: true });
    });
});