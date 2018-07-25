<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\FormTemplate;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function createAction(Request $request)
    {
        $exampleForm = new FormTemplate();
        $exampleForm->setTopic('Topic');
        $exampleForm->setAddressee('example@gmail.com');
        $exampleForm->setMailBody('Message content...');
        $exampleForm->setSignature('XXX');
        $exampleForm->setCreateDate(new \DateTime('now'));

        $form = $this->createFormBuilder($exampleForm)
            ->add('createDate', DateType::class)
            ->add('topic', TextType::class)
            ->add('addressee', EmailType::class)
            ->add('mailBody', TextType::class)
            ->add('signature', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Send Message'))
            ->getForm();

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
