<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendorModel extends CI_Model
{


    public function detail_data($id)
    {
        return $this->db->select('*')->from('vendors')->where('id', $id)->order_by('id', 'desc')->get()->row();
    }

    public function create_data($data)
    {
        $this->db->insert('vendors', $data);
    }

    public function update_data($id, $data)
    {
        $this->db->where('id', $id)->update('vendors', $data);
    }


    public function delete_data($id, $data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('vendors', $data);
    }

    public function all_data()
    {
        return $this->db->select('*')->from("vendors")->where('status', '1')->order_by('id', 'desc')->get()->result();
    }

}
