<?php
/**
 * User: Georgi
 * Date: 3/25/2016
 * Time: 3:18 PM
 */
class Configuration
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }
}

// db test connection
Configuration::write('db.host', 'localhost');
Configuration::write('db.basename', 'html2pdf');
Configuration::write('db.user', 'root');
Configuration::write('db.password', '');
