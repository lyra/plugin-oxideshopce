<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
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
            // State == 1 (new order) or state == 3 (order retry).
            // Redirect to payment gateway.
            if (($iSuccess === oxOrder::ORDER_STATE_OK)
                || (($iSuccess === oxOrder::ORDER_STATE_ORDEREXISTS) && ($oOrder->oxorder__oxtransstatus !== 'OK'))) {
                // Order not finished until confirmation on gateway.
                $oOrder->oxorder__oxtransstatus = new oxField('NOT_FINISHED');
                $oOrder->oxorder__oxsenddate = new oxField(date('Y-m-d H:i:s', time()), oxField::T_RAW);
                $oOrder->oxorder__oxip = new oxField($_SERVER['REMOTE_ADDR']);
                $oOrder->save();

                $this->_logger->log("Order #{$oOrder->oxorder__oxordernr->value} prepared for redirection to payment gateway.");

                // Redirect controller.
                return 'lypayzenredirect';
            }
        }

        // Continue with normal flow.
        return parent::_getNextStep($iSuccess);
    }
}
