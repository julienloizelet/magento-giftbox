<?php
/**
 * Okaeli_Giftbox  Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE Version 3
 * that is bundled with this package in the file LICENSE
 *
 * @category Okaeli
 * @package Okaeli_Giftbox
 * @copyright  Copyright (c)  2017 Julien Loizelet
 * @author     Julien Loizelet <julienloizelet@okaeli.com>
 * @license    GNU GENERAL PUBLIC LICENSE Version 3
 *
 */

/**
 *
 * @category Okaeli
 * @package  Okaeli_Giftbox
 * @module   Giftbox
 * @author   Julien Loizelet <julienloizelet@okaeli.com>
 *
 */
class Okaeli_Giftbox_Model_Observer extends Mage_Catalog_Model_Observer
{

    protected $_helper;

    /**
     * @param Varien_Event_Observer $observer
     */
    public function onRemoveItem(Varien_Event_Observer $observer)
    {
        $item = $observer->getQuoteItem();
        $storeId = $item->getStoreId();
        $helper = $this->_getHelper();
        if ($helper->isEnabled($storeId)) {
            $removeItemSku = $item->getSku();
            $giftSku = $helper->getSku();
            if ($removeItemSku == $giftSku) {
                return;
            } else {
                $this->_manageGiftbox($giftSku);
            }
        }
    }

    protected function _manageGiftbox($giftSku)
    {
        $items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
        $giftIsAlone = true;
        $giftboxItemId = false;
        foreach ($items as $item) {
            if ($item->getSku() != $giftSku) {
                $giftIsAlone = false;
            } else {
                $giftboxItemId = $item->getItemId();
            }
        }

        if ($giftIsAlone && $giftboxItemId) {
            $this->_getCart()->removeItem($giftboxItemId)->save();
        }
    }

    /**
     * Helper init
     * @return Okaeli_Giftbox_Helper_Data
     */
    protected function _getHelper()
    {
        if ($this->_helper === null) {
            $helper = Mage::helper('okaeli_giftbox');
            $this->_helper = ($helper) ? $helper : false;
        }

        return $this->_helper;
    }

    /**
     * @return mixed
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }
}