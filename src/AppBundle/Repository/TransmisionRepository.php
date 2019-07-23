<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Transmision;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * TransmisionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TransmisionRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * TransmisionRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(Transmision::class));
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll()
    {
        return parent::findAll();
    }

    public function save(Transmision $transmision)
    {
        try
        {
            $this->_em->persist($transmision);
            $this->_em->flush();

            return true;
        }
        catch (\Exception $exception)
        {
            return false;
        }
    }
    public function update(Transmision $transmision)
    {
        try{
            $this->_em->merge($transmision);
            $this->_em->flush();

            return true;
        }catch (\Exception $exception){

            return false;
        }
    }

    public function delete(Transmision $transmision)
    {
        try{
            $this->_em->remove($transmision);
            $this->_em->flush();

            return true;
        }catch (\Exception $exception){

            return false;
        }
    }



}

