<?php

namespace GedBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Documents
 */
class Documents
{



    // GENERATED CODE


    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max = 50)
     * @Assert\Type(type="alnum")
     */
    private $titre;

    /**
     * @var string
     * @Assert\Type(type="alnum")
     */
    private $resume;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     * @Assert\Length(max = 50)
     * @Assert\Type(type="string")
     */
    private $auteur;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max = 50)
     * @Assert\File(maxSize = "10M")
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
     * @var \DateTime
     * @Assert\Date()
     */
    private $finDeVie;

    /**
     * @var \UserBundle\Entity\User
     */
    private $user;


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
     * Set finDeVie
     *
     * @param \DateTime $finDeVie
     *
     * @return Documents
     */
    public function setFinDeVie($finDeVie)
    {
        $this->finDeVie = $finDeVie;

        return $this;
    }

    /**
     * Get finDeVie
     *
     * @return \DateTime
     */
    public function getFinDeVie()
    {
        return $this->finDeVie;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Documents
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
