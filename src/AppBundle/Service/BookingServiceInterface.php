<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/8/2019
 * Time: 6:13 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Booking;

interface BookingServiceInterface
{
    public function find(int $id):?Booking;
    public function findAll();
    public function findCarAndBooking(int $id):array ;
    public function save(Booking $booking):bool;
    public function delete(Booking $booking):bool;
    public function deleteAll():bool;

}