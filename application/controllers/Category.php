<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('CategoryModel');
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
                    $resp = $this->CategoryModel->all_data();
                    json_output(200, $this->common->getGenericResponse("categories", $resp, "Categories Details"));
                }
            }
        }
    }

    public function detail($id)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE) {
            return $this->common->getGenericErrorResponse(400, array('status', 'message', 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response['status'] == 200) {
                    $resp = $this->CategoryModel->detail_data($id);
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
                if ($response['status'] == 200) {
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['name'] = $data['name'];
                    $params['status'] = 1;
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $this->CategoryModel->create_data($params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Category Added"));
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
                $respStatus = $response['status'];
                if ($response['status'] == 200) {
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['name'] = $data['name'];
                    $params['id'] = $data['id'];
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $resp = $this->CategoryModel->update_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Category updated"));
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
//                print_r($response);
                if ($response['status'] == 200) {
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['id'] = $data['id'];
                    $params['status'] = 0;
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $resp = $this->CategoryModel->delete_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Category Deleted"));
                }
            }
        }
    }

}
