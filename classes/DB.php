<?php

/**
 * Exercice Web TD2
 *
 * @author ZHANG Zhao
 * @email  zo.zhang@gmail.com
 * @site   td2.web.zhaozhang.fr
 */

namespace Film;

class DB {
    use \Film\Config;

    private static $_stmt = null;

    private static $_connect = null;

    private static function connect()
    {
        if (is_null(self::$_connect)) {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8',self::getConfig('db','host'),self::getConfig('db','name'));
            self::$_connect = new \PDO($dsn, self::getConfig('db','user'), self::getConfig('db','pass'));
            self::$_connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$_connect->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        }
        return self::$_connect;
    }

    /**
     * PDO Prepare query sql
     * @param string $query
     * @return mixed
     */
    private static function prepare($query='')
    {
        if (!$query) {
            throw new \Exception('Plese check your sql.');
        }

        self::$_stmt = self::connect()->prepare($query);
    }

    private static function query($parameters=array())
    {
        if (!count($parameters)) {
            throw new \Exception('Plese check your sql parametes.');
        }

        self::$_stmt->execute($parameters);
    }

    private static function fetch()
    {
        $data = [];

        if (self::$_stmt->rowCount()) {
            self::$_stmt->setFetchMode(\PDO::FETCH_OBJ);
            $data = self::$_stmt->fetchAll();
        }
        return $data;
    }

    /**
     *  Genere options data en SQL
     *@return string
     */
    public static function getSQL($options=[])
    {
        $sql = '';

        if (!isset($options['table']) || !isset($options['fields'])) {
            throw new \PDOException('Pleles check your arguments.');
        }

        $options['fields'] = implode($options['fields'],',');

        $sql .= "SELECT {$options['fields']} FROM {$options['table']}";

        if (isset($options['left_join'])) {
            foreach($options['left_join'] as $left_join => $left_on) {
                $sql .= " LEFT JOIN {$left_join} ON {$left_on} ";
            }
        }

        if (isset($options['where'])) {
            $sql .= ' WHERE ' . $options['where'];
        }

        if (isset($options['order'])) {
            $sql .= ' ORDER BY ' . $options['order'];
        }

        //$sql = self::connect()->quote($sql);

        return $sql;
    }

    /**
     * Get data by options.
     * @return array
     */
    public static function getData($options=[])
    {
        try {
            $data = [];

            $sql = self::getSQL($options);

            self::prepare($sql);

            if (isset($options['parametes'])) {
                self::query($options['parametes']);
            }

            $data = self::fetch();
        } catch (\PDOException $e) {
            print_r($e->getMessage());die;
            throw new \Exception($e->getMessage());
        }

        return $data;
    }
}