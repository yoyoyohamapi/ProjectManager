<?php
/**
 * Created by CSCV.
 * Desc: 图像路径
 * User: Woo
 * Date: 15/5/31
 * Time: 下午8:52
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Expose;

/**
 * @MongoDB\Document
 */
class Paths
{

    const DOC_NAME = 'Paths';
    const SRC_KEY = 'src';
    const CROP_KEY = 'crop';
    const SEG_KEY = 'seg';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\File
     */
    private $src;

    /**
     * @MongoDB\File
     */
    private $crop;

    /**
     * @MongoDB\File
     */
    private $seg;

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
     * Set src
     *
     * @param file $src
     * @return self
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return file $src
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set crop
     *
     * @param file $crop
     * @return self
     */
    public function setCrop($crop)
    {
        $this->crop = $crop;

        return $this;
    }

    /**
     * Get crop
     *
     * @return file $crop
     */
    public function getCrop()
    {
        return $this->crop;
    }

    /**
     * Set seg
     *
     * @param file $seg
     * @return self
     */
    public function setSeg($seg)
    {
        $this->seg = $seg;

        return $this;
    }

    /**
     * Get seg
     *
     * @return file $seg
     */
    public function getSeg()
    {
        return $this->seg;
    }

    /**
     * 设置对应路径图像
     * @param $type 图像类型
     */
    public function setImgFile($file, $type)
    {

        switch ($type) {
            case Paths::SRC_KEY:
                $this->setSrc($file);
                break;
            case Paths::CROP_KEY:
                $this->setCrop($file);
                break;
            case Paths::SEG_KEY:
                $this->setSeg($file);
                break;
        }
    }
}
