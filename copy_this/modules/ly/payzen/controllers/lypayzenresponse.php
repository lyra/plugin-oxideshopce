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
 * gateway response process controller.
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
            $this->getConfig()->getConfigParam('PAYZEN_CTX_MODE'),
            $this->getConfig()->getConfigParam('PAYZEN_KEY_TEST'),
            $this->getConfig()->getConfigParam('PAYZEN_KEY_PROD'),
            $this->getConfig()->getConfigParam('PAYZEN_SIGN_ALGO')
        );

        $fromServer = ($response->get('hash') != null);

        // Check request validity.
        if (! $response->isAuthentified()) {
            $this->_logger->log("{$_SERVER['REMOTE_ADDR']} tries to access lypayzenresponse/callback page without valid signature with parameters: " . print_r($_REQUEST, true), lyPayzenLogger::ERROR);
            $this->_logger->log('Signature algorithm selected in module settings must be the same as one selected in PayZen Back Office.', lyPayzenLogger::ERROR);

            if ($fromServer) {
                die($response->getOutputForGateway('auth_fail'));
            } else {
                // Redirect user to store home page.
                oxRegistry::getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(), false);
                exit;
            }
        }

        // Order number useful for logging issue only (can be not unique).
        $orderNr = $response->get('order_id');

        // Check order exists.
        $sessChallenge = substr($response->get('order_info'), strlen('sess_challenge='));
        $oOrder = oxNew('lyPayzenOxOrder');
        if (! $oOrder->load($sessChallenge)) {
            $this->_logger->log(
                "Order not found with ID $sessChallenge correspending to #$orderNr order number.",
                lyPayzenLogger::ERROR
            );

            if ($fromServer) {
                die($response->getOutputForGateway('order_not_found'));
            } else {
                if (! $response->isCancelledPayment()) {
                    // Redirect user to store home page.
                    oxRegistry::getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(), false);
                    exit;
                }
            }
        }

        $firstMsg = true;
        $oLang = oxRegistry::getLang();

        // Messages to display on payment result page.
        require_once(dirname(__FILE__) . '/../core/lypayzentools.php');
        if ((! $fromServer && $this->getConfig()->getConfigParam('PAYZEN_CTX_MODE') === 'TEST') && lyPayzenTools::$pluginFeatures['prodfaq']) {
            $message = $oLang->translateString('PAYZEN_GOING_INTO_PROD_INFO');

            $this->_getUtilsView()->addErrorToDisplay($message);

            $firstMsg = false;
        }

        // Load module language file.
        if ($oOrder->oxorder__oxtransstatus->value === 'NOT_FINISHED') {
            if ($response->isAcceptedPayment()) {
                $this->_logger->log("Payment successful for order #$orderNr.");

                $this->_savePaymentData($oOrder, $response);

                // Update and save order.
                $oOrder->oxorder__oxtransstatus = new oxField('OK');
                $oOrder->oxorder__oxpaid = new oxField(date('Y-m-d H:i:s', time()), oxField::T_RAW);

                $oOrder->save();

                $this->_logger->log("Order #$orderNr successfully updated.");

                // Retrieve info for sending mail.
                $oUser = $oOrder->getOrderUser();

                $oBasket = oxNew('oxBasket');
                $oBasket->setBasketUser($oUser);
                $oBasket->load();
                $oBasket->calculateBasket();

                $oPayment = oxNew('oxpayment');
                $oPayment->load($oOrder->oxorder__oxpaymenttype->value);

                // Effective call to send mail.
                $result = $oOrder->sendPayzenOrderByEmail($oUser, $oBasket, $oPayment);

                // Save sending mail state in order.
                $oOrder->oxorder__payzensendmail = new oxField($result);
                $oOrder->save();

                if ($result === oxOrder::ORDER_STATE_MAILINGERROR) {
                    $this->_logger->log("Error when sending order #$orderNr by e-mail.", lyPayzenLogger::WARN);
                }

                if ($fromServer) {
                    die($response->getOutputForGateway('payment_ok'));
                } else {
                    if ($this->getConfig()->getConfigParam('PAYZEN_CTX_MODE') == 'TEST') {
                        $this->_logger->log("Notification URL not called correctly for order #$orderNr.", lyPayzenLogger::WARN);

                        $message = '<br />';

                        $shop = $this->getConfig()->getActiveShop();
                        if (! $shop->oxshops__oxactive->value) {
                            $message .= $oLang->translateString('PAYZEN_CHECK_URL_WARN_MAINTENANCE');
                        } else {
                            // Payment confirmed by client return, show a warning if TEST mode.
                            $message .= $oLang->translateString('PAYZEN_CHECK_URL_WARN');
                            $message .= ' ' . $oLang->translateString('PAYZEN_CHECK_URL_WARN_DETAIL');
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
                // Order cancel, delete it from database.
                $oOrder->delete();

                $this->_logger->log("Order #$orderNr deleted from database.", lyPayzenLogger::WARN);

                if ($fromServer){
                    die($response->getOutputForGateway('payment_ko'));
                } else {
                    // Error message.
                    $message = '';

                    if (! $firstMsg) {
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
                    die($response->getOutputForGateway('payment_ko'));
                } else {
                    // Error message.
                    $message = '';

                    if (! $firstMsg) {
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
                    die($response->getOutputForGateway('payment_ok_already_done'));
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
                    die($response->getOutputForGateway('payment_ko_already_done'));
                } else {
                    // Error message.
                    $message = '';

                    if (! $firstMsg) {
                        $message .= '<br />';
                    }

                    $message .= $oLang->translateString('PAYZEN_PAYMENT_CANCEL');
                    $this->_getUtilsView()->addErrorToDisplay($message);
                    return 'payment';
                }
            } elseif (! $response->isAcceptedPayment() && ($oOrder->oxorder__oxtransstatus->value == 'ERROR')) {
                $this->_logger->log("Payment failed confirmed for order #$orderNr.");

                if ($fromServer) {
                    die($response->getOutputForGateway('payment_ko_already_done'));
                } else {
                    // Error message.
                    $message = '';

                    if (! $firstMsg) {
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
                    die($response->getOutputForGateway('payment_ko_on_order_ok'));
                } else {
                    oxRegistry::getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(), false);
                    exit;
                }
            }
        }
    }

    private function _savePaymentData($oOrder, $response)
    {
        // Save payment information.
        $card_brand = $response->get('card_brand');
        if ($response->get('brand_management')) {
            $brand_info = json_decode($response->get('brand_management'));
            $oLang = oxRegistry::getLang();

            if (isset($brand_info->userChoice) && $brand_info->userChoice) {
                $msg_brand_choice .= $oLang->translateString('PAYZEN_ORDER_BRANDUSERCHOICE');
            } else {
                $msg_brand_choice .= $oLang->translateString('PAYZEN_ORDER_BRANDEFAULTCHOICE');
            }

            $card_brand .= ' (' . $msg_brand_choice . ')';
        }

        $oOrder->oxorder__oxtransid = new oxField($response->get('trans_id'));
        $oOrder->oxorder__payzentransuuid = new oxField($response->get('trans_uuid'));
        $oOrder->oxorder__payzencardbrand = new oxField($card_brand);
        $oOrder->oxorder__payzencardnumber = new oxField($response->get('card_number'));

        if ($response->get('expiry_month') && $response->get('expiry_year')) {
            $expiry = str_pad($response->get('expiry_month'), 2, '0', STR_PAD_LEFT) . '/' . $response->get('expiry_year');
            $oOrder->oxorder__payzencardexpiration = new oxField($expiry);
        }
    }

    /**
     * Returns oxUtilsView instance.
     *
     * @return oxUtilsView
     */
    protected function _getUtilsView()
    {
        return oxRegistry::get('oxUtilsView');
    }
}
