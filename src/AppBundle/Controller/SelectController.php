<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Category;
use AppBundle\Entity\Transmision;
use AppBundle\Repository\SelectRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @param \Symfony\Component\HttpFoundation\Request
     * @Route("/select", name="index_action")
     */
    public function indexAction()
    {


        return new Response('palamud');
    }

    /**
     * Form defines user criteria car choice
     * @Route("/select/select", name="select_action")
     * @param Request $request
     * @return Response
     */

    public function selectAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $transmision = $em->getRepository('AppBundle:Transmision')->findAll();
        $category= $em->getRepository('AppBundle:Category')->findAll();


        $transmisionForm= $this->createFormBuilder()
                              ->add("transmision", EntityType::class,
                                              ['class'=>Transmision::class,
                                              'choice_label'=>'transmisionModel'])
                              ->add("category", EntityType::class,
                                          ['class'=>Category::class,
                                            'choice_label'=>'categoryName'])
                              ->add("save", SubmitType::class)
                              ->getForm();



       $transmisionForm->handleRequest($request);

        if ($transmisionForm->isSubmitted())
        {

            $transmision=$transmisionForm->get('transmision')->getData()->getId();
            $category=$transmisionForm->get('category')->getData()->getId();

            if ($transmision==3)
            {
                $selectedCars=$this->getDoctrine()->getManager()
                                ->getRepository(Car::class)
                                ->findByCategory($category);
            }
            else
            {
                $selectedCars=$this->getDoctrine()->getManager()
                    ->getRepository(Car::class)
                    ->findByAll($transmision, $category);
            }

            $cars=array();

            foreach ($selectedCars as $id)
            {
                $car=$em->getRepository('AppBundle:Car')->find($id);
               array_push($cars,$car);
            }

            return $this->render('car/selected.html.twig', array('cars'=>$cars));



        }


       return $this->render('transmision/select.html.twig',
           array('transmisions'=>$transmision,
                 'category'=>$category,
                 'myform'=>$transmisionForm->createView()
               )
           );

    }




}
