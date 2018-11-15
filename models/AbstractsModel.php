<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

class AbstractsModel {

    /**
     * Get data by database
     */
    public function getData($options=[])
    {
       return DB::getData($options);
    }

    /*
     * Get info base
     * @return array
     */
    public function getBaseInfos()
    {


    }
}