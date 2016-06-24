<?php

namespace AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AgendaBundle\Entity\events;
use UserBundle\Entity\Statistiques;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organismes = $em->getRepository('AppBundle:Organisme')->findAll();

        $this->stats($em);

        return $this->render('AgendaBundle:Default:index.html.twig', array(
            'organismes' => $organismes
        ));
    }

    public function stats($em)
    {
        $statistiques = $em->getRepository('UserBundle:Statistiques');

        $current_user = $this->get('security.token_storage')->getToken()->getUser();

        $stats = $statistiques->findOneBy(array('user' => $current_user, 'date' => new \DateTime()));
        $stats->setNbVisitesAgenda($stats->getNbVisitesAgenda()+1);
        $em->flush();
    }

}
