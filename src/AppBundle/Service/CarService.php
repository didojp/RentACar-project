<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/7/2019
 * Time: 10:17 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Car;
use AppBundle\Entity\Category;
use AppBundle\Entity\Transmision;
use AppBundle\Repository\CarRepository;

class CarService implements CarServiceInterface
{
    private $carRepository;

    /**
     * CarService constructor.
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }


    public function save(Car $car)
    {
        return $this->carRepository->save($car);
    }

    public function update(Car $car):bool
    {
        return $this->carRepository->update($car);
    }


    public function delete(Car $car):bool
    {

        return $this->carRepository->delete($car);
    }

    /**
     * @param int $id
     * @return null|object|Car
     */
    public function find(int $id): ?Car
    {
        return $this->carRepository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->carRepository->findAll();
    }

    public function findByAll(int $transmision, int $category)
    {
        return $this->carRepository->findByAll($transmision, $category);
    }

    public function findByCategory(int $category)
    {
        return $this->findByCategory($category);
    }

    public function lastInsertedId(): int
    {
        return $this->carRepository->lastInsertedId();
    }


}

