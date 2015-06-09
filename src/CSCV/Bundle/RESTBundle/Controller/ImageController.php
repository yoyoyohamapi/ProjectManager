<?php

namespace CSCV\Bundle\RESTBundle\Controller;

use CSCV\Bundle\StorageBundle\Document\Image;
use CSCV\Bundle\StorageBundle\Form\Type\ImageType;
use CSCV\Bundle\StorageBundle\Service\ImageService;
use FOS\RestBundle\Util\Codes;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class ImageController extends BaseController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="获得所有图片",
     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  }
     * )
     */
    public function getImagesAction()
    {
        $images = $this->get("image_service")->findAll();
        $view = View::create()
            ->setStatusCode(200)
            ->setData($images);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="根据图片id获得图片",
     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  },
     *  statusCodes={
     *      200="请求成功",
     *      204="无此图片"
     *  }
     * )
     */
    public function getImageAction($id)
    {
        $image = $this->get('doctrine_mongodb')
            ->getRepository('CSCVStorageBundle:Image')
            ->find($id);
        $view = View::create()
            ->setStatusCode(Codes::HTTP_OK)
            ->setData($image);
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="创建图像",
     *     input="image",
     *     output="CSCV\Bundle\StorageBundle\Document\Image",
     *     statusCodes={
     *        201 = "创建成功",
     *
     *     }
     * )
     * @return mixed
     */
    public function postImageAction(Request $request)
    {

        $imageService = $this->get('image_service');
        $image = new Image();
        $form = $this->createForm(
            new ImageType($this->get('disease_service')),
            $image
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            //$file_contents = $request->get('file_contents');
            $imageService->saveImg($image, null);
        } else {
        }
        $view = View::create()
            ->setStatusCode(Codes::HTTP_CREATED)
            ->setData($image);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="上传图像",
     *     output="CSCV\Bundle\StorageBundle\Document\Image"
     * )
     * @return mixed
     */
    public function uploadAction(Request $request)
    {
        $imageService = $this->get('image_service');
        $image = new Image();
        $tmp = new File($_FILES['file']['tmp_name']);
        $fileType = $request->get('fileType');
        $fileName = md5(uniqid(rand())).".jpg";
        //将图像暂存至unset
        $file = $tmp->move(ImageService::IMAGE_DIR."//tmp", $fileName);
        $fileInfo = array(
            'name' => $fileName,
            'type' => $fileType
        );
        $imageService->saveImg($image, $fileInfo);
        $view = View::create()
            ->setStatusCode(200)
            ->setData($image);

        return $this->get('fos_rest.view_handler')->handle($view);
    }


}