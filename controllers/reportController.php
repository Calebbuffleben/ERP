<?php

class reportController extends controller {

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

        if ($users->hasPermission('report_view')) {

            $this->loadTemplate("report", $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function sales() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $company = new Companies($users->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $users->getEmail();

        $data['statuses'] = array(
            '0' => 'Aguardando Pgto.',
            '1' => 'Pago',
            '2' => 'Cancelado'
        );

        if ($users->hasPermission('report_view')) {

            $this->loadTemplate("report_sales", $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function sales_pdf() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();

        $data['statuses'] = array(
            '0' => 'Aguardando Pgto.',
            '1' => 'Pago',
            '2' => 'Cancelado'
        );

        if ($users->hasPermission('report_view')) {
            $client_name = addslashes($_GET['client_name']);
            $period1 = addslashes($_GET['period1']);
            $period2 = addslashes($_GET['period2']);
            $status = addslashes($_GET['status']);
            $order = addslashes($_GET['order']);

            $s = new Sales();
            $data['sales_list'] = $s->getSalesFiltered($client_name, $period1, $period2, $status, $order, $users->getCompany());

            $data['filters'] = $_GET;

            $this->loadLibrary('mpdf60/mpdf');

            ob_start();
            $this->loadView("report_sales_pdf", $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->Output();

            $this->loadView("report_sales_pdf", $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function inventory() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if ($u->hasPermission('report_view')) {

            $this->loadTemplate("report_inventory", $data);
        } else {
            header("Location: " . base_url);
        }
    }

    public function inventory_pdf() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();

        if ($users->hasPermission('report_view')) {
            $inventory = new Inventory();
            $data['inventory_list'] = $inventory->getInventoryFiltered($users->getCompany());

            $data['filters'] = $_GET;

            $this->loadLibrary('mpdf60/mpdf');

            ob_start();
            $this->loadView("report_inventory_pdf", $data);
            $html = ob_get_contents();
            ob_end_clean();

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            header("Location: " . base_url);
        }
    }

}
