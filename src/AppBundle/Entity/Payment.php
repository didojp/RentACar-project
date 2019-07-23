<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payments")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentRepository")
 */
class Payment
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
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var ArrayCollection|Deal[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Deal", mappedBy="payment")
     */
    private $deals;

    /**
     * @var boolean
     * @ORM\Column(name="is_set", type="boolean")
     */
    private  $isSet;

    public function __construct()
    {
        $this->deals=new ArrayCollection();
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Deal[]|ArrayCollection
     */
    public function getDeals()
    {
        return $this->deals;
    }

    /**
     * @param Deal[]|ArrayCollection $deals
     */
    public function setDeals($deals): void
    {
        $this->deals = $deals;
    }

    /**
     * @return bool
     */
    public function isSet(): bool
    {
        return $this->isSet;
    }

    /**
     * @param bool $isSet
     */
    public function setIsSet(bool $isSet): void
    {
        $this->isSet = $isSet;
    }




}

