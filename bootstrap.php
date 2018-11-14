<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

//Initialiser les repertoire
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('CP', dirname(__FILE__));
define('ROOT_PATH', realpath(CP));
define('LOG_PATH', ROOT_PATH . DS . 'var' . DS . 'log');
define('TEMPLATE_PATH', ROOT_PATH . DS . 'views' . DS . 'template');

//Initialiser les errors logs configs
//ini_set('error_reporting', '-1'); // '-1' : toutes les erreurs possibles
//ini_set('display_errors', 'off');
//ini_set('log_errors', 'on');

//Initializer les repertoir include
set_include_path(
   get_include_path() . PS .
   ROOT_PATH . DS . 'models' .  PS .
   ROOT_PATH . DS . 'classes' . PS .
   ROOT_PATH . DS . 'controllers' . PS .
   ROOT_PATH . DS . 'views' . DS . 'template'
);

//Autoload class file.
spl_autoload_register(function($class){

    $classFile = preg_replace('/^.*\\\(.*)/i','$1.php',$class);

    include_once $classFile;
});

use \Film\AppException;
use \Film\AbstractsController;

class Bootstrap {

    use \Film\Config;

    /*
     * Start application
     */
    public static function run()
    {
        try {

            //Dispatche les pages.
            AbstractsController::dispatche();


        } catch (AppException $e) {
            AppException::logger($e->getMessage(), 1);

        } catch (\Exception $e) {
            AppException::logger($e->getMessage(), 0);
        }
    }

}

\Film\Bootstrap::run();