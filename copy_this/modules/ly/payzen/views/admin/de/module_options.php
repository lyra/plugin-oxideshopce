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
    'SHOP_MODULE_GROUP_PAYZEN_GATEWAY_ACCESS' => 'ZUGANG ZAHLUNGSSCHNITTSTELLE',
    'SHOP_MODULE_PAYZEN_SITE_ID' => 'Shop ID',
    'HELP_SHOP_MODULE_PAYZEN_SITE_ID' => 'Kennung, die von Ihrer Bank bereitgestellt wird.',
    'SHOP_MODULE_PAYZEN_KEY_TEST' => 'Schlüssel im Testbetrieb',
    'HELP_SHOP_MODULE_PAYZEN_KEY_TEST' => 'Schlüssel, das von Ihrer Bank zu Testzwecken bereitgestellt wird (im PayZen Back Office verfügbar).',
    'SHOP_MODULE_PAYZEN_KEY_PROD' => 'Schlüssel im Produktivbetrieb',
    'HELP_SHOP_MODULE_PAYZEN_KEY_PROD' => 'Schlüssel, das von PayZen zu Testzwecken bereitgestellt wird (im PayZen Back Office verfügbar).',
    'SHOP_MODULE_PAYZEN_CTX_MODE' => 'Modus',
    'SHOP_MODULE_PAYZEN_CTX_MODE_TEST' => 'TEST',
    'SHOP_MODULE_PAYZEN_CTX_MODE_PRODUCTION' => 'PRODUKTION',
    'HELP_SHOP_MODULE_PAYZEN_CTX_MODE' => 'Kontextmodus dieses Moduls.',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Signaturalgorithmus',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-1' => 'SHA-1',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-256' => 'HMAC-SHA-256',
    'HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Algorithmus zur Berechnung der Zahlungsformsignatur. Der ausgewählte Algorithmus muss derselbe sein, wie er im PayZen Back Office.',
    'SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'Plattform-URL',
    'HELP_SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'Link zur Bezahlungsplattform.',
    'SHOP_MODULE_PAYZEN_CHECK_URL' => 'Benachrichtigung-URL',
    'HELP_SHOP_MODULE_PAYZEN_CHECK_URL' => 'URL, die Sie in Ihre PayZen Back Office kopieren sollen > Einstellung > Regeln der Benachrichtigungen.',

    // ADMINISTRATION INTERFACE - PAYMENT PAGE.
    'SHOP_MODULE_GROUP_PAYZEN_PAYMENT_PAGE' => 'ZAHLUNGSSEITE',
    'SHOP_MODULE_PAYZEN_LANGUAGE' => 'Standardsprache',
    'HELP_SHOP_MODULE_PAYZEN_LANGUAGE' => 'Wählen Sie bitte die Spracheinstellung der Zahlungsseiten aus.',
    'SHOP_MODULE_PAYZEN_LANGUAGE_zh' => 'Chinesisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_nl' => 'Holländisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_en' => 'Englisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_fr' => 'Französisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_de' => 'Deutsch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_it' => 'Italienisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ja' => 'Japanisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pl' => 'Polnisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pt' => 'Portugiesisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ru' => 'Russisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_es' => 'Spanisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_sv' => 'Schwedisch',
    'SHOP_MODULE_PAYZEN_LANGUAGE_tr' => 'Türkisch',
    'SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Verfügbare Sprachen',
    'HELP_SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Verfügbare Sprachen der Zahlungsseite. Nichts auswählen, um die Einstellung der Zahlungsplattform zu benutzen.',
    'SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'Einzugsfrist',
    'HELP_SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'Anzahl der Tage bis zum Einzug der Zahlung (Einstellung über Ihr PayZen Back Office).',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'Bestätigungsmodus',
    'HELP_SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'Bei manueller Eingabe müssen Sie Zahlungen manuell in Ihrem Banksystem bestätigen.',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_' => 'Einstellung Back Office',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_0' => 'Automatisch',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_1' => 'Manuell',
    'SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'Kartentypen',
    'HELP_SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'Wählen Sie die zur Zahlung verfügbaren Kartentypen aus. Nichts auswählen, um die Einstellungen der Plattform zu verwenden.',

    // ADMINISTRATION INTERFACE - SELECTIVE 3DS.
    'SHOP_MODULE_GROUP_PAYZEN_SELECTIVE_3DS' => 'SELEKTIVES 3DS',
    'SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => '3DS deaktivieren',
    'HELP_SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Betrag, unter dem 3DS deaktiviert wird. Muss für die Option Selektives 3DS freigeschaltet sein. Weitere Informationen finden Sie in der Moduldokumentation.',

    // ADMINISTRATION INTERFACE - RETURN TO SHOP.
    'SHOP_MODULE_GROUP_PAYZEN_RETURN_TO_SHOP' => 'ZURÜCK ZUM SHOP',
    'SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Automatische Weiterleitung',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Ist diese Einstellung aktiviert, wird der Kunde am Ende des Bezahlvorgangs automatisch auf Ihre Seite weitergeleitet.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Zeitbeschränkung Weiterleitung im Erfolgsfall',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Zeitspanne in Sekunden (0-300) bis zur automatischen Weiterleitung des Kunden auf Ihre Seite nach erfolgter Zahlung.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Weiterleitungs-Nachricht im Erfolgsfall',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Nachricht, die nach erfolgter Zahlung und vor der Weiterleitung auf der Plattform angezeigt wird.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Zeitbeschränkung Weiterleitung nach Ablehnung',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Zeitspanne in Sekunden (0-300) bis zur automatischen Weiterleitung des Kunden auf Ihre Seite nach fehlgeschlagener Zahlung.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Weiterleitungs-Nachricht nach Ablehnung',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Nachricht, die nach fehlgeschlagener Zahlung und vor der Weiterleitung auf der Plattform angezeigt wird.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Übermittlungs-Modus',
    'HELP_SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Methode, die zur Übermittlung des Zahlungsergebnisses von der Zahlungsschnittstelle an Ihren Shop verwendet wird.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_GET' => 'GET',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_POST' => 'POST'
);

require_once(dirname(__FILE__) . '/../../../core/lypayzentools.php');
if (! lyPayzenTools::$pluginFeatures['shatwo']) {
    $aLang['HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO'] .= '<br /><b>Der HMAC-SHA-256-Algorithmus sollte nicht aktiviert werden, wenn er noch nicht im PayZen Back Office verfügbar ist. Die Funktion wird in Kürze verfügbar sein.</b>';
}
