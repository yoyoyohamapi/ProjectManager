<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/3
 * Time: 下午9:17
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @MongoDB\Document
 */
class ApiToken
{

    const DOC_NAME = "ApiToken";
    const APP_NAME_KEY = "appName";
    const TOKEN_KEY = "token";
    const LIMIT_KEY = "limit";

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    private $appName; //应用名

    /**
     * @MongoDB\String
     */
    private $token; //api口令

    /**
     * @MongoDB\Date
     * @Assert\NotBlank()
     */
    private $limit; // 限制时间

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set appName
     *
     * @param string $appName
     * @return self
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;

        return $this;
    }

    /**
     * Get appName
     *
     * @return string $appName
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set limit
     *
     * @param date $limit
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get limit
     *
     * @return date $limit
     */
    public function getLimit()
    {
        return $this->limit;
    }
}
