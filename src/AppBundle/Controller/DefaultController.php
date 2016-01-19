<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        $actus = $this->container->get('app.actu')->getActualites();

        return $this->render('default/index.html.twig', array(
            'nb' => $nb,
            'nb_month' => $nb_month,
            'results' => $actus
        ));
    }



    public function adminAction()
    {
        return $this->render('AppBundle:admin:index.html.twig');
    }
}