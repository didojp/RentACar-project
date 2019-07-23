<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transmision;
use AppBundle\Service\TransmisionService;
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
    private $transmisionService;

    /**
     * TransmisionController constructor.
     * @param $transmisionService
     */
    public function __construct(TransmisionService $transmisionService)
    {
        $this->transmisionService = $transmisionService;
    }


    /**
     * Lists all transmision entities.
     *
     * @Route("/", name="transmision_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $transmisions= $this->transmisionService->findAll();

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

            $this->transmisionService->save($transmision);

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
     * @param $id
     *
     * @return Response
     */
    public function showAction($id)
    {
        $transmision=$this->transmisionService->find($id);

        return $this->render('transmision/show.html.twig', array(
            'transmision' => $transmision,
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

        $editForm = $this->createForm('AppBundle\Form\TransmisionType', $transmision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->transmisionService->update($transmision);

            return $this->redirectToRoute('transmision_edit', array('id' => $transmision->getId()));
        }

        return $this->render('transmision/edit.html.twig', array(
            'transmision' => $transmision,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a transmision entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="transmision_delete")
     *
     */
    public function deleteAction($id)
    {
        $transmision= $this->transmisionService->find($id);
        $this->transmisionService->delete($transmision);

        return $this->redirectToRoute('transmision_index');
    }





}
