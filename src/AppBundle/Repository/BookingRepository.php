<?php

namespace AppBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCarAndBooking($id)
    {
        $query=$this->getEntityManager()->createQuery('SELECT b, c FROM AppBundle:Booking b
                                                            JOIN b.car c
                                                            WHERE b.id=:id'
        )->setParameter('id',$id);
        try
        {
            return $query->getOneOrNullResult();
        }
        catch (NonUniqueResultException $e)
        {
            echo 'No such booking finded';
        }
    }
}
