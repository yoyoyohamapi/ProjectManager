<?php

namespace CSCV\Bundle\RESTBundle\EventListener;

use CSCV\Bundle\RESTBundle\Controller\TokenAuthenticatedController;
use CSCV\Bundle\StorageBundle\Service\ApiTokenService;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/3
 * Time: 下午4:37
 */
class TokenListener
{
    private $tokenService;
    private $tokenStr;

    public function __construct($tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof TokenAuthenticatedController) {
            $headers = $event->getRequest()->headers;
            if ($this->isHeaderValid($headers)) {
                $tokenStatus = $this->tokenService->isValid($this->tokenStr);
                switch ($tokenStatus) {
                    case ApiTokenService::INVALID_TOKEN:
                        throw new UnauthorizedHttpException('Invalid Token');
                        break;
                    case ApiTokenService::OUT_OF_DATE_TOKEN:
                        throw new UnauthorizedHttpException('Token is out of date');
                        break;
                    case ApiTokenService::VALID_TOKEN:
                        break;
                }
            } else {
                throw new BadRequestHttpException('Invalid Header');
            }
        }
    }

    public function isHeaderValid($headers)
    {
        $authStr = $headers->get('Authorization');
        if (empty($authStr)) {
            return false;
        } else {
            $strArr = explode(' ', $authStr);
            if (count($strArr) != 2) {
                return false;
            }
            $bearer = $strArr[0];
            $tokenStr = $strArr[1];
            if ($bearer != 'Bearer') {
                return false;
            }
            $this->tokenStr = $tokenStr;

            return true;
        }
    }
}