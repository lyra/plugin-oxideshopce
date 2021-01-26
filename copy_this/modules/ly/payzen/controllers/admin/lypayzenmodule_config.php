<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

class lyPayzenModule_Config extends lyPayzenModule_Config_parent
{
    /**
     * Add additional config type for modules.
     */
    public function __construct()
    {
        $this->_aSkipMultiline = array_merge($this->_aSkipMultiline, array('PAYZEN_AVAILABLE_LANGUAGES', 'PAYZEN_PAYMENT_CARDS'));

        parent::__construct();
    }

    public function render()
    {
        $template = parent::render();

        require_once dirname(dirname(dirname(__FILE__))) . '/core/api/lypayzenapi.php';
        $this->_aViewData['var_constraints']['PAYZEN_AVAILABLE_LANGUAGES'] = PayzenApi::getSupportedLanguages();
        $this->_aViewData['var_constraints']['PAYZEN_PAYMENT_CARDS'] = PayzenApi::getSupportedCardTypes();

        // Decode saved data as json string if necessary.
        foreach ($this->_aViewData['confarrs'] as $payzenArrConfCode => $payzenArrConf) {
            if (! is_array($payzenArrConf) || (! empty ($payzenArrConf) && ! in_array(reset($payzenArrConf), array_keys($this->_aViewData['var_constraints'][$payzenArrConfCode])))) {
                if (is_array($payzenArrConf)) {
                    $payzenArrConf = reset($payzenArrConf);
                }

                $payzenArrConfNewValue = json_decode(htmlspecialchars_decode($payzenArrConf));
                $this->_aViewData['confarrs'][$payzenArrConfCode] = is_array($payzenArrConfNewValue) ? $payzenArrConfNewValue : array();
            }
        }

        return $template;
    }

    /**
     * Saves shop configuration variables.
     */
    public function saveConfVars()
    {
        $oConfig = $this->getConfig();
        $aConfVars = $oConfig->getRequestParameter('confarrs');

        if (! is_array($aConfVars)) {
            $_POST['confarrs'] = array();
        }

        if (! key_exists('PAYZEN_AVAILABLE_LANGUAGES', $_POST['confarrs'])) {
            $_POST['confarrs']['PAYZEN_AVAILABLE_LANGUAGES'] = '[]';
        } else {
            $_POST['confarrs']['PAYZEN_AVAILABLE_LANGUAGES'] = json_encode($_POST['confarrs']['PAYZEN_AVAILABLE_LANGUAGES']);
        }

        if (! key_exists('PAYZEN_PAYMENT_CARDS', $_POST['confarrs'])) {
            $_POST['confarrs']['PAYZEN_PAYMENT_CARDS'] = '[]';
        } else {
            $_POST['confarrs']['PAYZEN_PAYMENT_CARDS'] = json_encode($_POST['confarrs']['PAYZEN_PAYMENT_CARDS']);
        }

        parent::saveConfVars();
    }
}
