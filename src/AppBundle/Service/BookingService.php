<?php
/**
 * Created by PhpStorm.
 * User: dpetkov
 * Date: 5/8/2019
 * Time: 6:21 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Booking;
use AppBundle\Repository\BookingRepository;

class BookingService implements BookingServiceInterface
{
    private $bookingRepository;

    /**
     * BookingService constructor.
     * @param $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @param int $id
     * @return null|object|Booking
     */
    public function find(int $id): ?Booking
    {
        return $this->bookingRepository->find($id);
    }

    public function findAll():array
    {
        return $this->bookingRepository->findAll();
    }

    public function findCarAndBooking(int $id):array
    {
        return $this->bookingRepository->findCarAndBooking($id);
    }

    public function save(Booking $booking): bool
    {
        return $this->bookingRepository->save($booking);
    }

    public function delete(Booking $booking): bool
    {
        return $this->bookingRepository->delete($booking);
    }
    public function deleteAll(): bool
    {
        return $this->bookingRepository->deleteAll();
    }


}