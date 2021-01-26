<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

$aLang = array (
    'charset' => 'UTF-8',

    // ADMINISTRATION INTERFACE - GATEWAY ACCESS.
    'SHOP_MODULE_GROUP_PAYZEN_GATEWAY_ACCESS' => 'PAYMENT GATEWAY ACCESS',
    'SHOP_MODULE_PAYZEN_SITE_ID' => 'Shop ID',
    'HELP_SHOP_MODULE_PAYZEN_SITE_ID' => 'The identifier provided by PayZen.',
    'SHOP_MODULE_PAYZEN_KEY_TEST' => 'Key in test mode',
    'HELP_SHOP_MODULE_PAYZEN_KEY_TEST' => 'Key provided by PayZen for test mode (available in PayZen Back Office).',
    'SHOP_MODULE_PAYZEN_KEY_PROD' => 'Key in production mode',
    'HELP_SHOP_MODULE_PAYZEN_KEY_PROD' => 'Key provided by PayZen (available in PayZen Back Office after enabling production mode).',
    'SHOP_MODULE_PAYZEN_CTX_MODE' => 'Mode',
    'SHOP_MODULE_PAYZEN_CTX_MODE_TEST' => 'TEST',
    'SHOP_MODULE_PAYZEN_CTX_MODE_PRODUCTION' => 'PRODUCTION',
    'HELP_SHOP_MODULE_PAYZEN_CTX_MODE' => 'The context mode of this module.',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Signature algorithm',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-1' => 'SHA-1',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-256' => 'HMAC-SHA-256',
    'HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Algorithm used to compute the payment form signature. Selected algorithm must be the same as one configured in the PayZen Back Office.',
    'SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'Payment page URL',
    'HELP_SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'Link to the payment page.',
    'SHOP_MODULE_PAYZEN_CHECK_URL' => 'Instant Payment Notification URL',
    'HELP_SHOP_MODULE_PAYZEN_CHECK_URL' => 'URL to copy into your PayZen Back Office > Settings > Notification rules.',

    // ADMINISTRATION INTERFACE - PAYMENT PAGE.
    'SHOP_MODULE_GROUP_PAYZEN_PAYMENT_PAGE' => 'PAYMENT PAGE',
    'SHOP_MODULE_PAYZEN_LANGUAGE' => 'Default language',
    'HELP_SHOP_MODULE_PAYZEN_LANGUAGE' => 'Default language on the payment page.',
    'SHOP_MODULE_PAYZEN_LANGUAGE_zh' => 'Chinese',
    'SHOP_MODULE_PAYZEN_LANGUAGE_nl' => 'Dutch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_en' => 'English',
    'SHOP_MODULE_PAYZEN_LANGUAGE_fr' => 'French',
    'SHOP_MODULE_PAYZEN_LANGUAGE_de' => 'German',
    'SHOP_MODULE_PAYZEN_LANGUAGE_it' => 'Italian',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ja' => 'Japanese',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pl' => 'Polish',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pt' => 'Portuguese',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ru' => 'Russian',
    'SHOP_MODULE_PAYZEN_LANGUAGE_es' => 'Spanish',
    'SHOP_MODULE_PAYZEN_LANGUAGE_sv' => 'Swedish',
    'SHOP_MODULE_PAYZEN_LANGUAGE_tr' => 'Turkish',
    'SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Available languages',
    'HELP_SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Languages available on the payment page. If you do not select any, all the supported languages will be available.',
    'SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'Capture delay',
    'HELP_SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'The number of days before the bank capture (adjustable in your PayZen Back Office).',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'Validation mode',
    'HELP_SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'If manual is selected, you will have to confirm payments manually in your PayZen Back Office.',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_' => 'Back Office configuration',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_0' => 'Automatic',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_1' => 'Manual',
    'SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'Card Types',
    'HELP_SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'The card type(s) that can be used for the payment. Select none to use gateway configuration.',

    // ADMINISTRATION INTERFACE - SELECTIVE 3DS.
    'SHOP_MODULE_GROUP_PAYZEN_SELECTIVE_3DS' => 'SELECTIVE 3DS',
    'SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Disable 3DS',
    'HELP_SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Amount below which 3DS will be disabled. Needs subscription to selective 3DS option. For more information, refer to the module documentation.',

    // ADMINISTRATION INTERFACE - RETURN TO SHOP.
    'SHOP_MODULE_GROUP_PAYZEN_RETURN_TO_SHOP' => 'RETURN TO SHOP',
    'SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Automatic redirection',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'If enabled, the buyer is automatically redirected to your site at the end of the payment.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Redirection timeout on success',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Time in seconds (0-300) before the buyer is automatically redirected to your website after a successful payment.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Redirection message on success',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Message displayed on the payment page prior to redirection after a successful payment.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Redirection timeout on failure',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Time in seconds (0-300) before the buyer is automatically redirected to your website after a declined payment.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Redirection message on failure',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Message displayed on the payment page prior to redirection after a declined payment.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Return mode',
    'HELP_SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Method that will be used for transmitting the payment result from the payment page to your shop.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_GET' => 'GET',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_POST' => 'POST'
);

require_once(dirname(__FILE__) . '/../../../core/lypayzentools.php');
if (! lyPayzenTools::$pluginFeatures['shatwo']) {
    $aLang['HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO'] .= '<br /><b>The HMAC-SHA-256 algorithm should not be activated if it is not yet available in the PayZen Back Office, the feature will be available soon.</b>';
}
