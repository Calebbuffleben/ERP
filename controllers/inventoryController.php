<?php

class inventoryController extends controller {

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

        if ($users->hasPermission('inventory_view')) {
            $inventory = new Inventory();
            $offset = 0;

            $data['inventory_list'] = $inventory->getList($offset, $users->getCompany());

            $data['add_permission'] = $users->hasPermission('inventory_add');
            $data['edit_permission'] = $users->hasPermission('inventory_edit');

            $this->loadTemplate("inventory", $data);
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

        if ($users->hasPermission('inventory_add')) {

            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $inventory = new Inventory();

                $name = addslashes($_POST['name']);
                $price = addslashes($_POST['price']);
                $quant = addslashes($_POST['quant']);
                $min_quant = addslashes($_POST['min_quant']);

                $price = str_replace(',', '.', $price);

                $inventory->add($name, $price, $quant, $min_quant, $users->getCompany(), $users->getId());
                header("Location: " . base_url . "/inventory");
            }

            $this->loadTemplate("inventory_add", $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function edit($id) {
        $data = array();
        $user = new Users();
        $user->setLoggedUser();
        $company = new Companies($user->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $user->getEmail();

        if ($user->hasPermission('inventory_edit')) {
            $inventory = new Inventory();

            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $price = addslashes($_POST['price']);
                $quant = addslashes($_POST['quant']);
                $min_quant = addslashes($_POST['min_quant']);

                $price = str_replace('.', '', $price);
                $price = str_replace(',', '.', $price);

                $inventory->edit($id, $name, $price, $quant, $min_quant, $user->getCompany(), $user->getId());

                header("Location: " . base_url . "/inventory");
            }

            $data['inventory_info'] = $inventory->getInfo($id, $user->getCompany());

            $this->loadTemplate('inventory_edit', $data);
        }
    }
    public function delete($id){
        $user = new Users();
        $user->setLoggedUser();
        
        if($user->hasPermission('inventory_edit')){
            $inventory = new Inventory();
            $inventory->delete($id, $user->getCompany(), $user->getId());
            header("Location: " . base_url . "/inventory");
        }

    }
    

}
