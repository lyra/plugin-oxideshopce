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
 * Metadata version.
 */
$sMetadataVersion = '1.1';

require_once(dirname(__FILE__) . '/core/api/lypayzenapi.php');
require_once(dirname(__FILE__) . '/core/lypayzentools.php');
$availableLanguages = PayzenApi::getSupportedLanguages();
$notificationUrl = oxRegistry::getConfig()->getSslShopUrl() . 'index.php?cl=lyPayzenResponse&fnc=callback';

/**
 * Module information.
 */
$aModule = array(
    'id' => 'payzen',
    'title' => lyPayzenTools::getDefault('GATEWAY_NAME'),
    'description' => array(
        'en' => 'Module that links OXID eShop system with PayZen secured payment gateway.<br />This module is compatible with PayZen <b>V2</b> gateway.',
        'de' => 'Modul, der das OXID eShop System mit PayZen sicherlicher Bezahlungsplattform verbindet.<br />Dieser Modul ist mit PayZen <b>V2</b> Plattform kompatibel.',
        'fr' => 'Module qui lie le système OXID eShop avec la plateforme de paiement sécurisé PayZen. <br />Ce module est compatible la plateforme PayZen <b>V2</b>.',
        'es' => 'Módulo que vincula el sistema OXID eShop con la pasarela de pago segura PayZen.<br /> Este módulo es compatible con la puerta de enlace PayZen <b>. V2 </b>.'
    ),
    'lang' => lyPayzenTools::getDefault('LANGUAGE'),
    'thumbnail' => 'logo.png',
    'version' => lyPayzenTools::getDefault('PLUGIN_VERSION'),
    'author' => 'Lyra Network',
    'email' => lyPayzenTools::getDefault('SUPPORT_EMAIL'),
    'url' => 'https://www.lyra.com/',

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
        array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_SITE_ID', 'type' => 'str', 'value' => lyPayzenTools::getDefault('SITE_ID'), 'position' => '1'),
        array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_KEY_TEST', 'type' => 'str', 'value' => lyPayzenTools::getDefault('KEY_TEST'), 'position' => '2'),
        array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_KEY_PROD', 'type' => 'str', 'value' => lyPayzenTools::getDefault('KEY_PROD'), 'position' => '3'),
        ! lyPayzenTools::$pluginFeatures['qualif'] ?
            array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_CTX_MODE', 'type' => 'select', 'constraints' => 'TEST|PRODUCTION', 'value' => lyPayzenTools::getDefault('CTX_MODE'), 'position' => '4')
            : array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_CTX_MODE', 'type' => 'select', 'constraints' => 'PRODUCTION', 'value' => 'PRODUCTION', 'position' => '4'),
        array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_SIGN_ALGO', 'type' => 'select', 'constraints' => 'SHA-1|SHA-256', 'value' => lyPayzenTools::getDefault('SIGN_ALGO'), 'position' => '5'),
        array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_CHECK_URL', 'type' => 'str', 'value' => $notificationUrl, 'position' => '6'),
        array('group' => 'PAYZEN_GATEWAY_ACCESS', 'name' => 'PAYZEN_PLATFORM_URL', 'type' => 'str', 'value' => lyPayzenTools::getDefault('GATEWAY_URL'), 'position' => '7'),

        array('group' => 'PAYZEN_PAYMENT_PAGE', 'name' => 'PAYZEN_LANGUAGE', 'type' => 'select', 'constraints' => implode('|', array_keys($availableLanguages)), 'value' => lyPayzenTools::getDefault('LANGUAGE'), 'position' => '1'),
        array('group' => 'PAYZEN_PAYMENT_PAGE', 'name' => 'PAYZEN_AVAILABLE_LANGUAGES', 'type' => 'arr', 'value' => array(), 'position' => '2'),
        array('group' => 'PAYZEN_PAYMENT_PAGE', 'name' => 'PAYZEN_CAPTURE_DELAY', 'type' => 'str', 'value' => '', 'position' => '3'),
        array('group' => 'PAYZEN_PAYMENT_PAGE', 'name' => 'PAYZEN_VALIDATION_MODE', 'type' => 'select', 'constraints' => '|0|1', 'value' => '', 'position' => '4'),
        array('group' => 'PAYZEN_PAYMENT_PAGE', 'name' => 'PAYZEN_PAYMENT_CARDS', 'type' => 'arr', 'value' => array(), 'position' => '5'),

        array('group' => 'PAYZEN_SELECTIVE_3DS', 'name' => 'PAYZEN_3DS_MIN_AMOUNT', 'type' => 'str', 'value' => '', 'position' => '6'),

        array('group' => 'PAYZEN_RETURN_TO_SHOP', 'name' => 'PAYZEN_REDIRECT_ENABLED', 'type' => 'bool', 'value' => 'false', 'position' => '1'),
        array('group' => 'PAYZEN_RETURN_TO_SHOP', 'name' => 'PAYZEN_REDIRECT_SUCCESS_TIMEOUT', 'type' => 'str', 'value' => '5', 'position' => '2'),
        array('group' => 'PAYZEN_RETURN_TO_SHOP', 'name' => 'PAYZEN_REDIRECT_SUCCESS_MESSAGE', 'type' => 'str', 'value' => 'Redirection to shop in a few seconds...', 'position' => '3'),
        array('group' => 'PAYZEN_RETURN_TO_SHOP', 'name' => 'PAYZEN_REDIRECT_ERROR_TIMEOUT', 'type' => 'str', 'value' => '5', 'position' => '4'),
        array('group' => 'PAYZEN_RETURN_TO_SHOP', 'name' => 'PAYZEN_REDIRECT_ERROR_MESSAGE', 'type' => 'str', 'value' => 'Redirection to shop in a few seconds...', 'position' => '5'),
        array('group' => 'PAYZEN_RETURN_TO_SHOP', 'name' => 'PAYZEN_RETURN_MODE', 'type' => 'select', 'constraints' => 'GET|POST', 'value' => 'GET', 'position' => '6')
    )
);

if (lyPayzenTools::$pluginFeatures['qualif']) {
    foreach ($aModule['settings'] as $key => $item) {
        if ($item['name'] == 'PAYZEN_KEY_TEST') {
            unset ($aModule['settings'][$key]);
            break;
        }
    }
}
