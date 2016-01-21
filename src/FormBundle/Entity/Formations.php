<?php

namespace FormBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * Formations
 */
class Formations
{

    // UPLOAD
    /**
     * @var file
     */
    public $file;

    protected function getUploadDir()
    {
        return '/formations_documents';
    }

    public function getFixturesPath()
    {
        return $this->getAbsolutePath() . 'web/uploads/formations_documents/fixtures/';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../app/uploads'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->fichier ? null : $this->getUploadDir().'/'.$this->fichier;
    }

    public function getAbsolutePath()
    {
        return null === $this->fichier ? null : $this->getUploadRootDir().'/'.$this->fichier;
    }

    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->fichier_nom = $this->file->getClientOriginalName();
            $this->fichier = uniqid().'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->fichier);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    //

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
    private $organisme;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $fichier;

    /**
     * @var string
     */
    private $fichier_nom;

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
     * @var boolean
     */
    private $fil_actu;

    /**
     * @var \DateTime
     */
    private $dateAjout;

    /**
     * @var \AppBundle\Entity\Organisme
     */
    private $address;


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
     * Set fichier
     *
     * @param string $fichier
     *
     * @return Formations
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Set fichierNom
     *
     * @param string $fichierNom
     *
     * @return Formations
     */
    public function setFichierNom($fichierNom)
    {
        $this->fichier_nom = $fichierNom;

        return $this;
    }

    /**
     * Get fichierNom
     *
     * @return string
     */
    public function getFichierNom()
    {
        return $this->fichier_nom;
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
}
