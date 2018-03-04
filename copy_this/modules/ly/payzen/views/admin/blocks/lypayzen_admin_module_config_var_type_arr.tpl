[{* 
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
*}]

[{if $oModule->getInfo('id') == 'payzen'}]
	<select class="select" name="confarrs[[{$module_var}]][]" [{ $readonly }] multiple="multiple" size="5">
		[{foreach from=$var_constraints.$module_var key='code' item='label'}]
			<option value="[{$code|escape}]" [{ if (in_array($code, $confarrs.$module_var)) }]selected="selected"[{/if}]>
				[{if $module_var == 'AVAILABLE_LANGUAGES' }]
					[{ oxmultilang ident="SHOP_MODULE_LANGUAGE_`$code`" alternative="$label" }]
				[{else}]
					[{ oxmultilang ident="SHOP_MODULE_`$module_var`_`$code`" alternative="$label" }]
				[{/if}]
			</option>
		[{/foreach}]
	</select>
[{else}]
	[{$smarty.block.parent}]
[{/if}]