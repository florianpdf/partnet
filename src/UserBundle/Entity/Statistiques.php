<?php

namespace UserBundle\Entity;

/**
 * Statistiques
 */
class Statistiques
{

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $nbVisitesAccueil;

    /**
     * @var integer
     */
    private $nbVisitesGed;

    /**
     * @var integer
     */
    private $nbVisitesAgenda;

    /**
     * @var integer
     */
    private $nbVisitesAnnuaire;

    /**
     * @var integer
     */
    private $nbVisitesFormation;

    /**
     * @var integer
     */
    private $nbVisitesEmploi;

    /**
     * @var integer
     */
    private $nbVisitesDialogue;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \UserBundle\Entity\User
     */
    private $user;


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Statistiques
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nbVisitesAccueil
     *
     * @param integer $nbVisitesAccueil
     *
     * @return Statistiques
     */
    public function setNbVisitesAccueil($nbVisitesAccueil)
    {
        $this->nbVisitesAccueil = $nbVisitesAccueil;

        return $this;
    }

    /**
     * Get nbVisitesAccueil
     *
     * @return integer
     */
    public function getNbVisitesAccueil()
    {
        return $this->nbVisitesAccueil;
    }

    /**
     * Set nbVisitesGed
     *
     * @param integer $nbVisitesGed
     *
     * @return Statistiques
     */
    public function setNbVisitesGed($nbVisitesGed)
    {
        $this->nbVisitesGed = $nbVisitesGed;

        return $this;
    }

    /**
     * Get nbVisitesGed
     *
     * @return integer
     */
    public function getNbVisitesGed()
    {
        return $this->nbVisitesGed;
    }

    /**
     * Set nbVisitesAgenda
     *
     * @param integer $nbVisitesAgenda
     *
     * @return Statistiques
     */
    public function setNbVisitesAgenda($nbVisitesAgenda)
    {
        $this->nbVisitesAgenda = $nbVisitesAgenda;

        return $this;
    }

    /**
     * Get nbVisitesAgenda
     *
     * @return integer
     */
    public function getNbVisitesAgenda()
    {
        return $this->nbVisitesAgenda;
    }

    /**
     * Set nbVisitesAnnuaire
     *
     * @param integer $nbVisitesAnnuaire
     *
     * @return Statistiques
     */
    public function setNbVisitesAnnuaire($nbVisitesAnnuaire)
    {
        $this->nbVisitesAnnuaire = $nbVisitesAnnuaire;

        return $this;
    }

    /**
     * Get nbVisitesAnnuaire
     *
     * @return integer
     */
    public function getNbVisitesAnnuaire()
    {
        return $this->nbVisitesAnnuaire;
    }

    /**
     * Set nbVisitesFormation
     *
     * @param integer $nbVisitesFormation
     *
     * @return Statistiques
     */
    public function setNbVisitesFormation($nbVisitesFormation)
    {
        $this->nbVisitesFormation = $nbVisitesFormation;

        return $this;
    }

    /**
     * Get nbVisitesFormation
     *
     * @return integer
     */
    public function getNbVisitesFormation()
    {
        return $this->nbVisitesFormation;
    }

    /**
     * Set nbVisitesEmploi
     *
     * @param integer $nbVisitesEmploi
     *
     * @return Statistiques
     */
    public function setNbVisitesEmploi($nbVisitesEmploi)
    {
        $this->nbVisitesEmploi = $nbVisitesEmploi;

        return $this;
    }

    /**
     * Get nbVisitesEmploi
     *
     * @return integer
     */
    public function getNbVisitesEmploi()
    {
        return $this->nbVisitesEmploi;
    }

    /**
     * Set nbVisitesDialogue
     *
     * @param integer $nbVisitesDialogue
     *
     * @return Statistiques
     */
    public function setNbVisitesDialogue($nbVisitesDialogue)
    {
        $this->nbVisitesDialogue = $nbVisitesDialogue;

        return $this;
    }

    /**
     * Get nbVisitesDialogue
     *
     * @return integer
     */
    public function getNbVisitesDialogue()
    {
        return $this->nbVisitesDialogue;
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Statistiques
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
