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

/**
 * @MongoDB\Document
 */
class Disease
{

    const DOC_NAME = "Disease";
    const INDEX_KEY = "index";
    const NAME_KEY = "name";
    const ETIOLOGY_KEY = "etiology";
    const MANIFEST_KEY = "manifest";
    const IDENTIFY_KEY = "identify";
    const DIAGNOSE_KEY = "diagnose";
    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\Int
     */
    private $index; // 疾病自定义索引

    /**
     * @MongoDB\String
     */
    private $name; // 疾病名称

    /**
     * @MongoDB\String
     */
    private $etiology; // 病因

    /**
     * @MongoDB\String
     */
    private $manifest; // 临床表现

    /**
     * @MongoDB\String
     */
    private $diagnose; // 诊断

    /**
     * @MongoDB\String
     */
    private $identify; // 鉴别


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
     * Set index
     *
     * @param int $index
     * @return self
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get index
     *
     * @return int $index
     */
    public function getIndex()
    {
        return $this->index;
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
     * Set manifest
     *
     * @param string $manifest
     * @return self
     */
    public function setManifest($manifest)
    {
        $this->manifest = $manifest;

        return $this;
    }

    /**
     * Get manifest
     *
     * @return string $manifest
     */
    public function getManifest()
    {
        return $this->manifest;
    }

    /**
     * Set diagnose
     *
     * @param string $diagnose
     * @return self
     */
    public function setDiagnose($diagnose)
    {
        $this->diagnose = $diagnose;

        return $this;
    }

    /**
     * Get diagnose
     *
     * @return string $diagnose
     */
    public function getDiagnose()
    {
        return $this->diagnose;
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
        return strval($this->id);
    }
}
