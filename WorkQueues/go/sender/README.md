# RabbitMQ Work Queues - Go Sender Docker Container

Demo source code from [Official RabbitMQ Tutorials](https://www.rabbitmq.com/tutorials/tutorial-two-go.html).

This container requires:
- The initial setup of a user-defined bridge network named `rabbitmq-tutorials`;
- A running RabbitMQ container. 

Please, read the instructions at this repository main page for more details.

# How to use:

Build the image from the Dockerfile:

```
docker build -t rmq-workqueues-go-sender .
```

Run the container:

```
docker run --rm -it --network rabbitmq-tutorials rmq-workqueues-go-sender [message]
```
