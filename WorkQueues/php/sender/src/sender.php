<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

const QUEUE_NAME = "task_queue";

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare(QUEUE_NAME, false, true, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) {
    $data = 'Hello world from PHP!';
}

$msg = new AMQPMessage(
    $data, 
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);

$channel->basic_publish($msg, '', QUEUE_NAME);

echo '[PHP] Sent ', $data, "\n";

$channel->close();
$connection->close();