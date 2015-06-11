<?php

namespace CSCV\Bundle\AppBundle\Controller;


use CSCV\Bundle\StorageBundle\Document\Author;
use CSCV\Bundle\StorageBundle\Document\Book;
use CSCV\Bundle\StorageBundle\Document\Image;
use CSCV\Bundle\StorageBundle\Document\ImageFile;
use CSCV\Bundle\StorageBundle\Document\State;
use CSCV\Bundle\StorageBundle\Form\Type\ImageType;
use CSCV\Bundle\StorageBundle\Service\ImageService;
use Gedmo\Uploadable\FakeFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends BaseController
{

    /**
     * 图像标定主页
     */
    public function indexAction(Request $request)
    {
        $disService = $this->get('disease_service');
        $image = new Image();
        $form = $this->createForm(
            new ImageType(),
            $image
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
            return $this->createJsonResponse(
                $response,
                JsonResponse::HTTP_OK,
                ''
            );
        } else {
        }

        return $this->render(
            '@CSCVApp/Image/index.html.twig',
            array(
                'form' => $form->createView()
            )
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

    public function fileAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $imagesService = $this->get('image_service');
        //$images = $imagesService->findAll();
        $image = $imagesService->find('55727866e7ec7be14a0041a7');
        $files = $image->getImageFiles()->toArray();
        header('Content-type: image/png');
        echo $files[0]->getFile()->getBytes();

    }


}