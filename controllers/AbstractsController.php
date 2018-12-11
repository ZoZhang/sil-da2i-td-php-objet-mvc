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

    //error messages
    protected static $_errors = [];

    //current request data
    protected static $_requests = [];

    //dynamic data by controllers
    protected static $_settings = [];

    //dynamic template files
    protected static $_templates = [];

    //current page main-class
    protected static $_pageClass = '';

    /**
     * Getter val request
     * @return string
     */
    public static function getRequest($name='')
    {
        if (isset(static::$_requests[$name])) {
            return static::$_requests[$name];
        }

        return null;
    }

    /**
     * Getter data
     * @return string||array
     */
    public static function getSettings($name='')
    {
        if (isset(static::$_settings[$name])) {
            return static::$_settings[$name];
        }

        return static::$_settings;
    }

    /**
     * Getter an model
     */
    public static function getModel($name)
    {
        $className = '\\Film\\'. ucfirst($name) . 'Model';

        if (!class_exists($className)) {
            throw new AppException("Warning: {$className} is not class");
        }

        return new $className;
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
     * Rediction page
     */
    public static function redirectUrl($url,$msg='')
    {
        if (!$url) {
            throw new AppException("Warning: url is required");
        }

        header("Location: ${url}");
    }

    /**
     * Start Sessions
     */
    public static function startSession()
    {
        session_start();
    }

    /**
     * Get cur page custom class name
     */
    protected static function getPageClass()
    {
        return static::$_pageClass;
    }

    /**
     * Initialize les configs
     */
    public static function dispatche()
    {
        $options = [];
        preg_match('/^\/(\w+)(.*)/i', $_SERVER['REQUEST_URI'], $_controllerName);

        if (!isset($_controllerName[1])) {
            $_controllerName[1] = 'index';
        }

        if ('admin' == $_controllerName[1]) {
            $options['is_admin'] = true;
        } else {
            $options['is_front'] = true;
        }

        if (isset($_controllerName[2])) {
            $_urlParmetes = explode('/', $_controllerName[2]);

            foreach($_urlParmetes as $index => $val) {
                if ($index == 0 || empty($val)) continue;

                if ($index%2) {

                    if (isset($_urlParmetes[$index+1])) {
                        $options[$val] = $_urlParmetes[$index+1];
                    }
                }
            }
        }

        if (isset($_controllerName[2])) {
            $_actionName = preg_replace('/\/(.*)\//i','$1Action',$_controllerName[2]);
        }

        // replace default index page to home page.
        $_controllerName[1] = str_ireplace('index','home', $_controllerName[1]);
        $_controllerName = preg_replace('/(.+)/i','$1Controller',$_controllerName[1]);
        $_controllerName = '\\' . __NAMESPACE__ . '\\' . ucfirst($_controllerName);

        //filter name controller
        array_shift($_REQUEST);

        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $options['url'] = $http_type . $_SERVER['HTTP_HOST'] . '/';

        self::$_requests = array_merge($options, $_REQUEST);

        //self::$_controller = new $_controllerName;
       // call_user_func(self::$_controller->loadLayout(), array('options'=>array()));

        if (!class_exists($_controllerName, $autoload = true)) {
            header('Location: /error');
        }

        call_user_func_array(array($_controllerName, 'startSession'), array());

        //authentifiant account
        self::$_configs['is_authentied'] = false;
        if (method_exists($_controllerName,'authentifiant')) {
            self::$_configs['is_authentied'] = call_user_func_array(array($_controllerName, 'authentifiant'), array());
        }

        //set default admin page after admin login
        if (self::$_configs['is_authentied'] && stripos($_controllerName, 'admin') && empty($_actionName) || '/' == $_actionName) {
            $_actionName  = 'dashboardAction';
        }

        // call action by cur controller
        if (isset($_actionName) && self::$_configs['is_authentied'] && method_exists($_controllerName,$_actionName)) {
            call_user_func_array(array($_controllerName, $_actionName), array());
        }

        call_user_func_array(array($_controllerName, 'loadLayout'), array());
    }

    /**
     * Load template file
     */
    public static function loadLayout()
    {
        if (!isset(static::$_templates) || !count(static::$_templates)) {
            throw new AppException("Warning: ". static::class . " Page not define template.");
        }

        $_templatePath = (isset(self::$_requests['is_admin']) ? ADMIN_TEMPLATE_PATH : TEMPLATE_PATH ). DS;

        foreach(static::$_templates as $_template) {

            if (!is_file($_templatePath . $_template)) {
                throw new AppException("Warning: {$_template} Page Template not found.");
                continue;
            }

            include_once $_templatePath . $_template;
        }

    }

}