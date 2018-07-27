<?php

namespace AppBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use AppBundle\Entity\FormTemplate;


class ReadNode implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        $mailModel = unserialize($msg->body);

        $message = (new \Swift_Message($mailModel->getTopic()))
                        ->setFrom('MyEmail@gmail.com')
                        ->setTo($mailModel->getTopic())
                        ->setBody($mailModel->getMailBody());

        $mailer->send($message);
    }
}