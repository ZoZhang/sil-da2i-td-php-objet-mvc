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

    /**
     * verify identifiant
     * @return bool
     * @throws AppException
     */
    protected static function authentifiant()
    {
        static::$_pageClass = 'admin-login';

        if (!isset($_SESSION['admin']) && (!isset(static::$_requests['username']) || !isset(static::$_requests['password']))) {
            return false;
        }

        //appelle l'authentification
        $model = static::getModel('admin');
        if (!isset($_SESSION['admin']) && !$model->authentifiant(static::$_requests)) {
            static::$_errors = [
                'message'=> 'Username or password error, please try again'
            ];
            return false;
        }

        return true;
    }

    /**
     * get admin user full name
     * @return string
     */
    public static function getLoginUser($field = '')
    {
        $data = '';
        if (!isset($_SESSION['admin'])) {
            return;
        }

        switch ($field) {
            case 'email':
                $data = $_SESSION['admin']->email;
                break;
            case 'full_name':
                $data = $_SESSION['admin']->first_name . ' ' .$_SESSION['admin']->last_name;
                break;
        }
        return $data;
    }

    /**
     * Dashboard Page
     * @return null
     */
    protected static function dashboardAction()
    {
        static::$_pageClass = 'admin-dsahboard';
        static::$_templates = [
            'header.phtml',
            'dashboard.phtml',
            'footer.phtml'
        ];
    }

    /**
     * Film List Page
     */
    protected static function filmAction()
    {

        die('tdssest');

    }

}