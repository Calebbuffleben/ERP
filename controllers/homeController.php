<?php

class homeController extends controller {

    public function __construct() {
        parent::__construct();

        $validacao = new Validate();
        $validacao->valid_user();
    }

    public function index() {
        //    $validacao = new Validate();
        $data = array();
        $users = new Users($_SESSION['ccUser']);
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_name'] = $users->getName();
        $sales = new Sales();

        $data['statuses'] = array(
            '0' => 'Aguardando Pgto.',
            '1' => 'Pago',
            '2' => 'Cancelado'
        );

        $data['products_sold'] = $sales->getSoldProducts(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $users->getCompany());

        $data['revenue'] = $sales->getTotalRevenue(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $users->getCompany());

        $data['expenses'] = $sales->getTotalExpenses(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $users->getCompany());

        $data['days_list'] = array();
        for ($q = 30; $q > 0; $q--) {
            $data['days_list'][] = date('d/m', strtotime('-' . $q . ' days'));
        }

        $data['revenue_list'] = $sales->getRevenueList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $users->getCompany());

        $data['expenses_list'] = $sales->getExpensesList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $users->getCompany());

        $data['status_list'] = $sales->getQuantStatusList(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $users->getCompany());

        $this->loadTemplate('home', $data);
    }

}
