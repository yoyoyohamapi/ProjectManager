<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/3
 * Time: 下午9:31
 */

namespace CSCV\Bundle\StorageBundle\Service;


use CSCV\Bundle\StorageBundle\Document\ApiToken;

class ApiTokenService extends BaseService
{

    const DOC_NAME = 'CSCVStorageBundle:ApiToken';
    const INVALID_TOKEN = 1;
    const OUT_OF_DATE_TOKEN = 0;
    const VALID_TOKEN = 2;
    const DATE_FORMAT = 'y-m-d';

    private $repo;
    private $builder; // QueryBuilder


    public function init()
    {
        $this->repo = $this->mongo
            ->getRepository(ApiTokenService::DOC_NAME);
        $this->builder = $this->mongo->getManager()
            ->createQueryBuilder(ApiTokenService::DOC_NAME);
    }

    /**
     * 获得所有ApiToken
     */
    public function findAll()
    {
        return $this->repo->findAll();
    }

    /**
     * 根据应用名称获得ApiToken
     * @param $appName 待查询应用名称
     * @return 应用名称对应的ApiToken
     */
    public function findByAppName($appName)
    {
        return $this->repo->findByAppName($appName);
    }

    /**
     * 根据Id获得ApiToken
     * @param $id 待查询Id
     * @return mixed Id对应的ApiToken
     */
    public function findById($id)
    {
        return $this->repo->find($id);
    }

    /**
     * 创建ApiToken
     * @return token
     */
    public function generateToken()
    {
        $generator = $this->container->get('security.secure_random');
        $bytes = $generator->nextBytes(16);
        $tokenStr = md5(md5('b1f2t3j7'.$bytes.'1q2w3e4r5t6y'));

        return $tokenStr;
    }


    /**
     * 查询某Token字串是否有效
     * @param $tokenStr
     */
    public function isValid($tokenStr)
    {
        $tokens = $this->repo->findByToken($tokenStr);
        // 如果该Token不存在，则返回‘无效Token’
        if (empty($tokens)) {
            return ApiTokenService::INVALID_TOKEN;
        } // 否则判断Token是否过期
        else {
            $token = $tokens[0];
            $now = date(ApiTokenService::DATE_FORMAT);

            return strtotime($now) > strtotime(
                $token->getLimit()->format(ApiTokenService::DATE_FORMAT)
            ) ? ApiTokenService::OUT_OF_DATE_TOKEN : ApiTokenService::VALID_TOKEN;
        }
    }


}