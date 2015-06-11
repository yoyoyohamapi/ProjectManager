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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Image extends BaseDocument
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
     * @MongoDB\ReferenceOne(targetDocument="Disease",simple=true)
     */
    private $disease; // 分类标记

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
     *
     */
    private $feature_color; // 颜色特征

    /**
     * @MongoDB\Int
     */
    private $state = State::UNSETTED; // 状态码

    /**
     * @MongoDB\ReferenceMany(targetDocument="ImageFile",cascade="all",strategy="set")
     */
    private $imageFiles = array();


    public function __construct()
    {
        $this->imageFiles = new ArrayCollection();
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

    public function refreshOrAddFile(File $file, $type)
    {
        $imageFiles = $this->getImageFiles();
        $dstFile = null;
        // 遍历查看类型为type的文件是否存在
        // 若存在，则刷新，否则新建
        foreach ($imageFiles as $imageFile) {
            if ($imageFile->getType() == $type) {
                $dstFile = $imageFile;
                break;
            }
        }
        if (!$dstFile) {
            $dstFile = new ImageFile();
            $dstFile->setFile($file->getPathname());
            $dstFile->setType($type);
            $this->addImageFile($dstFile);
        } else {
            $dstFile->setFile($file->getPathname());
        }
    }

}
