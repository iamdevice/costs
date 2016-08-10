<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CostEntity;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller
{
    /**
     * @Route("/report", name="cur_month_report")
     */
    public function indexAction(Request $request)
    {
        $mgr = $this->getDoctrine()->getManager();
        $rep = $mgr->getRepository('AppBundle:CostEntity');
        $report_data = $rep->getCurrentMonthReport();
        return $this->render(
            'report/report.html.twig',
            array(
                'data' => $report_data
            )
        );
    }
}
