<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('SubCategoryModel');
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
                    $resp = $this->SubCategoryModel->all_data();
                    json_output(200, $this->common->getGenericResponse("sub_category", $resp, "Sub Categories Details"));
                }
            }
        }
    }

    public function detail($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $resp = $this->SubCategoryModel->detail_data($id);
                    json_output($response['status'], $resp);
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
                    $params['name'] = $data['name'];
                    $params['category_id'] = $data['cid'];
                    $params['path'] = $data['path'];
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['status'] = 1;
                    $resp = $this->SubCategoryModel->create_data($params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Sub Category Added"));
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
                    $params['name'] = $data['name'];
                    $params['id'] = $data['id'];
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['path'] = $data['path'];
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $resp = $this->SubCategoryModel->update_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Sub Category updated"));
                }
            }
        }
    }

    public function changecategory()
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
                    $params['id'] = $data['id'];
                    $params['category_id'] = $data['cid'];
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $resp = $this->SubCategoryModel->update_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Sub Category updated"));
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
                    $resp = $this->SubCategoryModel->delete_data($data['id'],$params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Sub Category Deleted"));
                }
            }
        }
    }

}
