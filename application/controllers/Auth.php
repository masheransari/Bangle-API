<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("ion_auth");
        $this->load->model('UserModel');
    }

    public function login()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {

            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $username = $data['username'];
                $password = $data['password'];

                $response = $this->MyModel->login($username, $password);
                json_output(200, $response);
            }
        }
    }

    public function hash_password_db($id, $password, $use_sha1_override = FALSE)
    {
        if (empty($id) || empty($password)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        $query = $this->db->select('password, salt')
            ->where('id', $id)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        $hash_password_db = $query->row();

        if ($query->num_rows() !== 1) {
            return FALSE;
        }

        // bcrypt
        if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
            if ($this->bcrypt->verify($password, $hash_password_db->password)) {
                return TRUE;
            }

            return FALSE;
        }

        // sha1
        if ($this->store_salt) {
            $db_password = sha1($password . $hash_password_db->salt);
        } else {
            $salt = substr($hash_password_db->password, 0, $this->salt_length);

            $db_password = $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
        }

        if ($db_password == $hash_password_db->password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->logout();
                json_output($response['status'], $response);
            }
        }
    }

    public function change_password()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(400, array('status' => 400, 'message' => 'Bad request.'));
        } else {
            $response = $this->MyModel->auth();
            if ($response != NULL && $response['status'] == 200) {
                $data = json_decode($this->input->raw_input_stream, true);
                $uId = $this->input->get_request_header('User-ID', TRUE);
                $response = $this->ion_auth->change_password_custom($uId, $data['old'], $data['new']);
                json_output(200, $response);
            }
        }
    }


}
