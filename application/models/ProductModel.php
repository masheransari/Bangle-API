<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model
{


    public function detail_data($id)
    {
        $arr = array("products.status" => 1, "sub_category.status" => 1, "category.status" => 1, "vendors.status" => 1, "products.id" => $id);
        return $this->db->select('products.id as id,products.name, products.purchase_price,products.selling_price,products.img,products.created_at, products.name as name, sub_category.name as subname,sub_category.path as spath, sub_category.id as subid, category.name as cname, category.id as cid, category.path as cpath, products.vendor_id, vendors.name as vname, vendors.address as vaddress, vendors.phone_no as number,vendors.path as vPath')->from("products")->join('sub_category', 'sub_category.id=products.sub_category_id', "left")->join('category', 'category.id=sub_category.category_id', "left")->join('vendors', 'vendors.id=products.vendor_id', "left")->where($arr)->order_by('products.id', 'desc')->get()->row();
    }

    public function create_data($data)
    {
        $this->db->insert('products', $data);
    }

    public function update_data($id, $data)
    {
        $arr = array("id" => $id, "status" => 1);
        $this->db->where($arr)->update('products', $data);
    }


    public function delete_data($id, $data)
    {
        $arr = array('id' => $id, 'status' => '1');
        $this->db->where($arr)->update('products', $data);
    }

    public function all_data()
    {
        $arr = array("products.status" => 1, "sub_category.status" => 1, "category.status" => 1, "vendors.status" => 1);
        return $this->db->select('products.id as id,products.name, products.purchase_price,products.selling_price,products.img,products.created_at, products.name as name, sub_category.name as subname,sub_category.path as spath, sub_category.id as subid, category.name as cname, category.id as cid, category.path as cpath, products.vendor_id, vendors.name as vname, vendors.address as vaddress, vendors.phone_no as number,vendors.path as vPath')->from("products")->join('sub_category', 'sub_category.id=products.sub_category_id', "left")->join('category', 'category.id=sub_category.category_id', "left")->join('vendors', 'vendors.id=products.vendor_id', "left")->where($arr)->order_by('products.id', 'desc')->get()->result();
    }

}
