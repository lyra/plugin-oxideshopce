<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

/**
 * Payment class wrapper for gateway module.
 */
class lyPayzenPayment extends lyPayzenPayment_parent
{
    /**
     * Detects is there a payment attempt using gateway and delete not finished order.
     *
     * @return bool
     */
    public function validatePayment()
    {
        // Selected payment ID.
        $sPaymentId = oxRegistry::getConfig()->getRequestParameter('paymentid');

        // Search for order with current session challenge.
        $order = oxNew('lyPayzenOxOrder');

        if (($sPaymentId !== 'oxidpayzen') && $order->load($this->getSession()->getVariable('sess_challenge'))) {
            if ($order->oxorder__oxpaymenttype->value === 'oxidpayzen') {
                if ($order->oxorder__oxtransstatus->value === 'NOT_FINISHED') {
                    // Delete abandonned order initiated with our payment gateway.
                    $order->delete();
                } elseif ($order->oxorder__oxtransstatus->value === 'ERROR') {
                    // Force OXID to create new order on payment retry to keep failed payment attempts.
                    $this->getSession()->deleteVariable('sess_challenge');
                }
            }
        }

        return parent::validatePayment();
    }
}
