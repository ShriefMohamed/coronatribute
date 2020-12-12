<?php


namespace Framework\lib;


class Text
{
    public static $texts;

    public function __construct($language = 'en')
    {
        self::$texts = require_once CONFIG_DIR . $language . '.php';
    }

    public static function Get($key)
    {
        if (!$key) {
            return null;
        }

        // check if array key exists
        if (!array_key_exists($key, self::$texts)) {
            return null;
        }

        return self::$texts[$key];
    }
}
