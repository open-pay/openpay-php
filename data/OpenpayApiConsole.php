<?php

/**
 * Openpay API v1 Client for PHP (version 2.0.0)
 * 
 * Copyright © Openpay SAPI de C.V. All rights reserved.
 * http://www.openpay.mx/
 * soporte@openpay.mx
 */
class OpenpayConsole {

    const CONSOLE_NONE = 0;
    const CONSOLE_TRACE = 2;
    const CONSOLE_DEBUG = 4;
    const CONSOLE_INFO = 8;
    const CONSOLE_WARNING = 16;
    const CONSOLE_ERROR = 32;
    const CONSOLE_CRITICAL = 64;
    const CONSOLE_ALL = 126;

    private static $instance;
    private $level;
    private $toScreen;

    private function __construct() {
        $this->level = self::CONSOLE_NONE;
        $this->toScreen = false;
    }

    private function record($prefix, $text) {
        $output = $prefix . ': ' . print_r($text, true);
        if ($this->toScreen == true) {
            print_r('<pre>' . $output . '</pre>' . "\n");
        } else {
            syslog(LOG_INFO, $output);
        }
    }

    private function checkFlag($flag, $value) {
        return (($flag & $value) == $flag);
    }

    private static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private static function _log($type, $flag, $text) {
        $logger = self::getInstance();
        if ($logger->checkFlag($flag, $logger->level))
            $logger->record('[' . strtoupper($type) . ']', $text);
    }

    // -----------------------------------------------
    public static function setLevel($level) {
        $instance = self::getInstance();
        $instance->level = $level;
    }

    public static function printToScreen($flag) {
        $instance = self::getInstance();
        $instance->toScreen = ($flag ? true : false);
    }

    public static function trace($text) {
        self::_log('trace', self::CONSOLE_TRACE, $text);
    }

    public static function debug($text) {
        self::_log('debug', self::CONSOLE_DEBUG, $text);
    }

    public static function info($text) {
        self::_log('info', self::CONSOLE_INFO, $text);
    }

    public static function warn($text) {
        self::_log('warning', self::CONSOLE_WARNING, $text);
    }

    public static function error($text) {
        self::_log('error', self::CONSOLE_ERROR, $text);
    }

    public static function critical($text) {
        self::_log('critical', self::CONSOLE_CRITICAL, $text);
    }

}

?>