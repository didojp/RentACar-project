<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="categoryName", type="string", length=255)
     */
    private $categoryName;

    /**
     * @var ArrayCollection|Car[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Car",mappedBy="category")
     *
     */
    private $car;

    public function __construct()
    {
        $this->car= new ArrayCollection();
    }

    /**
     * @return Car[]|ArrayCollection
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param Car[]|ArrayCollection $car
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
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function __toString()
    {
        return $this ->categoryName;
    }
}

