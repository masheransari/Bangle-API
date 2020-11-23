<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Common");
        $this->load->model('CategoryModel');
        $this->load->model('CustomerModel');
        $this->load->model('SubCategoryModel');
        $this->load->model('VendorModel');
        $this->load->model('RulesModel');
        $this->load->model('ProductModel');
    }

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $arr = array(
                        "category"=>sizeof($this->CategoryModel->all_data()),
                        "subCategory"=>sizeof($this->SubCategoryModel->all_data()),
                        "customer"=>sizeof($this->CustomerModel->all_data()),
                        "vendor"=>sizeof($this->VendorModel->all_data()),
                        "rule"=>sizeof($this->RulesModel->all_data()),
                        "product"=>sizeof($this->ProductModel->all_data())
                    );
                    json_output(200, $this->common->getGenericResponse("home", $arr, "Home Listing"));
                }
            }
        }
    }
}
