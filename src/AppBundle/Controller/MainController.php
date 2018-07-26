<?php

namespace AppBundle\Controller;

use AppBundle\Form\MailForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
//
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $exampleForm = $form->getData();
            $topic = $exampleForm->getTopic();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
