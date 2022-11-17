var amqp = require('amqplib/callback_api');

const queueName = 'task_queue';

amqp.connect('amqp://rabbitmq', function(error0, connection) {
    if(error0) {
        throw error0;
    }

    connection.createChannel(function(error1, channel) {
        if(error1) {
            throw error1;
        }

        channel.assertQueue(queueName, {
            durable: true
        });

        channel.prefetch(1);

        console.log("[JS] Waiting for messages in %s. To exit send 'exit' as message body text.", queueName);

        channel.consume(queueName, function(msg) {
            var secs = msg.content.toString().split('.').length - 1;

            console.log("[JS] Received %s", msg.content.toString());

            if(msg.content.toString() == "exit") {
                channel.ack(msg);
                console.log("[JS] Worker is exiting...");
                setTimeout(() => connection.close(), 1000);
                return;
            }

            setTimeout(function(){
                console.log("[JS] Done!");
                channel.ack(msg);
            }, secs * 1000);
        }, {
            noAck: false,
        });        
    });
});