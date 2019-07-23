<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Booking;
use AppBundle\Entity\Car;
use AppBundle\Service\BookingService;
use AppBundle\Service\CarService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{

    private $bookingService;
    private $carService;

    /**
     * BookingController constructor.
     * @param BookingService $bookingService
     * @param CarService $carService
     */
    public function __construct(BookingService $bookingService,CarService $carService)
    {
        $this->bookingService = $bookingService;
        $this->carService= $carService;
    }

    /**
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/booking",name="booking_index")
     * @Method("GET")
     * @return Response
     */
    public function indexAction()
    {
        $bookings= $this->bookingService->findAll();

        return $this->render('booking/indexBooking.html.twig', array('bookings' => $bookings));
    }

    /**
     * @Route("/booking/delete", name="booking_deleteall")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function deleteAllAction(Request $request)
    {
        $this->bookingService->deleteAll();
        $bookings=$this->bookingService->findAll();

        if ($bookings==null){
            $this->addFlash('notice', 'The whole booking list was successfully deleted');
        }
        return $this->render('booking/indexBooking.html.twig', array('bookings' => $bookings));
    }

    /**
     *
     * @Route("/booking/{car_id}", name="booking_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $car_id
     * @return Response
     *
     * @throws \Exception
     */
    public function newBookingAction(Request $request, $car_id)
    {

        $booking= new Booking();
        /** @var Car $car */
        $id=$car_id;

        $car=$this->carService->find($id);

        $booking->setCar($car);
        $booking->setPrice($car->getPrice());
        $bookingForm=$this->createForm('AppBundle\Form\BookingType', $booking);
        $bookingForm->handleRequest($request);



        if ($bookingForm->isValid()&&$bookingForm->isSubmitted())
        {
            //calculate number of days based over fromDate and toDate
            $start=$booking->getFromDate();
            $final=$booking->getToDate();
            $numberOfDays=date_diff($start,$final);
            $days=$numberOfDays->d;
            $booking->setNumberOfDays($days);
            $today=$booking->today();
            if ($start< $today||$final<$start) //check does choosen dates are valid
            {
                $this->addFlash('notice','The chosen dates are not valid!');
                return $this->render('booking/carBooking.html.twig', array(
                    'booking'=>$booking,
                    'bookingForm' => $bookingForm->createView(),
                ));
            }

            $this->bookingService->save($booking);

            return $this->render('booking/bookedCar.html.twig',['booking'=>$booking]);
        }

        return $this->render('booking/carBooking.html.twig', array(
            'booking'=>$booking,
            'bookingForm' => $bookingForm->createView(),
        ));


    }



}
