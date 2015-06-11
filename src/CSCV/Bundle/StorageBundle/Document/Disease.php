<?php
/**
 * Created by CSCV.
 * Desc: 疾病文档
 * User: Woo
 * Date: 15/5/12
 * Time: 下午9:43
 */

namespace CSCV\Bundle\StorageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Disease extends BaseDocument
{

    const DOC_NAME = "Disease";
    const NAME_KEY = "name";
    const DESC_KEY = "desc";
    const ETIOLOGY_KEY = "etiology";
    const SYMPTOM_KEY = "symptom";
    const IDENTIFY_KEY = "identify";
    const PREVENT_KEY = "prevent";
    const COMPLICATION_KEY = "complication";
    const THERAPIES_KEY = "therapies";

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @Assert\Length(
     * max=10,
     * maxMessage="疾病名称不能超过10个字符")
     */
    private $name; // 疾病名称

    /**
     * @MongoDB\String
     */
    private $desc; // 疾病简介

    /**
     * @MongoDB\String
     */
    private $etiology; // 病因

    /**
     * @MongoDB\String
     */
    private $symptom; // 典型症状

    /**
     * @MongoDB\String
     */
    private $prevent; // 预防

    /**
     * @MongoDB\String
     */
    private $identify; // 鉴别

    /**
     * @MongoDB\String
     */
    private $complication; // 并发症

    /**
     * @MongoDB\String
     */
    private $therapies; // 治疗方法


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
     * Set etiology
     *
     * @param string $etiology
     * @return self
     */
    public function setEtiology($etiology)
    {
        $this->etiology = $etiology;

        return $this;
    }

    /**
     * Get etiology
     *
     * @return string $etiology
     */
    public function getEtiology()
    {
        return $this->etiology;
    }

    /**
     * Set identify
     *
     * @param string $identify
     * @return self
     */
    public function setIdentify($identify)
    {
        $this->identify = $identify;

        return $this;
    }

    /**
     * Get identify
     *
     * @return string $identify
     */
    public function getIdentify()
    {
        return $this->identify;
    }


    public function __toString()
    {
        return strval($this->getId());
    }

    /**
     * Set desc
     *
     * @param string $desc
     * @return self
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;

        return $this;
    }

    /**
     * Get desc
     *
     * @return string $desc
     */
    public function getDesc()
    {
        return $this->desc;
    }


    /**
     * Set symptom
     *
     * @param string $symptom
     * @return self
     */
    public function setSymptom($symptom)
    {
        $this->symptom = $symptom;
        return $this;
    }

    /**
     * Get symptom
     *
     * @return string $symptom
     */
    public function getSymptom()
    {
        return $this->symptom;
    }

    /**
     * Set prevent
     *
     * @param string $prevent
     * @return self
     */
    public function setPrevent($prevent)
    {
        $this->prevent = $prevent;

        return $this;
    }

    /**
     * Get prevent
     *
     * @return string $prevent
     */
    public function getPrevent()
    {
        return $this->prevent;
    }

    /**
     * Set complication
     *
     * @param string $complication
     * @return self
     */
    public function setComplication($complication)
    {
        $this->complication = $complication;

        return $this;
    }

    /**
     * Get complication
     *
     * @return string $complication
     */
    public function getComplication()
    {
        return $this->complication;
    }

    /**
     * Set therapies
     *
     * @param string $therapies
     * @return self
     */
    public function setTherapies($therapies)
    {
        $this->therapies = $therapies;
        return $this;
    }

    /**
     * Get therapies
     *
     * @return string $therapies
     */
    public function getTherapies()
    {
        return $this->therapies;
    }
}
