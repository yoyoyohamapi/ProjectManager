<?php

namespace CSCV\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BaseController
 * @package CSCV\Bundle\AppBundle\Controller
 * 继承基类
 */
class BaseController extends Controller
{


    /**
     * 返回JSON响应
     * @param $data :JSON数据
     * @param $statusCode :状态码
     * @param $msg :状态附加消息
     * @return JsonResponse 返回JSON回调信息
     * @throws \Exception
     */
    protected function createJsonResponse($data, $statusCode, $msg)
    {
        $dataArray = array(
            'data' => $data,
            'message' => $msg,
        );
        $response = new JsonResponse();
        $response->setData($dataArray);
        $response->setStatusCode($statusCode);

        return $response;
    }
}