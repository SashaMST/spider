<?php

class DB
{
    private static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * @param $config
     * @return null|PDO
     */
    public static function init($config)
    {
        if (self::$instance === null) {
            try {

                return new PDO($config['dns'], $config['username'], $config['password'],
                    [PDO::ATTR_EMULATE_PREPARES => true]);
            } catch (PDOException $e) {
                echo $e->getMessage();

                exit();
            }
        } else {

            return self::$instance;
        }
    }
}
