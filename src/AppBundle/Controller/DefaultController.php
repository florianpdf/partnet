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

        $data_global = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );

        foreach ($statistiques_par_mois_global as $statistique_par_mois_global)
        {
            $month = substr($statistique_par_mois_global['month'], 5, 6);
            if ($month == 1)
                $data_global['janvier'] = $statistique_par_mois_global['visites'];
            if ($month == 2)
                $data_global['fevrier'] = $statistique_par_mois_global['visites'];
            if ($month == 3)
                $data_global['mars'] = $statistique_par_mois_global['visites'];
            if ($month == 4)
                $data_global['avril'] = $statistique_par_mois_global['visites'];
            if ($month == 5)
                $data_global['mai'] = $statistique_par_mois_global['visites'];
            if ($month == 6)
                $data_global['juin'] = $statistique_par_mois_global['visites'];
            if ($month == 7)
                $data_global['juillet'] = $statistique_par_mois_global['visites'];
            if ($month == 8)
                $data_global['aout'] = $statistique_par_mois_global['visites'];
            if ($month == 9)
                $data_global['septembre'] = $statistique_par_mois_global['visites'];
            if ($month == 10)
                $data_global['octobre'] = $statistique_par_mois_global['visites'];
            if ($month == 11)
                $data_global['novembre'] = $statistique_par_mois_global['visites'];
            if ($month == 12)
                $data_global['decembre'] = $statistique_par_mois_global['visites'];
        }

        $data_accueil = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_accueil as $statistique_par_mois_accueil)
        {
            $month = substr($statistique_par_mois_accueil['month'], 5, 6);
            if ($month == 1)
                $data_accueil['janvier'] = $statistique_par_mois_accueil['visites'];
            if ($month == 2)
                $data_accueil['fevrier'] = $statistique_par_mois_accueil['visites'];
            if ($month == 3)
                $data_accueil['mars'] = $statistique_par_mois_accueil['visites'];
            if ($month == 4)
                $data_accueil['avril'] = $statistique_par_mois_accueil['visites'];
            if ($month == 5)
                $data_accueil['mai'] = $statistique_par_mois_accueil['visites'];
            if ($month == 6)
                $data_accueil['juin'] = $statistique_par_mois_accueil['visites'];
            if ($month == 7)
                $data_accueil['juillet'] = $statistique_par_mois_accueil['visites'];
            if ($month == 8)
                $data_accueil['aout'] = $statistique_par_mois_accueil['visites'];
            if ($month == 9)
                $data_accueil['septembre'] = $statistique_par_mois_accueil['visites'];
            if ($month == 10)
                $data_accueil['octobre'] = $statistique_par_mois_accueil['visites'];
            if ($month == 11)
                $data_accueil['novembre'] = $statistique_par_mois_accueil['visites'];
            if ($month == 12)
                $data_accueil['decembre'] = $statistique_par_mois_accueil['visites'];
        }

        $data_ged = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_ged as $statistique_par_mois_ged)
        {
            $month = substr($statistique_par_mois_ged['month'], 5, 6);
            if ($month == 1)
                $data_ged['janvier'] = $statistique_par_mois_ged['visites'];
            if ($month == 2)
                $data_ged['fevrier'] = $statistique_par_mois_ged['visites'];
            if ($month == 3)
                $data_ged['mars'] = $statistique_par_mois_ged['visites'];
            if ($month == 4)
                $data_ged['avril'] = $statistique_par_mois_ged['visites'];
            if ($month == 5)
                $data_ged['mai'] = $statistique_par_mois_ged['visites'];
            if ($month == 6)
                $data_ged['juin'] = $statistique_par_mois_ged['visites'];
            if ($month == 7)
                $data_ged['juillet'] = $statistique_par_mois_ged['visites'];
            if ($month == 8)
                $data_ged['aout'] = $statistique_par_mois_ged['visites'];
            if ($month == 9)
                $data_ged['septembre'] = $statistique_par_mois_ged['visites'];
            if ($month == 10)
                $data_ged['octobre'] = $statistique_par_mois_ged['visites'];
            if ($month == 11)
                $data_ged['novembre'] = $statistique_par_mois_ged['visites'];
            if ($month == 12)
                $data_ged['decembre'] = $statistique_par_mois_ged['visites'];
        }

        $data_formation = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_formation as $statistique_par_mois_formation)
        {
            $month = substr($statistique_par_mois_formation['month'], 5, 6);
            if ($month == 1)
                $data_formation['janvier'] = $statistique_par_mois_formation['visites'];
            if ($month == 2)
                $data_formation['fevrier'] = $statistique_par_mois_formation['visites'];
            if ($month == 3)
                $data_formation['mars'] = $statistique_par_mois_formation['visites'];
            if ($month == 4)
                $data_formation['avril'] = $statistique_par_mois_formation['visites'];
            if ($month == 5)
                $data_formation['mai'] = $statistique_par_mois_formation['visites'];
            if ($month == 6)
                $data_formation['juin'] = $statistique_par_mois_formation['visites'];
            if ($month == 7)
                $data_formation['juillet'] = $statistique_par_mois_formation['visites'];
            if ($month == 8)
                $data_formation['aout'] = $statistique_par_mois_formation['visites'];
            if ($month == 9)
                $data_formation['septembre'] = $statistique_par_mois_formation['visites'];
            if ($month == 10)
                $data_formation['octobre'] = $statistique_par_mois_formation['visites'];
            if ($month == 11)
                $data_formation['novembre'] = $statistique_par_mois_formation['visites'];
            if ($month == 12)
                $data_formation['decembre'] = $statistique_par_mois_formation['visites'];
        }

        $data_emploi = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_emploi as $statistique_par_mois_emploi)
        {
            $month = substr($statistique_par_mois_emploi['month'], 5, 6);
            if ($month == 1)
                $data_emploi['janvier'] = $statistique_par_mois_emploi['visites'];
            if ($month == 2)
                $data_emploi['fevrier'] = $statistique_par_mois_emploi['visites'];
            if ($month == 3)
                $data_emploi['mars'] = $statistique_par_mois_emploi['visites'];
            if ($month == 4)
                $data_emploi['avril'] = $statistique_par_mois_emploi['visites'];
            if ($month == 5)
                $data_emploi['mai'] = $statistique_par_mois_emploi['visites'];
            if ($month == 6)
                $data_emploi['juin'] = $statistique_par_mois_emploi['visites'];
            if ($month == 7)
                $data_emploi['juillet'] = $statistique_par_mois_emploi['visites'];
            if ($month == 8)
                $data_emploi['aout'] = $statistique_par_mois_emploi['visites'];
            if ($month == 9)
                $data_emploi['septembre'] = $statistique_par_mois_emploi['visites'];
            if ($month == 10)
                $data_emploi['octobre'] = $statistique_par_mois_emploi['visites'];
            if ($month == 11)
                $data_emploi['novembre'] = $statistique_par_mois_emploi['visites'];
            if ($month == 12)
                $data_emploi['decembre'] = $statistique_par_mois_emploi['visites'];
        }

        $data_annuaire = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_annuaire as $statistique_par_mois_annuaire)
        {
            $month = substr($statistique_par_mois_annuaire['month'], 5, 6);
            if ($month == 1)
                $data_annuaire['janvier'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 2)
                $data_annuaire['fevrier'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 3)
                $data_annuaire['mars'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 4)
                $data_annuaire['avril'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 5)
                $data_annuaire['mai'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 6)
                $data_annuaire['juin'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 7)
                $data_annuaire['juillet'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 8)
                $data_annuaire['aout'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 9)
                $data_annuaire['septembre'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 10)
                $data_annuaire['octobre'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 11)
                $data_annuaire['novembre'] = $statistique_par_mois_annuaire['visites'];
            if ($month == 12)
                $data_annuaire['decembre'] = $statistique_par_mois_annuaire['visites'];
        }

        $data_dialogue = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_dialogue as $statistique_par_mois_dialogue)
        {
            $month = substr($statistique_par_mois_dialogue['month'], 5, 6);
            if ($month == 1)
                $data_dialogue['janvier'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 2)
                $data_dialogue['fevrier'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 3)
                $data_dialogue['mars'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 4)
                $data_dialogue['avril'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 5)
                $data_dialogue['mai'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 6)
                $data_dialogue['juin'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 7)
                $data_dialogue['juillet'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 8)
                $data_dialogue['aout'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 9)
                $data_dialogue['septembre'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 10)
                $data_dialogue['octobre'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 11)
                $data_dialogue['novembre'] = $statistique_par_mois_dialogue['visites'];
            if ($month == 12)
                $data_dialogue['decembre'] = $statistique_par_mois_dialogue['visites'];
        }

        $data_agenda = array(
            'janvier' => 0,
            'fevrier' => 0,
            'mars' => 0,
            'avril' => 0,
            'mai' => 0,
            'juin' => 0,
            'juillet' => 0,
            'aout' => 0,
            'septembre' => 0,
            'octobre' => 0,
            'novembre' => 0,
            'decembre' => 0
        );
        foreach ($statistiques_par_mois_agenda as $statistique_par_mois_agenda)
        {
            $month = substr($statistique_par_mois_agenda['month'], 5, 6);
            if ($month == 1)
                $data_agenda['janvier'] = $statistique_par_mois_agenda['visites'];
            if ($month == 2)
                $data_agenda['fevrier'] = $statistique_par_mois_agenda['visites'];
            if ($month == 3)
                $data_agenda['mars'] = $statistique_par_mois_agenda['visites'];
            if ($month == 4)
                $data_agenda['avril'] = $statistique_par_mois_agenda['visites'];
            if ($month == 5)
                $data_agenda['mai'] = $statistique_par_mois_agenda['visites'];
            if ($month == 6)
                $data_agenda['juin'] = $statistique_par_mois_agenda['visites'];
            if ($month == 7)
                $data_agenda['juillet'] = $statistique_par_mois_agenda['visites'];
            if ($month == 8)
                $data_agenda['aout'] = $statistique_par_mois_agenda['visites'];
            if ($month == 9)
                $data_agenda['septembre'] = $statistique_par_mois_agenda['visites'];
            if ($month == 10)
                $data_agenda['octobre'] = $statistique_par_mois_agenda['visites'];
            if ($month == 11)
                $data_agenda['novembre'] = $statistique_par_mois_agenda['visites'];
            if ($month == 12)
                $data_agenda['decembre'] = $statistique_par_mois_agenda['visites'];
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