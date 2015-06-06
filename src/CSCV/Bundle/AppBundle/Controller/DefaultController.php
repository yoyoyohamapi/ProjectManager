<?php

namespace CSCV\Bundle\AppBundle\Controller;


class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->redirectToRoute('cscv_app_image_index');
    }

    public function createTokenAction()
    {

    }


}
