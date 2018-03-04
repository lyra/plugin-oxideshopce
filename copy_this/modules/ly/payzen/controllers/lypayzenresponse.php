<?php
/**
 * PayZen V2-Payment Module version 2.0.0 for OXID_eShop_CE 4.9.x. Support contact : support@payzen.eu.
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
 * @category  payment
 * @package   payzen
 * @author    Lyra Network (http://www.lyra-network.com/)
 * @copyright 2014-2016 Lyra Network and contributors
 * @license   http://www.gnu.org/licenses/gpl.html  GNU General Public License (GPL v3)
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
		$payzenResponse = new PayzenResponse(
				$_REQUEST,
				$this->getConfig()->getConfigParam('CTX_MODE'),
				$this->getConfig()->getConfigParam('KEY_TEST'),
				$this->getConfig()->getConfigParam('KEY_PROD')
		);

		$this->_logger->log('Response received from : ' . $_SERVER['REMOTE_ADDR'] . ' with data ' . print_r($_REQUEST, true) . '.', lyPayzenLogger::LEVEL_DEBUG);

		$fromServer = $payzenResponse->get('hash') != null;

		if(!$payzenResponse->isAuthentified()) {
			$this->_logger->log('Authentication failed - Received from IP: ' . $_SERVER['REMOTE_ADDR'], lyPayzenLogger::LEVEL_ERROR);
			if($fromServer) {
				die($payzenResponse->getOutputForPlatform('auth_fail'));
			} else {
				// redirect user to store home page
				$this->_getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(),false);
				exit;
			}
		}

		$oxid = oxDb::getDB()->getone('SELECT `OXID` FROM `oxorder` WHERE `OXORDERNR` = ' . $payzenResponse->get('order_id'));
		$oOrder = oxNew('lyPayzenOxOrder');
		if(!$oOrder->load($oxid)) {
			$this->_logger->log('Order not found : '. $payzenResponse->get('vads_order_id'), lyPayzenLogger::LEVEL_ERROR);

			if($fromServer) {
				die($payzenResponse->getOutputForPlatform('order_not_found'));
			} else {
				// redirect user to store home page
				$this->_getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(),false);
				exit;
			}
		}

		$firstMsg = true;

		// messages to display on payment result page
		if(!$fromServer && $this->getConfig()->getConfigParam('CTX_MODE') == 'TEST') {
			$this->_getUtilsView()->addErrorToDisplay('PAYZEN_GOING_INTO_PROD_INFO');
			$this->_getUtilsView()->addErrorToDisplay('<a href="https://secure.payzen.eu/html/faq/prod" target="_blank">https://secure.payzen.eu/html/faq/prod</a><br />');

			$firstMsg = false;
		}

		// load module language file
		if($oOrder->oxorder__oxtransstatus->value == 'NOT_FINISHED') {
			if ($payzenResponse->isAcceptedPayment()) {
				$this->_logger->log("Payment successful for order #{$payzenResponse->get('order_id')}.");

				// update and save order
				$oOrder->oxorder__oxtransstatus = new oxField('OK');
				$oOrder->oxorder__oxtransid = new oxField($payzenResponse->get('trans_id'));
				$oOrder->oxorder__oxpaid = new oxField(date('Y-m-d H:i:s', time()), oxField::T_RAW);

				$oOrder->oxorder__payzencardnumber = new oxField($payzenResponse->get('card_number'));
				$oOrder->oxorder__payzencardbrand = new oxField($payzenResponse->get('card_brand'));
				$oOrder->oxorder__payzencardexpiration = new oxField(
						str_pad($payzenResponse->get('expiry_month'), 2, '0', STR_PAD_LEFT).'/'.$payzenResponse->get('expiry_year')
				);

				$oOrder->save();
				$this->_logger->log("Order #{$payzenResponse->get('order_id')} successfully updated.");

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

				if($result === oxOrder::ORDER_STATE_MAILINGERROR) {
					$this->_logger->log("Error when sending order #{$payzenResponse->get('order_id')} by e-mail.", lyPayzenLogger::LEVEL_WARN);
				}

				if($fromServer) {
					die($payzenResponse->getOutputForPlatform('payment_ok'));
				} else {
					if($this->getConfig()->getConfigParam('CTX_MODE') == 'TEST') {
						$this->_logger->log("Notification URL not called correctly for order #{$payzenResponse->get('order_id')}.", lyPayzenLogger::LEVEL_WARN);

						// payment confirmed by client retun, show a warning if TEST mode
						$this->_getUtilsView()->addErrorToDisplay('<br />');
						$this->_getUtilsView()->addErrorToDisplay('PAYZEN_CHECK_URL_WARN');
						$this->_getUtilsView()->addErrorToDisplay('PAYZEN_CHECK_URL_WARN_DETAIL');
					}

					$page = 'thankyou';
					if($result === oxOrder::ORDER_STATE_MAILINGERROR) {
						$page .= '?mailerror=1';
					}

					return $page;
				}
			} elseif ($payzenResponse->isCancelledPayment()) {
				if($fromServer){
					die($payzenResponse->getOutputForPlatform('payment_ko'));
				} else {
					// error message
					if(!$firstMsg) {
						$this->_getUtilsView()->addErrorToDisplay('<br />');
					}
					$this->_getUtilsView()->addErrorToDisplay('PAYZEN_PAYMENT_CANCEL');
					return 'payment';
				}
			} else {
				$this->_logger->log("Payment failed for order #{$payzenResponse->get('order_id')} with message \"{$payzenResponse->getLogString()}\".");

				$oOrder->oxorder__oxtransstatus = new oxField('ERROR');
				$oOrder->oxorder__oxtransid = new oxField($payzenResponse->get('trans_id'));
				$oOrder->save();

				if($fromServer){
					die($payzenResponse->getOutputForPlatform('payment_ko'));
				} else {
					// to force oxid to create new order
					$this->getSession()->deleteVariable('sess_challenge');

					// error message
					if(!$firstMsg) {
						$this->_getUtilsView()->addErrorToDisplay('<br />');
					}
					$this->_getUtilsView()->addErrorToDisplay('PAYZEN_PAYMENT_ERROR');
					return 'payment';
				}
			}
		} else {
			if (($payzenResponse->isAcceptedPayment()) && ($oOrder->oxorder__oxtransstatus->value == 'OK')) {
				$this->_logger->log("Payment successful confirmed for order #{$payzenResponse->get('order_id')}.");

				if($fromServer){
					die($payzenResponse->getOutputForPlatform('payment_ok_already_done'));
				} else {
					$page = 'thankyou';
					if($oOrder->oxorder__payzensendmail->value == oxOrder::ORDER_STATE_MAILINGERROR) {
						$page .= '?mailerror=1';
					}

					return $page;
				}
			} elseif((!$payzenResponse->isAcceptedPayment()) && ($oOrder->oxorder__oxtransstatus->value == 'ERROR')) {
				$this->_logger->log("Payment failed confirmed for order #{$payzenResponse->get('order_id')}.");

				if($fromServer) {
					die ($payzenResponse->getOutputForPlatform('payment_ko_already_done'));
				} else {
					// to force oxid to create new order
					$this->getSession()->deleteVariable('sess_challenge');

					// error message
					if(!$firstMsg) {
						$this->_getUtilsView()->addErrorToDisplay('<br />');
					}
					$this->_getUtilsView()->addErrorToDisplay('PAYZEN_PAYMENT_ERROR');
					return 'payment';
				}
			} else {
				$this->_logger->log("Incorrect payment result ({$payzenResponse->get('resut')}) for an already registred order with status \"{$oOrder->oxorder__oxtransstatus->value}\"", lyPayzenLogger::LEVEL_ERROR);

				if($fromServer) {
					die ($payzenResponse->getOutputForPlatform('payment_ko_on_order_ok'));
				} else {
					// error message
					$this->_getUtils()->redirect($this->getConfig()->getShopSecureHomeUrl(),false);
					exit;
				}
			}
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

	/**
	 * Returns oxUtils instance
	 *
	 * @return oxUtils
	 */
	protected function _getUtils()
	{
		return oxRegistry::getUtils();
	}
}