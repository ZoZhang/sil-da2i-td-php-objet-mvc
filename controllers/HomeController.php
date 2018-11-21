<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

use \Film\MovieModel;

class HomeController extends \Film\AbstractsController
{
    protected static $_templates = [
        'header.phtml',
        'home.phtml',
        'footer.phtml'
    ];

    protected static $_pageClass = 'page-index';

    /**
     * Getter all movie
     * @return array
     */
    protected static function getAllMovies()
    {
        $movies = array();

        $movieModel = static::getModel('movie');

        $movies = $movieModel->getAllMovies();

        return $movies;
    }

    /**
     * Getter all actors
     * @return array
     */
    protected static function getAllActors()
    {
        $actors = array();

        $actorModel = static::getModel('actor');

        $actors = $actorModel->getAllActors();

        return $actors;
    }

    /**
     * Getter all directors
     * @return array
     */
    protected static function getAllDirectors()
    {
        $directors = array();

        $directorModel = static::getModel('director');

        $directors = $directorModel->getAllDirectors();

        return $directors;
    }
}