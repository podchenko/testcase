<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Traits\CreatedAtFieldTrait;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="base_price", type="string", nullable=false)
     */
    private $basePrice;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SpecialPrice", mappedBy="product", cascade={"persist"})
     */
    private $specialPrices;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->specialPrices = new ArrayCollection();
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
     * @return Product
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
     * Set basePrice
     *
     * @param string $basePrice
     *
     * @return Product
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = floatval(str_replace(' ', '', $basePrice));

        return $this;
    }

    /**
     * Get basePrice
     *
     * @return string
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * Add specialPrice
     *
     * @param \AppBundle\Entity\SpecialPrice $specialPrice
     *
     * @return Product
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
