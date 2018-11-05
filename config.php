<?php

require 'environment.php';
//require 'vendor/autoload.php';

define("base_url", "http://localhost/ERP");

global $config;
$config = array();
if (ENVIRONMENT == "development") {
    $config['dbname'] = 'erp';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['pass'] = '';
} else {
    $config['dbname'] = 'erp';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['pass'] = '';
}

