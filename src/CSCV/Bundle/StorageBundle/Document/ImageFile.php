<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/5
 * Time: 下午4:55
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class ImageFile extends BaseDocument
{
    const DOC_NAME = "ImageFile";
    const FILE_KEY = "file";
    const IMAGE_SRC_TYPE = 'src';
    const IMAGE_CROP_TYPE = 'crop';
    const IMAGE_SEG_TYPE = 'seg';

    /**
     * @MongoDB\String
     */
    private $type;

    /**
     * @MongoDB\File
     */
    private $file;

    /**
     * Set type
     *
     * @param string $type
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
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set file
     *
     * @param file $file
     * @return self
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return file $file
     */
    public function getFile()
    {
        return $this->file;
    }

}
