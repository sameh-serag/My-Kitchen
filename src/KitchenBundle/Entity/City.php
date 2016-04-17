<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\CityRepository")
 */
class City
{
    /**
     * @var integer
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
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\Country", inversedBy="cities")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\User", mappedBy="city")
     */
    private $chefs;

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
     * Set name
     *
     * @param string $name
     * @return City
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
     * Set Country
     *
     * @param \KitchenBundle\Entity\Country $country
     * @return City
     */
    public function setState($country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get Country
     *
     * @return \KitchenBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chefs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add chef
     *
     * @param \KitchenBundle\Entity\User $chef
     * @return City
     */
    public function addChef( $chef)
    {
        $this->chefs[] = $chef;

        return $this;
    }

    /**
     * Remove chef
     *
     * @param \KitchenBundle\Entity\User $chef
     */
    public function removeChef($chef)
    {
        $this->chefs->removeElement($chef);
    }

    /**
     * Get chefs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChefs()
    {
        return $this->chefs;
    }

}
