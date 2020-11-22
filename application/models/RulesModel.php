<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RulesModel extends CI_Model
{
    public function detail_data($id)
    {
        return $this->db->select('*')->from('rules')->where('id', $id)->order_by('id', 'desc')->get()->row();
    }

    public function create_data($data)
    {
        $this->db->insert('rules', $data);
    }

    public function update_data($id, $data)
    {
        $this->db->where('id', $id)->update('rules', $data);
    }

    public function delete_data($id, $data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('rules', $data);
    }

    public function all_data()
    {
        return $this->db->select('*')->from("rules")->where('status', '1')->order_by('id', 'desc')->get()->result();
    }



}