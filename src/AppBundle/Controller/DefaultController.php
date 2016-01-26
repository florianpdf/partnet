<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use UserBundle\Entity\Statistiques;


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

        $this->stats($em);

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

    public function StatistiquesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $statistiques = $em->getRepository('UserBundle:Statistiques');

        $nb_connection_par_jour = $statistiques->getNbConnectionParJour();
        $nb_connection_par_mois = $statistiques->getNbConnectionParMois();

        $statistiques_par_mois_accueil = $statistiques->getStatistiquesParMois();

//        $organismes = [];
//        foreach ($statistiques_organisme as $statistique_organisme){
//            $organismes[] = $statistique_organisme->getUser()->getIdOrganisme()->getNom();
//        }
//
//        $statistiques_organisme_par_mois = array_count_values($organismes);
//
//        $statistiques_par_mois = $statistiques->findBy(array(), array('date' => 'ASC'));

        $janvier = [];
        $fevrier = [];
        $mars = [];
        $avril = [];
        $mai = [];
        $juin = [];
        $juillet = [];
        $aout = [];
        $septembre = [];
        $octobre = [];
        $novembre = [];
//        $decembre = [];
//        foreach ($statistiques_par_mois as $statistique_par_moi)
//        {
//            if (
//                $statistique_par_moi->getDate()->getTimestamp() > new \DateTime('2016-01-01') &&
//                $statistique_par_moi->getDate()->getTimestamp() < new \DateTime('2016-01-31'))
//            {
//                $janvier = $statistique_par_moi;
//            }
//
//        }

//        array(
//
//            array('stat1', '01/01/50', 'flkrepof')
//            array('stat1', '03/01/50', 'flkrepof')
//            array('stat1', '01/06/50', 'flkrepof')
//            array('stat1', '01/01/50', 'flkrepof')
//            array('stat1', '01/01/50', 'flkrepof')
//
//        )
//
//        $organismes = [];
//        foreach ($statistiques_organisme as $statistique_organisme){
//            $organismes[] = $statistique_organisme->getUser()->getIdOrganisme()->getNom();
//        }
//
//        $statistiques_organisme_par_mois = array_count_values($organismes);


        return $this->render('AppBundle:statistiques:index.html.twig', array(
            'nb_connection_par_jour' => $nb_connection_par_jour,
            'nb_connection_par_mois' => $nb_connection_par_mois,
            'statistiques_par_mois_accueil' => $statistiques_par_mois_accueil
        ));
    }

    public function stats($em)
    {
        $statistiques = $em->getRepository('UserBundle:Statistiques');

        $current_user = $this->get('security.token_storage')->getToken()->getUser();

        if ($statistiques->findOneBy(array('user' => $current_user, 'date' => new \DateTime())) == null){
            $stats = new Statistiques();
            $stats->setUser($current_user);
            $stats->setDate(new \DateTime());
            $stats->setNbVisitesAccueil(+1);
            $em->persist($stats);
            $em->flush();
        }
        else
        {
            $stats = $statistiques->findOneBy(array('user' => $current_user, 'date' => new \DateTime()));
            $stats->setNbVisitesAccueil($stats->getNbVisitesAccueil()+1);
            $em->flush();
        }
    }
}