<?php

class ajaxController extends controller {

    public function __construct() {
        parent::__construct();

        $validacao = new Validate();
        $validacao->valid_user();
    }

    public function index() {
        
    }

    public function search_clients() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $clients = new Clients();

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = addslashes($_GET['q']);

            $c = $clients->searchClientByName($q, $users->getCompany());

            foreach ($c as $citem) {
                $data[] = array(
                    'name' => $citem['name'],
                    'link' => base_url . '/clients/edit/' . $citem['id'],
                    'id' => $citem['id']
                );
            }
        }
        echo json_encode($data);
    }

    public function get_city_list() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        
        $cidade = new Cidade();
        if (isset($_GET['state']) && !empty($_GET['state'])) {
            $state = addslashes($_GET['state']);
            $data['cities'] = $cidade->getCityList($state);
        }
        foreach ($data['cities'] as $cityk => $city){
            $data['cities'][$cityk]['Nome'] = utf8_encode($city['Nome']);
            $data['cities'][$cityk]['0'] = utf8_encode($city['0']);
        }
        $json = json_encode($data);
        
        echo $json;
    }

    public function search_products() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $inventory = new Inventory();

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $q = addslashes($_GET['q']);
            $data = $inventory->searchProductsByName($q, $users->getCompany());
        }

        echo json_encode($data);
    }

    public function add_client() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $clients = new Clients();

        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $name = addslashes($_POST['name']);

            $data['id'] = $clients->add($users->getCompany(), $name);
        }
        echo json_encode($data);
    }

}
