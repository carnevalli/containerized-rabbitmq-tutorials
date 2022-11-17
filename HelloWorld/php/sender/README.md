# RabbitMQ PHP Sender Docker Container

Demo source code from [Official RabbitMQ Tutorials](https://www.rabbitmq.com/tutorials/tutorial-one-php.html).

This container requires:
- The initial setup of a user-defined bridge network named `rabbitmq-tutorials`;
- A running RabbitMQ container. 

Please, read the instructions at this repository main page for more details.

# How to use:

Build the image from the Dockerfile:

```
docker build . -t php-rabbitmq-sender
```

Run the container:

```
docker run --rm --net rabbitmq-tutorials php-rabbitmq-sender
```
