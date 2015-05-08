<?php

namespace CSCV\Bundle\AppBundle\Controller;


use CSCV\Bundle\StorageBundle\Document\Image;
use CSCV\Bundle\StorageBundle\Form\Type\ImageType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends BaseController
{
    const IMAGE_DIR = 'storage//images';

    /**
     * 图像标定主页
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $image = new Image();
        $form = $this->createForm(new ImageType(), $image);
        $form->add(
            IMAGE::NAME_KEY,
            'hidden'
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            // 设置创建时间及更新时间
            $datetime = new \MongoDate();
            $image->setCreatedAt($datetime);
            $image->setUpdatedAt($datetime);
            // 转移文件 ---> /疾病/日期(精确到)/唯一码
            $finder = new Finder();
            $finder->name($image->getName());
            $finder->files()->in(ImageController::IMAGE_DIR.'//tmp');
            $date = date("Y-m");
            $dir = 'storage//images//'.$image->getType().'//'.$date;
            foreach ($finder as $file) {
                $tmp = new File($file->getRealPath());
                $dst = $tmp->move($dir, $image->getName());
                $image->setName($dst->getRealPath());
            }
            $dm->persist($image);
            $dm->flush();
            $response = array(
                'success' => true
            );

            return $this->createJsonResponse(
                $response,
                JsonResponse::HTTP_OK,
                ''
            );
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
        $files = $request->files->get('files');
        $imageName = md5(uniqid(rand())).".jpg";
        $uploadedFile = $files[0];
        // 先暂存到临时文件夹下
        $tmpFile = $uploadedFile->move(ImageController::IMAGE_DIR.'//tmp', $imageName);
        $data = array(
            'tmp_path' => $imageName
        );

        return $this->createJsonResponse(
            $data,
            JsonResponse::HTTP_OK,
            ''
        );
    }

    public function postAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $image = new Image();
        $form = $this->createForm(new ImageType(), $image);
        $form->add(
            IMAGE::NAME_KEY,
            'hidden'
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($image);
            $dm->flush();
            $response = array(
                'success' => true
            );

            return $this->createJsonResponse(
                $response,
                JsonResponse::HTTP_OK,
                ''
            );
        }

        return $this->render(
            '@CSCVApp/Image/post.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function findAction($imageName)
    {
        $finder = new Finder();
        $finder->name($imageName);
        $finder->files()->in(ImageController::IMAGE_DIR.'//tmp');
        echo $finder->count();
        foreach ($finder as $file) {
            $tmp = new File($file->getRealPath());
            $tmp->move(ImageController::IMAGE_DIR.'//11', $imageName);
        }
    }


}