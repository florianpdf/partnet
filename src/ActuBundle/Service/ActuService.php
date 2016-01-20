<?php

// src/ActuBundle/Service/ActuService.php

namespace ActuBundle\Service;

use Doctrine\ORM\EntityManager;

class ActuService
{
    private $em;

    private $actualites;

    public function getActualites()
    {
        return $this->actualites;
    }

    public function getActualitesById($id)
    {
        $document = $this->em->getRepository('GedBundle:Documents')->find($id);
        $event = $this->em->getRepository('AgendaBundle:Events')->find($id);
        $formation = $this->em->getRepository('FormBundle:Formations')->find($id);
        $actualite = $this->em->getRepository('ActuBundle:Actu')->find($id);

        $actus = [$document, $event, $formation, $actualite];

        return $actus;
    }

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;

        $documents = $this->em->getRepository('GedBundle:Documents')->findBy(array('fil_actu' => 1));
        $events = $this->em->getRepository('AgendaBundle:Events')->findBy(array('fil_actu' => 1));
        $formations = $this->em->getRepository('FormBundle:Formations')->findBy(array('fil_actu' => 1));
        $actu = $this->em->getRepository('ActuBundle:Actu')->findAll();

        $actus = array_merge($documents, $events, $formations, $actu);

        usort($actus, $this->getSort());

        $this->actualites = array_slice($actus, 0, 10);
    }

    public function getSort()
    {
        return function ($a, $b) {
            if ($a->getDateAjout() < $b->getDateAjout())
                return 1;
            if ($a->getDateAjout() > $b->getDateAjout())
                return -1;
            return 0;
        };
    }

}