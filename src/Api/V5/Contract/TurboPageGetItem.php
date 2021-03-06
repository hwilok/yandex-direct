<?php

namespace Biplane\YandexDirect\Api\V5\Contract;

/**
 * Auto-generated code.
 */
class TurboPageGetItem
{

//    Can be omit.
//    protected $Id = null;

//    Can be omit.
//    protected $Name = null;

//    Can be omit.
//    protected $Href = null;

//    Can be omit.
//    protected $PreviewHref = null;

    /**
     * Creates a new instance of TurboPageGetItem.
     *
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Gets Id.
     *
     * @return int|null
     */
    public function getId()
    {
        return isset($this->Id) ? $this->Id : null;
    }

    /**
     * Sets Id.
     *
     * @param int|null $value
     * @return $this
     */
    public function setId($value = null)
    {
        $this->Id = $value;

        return $this;
    }

    /**
     * Gets Name.
     *
     * @return string|null
     */
    public function getName()
    {
        return isset($this->Name) ? $this->Name : null;
    }

    /**
     * Sets Name.
     *
     * @param string|null $value
     * @return $this
     */
    public function setName($value = null)
    {
        $this->Name = $value;

        return $this;
    }

    /**
     * Gets Href.
     *
     * @return string|null
     */
    public function getHref()
    {
        return isset($this->Href) ? $this->Href : null;
    }

    /**
     * Sets Href.
     *
     * @param string|null $value
     * @return $this
     */
    public function setHref($value = null)
    {
        $this->Href = $value;

        return $this;
    }

    /**
     * Gets PreviewHref.
     *
     * @return string|null
     */
    public function getPreviewHref()
    {
        return isset($this->PreviewHref) ? $this->PreviewHref : null;
    }

    /**
     * Sets PreviewHref.
     *
     * @param string|null $value
     * @return $this
     */
    public function setPreviewHref($value = null)
    {
        $this->PreviewHref = $value;

        return $this;
    }


}

