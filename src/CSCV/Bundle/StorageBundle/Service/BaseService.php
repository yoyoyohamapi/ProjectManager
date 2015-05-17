<?php
namespace CSCV\Bundle\StorageBundle\Service;

/**
 * Created by CSCV.
 * Desc: 基Service
 * User: Woo
 * Date: 15/5/12
 * Time: 下午10:08
 */


class BaseService
{

    protected $container; // 服务容器
    protected $mongo; // mongodb服务

    public function __construct($mongo)
    {
        $this->mongo = $mongo;
        $this->init();
    }

    /**
     * 初始化方法，由子类实现
     */
    protected function init()
    {

    }

    public function save($document)
    {
        $dm = $this->mongo->getManager();
        $dm->persist($document);
        $dm->flush();
    }
}