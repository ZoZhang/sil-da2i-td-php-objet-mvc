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

    //Verify identifiant
    protected static function authentifiant()
    {
        static::$_pageClass = 'admin-login';

        //appelle l'authentification
        $model = static::getModel('admin');
        if (!$model->authentifiant(static::$_requests) || !isset($_SESSION['admin'])) {
            static::$_errors = [
                'message'=> 'Username or password error, please try again'
            ];
        } else {
            static::$_templates = ['dashboard.phtml'];
        }
    }

    protected static function filmAction()
    {

    }

}