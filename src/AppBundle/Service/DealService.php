<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/9/2019
 * Time: 3:25 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Deal;
use AppBundle\Repository\DealRepository;

class DealService implements DealServiceInterface
{
    private $dealRepository;

    /**
     * DealService constructor.
     * @param $dealRepository
     */
    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    /**
     * @param int $id
     * @return null|object|Deal
     */
    public function find(int $id):?Deal
    {
      return $this->dealRepository->find($id);
    }

    public function findAll() :array
    {
        return $this->dealRepository->findAll();
    }

    public function save(Deal $deal)
    {
        return $this->dealRepository->save($deal);
    }

    public function update(Deal $deal):bool
    {
        return $this->dealRepository->update($deal);
    }

    public function delete(Deal $deal):bool
    {
       return $this->dealRepository->delete($deal);
    }


}