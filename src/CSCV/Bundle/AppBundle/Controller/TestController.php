<?php
/**
 * Created by CSCV.
 * User: Woo
 * Date: 15/4/6
 * Time: 下午10:38
 */

namespace CSCV\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{

    public function seaAction()
    {
        return $this->render('CSCVAppBundle:Test:sea.html.twig');
    }

}