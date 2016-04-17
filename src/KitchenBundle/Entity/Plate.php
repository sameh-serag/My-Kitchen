<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\PlateRepository")
 */
class Plate
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
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_hot", type="boolean")
     */
    private $isHot;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\User", inversedBy="plates")
     * @ORM\JoinColumn(name="chef_id", referencedColumnName="id", nullable=true)
     */
    private $chef;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\Category", inversedBy="plates")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

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
     * @return Plate
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
     * Set price
     *
     * @param string $price
     * @return Plate
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isHot
     *
     * @param boolean $isHot
     * @return Plate
     */
    public function setIsHot($isHot)
    {
        $this->isHot = $isHot;

        return $this;
    }

    /**
     * Get isHot
     *
     * @return boolean 
     */
    public function getIsHot()
    {
        return $this->isHot;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Plate
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Plate
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
     * @return \KitchenBundle\Entity\User
     */
    public function getChef()
    {
        return $this->chef;
    }

    /**
     * @param \KitchenBundle\Entity\User $chef
     * @return Plate
     */
    public function setChef($chef)
    {
        $this->chef = $chef;
    }

    /**
     * @return \KitchenBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \KitchenBundle\Entity\Category $category
     * @return Plate
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
