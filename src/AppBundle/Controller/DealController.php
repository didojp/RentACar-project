<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Booking;
use AppBundle\Entity\Car;
use AppBundle\Entity\Deal;
use AppBundle\Entity\Payment;
use AppBundle\Entity\User;
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
    /**
     * Lists all deals entities.
     *
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/", name="deal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $deals = $em->getRepository('AppBundle:Deal')->findAll();

        return $this->render('deal/index.html.twig', array(
            'deals' => $deals,
        ));
    }

    /**
     * Creates a new deals entity.
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/new/{booking_id}", name="deal_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $booking_id
     * @return Response
     */
    public function newAction(Request $request, $booking_id)
    {


        /** @var User $bookerId */
        $bookerId=$this->getUser()?:null;

        if ($bookerId==null)
        {
            return $this->redirectToRoute('security_login');// да се довърши
        }

        $userId=$bookerId->getId();
        $user= $this->getDoctrine()->getManager()
                    ->getRepository(User::class)->find($userId);



       $deal = new Deal();
       $id=$booking_id;
       $booking=$this->getDoctrine()->getManager()
                     ->getRepository(Booking::class)
                     ->findCarAndBooking($id);

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

       //до тук работи!
       $payment=$this->getDoctrine()->getManager()->getRepository(Payment::class)->findAll();
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

       //Here should set the payment logic;

        if ($paymentForm->isSubmitted() && $paymentForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($deal);
            $em->flush();


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
