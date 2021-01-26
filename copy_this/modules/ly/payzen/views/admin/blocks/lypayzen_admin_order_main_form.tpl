[{*
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
*}]

[{$smarty.block.parent}]

[{if $edit->oxorder__oxpaymenttype->value == "oxidpayzen"}]
    <tr>
        <td class="edittext" colspan="2">
            <br>
            <table style="border: 1px solid #A9A9A9; padding: 5px; width: 600px;">
                <tr>
                    <td class="edittext" colspan="3">
                        <b>[{oxmultilang ident="PAYZEN_ORDER_INFORMATION"}]</b>
                    </td>
                </tr>
                <tr>
                    <td class="edittext" style="width: 200px">
                        [{oxmultilang ident="PAYZEN_ORDER_PAYMENTMEANS"}]
                    </td>
                    <td class="edittext" >
                        [{$edit->oxorder__payzencardbrand->value}]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                        [{oxmultilang ident="PAYZEN_ORDER_TRANSACTIONID"}]
                    </td>
                    <td class="edittext" >
                        [{$edit->oxorder__oxtransid->value}]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                        [{oxmultilang ident="PAYZEN_ORDER_TRANSACTIONUUID"}]
                    </td>
                    <td class="edittext" >
                        [{$edit->oxorder__payzentransuuid->value}]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                        [{oxmultilang ident="PAYZEN_ORDER_CARDNUMBER"}]
                    </td>
                    <td class="edittext" >
                        [{$edit->oxorder__payzencardnumber->value}]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                        [{oxmultilang ident="PAYZEN_ORDER_CARDEXPIRATION"}]
                    </td>
                    <td class="edittext" >
                        [{$edit->oxorder__payzencardexpiration->value}]
                    </td>
                </tr>
            </table>
        </td>
    </tr>
[{/if}]