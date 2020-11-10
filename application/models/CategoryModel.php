<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModel extends CI_Model
{


    public function detail_data($id)
    {
        return $this->db->select('*')->from('category')->where('id', $id)->order_by('id', 'desc')->get()->row();
    }

    public function create_data($data)
    {
        $this->db->insert('category', $data);
        return array('status' => 200, 'message' => 'Data has been created.');
    }

    public function update_data($id, $data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('category', $data);
        return array('status' => 200, 'message' => 'Data has been updated.');
    }


    public function delete_data($id, $data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('category', $data);
        return array('status' => 200, 'message' => 'Data has been deleted.');
    }

    public function all_data()
    {
        return $this->db->select('*')->from("category")->where('status', '1')->order_by('id', 'desc')->get()->result();
    }

}
