import pika
import sys
import time

QUEUE_NAME = 'task_queue'

connection = pika.BlockingConnection(
    pika.ConnectionParameters(host='rabbitmq')
)

channel = connection.channel()

channel.queue_declare(queue=QUEUE_NAME, durable=True)

print('[PY] Waiting for messages. To exit press Ctrl + C')

def callback(ch, method, properties, body):
    print("[PY] Received %r" % body.decode())
    time.sleep(body.count(b'.'))
    print('[PY] Done!')
    ch.basic_ack(delivery_tag=method.delivery_tag)

channel.basic_qos(prefetch_count=1)
channel.basic_consume(queue=QUEUE_NAME, on_message_callback=callback)

channel.start_consuming()