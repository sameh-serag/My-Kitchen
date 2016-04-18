<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Request
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\RequestRepository")
 */
class Request
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
     * @ORM\Column(name="status", type="string", length=255, options={"comment"="0:pendding | 1:approved | 2:rejected"})
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cancel_time", type="datetime")
     */
    private $cancelTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delivery_date", type="date")
     */
    private $deliveryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delivery_time", type="time")
     */
    private $deliveryTime;

    /**
     * @var string
     *
     * @ORM\Column(name="user_lat", type="string", length=255)
     */
    private $userLat;

    /**
     * @var string
     *
     * @ORM\Column(name="user_lng", type="string", length=255)
     */
    private $userLng;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal")
     */
    private $total_price;

    /**
     * @var string
     *
     * @ORM\Column(name="user_mobile", type="string", length=255)
     */
    private $userMobile;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text")
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="KitchenBundle\Entity\RequestDetails", mappedBy="request")
     */
    private $requestdetails;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->requestdetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Request
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cancelTime
     *
     * @param \DateTime $cancelTime
     * @return Request
     */
    public function setCancelTime($cancelTime)
    {
        $this->cancelTime = $cancelTime;

        return $this;
    }

    /**
     * Get cancelTime
     *
     * @return \DateTime 
     */
    public function getCancelTime()
    {
        return $this->cancelTime;
    }

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\User", inversedBy="requests")
     * @ORM\JoinColumn(name="chef_id", referencedColumnName="id")
     */
    private $chef;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Set deliveryDate
     *
     * @param \DateTime $deliveryDate
     * @return Request
     */
    public function setDeliveryDate($deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get deliveryDate
     *
     * @return \DateTime 
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * Set deliveryTime
     *
     * @param \DateTime $deliveryTime
     * @return Request
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    /**
     * Get deliveryTime
     *
     * @return \DateTime 
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * Set userLat
     *
     * @param string $userLat
     * @return Request
     */
    public function setUserLat($userLat)
    {
        $this->userLat = $userLat;

        return $this;
    }

    /**
     * Get userLat
     *
     * @return string 
     */
    public function getUserLat()
    {
        return $this->userLat;
    }

    /**
     * Set userLng
     *
     * @param string $userLng
     * @return Request
     */
    public function setUserLng($userLng)
    {
        $this->userLng = $userLng;

        return $this;
    }

    /**
     * Get userLng
     *
     * @return string 
     */
    public function getUserLng()
    {
        return $this->userLng;
    }

    /**
     * Set userMobile
     *
     * @param string $userMobile
     * @return Request
     */
    public function setUserMobile($userMobile)
    {
        $this->userMobile = $userMobile;

        return $this;
    }

    /**
     * Get userMobile
     *
     * @return string 
     */
    public function getUserMobile()
    {
        return $this->userMobile;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Request
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
     * @return \KitchenBundle\Entity\User
     */
    public function getChef()
    {
        return $this->chef;
    }

    /**
     * @param \KitchenBundle\Entity\User $chef
     * @return Request
     */
    public function setChef($chef)
    {
        $this->chef = $chef;
    }
    /**
     * @return \KitchenBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \KitchenBundle\Entity\User $user
     * @return Request
     */
    public function setUser($user)
    {
        $this->chef = $user;
    }

    /**
     * Add Request Detail
     *
     * @param \KitchenBundle\Entity\RequestDetails $requestDetails
     * @return Request
     */
    public function addRequestDetail( $requestDetails)
    {
        $this->requestdetails[] = $requestDetails;

        return $this;
    }

    /**
     * Remove Request Detail
     *
     * @param \KitchenBundle\Entity\RequestDetails $requestDetails
     */
    public function removeRequestDetail($requestDetails)
    {
        $this->requestdetails->removeElement($requestDetails);
    }

    /**
     * Get Request Details
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequestDetails()
    {
        return $this->requestdetails;
    }
}
