<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

class MovieModel extends AbstractsModel {

    /**
     * get all movies
     * @return array
     */
    public function getAllMovies()
    {
        $allMovies = $this->getData([
             'table'=> 'movie as M',
             'fields' => ['M.id','M.title','M.title_original','M.rating','PT.path as film_image'],
             'left_join' => [
                 '`movieHasPicture` as MHP'=>'MHP.idMovie = M.id and MHP.type = :pictureType',
                 '`picture` as PT'=>'PT.id = MHP.idPicture',
                 ],
             'where' => '1',
             'order' => 'M.title ASC',
             'parametes' => [':pictureType' => 'poster']
            ]);

        return $allMovies;
    }

    /**
     * get all directors
     * @return array
     */
    public function getAllDirectors()
    {
        $allDirectors = $this->getData([
            'table'=> '`movieHasPerson` as MHP',
            'fields' => ['DISTINCT P.id', 'PT.path', 'P.firstname', 'P.lastname'],
            'left_join' => [
                '`person` P'=>'P.id = MHP.idPerson',
                '`personHasPicture` as PHP'=>'P.id = PHP.idPerson',
                '`picture` as PT'=>'PT.id = PHP.idPicture',
            ],
            'where' => 'MHP.role = :role',
            'order' => 'P.firstname ASC',
            'parametes' => [':role' => 'director']
        ]);

        return $allDirectors;
    }

    /**
     * get all actors
     * @return array
     */
    public function getAllActors()
    {
        $allMovies = $this->getData([
            'table'=> '`movieHasPerson` as MP',
            'fields' => ['DISTINCT P.id','P.firstname','P.lastname','PT.path'],
            'left_join' => [
                '`person` as P'=>'P.id = MP.idPerson',
                '`personHasPicture` as PHP'=>'P.id = PHP.idPerson',
                '`picture` AS PT'=>'PT.id = PHP.idPicture',
            ],
            'where' => 'MP.role=:role',
            'order' => 'P.firstname ASC',
            'parametes' => [':role' => 'actor']
        ]);

        return $allMovies;
    }

    /**
     * get all actors
     * @return array
     */
    public function getBaseInfos(){


    }
}