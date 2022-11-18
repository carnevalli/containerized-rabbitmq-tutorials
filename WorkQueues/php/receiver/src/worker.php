<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

const QUEUE_NAME = 'task_queue';

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare(QUEUE_NAME, false, true, false, false);

echo " [PHP] Waiting for messages. To exit send an \"exit\" message.\n";

$callback = function($msg) {
    echo '[PHP] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo "[PHP] Done!\n";
    $msg->ack();

    if($msg->body == 'exit') {
        echo "[PHP] Received an 'exit' message. Leaving...\n";
        $msg->getChannel()->close();
    }
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume(QUEUE_NAME, '', false, false, false, false, $callback);

while($channel->is_open()) {
    $channel->wait();
}

echo "The channel was closed.\n";

$connection->close();

echo "Connection closed. Leaving worker.\n";