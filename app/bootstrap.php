<?php

session_start();

define("ROOT_APP", $_SERVER['DOCUMENT_ROOT'] . '/../app/');

spl_autoload_register(function ($className) {
    $file = ROOT_APP . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file))
        require_once $file;
});