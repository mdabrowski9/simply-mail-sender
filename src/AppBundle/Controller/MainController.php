<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\MailForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FormTemplate;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function createAction(Request $request)
    {
        $exampleForm = new FormTemplate();

        $form = $this->createForm(MailForm::class, $exampleForm, []);
        $form->add('save', SubmitType::class, array(
            'label' => 'Send Message',
            'attr'  => array('class' => 'btn btn-default pull-right'),
            ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($exampleForm, 'json');
            $this->get('old_sound_rabbit_mq.mail_sender_producer')->publish($jsonContent);

            $this->addFlash('notice', 'Your message was sent!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
