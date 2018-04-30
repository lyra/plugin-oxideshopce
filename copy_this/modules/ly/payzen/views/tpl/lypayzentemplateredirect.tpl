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

[{capture append="oxidBlock_content"}]
    [{* ordering steps *}]
    [{include file="page/checkout/inc/steps.tpl" active=4}]

    [{block name="checkout_payzen_redirect_main"}]
        <form action="[{$oView->getFormAction()}]" method="post" id="payzen_form" name="payzen_form">
            [{foreach from=$oView->getFormFields() key="key" item="value"}]
                <input type="hidden" name="[{$key}]" value="[{$value}]" />
            [{/foreach}]

            <p>
                <img src="[{$oViewConf->getModuleUrl('payzen', 'out/img/all_cards.png')}]" alt="PayZen" style="margin-bottom: 5px" />
                <br />
                [{oxmultilang ident="PAYZEN_REDIRECTION_MESSAGE" mod="payzen"}]
                <br /> <br />
                [{oxmultilang ident="PAYZEN_REDIRECTION_CONFIRMATION_MESSAGE" mod="payzen"}]
                <br /><br />
            </p>

            <p class="cart_navigation">
                <input type="submit" name="submitPayment" value="[{oxmultilang ident='PAYZEN_REDIRECTION_BUTTON_TEXT' mod='payzen'}]" class="exclusive" />
            </p>
        </form>

        [{oxscript add="$(function() { $('#payzen_form').submit(); });"}]
    [{/block}]
[{/capture}]
[{include file="layout/page.tpl"}]