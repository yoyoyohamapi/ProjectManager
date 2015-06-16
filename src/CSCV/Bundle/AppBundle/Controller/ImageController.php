<?php

namespace CSCV\Bundle\AppBundle\Controller;


use CSCV\Bundle\AppBundle\Utils\JsonMsgUtils;
use CSCV\Bundle\StorageBundle\Document\Author;
use CSCV\Bundle\StorageBundle\Document\Book;
use CSCV\Bundle\StorageBundle\Document\Image;
use CSCV\Bundle\StorageBundle\Document\ImageFile;
use CSCV\Bundle\StorageBundle\Document\State;
use CSCV\Bundle\StorageBundle\Form\Type\ImageType;
use CSCV\Bundle\StorageBundle\Service\ImageService;
use FOS\RestBundle\Util\Codes;
use Gedmo\Uploadable\FakeFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends BaseController
{

    /**
     * 图像标定主页
     */
    public function indexAction()
    {
        // 产生首页需要的两个表单
        $image = new Image();
        $newForm = $this->generateForm(
            $image,
            $this->generateUrl('cscv_app_image_new'),
            'POST'
        );

        $editForm = $this->generateForm(
            $image,
            $this->generateUrl('cscv_app_image_update'),
            'PUT'
        );
        return $this->render(
            '@CSCVApp/Image/index.html.twig',
            array(
                'newForm' => $newForm->createView(),
                'editForm' => $editForm->createView()
            )
        );
    }

    /**
     * 新建图像
     * @param $request 请求响应
     */
    public function newAction(Request $request)
    {
        $image = new Image();
        $form = $this->generateForm(
            $image,
            $this->generateUrl('cscv_app_image_new'),
            'POST'
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $fileName = ImageService::IMAGE_DIR.'//tmp//'.$request->get('path');
            $imageService = $this->get('image_service');
            // 设置图像标定状态为True
            $image->setState(State::SETTED);
            $fileInfo = array(
                ImageService::FILE_INFO_TMP_KEY => new File($fileName),
                ImageService::FILE_INFO_TYPE_KEY => ImageFile::IMAGE_SRC_TYPE
            );
            $imageService->setImgFile($image, $fileInfo);
            $response = array(
                'success' => true
            );
            $jsonData = $image;
            $statusCode = Codes::HTTP_OK;
            $msg = JsonMsgUtils::ERROR_MSG;

        } else {
            $jsonData = JsonMsgUtils::FORM_INVALID_CB;
            $statusCode = Codes::HTTP_BAD_REQUEST;
            $msg = JsonMsgUtils::ERROR_MSG;
        }

        return $this->createJsonResponse(
            $jsonData,
            $statusCode,
            $msg
        );
    }

    /**
     * 图像上传方法
     */
    public function uploadAction(Request $request)
    {
        $imageService = $this->get('image_service');
        $data = $imageService->uploadAction($request);

        return $this->createJsonResponse(
            $data,
            JsonResponse::HTTP_OK,
            ''
        );
    }


    /**
     * 获得信息不完整的图像
     * @return JsonResponse
     */
    public function getBrokenImgsAction()
    {
        $imageService = $this->get('image_service');
        $images = $imageService->getBrokenImgs();
        if (empty($images)) {
            $jsonData = "";
            $statusCode = Codes::HTTP_NO_CONTENT;
            $msg = JsonMsgUtils::ERROR_MSG;
        } else {
            $jsonData = $images->toArray();
            $statusCode = Codes::HTTP_OK;
            $msg = JsonMsgUtils::SUCCESS_MSG;
        }

        return $this->createJsonResponse($jsonData, $statusCode, $msg);
    }

    /**
     * 更新图像方法
     * @param $request 请求
     */
    public function updateAction(Request $request)
    {
        $imageService = $this->get('image_service');
        $imageId = $request->get('image_id');
        $request->request->remove('image_id');
        // 根据Id获得待更新图像
        $image = $imageService->find($imageId);
        $form = $this->generateForm(
            $image,
            $this->generateUrl('cscv_app_image_update'),
            'PUT'
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            // 刷新Token
            $imageService->save($image);
            $jsonData = "refresh token";
            $msg = JsonMsgUtils::SUCCESS_MSG;
            $statusCode = Codes::HTTP_OK;
        } else {
            $jsonData = JsonMsgUtils::FORM_INVALID_CB;
            $msg = JsonMsgUtils::ERROR_MSG;
            $statusCode = Codes::HTTP_BAD_REQUEST;
        }

        return $this->createJsonResponse($jsonData, $statusCode, $msg);

    }

    /**
     * 产生表单
     * @param $image 表单中图像对象
     * @param $action 表单action
     * @param $method 表单method
     * @return \Symfony\Component\Form\Form
     */
    private function generateForm($image, $action, $method)
    {
        $disService = $this->get("disease_service");
        $form = $this->createForm(
            new ImageType(),
            $image,
            array(
                'action' => $action,
                'method' => $method
            )
        );
        $form->add(
            Image::DISEASE_KEY,
            'document',
            array(
                'class' => 'CSCVStorageBundle:Disease',
                'property' => 'name',
                'choices' => $disService->findAllBase(),
                'multiple' => false,
            )
        );

        return $form;
    }

    public function fileAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $imagesService = $this->get('image_service');
        //$images = $imagesService->findAll();
        $image = $imagesService->find('5577f0c1e7ec7bb7020041d3');
        echo $image->getLocation();
        exit;

    }


}