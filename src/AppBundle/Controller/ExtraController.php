<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Extra;
use AppBundle\Service\ExtraService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExtraController extends Controller
{

    private $extraService;

    /**
     * ExtraController constructor.
     * @param $extraService
     */

    public function  __construct(ExtraService $extraService)
    {
        $this->extraService=$extraService;
    }

    /**
     *  List of all extras
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/extras", name="extra_index", methods={"GET"})
     *
     */

    public function indexAction(Request $request)
    {
        $extras=$this->extraService->findAll();

        $paginator=$this->get('knp_paginator');
        $pagination= $paginator->paginate(
            $extras,
            $request->query->getInt('page', 1), 5
        );

        return $this->render('extra/index.html.twig', array(
            'pagination'=>$pagination,
        )); // the view page should be added!!
    }

    /**
     *
     * @Route("/extras/new", name="extra_new", methods={"GET","POST"})
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
                // @Security("is_granted('ROLE_MODERATOR')")
    public function newAction(Request $request)
    {
        $extra= new Extra();
        $form=$this->createForm('AppBundle\Form\ExtraType', $extra);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            var_dump($form->getData());

            /** @var UploadedFile $file */
            $file=$form->get('image')->getData();
            $fileName=$this->generateUniqueExtrasName().'.'.$file->guessExtension();

            try{
                $file->move(
                    $this->getParameter('extras_directory'),$fileName
                );
                $extra->setImage($fileName);

            }catch (FileException $ex){

            }
            $extra->setImage($fileName);
        $this->extraService->save($extra);
        $this->addFlash('notice', 'The extra was updated successfully.');

            return $this->redirectToRoute('extra_index', array('id'=>$extra->getId()));
        }

        return $this->render('extra/new.html.twig', array(
            'extra'=> $extra,
            'form'=>$form->createView(),
        ));
    }

    /**
     * Displays a single gadget with its details.
     * @Route("/extras/{id}", name="extra_show", methods={"GET"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showAction(int $id)
    {
        $extra=$this->extraService->find($id);

        return $this->render('extra/show.html.twig', array(
            'extra'=>$extra,
        ));
    }

    /**
     *
     * @Security("has_role('ROLE_ADMIN','ROLE_MODERATOR')")
     * @Route("/{id}/delete", name="extra_delete", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {

        $extra=$this->extraService->find($id);
        $form=$this->createDeleteForm($extra);
        $form->handleRequest($request);
            if ($form->isSubmitted()&&$request->getMethod()=="POST"){
                $this->extraService->delete($extra);
                $this->addFlash('notice', 'The chosen extra was successfully deleted');

                return $this->redirectToRoute('extra_index');
            }


        return $this->render('extra/delete_confirm.html.twig', array(
            'delete_form'=>$form->createView(),
            'extra'=>$extra,
        ));

    }
    private function createDeleteForm(Extra $extra)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('extra_delete', array('id'=>$extra->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }

    /**
     * Displays a form to edit an existing extra entity.
     * @Security("has_role('ROLE_MODERATOR')")
     * @Route("/{id}/edit", name="extra_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Extra $extra
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function editAction(Request $request, Extra $extra)
    {

        $editForm = $this->createForm('AppBundle\Form\ExtraType', $extra);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $finder= new Finder();
            $finder->in('C:\Users\dpetkov.M-Daniel\RentACar-project\web\uploads\extras');
            $oldFile= $finder->path('extras_directory')->name($extra->getId());
            //за да не става натрупване на снимки при едит се маха старата и тогава се едитва новата.
            //машинката не работи, обаче! Защо?

            if (!$oldFile==null)
            {
                $fs=new Filesystem();
                $fs->remove($oldFile);
            }

            /** @var UploadedFile $file */
            $file= $editForm->get('image')->getData(); //това не е като в документацията, но работи
// https://symfony.com/doc/3.4/controller/upload_file.html
            $fileName=$this->generateUniqueExtrasName().'.'.$file->guessExtension();


            try{
                $file->move(
                    $this->getParameter('extras_directory'),$fileName
                );

                $extra->setImage($fileName);

            }catch (FileException $ex){

            }
            $extra->setImage($fileName);

            $this->extraService->update($extra);

            $this->addFlash('notice', "The gadget was updated successfully.");

            return $this->redirectToRoute('extra_show', array('id' => $extra->getId()));
        }

        return $this->render('extra/edit.html.twig', array(
            'extra' => $extra,
            'edit_form' => $editForm->createView(),

        ));
    }

    /**
     * @return string
     */
    private function generateUniqueExtrasName()
    {
        return md5(uniqid( ));
    }


}
