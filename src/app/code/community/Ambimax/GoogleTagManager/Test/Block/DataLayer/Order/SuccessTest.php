<?php

class Ambimax_GoogleTagManager_Test_Block_DataLayer_Order_SuccessTest extends EcomDev_PHPUnit_Test_Case
{
    protected $_dataLayerBlock;
    protected $_checkoutSessionMock;

    public function setUp()
    {
        /** @var Mage_Core_Model_Layout $layout */
        $layout = Mage::app()->getLayout();

        /** @var Ambimax_GoogleTagManager_Block_DataLayer _dataLayerBlock */
        $this->_dataLayerBlock = $layout->createBlock('ambimax_googletagmanager/dataLayer');

        $orderSuccessBlock = $layout->createBlock(
            'ambimax_googletagmanager/dataLayer_order_success',
            'ambimax_googletagmanager.data_layer.order_success',
            ['as' => 'ambimax_gtm_order_success']
        );
        $this->_dataLayerBlock->append($orderSuccessBlock);

        $order = Mage::getModel('sales/order')->load(1);

        $this->_checkoutSessionMock = $this->getMockBuilder('Mage_Checkout_Model_Session')
            ->setMethods(['getLastRealOrder'])
            ->getMock();

        $this->_checkoutSessionMock
            ->expects($this->any())
            ->method('getLastRealOrder')
            ->willReturn($order);

        // Global category will be used as returning category for cart items
        $category = Mage::getModel('catalog/category')->load(2);
        Mage::register('current_category', $category);

        $this->replaceByMock('model', 'checkout/session', $this->_checkoutSessionMock);
    }

    /**
     * @loadFixture ~Ambimax_GoogleTagManager/default.yaml
     * @loadExpectation ~Ambimax_GoogleTagManager/default
     */
    public function testOrderSuccessDataLayer()
    {
        $this->assertEquals(
            $this->expected('dataLayer')->getOrderSuccess(),
            $this->_dataLayerBlock->getDataLayer()
        );
    }

}