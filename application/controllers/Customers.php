<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Customers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Common");
        $this->load->model('CustomerModel');
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

                    $resp = $this->CustomerModel->all_data();

                    json_output(200, $this->common->getGenericResponse("customers", $resp, "Customers Listing"));

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

                    $resp = $this->CustomerModel->detail_data($id);

                    json_output(200, $this->common->getGenericResponse("customer", $resp, "Customers Listing"));

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

                    $params['address'] = $data['address'];

                    $params['defective'] = $data['defective'];
                    
                    $params['rule_id'] = $data['rule_id'];

                    if (isset($data['cnic'])){

                        $params['cnic'] = $data['cnic'];

                    }

                    $params['path'] = $data['path'];
                    
                    $params['created_at'] = date('Y-m-d H:i:s');

                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);

                    $params['updated_at'] = date('Y-m-d H:i:s');

                    $params['status'] = 1;

                    $this->CustomerModel->create_data($params);

                    json_output(200, $this->common->getGenericResponse("response", null, "Customer Added"));

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

                    $params['defective'] = $data['defective'];
                    
                    $params['rule_id'] = $data['rule_id'];

                    if (isset($data['cnic'])){

                        $params['cnic'] = $data['cnic'];

                    }

                    $params['path'] = $data['path'];

                    $params['created_by'] = $this->input->get_request_header('User-ID', TRUE);

                    $params['status'] = 1;

                    $params['updated_at'] = date('Y-m-d H:i:s');

                    $resp = $this->CustomerModel->update_data($data['id'], $params);

                    json_output(200, $this->common->getGenericResponse("response", null, "Customer updated"));

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

                    $resp = $this->CustomerModel->delete_data($data['id'], $params);

                    json_output(200, $this->common->getGenericResponse("response", null, "Customer Deleted"));

                }

            }

        }

    }



}
?>
