<?php

class Ambimax_GoogleTagManager_Model_Observer
{
    protected $_googleTagManagerHtml;
    protected $_googleRemarketingTagHtml;

    /**
     * @param Varien_Event_Observer $observer
     */
    public function addGoogleTagManagerAfterHeadOpeningTag(Varien_Event_Observer $observer)
    {
        if ($observer->getBlock() instanceof Mage_Page_Block_Html_Head) {
            $html = $observer->getTransport()->getHtml();

            $html = $this->_getGoogleRemarketingTagHtml() . $html;

            $observer->getTransport()->setHtml($this->_getGoogleTagManagerHtml() . $html);
        }
    }

    /**
     * @return string
     */
    protected function _getGoogleTagManagerHtml() // @codingStandardsIgnoreLine
    {
        if (is_null($this->_googleTagManagerHtml)) {
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

    protected function _getGoogleRemarketingTagHtml()
    {
        if (is_null($this->_googleRemarketingTagHtml)) {
            $this->_googleRemarketingTagHtml = Mage::app()->getLayout()->createBlock(
                'ambimax_googletagmanager/remarketing_dataLayer',
                'ambimax_googletagmanager.remarketing_script_head',
                [
                    'template' => 'ambimax/googletagmanager/remarketing/script.phtml',
                ]
            )->toHtml();
        }

        return $this->_googleRemarketingTagHtml;
    }
}