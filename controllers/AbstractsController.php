<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

abstract class AbstractsController
{
    use \Film\Config;

    protected static $_requests = null;

    protected static $_templates = [];

    /**
     * Initialize les configs
     */
    public static function dispatche()
    {
        preg_match('/^\/(\w+)/i', $_SERVER['REQUEST_URI'], $_controllerName);

        if (!isset($_controllerName[1])) {
            $_controllerName[1] = 'index';
        }

        // replace default index page to home page.
        $_controllerName[1] = str_ireplace('index','home', $_controllerName[1]);
        $_controllerName = preg_replace('/(.+)/i','$1Controller',$_controllerName[1]);
        $_controllerName = '\\' . __NAMESPACE__ . '\\' . ucfirst($_controllerName);

        //filter name controller
        array_shift($_REQUEST);

        $options = [
            'url' => ($_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'] ? 'http://' : 'https://') . $_SERVER['SERVER_NAME']
                . '/',

        ];

        self::$_requests = array_merge($options,$_REQUEST);

        //self::$_controller = new $_controllerName;
       // call_user_func(self::$_controller->loadLayout(), array('options'=>array()));

        if (!class_exists($_controllerName, $autoload = true)) {
            header('Location: /error');
        }

        call_user_func_array(array($_controllerName, 'startSession'), array());
        call_user_func_array(array($_controllerName, 'loadLayout'), array());
    }

    /**
     * Getter val request
     * @return string
     */
    public static function getRequest($name='')
    {
        if (!isset(static::$_requests[$name])) {
            throw new AppException("Warning:  {$name} Filed not define in request.");
        }

        return static::$_requests[$name];
    }

    /**
     * Getter url domain
     * @return string
     */
    public static function getUrl($name='')
    {
        return static::getRequest('url') . $name . '/';
    }

    /**
     * Start Sessions
     */
    public static function startSession()
    {
        session_start();
    }

    /**
     * Load template file
     */
    public static function loadLayout()
    {
        if (!isset(static::$_templates) || !count(static::$_templates)) {
            throw new AppException("Warning: ". static::class . " Page not define template.");
        }

        foreach(static::$_templates as $_template) {

            if (!is_file(TEMPLATE_PATH . DS . $_template)) {
                AppException::logger("Warning: {$_template} Page Template not found.", 1);
                continue;
            }

            include_once $_template;
        }

    }

}