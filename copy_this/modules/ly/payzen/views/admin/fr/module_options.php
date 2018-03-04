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
		'SHOP_MODULE_GROUP_GATEWAY_ACCESS' => 'ACCÈS À LA PLATEFORME',
		'SHOP_MODULE_SITE_ID' => 'Identifiant boutique',
		'HELP_SHOP_MODULE_SITE_ID' => 'L\'identifiant fourni par PayZen.',
		'SHOP_MODULE_KEY_TEST' => 'Certificat en mode test',
		'HELP_SHOP_MODULE_KEY_TEST' => 'Certificat fourni par PayZen pour le mode test (disponible sur le Back Office PayZen).',
		'SHOP_MODULE_KEY_PROD' => 'Certificat en mode production',
		'HELP_SHOP_MODULE_KEY_PROD' => 'Certificat fourni par PayZen (disponible sur le Back Office PayZen après passage en production).',
		'SHOP_MODULE_CTX_MODE' => 'Mode',
		// CONTEXT MODES
		'SHOP_MODULE_CTX_MODE_TEST' => 'TEST',
		'SHOP_MODULE_CTX_MODE_PRODUCTION' => 'PRODUCTION',
		'HELP_SHOP_MODULE_CTX_MODE' => 'Mode de fonctionnement du module.',
		'SHOP_MODULE_PLATFORM_URL' => 'URL de la page de paiement',
		'HELP_SHOP_MODULE_PLATFORM_URL' => 'URL vers laquelle l\'acheteur sera redirigé pour le paiement.',
		'SHOP_MODULE_CHECK_URL' => 'URL serveur',
		'SHOP_MODULE_CHECK_URL' => 'URL de notification à copier dans le Back Office PayZen',

		// ADMINISTRATION INTERFACE -PAYMENT OPTIONS
		'SHOP_MODULE_GROUP_PAYMENT_PAGE' => 'PAGE DE PAIEMENT',
		'SHOP_MODULE_LANGUAGE' => 'Langue par défaut',
		'HELP_SHOP_MODULE_LANGUAGE' => 'Sélectionner la langue par défaut à utiliser sur la page de paiement.',
		// ORDERED AVAILABLE LANGUAGES
		'SHOP_MODULE_LANGUAGE_zh' => 'Chinois',
		'SHOP_MODULE_LANGUAGE_nl' => 'Néerlandais',
		'SHOP_MODULE_LANGUAGE_en' => 'Anglais',
		'SHOP_MODULE_LANGUAGE_fr' => 'Français',
		'SHOP_MODULE_LANGUAGE_de' => 'Allemand',
		'SHOP_MODULE_LANGUAGE_it' => 'Italien',
		'SHOP_MODULE_LANGUAGE_ja' => 'Japonais',
		'SHOP_MODULE_LANGUAGE_pl' => 'Polonais',
		'SHOP_MODULE_LANGUAGE_pt' => 'Portugais',
		'SHOP_MODULE_LANGUAGE_ru' => 'Russe',
		'SHOP_MODULE_LANGUAGE_es' => 'Espagnol',
		'SHOP_MODULE_LANGUAGE_sv' => 'Suédois',
		'SHOP_MODULE_LANGUAGE_tr' => 'Turc',
		'SHOP_MODULE_AVAILABLE_LANGUAGES' => 'Langues disponibles',
		'HELP_SHOP_MODULE_AVAILABLE_LANGUAGES' => 'Sélectionner les langues à proposer sur la page de paiement.',
		'SHOP_MODULE_CAPTURE_DELAY' => 'Délai avant remise en banque',
		'HELP_SHOP_MODULE_CAPTURE_DELAY' => 'Le nombre de jours avant la remise en banque (paramétrable sur votre Back Office PayZen).',
		'SHOP_MODULE_VALIDATION_MODE' => 'Mode de validation',
		'HELP_SHOP_MODULE_VALIDATION_MODE' => 'En mode manuel, vous devrez confirmer les paiements dans le Back Office PayZen.',
		//VALIDATION MODE OPTIONS
		'SHOP_MODULE_VALIDATION_MODE_' => 'Configuration Back Office',
		'SHOP_MODULE_VALIDATION_MODE_1' => 'Automatique',
		'SHOP_MODULE_VALIDATION_MODE_2' => 'Manuel',
		'SHOP_MODULE_PAYMENT_CARDS' => 'Types de carte',
		'HELP_SHOP_MODULE_PAYMENT_CARDS' => 'Le(s) type(s) de carte pouvant être utilisé(s) pour le paiement. Ne rien sélectionner pour utiliser la configuration de la plateforme.',

		// ADMINISTRATION INTERFACE -3DS SECURITY
		'SHOP_MODULE_GROUP_SELECTIVE_3DS' => '3DS SÉLECTIF',
		'SHOP_MODULE_3DS_MIN_AMOUNT' => 'Montant minimum pour lequel activer 3-DS',
		'HELP_SHOP_MODULE_3DS_MIN_AMOUNT' => 'Nécessite la souscription à l’option 3-D Secure sélectif.',

		// ADMINISTRATION INTERFACE -RETURN TO SHOP
		'SHOP_MODULE_GROUP_RETURN_TO_SHOP' => 'RETOUR À LA BOUTIQUE',
		'SHOP_MODULE_REDIRECT_ENABLED' => 'Redirection automatique',
		'HELP_SHOP_MODULE_REDIRECT_ENABLED' => 'Si activée, l\'acheteur sera redirigé automatiquement vers votre site à la fin du paiement.',
		'SHOP_MODULE_REDIRECT_SUCCESS_TIMEOUT' => 'Temps avant redirection (succès)',
		'HELP_SHOP_MODULE_REDIRECT_SUCCESS_TIMEOUT' => 'Temps en secondes (0-300) avant que l\'acheteur ne soit redirigé automatiquement vers votre site lorsque le paiement a réussi.',
		'SHOP_MODULE_REDIRECT_SUCCESS_MESSAGE' => 'Message avant redirection (succès)',
		'HELP_SHOP_MODULE_REDIRECT_SUCCESS_MESSAGE' => 'Message affiché sur la page de paiement avant redirection lorsque le paiement a réussi.',
		'SHOP_MODULE_REDIRECT_ERROR_TIMEOUT' => 'Temps avant redirection (échec)',
		'HELP_SHOP_MODULE_REDIRECT_ERROR_TIMEOUT' => 'Temps en secondes (0-300) avant que l\'acheteur ne soit redirigé automatiquement vers votre site lorsque le paiement a échoué.',
		'SHOP_MODULE_REDIRECT_ERROR_MESSAGE' => 'Message avant redirection (échec)',
		'HELP_SHOP_MODULE_REDIRECT_ERROR_MESSAGE' => 'Message affiché sur la page de paiement avant redirection, lorsque le paiement a échoué.',
		'SHOP_MODULE_RETURN_MODE' => 'Mode de retour',
		'HELP_SHOP_MODULE_RETURN_MODE' => 'Façon dont l\'acheteur transmettra le résultat du paiement lors de son retour à la boutique.',
		'SHOP_MODULE_RETURN_MODE_GET' => 'GET',
		'SHOP_MODULE_RETURN_MODE_POST' => 'POST'
);