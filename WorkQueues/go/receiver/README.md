# RabbitMQ Work Queues - Go Worker Docker Container

Demo source code from [Official RabbitMQ Tutorials](https://www.rabbitmq.com/tutorials/tutorial-two-go.html).

This container requires:
- The initial setup of a user-defined bridge network named `rabbitmq-tutorials`;
- A running RabbitMQ container. 

Please, read the instructions at this repository main page for more details.

# How to use:

Build the image from the Dockerfile:

```
docker build -t rmq-workqueues-go-receiver .-go-receiver
```

Run the container:

```
docker run --rm --network rabbitmq-tutorials rmq-workqueues-go-receiver
```
