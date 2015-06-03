<?php
namespace CSCV\Bundle\StorageBundle\Service;

use CSCV\Bundle\StorageBundle\Document\Image;
use CSCV\Bundle\StorageBundle\Document\Paths;
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

    /**
     * 获得所有疾病
     * @return mixed
     */
    public function findAll()
    {
        return $this->repo->findAll();
    }

    /**
     * 根据疾病Id获得图像
     * @param $disease
     */
    public function findByDisease($disease)
    {
        return $this->repo->findByDisease($disease);
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

    /**
     * @param $image 待保存图像对象
     * @param $fileInfo 文件信息
     *        $fileInfo['name']: 图像
     *        $fileInfo['type']: 图像类型（原图，裁剪后图，分割后图）
     */
    public function saveImg($image, $fileInfo)
    {
        // 设置创建时间及更新时间
        $datetime = new \MongoDate();
        $image->setCreatedAt($datetime);
        $image->setUpdatedAt($datetime);
        // 转移文件 ---> /疾病/日期(精确到)/唯一码
        if (!empty($fileInfo)) {
            $finder = new Finder();
            $finder->name($fileInfo['name']);
            $finder->files()->in(ImageService::IMAGE_DIR.'//tmp');
            $date = date("Y-m");
            /* 文件保存路径:
                若设置了疾病类型：基础路径/疾病ID/图像类型/日期
                若未设置疾病类型：基础路径/unset/图像类型/日期
            */
            $disDir = empty($image->getDisease()) ?
                'unset' : $image->getDisease();
            $dir = ImageService::IMAGE_DIR.'//'.$disDir.'//'.$fileInfo['type'].'//'.$date;
            foreach ($finder as $file) {
                $tmp = new File($file->getRealPath());
                $file = $tmp->move($dir, $fileInfo['name']);
                $paths = new Paths();
                echo $paths->getId();
                $paths->setImgFile($file->getRealPath(), $fileInfo['type']);
                $image->setPaths($paths);
            }
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