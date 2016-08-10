<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CategoryEntity;
use AppBundle\Form\CategoryForm;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="cat_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:CategoryEntity')->findAll();

        $cat = new CategoryEntity();
        $form = $this->getCategoryForm($cat, 'cat_add');
        return $this->render('category/category.html.twig', array('categories' => $categories, 'form' => $form->createView()));
    }

    /**
     * @Route("category/add", name="cat_add")
     * @Method("POST")
     */
    public function addCategoryAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'message' => 'Данная функция доступна только через AJAX'
                ),
                400
            );
        }

        $cat = new CategoryEntity();
        $form = $this->getCategoryForm($cat, 'cat_add');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            $added = array(
                'category_id' => $cat->getCategoryId(),
                'name' => $cat->getName()
            );

            return new JsonResponse(
                array(
                    'message' => 'Success',
                    'added' => $added
                ),
                200
            );
        }

        return new JsonResponse(
            array(
                'message' => 'Error',
                'data' => $this->renderView(
                    'category/category.html.twig',
                    array(
                        'categories' => $cat,
                        'form' => $form->createView()
                    )
                )
            ),
            400
        );
    }

    /**
     * @Route("/category/del", name="cat_del")
     * @Method("POST")
     */
    public function delCategoryAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'message' => 'Данная функция доступна только через AJAX'
                ),
                400
            );
        }

        // Получение ID удаляемой категории и ее удаление из базы
        $category_id = $request->request->get('category_id');
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:CategoryEntity')->find($category_id);
        $em->remove($category);
        $em->flush();

        return new JsonResponse(
            array(
                'message' => 'Success'
            ),
            200
        );

    }

    private function getCategoryForm($entity, $action)
    {
        $form = $this->createForm(
            new CategoryForm(),
            $entity,
            array(
                'action' => $this->generateUrl($action),
                'method' => 'POST'
            )
        );

        return $form;
    }
}
