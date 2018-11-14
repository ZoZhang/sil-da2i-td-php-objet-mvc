<?php

/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class AppException extends \Exception {

    protected static $_levels = [
        '0' => ['type'=> 1, 'file'=> 'errors.log'],
        '1' => ['type'=> 3, 'file'=> 'exception.log'],
    ];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Write message to log file
     * @param $message
     * @param $level
     */
    public static function logger($message, $level='0')
    {
        error_log($message . PHP_EOL , self::$_levels[$level]['type'],LOG_PATH . DS . self::$_levels[$level]['file']);
    }

}


