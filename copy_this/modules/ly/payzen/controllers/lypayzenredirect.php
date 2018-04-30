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
 * Redirection to PayZen payment gateway controller.
 */
class lyPayzenRedirect extends oxUBase
{
    /**
     * Logger instance.
     * @var lyPayzenLogger
     */
    protected $_logger;

    /**
     * Current view is an order step.
     *
     * @var bool
     */
    protected $_blIsOrderStep = true;

    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'lypayzentemplateredirect.tpl';

    /**
     * Class constructor, initiates parent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_logger = new lyPayzenLogger(__CLASS__);
    }

    public function render()
    {
        if (!$this->getSession()->getVariable('sess_challenge')) {
            oxRegistry::getUtils()->redirect($this->getConfig()->getShopHomeURL() . 'cl=basket', false, 302);
        }

        return parent::render();
    }

    public function getFormAction()
    {
        return $this->getConfig()->getConfigParam('PLATFORM_URL');
    }

    public function getFormFields()
    {
        $data = array();

        // load order information
        $oOrder = oxNew('lyPayzenOxOrder');
        $oOrder->load($this->getSession()->getVariable('sess_challenge'));

        // current language
        $oLang = $oOrder->getOrderLanguage();

        // admin module config
        $oConfig = $this->getConfig();

        // process currency
        $currency = PayzenApi::findCurrencyByAlphaCode($oOrder->getOrderCurrency()->name);
        $data['currency'] = $currency->getNum();

        // format amount
        $amount = $oOrder->getTotalOrderSum();

        $data['amount'] = $currency->convertAmountToInteger($amount);
        $data['order_id'] = $oOrder->oxorder__oxordernr->value;
        $data['order_info'] = 'sess_challenge=' . $this->getSession()->getVariable('sess_challenge');

        $data['contrib'] = 'OXID_eShop_CE4.9-4.10_2.0.1/' . oxView::getShopFullEdition() . ' ' . oxView::getShopVersion()
            . '/' . PHP_VERSION;

        // return to shop URL
        $data['url_return'] = $this->_getReturnUrl($oLang);
        $this->_logger->log("Complete return URL is {$data['url_return']}.", lyPayzenLogger::DEBUG);

        // activate 3ds ?
        $threedsMpi = null;
        $threedsMinAmount = $oConfig->getConfigParam('3DS_MIN_AMOUNT');
        if ($threedsMinAmount && ($amount < $threedsMinAmount)) {
            $threedsMpi = '2';
        }

        $data['threeds_mpi'] = $threedsMpi;

        // gateway params
        $configParams = array(
            'site_id', 'key_test', 'key_prod', 'ctx_mode',
            'capture_delay', 'validation_mode', 'return_mode', 'redirect_enabled',
            'redirect_success_timeout', 'redirect_success_message', 'redirect_error_timeout',
            'redirect_error_message'
        );

        foreach ($configParams as $configParam) {
            $data[$configParam] = $oConfig->getConfigParam(strtoupper($configParam)) ;
        }

        // process payment page language
        $lang = strtolower(oxRegistry::getLang()->getLanguageAbbr($oLang));
        $data['language'] = ($lang && PayzenApi::isSupportedLanguage($lang)) ? $lang : $oConfig->getConfigParam('LANGUAGE');

        $availLanguages = null;
        $languages = $oConfig->getConfigParam('AVAILABLE_LANGUAGES');
        if (isset($languages) && is_array($languages) && !empty($languages)) {
            $availLanguages = implode(';', $languages);
        }

        $data['available_languages'] = $availLanguages ;

        $availCards = null;
        $cards = $oConfig->getConfigParam('PAYMENT_CARDS');
        if (isset($cards) && is_array($cards) && !empty($cards)) {
            $availCards = implode(';', $cards);
        }

        $data['payment_cards'] = $availCards ;

        // customer IDs
        $data['cust_id'] = $oOrder->oxorder__oxuserid->value;
        $data['cust_email'] = $oUser->oxorder__oxbillemail->value;

        // billing address
        $data['cust_title'] = $oOrder->oxorder__oxdelsal->value;
        $data['cust_first_name'] = $oOrder->oxorder__oxdelfname->value;
        $data['cust_last_name'] = $oOrder->oxorder__oxdellname->value;
        $data['cust_address'] = $oOrder->oxorder__oxdelstreetnr->value . ' ' . $oOrder->oxorder__oxdelstreet->value;
        $data['cust_zip'] = $oOrder->oxorder__oxdelzip->value;
        $data['cust_city'] = $oOrder->oxorder__oxdelcity->value;
        $data['cust_phone'] = $oOrder->oxorder__oxdelfon->value;

        $bState = null;
        if ($oOrder->oxorder__oxdelstateid->value) {
            $oState = oxNew('oxState');
            $oState->load($oOrder->oxorder__oxdelstateid->value);

            // send state ISO code
            $bState = $oState->oxstates__oxisoalpha2->value;
        }

        $data['cust_state'] = $bState;

        $bCountry = null;
        if ($oOrder->oxorder__oxdelcountryid->value) {
            $oCountry = oxNew('oxCountry');
            $oCountry->load($oOrder->oxorder__oxdelcountryid->value);

            // send country ISO code
            $bCountry = $oCountry->oxcountry__oxisoalpha2->value;
        }

        $data['cust_country'] = $bCountry;

        // shipping address
        if ($oOrder->oxorder__oxdelstreet->value) {
            $data['ship_to_first_name'] = $oOrder->oxorder__oxdelfname->value;
            $data['ship_to_last_name'] = $oOrder->oxorder__oxdellname->value;

            $data['ship_to_street'] = $oOrder-> oxorder__oxdelstreetnr->value . ' ' . $oOrder-> oxorder__oxdelstreet->value;
            $data['ship_to_zip'] = $oOrder->oxorder__oxdelzip->value;
            $data['ship_to_city'] = $oOrder->oxorder__oxdelcity->value;

            $data['ship_to_phone_num'] = $oOrder->oxorder__oxdelfon->value;

            $sState = null;
            if ($oOrder->oxorder__oxdelstateid->value) {
                $oState = oxNew('oxState');
                $oState->load($oOrder->oxorder__oxdelstateid->value);

                $sState = $oState->oxstates__oxisoalpha2->value;
            }

            $data['ship_to_state'] = $sState;

            $sCountry = null;
            if ($oOrder->oxorder__oxdelcountryid->value) {
                $oCountry = oxNew('oxCountry');
                $oCountry->load($oOrder->oxorder__oxdelcountryid->value);

                $sCountry = $oCountry->oxcountry__oxisoalpha2->value;
            }

            $data['ship_to_country'] = $sCountry;
        } else {
            // shipping address is the same as billing address
            $data['ship_to_first_name'] = $oOrder->oxorder__oxbillfname->value;
            $data['ship_to_last_name'] = $oOrder->oxorder__oxbilllname->value;
            $data['ship_to_street'] = $oOrder->oxorder__oxbillstreet->value . ' ' . $oOrder-> oxorder__oxbillstreetnr->value;
            $data['ship_to_zip'] = $oOrder->oxorder__oxbillzip->value;
            $data['ship_to_city'] = $oOrder->oxorder__oxbillcity->value;
            $data['ship_to_phone_num'] = $oOrder->oxorder__oxbillfon->value;
            $data['ship_to_state'] = $bState;
            $data['ship_to_country'] = $bCountry;
        }

        // render payment request form
        $encoding = $oConfig->isUtf() ? 'UTF-8' : 'ISO-8859-15';
        $payzenRequest = new PayzenRequest($encoding);
        $payzenRequest->setFromArray($data);

        $this->_logger->log(
            'Data to send to payment gateway : ' . print_r($payzenRequest->getRequestFieldsArray(true), true),
            lyPayzenLogger::DEBUG
        );

        return $payzenRequest->getRequestFieldsArray();
    }

    private function _getReturnUrl($lang)
    {
        $oSession = $this->getSession();

        $sUrl = $this->getConfig()->getSslShopUrl() . 'index.php?lang=' . $lang;
        $sUrl .= '&rtoken=' . $oSession->getRemoteAccessToken();
        $sUrl .= '&shp=' . $this->getConfig()->getShopId();
        $sUrl .= '&cl=lyPayzenResponse&fnc=callback';

        return $oSession->processUrl($sUrl);
    }
}
