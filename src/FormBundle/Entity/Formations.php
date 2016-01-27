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

    /**
     * @var file
     */
    public $file2;

    protected function getUploadDir()
    {
        return '/formations_documents';
    }

    public function getFixturesPath()
    {
        return $this->getAbsolutePath() . 'web/uploads/formations_documents/fixtures/';
    }


    /**
     * @ORM\PrePersist
     */
    public function preUploadFile1()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->fichier_nom = $this->file->getClientOriginalName();
            $this->fichier = uniqid() . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function preUploadFile2()
    {
        if (null !== $this->file2) {
            // do whatever you want to generate a unique name
            $this->second_fichier_nom = $this->file2->getClientOriginalName();
            $this->second_fichier = uniqid().'.'.$this->file2->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function uploadFile1()
    {
        if (null === $this->file) {
            return;
        } else {
            $this->file->move(__DIR__ . '/../../../app/uploads' . $this->getUploadDir(), $this->fichier);
            unset($this->file);
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function uploadFile2(){
        if (null === $this->file2) {
            return;
        } else {
            $this->file2->move(__DIR__.'/../../../app/uploads'.$this->getUploadDir(), $this->second_fichier);
            unset($this->file2);
        }
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUploadFile1()
    {
        $target = __DIR__ . '/../../../app/uploads' . $this->getUploadDir() . '/';

        if ($this->fichier) {

            unlink($target . $this->fichier);
        }
    }

    public function removeUploadFile2()
    {
        $target = __DIR__.'/../../../app/uploads'.$this->getUploadDir().'/';

        if($this->second_fichier) {

            unlink($target.$this->second_fichier);

        }
    }

    protected $type = 'Formations';


    public function getType(){
        return $this->type;
    }

    // GENERATED CODE

    /**
     * @var integer
     */
    private $id;

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
     * @var string
     */
    private $second_fichier;

    /**
     * @var string
     */
    private $second_fichier_nom;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Set secondFichier
     *
     * @param string $secondFichier
     *
     * @return Formations
     */
    public function setSecondFichier($secondFichier)
    {
        $this->second_fichier = $secondFichier;

        return $this;
    }

    /**
     * Get secondFichier
     *
     * @return string
     */
    public function getSecondFichier()
    {
        return $this->second_fichier;
    }

    /**
     * Set secondFichierNom
     *
     * @param string $secondFichierNom
     *
     * @return Formations
     */
    public function setSecondFichierNom($secondFichierNom)
    {
        $this->second_fichier_nom = $secondFichierNom;

        return $this;
    }

    /**
     * Get secondFichierNom
     *
     * @return string
     */
    public function getSecondFichierNom()
    {
        return $this->second_fichier_nom;
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
}
