<?php

namespace CSCV\Bundle\StorageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CSCVStorageBundle:Default:index.html.twig', array('name' => $name));
    }
}
