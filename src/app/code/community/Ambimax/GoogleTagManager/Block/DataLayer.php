<?php

class Ambimax_GoogleTagManager_Block_DataLayer extends Mage_Core_Block_Template
{
    /**
     * @var array
     */
    protected $_dataLayer;

    /**
     * @return mixed
     */
    public function getContainerId()
    {
        return Mage::getStoreConfig('google/ambimax_gtm/container_id');
    }

    /**
     * @return string
     */
    public function getNoScriptUrl()
    {
        $url = sprintf('https://www.googletagmanager.com/ns.html?id=%s', $this->getContainerId());

        if ( count($this->getDataLayer()) ) {
            $url .= '&' . http_build_query($this->getDataLayer());
        }

        return $url;
    }

    /**
     * @return array
     */
    public function getDataLayer()
    {
        if ( is_null($this->_dataLayer) ) {
            $this->_dataLayer = [];
            foreach ($this->getSortedChildBlocks() as $block) {
                if ( $block->isAllowed() && $data = $block->getDataLayer() ) {
                    $this->_dataLayer = array_merge($this->_dataLayer, $data);
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
        if ( !Mage::getStoreConfigFlag('google/ambimax_gtm/enabled') ) {
            return '';
        }

        if ( empty($this->getContainerId()) ) {
            return '';
        }

        return parent::_toHtml();
    }
}