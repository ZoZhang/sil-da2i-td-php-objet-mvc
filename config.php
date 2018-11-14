<?php

/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

Trait Config {

    private static $_configs = [
        'db' => [
            'host' => '127.0.0.1',
            'user' => 'web',
            'pass' => 'webtd',
            'name' => 'film',
        ]
    ];

    /*
     * Getter data config
     */
    public static function getConfig($scope,$name='')
    {
        if (!isset(self::$_configs[$scope])) {
            throw new AppException('Errors: Not found config filed');
        }

        if (isset(self::$_configs[$scope][$name])) {
            return self::$_configs[$scope][$name];
        }

        return self::$_configs[$scope];
    }

    /*
    * Setter data config
    */
    public static function setConfig($scope, $val=array())
    {
        if (!is_array($val)) {
            throw new AppException('Errors: ' . __CLASS__ . PS . __METHOD__ .' arguement has un error.');
        }

        if (isset( self::$_configs[$scope])){
            self::$_configs[$scope] = array_merge(self::$_configs[$scope], $val);
        } else {
            self::$_configs[$scope] = $val;
        }

        return self::$_configs[$scope];
    }
}