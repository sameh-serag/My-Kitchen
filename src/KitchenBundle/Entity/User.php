<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\UserRepository")
 * @UniqueEntity(fields={"username", "email"})
 */
class User
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="tokenValidTo", type="integer", nullable=true)
     */
    private $tokenValidTo;

    /**
     * @return string
     */
    public function getTokenValidTo()
    {
        return $this->tokenValidTo;
    }

    /**
     * @param string $tokenValidTo
     */
    public function setTokenValidTo($tokenValidTo)
    {
        $this->tokenValidTo = $tokenValidTo;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=555, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\City", inversedBy="users")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
     */
    private $city;

     /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="rate", type="string", length=255)
     */
    private $rate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="in_holiday", type="boolean")
     */
    private $inHoliday;

    /**
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return boolean
     */
    public function isInHoliday()
    {
        return $this->inHoliday;
    }

    /**
     * @param boolean $inHoliday
     */
    public function setInHoliday($inHoliday)
    {
        $this->inHoliday = $inHoliday;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email is not valid"
     * )
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=255)
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_notes", type="text", nullable=true)
     */
    private $deliveryNotes;

    /**
     * @var integer
     * 0 = chef, 1 = user
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\Plate", mappedBy="chef")
     */
    private $plates;

    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\Rating", mappedBy="chef")
     */
    private $ratings;

    public function __toString() {
        return (string) $this->username;
    }

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->plates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @ORM\PreUpdate()
     */
    public function updateUpdatedAt() {
        $this->updatedAt = new \DateTime();
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
     * @return User
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
     * Set image
     *
     * @param string $image
     * @return User
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return User
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     * @return User
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return User
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set deliveryNotes
     *
     * @param string $deliveryNotes
     * @return User
     */
    public function setDeliveryNotes($deliveryNotes)
    {
        $this->deliveryNotes = $deliveryNotes;

        return $this;
    }

    /**
     * Get deliveryNotes
     *
     * @return string 
     */
    public function getDeliveryNotes()
    {
        return $this->deliveryNotes;
    }

    /**
     * Set city
     *
     * @param \KitchenBundle\Entity\City $city
     * @return User
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City
     *
     * @return \KitchenBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * Add plate
     *
     * @param \KitchenBundle\Entity\Plate $plate
     * @return User
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


    /**
     * Add Rating
     *
     * @param \KitchenBundle\Entity\Rating $rating
     * @return User
     */
    public function addRating( $rating)
    {
        $this->rating[] = $rating;

        return $this;
    }

    /**
     * Remove Rating
     *
     * @param \KitchenBundle\Entity\Rating $rating
     */
    public function removeRating($rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get Ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

}
