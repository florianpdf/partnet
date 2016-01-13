<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Affichage de la page d'accueil
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nb = $em->getRepository('GedBundle:Documents')->getNbDocuments();
        $nb_month = $em->getRepository('GedBundle:Documents')->getNbDocumentsMonth();

        $documents = $em->getRepository('GedBundle:Documents')->findBy(array('fil_actu' => 1));
        $events = $em->getRepository('AgendaBundle:Events')->findBy(array('fil_actu' => 1));

        $actus = array_merge($documents, $events);
        function getSort()
        {
            return function ($a, $b) {
                if ($a->getDateAjout() < $b->getDateAjout())
                    return 1;
                if ($a->getDateAjout() > $b->getDateAjout())
                    return -1;
                return 0;
            };
        }
        usort($actus, getSort());

        $results = array_slice($actus, 0, 10);

        return $this->render('default/index.html.twig', array(
            'nb' => $nb,
            'nb_month' => $nb_month,
            'results' => $results
        ));
    }

    public function adminAction()
    {
        return $this->render('AppBundle:admin:index.html.twig');
    }
}