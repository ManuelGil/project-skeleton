<?php

namespace App\Libraries;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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
            if ($_ENV['ENVIRONMENT'] != "production") {
                die("DataBase Error: Database failed.<br>{$e->getMessage()}");
            } else {
                $log = new Logger('App');
                $log->pushHandler(new StreamHandler(__DIR__ . './../../logs/errors.log', Logger::ERROR));

                $log->error($e->getMessage(), $e->getTrace());
            }
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
