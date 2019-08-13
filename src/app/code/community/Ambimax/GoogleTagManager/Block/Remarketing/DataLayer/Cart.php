<?php

class Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Cart extends Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Abstract
{
    /**
     * @return array
     */
    public function getDataObject()
    {
        return Mage::getSingleton("checkout/session")->getQuote()->getAllItems();
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

        $allItems = $this->getDataObject();

        $prodSkus = [];
        $prodPrices = [];
        foreach ($allItems as $item) {
            $prodSkus[] = $item->getSku();
            $prodPrices[] = $item->getPrice();
        }
        return [
            'ecomm_prodid'     => $prodSkus,
            'ecomm_pagetype'   => 'cart',
            'ecomm_totalvalue' => $prodPrices,
        ];
    }

    /**
     * @return bool
     */
    public function isValidDataObject()
    {
        return is_array($this->getDataObject()) && !empty($this->getDataObject());
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return Mage::getStoreConfigFlag('google/ambimax_gtm_remarketing_datalayer/add_remarketing_datalayer_cart_page');
    }
}