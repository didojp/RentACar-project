<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Service\RoleService;
use AppBundle\Service\UserService;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    private $userService;
    private $roleService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService,RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService=$roleService;
    }


    /**
     * Lists all user entities.
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $users= $this->userService->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password=$this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());

            $user->setPassword($password);
            $userRole=$this->roleService->findOneBy('ROLE_USER');
            $user->addRole($userRole);


            $this->userService->save($user);

            return $this->redirectToRoute("security_login");
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $user=$this->userService->findAll();

        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $password=$this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $userRole=$this->roleService->findOneBy('ROLE_USER');

            $user->addRole($userRole);

            $this->userService->update($user);

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     * @Security("is_granted('ROLE_MODERATOR')")
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {

        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->userService->delete($user);
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
