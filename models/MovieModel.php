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
     * get base info
     * @return array
     */
    public function getBaseInfos($options=[])
    {
        $_data = $this->getAllMovies($options);

        if (count($_data)) {
            $_data = array_shift($_data);
            $_data->format_releaseDate = date("d M Y", strtotime($_data->releaseDate));
        }

        return $_data;
    }

    /**
     * get all movies
     * @return array
     */
    public function getAllMovies($optinos=[])
    {
        $allMovies = [];

        $_querys = [
            'table'=> 'movie as M',
            'fields' => ['M.id','M.title','M.title_original','M.releaseDate','M.synopsis','M.rating','PT.path as 
        film_image','PT.legend as film_legend'],
            'left_join' => [
                '`movieHasPicture` as MHP'=>'MHP.idMovie = M.id and MHP.type = :pictureType',
                '`picture` as PT'=>'PT.id = MHP.idPicture',
            ],
            'where' => '1',
            'order' => 'M.title ASC',
            'parametes' => [':pictureType' => 'poster']
        ];

        if (isset($optinos['id'])) {
            $_querys['where'] = ' M.id=:id';
            $_querys['parametes'][':id'] = $optinos['id'];
        }

        $allMovies = $this->getData($_querys);

        return $allMovies;
    }

    /**
     * get all movie photos
     * @return array
     */
    public function getAllPhotos($options=[])
    {
        $allPhotos = [];

        $_querys = [
            'table'=> 'movie as M',
            'fields' => ['PT.path','PT.legend'],
            'left_join' => [
                '`movieHasPicture` as MHP'=>'MHP.idMovie = M.id',
                '`picture` as PT'=>'PT.id = MHP.idPicture',
            ],
            'where' => 'MHP.type=:pictureType AND M.id=:idMovie',
        ];

        if (isset($options['id_movie'])) {
            $_querys['parametes'] = [
                ':pictureType' => 'gallery',
                ':idMovie' => $options['id_movie']
            ];
        }

        $allPhotos = $this->getData($_querys);

        return $allPhotos;
    }


    /**
     * get movie graphie
     * @return array
     */
    public function getMovieGraphie($options=[])
    {
        $allMovies = [];

        $_querys = [
            'table'=> '`movieHasPerson` as MHP',
            'fields' => ['M.id','M.title','M.releaseDate','PT.path','PT.legend'],
            'left_join' => [
                '`movie` as M'=>'M.id = MHP.idMovie',
                '`movieHasPicture` as MHPT'=>'MHPT.idMovie = MHP.idMovie',
                '`picture` as PT'=>'PT.id = MHPT.idPicture',
            ],
            'where' => 'MHPT.type=:pictureType AND MHP.idPerson=:id',
        ];

        if (isset($options['id'])) {
            $_querys['parametes'] = [
                ':pictureType' => 'poster',
                ':id' => $options['id']
            ];
        }

        $allMovies = $this->getData($_querys);

        if (count($allMovies)) {
            foreach($allMovies as &$movie) {
                $movie->format_releaseDate = date("d M Y", strtotime($movie->releaseDate));
            }
        }

        return $allMovies;
    }

}