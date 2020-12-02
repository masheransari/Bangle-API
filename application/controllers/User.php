<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library("Common");
    }

    public function getUser()
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
                    $resp = $this->UserModel->getUser($data['id']);
                    json_output(200, $this->common->getGenericResponse("user", $resp, "User Detail"));
                }
            }
        }
    }

    public function updateUserInfo()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                $res['first_name'] = $data['first_name'];
                $res['last_name'] = $data['last_name'];
                $res['phone'] = $data['phone'];
                $res['email'] = $data['email'];
                if (isset($data['path'])) {
                    $res['path'] = $data['path'];
                }
                if ($response != NULL && $response['status'] == 200) {
                    $this->UserModel->updateUser($data['id'], $res);
                    json_output(200, $this->common->getGenericResponse("user", $this->UserModel->getUser($data['id']), "User Detail"));
                }
            }
        }
    }

    public function updateUserPassword()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                $res['old_password'] = $data['old_password'];
                $res['new_password'] = $data['new_password'];
                if ($response != NULL && $response['status'] == 200) {
                    $resp = $this->UserModel->updatePassword($data['id'], $res);
                    json_output(200,$resp);
//                    if ($resp['error'] == 204) {
//                        json_output(200, $this->common->getGenericErrorResponse(204, 'Username not found.'));
//                    } elseif ($resp['error'] == 501) {
//                        json_output(200, $this->common->getGenericErrorResponse(501, 'Old password not valid'));
//                    } else if ($resp['error'] == 200) {
//                        json_output(200, $resp);
////                        json_output(200, $this->common->getGenericResponse("user", $this->UserModel->getUser($data['id'])));
//                    } else {
//                        json_output(200, $this->common->getGenericErrorResponse(500, 'Internal Server Error'));
//                    }
                }
            }
        }
    }
}

?>
