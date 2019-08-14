<?php

class Ambimax_GoogleTagManager_Block_DataLayer_Category extends Ambimax_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * @var array
     */
    protected $_dataLayerAttributes = [
        'categoryId'            => 'entity_id',
        'categoryName'          => 'name',
        'categoryIsAnchor'      => 'is_anchor',
        'categoryProductsCount' => ['callback' => 'getCategoryProductsCount'],
        'categoryHasImage'      => 'image',
        'categoryCmsBlockId'    => 'landing_page',
        'categoryDisplayMode'   => 'display_mode',
    ];

    /**
     * @var array
     */
    protected $_staticData = [
        'pageCategory' => 'category'
    ];

    /**
     * @return Mage_Catalog_Model_Category|mixed
     */
    public function getDataObject()
    {
        return Mage::registry('current_category');
    }

    /**
     * @return bool
     */
    public function isValidDataObject()
    {
        return $this->getDataObject() instanceof Mage_Catalog_Model_Category && $this->getDataObject()->getId();
    }

    /**
     * @return int
     */
    public function getCategoryProductsCount()
    {
        if (!$this->isValidDataObject()) {
            return 0;
        }

        return $this->getDataObject()->getProductCount();
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return Mage::getStoreConfigFlag('google/ambimax_gtm_datalayer/add_datalayer_category_page');
    }
}