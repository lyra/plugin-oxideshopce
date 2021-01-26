[{*
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
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