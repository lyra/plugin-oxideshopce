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

/**
 * Class defines what module does on shop events.
 */
class lyPayzenEvents
{
	/**
	 * Add PayZen payment method.
	 */
	public static function addPaymentMethod()
	{
		$oPayment = oxNew('oxPayment');

		if (!$oPayment->load('oxidpayzen')) {
			$oPayment->setId('oxidpayzen');
			$oPayment->oxpayments__oxactive = new oxField(1);
			$oPayment->oxpayments__oxdesc = new oxField('PayZen');
			$oPayment->oxpayments__oxaddsum = new oxField(0);
			$oPayment->oxpayments__oxaddsumtype = new oxField('abs');
			$oPayment->oxpayments__oxfromboni = new oxField(0);
			$oPayment->oxpayments__oxfromamount = new oxField(0);
			$oPayment->oxpayments__oxtoamount = new oxField(1000000);

			$aPaymentDescriptions = array(
					'fr' => '<div>Paiement sécurisé par carte bancaire via PayZen.</div>',
					'en' => '<div>Secured payments by card bank with PayZen.</div>',
					'de' => '<div>Sichere Kartenzahlung mit PayZen.</div>'
			);

			$oLanguage = oxRegistry::get('oxLang');
			$aLanguages = $oLanguage->getLanguageIds();
			foreach ($aPaymentDescriptions as $sLangCode => $sDescription) {
				$iLanguageId = array_search($sLangCode, $aLanguages);
				if ($iLanguageId !== false) {
					$oPayment->setLanguage($iLanguageId);
					$oPayment->oxpayments__oxlongdesc = new oxField($sDescription);
					$oPayment->save();
				}
			}
		}
	}

	/**
	 * Disables PayZen payment method.
	 */
	public static function disablePaymentMethod()
	{
		$oPayment = oxNew('oxpayment');
		$oPayment->load('oxidpayzen');
		$oPayment->oxpayments__oxactive = new oxField(0);
		$oPayment->save();
	}

	/**
	 * Activates PayZen payment method.
	 */
	public static function enablePaymentMethod()
	{
		$oPayment = oxNew('oxpayment');
		$oPayment->load('oxidpayzen');
		$oPayment->oxpayments__oxactive = new oxField(1);
		$oPayment->save();
	}

	/**
	 * Add PayZen fields to DB oxorder table.
	 */
	public static function addPayzenFields()
	{
		$oDbMetaDataHandler = oxNew('oxDbMetaDataHandler');
		$sTableName = 'oxorder';

		$aTableFields = array(
				'PAYZENSENDMAIL'				=> ['type' => 'TINYINT(1)', 'default' => 0],
				'PAYZENCARDNUMBER'				=> ['type' => 'VARCHAR(128)', 'default' => ''],
				'PAYZENCARDBRAND'				=> ['type' => 'VARCHAR(16)', 'default' => ''],
				'PAYZENCARDEXPIRATION'			=> ['type' => 'varchar(7)', 'default' => '']
		);

		foreach ($aTableFields as $sTableFieldName => $sFieldStructure) {
			if (!$oDbMetaDataHandler->fieldExists($sTableFieldName, $sTableName)) {
				oxDb::getDb()->execute(
						'ALTER TABLE `' . $sTableName
						. '` ADD COLUMN `' . $sTableFieldName .'` '. $sFieldStructure ['type'].' DEFAULT "'.$sFieldStructure ['default'].'";'
				);
			}
		}
	}

	/**
	 * Execute action on activate event.
	 */
	public static function onActivate()
	{
		// adding record to oxPayment table
		self::addPaymentMethod();

		// enabling PayZen payment method
		self::enablePaymentMethod();

		// adding PayZen fields to DB oxorder table
		self::addPayzenFields();
	}

	/**
	 * Execute action on deactivate event.
	 *
	 * @return null
	 */
	public static function onDeactivate()
	{
		self::disablePaymentMethod();
	}
}