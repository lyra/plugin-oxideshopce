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
 * Redirection to payment gateway controller.
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
        if (! $this->getSession()->getVariable('sess_challenge')) {
            oxRegistry::getUtils()->redirect($this->getConfig()->getShopHomeURL() . 'cl=basket', false, 302);
        }

        return parent::render();
    }

    public function getFormAction()
    {
        return $this->getConfig()->getConfigParam('PAYZEN_PLATFORM_URL');
    }

    public function getFormFields()
    {
        $data = array();

        // Load order information.
        $oOrder = oxNew('lyPayzenOxOrder');
        $oOrder->load($this->getSession()->getVariable('sess_challenge'));

        // Current language.
        $oLang = $oOrder->getOrderLanguage();

        // Admin module config.
        $oConfig = $this->getConfig();

        // Process currency.
        $currency = PayzenApi::findCurrencyByAlphaCode($oOrder->getOrderCurrency()->name);
        $data['currency'] = $currency->getNum();

        // Format amount.
        $amount = $oOrder->getTotalOrderSum();

        $data['amount'] = $currency->convertAmountToInteger($amount);
        $data['order_id'] = $oOrder->oxorder__oxordernr->value;
        $data['order_info'] = 'sess_challenge=' . $this->getSession()->getVariable('sess_challenge');

        $data['contrib'] = 'OXID_eShop_CE_4.9-6.x_2.1.1/' . oxView::getShopFullEdition() . ' ' . oxView::getShopVersion()
            . '/' . PHP_VERSION;

        // Return to shop URL.
        $data['url_return'] = $this->_getReturnUrl($oLang);
        $this->_logger->log("Complete return URL is {$data['url_return']}.", lyPayzenLogger::DEBUG);

        // Activate 3ds?
        $threedsMpi = null;
        $threedsMinAmount = $oConfig->getConfigParam('PAYZEN_3DS_MIN_AMOUNT');
        if ($threedsMinAmount && ($amount < $threedsMinAmount)) {
            $threedsMpi = '2';
        }

        $data['threeds_mpi'] = $threedsMpi;

        // Gateway params.
        $configParams = array(
            'site_id', 'key_test', 'key_prod', 'ctx_mode',
            'capture_delay', 'validation_mode', 'return_mode', 'redirect_enabled',
            'redirect_success_timeout', 'redirect_success_message', 'redirect_error_timeout',
            'redirect_error_message', 'sign_algo'
        );

        foreach ($configParams as $configParam) {
            $data[$configParam] = $oConfig->getConfigParam('PAYZEN_' . strtoupper($configParam)) ;
        }

        // Process payment page language.
        $lang = strtolower(oxRegistry::getLang()->getLanguageAbbr($oLang));
        $data['language'] = ($lang && PayzenApi::isSupportedLanguage($lang)) ? $lang : $oConfig->getConfigParam('PAYZEN_LANGUAGE');
        $data['available_languages'] = $this->_getAvailableMultiConf($oConfig->getConfigParam('PAYZEN_AVAILABLE_LANGUAGES'), PayzenApi::getSupportedLanguages());
        $data['payment_cards'] = $this->_getAvailableMultiConf($oConfig->getConfigParam('PAYZEN_PAYMENT_CARDS'), PayzenApi::getSupportedCardTypes());

        // Customer IDs.
        $data['cust_id'] = $oOrder->oxorder__oxuserid->value;
        $data['cust_email'] = $oOrder->oxorder__oxbillemail->value;

        // Billing address.
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

            // Send state ISO code.
            $bState = $oState->oxstates__oxisoalpha2->value;
        }

        $data['cust_state'] = $bState;

        $bCountry = null;
        if ($oOrder->oxorder__oxdelcountryid->value) {
            $oCountry = oxNew('oxCountry');
            $oCountry->load($oOrder->oxorder__oxdelcountryid->value);

            // Send country ISO code.
            $bCountry = $oCountry->oxcountry__oxisoalpha2->value;
        }

        $data['cust_country'] = $bCountry;

        // Shipping address.
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
            // Shipping address is the same as billing address.
            $data['ship_to_first_name'] = $oOrder->oxorder__oxbillfname->value;
            $data['ship_to_last_name'] = $oOrder->oxorder__oxbilllname->value;
            $data['ship_to_street'] = $oOrder->oxorder__oxbillstreet->value . ' ' . $oOrder-> oxorder__oxbillstreetnr->value;
            $data['ship_to_zip'] = $oOrder->oxorder__oxbillzip->value;
            $data['ship_to_city'] = $oOrder->oxorder__oxbillcity->value;
            $data['ship_to_phone_num'] = $oOrder->oxorder__oxbillfon->value;
            $data['ship_to_state'] = $bState;
            $data['ship_to_country'] = $bCountry;
        }

        // Render payment request form.
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

    private function _getAvailableMultiConf($multiConf, $supportedConf)
    {
        $availableMultiConf = null;
        if (isset($multiConf) && is_array($multiConf) && ! empty($multiConf)) {
            if (! in_array(reset($multiConf), array_keys($supportedConf))) {
                // Array contain json string recover config with json_decode.
                $multiConf = json_decode(reset($multiConf));

                if (isset($multiConf) && is_array($multiConf) && ! empty($multiConf)) {
                    $availableMultiConf = implode(';', $multiConf);
                }
            } else {
                $availableMultiConf = implode(';', $multiConf);
            }
        }

        return $availableMultiConf;
    }
}
