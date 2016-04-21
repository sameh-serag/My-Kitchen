<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\CountryRepository")
 */
class Country {

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
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\User", mappedBy="country")
     */
    private $chefs;
    
    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\City", mappedBy="country")
     */
    private $cities;

    public function __toString() {
        return (string) $this->name;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Country
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add city
     *
     * @param \KitchenBundle\Entity\City $city
     * @return Country
     */
    public function addCity($city) {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \KitchenBundle\Entity\City $city
     */
    public function removeCity($city) {
        $this->cities->removeElement($city);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities() {
        return $this->cities;
    }


    /**
     * Add chefs
     *
     * @param \KitchenBundle\Entity\User $chefs
     * @return Country
     */
    public function addChef(\KitchenBundle\Entity\User $chefs)
    {
        $this->chefs[] = $chefs;

        return $this;
    }

    /**
     * Remove chefs
     *
     * @param \KitchenBundle\Entity\User $chefs
     */
    public function removeChef(\KitchenBundle\Entity\User $chefs)
    {
        $this->chefs->removeElement($chefs);
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
