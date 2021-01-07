<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryModel extends CI_Model
{
    public function create_data($tableName, $data)
    {
        $this->db->insert($tableName, $data);
    }

    public function get_all($vendorId)
    {
        if ($vendorId != null) {
            $arr = array("inventory_bill.status" => 1, "inventory_bill.status" => $vendorId, "vendors.status" => 1);
        } else {
            $arr = array("inventory_bill.status" => 1, "vendors.status" => 1);
        }
        return $this->db->select('inventory_bill.*,vendors.name as vname, vendors.address as vaddress, vendors.phone_no as number,vendors.path as vPath')->from("inventory_bill")->join('vendors', 'vendors.id=inventory_bill.vendor_id', "left")->where($arr)->order_by('inventory_bill.id', 'desc')->get()->result();
    }

    public function detail_data($id)
    {
        $arr = array("products.status" => 1, "sub_category.status" => 1, "category.status" => 1, "vendors.status" => 1, "products.id" => $id);
        return $this->db->select('products.id as id,products.name, products.purchase_price,products.selling_price,products.img,products.created_at, products.name as name, sub_category.name as subname,sub_category.path as spath, sub_category.id as subid, category.name as cname, category.id as cid, category.path as cpath, products.vendor_id, vendors.name as vname, vendors.address as vaddress, vendors.phone_no as number,vendors.path as vPath')->from("products")->join('sub_category', 'sub_category.id=products.sub_category_id', "left")->join('category', 'category.id=sub_category.category_id', "left")->join('vendors', 'vendors.id=products.vendor_id', "left")->where($arr)->order_by('products.id', 'desc')->get()->row();
    }

    public function checkInvoiceNumberExists($invoiceStr)
    {
        $arr = array("invoice_number" => $invoiceStr);
        return $this->db->select('id')->from("inventory_bill")->where($arr)->get()->row();

    }

    public function getInvoiceDetailsByVendorId($invoiceStr, $vendorId)
    {
        $arr = array("inventory.invoice_number" => $invoiceStr, "inventory.vendor_id" => $vendorId, "products.status" => 1, "sub_category.status" => 1, "category.status" => 1);
        return $this->db->select('inventory.*,products.name as pName,sub_category.name as subname,sub_category.path as spath, sub_category.id as subid, category.name as cname, category.id as cid, category.path as cpath')->from("inventory")->join('products', 'inventory.product_id=products.id', "left")->join('sub_category', 'sub_category.id=products.sub_category_id', "left")->join('category', 'category.id=sub_category.category_id', "left")->where($arr)->get()->result();


    }

}