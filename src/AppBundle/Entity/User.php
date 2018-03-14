<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Member", mappedBy="user")
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="player")
     */
    private $characters;

    public function __construct()
    {
        parent::__construct();
        $this->members = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    /**
     * Get the id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of members
     */ 
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set the value of members
     *
     * @return  self
     */ 
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Get the value of characters
     */ 
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Set the value of characters
     *
     * @return  self
     */ 
    public function setCharacters($characters)
    {
        $this->characters = $characters;

        return $this;
    }
}