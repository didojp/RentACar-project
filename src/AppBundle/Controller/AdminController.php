<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/admin", name="admin_panel", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function indexAdminAction(Request $request)
    {
        return $this->render('administration/admin.html.twig');
    }
    //довърши админ панела
}
