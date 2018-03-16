<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DowntimePeriod
 *
 * @ORM\Table(name="downtime_period")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DowntimePeriodRepository")
 */
class DowntimePeriod
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
     * @ORM\Column(name="Description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Open", type="date", nullable=true)
     */
    private $open;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Close", type="date", nullable=true)
     */
    private $close;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="downtimePeriods")
     */
    private $game;


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
     * @return DowntimePeriod
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
     * @return DowntimePeriod
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
     * Set open
     *
     * @param \DateTime $open
     *
     * @return DowntimePeriod
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return \DateTime
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set close
     *
     * @param \DateTime $close
     *
     * @return DowntimePeriod
     */
    public function setClose($close)
    {
        $this->close = $close;

        return $this;
    }

    /**
     * Get close
     *
     * @return \DateTime
     */
    public function getClose()
    {
        return $this->close;
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
}

