<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/7/2019
 * Time: 12:45 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;

class CategoryService implements CategoryServiceInterface
{
 private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function find(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function findAll()
    {
        return $this->categoryRepository->findAll();
    }

    public function save(Category $category): bool
    {
        return $this->categoryRepository->save($category);
    }

    public function update(Category $category): bool
    {
        return $this->categoryRepository->update($category);
    }

    public function delete(Category $category): bool
    {
        return $this->categoryRepository->delete($category);
    }


}