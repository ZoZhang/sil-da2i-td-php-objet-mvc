<?php
/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */
namespace Film;

class AdminModel extends AbstractsModel {

    /**
     * get all actors
     * @return array
     */
    public function authentifiant($options=array())
    {
        $_querys = [
            'table'=> '`admin` as A',
            'fields' => ['DISTINCT A.id','A.first_name','A.last_name','A.email','A.password'],
            'where' => 'A.email=:email',
            'order' => 'A.id ASC',
            'parametes' => [':email' => $options['username']]
        ];

        $admin = $this->getData($_querys);

        if (!count($admin)) {
            return false;
        }

        $passwd = md5($options['password']);

        if ( $passwd != $admin[0]->password) {
            return false;
        }

        $_SESSION['admin'] = $admin[0];

        return $admin;
    }

}