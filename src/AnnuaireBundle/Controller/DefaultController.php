<?php

namespace AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Statistiques;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $this->stats($em);

        $entities = $em->getRepository('UserBundle:User')->findAll();
        $organisme_user_connect = $this->getUser()->getIdOrganisme();
        $id_user_connect = $this->getUser()->getId();

        return $this->render('AnnuaireBundle:Default:index.html.twig', array(
            'entities' => $entities,
            'organisme_user_connect' => $organisme_user_connect,
            'id_user_connect' => $id_user_connect

        ));
    }

    public function stats($em)
    {
        $statistiques = $em->getRepository('UserBundle:Statistiques');

        $current_user = $this->get('security.token_storage')->getToken()->getUser();

        $stats = $statistiques->findOneBy(array('user' => $current_user, 'date' => new \DateTime()));
        $stats->setNbVisitesAnnuaire($stats->getNbVisitesAnnuaire()+1);
        $em->flush();
    }
}
