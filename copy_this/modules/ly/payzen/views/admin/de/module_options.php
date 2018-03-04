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
		'SHOP_MODULE_GROUP_GATEWAY_ACCESS' => 'ZUGANG ZAHLUNGSSCHNITTSTELLE',
		'SHOP_MODULE_SITE_ID' => 'Shop ID',
		'HELP_SHOP_MODULE_SITE_ID' => 'Kennung, die von Ihrer Bank bereitgestellt wird.',
		'SHOP_MODULE_KEY_TEST' => 'Zertifikat im Testbetrieb',
		'HELP_SHOP_MODULE_KEY_TEST' => 'Zertifikat, das von Ihrer Bank zu Testzwecken bereitgestellt wird (im PayZen-System verfügbar).',
		'SHOP_MODULE_KEY_PROD' => 'Zertifikat im Produktivbetrieb',
		'HELP_SHOP_MODULE_KEY_PROD' => 'Von Ihrer Bank bereitgestelltes Zertifikat (im PayZen-System verfügbar).',
		'SHOP_MODULE_CTX_MODE' => 'Modus',
		// CONTEXT MODES
		'SHOP_MODULE_CTX_MODE_TEST' => 'TEST',
		'SHOP_MODULE_CTX_MODE_PRODUCTION' => 'PRODUKTION',
		'HELP_SHOP_MODULE_CTX_MODE' => 'Kontextmodus dieses Moduls.',
		'SHOP_MODULE_PLATFORM_URL' => 'Plattform-URL',
		'HELP_SHOP_MODULE_PLATFORM_URL' => 'Link zur Bezahlungsplattform.',
		'SHOP_MODULE_CHECK_URL' => 'Benachrichtigung-URL',
		'HELP_SHOP_MODULE_CHECK_URL' => 'URL vor Übertragung in Ihr PayZen prüfen.',

		// ADMINISTRATION INTERFACE -PAYMENT OPTIONS
		'SHOP_MODULE_GROUP_PAYMENT_PAGE' => 'ZAHLUNGSSEITE',
		'SHOP_MODULE_LANGUAGE' => 'Standardsprache',
		'HELP_SHOP_MODULE_LANGUAGE' => 'Wählen Sie bitte die Spracheinstellung der Zahlungsseiten aus.',
		// ORDERED AVAILABLE LANGUAGES
		'SHOP_MODULE_LANGUAGE_zh' => 'Chinesisch',
		'SHOP_MODULE_LANGUAGE_nl' => 'Holländisch',
		'SHOP_MODULE_LANGUAGE_en' => 'Englisch',
		'SHOP_MODULE_LANGUAGE_fr' => 'Französisch',
		'SHOP_MODULE_LANGUAGE_de' => 'Deutsch',
		'SHOP_MODULE_LANGUAGE_it' => 'Italienisch',
		'SHOP_MODULE_LANGUAGE_ja' => 'Japanisch',
		'SHOP_MODULE_LANGUAGE_pl' => 'Polnisch',
		'SHOP_MODULE_LANGUAGE_pt' => 'Portugiesisch',
		'SHOP_MODULE_LANGUAGE_ru' => 'Russisch',
		'SHOP_MODULE_LANGUAGE_es' => 'Spanisch',
		'SHOP_MODULE_LANGUAGE_sv' => 'Schwedisch',
		'SHOP_MODULE_LANGUAGE_tr' => 'Türkisch',
		'SHOP_MODULE_AVAILABLE_LANGUAGES' => 'Verfügbare Sprachen',
		'HELP_SHOP_MODULE_AVAILABLE_LANGUAGES' => 'Verfügbare Sprachen der Zahlungsseite. Nichts auswählen, um die Einstellung der Zahlungsplattform zu benutzen.',
		'SHOP_MODULE_CAPTURE_DELAY' => 'Einzugsfrist',
		'HELP_SHOP_MODULE_CAPTURE_DELAY' => 'Anzahl der Tage bis zum Einzug der Zahlung (Einstellung über Ihr PayZen-System).',
		'SHOP_MODULE_VALIDATION_MODE' => 'Bestätigungsmodus',
		'HELP_SHOP_MODULE_VALIDATION_MODE' => 'Bei manueller Eingabe müssen Sie Zahlungen manuell in Ihrem Banksystem bestätigen.',
		//VALIDATION MODE OPTIONS
		'SHOP_MODULE_VALIDATION_MODE_' => 'Einstellung Back Office',
		'SHOP_MODULE_VALIDATION_MODE_1' => 'Automatisch',
		'SHOP_MODULE_VALIDATION_MODE_2' => 'Manuell',
		'SHOP_MODULE_PAYMENT_CARDS' => 'Art der Kreditkarten',
		'HELP_SHOP_MODULE_PAYMENT_CARDS' => 'Liste der/die für die Zahlung verfügbare(n) Kartentyp(en), durch Semikolon getrennt.',

		// ADMINISTRATION INTERFACE -3DS SECURITY
		'SHOP_MODULE_GROUP_SELECTIVE_3DS' => 'SELEKTIVES 3DS',
		'SHOP_MODULE_3DS_MIN_AMOUNT' => 'Mindestbetrag zur Aktivierung von 3DS',
		'HELP_SHOP_MODULE_3DS_MIN_AMOUNT' => 'Muss für die Option Selektives 3-D Secure freigeschaltet sein.',

		// ADMINISTRATION INTERFACE -RETURN TO SHOP
		'SHOP_MODULE_GROUP_RETURN_TO_SHOP' => 'ZURÜCK ZUM SHOP',
		'SHOP_MODULE_REDIRECT_ENABLED' => 'Automatische Weiterleitung',
		'HELP_SHOP_MODULE_REDIRECT_ENABLED' => 'Ist diese Einstellung aktiviert, wird der Kunde am Ende des Bezahlvorgangs automatisch auf Ihre Seite weitergeleitet.',
		'SHOP_MODULE_REDIRECT_SUCCESS_TIMEOUT' => 'Zeitbeschränkung Weiterleitung im Erfolgsfall',
		'HELP_SHOP_MODULE_REDIRECT_SUCCESS_TIMEOUT' => 'Zeitspanne in Sekunden (0-300) bis zur automatischen Weiterleitung des Kunden auf Ihre Seite nach erfolgter Zahlung.',
		'SHOP_MODULE_REDIRECT_SUCCESS_MESSAGE' => 'Weiterleitungs-Nachricht im Erfolgsfall',
		'HELP_SHOP_MODULE_REDIRECT_SUCCESS_MESSAGE' => 'Nachricht, die nach erfolgter Zahlung und vor der Weiterleitung auf der Plattform angezeigt wird.',
		'SHOP_MODULE_REDIRECT_ERROR_TIMEOUT' => 'Zeitbeschränkung Weiterleitung nach Ablehnung',
		'HELP_SHOP_MODULE_REDIRECT_ERROR_TIMEOUT' => 'Zeitspanne in Sekunden (0-300) bis zur automatischen Weiterleitung des Kunden auf Ihre Seite nach fehlgeschlagener Zahlung.',
		'SHOP_MODULE_REDIRECT_ERROR_MESSAGE' => 'Weiterleitungs-Nachricht nach Ablehnung',
		'HELP_SHOP_MODULE_REDIRECT_ERROR_MESSAGE' => 'Nachricht, die nach fehlgeschlagener Zahlung und vor der Weiterleitung auf der Plattform angezeigt wird.',
		'SHOP_MODULE_RETURN_MODE' => 'Übermittlungs-Modus',
		'HELP_SHOP_MODULE_RETURN_MODE' => 'Methode, die zur Übermittlung des Zahlungsergebnisses von der Zahlungsschnittstelle an Ihren Shop verwendet wird.',
		'SHOP_MODULE_RETURN_MODE_GET' => 'GET',
		'SHOP_MODULE_RETURN_MODE_POST' => 'POST'
);