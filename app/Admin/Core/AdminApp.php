<?php

namespace App\Admin\Core;


class AdminApp
{
    public static $app;

    public static function get_instance()
    {
        self::$app = Registry::instance();
        self::getParams();

        return self::$app;

    }

    public static function getParams()
    {
        $params = require CONF.'/params.php';

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }
}