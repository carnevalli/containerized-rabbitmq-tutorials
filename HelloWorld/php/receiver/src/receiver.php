<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

const QUEUE_NAME = 'hello';

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare(QUEUE_NAME, false, false, false, false);

echo "[PHP] Waiting for messages. To exit, press CTRL + C.\n";

$callback = function($msg) {
    echo "[PHP] Received ", $msg->body, "\n";
};

$channel->basic_consume(QUEUE_NAME, '', false, true, false, false, $callback);

while($channel->is_open()) {
    $channel->wait();
}