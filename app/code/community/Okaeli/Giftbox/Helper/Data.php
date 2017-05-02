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
class Okaeli_Giftbox_Helper_Data extends Okaeli_Giftbox_Helper_Config
{
    protected $_giftboxProduct;
    protected $_giftboxItemId;

    /**
     * Load the product giftbox
     * @return mixed bool|Mage_Catalog_Model_Product
     */
    public function getGiftboxProduct()
    {
        if ($this->_giftboxProduct === null) {
            $sku = $this->getSku();
            $giftboxProduct = false;
            if ($sku) {
                /** @var Mage_Catalog_Model_Resource_Product_Collection $products */
                $products = Mage::getModel('catalog/product')->getCollection();
                $giftboxProduct = $products->addAttributeToSelect('*')
                    ->addAttributeToFilter('sku', array('eq' => $sku))
                    ->setPageSize(1)
                    ->getFirstItem();
            }

            $this->_giftboxProduct = (is_object($giftboxProduct) && $giftboxProduct->getId()) ? $giftboxProduct : false;
        }

        return $this->_giftboxProduct;
    }

    /**
     * Check if giftbox is in quote
     *
     * @param bool $reload
     * @return mixed bool|int
     */
    public function getGiftboxQuoteItemId($reload = false)
    {
        if ($this->_giftboxItemId === null || $reload) {
            $sku = $this->getSku();
            $items = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
            $giftboxItemId = false;
            foreach ($items as $item) {
                if ($item->getSku() == $sku) {
                    $giftboxItemId = $item->getItemId();
                }
            }

            $this->_giftboxItemId = $giftboxItemId;
        }

        return $this->_giftboxItemId;
    }
}
