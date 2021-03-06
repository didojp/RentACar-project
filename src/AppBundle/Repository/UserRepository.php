<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(User::class));
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll()
    {
        return parent::findAll();
    }

    public function save(User $user)
    {
        try{
            $this->_em->persist($user);
            $this->_em->flush();

            return true;
        }catch (\Exception $exception){

            return false;
        }
    }

    public function update(User $user){
        try{
            $this->_em->merge($user);
            $this->_em->flush();

            return true;
        }catch (\Exception $exception){

            return false;
        }
    }
    public function delete(User $user)
    {
        try{
            $this->_em->remove($user);
            $this->_em->flush();
            return true;
        }catch (\Exception $exception){

            return false;
        }
    }

}
