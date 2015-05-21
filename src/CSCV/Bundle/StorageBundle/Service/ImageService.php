<?php
namespace CSCV\Bundle\StorageBundle\Service;

use CSCV\Bundle\StorageBundle\Document\Image;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by CSCV.
 * Desc: 阿萨德
 * User: Woo
 * Date: 15/5/12
 * Time: 下午10:08
 */
class ImageService extends BaseService
{
    const DOC_NAME = 'CSCVStorageBundle:Image';
    const IMAGE_DIR = 'storage//images';

    private $repo;
    private $builder; // QueryBuilder


    public function init()
    {
        $this->repo = $this->mongo
            ->getRepository(ImageService::DOC_NAME);
        $this->builder = $this->mongo->getManager()
            ->createQueryBuilder(DiseaseService::DOC_NAME);
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    /**
     * 根据Id返回某疾病下所有图像
     * @param $id 疾病id
     */
    public function getImgCountByDisease($disease)
    {
        return count(
            $this->repo->findByDisease($disease)
        );
    }

    /**
     * 上传文件方法
     * @param Request $request
     * @return 临时文件路径
     */
    public function uploadAction(Request $request)
    {
        $files = $request->files->get('files');
        $imageName = md5(uniqid(rand())).".jpg";
        $uploadedFile = $files[0];
        // 先暂存到临时文件夹下
        $tmpFile = $uploadedFile->move(ImageService::IMAGE_DIR.'//tmp', $imageName);
        $data = array(
            'tmp_path' => $imageName
        );

        return $data;

    }

    public function saveImg($image, $fileName)
    {
        // 设置创建时间及更新时间
        $datetime = new \MongoDate();
        $image->setCreatedAt($datetime);
        $image->setUpdatedAt($datetime);
        // 转移文件 ---> /疾病/日期(精确到)/唯一码
        $finder = new Finder();
        $finder->name($fileName);
        $finder->files()->in(ImageService::IMAGE_DIR.'//tmp');
        $date = date("Y-m");
        $dir = ImageService::IMAGE_DIR.$image->getDisease().'//'.$date;
        foreach ($finder as $file) {
            $tmp = new File($file->getRealPath());
            $file = $tmp->move($dir, $fileName);
            $image->setFile($file->getRealPath());
        }
        parent::save($image);
    }


    /**
     * 以rest方式进行的图像标定
     * @param $content
     */
    public function restUpload($content)
    {

    }


}