<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/5/14
 * Time: 上午10:33
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document
 */
class Book
{

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\String
     */
    private $name;

    /**
     * @ReferenceOne(targetDocument="Author",simple=true)
     */
    private $author;


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
     * Set author
     *
     * @param CSCV\Bundle\StorageBundle\Document\Author $author
     * @return self
     */
    public function setAuthor(\CSCV\Bundle\StorageBundle\Document\Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return CSCV\Bundle\StorageBundle\Document\Author $author
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
