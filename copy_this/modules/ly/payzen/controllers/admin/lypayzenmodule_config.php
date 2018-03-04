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

class lyPayzenModule_Config extends lyPayzenModule_Config_parent
{
	/**
	 * Add additional config type for modules.
	 */
	public function __construct()
	{
		$this->_aSkipMultiline = array_merge($this->_aSkipMultiline, array('AVAILABLE_LANGUAGES', 'PAYMENT_CARDS'));

		parent::__construct();
	}

	public function render()
	{
		$template = parent::render();

		require_once dirname(dirname(dirname(__FILE__))) . '/core/api/lypayzenapi.php';
		$this->_aViewData['var_constraints']['AVAILABLE_LANGUAGES'] = PayzenApi::getSupportedLanguages();
		$this->_aViewData['var_constraints']['PAYMENT_CARDS'] =PayzenApi::getSupportedCardTypes();

		return $template;
	}


	/**
	 * Saves shop configuration variables
	 */
	public function saveConfVars()
	{
		$oConfig = $this->getConfig();
		$aConfVars = $oConfig->getRequestParameter('confarrs');

		if(!is_array($aConfVars)) {
			$_POST['confarrs'] = array();
		}

		if(!key_exists('AVAILABLE_LANGUAGES', $_POST['confarrs'])) {
			$_POST['confarrs']['AVAILABLE_LANGUAGES'] = array();
		}

		if(!key_exists('PAYMENT_CARDS', $_POST['confarrs'])) {
			$_POST['confarrs']['PAYMENT_CARDS'] = array();
		}

		parent::saveConfVars();
	}
}