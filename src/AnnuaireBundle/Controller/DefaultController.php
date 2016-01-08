<?php

namespace AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('AnnuaireBundle:Default:index.html.twig', array(
            'entities' => $entities));
    }
}
