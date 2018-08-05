<?php

namespace AppBundle\Form\Type;

// Pogrupowanie deklaracji
use AppBundle\Entity\FormTemplate;
use Symfony\Component\Form\{AbstractType, FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{TextareaType, TextType, EmailType, DateTimeType};

class MailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createDate', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy HH:mm',
                'data' => new \DateTime('now'),
                'attr' => array(
                    'readonly' => true,
                )))
            ->add('topic', TextType::class)
            ->add('addressee', EmailType::class)
            ->add('mailBody', TextareaType::class)
            ->add('signature', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FormTemplate::class,
        ));
    }
}