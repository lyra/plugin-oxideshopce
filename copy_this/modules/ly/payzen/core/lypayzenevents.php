<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */

/**
 * Class defines what module does on shop events.
 */
class lyPayzenEvents
{
    /**
     * Add gateway payment method.
     */
    public static function addPaymentMethod()
    {
        $oPayment = oxNew('oxPayment');

        require_once(dirname(__FILE__) . '/lypayzentools.php');
        if (! $oPayment->load('oxidpayzen')) {
            $oPayment->setId('oxidpayzen');
            $oPayment->oxpayments__oxactive = new oxField(1);
            $oPayment->oxpayments__oxdesc = new oxField(lyPayzenTools::getDefault('GATEWAY_NAME'));
            $oPayment->oxpayments__oxaddsum = new oxField(0);
            $oPayment->oxpayments__oxaddsumtype = new oxField('abs');
            $oPayment->oxpayments__oxfromboni = new oxField(0);
            $oPayment->oxpayments__oxfromamount = new oxField(0);
            $oPayment->oxpayments__oxtoamount = new oxField(1000000);

            $aPaymentDescriptions = array(
                'fr' => '<p>Paiement sécurisé par carte bancaire avec PayZen. Vous allez être redirigé(e) vers la page de paiement après confirmation de la commande.</p>',
                'en' => '<p>Secured payment by credit card with PayZen. You will be redirected to payment page after order confirmation.</p>',
                'de' => '<p>Sichere Zahlung mit Kreditkarte mit PayZen. Sie werden zu den Zahlungsseiten nach Zahlungsbestätigung weitergeleitet.</p>',
                'es' => '<p>Pago seguro con tarjeta de crédito con PayZen. Será redireccionado a la página de pago después de la confirmación del pedido.</p>'
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
     * Disables payment method.
     */
    public static function disablePaymentMethod()
    {
        $oPayment = oxNew('oxpayment');
        $oPayment->load('oxidpayzen');
        $oPayment->oxpayments__oxactive = new oxField(0);
        $oPayment->save();
    }

    /**
     * Activates payment method.
     */
    public static function enablePaymentMethod()
    {
        $oPayment = oxNew('oxpayment');
        $oPayment->load('oxidpayzen');
        $oPayment->oxpayments__oxactive = new oxField(1);
        $oPayment->save();
    }

    /**
     * Add gateway fields to DB oxorder table.
     */
    public static function addPayzenFields()
    {
        $oDbMetaDataHandler = oxNew('oxDbMetaDataHandler');
        $sTableName = 'oxorder';

        $aTableFields = array(
            'PAYZENSENDMAIL' => array('type' => 'TINYINT(1)', 'default' => 0),
            'PAYZENCARDNUMBER' => array('type' => 'VARCHAR(128)', 'default' => ''),
            'PAYZENCARDBRAND' => array('type' => 'VARCHAR(128)', 'default' => ''),
            'PAYZENCARDEXPIRATION' => array('type' => 'varchar(7)', 'default' => ''),
            'PAYZENTRANSUUID' => array('type' => 'varchar(32)', 'default' => '')
        );

        foreach ($aTableFields as $sTableFieldName => $sFieldStructure) {
            if (! $oDbMetaDataHandler->fieldExists($sTableFieldName, $sTableName)) {
                oxDb::getDb()->execute(
                    'ALTER TABLE `' . $sTableName . '`
                         ADD COLUMN `' . $sTableFieldName . '` ' . $sFieldStructure ['type'] . '
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
        // Adding record to oxPayment table.
        self::addPaymentMethod();

        // Enabling payment method.
        self::enablePaymentMethod();

        // Adding gateway fields to DB oxorder table.
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
