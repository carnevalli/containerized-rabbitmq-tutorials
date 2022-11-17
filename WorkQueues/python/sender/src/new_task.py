import pika
import sys

QUEUE_NAME = 'task_queue'

connection = pika.BlockingConnection(
    pika.ConnectionParameters(host='rabbitmq')
)

channel = connection.channel()

channel.queue_declare(queue=QUEUE_NAME, durable=True)

message = ' '.join(sys.argv[1:]) or "Hello World from Python!"

channel.basic_publish(
    exchange='',
    routing_key=QUEUE_NAME,
    body=message,
    properties=pika.BasicProperties(
        delivery_mode=pika.spec.PERSISTENT_DELIVERY_MODE,
    )
)

print('[PY] Sent %r' % message)
connection.close()