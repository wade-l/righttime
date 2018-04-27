<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Game
 * 
 * An on-going chronicle or campaign, which might consist of many sessions and downtimes.
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="instructions", type="text", nullable=true)
     */
    private $instructions;

    /**
     * @var string
     *
     * @ORM\Column(name="system", type="string", length=255, nullable=true)
     */
    private $system;

    /**
     * @ORM\OneToMany(targetEntity="Member", mappedBy="game")
     */
    private $members;
    
    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="game")
     */
    private $characters;

    /**
     * @ORM\OneToMany(targetEntity="DowntimePeriod", mappedBy="game")
     */
    private $downtimePeriods;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->downtimePeriods = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Game
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
     * Set system
     *
     * @param string $system
     *
     * @return Game
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * Get system
     *
     * @return string
     */
    public function getSystem()
    {
        return $this->system;
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
     * String representation of a game
     */
    public function __toString()
    {
        return $this->getName();
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

    /**
     * Get the value of downtimePeriods
     */ 
    public function getDowntimePeriods()
    {
        return $this->downtimePeriods;
    }

    /**
     * Set the value of downtimePeriods
     *
     * @return  self
     */ 
    public function setDowntimePeriods($downtimePeriods)
    {
        $this->downtimePeriods = $downtimePeriods;

        return $this;
    }

    /**
     * Get the value of instructions
     *
     * @return  string
     */ 
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set the value of instructions
     *
     * @param  string  $instructions
     *
     * @return  self
     */ 
    public function setInstructions(string $instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }
}

