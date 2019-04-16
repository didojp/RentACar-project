<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Booking;
use AppBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    /**
     * @Route("/booking",name="booking_index")
     * @Method("GET")
     * @param $name
     * @return Response
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    /**
     *
     * @Route("/booking/{car_id}", name="booking_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $car_id
     * @return Response
     *
     */
    public function newBookingAction(Request $request, $car_id)
    {

        $booking= new Booking();
        /** @var Car $car */
        $id=$car_id;

        $car= $this->getDoctrine()->getRepository(Car::class)->find($id);

        $booking->setCar($car);
        $booking->setPrice($car->getPrice());
        $bookingForm=$this->createForm('AppBundle\Form\BookingType', $booking);
        $bookingForm->handleRequest($request);



        if ($bookingForm->isValid()&&$bookingForm->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($booking);
//            $em->flush();
            $start=$booking->getFromDate();
            $final=$booking->getToDate();
            $numberOfDays=date_diff($start,$final);
            $days=$numberOfDays->d;
            $booking->setNumberOfDays($days);

            $em->persist($car);
            $em->persist($booking);
            $em->flush();

            return $this->render('booking/bookedCar.html.twig',['booking'=>$booking]);
        }

        return $this->render('booking/carBooking.html.twig', array(
            'booking'=>$booking,
            'bookingForm' => $bookingForm->createView(),
        ));


    }

//    /**
//     * @Route("/booking/{id}", name="booking_show")
//     * @param $id
//     * @Method("GET")
//     * @return Response
//     */
//
//    public function bookingShowAction(Booking $booking)
//    {
//
//        $deleteForm = $this->createDeleteForm($booking);
//
//
//
//        return $this->render('booking/bookedCar.html.twig', array(
//            'booking' => $booking,
//            'deleteForm'=>$deleteForm->createView(),
//        ));
//
//    }

//    /**
//     * Deletes a booking entity.
//     *
//     * @Route("/{id}", name="booking_delete")
//     * @Method("DELETE")
//     * @param Request $request
//     * @param Booking $booking
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function deleteAction(Request $request, Booking $booking)
//    {
//        $form = $this->createDeleteForm($booking);
//
//        $form->handleRequest($request);
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($booking);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('car_index');
//    }

    /**
     * Creates a form to delete a booking entity.
     *
     * @param Booking $booking The booking entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Booking $booking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('booking_delete', array('id' => $booking->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }



}
