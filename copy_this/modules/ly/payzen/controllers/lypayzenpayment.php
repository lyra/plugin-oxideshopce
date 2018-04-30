<?php
/**
 * PayZen V2-Payment Module version 2.0.1 for OXID_eShop_CE 4.9-4.10. Support contact : support@payzen.eu.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Lyra Network (http://www.lyra-network.com/)
 * @copyright 2014-2018 Lyra Network and contributors
 * @license   http://www.gnu.org/licenses/gpl.html  GNU General Public License (GPL v3)
 * @category  payment
 * @package   payzen
 */

/**
 * Payment class wrapper for PayZen module.
 */
class lyPayzenPayment extends lyPayzenPayment_parent
{
    /**
     * Detects is there a payment attempt using PayZen and delete not finished order.
     *
     * @return bool
     */
    public function validatePayment()
    {
        // selected payment ID
        $sPaymentId = oxRegistry::getConfig()->getRequestParameter('paymentid');

        // search for order with current session challenge
        $order = oxNew('lyPayzenOxOrder');

        if (($sPaymentId !== 'oxidpayzen') && $order->load($this->getSession()->getVariable('sess_challenge'))) {
            if ($order->oxorder__oxpaymenttype->value === 'oxidpayzen') {
                if ($order->oxorder__oxtransstatus->value === 'NOT_FINISHED') {
                    // delete abandonned order initiated with our payment gateway
                    $order->delete();
                } elseif ($order->oxorder__oxtransstatus->value === 'ERROR') {
                    // force OXID to create new order on payment retry to keep failed payment attempts
                    $this->getSession()->deleteVariable('sess_challenge');
                }
            }
        }

        return parent::validatePayment();
    }
}
