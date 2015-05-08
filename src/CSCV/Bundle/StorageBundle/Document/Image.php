<?php
/**
 * Created by CSCV.
 * Desc: 图像文档
 * User: Woo
 * Date: 15/4/20
 * Time: 下午9:15
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document
 */
class Image
{

    const DOC_NAME = 'image';
    const NAME_KEY = 'name';
    const TYPE_KEY = 'type';
    const CROPPED_KEY = 'cropped';
    const LOCATION_KEY = 'location';
    const FEATRUE_TEXTURE_KEY = 'feature_texture';
    const FEATURE_COLOR_KEY = 'feature_color';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\String
     */
    private $name; // 文件名

    /**
     * @MongoDB\Int
     */
    private $type; // 分类标记

    /**
     * @MongoDB\Boolean
     */
    private $cropped; // 是否剪切

    /**
     * @MongoDB\Int
     */
    private $location; // 发病部位

    /**
     * @MongoDB\Hash
     */
    private $feature_texture; // 纹理特征

    /**
     * @MongoDB\Hash
     */
    private $feature_color; // 颜色特征

    /**
     * @MongoDB\Date
     */
    private $created_at; // 创建时间

    /**
     * @MongoDB\Date
     */
    private $updated_at; // 更新时间


    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param int $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set cropped
     *
     * @param boolean $cropped
     * @return self
     */
    public function setCropped($cropped)
    {
        $this->cropped = $cropped;

        return $this;
    }

    /**
     * Get cropped
     *
     * @return boolean $cropped
     */
    public function getCropped()
    {
        return $this->cropped;
    }

    /**
     * Set location
     *
     * @param int $location
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return int $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set featureTexture
     *
     * @param hash $featureTexture
     * @return self
     */
    public function setFeatureTexture($featureTexture)
    {
        $this->feature_texture = $featureTexture;

        return $this;
    }

    /**
     * Get featureTexture
     *
     * @return hash $featureTexture
     */
    public function getFeatureTexture()
    {
        return $this->feature_texture;
    }

    /**
     * Set featureColor
     *
     * @param hash $featureColor
     * @return self
     */
    public function setFeatureColor($featureColor)
    {
        $this->feature_color = $featureColor;

        return $this;
    }

    /**
     * Get featureColor
     *
     * @return hash $featureColor
     */
    public function getFeatureColor()
    {
        return $this->feature_color;
    }
}