<?php

namespace CSCV\Bundle\AppBundle\Controller;


class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('CSCVAppBundle:Default:index.html.twig');
    }


}
