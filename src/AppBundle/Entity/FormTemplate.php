<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\{NotBlank, Type};

class FormTemplate
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    protected $createDate;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 78,
     *      minMessage = "Your topic must be at least {{ limit }} characters long",
     *      maxMessage = "Your topic cannot be longer than {{ limit }} characters"
     * )
     */
    protected $topic;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $addressee;

    /**
     * @Assert\NotBlank()
     */
    protected $mailBody;

    /**
     * @Assert\NotBlank()
     */
    protected $signature;



    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTime $createDate = null)
    {
        $this->createDate = $createDate;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    public function getAddressee()
    {
        return $this->addressee;
    }

    public function setAddressee($addressee)
    {
        $this->addressee = $addressee;
    }

    public function getMailBody()
    {
        return $this->mailBody;
    }

    public function setMailBody($mailBody)
    {
        $this->mailBody = $mailBody;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('topic', new Assert\Length(array(
                'min' => 1,
                'max' => 78,
                'minMessage' => 'Your topic must be at least {{ limit }} characters long',
                'maxMessage' => 'Your topic cannot be longer than {{ limit }} characters'
                )));

        $metadata
            ->addPropertyConstraint('createDate', new NotBlank())
            ->addPropertyConstraint('createDate', new Type('\DateTime'));

        $metadata
            ->addPropertyConstraint('addressee', new NotBlank())
            ->addPropertyConstraint('addressee', new Assert\Email(array(
                'message' => 'The email "{{ value }}" is not a valid email.',
                'checkMX' => true)));

        $metadata->addPropertyConstraint('mailBody', new NotBlank());
        $metadata->addPropertyConstraint('signature', new NotBlank());
    }
}