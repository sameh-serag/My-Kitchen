<?php

namespace KitchenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KitchenBundle\Entity\RatingRepository")
 */
class Rating
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
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    /**
     * @var integer
     *
     * @ORM\Column(name="hot", type="integer")
     */
    private $hot;

    /**
     * @var integer
     *
     * @ORM\Column(name="clean", type="integer")
     */
    private $clean;

    /**
     * @var integer
     *
     * @ORM\Column(name="taste", type="integer")
     */
    private $taste;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\User", inversedBy="ratings")
     * @ORM\JoinColumn(name="chef_id", referencedColumnName="id")
     */
    private $chef;

    /**
     * @ORM\ManyToOne(targetEntity="KitchenBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set time
     *
     * @param integer $time
     * @return Rating
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set hot
     *
     * @param integer $hot
     * @return Rating
     */
    public function setHot($hot)
    {
        $this->hot = $hot;

        return $this;
    }

    /**
     * Get hot
     *
     * @return integer 
     */
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * Set clean
     *
     * @param integer $clean
     * @return Rating
     */
    public function setClean($clean)
    {
        $this->clean = $clean;

        return $this;
    }

    /**
     * Get clean
     *
     * @return integer 
     */
    public function getClean()
    {
        return $this->clean;
    }

    /**
     * Set taste
     *
     * @param integer $taste
     * @return Rating
     */
    public function setTaste($taste)
    {
        $this->taste = $taste;

        return $this;
    }

    /**
     * Get taste
     *
     * @return integer 
     */
    public function getTaste()
    {
        return $this->taste;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Rating
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Rating
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set Chef
     *
     * @param \KitchenBundle\Entity\User $chef
     * @return Rating
     */
    public function setChef($chef = null)
    {
        $this->chef = $chef;

        return $this;
    }

    /**
     * Get Chef
     *
     * @return \KitchenBundle\Entity\User
     */
    public function getChef()
    {
        return $this->chef;
    }

    /**
     * Set User
     *
     * @param \KitchenBundle\Entity\User $user
     * @return Rating
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return \KitchenBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
