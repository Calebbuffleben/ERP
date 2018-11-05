<?php
class model {
    
    protected $db;
    public function __construct(){
        global $config;
        
        $this->db = new PDO("mysql:dbname=".$config['dbname'].';host='.$config['host'], 
                $config['dbuser'], $config['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
