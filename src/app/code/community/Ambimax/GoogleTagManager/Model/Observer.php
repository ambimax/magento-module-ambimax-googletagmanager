<?php

class Ambimax_GoogleTagManager_Model_Observer
{
    protected $_googleTagManagerHtml;

    /**
     * @param Varien_Event_Observer $observer
     */
    public function addGoogleTagManagerAfterHeadOpeningTag(Varien_Event_Observer $observer)
    {
        if ( $observer->getBlock() instanceof Mage_Page_Block_Html_Head ) {
            $html = $observer->getTransport()->getHtml();
            $observer->getTransport()->setHtml($this->_getGoogleTagManagerHtml() . $html);
        }
    }

    /**
     * @return string
     */
    protected function _getGoogleTagManagerHtml() // @codingStandardsIgnoreLine
    {
        if ( is_null($this->_googleTagManagerHtml) ) {
            $this->_googleTagManagerHtml = Mage::app()->getLayout()->createBlock(
                'ambimax_googletagmanager/dataLayer',
                'ambimax_googletagmanager.script_head',
                [
                    'template' => 'ambimax/googletagmanager/script.phtml',
                ]
            )->toHtml();
        }

        return $this->_googleTagManagerHtml;
    }
}