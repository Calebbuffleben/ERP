<?php

class purchasesController extends controller {

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

        $data['statuses'] = array(
            '0' => 'A pagar',
            '1' => 'Pago',
            '2' => 'Cancelado'
        );

        if ($users->hasPermission('purchases_view')) {
            $purchases = new Purchases();
            $offset = 0;

            $data['purchases_list'] = $purchases->getList($offset, $users->getCompany());

            $this->loadTemplate("purchases", $data);
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

        if ($users->hasPermission('purchases_edit')) {
            $purchases = new Purchases();

            if (isset($_POST['provider_name']) && !empty($_POST['provider_name'])) {
                $provider_name = addslashes($_POST['provider_name']);
                $provider_email = addslashes($_POST['provider_email']);
                $provider_phone = addslashes($_POST['provider_phone']);
                $status = addslashes($_POST['status']);
                $total_price = $_POST['total_price'];
                $product_name = $_POST['product_name'];
                $unit_price = $_POST['price'];
                $quant = $_POST['quant'];
                
                $purchases->addPurchase($users->getCompany(), $provider_name, $provider_email, $provider_phone, $users->getId(), $quant, $status, $total_price, $product_name, $unit_price);
                header("Location: " . base_url . "/purchases");
            }

            $this->loadTemplate("purchases_add", $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function edit($id) {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();
        $data['statuses'] = array(
            '0' => 'A pagar',
            '1' => 'Pago',
            '2' => 'Cancelado'
        );

        if ($users->hasPermission('purchases_view')) {
            $sales = new Sales();

            $data['permission_edit'] = $users->hasPermission('purchases_edit');

            if (isset($_POST['status']) && $data['permission_edit']) {
                $status = addslashes($_POST['status']);

                $sales->changeStatus($status, $id, $users->getCompany());

                header("Location: " . base_url . "/purchases");
            }
            $data['sales_info'] = $sales->getInfo($id, $users->getCompany());

            $this->loadTemplate("purchases_edit", $data);
        } else {
            header("Location: " . base_url);
        }
    }

}
