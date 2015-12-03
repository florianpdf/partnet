<?php
namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
        return $this->telephone;
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
}
