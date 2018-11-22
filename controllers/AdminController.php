<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class AdminController extends \Film\AbstractsController
{
    protected static $_templates = [
        'login.phtml',
    ];

    //Verify identidy
    protected static function authentifiant()
    {
        static::$_pageClass = 'admin-login';

        if (!isset($_SESSION['identidyed']) || !$_SESSION['identidyed']) {
            return false;
        }

        return true;
    }

    protected static function filmAction()
    {

    }

}