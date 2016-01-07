<?php
namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var file
     */
    public $file;

    protected function getUploadDir()
    {
        return '/profile_pictures';
    }

    public function getFixturesPath()
    {
        return $this->getAbsolutePath() . 'web/uploads/profile_pictures/fixtures/';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../app/uploads'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir().'/'.$this->picture;
    }

    public function getAbsolutePath()
    {
        return null === $this->picture ? null : $this->getUploadRootDir().'/'.$this->picture;
    }

    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->picture_name = $this->file->getClientOriginalName();
            $this->picture = $this->username.'.'.$this->file->guessExtension();
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
        $this->file->move($this->getUploadRootDir(), $this->picture);

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

    /* Override original functions */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->username = $email;
        return $this;
    }
    public function setEmailCanonical($emailCanonical)
    {
        parent::setEmailCanonical($emailCanonical);
        $this->usernameCanonical = $emailCanonical;
        return $this;
    }

    public function setPlainPassword($password)
    {
        parent::setPlainPassword($password);
        $this->password = $password;
        return $this;
    }


    //Generated Code

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $organisme;

    /**
     * @var string
     */
    private $poste;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var integer
     */
    private $nbUploads;

    /**
     * @var \DateTime
     */
    private $creationCompte;


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set organisme
     *
     * @param string $organisme
     *
     * @return User
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
     * Set poste
     *
     * @param string $poste
     *
     * @return User
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return chunk_split($this->telephone, 2, " ");
    }

    /**
     * Set nbUploads
     *
     * @param integer $nbUploads
     *
     * @return User
     */
    public function setNbUploads($nbUploads)
    {
        $this->nbUploads = $nbUploads;

        return $this;
    }

    /**
     * Get nbUploads
     *
     * @return integer
     */
    public function getNbUploads()
    {
        return $this->nbUploads;
    }

    /**
     * Set creationCompte
     *
     * @param \DateTime $creationCompte
     *
     * @return User
     */
    public function setCreationCompte($creationCompte)
    {
        $this->creationCompte = $creationCompte;

        return $this;
    }

    /**
     * Get creationCompte
     *
     * @return \DateTime
     */
    public function getCreationCompte()
    {
        return $this->creationCompte;
    }

    /**
     * @var string
     */
    private $picture_name;

    /**
     * @var string
     */
    private $picture;


    /**
     * Set pictureName
     *
     * @param string $pictureName
     *
     * @return User
     */
    public function setPictureName($pictureName)
    {
        $this->picture_name = $pictureName;

        return $this;
    }

    /**
     * Get pictureName
     *
     * @return string
     */
    public function getPictureName()
    {
        return $this->picture_name;
    }


    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }


}
