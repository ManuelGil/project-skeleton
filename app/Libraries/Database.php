<?php

namespace App\Libraries;

/**
 * Database class
 */
class Database extends \PDO
{

    private static $_instance;

    /**
     * __construct function
     */
    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';

        try {
            parent::__construct($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            die("DataBase Error: Database failed.<br>{$e->getMessage()}");
        }
    }

    /**
     * getInstance function
     *
     * @return Database
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$_instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }

        return self::$_instance;
    }
}
