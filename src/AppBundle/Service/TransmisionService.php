<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/7/2019
 * Time: 10:44 AM
 */

namespace AppBundle\Service;

use AppBundle\Entity\Transmision;
use AppBundle\Repository\TransmisionRepository;

class TransmisionService implements TransmisionServiceInterface
{
    private $transmisionRepository;

    /**
     * TransmisionService constructor.
     * @param $transmisionRepository
     */
    public function __construct(TransmisionRepository $transmisionRepository)
    {
        $this->transmisionRepository = $transmisionRepository;
    }


    public function find(int $id)
    {
        return $this->transmisionRepository->find($id);

    }

    public function findAll()
    {
        return $this->transmisionRepository->findAll();
    }

    public function save(Transmision $transmision): bool
    {
        return $this->transmisionRepository->save($transmision);
    }

    public function update(Transmision $transmision): bool
    {
        return $this->transmisionRepository->update($transmision);
    }

    public function delete(Transmision $transmision): bool
    {
        return $this->transmisionRepository->delete($transmision);
    }

}