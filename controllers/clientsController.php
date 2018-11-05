<?php

class clientsController extends controller {

    public function __construct() {
        parent::__construct();

        $validacao = new Validate();
        $validacao->valid_user();
    }

    public function index() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();

        if ($users->hasPermission('clients_view')) {
            $clients = new Clients();
            $offset = 0;
            $data['p'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['p'] = intval($_GET['p']);
                if ($data['p'] == 0) {
                    $data['p'] = 1;
                }
            }
            $offset = ( 10 * ($data['p'] - 1) );

            $data['clients_list'] = $clients->getList($offset, $users->getCompany());
            $data['clients_count'] = $clients->getCount($users->getCompany());
            $data['p_count'] = ceil($data['clients_count'] / 10);
            $data['edit_permission'] = $users->hasPermission('clients_edit');

            $this->loadTemplate('clients', $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function add() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();
        $city = new Cidade();

        if ($users->hasPermission('clients_edit')) {
            $clients = new Clients();

            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internal_obs = addslashes($_POST['internal_obs']);
                $address_zipcode = addslashes($_POST['address_zipcode']);
                $address = addslashes($_POST['address']);
                $address_number = addslashes($_POST['address_number']);
                $address2 = addslashes($_POST['address2']);
                $address_neighb = addslashes($_POST['address_neighb']);
                $address_citycode = addslashes($_POST['address_city']);
                $address_state = addslashes($_POST['address_state']);
                $address_country = addslashes($_POST['address_country']);
                $address_city = $city->getCity($address_citycode);


                $clients->add($users->getCompany(), $name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $address_citycode);
                header("Location: " . base_url . "/clients");
            }

            $data['states'] = $city->getStates();
            $data['cities'] = 'AC';

            $this->loadTemplate('clients_add', $data);
        } else {
            header("Location: " . base_url . "/clients");
        }
    }

    public function edit($id) {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();
        $city = new Cidade();

        if ($users->hasPermission('clients_edit')) {
            $clients = new Clients();
            
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internal_obs = addslashes($_POST['internal_obs']);
                $address_zipcode = addslashes($_POST['address_zipcode']);
                $address = addslashes($_POST['address']);
                $address_number = addslashes($_POST['address_number']);
                $address2 = addslashes($_POST['address2']);
                $address_neighb = addslashes($_POST['address_neighb']);
                $address_citycode = addslashes($_POST['address_city']);
                $address_state = addslashes($_POST['address_state']);
                $address_country = addslashes($_POST['address_country']);
                $address_city = $city->getCity($address_citycode);

                $clients->edit($id, $users->getCompany(), $name, $email, $phone, $stars, $internal_obs, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $address_citycode);
                header("Location: " . base_url . "/clients");
            }

            $data['client_info'] = $clients->getInfo($id, $users->getCompany());
            $data['states'] = $city->getStates();
            $data['cities'] = 'AC';

            $this->loadTemplate('clients_edit', $data);
        } else {
            header("Location: " . base_url . "/clients");
        }
    }

}
