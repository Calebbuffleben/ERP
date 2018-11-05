<?php

class providersController extends controller {

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

        if ($users->hasPermission('providers_view')) {
            $providers = new Providers();
            $offset = 0;
            $data['p'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['p'] = intval($_GET['p']);
                if ($data['p'] == 0) {
                    $data['p'] = 1;
                }
            }
            $offset = ( 10 * ($data['p'] - 1) );

            $data['providers_list'] = $providers->getList($offset, $users->getCompany());
            $data['providers_count'] = $providers->getCount($users->getCompany());
            $data['p_count'] = ceil($data['providers_count'] / 10);
            $data['edit_permission'] = $users->hasPermission('providers_edit');

            $this->loadTemplate('providers', $data);
        } else {
            header("Location: " . base_url);
        }
    }
    public function add(){
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();

        if ($users->hasPermission('providers_edit')) {
            $providers = new Providers();

            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $providers->add($users->getCompany(), $name, $email, $phone);
                header("Location: " . base_url . "/providers");
            }

            $this->loadTemplate('providers_add', $data);
        } else {
            header("Location: " . base_url . "/providers");
        }
    }
    public function edit($id){
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();

        if ($users->hasPermission('providers_edit')) {
            $providers = new Providers();

            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);

                $providers->edit($id, $users->getCompany(), $name, $email, $phone);
                header("Location: " . base_url . "/providers");
            }

            $data['provider_info'] = $providers->getInfo($id, $users->getCompany());

            $this->loadTemplate('providers_edit', $data);
        } else {
            header("Location: " . base_url . "/providers");
        }
    }
}
