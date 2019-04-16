<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/login", name="security_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error= $authenticationUtils->getLastAuthenticationError();
        $lastUsername=$authenticationUtils->getLastUsername();
        if ($this->getUser()){
            dump($this->getUser());
            exit;
            return $this->redirectToRoute('car_index');
        }

        return $this->render('security/login.html.twig',['last_username'=>$lastUsername,
            'error'=> $error]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @return Response
     */
    public function logoutAction()
    {
        return $this->render('car/index.html.twig');
    }
}
