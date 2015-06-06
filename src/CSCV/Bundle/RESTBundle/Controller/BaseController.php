<?php

namespace CSCV\Bundle\RESTBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController implements TokenAuthenticatedController
{

}