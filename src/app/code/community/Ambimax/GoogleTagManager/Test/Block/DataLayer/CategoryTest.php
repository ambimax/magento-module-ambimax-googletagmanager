<?php

class Ambimax_GoogleTagManager_Test_Block_DataLayer_CategoryTest extends EcomDev_PHPUnit_Test_Case
{
    protected $_dataLayerBlock;

    public function setUp()
    {
        /** @var Mage_Core_Model_Layout $layout */
        $layout = Mage::app()->getLayout();

        /** @var Ambimax_GoogleTagManager_Block_DataLayer _dataLayerBlock */
        $this->_dataLayerBlock = $layout->createBlock('ambimax_googletagmanager/dataLayer');

        $categoryBlock = $layout->createBlock(
            'ambimax_googletagmanager/dataLayer_category',
            'ambimax_googletagmanager.data_layer.category',
            ['as' => 'ambimax_gtm_category']
        );
        $this->_dataLayerBlock->append($categoryBlock);

        $category = Mage::getModel('catalog/category')->load(2);
        Mage::register('current_category', $category);
    }

    /**
     * @loadFixture ~Ambimax_GoogleTagManager/default.yaml
     * @loadExpectation ~Ambimax_GoogleTagManager/default
     */
    public function testCategoryDataLayer()
    {
        $this->assertEquals(
            $this->expected('dataLayer')->getCategory(),
            $this->_dataLayerBlock->getDataLayer()
        );
    }

}