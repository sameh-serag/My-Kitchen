<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequestDetails
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\RequestDetailsRepository")
 */
class RequestDetails
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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\Request", inversedBy="requestdetails")
     * @ORM\JoinColumn(name="request_id", referencedColumnName="id")
     */
    private $request;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\Plate")
     * @ORM\JoinColumn(name="plate_id", referencedColumnName="id")
     */
    private $plate;


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
     * Set quantity
     *
     * @param integer $quantity
     * @return RequestDetails
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return \KitchenBundle\Entity\Request
     */

    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \KitchenBundle\Entity\Request $request
     * @return RequestDetails
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \KitchenBundle\Entity\Plate
     */

    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * @param \KitchenBundle\Entity\Plate $plate
     * @return Plate
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;
    }

}
