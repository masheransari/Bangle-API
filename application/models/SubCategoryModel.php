<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategoryModel extends CI_Model
{


    public function detail_data($id)
    {
        return $this->db->select('*')->from('sub_category')->where('id', $id)->order_by('id', 'desc')->get()->row();
    }

    public function create_data($data)
    {
        $this->db->insert('sub_category', $data);
        return array('status' => 201, 'message' => 'Data has been created.');
    }

    public function update_data($id, $data)
    {
        $arr = array("id" => $id, "status" => 1);
        $this->db->where($arr)->update('sub_category', $data);
        return array('status' => 200, 'message' => 'Data has been updated.');
    }


    public function delete_data($id,$data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('sub_category',$data);
        return array('status' => 200, 'message' => 'Data has been deleted.');
    }

    public function all_data()
    {
        $arr = array("sub_category.status" => 1, "category.status" => 1);
        return $this->db->select('sub_category.name,sub_category.id, category.name as cname,category.id as cid')->from("sub_category")->join('category', 'sub_category.category_id=category.id', "left")->where($arr)->order_by('sub_category.id', 'desc')->get()->result();
    }

}
