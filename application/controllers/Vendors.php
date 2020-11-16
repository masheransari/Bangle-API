<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Common");
        //$this->load->model('VendorModel');

        // $VendorModel =  $this->load->model("VendorModel");
        /*
        $check_auth_client = $this->VendorModel->check_auth_client();
		if($check_auth_client != true){
			die($this->output->get_output());
		}
		*/
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
                    $resp = $this->VendorModel->all_data();
                    json_output(200, $this->common->getGenericResponse("vendors", $resp, "Vendors Listing"));
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
                    $id = $data['id'];
                    $resp = $this->VendorModel->detail_data($id);
                    json_output(200, $this->common->getGenericResponse("vendor", $resp, "Vendors Listing"));
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
                    $params['phone_no'] = $data['number'];
                    $params['address'] = $data['address'];//0336-8892931
                    if (isset($data['cnic'])){
                        $params['cnic'] = $data['cnic'];
                    }
                    $params['path'] = $data['path'];
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['status'] = 1;
                    $this->VendorModel->create_data($params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Vendor Added"));
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
                    $params['phone_no'] = $data['number'];
                    $params['address'] = $data['address'];
                    if (isset($data['cnic'])){
                        $params['cnic'] = $data['cnic'];
                    }
                    $params['path'] = $data['path'];
                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $params['status'] = 1;
                    $params['updated_at'] = date('Y-m-d H:i:s');
                    $resp = $this->VendorModel->update_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Vendor updated"));
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
                    $resp = $this->VendorModel->delete_data($data['id'], $params);
                    json_output(200, $this->common->getGenericResponse("response", null, "Vendor Deleted"));
                }
            }
        }
    }

}
