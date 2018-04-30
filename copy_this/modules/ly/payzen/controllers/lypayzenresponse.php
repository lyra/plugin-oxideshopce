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
 * PayZen response process controller.
 */
class lyPayzenResponse extends oxUBase
{
    /**
     * Logger instance.
     * @var lyPayzenLogger
     */
    protected $_logger;

    /**
     * Class constructor, initiates parent constructor (parent::oxBase()).
     */
    public function __construct()
    {
        parent::__construct();

        $this->_logger = new lyPayzenLogger(__CLASS__);
    }

    /**
     * Handles response when user comes back from the payment website to shop.
     */
    public function callback()
    {
        $response = new PayzenResponse(
            $_REQUEST,
            $this->getConfig()->getConfigParam('CTX_MODE'),
            $this->getConfig()->getConfigParam('KEY_TEST'),
            $this->getConfig()->getConfigParam('KEY_PROD')
        );

        $fromServer = $response->get('hash') != null;

        // check request validity
        if (!$response->isAuthentified()) {
            $this->_logger->log(
                "Received invalid response from IP {$_SERVER['REMOTE_ADDR']} with parameters: " . print_r($_REQUEST, true),
                lyPayzenLogger::ERROR
            );

            if ($fromServer) {
                die($response->getOutputForPlatform('auth_fail'));
            } else {
                // redirect user to store home page
                oxRegistry::getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(), false);
                exit;
            }
        }

        // order number useful for logging issue only (can be not unique)
        $orderNr = $response->get('order_id');

        // check order exists
        $sessChallenge = substr($response->get('order_info'), strlen('sess_challenge='));
        $oOrder = oxNew('lyPayzenOxOrder');
        if (!$oOrder->load($sessChallenge)) {
            $this->_logger->log(
                "Order not found with ID $sessChallenge correspending to #$orderNr order number.",
                lyPayzenLogger::ERROR
            );

            if ($fromServer) {
                die($response->getOutputForPlatform('order_not_found'));
            } else {
                if (!$response->isCancelledPayment()) {
                    // redirect user to store home page
                    oxRegistry::getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(), false);
                    exit;
                }
            }
        }

        $firstMsg = true;
        $oLang = oxRegistry::getLang();

        // messages to display on payment result page
        if (!$fromServer && $this->getConfig()->getConfigParam('CTX_MODE') === 'TEST') {
            $message = $oLang->translateString('PAYZEN_GOING_INTO_PROD_INFO');
            $message .= ' <a href="https://secure.payzen.eu/html/faq/prod" target="_blank">https://secure.payzen.eu/html/faq/prod</a>';

            $this->_getUtilsView()->addErrorToDisplay($message);

            $firstMsg = false;
        }

        // load module language file
        if ($oOrder->oxorder__oxtransstatus->value === 'NOT_FINISHED') {
            if ($response->isAcceptedPayment()) {
                $this->_logger->log("Payment successful for order #$orderNr.");

                $this->_savePaymentData($oOrder, $response);

                // update and save order
                $oOrder->oxorder__oxtransstatus = new oxField('OK');
                $oOrder->oxorder__oxpaid = new oxField(date('Y-m-d H:i:s', time()), oxField::T_RAW);

                $oOrder->save();

                $this->_logger->log("Order #$orderNr successfully updated.");

                // retrieve info for sending mail
                $oUser = $oOrder->getOrderUser();

                $oBasket = oxNew('oxBasket');
                $oBasket->setBasketUser($oUser);
                $oBasket->load();
                $oBasket->calculateBasket();

                $oPayment = oxNew('oxpayment');
                $oPayment->load($oOrder->oxorder__oxpaymenttype->value);

                // effective call to send mail
                $result = $oOrder->sendPayzenOrderByEmail($oUser, $oBasket, $oPayment);

                // save sending mail state in order
                $oOrder->oxorder__payzensendmail = new oxField($result);
                $oOrder->save();

                if ($result === oxOrder::ORDER_STATE_MAILINGERROR) {
                    $this->_logger->log("Error when sending order #$orderNr by e-mail.", lyPayzenLogger::WARN);
                }

                if ($fromServer) {
                    die($response->getOutputForPlatform('payment_ok'));
                } else {
                    if ($this->getConfig()->getConfigParam('CTX_MODE') == 'TEST') {
                        $this->_logger->log("Notification URL not called correctly for order #$orderNr.", lyPayzenLogger::WARN);

                        $message = '<br />';

                        $shop = $this->getConfig()->getActiveShop();
                        if (!$shop->oxshops__oxactive->value) {
                            $message .= $oLang->translateString('PAYZEN_CHECK_URL_WARN_MAINTENANCE');
                        } else {
                            // payment confirmed by client retun, show a warning if TEST mode
                            $message .= $oLang->translateString('PAYZEN_CHECK_URL_WARN');
                            $message .= $oLang->translateString('PAYZEN_CHECK_URL_WARN_DETAIL');
                        }

                        $this->_getUtilsView()->addErrorToDisplay($message);
                    }

                    $page = 'thankyou';
                    if ($result === oxOrder::ORDER_STATE_MAILINGERROR) {
                        $page .= '?mailerror=1';
                    }

                    return $page;
                }
            } elseif ($response->isCancelledPayment()) {
                // order cancel, delete it from database
                $oOrder->delete();

                $this->_logger->log("Order #$orderNr deleted from database.", lyPayzenLogger::WARN);

                if ($fromServer){
                    die($response->getOutputForPlatform('payment_ko'));
                } else {
                    // error message
                    $message = '';

                    if (!$firstMsg) {
                        $message .= '<br />';
                    }

                    $message .= $oLang->translateString('PAYZEN_PAYMENT_CANCEL');
                    $this->_getUtilsView()->addErrorToDisplay($message);
                    return 'payment';
                }
            } else {
                $this->_logger->log("Payment failed for order #$orderNr with message: {$response->getLogMessage()}.");

                $this->_savePaymentData($oOrder, $response);

                $oOrder->oxorder__oxtransstatus = new oxField('ERROR');
                $oOrder->save();

                if ($fromServer){
                    die($response->getOutputForPlatform('payment_ko'));
                } else {
                    // error message
                    if (!$firstMsg) {
                        $message = '<br />';
                    }

                    $message .= $oLang->translateString('PAYZEN_PAYMENT_ERROR');
                    $this->_getUtilsView()->addErrorToDisplay($message);
                    return 'payment';
                }
            }
        } else {
            if ($response->isAcceptedPayment() && ($oOrder->oxorder__oxtransstatus->value == 'OK')) {
                $this->_logger->log("Payment successful confirmed for order #$orderNr.");

                if ($fromServer){
                    die($response->getOutputForPlatform('payment_ok_already_done'));
                } else {
                    $page = 'thankyou';
                    if ($oOrder->oxorder__payzensendmail->value == oxOrder::ORDER_STATE_MAILINGERROR) {
                        $page .= '?mailerror=1';
                    }

                    return $page;
                }
            } elseif ($response->isCancelledPayment()) {
                $this->_logger->log("Payment cancellation confirmed for order #$orderNr.");

                if ($fromServer){
                    die($response->getOutputForPlatform('payment_ko_already_done'));
                } else {
                    // error message
                    $message = '';

                    if (!$firstMsg) {
                        $message .= '<br />';
                    }

                    $message .= $oLang->translateString('PAYZEN_PAYMENT_CANCEL');
                    $this->_getUtilsView()->addErrorToDisplay($message);
                    return 'payment';
                }
            } elseif (!$response->isAcceptedPayment() && ($oOrder->oxorder__oxtransstatus->value == 'ERROR')) {
                $this->_logger->log("Payment failed confirmed for order #$orderNr.");

                if ($fromServer) {
                    die($response->getOutputForPlatform('payment_ko_already_done'));
                } else {
                    // error message
                    if (!$firstMsg) {
                        $message = '<br />';
                    }

                    $message .= $oLang->translateString('PAYZEN_PAYMENT_ERROR');
                    $this->_getUtilsView()->addErrorToDisplay($message);
                    return 'payment';
                }
            } else {
                $this->_logger->log(
                    "Inconsistent payment result ({$response->getTransStatus()}) received for an already registred order (with status {$oOrder->oxorder__oxtransstatus->value}).",
                    lyPayzenLogger::ERROR
                );

                if ($fromServer) {
                    die($response->getOutputForPlatform('payment_ko_on_order_ok'));
                } else {
                    // error message
                    oxRegistry::getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(), false);
                    exit;
                }
            }
        }
    }

    private function _savePaymentData($oOrder, $response)
    {
        // save payment information
        $oOrder->oxorder__oxtransid = new oxField($response->get('trans_id'));
        $oOrder->oxorder__payzentransuuid = new oxField($response->get('trans_uuid'));
        $oOrder->oxorder__payzencardbrand = new oxField($response->get('card_brand'));
        $oOrder->oxorder__payzencardnumber = new oxField($response->get('card_number'));

        if ($response->get('expiry_month') && $response->get('expiry_year')) {
            $expiry = str_pad($response->get('expiry_month'), 2, '0', STR_PAD_LEFT) . '/' . $response->get('expiry_year');
            $oOrder->oxorder__payzencardexpiration = new oxField($expiry);
        }
    }

    /**
     * Returns oxUtilsView instance
     *
     * @return oxUtilsView
     */
    protected function _getUtilsView()
    {
        return oxRegistry::get('oxUtilsView');
    }
}
