<?php

namespace Lib;

/**
 * Description of Config
 *
 * @author Windows 7
 */
class Config {
    
    protected static $settings = [];
    
    public static function get($key) {
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }
    
    public static function set($key, $value) {
        self::$settings[$key] = $value;
    }
}
