<?php

namespace GedBundle\Entity;

/**
 * Documents
 */
class Documents
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
     * @var string
     */
    private $resume;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $auteur;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \DateTime
     */
    private $dateUpload;

    /**
     * @var \DateTime
     */
    private $dateModif;

    /**
     * @var integer
     */
    private $dureeDeVie;

    /**
     * @var integer
     */
    private $idUser;


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
     * @return Documents
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
     * Set resume
     *
     * @param string $resume
     *
     * @return Documents
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
     * Set extension
     *
     * @param string $extension
     *
     * @return Documents
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Documents
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Documents
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dateUpload
     *
     * @param \DateTime $dateUpload
     *
     * @return Documents
     */
    public function setDateUpload($dateUpload)
    {
        $this->dateUpload = $dateUpload;

        return $this;
    }

    /**
     * Get dateUpload
     *
     * @return \DateTime
     */
    public function getDateUpload()
    {
        return $this->dateUpload;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return Documents
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set dureeDeVie
     *
     * @param integer $dureeDeVie
     *
     * @return Documents
     */
    public function setDureeDeVie($dureeDeVie)
    {
        $this->dureeDeVie = $dureeDeVie;

        return $this;
    }

    /**
     * Get dureeDeVie
     *
     * @return integer
     */
    public function getDureeDeVie()
    {
        return $this->dureeDeVie;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Documents
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}

