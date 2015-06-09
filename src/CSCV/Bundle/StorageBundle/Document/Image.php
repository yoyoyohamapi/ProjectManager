<?php
/**
 * Created by CSCV.
 * Desc: 图像文档
 * User: Woo
 * Date: 15/4/20
 * Time: 下午9:15
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Image
{

    const DOC_NAME = 'Image';
    const NAME_KEY = 'name';
    const DISEASE_KEY = 'disease';
    const CROPPED_KEY = 'cropped';
    const LOCATION_KEY = 'location';
    const FEATURE_TEXTURE_KEY = 'feature_texture';
    const FEATURE_COLOR_KEY = 'feature_color';
    const STATE_KEY = 'state';
    const IMAGE_FILES_KEY = 'imageFiles';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Disease",simple=true)
     */
    private $disease; // 分类标记

    /**
     * @MongoDB\Boolean
     */
    private $cropped; // 是否剪切

    /**
     * @MongoDB\Int
     * @Assert\NotBlank()
     */
    private $location; // 发病部位

    /**
     * @MongoDB\Hash
     */
    private $feature_texture; // 纹理特征

    /**
     * @MongoDB\Hash
     *
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
     * @MongoDB\Int
     */
    private $state = State::UNSETTED; // 状态码

    /**
     * @MongoDB\ReferenceMany(targetDocument="ImageFile",cascade="all")
     */
    private $imageFiles = array();


    public function __construct()
    {
        $this->imageFiles = new ArrayCollection();
    }

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


    /**
     * Set disease
     *
     * @param CSCV\Bundle\StorageBundle\Document\Disease $disease
     * @return self
     */
    public function setDisease(\CSCV\Bundle\StorageBundle\Document\Disease $disease)
    {
        $this->disease = $disease;

        return $this;
    }

    /**
     * Get disease
     *
     * @return CSCV\Bundle\StorageBundle\Document\Disease $disease
     */
    public function getDisease()
    {
        return $this->disease;
    }

    /**
     * Set state
     *
     * @param int $state
     * @return self
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int $state
     */
    public function getState()
    {
        return $this->state;
    }


    /**
     * Add imageFile
     *
     * @param CSCV\Bundle\StorageBundle\Document\ImageFile $imageFile
     */
    public function addImageFile(\CSCV\Bundle\StorageBundle\Document\ImageFile $imageFile)
    {
        $this->imageFiles[] = $imageFile;
    }

    /**
     * Remove imageFile
     *
     * @param CSCV\Bundle\StorageBundle\Document\ImageFile $imageFile
     */
    public function removeImageFile(\CSCV\Bundle\StorageBundle\Document\ImageFile $imageFile)
    {
        $this->imageFiles->removeElement($imageFile);
    }

    /**
     * Get imageFiles
     *
     * @return \Doctrine\Common\Collections\Collection $imageFiles
     */
    public function getImageFiles()
    {
        return $this->imageFiles;
    }

}
