<?php

namespace FormBundle\Entity;

/**
 * Formations
 */
class Formations
{

    protected $type;

    public function getType(){
        return $this->type = 'formations';
    }

    // GENERATED CODE

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $photoOrganisme;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var integer
     */
    private $nbPlace;

    /**
     * @var string
     */
    private $lieu;

    /**
     * @var string
     */
    private $resume;


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
     * Set photoOrganisme
     *
     * @param string $photoOrganisme
     *
     * @return Formations
     */
    public function setPhotoOrganisme($photoOrganisme)
    {
        $this->photoOrganisme = $photoOrganisme;

        return $this;
    }

    /**
     * Get photoOrganisme
     *
     * @return string
     */
    public function getPhotoOrganisme()
    {
        return $this->photoOrganisme;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Formations
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
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return Formations
     */
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return integer
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Formations
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return Formations
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }
    /**
     * @var string
     */
    private $organisme;


    /**
     * Set organisme
     *
     * @param string $organisme
     *
     * @return Formations
     */
    public function setOrganisme($organisme)
    {
        $this->organisme = $organisme;

        return $this;
    }

    /**
     * Get organisme
     *
     * @return string
     */
    public function getOrganisme()
    {
        return $this->organisme;
    }
    /**
     * @var \AppBundle\Entity\Organisme
     */
    private $user;


    /**
     * Set user
     *
     * @param \AppBundle\Entity\Organisme $user
     *
     * @return Formations
     */
    public function setUser(\AppBundle\Entity\Organisme $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Organisme
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \AppBundle\Entity\Organisme
     */
    private $address;


    /**
     * Set address
     *
     * @param \AppBundle\Entity\Organisme $address
     *
     * @return Formations
     */
    public function setAddress(\AppBundle\Entity\Organisme $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Organisme
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * @var string
     */
    private $image;


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Formations
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * @var boolean
     */
    private $fil_actu;

    /**
     * @var \DateTime
     */
    private $dateAjout;


    /**
     * Set filActu
     *
     * @param boolean $filActu
     *
     * @return Formations
     */
    public function setFilActu($filActu)
    {
        $this->fil_actu = $filActu;

        return $this;
    }

    /**
     * Get filActu
     *
     * @return boolean
     */
    public function getFilActu()
    {
        return $this->fil_actu;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Formations
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
}
