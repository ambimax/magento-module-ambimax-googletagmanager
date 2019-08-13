<?php

class Ambimax_GoogleTagManager_Block_Remarketing_DataLayer extends Mage_Core_Block_Template
{
    /**
     * @var array
     */
    protected $_dataLayer;

    /**
     * @return array
     */
    public function getDataLayer()
    {
        if (is_null($this->_dataLayer)) {
            $this->_dataLayer = [];

            /** @var Ambimax_GoogleTagManager_Block_Remarketing_DataLayer_Abstract $block */
            foreach ($this->getSortedChildBlocks() as $block) {
                Mage::log('blah', LOG_INFO, 'google_api.log');
                if ($block->isAllowed() && $data = $block->getGoogleTagParams()) {
                    $this->_dataLayer = [
                        'event'             => 'fireRemarketingTag',
                        'google_tag_params' => $data,
                    ];
                }
            }
        }

        return $this->_dataLayer;
    }

    /**
     * @return string
     */
    public function getDataLayerJson()
    {
        return json_encode($this->getDataLayer());
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::getStoreConfigFlag('google/ambimax_gtm/remarketing_enabled')) {
            return '';
        }

        return parent::_toHtml();
    }
}