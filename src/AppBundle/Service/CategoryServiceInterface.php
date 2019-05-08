<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/7/2019
 * Time: 12:45 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Category;

interface CategoryServiceInterface
{
    public function find(int $id);
    public function findAll();
    public function save(Category $category):bool ;
    public function update(Category $category):bool ;
    public function delete(Category $category):bool ;

}