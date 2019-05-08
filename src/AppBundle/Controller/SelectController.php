<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Category;
use AppBundle\Entity\Transmision;
use AppBundle\Repository\SelectRepository;
use AppBundle\Service\CarService;
use AppBundle\Service\CategoryService;
use AppBundle\Service\TransmisionService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectController extends Controller
{
    private $carService;
    private $transmisionService;
    private $categoryService;

    /**
     * SelectController constructor.
     * @param $carService
     * @param $transmisionService
     * @param $categoryService
     */
    public function __construct(CarService $carService,
                                TransmisionService $transmisionService,
                                CategoryService $categoryService)
    {
        $this->carService = $carService;
        $this->transmisionService = $transmisionService;
        $this->categoryService = $categoryService;
    }

    /**
     * Form defines user criteria car choice
     * @Route("/select/select", name="select_action")
     * @param Request $request
     * @return Response
     */

    public function selectAction(Request $request)
    {

        $transmision=$this->transmisionService->findAll();
        $category=$this->categoryService->findAll();

//        $em = $this->getDoctrine()->getManager();
//        $transmision = $em->getRepository('AppBundle:Transmision')->findAll();
//        $category= $em->getRepository('AppBundle:Category')->findAll();


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
                $selectedCars=$this->carService->findByCategory($category);
            }
            else
            {
                $selectedCars=$this->carService->findByAll($transmision, $category);
            }

            $cars=array();

            foreach ($selectedCars as $key=>$value)
            {
                foreach ($value as $key1=>$value1){
                    $id=$value1;
                    $car=$this->carService->find($id);
                    array_push($cars,$car);
                }
            }
            if ($cars==null)
            {
                $this->addFlash('notice', 'We are sorry, but we do not have such a car.
                                                            Please check for another one');
                return $this->render('transmision/select.html.twig',
                    array('transmisions'=>$transmision,
                        'category'=>$category,
                        'myform'=>$transmisionForm->createView()
                    )
                );
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
