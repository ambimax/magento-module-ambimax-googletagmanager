<?php

class Ambimax_GoogleTagManager_Block_DataLayer_Order_Success extends Ambimax_GoogleTagManager_Block_DataLayer_Abstract
{
    /**
     * @var array
     */
    protected $_dataLayerAttributes = [
        'transactionId'          => 'increment_id',
        'transactionAffiliation' => 'store_id',
        'transactionTotal'       => 'grand_total',
        'transactionProducts'    => ['callback' => 'getCartItems'],
        'transactionShipping'    => 'shipping_amount',
        'transactionTax'         => 'tax_amount',
        'transactionCurrency'    => 'order_currency_code'
    ];

    /**
     * @var array
     */
    protected $_staticData = [
        'pageCategory' => 'new_order'
    ];

    /**
     * @var
     */
    protected $_cartItems;

    /**
     * @return Mage_Sales_Model_Order
     */
    public function getDataObject()
    {
        return Mage::getSingleton('checkout/session')->getLastRealOrder();
    }

    /**
     * @return bool
     */
    public function isValidDataObject()
    {
        return $this->getDataObject() instanceof Mage_Sales_Model_Order && $this->getDataObject()->getIncrementId();
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return Mage::getStoreConfigFlag('google/ambimax_gtm_datalayer/add_datalayer_success_page');
    }

    /**
     * Returns cart items of last real order
     *
     * @return array|mixed
     */
    public function getCartItems()
    {
        if (!is_array($this->_cartItems)) {

            $this->_cartItems = [];

            if (!$this->isValidDataObject()) {
                return $this->_cartItems;
            }

            $order = $this->getDataObject();

            /** @var Mage_Sales_Model_Order_Item $item */
            foreach ($order->getAllItems() as $item) {
                $this->_cartItems[] = [
                    'name'     => $item->getName(),
                    'sku'      => $item->getSku(),
                    'category' => $this->getCategoryFromCartItem($item),
                    'price'    => $item->getPrice(),
                    'quantity' => $item->getQtyOrdered()
                ];
            }
        }

        return $this->_cartItems;
    }

    /**
     * @param Mage_Sales_Model_Order_Item $item
     * @return string
     */
    public function getCategoryFromCartItem(Mage_Sales_Model_Order_Item $item)
    {
        if (!$item->getProduct() instanceof Mage_Catalog_Model_Product) {
            return '';
        }

        if (!$item->getProduct()->getCategory() instanceof Mage_Catalog_Model_Category) {
            return '';
        }

        return $item->getProduct()->getCategory()->getName();
    }
}