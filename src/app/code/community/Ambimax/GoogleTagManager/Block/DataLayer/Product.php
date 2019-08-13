<?php

class Ambimax_GoogleTagManager_Block_DataLayer_Product extends Ambimax_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * @var array
     */
    protected $_dataLayerAttributes = [
        'productId'      => 'entity_id',
        'productSku'     => 'sku',
        'productName'    => 'name',
        'productType'    => 'type_id',
        'productInStock' => 'is_in_stock',
        'productPrice'   => 'price',
    ];

    /**
     * @return Mage_Catalog_Model_Product|mixed|object
     */
    public function getDataObject()
    {
        return Mage::registry('current_product');
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isValidDataObject()
    {
        $product = $this->getDataObject();
        if (!$product instanceof Mage_Catalog_Model_Product || !$product->getId()) {
            return false;
        }

        // check whether it has special price right now and add it to the dataLayer
        if ($specialPrice = $product->getSpecialPrice()) {
            $fromDate = new DateTime($product->getSpecialFromDate());
            $toDate = new DateTime($product->getSpecialToDate());
            $nowDate = new DateTime(date('Y-m-d'));

            if ($fromDate <= $nowDate && $nowDate <= $toDate) {
                $this->_dataLayerAttributes['productSpecialPrice'] = 'special_price';
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return Mage::getStoreConfigFlag('google/ambimax_gtm_datalayer/add_datalayer_product_page');
    }
}