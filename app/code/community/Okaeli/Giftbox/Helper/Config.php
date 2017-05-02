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
class Okaeli_Giftbox_Helper_Config extends Mage_Core_Helper_Abstract
{
    protected $_isEnabled;
    protected $_sku;

    const XML_PATH_ENABLED = 'okaeli_giftbox/settings/enabled';
    const XML_PATH_SKU = 'okaeli_giftbox/settings/sku';

    /**
     * Get 'enabled' setting
     * @return mixed
     */
    public function isEnabled()
    {
        if ($this->_isEnabled === null) {
            $enabled = Mage::getStoreConfig(self::XML_PATH_ENABLED);
            $this->_isEnabled = $enabled;
        }

        return $this->_isEnabled;
    }

    /**
     * Get 'sku' setting
     * @return mixed
     */
    public function getSku()
    {
        if ($this->_sku === null) {
            $sku = trim(Mage::getStoreConfig(self::XML_PATH_SKU));
            $this->_sku = !empty($sku) ? $sku : false;
        }

        return $this->_sku;
    }
}
