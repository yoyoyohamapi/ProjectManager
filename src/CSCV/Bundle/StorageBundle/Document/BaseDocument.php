<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/9
 * Time: 下午9:47
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @MongoDB\MappedSuperclass
 */
class BaseDocument
{

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\Date
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @MongoDB\Date
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

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
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param date $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
