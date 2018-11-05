<?php

class permissionsController extends controller {

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

        if ($users->hasPermission('permissions_view')) {
            $permissions = new Permissions();

            $data['permissions_list'] = $permissions->getList($users->getCompany());
            $data['permissions_groups_list'] = $permissions->getGroupList($users->getCompany());

            $this->loadTemplate('permissions', $data);
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

        if ($users->hasPermission('permissions_view')) {
            $permissions = new Permissions();

            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $pname = addslashes($_POST['name']);

                $permissions->add($pname, $users->getCompany());

                header("Location: " . base_url . "/permissions");
            }

            $this->loadTemplate('permissions_add', $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function add_group() {
        $data = array();

        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions_view')) {
            $permissions = new Permissions();
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $pname = addslashes($_POST['name']);
                $plist = $_POST['permissions'];

                $permissions->addGroup($pname, $plist, $users->getCompany());

                header("Location: " . base_url . "/permissions");
            }
            $data['permissions_list'] = $permissions->getList($users->getCompany());

            $this->loadTemplate('permissions_addgroup', $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function delete($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions_view')) {
            $permissions = new Permissions();
            $permissions->delete($id);

            header("Location: " . base_url . "/permissions");
        } else {
            header("Location: " . base_url);
        }
    }

    public function delete_group($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions_view')) {
            $permissions = new Permissions();
            $permissions->deleteGroup($id);

            header("Location: " . base_url . "/permissions");
        } else {
            header("Location: " . base_url);
        }
    }

    public function edit_group($id) {
        $data = array();

        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();

        $company = new Companies($users->getCompany());

        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions_view')) {
            $permissions = new Permissions();
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $pname = addslashes($_POST['name']);
                $plist = $_POST['permissions'];

                $permissions->editGroup($pname, $plist, $id, $users->getCompany());

                header("Location: " . base_url . "/permissions");
            }
            $data['permissions_list'] = $permissions->getList($users->getCompany());
            $data['group_info'] = $permissions->getGroup($id, $users->getCompany());

            $this->loadTemplate('permissions_editgroup', $data);
        } else {
            header("Location: " . base_url);
        }
    }

}
