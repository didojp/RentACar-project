<?php


namespace AppBundle\Service;


use AppBundle\Entity\Extra;
use AppBundle\Repository\ExtraRepository;

class ExtraService implements ExtraServiceInterface
{
    private $extraRepository;

    /**
     * ExtraService constructor.
     * @param ExtraRepository $extraRepository
     */

    public function __construct(ExtraRepository $extraRepository)
    {
        $this->extraRepository=$extraRepository;
    }


    public function save(Extra $extra)
    {
        return $this->extraRepository->save($extra);
    }

    public function update(Extra $extra): bool
    {
        return $this->extraRepository->update($extra);
    }

    public function delete(Extra $extra): bool
    {
       return $this->extraRepository->delete($extra);
    }

    /**
     * @param int $id
     * @return null|object|Extra
     */
    public function find(int $id): ?Extra
    {
        return $this->extraRepository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->extraRepository->findAll();
    }


}