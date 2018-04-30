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

class lyPayzenOrder extends lyPayzenOrder_parent
{
    /**
     * Logger instance.
     * @var lyPayzenLogger
     */
    protected $_logger;

    /**
     * Class constructor, initiates parent constructor and adds class logger.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_logger = new lyPayzenLogger(__CLASS__);
    }

    /**
     * Override OXID order flow to redirect to payment gateway.
     *
     * @param integer $iSuccess
     * @return function
     */
    protected function _getNextStep($iSuccess)
    {
        $oOrder = oxNew('lyPayzenOxOrder');

        if ($oOrder->load($this->getSession()->getVariable('sess_challenge'))
            && ($oOrder->oxorder__oxpaymenttype->value === 'oxidpayzen')) {
            // state == 1 (new order) or state == 3 (order retry)
            // redirect to PayZen payment gateway
            if (($iSuccess === oxOrder::ORDER_STATE_OK)
                || (($iSuccess === oxOrder::ORDER_STATE_ORDEREXISTS) && ($oOrder->oxorder__oxtransstatus !== 'OK'))) {
                // order not finished until confirmation on gateway
                $oOrder->oxorder__oxtransstatus = new oxField('NOT_FINISHED');
                $oOrder->oxorder__oxsenddate = new oxField(date('Y-m-d H:i:s', time()), oxField::T_RAW);
                $oOrder->oxorder__oxip = new oxField($_SERVER['REMOTE_ADDR']);
                $oOrder->save();

                $this->_logger->log("Order #{$oOrder->oxorder__oxordernr->value} prepared for redirection to payment gateway.");

                // redirect controller
                return 'lypayzenredirect';
            }
        }

        // continue with normal flow
        return parent::_getNextStep($iSuccess);
    }
}
