<?php

abstract class Ambimax_GoogleTagManager_Block_DataLayer_Abstract extends Mage_Core_Block_Template
{
    protected $_dataLayer;

    protected $_dataLayerAttributes = [];
    protected $_staticData = [];

    /**
     * @return array|mixed
     */
    public function getDataLayer()
    {
        if ( $this->_dataLayer ) {
            return $this->_dataLayer;
        }

        $this->_dataLayer = [];

        if ( !$this->isAllowed() ) {
            return $this->_dataLayer;
        }

        if ( $this->isValidDataObject() ) {
            foreach ($this->_dataLayerAttributes as $code => $attributeCode) {

                // handle callbacks
                if ( isset($attributeCode['callback']) ) {
                    $this->_dataLayer[$code] = call_user_func(array($this, $attributeCode['callback'])); // @codingStandardsIgnoreLine
                    continue;
                }

                $this->_dataLayer[$code] = $this->getDataObject()->getData($attributeCode);
            }
        }

        if ( !empty($this->_staticData) ) {
            $this->_dataLayer = array_merge($this->_dataLayer, $this->_staticData);
        }

        return $this->_dataLayer;
    }

    /**
     * @return object
     */
    abstract public function getDataObject();

    /**
     * @return bool
     */
    public function isValidDataObject()
    {
        return is_object($this->getDataObject());
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return true;
    }
}