<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\MailForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FormTemplate;
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

            $this->get('old_sound_rabbit_mq.mail_sender_producer')->publish(serialize($exampleForm));

            $this->addFlash('notice', 'Your message was sent!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
