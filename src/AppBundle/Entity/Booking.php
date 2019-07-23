<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Booking
 *
 * @ORM\Table(name="bookings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Car",inversedBy="booking")
     * @ORM\JoinColumn(name="car_id",referencedColumnName="id")
     */
    private $car;

    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     * @Assert\NotBlank()     *
     * @ORM\Column(name="fromDate", type="datetime")
     *
     */
    private $fromDate;

    /**
     * @var \DateTime
     * @Assert\NotBlank()     *
     * @ORM\Column(name="toDate", type="datetime")
     *
     */
    private $toDate;

    /**
     * @var \DateInterval
     *
     * @ORM\Column(name="numberOfDays", type="integer")
     *
     */
    private $numberOfDays;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var \DateTime("now")
     */
    private $today;


//    public function setToday():void
//    {
//        $this->today=new \DateTime("now");
//        //$this->today= date('Y-m-d', 'H:i');
////        return $this;
//    }

    public function today()
    {

        return $this->today=new \DateTime("now");
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
     * Set fromDate
     *
     * @param \DateTime $fromDate
     *
     * @return Booking
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
     * @return Booking
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
     * Set numberOfDays
     *
     * @param integer
     *
     * @return Booking
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
     * Set price
     *
     * @param float $price
     *
     * @return Booking
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param mixed $car     *
     */
    public function setCar($car) :void
    {
        $this->car = $car;
    }

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
     * @return float
     */
    public function getTotalPrice() :float
    {
        return $this->getPrice()*$this->getNumberOfDays();

    }






}

