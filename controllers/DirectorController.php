<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class DirectorController extends \Film\AbstractsController
{
    protected static $_templates = [
        'header.phtml',
        'director.phtml',
        'filmographie.phtml',
        'footer.phtml'
    ];

    protected static $_pageClass = 'biographie';

    /**
     * Get cur director info
     */
    public static function getDirector()
    {
        $director  = array();

        $model = static::getModel('director');

        $options = array('id'=>static::getRequest('id'),'role'=>'director');

        $director = $model->getBaseInfos($options);

        return $director;
    }

    /**
     * Get filmgraphie
     */
    public static function getMovieGraphie()
    {
        $actor  = array();

        $model = static::getModel('movie');

        $options = array('id'=>static::getRequest('id'),'role'=>'director');

        $actor = $model->getMovieGraphie($options);

        return $actor;
    }
}