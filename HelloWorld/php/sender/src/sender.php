<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

const QUEUE_NAME = "hello";

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare(QUEUE_NAME, false, false, false, false);

$msg = new AMQPMessage("Hello World from PHP!");

$channel->basic_publish($msg, '', QUEUE_NAME);

echo " [PHP] Sent 'Hello World'!\n";

$channel->close();
$connection->close();
