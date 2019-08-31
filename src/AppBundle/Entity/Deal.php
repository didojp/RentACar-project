<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var \DateInterval
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
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="deals")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Payment", inversedBy="deals")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     *
     */
    private $payment;

    /**
     * @ORM\Column(name="car_price", type="decimal", precision=10, scale=2)
     */
    private $carPrice;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Extra", mappedBy="deals")
     */
    private $extras;

    public function __construct()
    {
        $this->extras= new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCarPrice()
    {
        return $this->carPrice;
    }

    /**
     * @param mixed $carPrice
     */
    public function setCarPrice($carPrice): void
    {
        $this->carPrice = $carPrice;
    }




    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Deal
     */
    public function setUser(User $user= null) //: void
    {
        $this->user = $user;
        return $this;
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * Set numberOfDays
     *
     * @param \DateInterval $numberOfDays
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
     * @return \DateInterval
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

    /**
     * @return string
     */
    public function getPayment(): string
    {
        return $this->payment;
    }

    /**
     * @param string $payment
     */
    public function setPayment(string $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return string
     */
    public function getDealPrice(): string
    {
        return $this->dealPrice;
    }

    /**
     * @param string $dealPrice
     */
    public function setDealPrice(string $dealPrice): void
    {
        $this->dealPrice = $dealPrice;
    }

    public function addExtra(Extra $extra)
    {
        $extra->addDeal($this);
        $this->extras[]=$extra;

    }






}

