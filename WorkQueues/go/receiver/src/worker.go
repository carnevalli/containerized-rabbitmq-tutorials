package main

import (
	"bytes"
	"log"
	"time"

	amqp "github.com/rabbitmq/amqp091-go"
)

const QueueName = "task_queue"

func failOnError(err error, msg string) {
	if err != nil {
		log.Panicf("%s: %s", msg, err)
	}
}

func main() {
	conn, err := amqp.Dial("amqp://guest:guest@rabbitmq:5672")
	failOnError(err, "Failed to connecto to RabbitMQ")
	defer conn.Close()

	ch, err := conn.Channel()
	failOnError(err, "Failed to create a channel")
	defer ch.Close()

	q, err := ch.QueueDeclare(
		QueueName, // queue name
		true,      // durable
		false,     // delete when unused
		false,     // exclusive
		false,     // no-waint
		nil,       // arguments
	)

	failOnError(err, "Failed to declare a queue")

	err = ch.Qos(
		1,     // prefetch count
		0,     // prefetch size
		false, // global
	)

	failOnError(err, "Failed to set QoS")

	msgs, err := ch.Consume(
		q.Name, // queue
		"",     // consumer
		false,  // auto-ack
		false,  // exclusive
		false,  // no local
		false,  // no-waint
		nil,    //args
	)

	failOnError(err, "Failed to register a consumer")

	forever := make(chan struct{})

	go func() {
		for d := range msgs {
			log.Printf("[GO] Received a message: %s", d.Body)
			dotCount := bytes.Count(d.Body, []byte("."))
			t := time.Duration(dotCount)
			time.Sleep(t * time.Second)
			log.Printf("Done")
			d.Ack(false)

			if string(d.Body) == "exit" {
				print("Exiting channel...")
				forever <- struct{}{}
				return
			}
		}
	}()

	log.Printf("[GO] Waiting for messages. To exit send \"exit\" or press Ctrl + C.")
	<-forever
	print("Exiting program....")
}
