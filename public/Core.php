<?php

/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 3/25/2016
 * Time: 3:14 PM
 */
require_once('Configuration.php');

class Core
{
    public $db; // handle of the db connexion
    private static $instance;

    private function __construct()
    {
        // building data source name from config
        $dsn =  'mysql:host=' . Configuration::read('db.host') .
                ';dbname='    . Configuration::read('db.basename') .
                ';connect_timeout=15';
        $user = Configuration::read('db.user');
        $password = Configuration::read('db.password');

        try {
            $this->db = new PDO($dsn, $user, $password);
            $this->db->exec('set names utf8');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    // others global functions
}

?>