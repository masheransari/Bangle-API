<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PurchasingModel');
        $this->load->library("Common");
    }

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $resp = $this->PurchasingModel->get_all(null);
                    if ($resp != null && count($resp) > 0) {
                        for ($x = 0; $x < count($resp); $x++) {
                            $invoice = $resp[$x]->invoice_number;
                            $vendor = $resp[$x]->vendor_id;
                            $details = $this->PurchasingModel->getInvoiceDetailsByVendorId(
                                $invoice,
                                $vendor
                            );
                            $resp[$x]->details = $details;
                        }

                        json_output(200, $this->common->getGenericResponse("purchasing", $resp, "Purchasing Founds"));
                    } else {
                        json_output(200, $this->common->getGenericResponse("purchasing", null, "No Purchasing Found"));
                    }
                }
            }
        }
    }

    public function vendor_purchasing()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $data = json_decode($this->input->raw_input_stream, true);
                    $resp = $this->PurchasingModel->get_all($data['vendor_id']);
                    if ($resp != null && count($resp) > 0) {
                        for ($x = 0; $x < count($resp); $x++) {
                            $invoice = $resp[$x]->invoice_number;
                            $vendor = $resp[$x]->vendor_id;
                            $details = $this->PurchasingModel->getInvoiceDetailsByVendorId(
                                $invoice,
                                $vendor
                            );
                            $resp[$x]->details = $details;
                        }

                        json_output(200, $this->common->getGenericResponse("purchasing", $resp, "Purchasing Founds"));
                    } else {
                        json_output(200, $this->common->getGenericResponse("purchasing", null, "No Purchasing Found"));
                    }
                }
            }
        }
    }


    public function getInvoiceNumber()
    {
        $found = false;
        $invoice = "";
        while (!$found) {
            $invoice = "RUS-" . (rand(1000, 100000) + 10000);
            $resp = $this->PurchasingModel->checkInvoiceNumberExists($invoice);
            if ($resp != null && count($resp) > 0) {

            } else {
                $found = true;
            }
        }
        return $invoice;
    }

    public function add_purchasing()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode($this->input->raw_input_stream, true);
        if ($method != 'POST') {
            json_output(200, $this->common->getGenericErrorResponse(400, 'Bad request.'));
        } else {
            $check_auth_client = $this->MyModel->check_auth_client();
            if ($check_auth_client == true) {
                $response = $this->MyModel->auth();
                if ($response != NULL && $response['status'] == 200) {
                    $data = json_decode($this->input->raw_input_stream, true);
                    $invoiceNumber = $this->getInvoiceNumber();
                    $totalAmount = 0.0;
                    $amountPaid = 0.0;
                    $amountRemaining = 0.0;
                    for ($x = 0; $x < count($data); $x++) {
                        $currentDate = date('Y-m-d H:i:s');
                        $totalAmount = $totalAmount + $data[$x]['total_amount'];
                        $amountPaid = $amountPaid + $data[$x]['amount_paid'];
                        $amountRemaining = $amountRemaining + $data[$x]['remaining_amount'];
                        $data[$x]['invoice_number'] = $invoiceNumber;
                        $data[$x]['date'] = date('Y-m-d H:i:s');
                        $data[$x]['created_at'] = $currentDate;
                        $data[$x]['updated_at'] = $currentDate;
                        $data[$x]['created_by'] = $this->input->get_request_header('User-ID', TRUE);
                        $data[$x]['updated_by'] = $this->input->get_request_header('User-ID', TRUE);
                        $data[$x]['status'] = 1;
                        $this->PurchasingModel->create_data("purchase", $data[$x]);
                    }
//
                    $timeStamp = date('Y-m-d H:i:s');
                    $purchasingBill = array(
                        "vendor_id" => $data[0]['vendor_id'],
                        "invoice_number" => $invoiceNumber,
                        "total_amount" => $totalAmount,
                        "amount_paid" => $amountPaid,
                        "remaining_amount" => $amountRemaining,
                        "created_by" => $this->input->get_request_header('User-ID', TRUE),
                        "updated_by" => $this->input->get_request_header('User-ID', TRUE),
                        "created_at" => $timeStamp,
                        "updated_at" => $timeStamp,
                        "status" => 1,
                    );
                    $this->PurchasingModel->create_data("purchase_bill", $purchasingBill);

                    json_output(200, $this->common->getGenericResponse("response", null, "Purchasing Added"));
                }
            }
        }
    }
}