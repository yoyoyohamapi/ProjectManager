<?php

namespace CSCV\Bundle\RESTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CSCVRESTBundle:Default:index.html.twig', array('name' => $name));
    }
}
