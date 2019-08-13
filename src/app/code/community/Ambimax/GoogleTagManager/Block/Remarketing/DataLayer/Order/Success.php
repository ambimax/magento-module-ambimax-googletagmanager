<?php

class Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Order_Success extends Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Abstract
{
    /**
     * @var
     */
    protected $_cartItems;

    /**
     * @return Mage_Sales_Model_Order
     */
    public function getDataObject()
    {
        return Mage::getSingleton('checkout/session')->getLastRealOrder();
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

        $order = $this->getDataObject();

        $prodSkus = [];
        foreach ($order->getAllItems() as $item) {
            $prodSkus[] = $item->getSku();
        }

        return [
            'ecomm_prodid'     => $prodSkus,
            'ecomm_pagetype'   => 'purchase',
            'ecomm_totalvalue' => $order->getGrandTotal(),
        ];
    }

    /**
     * @return bool
     */
    public function isValidDataObject()
    {
        return $this->getDataObject() instanceof Mage_Sales_Model_Order && $this->getDataObject()->getIncrementId();
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return Mage::getStoreConfigFlag('google/ambimax_gtm_remarketing_datalayer/add_remarketing_datalayer_success_page');
    }
}