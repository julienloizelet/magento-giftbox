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
require_once(Mage::getModuleDir('controllers', 'Mage_Checkout') . DS . 'CartController.php');

class Okaeli_Giftbox_IndexController extends Mage_Checkout_CartController
{

    /**
     * Shipping method save action in cart
     */
    public function giftboxInCartAction()
    {

        $helper = $this->_getHelper();
        $cart = $this->_getCart();
        $error = true;
        $jsonResponse = array();
        $giftboxItemId = $helper->getGiftboxQuoteItemId();
        if ($this->getRequest()->getPost('giftbox')) {
            try {
                $giftbox = $helper->getGiftboxProduct();
                if (is_object($giftbox)) {
                    if (!$giftboxItemId) {
                        $cart->addProduct($giftbox->getId(), array('giftbox' => true))->save();
                        $error = false;
                    }
                }
            } catch (Exception $e) {
                Mage::logException($e);
                $error = $e->getMessage();
            }
        } else {
            try {
                if ($giftboxItemId) {
                    $cart->removeItem($giftboxItemId)->save();
                }

                $error = false;
            } catch (Exception $e) {
                Mage::logException($e);
                $error = $e->getMessage();
            }
        }

        // handle : okaeli_giftbox_index_giftboxincart
        $this->loadLayout();
        $cartTotalsBlock = $this->getLayout()->getBlock('checkout.cart.totals');
        $cartGiftboxFormBlock = $this->getLayout()->getBlock('okaeli.giftbox.form');
        if (is_object($cartGiftboxFormBlock)) {
            $jsonResponse['giftbox_form'] = $cartGiftboxFormBlock->toHtml();
        }

        if (is_object($cartTotalsBlock)) {
            $jsonResponse['totals'] = $cartTotalsBlock->renderView();
        }

        if ($error) {
            $jsonResponse['error'] =
                (is_string($error)) ? $error : $helper->__('There has been an error while trying to add giftbox');
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResponse));
    }

    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * @return Okaeli_Giftbox_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('okaeli_giftbox');
    }
}
