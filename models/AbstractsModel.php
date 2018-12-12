<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

abstract class AbstractsModel {

    /**
     * Get data by database
     */
    public function getData($options=[])
    {
       return DB::getData($options);
    }

    /*
     * Get paramete by url
     * @return string|boolean|int
     */
    public function getParamete($name = [])
    {
        $paramete = AbstractsController::getRequest($name);

        if (!is_null($paramete)) {
            return $paramete;
        }

        return null;
    }

    /**
     * get base info
     * @return array
     */
    public function getBaseInfos($options=[])
    {
        $_data = [];

        $_querys = [
            'table'=> '`movieHasPerson` as MHP',
            'fields' => ['DISTINCT P.id','P.firstname','P.lastname','P.birthDate','P.biography','PT.path','PT.legend'],
            'left_join' => [
                '`person` AS P'=>'P.id=MHP.idPerson',
                '`personHasPicture` AS PHP'=>'PHP.idPerson = P.id',
                '`picture` AS PT'=>'PT.id = PHP.idPicture',
            ],
            'where' => 'MHP.role=:role AND MHP.idPerson=:id'
        ];

        if (isset($options['id'])) {
            $_querys['parametes'][':id'] = $options['id'];
        }

        if (isset($options['role'])) {
            $_querys['parametes'][':role'] = $options['role'];
        }
        $_data = $this->getData($_querys);

        if (count($_data)) {
            $_data = array_shift($_data);
            $_data->format_birthDate = date("d M Y", strtotime($_data->birthDate));
        }

        return $_data;
    }


    /**
     * Delete movie by id
     */
    public function delete($parametes = [])
    {
        if (!isset($parametes['id'])) {
            return false;
        }

        $ids = implode(',', $parametes['id']);

        $_querys = [
            'where' => "id in ($ids)",
            'operation' => 'delete'
        ];

        //table name
        if ($this instanceof ActorModel || $this instanceof DirectorModel) {
            $_querys['table'] = '`person`';
        } else if ($this instanceof MovieModel) {
            $_querys['table'] = '`movie`';
        }


        //print_r($_querys);die;
        return $this->getData($_querys);
    }


}