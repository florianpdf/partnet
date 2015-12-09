<?php

namespace GedBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * Documents
 *
 */
class Documents
{
    protected function getUploadDir()
    {
        return 'uploads/documents';
    }

    public function getFixturesPath()
    {
        return $this->getAbsolutePath() . 'app/uploads/documents/fixtures/';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../app/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->document ? null : $this->getUploadDir().'/'.$this->document;
    }

    public function getAbsolutePath()
    {
        return null === $this->document ? null : $this->getUploadRootDir().'/'.$this->document;
    }

    // used in fixtures
    public function createFile($ext)
    {
        $token = uniqid().".".$ext;
        $this->setDocument($token);
        fopen("app/uploads/documents/" . $token, "w");
        $this->setExtension($ext);
    }

    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->file_name = $this->file->getClientOriginalName();
            $this->document = uniqid().'.'.$this->file->guessExtension();
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
        $this->file->move($this->getUploadRootDir(), $this->document);

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

    //Generated Code

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
    private $document;

    /**
     * @var string
     */
    private $file_name;

    /**
     * @var file
     */
    public $file;

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
     * Set document
     *
     * @param string $document
     *
     * @return Documents
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Documents
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
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

    /**
     * @var integer
     */
    private $nbdocument;


    /**
     * Set nbdocument
     *
     * @param integer $nbdocument
     *
     * @return Documents
     */
    public function setNbdocument($nbdocument)
    {
        $this->nbdocument = $nbdocument;

        return $this;
    }

    /**
     * Get nbdocument
     *
     * @return integer
     */
    public function getNbdocument()
    {
        return $this->nbdocument;
    }
}
