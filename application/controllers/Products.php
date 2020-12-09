<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductModel');
        $this->load->library("Common");
    }

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $resp = $this->ProductModel->all_data();
                    json_output(200, $this->common->getGenericResponse("products", $resp, "Product Listing"));
                }
            }
        }
    }

    public function search()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $data = json_decode($this->input->raw_input_stream, true);
                    if (isset($data['keyword'])) {
//                        $resp = $this->ProductModel->all_data();
                        $resp = $this->ProductModel->get_keyword_product($data['keyword']);
                        json_output(200, $this->common->getGenericResponse("products", $resp, "Product Listing"));
                    } else {
                        json_output(200, $this->common->getGenericErrorResponse(404, 'No Keywords Found.'));
                    }
                }
            }
        }
    }

    public function detail()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $resp = $this->ProductModel->detail_data($data['id']);
                    json_output(200, $this->common->getGenericResponse("product", $resp, "Product Information"));
                }
            }
        }
    }

    public function create()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $res['name'] = $data['name'];
                    $res['sub_category_id'] = $data['sid'];
                    $res['purchase_price'] = $data['pprice'];
                    $res['selling_price'] = $data['sprice'];
                    $res['img'] = $data['img'];
                    $res['vendor_id'] = $data['vid'];
                    $res['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $res['updated_at'] = date('Y-m-d H:i:s');
                    $res['created_at'] = date('Y-m-d H:i:s');
                    $res['status'] = 1;
                    $this->ProductModel->create_data($res);
                    json_output(200, $this->common->getGenericResponse("response", null, "Product Added"));
                }
            }
        }
    }

    public function update()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $res['name'] = $data['name'];
                    $res['sub_category_id'] = $data['sid'];
                    $res['purchase_price'] = $data['pprice'];
                    $res['selling_price'] = $data['sprice'];
                    $res['img'] = $data['img'];
                    $res['vendor_id'] = $data['vid'];
                    $res['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $res['updated_at'] = date('Y-m-d H:i:s');
                    $res['status'] = 1;
                    $this->ProductModel->update_data($data['id'], $res);
                    json_output(200, $this->common->getGenericResponse("response", null, "Product Updated"));
                }
            }
        }
    }

    public function delete()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['id'] = $data['id'];
                    $params['status'] = 0;
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $resp = $this->ProductModel->delete_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Product Deleted"));
                }
            }
        }
    }

}
