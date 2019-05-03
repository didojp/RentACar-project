<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Category;
use AppBundle\Entity\Transmision;
use AppBundle\Form\TransmisionType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Car controller.
 *
 * @Route("car")
 */
class CarController extends Controller
{
    /**
     * Lists all car entities.
     *
     * @Route("/", name="car_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('AppBundle:Car')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $cars, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );


        return $this->render('car/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * @Route("/select", name="car_select")
     * @Method("GET")
     *
     */
    public function selectAction()
    {

        $cars=$this->getDoctrine()->getManager()->getRepository(Car::class)->findByTransmision();

//        dump($cars);
//        exit;

        return $this->render('car/selected.html.twig', array('car'=>$cars,));

    }



    /**
     * Creates a new car entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/new", name="car_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $car = new Car();
        $form = $this->createForm('AppBundle\Form\CarType', $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file= $form->get('image')->getData();
// https://symfony.com/doc/3.4/controller/upload_file.html
            $fileName=$this->generateUniqueFileName().'.'.$file->guessExtension();

            try{
                $file->move(
                    $this->getParameter('car_directory'),$fileName
                );

                $car->setImage($fileName);

            }catch (FileException $ex){

            }
            $car->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('car_show', array('id' => $car->getId()));
        }

        return $this->render('car/new.html.twig', array(
            'car' => $car,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("/{id}", name="car_show")
     * @Method("GET")
     */
    public function showAction(Car $car)
    {

        $deleteForm = $this->createDeleteForm($car);

        return $this->render('car/show.html.twig', array(
            'car' => $car,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing car entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="car_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Car $car)
    {
       // $car->setImage(new File($this->getParameter('car_directory').'/'.$car->getImage()));
        //въпреки, че е дадено в документацията прави бели. Ако обектът е сетнат без снимка първоначално,
        //след това чупи и дава грешка при опит за едит.

        $deleteForm = $this->createDeleteForm($car);

        $editForm = $this->createForm('AppBundle\Form\CarType', $car);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $finder= new Finder();
            $finder->in('C:\Users\dpetkov.M-Daniel\RentACar\web\uploads\images');
            $oldFile= $finder->path('car_directory')->name($car->getImage());
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
            $fileName=$this->generateUniqueFileName().'.'.$file->guessExtension();


            try{
                $file->move(
                    $this->getParameter('car_directory'),$fileName
                );

                $car->setImage($fileName);

            }catch (FileException $ex){

            }
            $car->setImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_edit', array('id' => $car->getId()));
        }

        return $this->render('car/edit.html.twig', array(
            'car' => $car,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a car entity.
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/{id}", name="car_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Car $car
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Car $car)
    {
        $form = $this->createDeleteForm($car);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($car);
            $em->flush();
        }

        return $this->redirectToRoute('car_index');
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Car $car)
    {
                return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid( ));
    }






}