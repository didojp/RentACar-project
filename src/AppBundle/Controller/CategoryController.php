<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Service\CategoryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Lists all category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $categories=$this->categoryService->findAll();
//        $em = $this->getDoctrine()->getManager();
//
//        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new category entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->save($category);
            $this->addFlash('notice', "The category was successfully created.");

            return $this->redirectToRoute('category_show', array('id' => $category->getId()));
        }

        return $this->render('category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $category=$this->categoryService->find($id);

        return $this->render('category/show.html.twig', array(
            'category' => $category,

        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {

        $editForm = $this->createForm('AppBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->categoryService->update($category);
            $this->addFlash('notice', "The category was updated successfully.");

            return $this->redirectToRoute('category_edit', array('id' => $category->getId()));
        }

        return $this->render('category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),

        ));
    }

    /**
     * Deletes a category entity.
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="category_delete")     *
     */
    public function deleteAction($id)
    {
        $category=$this->categoryService->find($id);
        $this->categoryService->delete($category);
        $this->addFlash('notice', "The category was successfully deleted.");

        return $this->redirectToRoute('category_index');
    }


}
