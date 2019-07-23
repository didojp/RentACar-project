<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Transmision
 *
 * @ORM\Table(name="transmisions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransmisionRepository")
 */
class Transmision
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
     * @ORM\Column(name="transmisionModel", type="string", length=255)
     */
    private $transmisionModel;

    /**
     * @var ArrayCollection|Car[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Car", mappedBy="transmision")
     *
     */
    private $car;

    public function __construct()
    {
        $this->car=new ArrayCollection();
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
     * Set transmisionModel
     *
     * @param string $transmisionModel
     *
     * @return Transmision
     */
    public function setTransmisionModel($transmisionModel)
    {
        $this->transmisionModel = $transmisionModel;

        return $this;
    }

    /**
     * Get transmisionModel
     *
     * @return string
     */
    public function getTransmisionModel()
    {
        return $this->transmisionModel;
    }

    public function __toString()
    {
        return $this->transmisionModel;
    }
}

