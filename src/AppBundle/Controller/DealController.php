<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\Car;
use AppBundle\Entity\Deal;
use AppBundle\Entity\Payment;
use AppBundle\Entity\User;
use AppBundle\Service\BookingService;
use AppBundle\Service\DealService;
use AppBundle\Service\PaymentService;
use AppBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deal controller.
 *
 * @Route("deals")
 */
class DealController extends Controller
{
    private $dealService;
    private $userService;
    private $bookingService;
    private $paymentService;

    /**
     * DealController constructor.
     * @param BookingService $bookingService
     * @param DealService $dealService
     * @param PaymentService $paymentService
     * @param UserService $userService
     */
    public function __construct(BookingService $bookingService,
                                DealService $dealService,
                                PaymentService $paymentService,
                                UserService $userService)
    {
        $this->dealService = $dealService;
        $this->userService = $userService;
        $this->bookingService= $bookingService;
        $this->paymentService= $paymentService;
    }


    /**
     * Lists all deals entities.
     *
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/", name="deal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $deals=$this->dealService->findAll();

        return $this->render('deal/index.html.twig', array(
            'deals' => $deals,
        ));
    }

    /**
     * Creates a new deals entity.
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @\Symfony\Component\Routing\Annotation\Route("/new/{booking_id}", name="deal_new", methods={"GET", "POST"})
     * @param Request $request
     * @param $booking_id
     * @return Response
     */
    public function newAction(Request $request, $booking_id)
    {
        var_dump('tuk sme');
        /** @var User $bookerId */
        $bookerId=$this->getUser()?:null;

        if ($bookerId==null)
        {
            $this->addFlash('notice','To oreder a car you should first to login/ register. ');
            return $this->redirectToRoute('security_login');// да се довърши
        }

        $userId=$bookerId->getId();
        $user=$this->userService->find($userId);

       $deal = new Deal();
       $id=$booking_id;
       $bookingArray=$this->bookingService->findCarAndBooking($id);

       $booking=$bookingArray[0];

       $car=$booking->getCar();
       $deal->setUser($user);
       $deal->setCar($car);
       $deal->setCarPrice($booking->getPrice());
       $deal->setFromDate($booking->getFromDate());
       $deal->setToDate($booking->getToDate());
       $deal->setNumberOfDays($booking->getNumberOfDays());
       $carPrice=$booking->getPrice();
       $numberOfDays=$booking->getNumberOfDays();
       $rentPrice=$carPrice*$numberOfDays;
       $deal->setDealPrice($rentPrice);


        $payment=$this->paymentService->findAll();
       $paymentForm=$this->createFormBuilder($payment)
           ->add('Payment', ChoiceType::class,array(
               'choices'=>array(
               'Will pay via PayPal'=>'via PayPal',
               'Expect a phone call from us within next 24 hours'=>'phone call',
                   ),
               'expanded'=>true,
           ))
           ->add('save', SubmitType::class, ['label'=>'Confirm_payment'])
           ->getForm();

        $paymentForm->handleRequest($request);

        if ($paymentForm->isSubmitted() && $paymentForm->isValid()) {
           $this->dealService->save($deal);

            return $this->redirectToRoute('deal_show', array('id' => $deal->getId()));
        }

        return $this->render('deal/new.html.twig', array(
            'deals' => $deal,
            'paymentForm' => $paymentForm->createView(),
        ));
    }

    /**
     * Finds and displays a deals entity.
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/{id}", name="deal_show")
     * @Method("GET")
     */
    public function showAction(Deal $deal)
    {
        $deleteForm = $this->createDeleteForm($deal);

        return $this->render('deal/show.html.twig', array(
            'deals' => $deal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing deals entity.
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/{id}/edit", name="deal_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Deal $deal
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Deal $deal)
    {
        $deleteForm = $this->createDeleteForm($deal);
        $editForm = $this->createForm('AppBundle\Form\DealType', $deal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('deal_edit', array('id' => $deal->getId()));
        }

        return $this->render('deal/edit.html.twig', array(
            'deals' => $deal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a deals entity.
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/{id}", name="deal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Deal $deal)
    {
        $form = $this->createDeleteForm($deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($deal);
            $em->flush();
        }

        return $this->redirectToRoute('deal_index');
    }

    /**
     * Creates a form to delete a deals entity.
     *
     * @param Deal $deal The deals entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Deal $deal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deal_delete', array('id' => $deal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
