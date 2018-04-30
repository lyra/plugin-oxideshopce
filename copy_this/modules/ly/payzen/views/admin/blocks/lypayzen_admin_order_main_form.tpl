[{*
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