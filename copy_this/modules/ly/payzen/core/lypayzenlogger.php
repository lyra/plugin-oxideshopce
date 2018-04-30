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

class lyPayzenLogger
{
    const DEBUG = 1;
    const INFO = 2;
    const WARN = 3;
    const ERROR = 4;

    public static $availLevels = array(
        self::DEBUG => 'DEBUG',
        self::INFO => 'INFO',
        self::WARN => 'WARN',
        self::ERROR => 'ERROR'
    );

    private $_level;
    private $_context;
    private $_path;

    public function __construct($context, $minLevel = self::DEBUG)
    {
        if (!is_int($minLevel) || $minLevel < 0) {
            $minLevel = self::DEBUG;
        }

        $this->_context = $context;
        $this->_level = $minLevel;

        $this->_path = getShopBasePath() . 'log/payzen.log';
    }

    public function log($msgText, $level = self::INFO)
    {
        if (!key_exists($level, self::$availLevels)) {
            $level = self::INFO;
        }

        if ($level < $this->_level) {
            // no log
            return;
        }

        $msgLevel = self::$availLevels[$level];

        $date = date('Y-m-d H:i:s', time());

        $fLog = @fopen($this->_path, 'a');
        if ($fLog) {
            fwrite($fLog, "$date - {$msgLevel} - {$this->_context} : $msgText\n");
            fclose($fLog);
        }
    }
}
