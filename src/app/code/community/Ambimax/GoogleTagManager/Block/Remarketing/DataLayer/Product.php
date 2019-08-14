<?php

class Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Product extends Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Abstract
{

    /**
     * @return Mage_Catalog_Model_Category|mixed
     */
    public function getDataObject()
    {
        return Mage::registry('current_product');
    }

    public function getGoogleTagParams()
    {
        if ($this->_dataLayer) {
            return $this->_dataLayer;
        }

        $this->_dataLayer = [];

        if (!$this->isAllowed()) {
            return $this->_dataLayer;
        }

        if (!$this->isValidDataObject()) {
            return $this->_dataLayer;
        }

        $product = $this->getDataObject();

        return [
            'ecomm_prodid'     => $product->getSku(),
            'ecomm_pagetype'   => 'product',
            'ecomm_totalvalue' => $product->getFinalPrice(),
        ];
    }

    /**
     * @return bool
     */
    public function isValidDataObject()
    {
        return $this->getDataObject() instanceof Mage_Catalog_Model_Product && $this->getDataObject()->getId();
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return Mage::getStoreConfigFlag('google/ambimax_gtm_remarketing_datalayer/add_remarketing_datalayer_product_page');
    }
}