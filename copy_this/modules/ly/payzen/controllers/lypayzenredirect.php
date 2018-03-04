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
 * Redirection to PayZen payment platform controller.
 */
class lyPayzenRedirect extends oxUBase
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
	 * Current class template name.
	 *
	 * @var string
	 */
	protected $_sThisTemplate = 'lypayzentemplateredirect.tpl';

	public function getFormAction() {
		return $this->getConfig()->getConfigParam('PLATFORM_URL');
	}

	public function getFormFields() {
		$data = array();

		// load order information
		$oOrder = oxNew('lyPayzenOxOrder');
		$oOrder->load($this->getSession()->getVariable('sess_challenge'));

		// admin module config
		$myConfig = $this->getConfig();

		// process currency
		$oxCurrency = $oOrder->getOrderCurrency();
		$currency = PayzenApi::findCurrencyByAlphaCode($oOrder->getOrderCurrency()->name);
		$data['currency'] = $currency->getNum();

		// format amount
		$amount = $oOrder->getTotalOrderSum();

		$data['amount'] = $currency->convertAmountToInteger($amount);
		$data['order_id'] = $oOrder->oxorder__oxordernr->value;
		$data['order_info'] = 'session_id=' . $this->getSession()->getId();

		$data['contrib'] = 'OXID_eShop_CE4.9.x_2.0.0/' . oxView::getShopFullEdition() . ' ' . oxView::getShopVersion();

		// return to shop URL
		$data['url_return'] = $this->_getReturnUrl($oOrder->getOrderLanguage());

		// activate 3ds ?
		$threedsMpi = null;
		$threedsMinAmount = $myConfig->getConfigParam('3DS_MIN_AMOUNT');
		if($threedsMinAmount != '' && $amount < $threedsMinAmount) {
			$threedsMpi = '2';
		}
		$data['threeds_mpi'] = $threedsMpi;

		// platform params
		$configParams = array(
				'site_id', 'key_test', 'key_prod', 'ctx_mode',
				'capture_delay', 'validation_mode', 'return_mode', 'redirect_enabled',
				'redirect_success_timeout', 'redirect_success_message', 'redirect_error_timeout', 'redirect_error_message'
		);
		foreach ($configParams as $configParam) {
			$data[$configParam] = $myConfig->getConfigParam(strtoupper($configParam)) ;
		}

		// process language
		$locale = strtolower(oxRegistry::getLang()->getLanguageAbbr($oOrder->getOrderLanguage()));

		if($locale && PayzenApi::isSupportedLanguage($locale)) {
			$data['language'] = $locale;
		} else {
			$data['language'] = $myConfig->getConfigParam('LANGUAGE');
		}

		$availLanguages = null;
		$languages = $myConfig->getConfigParam('AVAILABLE_LANGUAGES');
		if (isset($languages) && is_array($languages) && !empty($languages)) {
			$availLanguages = implode(';', $languages);
		}
		$data['available_languages'] = $availLanguages ;

		$availCards = null;
		$cards = $myConfig->getConfigParam('PAYMENT_CARDS');
		if (isset($cards) && is_array($cards) && !empty($cards)) {
			$availCards = implode(';', $cards);
		}
		$data['payment_cards'] = $availCards ;

		// billing address
		$data['cust_id'] = $this->getUser()->getId();
		$data['cust_address'] = $oOrder->oxorder__oxbillstreet->value . ' ' . $oOrder->oxorder__oxbillstreetnr->value;
		$data['cust_zip'] = $oOrder->oxorder__oxbillzip->value;

		$billingCountry = null;
		if ($oOrder->oxorder__oxbillcountryid->value) {
			$oCountry = oxNew('oxCountry');
			$oCountry->load($oOrder->oxorder__oxbillcountryid->value);
			$billingCountry = $oCountry->oxcountry__oxisoalpha2->value;
		}
		$data['cust_country'] = $billingCountry;

		$data['cust_email'] = $oOrder->oxorder__oxbillemail->value;
		$data['cust_phone'] = $oOrder->oxorder__oxbillfon->value;
		$data['cust_city'] = $oOrder->oxorder__oxbillcity->value;

		$billingState = null;
		if ($oOrder->oxorder__oxbillstateid->value) {
			$oState = oxNew('oxState');
			$oState->load($oOrder->oxorder__oxbillstateid->value);
			$billingState = $oState->oxstates__oxisoalpha2->value;
		}

		$data['cust_state'] = $billingState;
		$data['cust_title'] = $oOrder->oxorder__oxbillsal->value;
		$data['cust_first_name'] = $oOrder->oxorder__oxbillfname->value;
		$data['cust_last_name'] = $oOrder->oxorder__oxbilllname->value;

		// shipping address
		if($oDelAddress = $oOrder->getDelAddressInfo()) {
			$data['ship_to_first_name'] = $oOrder->oxorder__oxdelfname->value;
			$data['ship_to_last_name'] = $oOrder->oxorder__oxdellname->value;
			$data['ship_to_phone_num'] = $oOrder->oxorder__oxdelfon->value;
			$data['ship_to_street'] = $oOrder-> oxorder__oxdelstreet->value;
			$data['ship_to_street2'] = $oOrder-> oxorder__oxdelstreetnr->value;

			$shippingState = null;
			if ($oOrder->oxorder__oxdelstateid->value) {
				$oState = oxNew('oxState');
				$oState->load($oOrder->oxorder__oxdelstateid->value);
				$shippingState = $oState->oxstates__oxisoalpha2->value;
			}
			$data['ship_to_state'] = $shippingState;

			$shippingCountry = null;
			if ($oOrder->oxorder__oxdelcountryid->value) {
				$oCountry = oxNew('oxCountry');
				$oCountry->load($oOrder->oxorder__oxdelcountryid->value);
				$shippingCountry = $oCountry->oxcountry__oxisoalpha2->value;
			}
			$data['ship_to_country'] = $shippingCountry;

			$data['ship_to_city'] = $oOrder->oxorder__oxdelcity->value;
			$data['ship_to_zip'] = $oOrder->oxorder__oxdelzip->value;
		} else {
			// Shipping address equals to Billing address
			$data['ship_to_first_name'] = $oOrder->oxorder__oxbillfname->value;
			$data['ship_to_last_name'] = $oOrder->oxorder__oxbilllname->value;
			$data['ship_to_phone_num'] = $oOrder->oxorder__oxbillfon->value;
			$data['ship_to_street'] = $oOrder->oxorder__oxbillstreet->value;
			$data['ship_to_street2'] = $oOrder-> oxorder__oxbillstreetnr->value;
			$data['ship_to_state'] = $billingState;
			$data['ship_to_country'] = $billingCountry;
			$data['ship_to_city'] = $oOrder->oxorder__oxbillcity->value ;
			$data['ship_to_zip'] = $oOrder->oxorder__oxbillzip->value  ;
		}

		// render payment request form
		$encoding = $myConfig->isUtf() ? 'UTF-8' : 'ISO-8859-15';
		$payzenRequest = new PayzenRequest($encoding);
		$payzenRequest->setFromArray($data);

		$this->_logger->log('Data to send to payment platform : ' . print_r($payzenRequest->getRequestFieldsArray(true), true) . '.', lyPayzenLogger::LEVEL_DEBUG);

		return $payzenRequest->getRequestFieldsArray();
	}

	public function _getReturnUrl($lang) {
		$oSession = $this->getSession();

		$sUrl = $this->getConfig()->getSslShopUrl() . 'index.php?lang=' . $lang;
		$sUrl .= '&rtoken=' . $oSession->getRemoteAccessToken();
		$sUrl .= '&shp=' . $this->getConfig()->getShopId();
		$sUrl .= '&cl=lyPayzenResponse&fnc=callback';

		return $oSession->processUrl($sUrl);
	}
}