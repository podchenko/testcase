<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @var float
     *
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="base_prices",
     *      joinColumns={@ORM\JoinColumn(name="action_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $basePrices;


    public function __construct() {
        $this->basePrices = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add basePrice
     *
     * @param \AppBundle\Entity\Product $basePrice
     *
     * @return Action
     */
    public function addBasePrice(\AppBundle\Entity\Product $basePrice)
    {
        $this->basePrices[] = $basePrice;

        return $this;
    }

    /**
     * Remove basePrice
     *
     * @param \AppBundle\Entity\Product $basePrice
     */
    public function removeBasePrice(\AppBundle\Entity\Product $basePrice)
    {
        $this->basePrices->removeElement($basePrice);
    }

    /**
     * Get basePrices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBasePrices()
    {
        return $this->basePrices;
    }
}
