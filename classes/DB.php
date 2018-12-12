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

    private static function query($options=[])
    {
        $_res = null;
        if (!isset($options['parametes'])) {
            $_res = self::$_stmt->execute();
        } else {
            $_res = self::$_stmt->execute($options['parametes']);
        }
        return $_res;
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

        if (!isset($options['table'])) {
            throw new \PDOException('Pleles check your arguments.');
        }

        if (!isset($options['fields'])){
            $options['fields'] = '*';
        } else if (is_array($options['fields'])) {
            $options['fields'] = implode($options['fields'],',');
        }

        if (!isset($options['operation'])) {
            $sql .= "SELECT {$options['fields']} FROM {$options['table']}";
        } else {
            switch ($options['operation']) {
                case 'delete':
                    $sql .= "DELETE FROM {$options['table']}";
                    break;
                case 'update':
                    $sql .= "UPDATE {$options['table']}";
                    break;
            }
        }

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
            $res = false;
            $data = [];
            $sql = self::getSQL($options);

            self::prepare($sql);

            $res = self::query($options);

            if (!isset($options['operation'])) {
                $data = self::fetch();
                return $data;
            }
        } catch (\PDOException $e) {
            throw new AppException("Errors: ". $e->getMessage());
        }

        return $res;
    }
}