<?php

namespace AppBundle\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organisme
 */
class Organisme
{


    protected function getUploadDir()
    {
        return 'uploads/organismes_pictures/';
    }

    public function getFixturesPath()
    {
        return $this->getAbsolutePath() . 'app/Resources/images/';
    }
//    public function getFixturesPath()
//    {
//        return $this->getAbsolutePath() . 'app/uploads/documents/fixtures/';
//    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../app/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->photo ? null : $this->getUploadDir().'/'.$this->photo;
    }

    public function getAbsolutePath()
    {
        return null === $this->photo ? null : $this->getUploadRootDir().'/'.$this->photo;
    }



    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->photo = uniqid().'.'.$this->file->guessExtension();
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
        $this->file->move($this->getUploadRootDir(), $this->photo);

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


    /// GENERATED CODE
    /**
     * @var integer
     */
    private $id;

    /**
     * @var file
     */
    public $file;

    /**
     * @var integer
     */
    private $idUser;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $description;


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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Organisme
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

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Organisme
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Organisme
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Organisme
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var string
     */
    private $backgroundColor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fos_user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fos_user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set backgroundColor
     *
     * @param string $backgroundColor
     *
     * @return Organisme
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * Get backgroundColor
     *
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Add fosUser
     *
     * @param \UserBundle\Entity\User $fosUser
     *
     * @return Organisme
     */
    public function addFosUser(\UserBundle\Entity\User $fosUser)
    {
        $this->fos_user[] = $fosUser;

        return $this;
    }

    /**
     * Remove fosUser
     *
     * @param \UserBundle\Entity\User $fosUser
     */
    public function removeFosUser(\UserBundle\Entity\User $fosUser)
    {
        $this->fos_user->removeElement($fosUser);
    }

    /**
     * Get fosUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFosUser()
    {
        return $this->fos_user;
    }
}
