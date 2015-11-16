<?php

namespace GedBundle\Controller;

use GedBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $task = new Task();
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createForm('task', $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('task_success');
        }

        return $this->render('GedBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}