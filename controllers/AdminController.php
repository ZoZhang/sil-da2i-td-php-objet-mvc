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
            return $data;
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
     * logout administrator
     */
    public static function logoutAction()
    {
        unset($_SESSION['admin']);

        static::redirectUrl('/');
    }

    /**
     * Dashboard Page
     * @return null
     */
    protected static function dashboardAction()
    {
        static::$_pageClass = 'admin admin-dsahboard';

        static::$_templates = [
            'header.phtml',
            'dashboard.phtml',
            'footer.phtml'
        ];

        $movieModel = static::getModel('movie');
        $actorModel = static::getModel('actor');
        $directorModel = static::getModel('director');

        static::$_settings['total_movie'] = $movieModel->getAllMovies(array('count_only'=>true));
        static::$_settings['total_actor'] = $actorModel->getAllActors(array('count_only'=>true));
        static::$_settings['total_director'] = $directorModel->getAllDirectors(array('count_only'=>true));
    }

    /**
     * Film List Page
     */
    protected static function filmAction()
    {
        static::$_pageClass = 'admin admin-film';

        static::$_templates = [
            'header.phtml',
            'film.phtml',
            'footer.phtml'
        ];

        var_dump(self::$_requests['film']['id']);
        //default film list
        if (!isset(self::$_requests['film']['id'])) {
            $movieModel = static::getModel('movie');

            static::$_settings['all_movie'] = $movieModel->getAllMovies();
        } else {

            $_operation = self::$_requests['film']['operation'];

            switch($_operation) {
                case 'add':

                    break;

                case 'modify':
                    break;

                case 'delete':

                    break;
            }

        }
    }

}