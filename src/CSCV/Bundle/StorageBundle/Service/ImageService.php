<?php
namespace CSCV\Bundle\StorageBundle\Service;

use CSCV\Bundle\StorageBundle\Document\Image;

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
     * 根据Id返回某疾病下所有图像
     * @param $id 疾病id
     */
    public function getImgCountByDisease($disease)
    {
        return count(
            $this->repo->findByDisease($disease)
        );
    }
}