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
    'SHOP_MODULE_GROUP_PAYZEN_GATEWAY_ACCESS' => 'ACCESO AL PORTAL DE PAGO',
    'SHOP_MODULE_PAYZEN_SITE_ID' => 'Identificador de tienda',
    'HELP_SHOP_MODULE_PAYZEN_SITE_ID' => 'El identificador proporcionado por PayZen.',
    'SHOP_MODULE_PAYZEN_KEY_TEST' => 'Clave en modo test',
    'HELP_SHOP_MODULE_PAYZEN_KEY_TEST' => 'Clave proporcionada por PayZen para modo test (disponible en el Back Office PayZen).',
    'SHOP_MODULE_PAYZEN_KEY_PROD' => 'Clave en modo production',
    'HELP_SHOP_MODULE_PAYZEN_KEY_PROD' => 'Clave proporcionada por PayZen para modo test (disponible en el Back Office PayZen).',
    'SHOP_MODULE_PAYZEN_CTX_MODE' => 'Modo',
    'SHOP_MODULE_PAYZEN_CTX_MODE_TEST' => 'TEST',
    'SHOP_MODULE_PAYZEN_CTX_MODE_PRODUCTION' => 'PRODUCTION',
    'HELP_SHOP_MODULE_PAYZEN_CTX_MODE' => 'El modo de contexto de este módulo.',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Algoritmo de firma',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-1' => 'SHA-1',
    'SHOP_MODULE_PAYZEN_SIGN_ALGO_SHA-256' => 'HMAC-SHA-256',
    'HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO' => 'Algoritmo usado para calcular la firma del formulario de pago. El algoritmo seleccionado debe ser el mismo que el configurado en el Back Office PayZen.',
    'SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'URL de página de pago',
    'HELP_SHOP_MODULE_PAYZEN_PLATFORM_URL' => 'Enlace a la página de pago.',
    'SHOP_MODULE_PAYZEN_CHECK_URL' => 'URL de notificación de pago instantáneo.',
    'HELP_SHOP_MODULE_PAYZEN_CHECK_URL' => 'URL a copiar en el Back Office PayZen > Configuración > Reglas de notificación.',

    // ADMINISTRATION INTERFACE - PAYMENT PAGE.
    'SHOP_MODULE_GROUP_PAYZEN_PAYMENT_PAGE' => 'PÁGINA DE PAGO',
    'SHOP_MODULE_PAYZEN_LANGUAGE' => 'Idioma por defecto',
    'HELP_SHOP_MODULE_PAYZEN_LANGUAGE' => 'Idioma por defecto en la página de pago.',
    'SHOP_MODULE_PAYZEN_LANGUAGE_zh' => 'Chino',
    'SHOP_MODULE_PAYZEN_LANGUAGE_nl' => 'Holandés',
    'SHOP_MODULE_PAYZEN_LANGUAGE_en' => 'Inglés',
    'SHOP_MODULE_PAYZEN_LANGUAGE_fr' => 'Francés',
    'SHOP_MODULE_PAYZEN_LANGUAGE_de' => 'Alemán',
    'SHOP_MODULE_PAYZEN_LANGUAGE_it' => 'Italiano',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ja' => 'Japonés',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pl' => 'Polaco',
    'SHOP_MODULE_PAYZEN_LANGUAGE_pt' => 'Portugués',
    'SHOP_MODULE_PAYZEN_LANGUAGE_ru' => 'Ruso',
    'SHOP_MODULE_PAYZEN_LANGUAGE_es' => 'Español',
    'SHOP_MODULE_PAYZEN_LANGUAGE_sv' => 'Sueco',
    'SHOP_MODULE_PAYZEN_LANGUAGE_tr' => 'Turco',
    'SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Idiomas disponibles',
    'HELP_SHOP_MODULE_PAYZEN_AVAILABLE_LANGUAGES' => 'Idiomas disponibles en la página de pago. Si no selecciona ninguno, todos los idiomas compatibles estarán disponibles.',
    'SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'Plazo de captura',
    'HELP_SHOP_MODULE_PAYZEN_CAPTURE_DELAY' => 'El número de días antes de la captura del pago (ajustable en su Back Office PayZen).',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'Modo de validación',
    'HELP_SHOP_MODULE_PAYZEN_VALIDATION_MODE' => 'Si se selecciona manual, deberá confirmar los pagos manualmente en su Back Office PayZen.',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_' => 'Configuración de Back Office PayZen',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_0' => 'Automático',
    'SHOP_MODULE_PAYZEN_VALIDATION_MODE_1' => 'Manual',
    'SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'Tipos de tarjeta',
    'HELP_SHOP_MODULE_PAYZEN_PAYMENT_CARDS' => 'El tipo(s) de tarjeta que se puede usar para el pago. No haga ninguna selección para usar la configuración del portal.',

    // ADMINISTRATION INTERFACE - SELECTIVE 3DS.
    'SHOP_MODULE_GROUP_PAYZEN_SELECTIVE_3DS' => '3DS SELECTIVO',
    'SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Deshabilitar 3DS',
    'HELP_SHOP_MODULE_PAYZEN_3DS_MIN_AMOUNT' => 'Monto por debajo del cual se deshabilitará 3DS. Requiere suscripción a la opción 3DS selectivo. Para más información, consulte la documentación del módulo.',

    // ADMINISTRATION INTERFACE - RETURN TO SHOP.
    'SHOP_MODULE_GROUP_PAYZEN_RETURN_TO_SHOP' => 'VOLVER A LA TIENDA',
    'SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Redirección automática',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ENABLED' => 'Si está habilitada, el comprador es redirigido automáticamente a su sitio al final del pago.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Tiempo de espera de la redirección en pago exitoso',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_TIMEOUT' => 'Tiempo en segundos (0-300) antes de que el comprador sea redirigido automáticamente a su sitio web después de un pago exitoso.',
    'SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Mensaje de redirección en pago exitoso',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_SUCCESS_MESSAGE' => 'Mensaje mostrado en la página de pago antes de la redirección después de un pago exitoso.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Tiempo de espera de la redirección en pago rechazado',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_TIMEOUT' => 'Tiempo en segundos (0-300) antes de que el comprador sea redirigido automáticamente a su sitio web después de un pago rechazado.',
    'SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Mensaje de redirección en pago rechazado',
    'HELP_SHOP_MODULE_PAYZEN_REDIRECT_ERROR_MESSAGE' => 'Mensaje mostrado en la página de pago antes de la redirección después de un pago rechazado.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Modo de retorno',
    'HELP_SHOP_MODULE_PAYZEN_RETURN_MODE' => 'Método que se usará para transmitir el resultado del pago de la página de pago a su tienda.',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_GET' => 'GET',
    'SHOP_MODULE_PAYZEN_RETURN_MODE_POST' => 'POST'
);

require_once(dirname(__FILE__) . '/../../../core/lypayzentools.php');
if (! lyPayzenTools::$pluginFeatures['shatwo']) {
    $aLang['HELP_SHOP_MODULE_PAYZEN_SIGN_ALGO'] .= '<br /><b>El algoritmo HMAC-SHA-256 no se debe activar si aún no está disponible el Back Office PayZen, la función estará disponible pronto.</b>';
}
