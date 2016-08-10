<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CostEntity;
use AppBundle\Form\CostForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CostController extends Controller
{
    /**
     * @Route("/cost", name="cost_list")
     */
    public function indexAction()
    {
        $cost = new CostEntity();
        $form = $this->getCostForm($cost, 'cost_add');

        return $this->render('cost/cost.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/cost/add", name="cost_add")
     * @Method("POST")
     */
    public function addCostAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'message' => 'Данная функция доступна только через AJAX'
                ),
                400
            );
        }

        $cost = new CostEntity();
        $form = $this->getCostForm($cost, 'cost_add');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            return new JsonResponse(
                array(
                    'message' => 'Success'
                ),
                200
            );
        }

        return new JsonResponse(
            array(
                'message' => 'Error',
                'data' => $this->renderView(
                    'cost/cost.html.twig',
                    array(
                        'form' => $form->createView()
                    )
                )
            ),
            400
        );
    }

    private function getCostForm($entity, $action)
    {
        $form = $this->createForm(
            new CostForm(),
            $entity,
            array(
                'action' => $this->generateUrl($action),
                'method' => 'POST'
            )
        );

        return $form;
    }
}
