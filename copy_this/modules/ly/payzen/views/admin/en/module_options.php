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

$aLang = array (
		'charset' => 'UTF-8',

		// ADMINISTRATION INTERFACE - PARAMETERS
		'SHOP_MODULE_GROUP_GATEWAY_ACCESS' => 'PAYMENT PLATFORM ACCESS',
		'SHOP_MODULE_SITE_ID' => 'Shop ID',
		'HELP_SHOP_MODULE_SITE_ID' => 'The identifier provided by PayZen.',
		'SHOP_MODULE_KEY_TEST' => 'Certificate in test mode',
		'HELP_SHOP_MODULE_KEY_TEST' => 'Certificate provided by PayZen for test mode (available in PayZen Back Office).',
		'SHOP_MODULE_KEY_PROD' => 'Certificate in production mode',
		'HELP_SHOP_MODULE_KEY_PROD' => 'Certificate provided by PayZen (available in PayZen Back Office after enabling production mode).',
		'SHOP_MODULE_CTX_MODE' => 'Mode',
		// CONTEXT MODES
		'SHOP_MODULE_CTX_MODE_TEST' => 'TEST',
		'SHOP_MODULE_CTX_MODE_PRODUCTION' => 'PRODUCTION',
		'HELP_SHOP_MODULE_CTX_MODE' => 'The context mode of this module.',
		'SHOP_MODULE_PLATFORM_URL' => 'Payment page URL',
		'HELP_SHOP_MODULE_PLATFORM_URL' => 'Link to the payment page.',
		'SHOP_MODULE_CHECK_URL' => 'Notification URL',
		'HELP_SHOP_MODULE_CHECK_URL' => 'Instant Payment Notification URL to copy into your PayZen Back Office',

		// ADMINISTRATION INTERFACE -PAYMENT OPTIONS
		'SHOP_MODULE_GROUP_PAYMENT_PAGE' => 'PAYMENT PAGE',
		'SHOP_MODULE_LANGUAGE' => 'Default language',
		'HELP_SHOP_MODULE_LANGUAGE' => 'Default language on the payment page.',
		// ORDERED AVAILABLE LANGUAGES
		'SHOP_MODULE_LANGUAGE_zh' => 'Chinese',
		'SHOP_MODULE_LANGUAGE_nl' => 'Dutch',
		'SHOP_MODULE_LANGUAGE_en' => 'English',
		'SHOP_MODULE_LANGUAGE_fr' => 'French',
		'SHOP_MODULE_LANGUAGE_de' => 'German',
		'SHOP_MODULE_LANGUAGE_it' => 'Italian',
		'SHOP_MODULE_LANGUAGE_ja' => 'Japanese',
		'SHOP_MODULE_LANGUAGE_pl' => 'Polish',
		'SHOP_MODULE_LANGUAGE_pt' => 'Portuguese',
		'SHOP_MODULE_LANGUAGE_ru' => 'Russian',
		'SHOP_MODULE_LANGUAGE_es' => 'Spanish',
		'SHOP_MODULE_LANGUAGE_sv' => 'Swedish',
		'SHOP_MODULE_LANGUAGE_tr' => 'Turkish',
		'SHOP_MODULE_AVAILABLE_LANGUAGES' => 'Available languages',
		'HELP_SHOP_MODULE_AVAILABLE_LANGUAGES' => 'Languages available on the payment page. If you do not select any, all the supported languages will be available.',
		'SHOP_MODULE_CAPTURE_DELAY' => 'Capture delay',
		'HELP_SHOP_MODULE_CAPTURE_DELAY' => 'The number of days before the bank capture (adjustable in your PayZen Back Office).',
		'SHOP_MODULE_VALIDATION_MODE' => 'Validation mode',
		'HELP_SHOP_MODULE_VALIDATION_MODE' => 'If manual is selected, you will have to confirm payments manually in your PayZen Back Office.',
		//VALIDATION MODE OPTIONS
		'SHOP_MODULE_VALIDATION_MODE_' => 'Back Office configuration',
		'SHOP_MODULE_VALIDATION_MODE_1' => 'Automatic',
		'SHOP_MODULE_VALIDATION_MODE_2' => 'Manual',
		'SHOP_MODULE_PAYMENT_CARDS' => 'Card Types',
		'HELP_SHOP_MODULE_PAYMENT_CARDS' => 'The card type(s) that can be used for the payment. Select none to use platform configuration.',

		// ADMINISTRATION INTERFACE -3DS SECURITY
		'SHOP_MODULE_GROUP_SELECTIVE_3DS' => 'SELECTIVE 3DS',
		'SHOP_MODULE_3DS_MIN_AMOUNT' => 'Minimum amount to activate 3DS',
		'HELP_SHOP_MODULE_3DS_MIN_AMOUNT' => 'Needs subscription to Selective 3-D Secure option.',

		// ADMINISTRATION INTERFACE -RETURN TO SHOP
		'SHOP_MODULE_GROUP_RETURN_TO_SHOP' => 'RETURN TO SHOP',
		'SHOP_MODULE_REDIRECT_ENABLED' => 'Automatic redirection',
		'HELP_SHOP_MODULE_REDIRECT_ENABLED' => 'If enabled, the buyer is automatically redirected to your site at the end of the payment.',
		'SHOP_MODULE_REDIRECT_SUCCESS_TIMEOUT' => 'Redirection timeout on success',
		'HELP_SHOP_MODULE_REDIRECT_SUCCESS_TIMEOUT' => 'Time in seconds (0-300) before the buyer is automatically redirected to your website after a successful payment.',
		'SHOP_MODULE_REDIRECT_SUCCESS_MESSAGE' => 'Redirection message on success',
		'HELP_SHOP_MODULE_REDIRECT_SUCCESS_MESSAGE' => 'Message displayed on the payment page prior to redirection after a successful payment.',
		'SHOP_MODULE_REDIRECT_ERROR_TIMEOUT' => 'Redirection timeout on failure',
		'HELP_SHOP_MODULE_REDIRECT_ERROR_TIMEOUT' => 'Time in seconds (0-300) before the buyer is automatically redirected to your website after a declined payment.',
		'SHOP_MODULE_REDIRECT_ERROR_MESSAGE' => 'Redirection message on failure',
		'HELP_SHOP_MODULE_REDIRECT_ERROR_MESSAGE' => 'Message displayed on the payment page prior to redirection after a declined payment.',
		'SHOP_MODULE_RETURN_MODE' => 'Return mode',
		'HELP_SHOP_MODULE_RETURN_MODE' => 'Method that will be used for transmitting the payment result from the payment page to your shop.',
		'SHOP_MODULE_RETURN_MODE_GET' => 'GET',
		'SHOP_MODULE_RETURN_MODE_POST' => 'POST'
);