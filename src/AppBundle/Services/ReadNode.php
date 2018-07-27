<?php

namespace AppBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use AppBundle\Entity\FormTemplate;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReadNode implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
//        $mailModel = $serializer->deserialize($msg, FormTemplate::class, 'json');
        $body = $msg->getBody();
        $mailModel = json_decode($body, true);
//        $mailModel = $serializer->deserialize($msg, FormTemplate::class, 'json');
            var_dump($mailModel);
//        $mail = (new \Swift_Message($mailModel->getTopic()))
//            ->setTo($mailModel->getAddressee())
//            ->setBody($mailModel->getMailBody())
//            ->setSender($mailModel->getSignature());

        echo $msg->getBody();
       }
}