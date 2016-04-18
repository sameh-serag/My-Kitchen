<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\Plate", mappedBy="category")
     */
    private $plates;

    public function __toString() {
        return (string) $this->name;
    }
    
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
     * @return Category
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
     * Constructor
     */
    public function __construct()
    {
        $this->plates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add plate
     *
     * @param \KitchenBundle\Entity\Plate $plate
     * @return Category
     */
    public function addPlate( $plate)
    {
        $this->plates[] = $plate;

        return $this;
    }

    /**
     * Remove plate
     *
     * @param \KitchenBundle\Entity\Plate $plate
     */
    public function removePlate($plate)
    {
        $this->plates->removeElement($plate);
    }

    /**
     * Get plates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlates()
    {
        return $this->plates;
    }
}
