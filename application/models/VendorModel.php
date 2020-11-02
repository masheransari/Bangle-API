<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendorModel extends CI_Model {

   
    public function detail_data($id)
    {
        return $this->db->select('*')->from('vendors')->where('id',$id)->order_by('id','desc')->get()->row();
    }

    public function create_data($data)
    {
        $this->db->insert('vendors',$data);
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function update_data($id,$data)
    {
        $this->db->where('id',$id)->update('vendors',$data);
        return array('status' => 200,'message' => 'Data has been updated.');
    }


    public function delete_data($id)
    {
        $this->db->where('id',$id)->delete('vendors');
        return array('status' => 200,'message' => 'Data has been deleted.');
    }

    public function all_data()
    {
        return $this->db->select('*')->from("vendors")->order_by('id','desc')->get()->result();
    }

}
