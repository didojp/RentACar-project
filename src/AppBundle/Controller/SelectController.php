<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transmision;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     *
     * @Route("/select/select", name="select_action")
     * @param Request $request
     */

    public function transmisionSelectAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $transmisions = $em->getRepository('AppBundle:Transmision')->findAll();


       $transmisionForm= $this->createFormBuilder($transmisions)
       ->add("transmisions", EntityType::class,
           ['class'=>Transmision::class,
               'choice_label'=>'transmisionModel'])
       ->getForm();
       var_dump(array('transmisions'=>$transmisions));
       exit;



       return $this->render('transmision/select.html.twig',
           array('transmisions'=>$transmisions,
               'myform'=>$transmisionForm->createView()
               )
           );

    }


}
