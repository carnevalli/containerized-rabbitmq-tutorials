var amqp = require('amqplib/callback_api');

const queue_name = "task_queue";

amqp.connect("amqp://rabbitmq", function(error0, connection) {
    if(error0) {
        throw error0;
    }

    connection.createChannel(function(error1, channel) {
        if(error1) {
            throw error1;
        }

        const msg = process.argv.slice(2).join(' ') || "Hello World from Javascript!";

        channel.assertQueue(queue_name, {
            durable: true
        });

        channel.sendToQueue(queue_name, Buffer.from(msg), {
            persistent: true
        });
        
        console.log("[JS] Sent '%s'", msg);
    });

    setTimeout(function() {
        connection.close();
        process.exit(0);
    }, 500);
});