<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class MovieController extends \Film\AbstractsController
{
    protected static $_templates = [
        'header.phtml',
        'movie.phtml',
        'footer.phtml'
    ];

    protected static $_pageClass = 'page-movie';

    /**
     * Get cur Movie info
     */
    public static function getMovie()
    {
        $movie  = array();

        $model = static::getModel('movie');

        $options = array('id'=>static::getRequest('id', 1));

        $movie = $model->getBaseInfos($options);

        return $movie;
    }

    /**
     * Get cur movie photos
     */
    public static function getPhotos()
    {
        $photos  = array();

        $model = static::getModel('movie');

        $options = array('id_movie'=> static::getRequest('id', 1));

        $photos = $model->getAllPhotos($options);

        return $photos;
    }

    /**
     * Get cur movie actors
     */
    public static function getActors()
    {
        $actors  = array();

        $model = static::getModel('actor');

        $options = array('id_movie'=> static::getRequest('id', 1));

        $actors = $model->getAllActors($options);

        return $actors;
    }

    /**
     * Get cur movie director
     */
    public static function getDirector()
    {
        $director  = array();

        $model = static::getModel('director');

        $options = array('id_movie'=> static::getRequest('id', 1));

        $director = $model->getDirector($options);

        return $director;
    }
}