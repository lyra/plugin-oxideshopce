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
 * Metadata version
 */
$sMetadataVersion = '1.0';

require_once(dirname(__FILE__) . '/core/api/lypayzenapi.php');
$availableLanguages = PayzenApi::getSupportedLanguages();
$notificationUrl = oxRegistry::getConfig()->getSslShopUrl() . 'index.php?cl=lyPayzenResponse&fnc=callback';

/**
 * Module information
 */
$aModule = array(
    'id' => 'payzen',
    'title' => 'PayZen',
    'description' => array(
        'en' => 'Module that links OXID eShop system with PayZen secured payment gateway.<br />This module is compatible with PayZen <b>V2</b> gateway.',
        'de' => 'Modul, der das OXID eShop System mit PayZen sicherlicher Bezahlungsplattform verbindet.<br />Dieser Modul ist mit PayZen <b>V2</b> Plattform kompatibel.',
        'fr' => 'Module qui lie le système OXID eShop avec la plateforme de paiement sécurisé PayZen. <br />Ce module est compatible la plateforme PayZen <b>V2</b>.'
    ),
    'lang' => 'fr',
    'thumbnail' => 'logo.png',
    'version' => '2.0.1',
    'author' => 'Lyra Network',
    'email' => 'support@payzen.eu',
    'url' => 'http://www.lyra-network.com/',

    'extend' => array(
        'module_config' => 'ly/payzen/controllers/admin/lypayzenmodule_config',
        'order' => 'ly/payzen/controllers/lypayzenorder',
        'payment' => 'ly/payzen/controllers/lypayzenpayment',
        'oxorder' => 'ly/payzen/models/lypayzenoxorder',
        'oxpaymentlist' => 'ly/payzen/models/lypayzenoxpaymentlist'
    ),

    'files' => array(
        'PayzenApi' => 'ly/payzen/core/api/lypayzenapi.php',
        'PayzenResponse' => 'ly/payzen/core/api/lypayzenresponse.php',
        'PayzenRequest' => 'ly/payzen/core/api/lypayzenrequest.php',
        'PayzenCurrency' => 'ly/payzen/core/api/lypayzencurrency.php',
        'PayzenField' => 'ly/payzen/core/api/lypayzenfield.php',
        'lyPayzenLogger' => 'ly/payzen/core/lypayzenlogger.php',
        'lyPayzenEvents' => 'ly/payzen/core/lypayzenevents.php',

        'lyPayzenRedirect' => 'ly/payzen/controllers/lypayzenredirect.php',
        'lyPayzenResponse' => 'ly/payzen/controllers/lypayzenresponse.php'
    ),

    'events' => array(
        'onActivate' => 'lyPayzenEvents::onActivate',
        'onDeactivate' => 'lyPayzenEvents::onDeactivate'
    ),

    'templates' => array(
        'lypayzentemplateredirect.tpl' => 'ly/payzen/views/tpl/lypayzentemplateredirect.tpl'
    ),

    'blocks' => array(
        array('template' => 'page/checkout/payment.tpl', 'block' => 'select_payment', 'file' => '/views/blocks/page/checkout/lypayzen_select_payment.tpl'),
        array('template' => 'order_main.tpl', 'block' => 'admin_order_main_form', 'file' => '/views/admin/blocks/lypayzen_admin_order_main_form.tpl'),
        array('template' => 'module_config.tpl', 'block' => 'admin_module_config_var_type_arr', 'file' => '/views/admin/blocks/lypayzen_admin_module_config_var_type_arr.tpl')
    ),

    'settings' => array(
        array('group' => 'GATEWAY_ACCESS', 'name' => 'SITE_ID', 'type' => 'str', 'value' => '12345678', 'position' => '1'),
        array('group' => 'GATEWAY_ACCESS', 'name' => 'KEY_TEST', 'type' => 'str', 'value' => '1111111111111111', 'position' => '2'),
        array('group' => 'GATEWAY_ACCESS', 'name' => 'KEY_PROD', 'type' => 'str', 'value' => '2222222222222222', 'position' => '3'),
        array('group' => 'GATEWAY_ACCESS', 'name' => 'CTX_MODE', 'type' => 'select', 'constraints' => 'TEST|PRODUCTION', 'value' => 'TEST', 'position' => '4'),
        array('group' => 'GATEWAY_ACCESS', 'name' => 'CHECK_URL', 'type' => 'str', 'value' => $notificationUrl, 'position' => '6'),
        array('group' => 'GATEWAY_ACCESS', 'name' => 'PLATFORM_URL', 'type' => 'str', 'value' => 'https://secure.payzen.eu/vads-payment/', 'position' => '5'),

        array('group' => 'PAYMENT_PAGE', 'name' => 'LANGUAGE', 'type' => 'select', 'constraints' => implode('|', array_keys($availableLanguages)), 'value' => 'fr', 'position' => '1'),
        array('group' => 'PAYMENT_PAGE', 'name' => 'AVAILABLE_LANGUAGES', 'type' => 'arr', 'value' => array(), 'position' => '2'),
        array('group' => 'PAYMENT_PAGE', 'name' => 'CAPTURE_DELAY', 'type' => 'str', 'value' => '', 'position' => '3'),
        array('group' => 'PAYMENT_PAGE', 'name' => 'VALIDATION_MODE', 'type' => 'select','constraints' => '|0|1', 'value' => '', 'position' => '4'),
        array('group' => 'PAYMENT_PAGE', 'name' => 'PAYMENT_CARDS', 'type' => 'arr', 'value' => array() , 'position' => '5'),

        array('group' => 'SELECTIVE_3DS', 'name' => '3DS_MIN_AMOUNT', 'type' => 'str', 'value' => '', 'position' => '6'),

        array('group' => 'RETURN_TO_SHOP', 'name' => 'REDIRECT_ENABLED', 'type' => 'bool', 'value' => 'false', 'position' => '1'),
        array('group' => 'RETURN_TO_SHOP', 'name' => 'REDIRECT_SUCCESS_TIMEOUT', 'type' => 'str', 'value' => '5', 'position' => '2'),
        array('group' => 'RETURN_TO_SHOP', 'name' => 'REDIRECT_SUCCESS_MESSAGE', 'type' => 'str', 'value' => 'Redirection to shop in a few seconds...', 'position' => '3'),
        array('group' => 'RETURN_TO_SHOP', 'name' => 'REDIRECT_ERROR_TIMEOUT', 'type' => 'str', 'value' => '5', 'position' => '4'),
        array('group' => 'RETURN_TO_SHOP', 'name' => 'REDIRECT_ERROR_MESSAGE', 'type' => 'str', 'value' => 'Redirection to shop in a few seconds...', 'position' => '5'),
        array('group' => 'RETURN_TO_SHOP', 'name' => 'RETURN_MODE', 'type' => 'select', 'constraints' => 'GET|POST', 'value' => 'GET', 'position' => '6')
    )
);
