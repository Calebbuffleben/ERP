<?php

class Validate extends model{
    public function __construct(){
        parent::__construct();
    }

    public function valid_user() {
        if ($this->isLogged() == false) {
            header("Location: " . base_url . "/login");
        }
        
    }
    public function valid_logged_user(){
        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();
        return $users->getName();
    }
    public function valid_logged_company(){
        $users = new Users($_SESSION['ccUser']);
        
        $company = new Companies();
        
        if($users->getCompany() == $company->getId()){
           return $company->getName();
        }
        
    }

    public function isLogged() {
        if (isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
            return true;
        } else {
            return false;
        }
    }

}
