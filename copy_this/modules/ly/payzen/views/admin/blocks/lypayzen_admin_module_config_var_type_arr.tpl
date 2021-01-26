[{*
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
*}]

[{if $oModule->getInfo('id') == 'payzen'}]
    <select class="select" name="confarrs[[{$module_var}]][]" [{$readonly}] multiple="multiple" size="5">
        [{foreach from=$var_constraints.$module_var key='code' item='label'}]
            <option value="[{$code|escape}]" [{if (in_array($code, $confarrs.$module_var))}]selected="selected"[{/if}]>
                [{if $module_var == 'PAYZEN_AVAILABLE_LANGUAGES'}]
                    [{oxmultilang ident="SHOP_MODULE_PAYZEN_LANGUAGE_`$code`" alternative="$label"}]
                [{else}]
                    [{oxmultilang ident="SHOP_MODULE_`$module_var`_`$code`" alternative="$label"}]
                [{/if}]
            </option>
        [{/foreach}]
    </select>
[{else}]
    [{$smarty.block.parent}]
[{/if}]