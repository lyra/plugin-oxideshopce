<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

class lyPayzenoxPaymentList extends lyPayzenoxPaymentList_parent
{
    public function getPaymentList($sShipSetId, $dPrice, $oUser = null)
    {
        parent::getPaymentList($sShipSetId, $dPrice, $oUser);
        $currency = PayzenApi::findCurrencyByAlphaCode($this->getConfig()->getActShopCurrencyObject()->name);

        if (! $currency) {
            unset($this->_aArray['oxidpayzen']);
        }

        return $this->_aArray ;
    }
}
