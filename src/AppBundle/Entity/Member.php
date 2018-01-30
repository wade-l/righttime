<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Joining assoication between Games and Users - a User might have membership
 * in many games, and a game ideally has many users as members.
 * 
 * @ORM\Entity
 * @ORM\Table(name="member")
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="member")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="member")
     */
    private $game;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    public function __construct()
    {
        // your own logic
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

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
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of position
     *
     * @return  string
     */ 
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the value of position
     *
     * @param  string  $position
     *
     * @return  self
     */ 
    public function setPosition(string $position)
    {
        $this->position = $position;

        return $this;
    }
}