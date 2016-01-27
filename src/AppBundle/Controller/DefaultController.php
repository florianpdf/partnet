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
        $organismes = $em->getRepository('AppBundle:Organisme')->findAll();

        $date = new \DateTime();
        $years = $date->format('Y-m-d');
        $years = substr($years, 0, 4);

        $statistiques_par_mois_global = $statistiques->getStatistiquesParMois($years);
        $statistiques_par_mois_accueil = $statistiques->getStatistiquesParMoisAccueil($years);
        $statistiques_par_mois_ged = $statistiques->getStatistiquesParMoisGed($years);
        $statistiques_par_mois_formation = $statistiques->getStatistiquesParMoisFormation($years);
        $statistiques_par_mois_emploi = $statistiques->getStatistiquesParMoisEmploi($years);
        $statistiques_par_mois_annuaire = $statistiques->getStatistiquesParMoisAnnuaire($years);
        $statistiques_par_mois_dialogue = $statistiques->getStatistiquesParMoisDialogue($years);
        $statistiques_par_mois_agenda = $statistiques->getStatistiquesParMoisAgenda($years);

        $data_global = [];
        foreach ($statistiques_par_mois_global as $statistique_par_mois_global)
        {
            array_push($data_global, $statistique_par_mois_global['visites']);
        }

        $data_accueil = [];
        foreach ($statistiques_par_mois_accueil as $statistique_par_mois_accueil)
        {
            array_push($data_accueil, $statistique_par_mois_accueil['visites']);
        }

        $data_ged = [];
        foreach ($statistiques_par_mois_ged as $statistique_par_mois_ged)
        {
            array_push($data_ged, $statistique_par_mois_ged['visites']);
        }

        $data_formation = [];
        foreach ($statistiques_par_mois_formation as $statistique_par_mois_formation)
        {
            array_push($data_formation, $statistique_par_mois_formation['visites']);
        }

        $data_emploi = [];
        foreach ($statistiques_par_mois_emploi as $statistique_par_mois_emploi)
        {
            array_push($data_emploi, $statistique_par_mois_emploi['visites']);
        }

        $data_annuaire = [];
        foreach ($statistiques_par_mois_annuaire as $statistique_par_mois_annuaire)
        {
            array_push($data_annuaire, $statistique_par_mois_annuaire['visites']);
        }

        $data_dialogue = [];
        foreach ($statistiques_par_mois_dialogue as $statistique_par_mois_dialogue)
        {
            array_push($data_dialogue, $statistique_par_mois_dialogue['visites']);
        }

        $data_agenda = [];
        foreach ($statistiques_par_mois_agenda as $statistique_par_mois_agenda)
        {
            array_push($data_agenda, $statistique_par_mois_agenda['visites']);
        }




//        foreach ($organismes as $organisme)
//        {
//            foreach ($statistiques_par_mois_accueil as $statistique_par_mois_accueil)
//            {
//                if (in_array($organisme->getNom(), $statistique_par_mois_accueil))
//                {
//                    $plop = array_combine($organisme->getNom(), $statistique_par_mois_accueil);
//                }
//            }
//        }

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
            'statistiques_par_mois_global' => $statistiques_par_mois_global,
            'data_global' => json_encode($data_global),
            'data_accueil' => json_encode($data_accueil),
            'data_ged' => json_encode($data_ged),
            'data_formation' => json_encode($data_formation),
            'data_emploi' => json_encode($data_emploi),
            'data_annuaire' => json_encode($data_annuaire),
            'data_dialogue' => json_encode($data_dialogue),
            'data_agenda' => json_encode($data_agenda)
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