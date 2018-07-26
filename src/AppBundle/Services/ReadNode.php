<?php

namespace AppBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ReadNode implements ConsumerInterface
{

    public function execute(AMQPMessage $msg)
    {
        $topic=$msg->topic;

        echo $topic;
    }
}