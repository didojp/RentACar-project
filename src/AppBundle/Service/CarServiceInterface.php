<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/7/2019
 * Time: 10:16 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Car;
use AppBundle\Entity\Category;
use AppBundle\Entity\Transmision;

interface CarServiceInterface
{
    public function save(Car $car):bool ;
    public function update(Car $car):bool ;
    public function delete(Car $car):bool ;
    public function find(int $id);
    public function findAll();
    public function findByAll(int $transmision, int $category);
    public function findByCategory(int $category);

}

