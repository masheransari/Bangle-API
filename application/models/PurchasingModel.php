<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PurchasingModel extends CI_Model
{
    public function create_data($tableName, $data)
    {
        $this->db->insert($tableName, $data);
    }

    public function get_all($vendorId)
    {
        if ($vendorId != null) {
            $arr = array("purchase_bill.status" => 1, "purchase_bill.status" => $vendorId, "vendors.status" => 1);
        } else {
            $arr = array("purchase_bill.status" => 1, "vendors.status" => 1);
        }
        return $this->db->select('purchase_bill.*,vendors.name as vname, vendors.address as vaddress, vendors.phone_no as vnumber,vendors.path as vPath')->from("purchase_bill")->join('vendors', 'vendors.id=purchase_bill.vendor_id', "left")->where($arr)->order_by('purchase_bill.id', 'desc')->get()->result();
    }

    public function detail_data($id)
    {
        $arr = array("products.status" => 1, "sub_category.status" => 1, "category.status" => 1, "vendors.status" => 1, "products.id" => $id);
        return $this->db->select('products.id as id,products.name, products.purchase_price,products.selling_price,products.img,products.created_at, products.name as name, sub_category.name as subname,sub_category.path as spath, sub_category.id as subid, category.name as cname, category.id as cid, category.path as cpath, products.vendor_id, vendors.name as vname, vendors.address as vaddress, vendors.phone_no as vnumber,vendors.path as vPath')->from("products")->join('sub_category', 'sub_category.id=products.sub_category_id', "left")->join('category', 'category.id=sub_category.category_id', "left")->join('vendors', 'vendors.id=products.vendor_id', "left")->where($arr)->order_by('products.id', 'desc')->get()->row();
    }

    public function checkInvoiceNumberExists($invoiceStr)
    {
        $arr = array("invoice_number" => $invoiceStr);
        return $this->db->select('id')->from("purchase_bill")->where($arr)->get()->row();

    }

    public function getInvoiceDetailsByVendorId($invoiceStr, $vendorId)
    {
        $arr = array("purchase.invoice_number" => $invoiceStr, "purchase.vendor_id" => $vendorId, "products.status" => 1, "sub_category.status" => 1, "category.status" => 1);
        return $this->db->select('purchase.*,products.name as pName,sub_category.name as subname,sub_category.path as spath, sub_category.id as subid, category.name as cname, category.id as cid, category.path as cpath')->from("purchase")->join('products', 'purchase.product_id=products.id', "left")->join('sub_category', 'sub_category.id=products.sub_category_id', "left")->join('category', 'category.id=sub_category.category_id', "left")->where($arr)->get()->result();


    }

}