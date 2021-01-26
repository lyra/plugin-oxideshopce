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
    'SHOP_MODULE_GROUP_PAYZEN_GATEWAY_ACCESS' => 'ACCÈS À LA PLATEFORME',
    'SHOP_MODULE_PAYZEN_SITE_ID' => 'Identifiant de la boutique',
    'HELP_SHOP_MODULE_PAYZEN_SITE_ID' => 'L\'identifiant fourni par PayZen.',
    'SHOP_MODULE_PAYZEN_KEY_TEST' => 'Clé en mode test',
    'HELP_SHOP_MODULE_PAYZEN_KEY_TEST' => 'Clé fourni par PayZen pour le mode test (disponible sur le Back Office PayZen).',
    'SHOP_MODULE_PAYZEN_KEY_PROD' => 'Clé en mode production',
    'HELP_SHOP_MODULE_PAYZEN_KEY_PROD' => 'Clé fourni par PayZen (disponible sur le Back Office PayZen après passage en production).',
    'SHOP_MODULE_PAYZEN_CTX_MODE' => 'Mode',
    'SHOP_MODULE_PAYZEN_CTX_MODE_TEST' => 'TEST',
    'SHOP_MODULE_PAYZEN_CTX_MODE_PRODUCTION' => 'PRODUCTION',
    'HELP_SHOP_MODULE_PAYZEN_CTX_MODE' => 'Mode de fonctionnement du module.',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Algorithme de signature',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-1' => 'SHA-1',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-256' => 'HMAC-SHA-256',
    'HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Algorithme utilisé pour calculer la signature du formulaire de paiement. L\'algorithme sélectionné doit être le même que celui configuré sur le Back Office PayZen.',
    'SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'URL de la page de paiement',
    'HELP_SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'URL vers laquelle l\'acheteur sera redirigé pour le paiement.',
    'SHOP_MODULE_PAYZEN_CHECK_URL' => 'URL de notification',
    'HELP_SHOP_MODULE_PAYZEN_CHECK_URL' => 'URL à copier dans le Back Office PayZen > Paramétrage > Règles de notifications.',

    // ADMINISTRATION INTERFACE - PAYMENT PAGE.
    'SHOP_MODULE_GROUP_PAYZEN_PAYMENT_PAGE' => 'PAGE DE PAIEMENT',
    'SHOP_MODULE_PAYZEN_LANGUAGE' => 'Langue par défaut',
    'HELP_SHOP_MODULE_PAYZEN_LANGUAGE' => 'Sélectionner la langue par défaut à utiliser sur la page de paiement.',
    'SHOP_MODULE_PAYZEN_LANGUAGE_zh' => 'Chinois',
    'SHOP_MODULE_PAYZEN_LANGUAGE_nl' => 'Néerlandais',
    'SHOP_MODULE_PAYZEN_LANGUAGE_en' => 'Anglais',
    'SHOP_MODULE_PAYZEN_LANGUAGE_fr' => 'Français',
    'SHOP_MODULE_PAYZEN_LANGUAGE_de' => 'Allemand',
    'SHOP_MODULE_PAYZEN_LANGUAGE_it' => 'Italien',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ja' => 'Japonais',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pl' => 'Polonais',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pt' => 'Portugais',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ru' => 'Russe',
    'SHOP_MODULE_PAYZEN_LANGUAGE_es' => 'Espagnol',
    'SHOP_MODULE_PAYZEN_LANGUAGE_sv' => 'Suédois',
    'SHOP_MODULE_PAYZEN_LANGUAGE_tr' => 'Turc',
    'SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Langues disponibles',
    'HELP_SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Sélectionner les langues à proposer sur la page de paiement. Ne rien sélectionner pour utiliser la configuration de la plateforme.',
    'SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'Délai avant remise en banque',
    'HELP_SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'Le nombre de jours avant la remise en banque (paramétrable sur votre Back Office PayZen).',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'Mode de validation',
    'HELP_SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'En mode manuel, vous devrez confirmer les paiements dans le Back Office PayZen.',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_' => 'Configuration Back Office',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_0' => 'Automatique',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_1' => 'Manuel',
    'SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'Types de carte',
    'HELP_SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'Le(s) type(s) de carte pouvant être utilisé(s) pour le paiement. Ne rien sélectionner pour utiliser la configuration de la plateforme.',

    // ADMINISTRATION INTERFACE - SELECTIVE 3DS.
    'SHOP_MODULE_GROUP_PAYZEN_SELECTIVE_3DS' => '3DS SÉLECTIF',
    'SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Désactiver 3DS',
    'HELP_SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Montant en dessous duquel 3DS sera désactivé. Nécessite la souscription à l\'option 3DS sélectif. Pour plus d\'informations, reportez-vous à la documentation du module.',

    // ADMINISTRATION INTERFACE - RETURN TO SHOP.
    'SHOP_MODULE_GROUP_PAYZEN_RETURN_TO_SHOP' => 'RETOUR À LA BOUTIQUE',
    'SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Redirection automatique',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Si activée, l\'acheteur sera redirigé automatiquement vers votre site à la fin du paiement.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Temps avant redirection (succès)',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Temps en secondes (0-300) avant que l\'acheteur ne soit redirigé automatiquement vers votre site lorsque le paiement a réussi.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Message avant redirection (succès)',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Message affiché sur la page de paiement avant redirection lorsque le paiement a réussi.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Temps avant redirection (échec)',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Temps en secondes (0-300) avant que l\'acheteur ne soit redirigé automatiquement vers votre site lorsque le paiement a échoué.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Message avant redirection (échec)',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Message affiché sur la page de paiement avant redirection, lorsque le paiement a échoué.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Mode de retour',
    'HELP_SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Façon dont l\'acheteur transmettra le résultat du paiement lors de son retour à la boutique.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_GET' => 'GET',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_POST' => 'POST'
);

require_once(dirname(__FILE__) . '/../../../core/lypayzentools.php');
if (! lyPayzenTools::$pluginFeatures['shatwo']) {
    $aLang['HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO'] .= '<br /><b>Le HMAC-SHA-256 ne doit pas être activé si celui-ci n\'est pas encore disponible depuis le Back Office PayZen, la fonctionnalité sera disponible prochainement.</b>';
}
