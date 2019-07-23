<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraint as Assert;



/**
 * Car
 *
 * @ORM\Table(name="cars")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
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
     * @ORM\Column(name="make", type="string", length=255)
     */
    private $make;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transmision",inversedBy="car")
     * @ORM\JoinColumn(name="transmision_id", referencedColumnName="id")
     */
    private $transmision;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category",inversedBy="car")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var ArrayCollection|Deal[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Deal",mappedBy="car")
     */

    private $deal;

    /**
     * @var int
     *
     * @ORM\Column(name="seats", type="integer")
     */
    private $seats;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", nullable=false)
     *
     *
     */
    private $image;

    /**
     * @var boolean
     * @ORM\Column(name="is_booked", type="boolean", options={"default"="0"},nullable=true)
     */
    private $isBooked;

    /**
     * @var ArrayCollection|Booking[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Booking",mappedBy="car")
     */
    private $booking;

    /**
     * @return bool
     */
    public function isBooked(): ?bool
    {
        return $this->isBooked;
    }

    /**
     * @param bool $isBooked
     */
    public function setIsBooked(bool $isBooked): void
    {
        $this->isBooked = $isBooked;
    }




    public function __construct()
    {
        $this->deal=new ArrayCollection();
        $this->booking=new ArrayCollection();

    }

    /**
     * @return Deal[]|ArrayCollection
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param Deal[]|ArrayCollection $deal
     */
    public function setDeal($deal): void
    {
        $this->deal = $deal;
    }


    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }


    /**
     * @return mixed
     */
    public function getTransmision()
    {
        return $this->transmision;
    }

    /**
     * @param mixed $transmision
     */
    public function setTransmision($transmision): void
    {
        $this->transmision = $transmision;
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
     * Set make
     *
     * @param string $make
     *
     * @return Car
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Car
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
     * @return int
     */
    public function getSeats(): ?int
    {
        return $this->seats;
    }

    /**
     * @param int $seats
     */
    public function setSeats(int $seats): void
    {
        $this->seats = $seats;
    }

    /**
     * @return string
     */
    public function getImage() : ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Car
     */
    public function setImage($image)  //i string v skobite
    {
        $this->image = $image;
        return $this;
    }

    public function _toString()
    {
        return $this->getId();
    }

    /**
     * @return Booking[]|ArrayCollection
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * @param Booking[]|ArrayCollection $booking
     */
    public function setBooking($booking): void
    {
        $this->booking[] = $booking;
    }


}

