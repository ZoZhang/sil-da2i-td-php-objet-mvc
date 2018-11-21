<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class ActorController extends \Film\AbstractsController
{
    protected static $_templates = [
        'header.phtml',
        'actor.phtml',
        'filmographie.phtml',
        'footer.phtml'
    ];

    protected static $_pageClass = 'biographie';

    /**
     * Get cur Actor info
     */
    public static function getActor()
    {
        $actor  = array();

        $model = static::getModel('actor');

        $options = array('id'=>static::getRequest('id'),'role'=>'actor');

        $actor = $model->getBaseInfos($options);

        return $actor;
    }

    /**
     * Get filmgraphie
     */
    public static function getMovieGraphie()
    {
        $actor  = array();

        $model = static::getModel('movie');

        $options = array('id'=>static::getRequest('id'),'role'=>'actor');

        $actor = $model->getMovieGraphie($options);

        return $actor;
    }


}