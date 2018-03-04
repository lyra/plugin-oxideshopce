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

class lyPayzenLogger
{
	const LEVEL_DEBUG = [1, 'DEBUG'];
	const LEVEL_INFO = [2, 'INFO'];
	const LEVEL_WARN = [3, 'WARN'];
	const LEVEL_ERROR = [4, 'ERROR'];

	private $_level;
	private $_context;
	private $_path;

	public function __construct($context, $level = self::LEVEL_INFO)
	{
		$this->_context = $context;
		$this->_level = $level;

		$this->_path = getShopBasePath() . 'log/payzen.log';
	}

	public function setContext($context)
	{
		$this->_context = $context;
	}

	public function log($msg, $msgLevel = self::LEVEL_INFO)
	{
		if(!is_array($msgLevel) || !isset($msgLevel[0]) || !is_numeric($msgLevel[0])) {
			$msgLevel = self::LEVEL_INFO;
		}

		if($msgLevel[0] < $this->_level[0]) {
			// no logs
			return ;
		}

		$date = date('Y-m-d H:i:s', time());

		$fLog = @fopen($this->_path, 'a');
		if ($fLog) {
			fwrite($fLog, "$date - {$msgLevel[1]} - {$this->_context} : $msg\n");
			fclose($fLog);
		}
	}
}