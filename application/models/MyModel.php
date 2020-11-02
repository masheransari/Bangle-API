<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Common.php');
require_once('Constants.php');

class MyModel extends CI_Model
{

    var $common = null;
    var $constant = null;

    function __construct()
    {
        $this->common = new Common();
        $this->constant = new Constants();
    }

    public function check_auth_client()
    {
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key = $this->input->get_request_header('Auth-Key', TRUE);

        if ($client_service == $this->constant->CLIENT_SERVICE && $auth_key == $this->constant->AUTH_KEY) {
            return true;
        } else {
            return $this->common->getGenericErrorResponse(401, 'Unauthorized User');

        }
    }

    public function login($username, $password)
    {
        $q = $this->db->select('password,id')->from('users')->where('email', $username)->get()->row();

        if ($q == "") {
            return $this->common->getGenericErrorResponse(204, 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id = $q->id;

            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
                $last_login = date('Y-m-d H:i:s');
                $token = crypt(substr(md5(rand()), 0, 7), null);
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->trans_start();
              //  $this->db->where('id', $id)->update('users', array('last_login' => $last_login));
                $this->db->insert('users_authentication', array('users_id' => $id, 'token' => $token, 'expired_at' => $expired_at));
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return $this->common->getGenericErrorResponse(500, 'Internal server error.');
                } else {
                    $this->db->trans_commit();
                    $object = ['id' => $id, 'token' => $token];
                    return $this->common->getGenericResponse($this->constant->CONSTANT_USER, $object, 'Successfully login.');
                }
            } else {
                return $this->common->getGenericErrorResponse(204, 'Internal server error.');
            }
        }
    }

    public function logout()
    {
        $users_id = $this->input->get_request_header('User-ID', TRUE);
        $token = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('users_id', $users_id)->where('token', $token)->delete('users_authentication');
        return $this->common->getGenericResponse($this->constant->CONSTANT_LOGOUT, null, 'Successfully login.');
    }

    public function auth()
    {
        $users_id = $this->input->get_request_header('User-ID', TRUE);
        $token = $this->input->get_request_header('Authorization', TRUE);
        $q = $this->db->select('expired_at')->from('users_authentication')->where('users_id', $users_id)->where('token', $token)->get()->row();
        if ($q == "") {
            return $this->common->unauthorizedUserResponse();
        } else {
            if ($q->expired_at < date('Y-m-d H:i:s')) {
                return json_output(401, array('status' => 401, 'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+1 minutes'));
                $this->db->where('users_id', $users_id)->where('token', $token)->update('users_authentication', array('expired_at' => $expired_at, 'updated_at' => $updated_at));
                return array('status' => 200, 'message' => 'Authorized.');
            }
        }
    }


}
