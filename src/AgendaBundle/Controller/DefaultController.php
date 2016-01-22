<?php

namespace AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgendaBundle\Entity\events;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organismes = $em->getRepository('AppBundle:Organisme')->findAll();

        return $this->render('AgendaBundle:Default:index.html.twig', array(
            'organismes' => $organismes
        ));
    }
}
