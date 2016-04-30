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
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 * @ORM\HasLifecycleCallbacks
 */
class User {

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
     * @var string
     *
     * @ORM\Column(name="tokenValidTo", type="integer", nullable=true)
     */
    private $tokenValidTo;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=555, nullable=true)
     */
    private $image;

    /**
     * a temp variable for storing the old image name to delete the old image after the update
     * @var string $temp
     */
    private $temp;

    /**
     * @Assert\Image
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\City", inversedBy="chefs")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\Country", inversedBy="chefs")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $userPassword
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="rate", type="string", length=255,nullable=true)
     */
    private $rate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="in_holiday", type="boolean")
     */
    private $inHoliday = false;

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
     * @ORM\Column(name="type", type="smallint", options={"comment":"0 = chef, 1 = user"})
     */
    private $type;

    /**
     * @var integer
     * 0 = pendding, 1 = approved, 2 = rejected
     * @ORM\Column(name="status", type="smallint", options={"comment":"0 = pendding, 1 = approved, 2 = rejected"})
     */
    private $status = 0;

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
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\Request", mappedBy="chef")
     */
    private $requests;

    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\Request", mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\Rating", mappedBy="chef")
     */
    private $ratings;

    /**
     * Set userPassword
     *
     * @param string $userPassword
     * @return User
     */
    public function setUserPassword($userPassword) {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword() {
        return $this->userPassword;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return User
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set file
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return User
     */
    public function setFile($file) {
        $this->file = $file;
        //check if we have an old image
        if ($this->image) {
            //store the old name to delete on the update
            $this->temp = $this->image;
            $this->image = NULL;
        } else {
            $this->image = 'initial';
        }
        return $this;
    }

    /**
     * Get file
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * this function is used to delete the current image
     * the deleting of the current object will also delete the image and you do not need to call this function
     * if you call this function before you remove the object the image will not be removed
     */
    public function removeImage() {
        //check if we have an old image
        if ($this->image) {
            //store the old name to delete on the update
            $this->temp = $this->image;
            //delete the current image
            $this->image = NULL;
        }
    }

    /**
     * create the the directory if not found
     * @param string $directoryPath
     * @throws \Exception if the directory can not be created
     */
    private function createDirectory($directoryPath) {
        if (!@is_dir($directoryPath)) {
            $oldumask = umask(0);
            $success = @mkdir($directoryPath, 0755, TRUE);
            umask($oldumask);
            if (!$success) {
                throw new \Exception("Can not create the directory $directoryPath");
            }
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if ($this->getUserPassword()) {
            //hash the password
            $this->setPassword(md5($this->getUserPassword()));
        }

        if (NULL !== $this->file && (NULL === $this->image || 'initial' === $this->image)) {
            //get the image extension
            $extension = $this->file->guessExtension();
            //generate a random image name
            $img = uniqid();
            //get the image upload directory
            $uploadDir = $this->getUploadRootDir();
            $this->createDirectory($uploadDir);
            //check that the file name does not exist
            while (@file_exists("$uploadDir/$img.$extension")) {
                //try to find a new unique name
                $img = uniqid();
            }
            //set the image new name
            $this->image = "$img.$extension";
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (NULL !== $this->file) {
            // you must throw an exception here if the file cannot be moved
            // so that the entity is not persisted to the database
            // which the UploadedFile move() method does
            $this->file->move($this->getUploadRootDir(), $this->image);
            //remove the file as you do not need it any more
            $this->file = NULL;
        }
        //check if we have an old image
        if ($this->temp) {
            //try to delete the old image
            @unlink($this->getUploadRootDir() . '/' . $this->temp);
            //clear the temp image
            $this->temp = NULL;
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove() {
        //check if we have an image
        if ($this->image) {
            //try to delete the image
            @unlink($this->getAbsolutePath());
        }
    }

    /**
     * @return string the path of image starting of root
     */
    public function getAbsolutePath() {
        return $this->getUploadRootDir() . '/' . $this->image;
    }

    /**
     * @return string the relative path of image starting from web directory
     */
    public function getWebPath() {
        return NULL === $this->image ? NULL : $this->getUploadDir() . '/' . $this->image;
    }

    /**
     * @return string the path of upload directory starting of root
     */
    public function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    /**
     * @param $width the desired image width
     * @param $height the desired image height
     * @return string the htaccess file url pattern which map to timthumb url
     */
    public function getSmallImageUrl($width = 50, $height = 50) {
        return NULL === $this->image ? null : "user-image/$width/$height/$this->image";
    }

    /**
     * @return string the document upload directory path starting from web folder
     */
    private function getUploadDir() {
        return 'uploads/user-images';
    }

    /**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getTokenValidTo() {
        return $this->tokenValidTo;
    }

    /**
     * @param string $tokenValidTo
     */
    public function setTokenValidTo($tokenValidTo) {
        $this->tokenValidTo = $tokenValidTo;
    }

    /**
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getRate() {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate($rate) {
        $this->rate = $rate;
    }

    /**
     * @return boolean
     */
    public function isInHoliday() {
        return $this->inHoliday;
    }

    /**
     * @param boolean $inHoliday
     */
    public function setInHoliday($inHoliday) {
        $this->inHoliday = $inHoliday;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    public function __toString() {
        if ($this->name)
            return (string) $this->name;
        else
            return (string) $this->username;
    }

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->plates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->requests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return User
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return User
     */
    public function setLat($lat) {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     * @return User
     */
    public function setLng($lng) {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng() {
        return $this->lng;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return User
     */
    public function setNotes($notes) {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Set deliveryNotes
     *
     * @param string $deliveryNotes
     * @return User
     */
    public function setDeliveryNotes($deliveryNotes) {
        $this->deliveryNotes = $deliveryNotes;

        return $this;
    }

    /**
     * Get deliveryNotes
     *
     * @return string 
     */
    public function getDeliveryNotes() {
        return $this->deliveryNotes;
    }

    /**
     * Set city
     *
     * @param \KitchenBundle\Entity\City $city
     * @return User
     */
    public function setCity($city = null) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City
     *
     * @return \KitchenBundle\Entity\City
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Add plate
     *
     * @param \KitchenBundle\Entity\Plate $plate
     * @return User
     */
    public function addPlate($plate) {
        $this->plates[] = $plate;

        return $this;
    }

    /**
     * Remove plate
     *
     * @param \KitchenBundle\Entity\Plate $plate
     */
    public function removePlate($plate) {
        $this->plates->removeElement($plate);
    }

    /**
     * Get plates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlates() {
        return $this->plates;
    }

    /**
     * Add Order
     *
     * @param \KitchenBundle\Entity\Request $orders
     * @return User
     */
    public function addOrder($orders) {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove Order
     *
     * @param \KitchenBundle\Entity\Request $order
     */
    public function removeOrder($order) {
        $this->orders->removeElement($order);
    }

    /**
     * Get Orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders() {
        return $this->orders;
    }

    /**
     * Add Request
     *
     * @param \KitchenBundle\Entity\Request $request
     * @return User
     */
    public function addRequest($request) {
        $this->requests[] = $request;

        return $this;
    }

    /**
     * Remove Request
     *
     * @param \KitchenBundle\Entity\Plate $request
     */
    public function removeRequest($request) {
        $this->requests->removeElement($request);
    }

    /**
     * Get Requests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequests() {
        return $this->requests;
    }

    /**
     * Add Rating
     *
     * @param \KitchenBundle\Entity\Rating $rating
     * @return User
     */
    public function addRating($rating) {
        $this->rating[] = $rating;

        return $this;
    }

    /**
     * Remove Rating
     *
     * @param \KitchenBundle\Entity\Rating $rating
     */
    public function removeRating($rating) {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get Ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings() {
        return $this->ratings;
    }

    /**
     * Get inHoliday
     *
     * @return boolean 
     */
    public function getInHoliday() {
        return $this->inHoliday;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return User
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }


    /**
     * Set country
     *
     * @param \KitchenBundle\Entity\Country $country
     * @return User
     */
    public function setCountry(\KitchenBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \KitchenBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
