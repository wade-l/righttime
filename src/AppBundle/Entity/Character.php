<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Character
 *
 * @ORM\Table(name="character")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CharacterRepository")
 */
class Character
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="characters")
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="characters")
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity="Turn", mappedBy="character")
     */
    private $turns;

    public function __construct()
    {
        $this->turns = new ArrayCollection();
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
     * @return Character
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
     * Get the value of player
     */ 
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set the value of player
     *
     * @return  self
     */ 
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get the value of game
     */ 
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set the value of game
     *
     * @return  self
     */ 
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get the value of turns
     */ 
    public function getTurns()
    {
        return $this->turns;
    }

    /**
     * Set the value of turns
     *
     * @return  self
     */ 
    public function setTurns($turns)
    {
        $this->turns = $turns;

        return $this;
    }

}

