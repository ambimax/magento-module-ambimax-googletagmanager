<?php

class Ambimax_GoogleTagManager_Block_DataLayer_Product extends Ambimax_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * @var array
     */
    protected $_dataLayerAttributes = [
        'productId' => 'entity_id',
        'productSku' => 'sku',
        'productName' => 'name',
        'productType' => 'type_id',
        'productInStock' => 'is_in_stock',
        'productPrice' => 'price',
        'productSpecialPrice' => 'special_price',
    ];

    /**
     * @return Mage_Catalog_Model_Category|mixed
     */
    public function getDataObject()
    {
        return Mage::registry('current_product');
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
        return Mage::getStoreConfigFlag('google/ambimax_gtm_datalayer/add_datalayer_product_page');
    }
}