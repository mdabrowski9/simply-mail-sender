<?php

namespace AppBundle\Services;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\FormTemplate;
use Symfony\Bundle\MonologBundle\SwiftMailer;
use Symfony\Bundle\SwiftmailerBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReadNode
{
    /** @var ContainerInterface $container */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {

        $this->container = $container;
    }

    /**
     * @param AMQPMessage $msg
     * @return bool
     */
    public function execute(AMQPMessage $msg) {

       return $this->prepareAndSendMail($msg);
    }

    /**
     * @param AMQPMessage $msg
     * @return int
     */
    public function prepareAndSendMail($msg) {
        $mailModel = unserialize($msg->body);

        $message = (new \Swift_Message($mailModel->getTopic()))
            ->setFrom('mmarcindabrowski@gmail.com')
            ->setTo($mailModel->getAddressee())
            ->setSubject($mailModel->getTopic())
            ->setBody($mailModel->getMailBody());

        $mailer = $this->getMailer();
        $mailer->send($message);

        return ConsumerInterface::MSG_ACK;
    }

    /**
     * @return \Swift_Mailer
     */
    protected function getMailer() {
        /** @var \Swift_Mailer $swiftMailer */
        $swiftMailer = $this->container->get('swiftmailer.mailer.default');

        return $swiftMailer;
    }
}