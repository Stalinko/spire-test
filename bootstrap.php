<?php

/**
 * Bootstrap the PHP environment
 */

spl_autoload_register(static function ($className) {
    $filename = __DIR__ . '/classes/' . $className . '.php';
    if (is_readable($filename)) {
        require_once $filename;
    }
});