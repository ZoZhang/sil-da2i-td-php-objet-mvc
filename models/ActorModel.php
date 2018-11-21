<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

class ActorModel extends AbstractsModel {

    /**
     * get all actors
     * @return array
     */
    public function getAllActors($options=array())
    {
        $_querys = [
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
        ];

        if (isset($options['id_movie'])) {

            $_querys['fields'][] = 'MP.roleName';
            $_querys['where'] .= ' AND MP.idMovie in (:idMovie)';

            if (is_array($options['id_movie'])) {
                $options['id_movie'] = implode(',', $options['id_movie']);
            }

            $_querys['parametes'][':idMovie'] = $options['id_movie'];
        }

        $allActors = $this->getData($_querys);

        return $allActors;
    }

}