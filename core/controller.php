<?php

class controller {

    protected $db;

    public function __construct() {
        global $config;

        $this->db = new PDO("mysql:dbname=" . $config['dbname'] . ';host=' . $config['host'], $config['dbuser'], $config['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function loadView($viewName, $viewData = array()) {
        extract($viewData);
        include 'views/' . $viewName . '.php';
    }

    public function loadTemplate($viewName, $viewData = array()) {

        include 'views/template/template.php';
    }

    public function loadViewInTemplate($viewName, $viewData = array()) {
        extract($viewData);
        include 'views/' . $viewName . '.php';
    }

    public function loadLibrary($lib) {
        if (file_exists('libraries/' . $lib . '.php')) {
            include 'libraries/' . $lib . '.php';
        }
    }

}
