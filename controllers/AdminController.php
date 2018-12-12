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
            static::$_responses = [
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

        $movieModel = static::getModel('movie');

        //default film list
        if (!isset(self::$_requests['film']['id'])) {
            static::$_settings['all_movie'] = $movieModel->getAllMovies();

        } else {
            switch(static::$_requests['film']['operation']) {
                case 'add':

                    break;

                case 'modify':
                    break;

                case 'delete':
                    if ($movieModel->delete(static::$_requests['film'])) {
                        static::$_responses = [
                            'class' =>  'success',
                            'message' =>  'Le film a bien supprimé.',
                        ];
                    } else {
                        static::$_responses = [
                            'class' =>  'errors',
                            'message' =>  'Il y a eu un probléme technique.',
                        ];
                    }
                    static::$_settings['all_movie'] = $movieModel->getAllMovies();
                    break;
            }
        }
    }

    /**
     * Actor List Page
     */
    protected static function actorAction()
    {
        static::$_pageClass = 'admin admin-actor';

        static::$_templates = [
            'header.phtml',
            'actor.phtml',
            'footer.phtml'
        ];

        $actorModel = static::getModel('actor');

        //default actor list
        if (!isset(self::$_requests['actor']['id'])) {
            static::$_settings['all_actor'] = $actorModel->getAllActors();
        } else {
            switch(static::$_requests['actor']['operation']) {
                case 'add':

                    break;

                case 'modify':
                    break;

                case 'delete':
                    if ($actorModel->delete(static::$_requests['actor'])) {
                        static::$_responses = [
                            'class' =>  'success',
                            'message' =>  'L\'actor a bien supprimé.',
                        ];
                    } else {
                        static::$_responses = [
                            'class' =>  'errors',
                            'message' =>  'Il y a eu un probléme technique.',
                        ];
                    }
                    static::$_settings['all_actor'] = $actorModel->getAllActors();
                    break;
            }
        }
    }

    /**
     * Director List Page
     */
    protected static function directorAction()
    {
        static::$_pageClass = 'admin admin-director';

        static::$_templates = [
            'header.phtml',
            'director.phtml',
            'footer.phtml'
        ];

        $directorModel = static::getModel('director');

        //default director list
        if (!isset(self::$_requests['director']['id'])) {
            static::$_settings['all_director'] = $directorModel->getAllDirectors();

        } else {
            switch(static::$_requests['director']['operation']) {
                case 'add':

                    break;

                case 'modify':
                    break;

                case 'delete':
                    if ($directorModel->delete(static::$_requests['director'])) {
                        static::$_responses = [
                            'class' =>  'success',
                            'message' =>  'Le director a bien supprimé.',
                        ];
                    } else {
                        static::$_responses = [
                            'class' =>  'errors',
                            'message' =>  'Il y a eu un probléme technique.',
                        ];
                    }
                    static::$_settings['all_director'] = $directorModel->getAllDirectors();
                    break;
            }
        }
    }

}