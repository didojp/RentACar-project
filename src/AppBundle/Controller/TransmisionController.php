<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transmision;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Transmision controller.
 *
 * @Route("transmision")
 */
class TransmisionController extends Controller
{
    /**
     * Lists all transmision entities.
     *
     * @Route("/", name="transmision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transmisions = $em->getRepository('AppBundle:Transmision')->findAll();

        return $this->render('transmision/index.html.twig', array(
            'transmisions' => $transmisions,
        ));
    }

   
    /**`
     * Creates a new transmision entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="transmision_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $transmision = new Transmision();
        $form = $this->createForm('AppBundle\Form\TransmisionType', $transmision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transmision);
            $em->flush();

            return $this->redirectToRoute('transmision_show', array('id' => $transmision->getId()));
        }

        return $this->render('transmision/new.html.twig', array(
            'transmision' => $transmision,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transmision entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="transmision_show")
     * @Method("GET")
     */
    public function showAction(Transmision $transmision)
    {
        $deleteForm = $this->createDeleteForm($transmision);

        return $this->render('transmision/show.html.twig', array(
            'transmision' => $transmision,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transmision entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="transmision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Transmision $transmision)
    {
        $deleteForm = $this->createDeleteForm($transmision);
        $editForm = $this->createForm('AppBundle\Form\TransmisionType', $transmision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transmision_edit', array('id' => $transmision->getId()));
        }

        return $this->render('transmision/edit.html.twig', array(
            'transmision' => $transmision,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transmision entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="transmision_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Transmision $transmision)
    {
        $form = $this->createDeleteForm($transmision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transmision);
            $em->flush();
        }

        return $this->redirectToRoute('transmision_index');
    }

    /**
     * Creates a form to delete a transmision entity.
     *
     * @param Transmision $transmision The transmision entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Transmision $transmision)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transmision_delete', array('id' => $transmision->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



}
