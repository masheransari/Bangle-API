<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model
{
    public function getUser($id){
        $arr = array("id" => $id, "status" => 1);
        return $this->db->select('*')->from('users')->where($arr)->order_by('id', 'desc')->get()->row();
    }
}