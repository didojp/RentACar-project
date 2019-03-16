<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deal
 *
 * @ORM\Table(name="deals")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DealRepository")
 */
class Deal
{
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
     * @ORM\Column(name="dealPrice", type="decimal", precision=10, scale=2)
     */
    private $dealPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfDays", type="integer")
     */
    private $numberOfDays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fromDate", type="date")
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="toDate", type="date")
     */
    private $toDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Car",inversedBy="deal")
     * @ORM\JoinColumn(name="car_id",referencedColumnName="id")
     */
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="deal")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param mixed $car
     */
    public function setCar($car): void
    {
        $this->car = $car;
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
     * Set dealPrice
     *
     * @param string $dealPrice
     *
     * @return Deal
     */
    public function setDealPrice($dealPrice)
    {
        $this->dealPrice = $dealPrice;

        return $this;
    }

    /**
     * Get dealPrice
     *
     * @return string
     */
    public function getDealPrice()
    {
        return $this->dealPrice;
    }

    /**
     * Set numberOfDays
     *
     * @param integer $numberOfDays
     *
     * @return Deal
     */
    public function setNumberOfDays($numberOfDays)
    {
        $this->numberOfDays = $numberOfDays;

        return $this;
    }

    /**
     * Get numberOfDays
     *
     * @return int
     */
    public function getNumberOfDays()
    {
        return $this->numberOfDays;
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     *
     * @return Deal
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set toDate
     *
     * @param \DateTime $toDate
     *
     * @return Deal
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * Get toDate
     *
     * @return \DateTime
     */
    public function getToDate()
    {
        return $this->toDate;
    }
}

