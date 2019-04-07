<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Traits\CreatedAtFieldTrait;

/**
 * Action
 *
 * @ORM\Table(name="action")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Action
{

    use CreatedAtFieldTrait;

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
     * @ORM\Column(name="name", type="string", nullable=false, length=100)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SpecialPrice", mappedBy="action")
     */
    private $specialPrices;

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
     * @return Action
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

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->specialPrices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add specialPrice
     *
     * @param \AppBundle\Entity\SpecialPrice $specialPrice
     *
     * @return Action
     */
    public function addSpecialPrice(\AppBundle\Entity\SpecialPrice $specialPrice)
    {
        $this->specialPrices[] = $specialPrice;

        return $this;
    }

    /**
     * Remove specialPrice
     *
     * @param \AppBundle\Entity\SpecialPrice $specialPrice
     */
    public function removeSpecialPrice(\AppBundle\Entity\SpecialPrice $specialPrice)
    {
        $this->specialPrices->removeElement($specialPrice);
    }

    /**
     * Get specialPrices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpecialPrices()
    {
        return $this->specialPrices;
    }
}
