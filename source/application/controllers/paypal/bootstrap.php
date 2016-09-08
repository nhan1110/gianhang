<?php
$composerAutoload = dirname(__DIR__) . '/paypal/vendor/autoload.php';
if (!file_exists($composerAutoload)) {
    $composerAutoload = dirname(__DIR__) . '/paypal/vendor/autoload.php';
    if (!file_exists($composerAutoload)) {
        echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
        exit(1);
    }
}
require $composerAutoload;
require __DIR__ . '/common.php';
date_default_timezone_set(@date_default_timezone_get());
error_reporting(E_ALL);
ini_set('display_errors', '1');

