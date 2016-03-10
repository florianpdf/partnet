<?php

namespace AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:User')->findAll();
        $organisme_user_connect = $this->getUser()->getIdOrganisme();
        $id_user_connect = $this->getUser()->getId();

        return $this->render('AnnuaireBundle:Default:index.html.twig', array(
            'entities' => $entities,
            'organisme_user_connect' => $organisme_user_connect,
            'id_user_connect' => $id_user_connect

        ));
    }
}
