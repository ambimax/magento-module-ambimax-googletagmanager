<?php

class Ambimax_GoogleTagManager_Test_Block_DataLayer_ProductTest extends EcomDev_PHPUnit_Test_Case
{
    protected $_dataLayerBlock;

    public function setUp()
    {
        /** @var Mage_Core_Model_Layout $layout */
        $layout = Mage::app()->getLayout();

        /** @var Ambimax_GoogleTagManager_Block_DataLayer _dataLayerBlock */
        $this->_dataLayerBlock = $layout->createBlock('ambimax_googletagmanager/dataLayer');

        $productBlock = $layout->createBlock(
            'ambimax_googletagmanager/dataLayer_product',
            'ambimax_googletagmanager.data_layer.product',
            ['as' => 'ambimax_gtm_product']
        );
        $this->_dataLayerBlock->append($productBlock);

        $product = Mage::getModel('catalog/product')->load(1);
        Mage::register('current_product', $product);
    }

    /**
     * @loadFixture ~Ambimax_GoogleTagManager/default.yaml
     * @loadExpectation ~Ambimax_GoogleTagManager/default
     */
    public function testProductDataLayer()
    {
        $this->assertEquals(
            $this->expected('dataLayer')->getProduct(),
            $this->_dataLayerBlock->getDataLayer()
        );
    }

}