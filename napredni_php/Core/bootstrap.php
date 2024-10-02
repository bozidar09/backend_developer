<?php

// autoload classes
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);

    $file = basePath($class_name) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});