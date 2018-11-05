<?php

class usersController extends controller {

    public function __construct() {
        parent::__construct();

        $validacao = new Validate();
        $validacao->valid_user();
    }

    public function index() {
        $data = array();

        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('users_view')) {
            $permissions = new Permissions();
            $data['users_list'] = $users->getList($users->getCompany());

            $this->loadTemplate('users', $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function add() {
        $data = array();

        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('users_view')) {
            $permissions = new Permissions();

            if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
                $email = addslashes($_POST['email']);
                $user_name = addslashes($_POST['user_name']);
                $pass = addslashes($_POST['password']);
                $group = addslashes($_POST['group']);

                $a = $users->add($email, $user_name, $pass, $group, $users->getCompany());

                if ($a == '1') {
                    header("Location: " . base_url . "/users");
                } else {
                    $data['error_msg'] = "Usuário já existe!";
                }
            }

            $data['group_list'] = $permissions->getGroupList($users->getCompany());

            $this->loadTemplate('users_add', $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function edit($id) {
        $data = array();

        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('users_view')) {
            $permissions = new Permissions();

            if (isset($_POST['group']) && !empty($_POST['group'])) {
                $pass = addslashes($_POST['password']);
                $group = addslashes($_POST['group']);

                $users->edit($id, $pass, $group, $users->getCompany());
                header("Location: " . base_url . "/users");
            }

            $data['user_info'] = $users->getInfo($id, $users->getCompany());
            $data['group_list'] = $permissions->getGroupList($users->getCompany());

            $this->loadTemplate('users_edit', $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function delete($id) {
        $data = array();

        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('users_view')) {
            $users->delete($id, $users->getCompany());
            header("Location: " . base_url . "/users");
        } 
        else {
            header("Location: " . base_url);
        }
    }

}
