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

    /**
     * Get cur page custom class name
     */
    protected static function getPageClass()
    {
        return 'page-index';
    }

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

        $movieModel = static::getModel('movie');

        $actors = $movieModel->getAllActors();

        return $actors;
    }

    /**
     * Getter all directors
     * @return array
     */
    protected static function getAllDirectors()
    {
        $directors = array();

        $movieModel = static::getModel('movie');

        $directors = $movieModel->getAllDirectors();

        return $directors;
    }
}