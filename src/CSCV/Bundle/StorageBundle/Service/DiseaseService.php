<?php
namespace CSCV\Bundle\StorageBundle\Service;

use CSCV\Bundle\StorageBundle\Document\Disease;

/**
 * Created by CSCV.
 * Desc: 疾病文档服务
 * User: Woo
 * Date: 15/5/12
 * Time: 下午10:09
 */
class DiseaseService extends BaseService
{

    const DOC_NAME = 'CSCVStorageBundle:Disease';
    private $repo;
    private $builder; // QueryBuilder

    public function init()
    {
        $this->repo = $this->mongo
            ->getRepository(DiseaseService::DOC_NAME);
        $this->builder = $this->mongo->getManager()
            ->createQueryBuilder(DiseaseService::DOC_NAME);
    }

    /**
     * 查找所有疾病
     * @return 所有疾病
     */
    public function findAll()
    {
        return $this->repo->findAll();
    }

    /**
     * 查找所有疾病
     * 仅返回index，name
     * @return 所有疾病（仅包含基本信息）
     */
    public function findAllBase()
    {
        $diseases = $this->builder
            ->select('_id', Disease::NAME_KEY)
            ->getQuery()
            ->execute();

        return $diseases;
    }

    /**
     * 根据Id的返回疾病
     * @param $id Id
     */
    public function findById($id)
    {
        return $this->repo->find($id);
    }


}