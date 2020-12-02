<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model
{
    function __construct()
    {
        $this->load->library("Common");
    }

    public function getUser($id)
    {
        $arr = array("id" => $id, "status" => 1);
        return $this->db->select('*')->from('users')->where($arr)->order_by('id', 'desc')->get()->row();
    }

    public function updateUser($id, $data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('users', $data);
    }

    public function updatePassword($id, $data)
    {
        $q = $this->db->select('*')->from('users')->where(array('id' => $id, 'status' => 1))->get()->row();
        if ($q == "") {
            return array("error" => 204);
        } else {
            $oldPassword = $data['old_password'];
            $hashed_password = $q->password;
            $id = $q->id;
            if ($hashed_password == crypt($oldPassword, $hashed_password)) {
                $updated_password = crypt($data['new_password'], $data['new_password']);
                $arr = array('id' => $id, 'status' => '1');
                $res['password'] = $updated_password;
                $this->db->where($arr)->update('users', $res);
                return array(
                    "output"=>hash_equals($hashed_password, crypt($oldPassword, $hashed_password)),
                    "encryptedPassword"=>crypt($oldPassword, $hashed_password),
                    "hashPassword"=>$hashed_password,
                    "oldPassword"=>$oldPassword,
                    "updatedPassword"=>$updated_password,
                    "newPassword"=>$res['password'],
                    "newPassword_unencrypted"=>$data['new_password']);
                return array("error" => 200);
            } else {
                return array("error" => 501);
            }
        }
    }
}