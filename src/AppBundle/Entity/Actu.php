<?php

namespace AppBundle\Entity;

/**
 * Actu
 */
class Actu
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var \DateTime
     */
    private $dateAjout;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Actu
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Actu
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Actu
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add event
     *
     * @param \AgendaBundle\Entity\Events $event
     *
     * @return Actu
     */
    public function addEvent(\AgendaBundle\Entity\Events $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AgendaBundle\Entity\Events $event
     */
    public function removeEvent(\AgendaBundle\Entity\Events $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
    /**
     * @var \AgendaBundle\Entity\Events
     */
    private $idEvents;


    /**
     * Set idEvents
     *
     * @param \AgendaBundle\Entity\Events $idEvents
     *
     * @return Actu
     */
    public function setIdEvents(\AgendaBundle\Entity\Events $idEvents = null)
    {
        $this->idEvents = $idEvents;

        return $this;
    }

    /**
     * Get idEvents
     *
     * @return \AgendaBundle\Entity\Events
     */
    public function getIdEvents()
    {
        return $this->idEvents;
    }
    /**
     * @var \GedBundle\Entity\Documents
     */
    private $idDocuments;


    /**
     * Set idDocuments
     *
     * @param \GedBundle\Entity\Documents $idDocuments
     *
     * @return Actu
     */
    public function setIdDocuments(\GedBundle\Entity\Documents $idDocuments = null)
    {
        $this->idDocuments = $idDocuments;

        return $this;
    }

    /**
     * Get idDocuments
     *
     * @return \GedBundle\Entity\Documents
     */
    public function getIdDocuments()
    {
        return $this->idDocuments;
    }
}
