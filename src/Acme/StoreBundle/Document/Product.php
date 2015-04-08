<?php
namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * @MongoDB\Document
 * @JMS\ExclusionPolicy("all")
 */
class Product
{

    const CLASS_NAME = 'product';
    const NAME_KEY = 'name';
    const PRICE_KEY = 'price';

    /**
     * @MongoDB\Id
     * @Expose
     * @JMS\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Expose
     * @JMS\Type("string")
     */
    protected $name;

    /**
     * @MongoDB\String
     * @Expose
     * @JMS\Type("string")
     */
    protected $price;


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
     * Set price
     *
     * @param string $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string $price
     */
    public function getPrice()
    {
        return $this->price;
    }
}
