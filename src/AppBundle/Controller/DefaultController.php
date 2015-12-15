<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nb = $em->getRepository('GedBundle:Documents')->getNbDocuments();
        $nb_month = $em->getRepository('GedBundle:Documents')->getNbDocumentsMonth();

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            return $this->redirectToRoute('fos_user_security_login');

        return $this->render('default/index.html.twig', array(
            'nb' => $nb,
            'nb_month' => $nb_month
        ));
    }

    public function adminAction()
    {
        return $this->render('AppBundle:admin:index.html.twig');
    }
}