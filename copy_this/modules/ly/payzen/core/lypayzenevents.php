<?php
/**
 * PayZen V2-Payment Module version 2.0.1 for OXID_eShop_CE 4.9-4.10. Support contact : support@payzen.eu.
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
 * @author    Lyra Network (http://www.lyra-network.com/)
 * @copyright 2014-2018 Lyra Network and contributors
 * @license   http://www.gnu.org/licenses/gpl.html  GNU General Public License (GPL v3)
 * @category  payment
 * @package   payzen
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
                'fr' => '<p>Paiement sécurisé par carte bancaire avec PayZen. Vous allez être redirigé(e) vers la page de paiement après confirmation de la commande.</p>',
                'en' => '<p>Secured payment by credit card with PayZen. You will be redirected to payment page after order confirmation.</p>',
                'de' => '<p>Sichere Zahlung mit Kreditkarte mit PayZen. Sie werden zu den Zahlungsseiten nach Zahlungsbestätigung weitergeleitet.</p>'
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
            'PAYZENSENDMAIL' => array('type' => 'TINYINT(1)', 'default' => 0),
            'PAYZENCARDNUMBER' => array('type' => 'VARCHAR(128)', 'default' => ''),
            'PAYZENCARDBRAND' => array('type' => 'VARCHAR(16)', 'default' => ''),
            'PAYZENCARDEXPIRATION' => array('type' => 'varchar(7)', 'default' => ''),
            'PAYZENTRANSUUID' => array('type' => 'varchar(32)', 'default' => '')
        );

        foreach ($aTableFields as $sTableFieldName => $sFieldStructure) {
            if (!$oDbMetaDataHandler->fieldExists($sTableFieldName, $sTableName)) {
                oxDb::getDb()->execute(
                    'ALTER TABLE `' . $sTableName . '`
                         ADD COLUMN `' . $sTableFieldName .'` '. $sFieldStructure ['type'] . '
                             DEFAULT "' . $sFieldStructure ['default'] . '";'
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
