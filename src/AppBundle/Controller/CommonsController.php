<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommonsController extends Controller
{
    /**
     * @param Request $request
     * @Route("/commons/news", name="show_news", methods={"GET"})
     * @return Response
     */
    public function showNewsAction(Request $request)
    {
        return $this->render('common/news.html.twig');
    }

    /**
     * @param Request $request
     * @Route("/commons/aboutUs", name="aboutUs_action",methods={"GET"})
     * @return Response
     *
     */
    public function aboutUsAction(Request $request)
    {
        return $this->render('common/aboutUs.thml.twig');
    }
}
