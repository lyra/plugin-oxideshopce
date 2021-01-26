<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

class lyPayzenOxOrder extends lyPayzenOxOrder_parent
{
    protected function _sendOrderByEmail($oUser = null, $oBasket = null, $oPayment = null)
    {
        if ($this->oxorder__oxpaymenttype->value === 'oxidpayzen') {
            // Don't send order email under normal flow.
            return oxOrder::ORDER_STATE_OK;
        }

        return parent::_sendOrderByEmail($oUser, $oBasket, $oPayment);
    }

    /**
     * Separate method to send order e-mail once order status is OK.
     *
     * @param oxUser $oUser
     * @param oxBasket $oBasket
     * @param oxPayment $oPayment
     */
    public function sendPayzenOrderByEmail($oUser = null, $oBasket = null, $oPayment = null)
    {
        return parent::_sendOrderByEmail($oUser, $oBasket, $oPayment);
    }
}
