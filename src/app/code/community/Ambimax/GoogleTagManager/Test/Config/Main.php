<?php

class Ambimax_GoogleTagManager_Test_Config_Main extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testModuleActive()
    {
        $this->assertModuleIsActive();
    }

    public function testModuleVersion()
    {
        $this->assertModuleVersion('2.0.0');
    }

    public function testBlockAliases()
    {
        $this->assertBlockAlias(
            'ambimax_googletagmanager/dataLayer',
            'Ambimax_GoogleTagManager_Block_DataLayer'
        );
        $this->assertBlockAlias(
            'ambimax_googletagmanager/dataLayer_category',
            'Ambimax_GoogleTagManager_Block_DataLayer_Category'
        );
        $this->assertBlockAlias(
            'ambimax_googletagmanager/dataLayer_product',
            'Ambimax_GoogleTagManager_Block_DataLayer_Product'
        );
        $this->assertBlockAlias(
            'ambimax_googletagmanager/dataLayer_order_success',
            'Ambimax_GoogleTagManager_Block_DataLayer_Order_Success'
        );
    }

    public function testHelperAlias()
    {
        $this->assertHelperAlias(
            'ambimax_googletagmanager',
            'Ambimax_GoogleTagManager_Helper_Data'
        );
    }
}