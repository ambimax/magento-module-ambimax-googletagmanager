<?php

class Ambimax_GoogleTagManager_Test_Block_DataLayerTest extends EcomDev_PHPUnit_Test_Case
{
    protected $_dataLayerBlock;

    public function setUp()
    {
        /** @var Ambimax_GoogleTagManager_Block_DataLayer _dataLayerBlock */
        $this->_dataLayerBlock = Mage::app()->getLayout()->createBlock('ambimax_googletagmanager/dataLayer');
    }

    /**
     * @loadFixture ~Ambimax_GoogleTagManager/default.yaml
     */
    public function testGetContainerId()
    {
        $this->assertEquals('GTM-TEST', $this->_dataLayerBlock->getContainerId());
    }

    /**
     * @loadFixture ~Ambimax_GoogleTagManager/default.yaml
     */
    public function testGetNoScriptUrl()
    {
        $this->assertEquals(
            'https://www.googletagmanager.com/ns.html?id=GTM-TEST',
            $this->_dataLayerBlock->getNoScriptUrl()
        );
    }

}