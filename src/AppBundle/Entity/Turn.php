<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Turn
 *
 * @ORM\Table(name="turn")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TurnRepository")
 */
class Turn
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
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="turns")
     */

    private $character;

    /**
     * @ORM\ManyToOne(targetEntity="DowntimePeriod", inversedBy="turns")
     */
    private $downtimePeriod;

    /**
     * @var bool
     *
     * @ORM\Column(name="finalized", type="boolean", nullable=true)
     */
    private $finalized;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Act", mappedBy="turn", cascade={"persist"})
     */
    private $acts;

    public function __construct()
    {
        $this->acts = new ArrayCollection();
        $finalized = false;
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
     * Set character
     *
     * @param string $character
     *
     * @return Turn
     */
    public function setCharacter($character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return string
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set downtimeperiod
     *
     * @param string $downtimeperiod
     *
     * @return Turn
     */
    public function setDowntimePeriod($downtimeperiod)
    {
        $this->downtimePeriod = $downtimeperiod;

        return $this;
    }

    /**
     * Get downtimeperiod
     *
     * @return string
     */
    public function getDowntimePeriod()
    {
        return $this->downtimePeriod;
    }

    /**
     * Set finalized
     *
     * @param boolean $finalized
     *
     * @return Turn
     */
    public function setFinalized($finalized)
    {
        $this->finalized = $finalized;

        return $this;
    }

    /**
     * Get finalized
     *
     * @return bool
     */
    public function getFinalized()
    {
        return $this->finalized;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Turn
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get the value of acts
     */ 
    public function getActs()
    {
        return $this->acts;
    }

    /**
     * Set the value of acts
     *
     * @return  self
     */ 
    public function setActs($acts)
    {
        $this->acts = $acts;

        return $this;
    }

    /**
     * Adder method to add in acts
     */
    public function addAct(Act $act)
    {
        $act->setTurn($this);
        $this->acts->add($act);
    }

    /**
     * Remover method to remove acts
     */
    public function removeAct(Act $act)
    {
        $this->acts->removeElement($act);
    }


    /**
     * String representation of a turn
     */
    public function __toString()
    {
        return $this->getCharacter()->getName() . 'for' . $this->getDowntimePeriod()->getName();
    }
}

