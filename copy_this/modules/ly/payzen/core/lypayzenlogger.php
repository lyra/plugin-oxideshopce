<?php
/**
 * Copyright © Lyra Network.
 * This file is part of PayZen plugin for OXID eShop CE. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
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
        if (! is_int($minLevel) || $minLevel < 0) {
            $minLevel = self::DEBUG;
        }

        $this->_context = $context;
        $this->_level = $minLevel;

        $this->_path = getShopBasePath() . 'log/payzen.log';
    }

    public function log($msgText, $level = self::INFO)
    {
        if (! key_exists($level, self::$availLevels)) {
            $level = self::INFO;
        }

        if ($level < $this->_level) {
            // No log.
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
