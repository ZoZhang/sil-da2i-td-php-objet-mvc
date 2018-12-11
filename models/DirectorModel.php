<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

class DirectorModel extends AbstractsModel {

    /**
     * get one director by movie
     * @return array
     */
    public function getDirector($options=[])
    {
        $_querys = [
            'table'=> '`movieHasPerson` as MP',
            'fields' => ['P.id','P.firstname','P.lastname','MP.roleName','PT.path','PT.legend'],
            'left_join' => [
                '`person` as P'=>'P.id = MP.idPerson',
                '`personHasPicture` as PHP'=>'P.id = PHP.idPerson',
                '`picture` AS PT'=>'PT.id = PHP.idPicture',
            ],
            'where' => 'MP.role=:role',
            'order' => 'P.firstname ASC',
            'parametes' => [':role' => 'director']
        ];

        if (isset($options['id_movie'])) {
            $_querys['where'] .= ' AND MP.idMovie in (:idMovie)';

            if (is_array($options['id_movie'])) {
                $options['id_movie'] = implode(',', $options['id_movie']);
            }

            $_querys['parametes'][':idMovie'] = $options['id_movie'];
        }

        $directors = $this->getData($_querys);

        return $directors;
    }

    /**
     * get all directors
     * @return array
     */
    public function getAllDirectors($options=[])
    {
        $_querys = [
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
        ];

        if (isset($options['count_only'])) {
            $_querys['fields'][] = 'count(*) as total';
        }

        $allDirectors = $this->getData($_querys);

        if (isset($options['count_only'])) {
            return $allDirectors[0]->total;
        }

        return $allDirectors;
    }

}