<?php
require __DIR__ . '/paypal/Paypal.php';
defined('BASEPATH') OR exit('No direct script access allowed');
class Upgrade extends CI_Controller {
    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $type_member = "Member";
    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->type_member = $this->user_info["type_member"];
            $this->data["is_login"] = $this->is_login;
            $this->data["user_info"] = $this->user_info;
        } else {
            if ($this->input->is_ajax_request()) {
                die(json_encode(array('status' => 'error')));
            } else {
                redirect(base_url());
            }
        }
    }

    public function index() {
        $up = new Upgrades();
        $this->data["upgrade"] = $up->get_raw()->result_array();
        if($this->input->get('method') != null && $this->input->get('method') != null){
            $method = $this->input->get('method');
            $type = $this->input->get('type');
            if($type == 'huy-bo'){
                $this->data['cancel'] = 'Thanh toán của bạn thất bại. Vui lòng thử lại.';
                if($method == 'baokim'){
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 1){
                        $this->data['cancel'] = 'Giao dịch chưa xác minh OTP.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 2){
                        $this->data['cancel'] = 'Giao dịch đã xác minh OTP.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 5){
                        $this->data['cancel'] = 'Giao dịch bị hủy.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 6){
                        $this->data['cancel'] = 'Giao dịch bị từ chối nhận tiền.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 7){
                        $this->data['cancel'] = 'Giao dịch hết hạn.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 8){
                        $this->data['cancel'] = 'Giao dịch thất bại.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 12){
                        $this->data['cancel'] = 'Giao dịch bị đóng băng.';
                    }
                    if(isset($_GET['payment_status']) && $_GET['payment_status'] == 15){
                        $this->data['cancel'] = 'Giao dịch bị hủy khi chưa xác minh OTP.';
                    }
                }
                else if($method == 'nangluong'){

                }
                else if($method == 'paypal' || $method == 'onepay'){

                }
            }
            else{

            }
        }
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/upgrade/index', $this->data);
        $this->load->view('fontend/block/footer');
    }

    public function payment($id = null){
        $ps = new Payments();
        $this->data["payments"] = $ps->where(array("Show" => "1","Status" => "1"))->order_by("Sort","DESC")->get_raw()->result_array();
        $up = new  Upgrades();
        $record = $up->where("ID",$id)->get_raw()->row_array();
        
        if($record!= null){
            if($this->input->post()){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
                $this->form_validation->set_rules('first_name', 'Họ', 'trim|required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Tên', 'trim|required|xss_clean');
                $this->form_validation->set_rules('phone_number', 'Số điện thoại', 'trim|required|xss_clean');
                $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|xss_clean');
                $this->form_validation->set_rules('payment', 'Phương thức thanh toán', 'trim|required|xss_clean');
                if ($this->form_validation->run() === FALSE) {
                    $this->data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                }
                else{
                    $first_name = $this->input->post("first_name");
                    $last_name = $this->input->post("last_name");
                    $company = $this->input->post("company");
                    $email = $this->input->post("email");
                    $phone_number = $this->input->post("phone_number");
                    $address = $this->input->post("address");
                    $payment = $this->input->post("payment");

                    $ph = new Payments_History();
                    $ph->Member_ID = $this->user_id;
                    $ph->First_Name = $first_name;
                    $ph->Last_Name = $last_name;
                    $ph->Email = $email;
                    $ph->Company = $company;
                    $ph->Phone = $phone_number;
                    $ph->Address = $address;
                    $ph->Total = ($record["Number_Month"] * $record["Price_One_Month"]);
                    $ph->Status = "pendding";
                    $ph->Createat = date('Y-m-d H:i:s');
                    $ph->Updateat = date('Y-m-d H:i:s');
                    $ph->Upgrade_ID = $id;

                    //Paypal
                    if($payment == 2){
                        $paypal = $ps->where("Slug","paypal")->get_raw()->row_array();
                        $setting = json_decode($paypal["Setting"],true);
                        $paypal_clientId = $setting["client-id"];
                        $paypal_clientSecret = $setting["secret"];
                        $pm = new Paypal($record,$paypal_clientId,$paypal_clientSecret);
                        $return_url = base_url("/upgrade/checkout_paypal/".$id."/");
                        $cancel_url = base_url('/upgrade/?method=paypal&type=huy-bo');
                        $data_paypal = $pm->CreatePaymentUsingPayPal($return_url,$cancel_url); 
                        if($data_paypal != null){
                            $ph->Type = "paypal";           
                            $ph->Return_ID = $data_paypal["payment"]["id"];
                            $ph->save();
                            redirect($data_paypal["approvalUrl"]);
                        }
                    }

                    //Onepay
                    if($payment == 1){
                    	$return_id = date ( 'YmdHis' ) . rand ();
                    	$onepay_arg = [];
                    	$onepay = $ps->where("Slug","chuyen-khoan-ngan-hang")->get_raw()->row_array();
                    	$setting = json_decode($onepay["Setting"],true);
                    	$onepay_arg = array(
                    		'Title' => 'Nâng cấp tài khoản '.$record["Number_Month"].' tháng',
    					    'vpc_AccessCode' => $setting["merchant-accesscode"],
    					    'vpc_Amount' => ($record["Number_Month"] * $record["Price_One_Month"]) * 100,
    					    'vpc_Command' => 'pay',
    					    'vpc_Currency' => 'VND',
    					    'vpc_Customer_Email' => 'support@onepay.vn',
    					    'vpc_Customer_Id' => 'thanhvt',
    					    'vpc_Customer_Phone' => $phone_number,
    					    'vpc_Locale' => 'vn',
    					    'vpc_MerchTxnRef' => $return_id,
    					    'vpc_Merchant' => $setting["merchant-id"],
    					    'vpc_OrderInfo' => 'Nâng cấp tài khoản '.$record["Number_Month"].' tháng',
    					    'vpc_ReturnURL' => base_url("/upgrade/checkout_onepay/".$id."/"),
    					    'vpc_TicketNo' => '::1',
    					    'vpc_Version' => '2'
                    	);
                    	ksort($onepay_arg);
                    	$SECURE_SECRET = $setting["hash-code"];
                    	$vpcURL = "https://mtf.onepay.vn/onecomm-pay/vpc.op?";
                    	$appendAmp = 0;
                    	$stringHashData = "";
                    	foreach ($onepay_arg as $key => $value) {
                    		if (strlen($value) > 0) {
    					        if ($appendAmp == 0) {
    					            $vpcURL .= urlencode($key) . '=' . urlencode($value);
    					            $appendAmp = 1;
    					        } else {
    					            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
    					        }
    					        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
    							    $stringHashData .= $key . "=" . $value . "&";
    							}
    					    }
                    	}
                    	$stringHashData = rtrim($stringHashData, "&");
                    	if (strlen($SECURE_SECRET) > 0) {
        					$vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)));
    					}
    					$ph->Type = "onepay";           
                        $ph->Return_ID = $return_id;
                        $ph->save();
    					redirect($vpcURL);
                    }

                    //SMS
                    if($payment == 9){
                        $sms = $ps->where("Slug","thanh-toan-bang-sms")->get_raw()->row_array();
                        $setting = json_decode($sms["Setting"],true);
                        $merchant_id = @$setting['merchant_id'];
                        $api_username = @$setting['api_username'];
                        $api_password = @$setting['api_password'];
                        $secure_code = @$setting['secure_code'];
                        $user_the_cao = @$setting['user_the_cao'];
                        $pass_the_cao = @$setting['pass_the_cao'];
                        
                        $pin_card = strip_tags($this->input->post('pin_card'));
                        $card_serial = strip_tags($this->input->post('card_serial'));
                        $type_card = strip_tags($this->input->post('type_card'));
                        $order_id = md5(time());
                        include_once('CheckOut/SMSCheckOut.php');
                        $api_sms = new api_sms($merchant_id,$api_username,$api_password,$secure_code,$user_the_cao,$pass_the_cao);
                        $check = $api_sms->cardPay($pin_card, $card_serial, $type_card, $order_id);
                        if(isset($check['status']) && $check['status'] = 'success'){
                            $ph->Type = "sms";
                            $ph->Status = "success";         
                            $ph->Return_ID = $order_id;
                            $ph->save();

                            $this->update_success($order_id);
                            redirect(base_url('/upgrade/success/'));
                        }
                        else{
                            $ph->Type = "sms";
                            $ph->Status = "fail";         
                            $ph->Return_ID = $order_id;
                            $ph->save();
                            redirect(base_url('/upgrade/?method=sms&type=huy-bo'));
                        }
                    }

                    //Ngân Lượng
                    if($payment == 8){
                        ob_start();
                        $order_id = md5(time());
                        $nangluong = $ps->where("Slug","thanh-toan-qua-ngan-luong")->get_raw()->row_array();
                        $setting = json_decode($nangluong["Setting"],true);
                        $merchant_id = @$setting['merchant_id'];
                        $merchant_password = @$setting['merchant_password'];
                        $receiver_email = @$setting['receiver_email'];
                        include_once('CheckOut/NangLuongCheckOut.php');
                        $NL = new NangLuongCheckOut($merchant_id,$merchant_password,$receiver_email);
                        
                        $order_code = time();
                        $total_amount = ($record["Number_Month"] * $record["Price_One_Month"]);
                        $payment_type = '';
                        $order_description = 'Nâng cấp tài khoản.';
                        $tax_amount = 0;
                        $fee_shipping = 0;
                        $discount_amount = 0;
                        $cancel_url = base_url('/upgrade/?method=nangluong&type=huy-bo');
                        $return_url = base_url('/upgrade/checkout_nangluong/'.$order_id.'/');
                        
                        $buyer_fullname = $this->input->post("first_name").' '.$this->input->post("last_name");
                        $buyer_email = $this->input->post("email");
                        $buyer_mobile = $this->input->post("phone_number");
                        $buyer_address = $this->input->post("address");

                        $array_items = array();
                        $array_items[0] = array(
                            'item_name1' => 'Nâng cấp tài khoản( Gói '.$record["Number_Month"].' tháng)',
                            'item_quantity1' => 1,
                            'item_amount1' => $total_amount,
                            'item_url1' => base_url()
                        );

                        $nl_result = $NL->NLCheckout($order_code,$total_amount,$payment_type,$order_description,$tax_amount,
                                                    $fee_shipping,$discount_amount,$return_url,urlencode($cancel_url),$buyer_fullname,$buyer_email,$buyer_mobile, 
                                                    $buyer_address,$array_items);
                        $ph->Type = "nangluong";           
                        $ph->Return_ID = $order_id;
                        $ph->save();
                        redirect((string)$nl_result->checkout_url);
                        die;
                        ob_end_flush();
                    }


                    //Bảo Kim
                    if($payment == 7){
                        ob_start();
                        $baokim = $ps->where("Slug","thanh-toan-qua-bao-kim")->get_raw()->row_array();
                        $setting = json_decode($baokim["Setting"],true);
                        $merchant_id = @$setting['merchant_id'];
                        $secure_pass = @$setting['secure_pass'];
                        $business = @$setting['business'];
                        
                        include_once('CheckOut/BaoKimPayment.php');
                        $BK = new BaoKimPayment($merchant_id,$secure_pass,$business);
                        $total_amount = ($record["Number_Month"] * $record["Price_One_Month"]);
                        $shipping_fee = 0;
                        $tax_fee = 0;
                        $order_description = 'Nâng cấp tài khoản.';
                        $url_success = base_url('/upgrade/checkout_baokim/'.$order_id.'/');
                        $url_cancel = base_url('/upgrade/?method=baokim&type=huy-bo');
                        $url_detail = '';
                        $order_id = md5(time());
                        $url = $BK->createRequestUrl($total_amount,$order_id, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail);
                        $ph->Type = "baokim";           
                        $ph->Return_ID = $order_id;
                        $ph->save();
                        redirect($url);
                        die;
                        ob_end_flush();
                    }

                }
            }
            $this->data["upgrade"] = $record;
            $this->load->view('fontend/block/header', $this->data);
            $this->load->view('fontend/upgrade/payment', $this->data);
            $this->load->view('fontend/block/footer');
        }else{
            redirect(base_url("upgrade"));
        }
    }

    public function checkout_paypal($id = null){
        if($this->input->get()){
            if($this->input->get("success") && $this->input->get("success") == "true" && $this->input->get("paymentId") && $this->input->get("PayerID")){
                $ps = new Payments();
                $up = new  Upgrades();
                $paypal = $ps->where("Slug","paypal")->get_raw()->row_array();
                $record = $up->where("ID",$id)->get_raw()->row_array();
                $setting = json_decode($paypal["Setting"],true);
                $paypal_clientId = $setting["client-id"];
                $paypal_clientSecret = $setting["secret"];
                $pm = new Paypal($record,$paypal_clientId,$paypal_clientSecret);
                $rps_arg = $pm->ExecutePayment();
                $ph = new Payments_History();
                if($rps_arg != null && is_array($rps_arg)){
                	$check_record = $ph->where(array("Return_ID"=>$rps_arg["id"],"Status" => "pendding"))->get_raw()->row_array();
                	if($check_record != null){
	                	$data_update = array(
	                		"Status" => "success",
	                		"Updateat" => date('Y-m-d H:i:s'),
	                		"Return_Data" => json_encode($rps_arg)
	                	);
	                	$ph->where("Return_ID",$rps_arg["id"])->update($data_update);
	                	$this->update_success($rps_arg["id"]);
	                	redirect(base_url("upgrade/payment/".$id."/?payment=success"));
                	}
                }
            }
        }
        redirect(base_url("upgrade/payment/".$id."/?payment=error"));
    }

    public function checkout_onepay($id){
    	if($this->input->get()){
    		$vpc_TxnResponseCode = $this->input->get("vpc_TxnResponseCode");
    		$vpc_MerchTxnRef = $this->input->get("vpc_MerchTxnRef");
    		if($vpc_TxnResponseCode == 0 || $vpc_TxnResponseCode == "0"){
    			$ph = new Payments_History();
    			$check_record = $ph->where(array("Return_ID"=>$vpc_MerchTxnRef,"Status" => "pendding"))->get_raw()->row_array();
    			if($check_record != null){
    				$data_update = array(
	            		"Status" => "success",
	            		"Updateat" => date('Y-m-d H:i:s'),
	            		"Return_Data" => json_encode($_GET)
	            	);
	            	$ph->where("Return_ID",$vpc_MerchTxnRef)->update($data_update);
	            	$this->update_success($vpc_MerchTxnRef);
	            	redirect(base_url("upgrade/payment/".$id."/?payment=success"));
    			}
    		}else{
    			$data_update = array(
            		"Status" => "error",
            		"Updateat" => date('Y-m-d H:i:s'),
            		"Return_Data" => json_encode($_GET)
            	);
            	$ph->where("Return_ID",$vpc_MerchTxnRef)->update($data_update);
    		}
    		
    	}
    	redirect(base_url("upgrade/payment/".$id."/?payment=error"));
    }

    public function checkout_baokim($order_id = null){
        //$order_id  = $this->input->get('order_id');
        $transaction_id  = $this->input->get('transaction_id');
        $created_on  = $this->input->get('created_on');
        $payment_type  = $this->input->get('payment_type');
        $transaction_status  = $this->input->get('transaction_status');
        $total_amount  = $this->input->get('total_amount');
        $net_amount  = $this->input->get('net_amount');
        $fee_amount  = $this->input->get('fee_amount');
        $merchant_id  = $this->input->get('merchant_id');
        $client_fullname  = $this->input->get('customer_name');
        $client_email  =$this->input->get('customer_email');
        $client_phone  = $this->input->get('customer_phone');
        $client_address  = $this->input->get('customer_address');
        $Checksum  = $this->input->get('Checksum');
        if(isset($transaction_status) && ($transaction_status == 4 || $transaction_status == 13) && isset($order_id) && $order_id!=null){
            $ph = new Payments_History();
            $ph->where(array('Member_ID' => $this->user_id,'Return_ID' => $order_id,"Status" => "pendding"))->get_raw()->row_array();
            if(isset($ph) && $ph!=null) {
                $arr = array(
                    'Status' => 'success',
                    "Updateat" => date('Y-m-d H:i:s')
                );
                $ph->where(array('Member_ID' => $this->user_id,'Return_ID' => $order_id,'Type' => 'baokim'))->update($arr);
                $this->update_success($order_id);
                redirect(base_url('/upgrade/success/'));
            }
            redirect(base_url('/upgrade/?method=baokim&type=huy-bo&payment_status='.$transaction_status));
        }
        else{
            redirect(base_url('/upgrade/?method=baokim&type=huy-bo&payment_status='.$transaction_status));
        }
    }


    public function checkout_nangluong($order_id = null){
        $ps = new Payments();
        $nangluong = $ps->where("Slug","thanh-toan-qua-ngan-luong")->get_raw()->row_array();
        $setting = json_decode($nangluong["Setting"],true);
        $merchant_id = @$setting['merchant_id'];
        $merchant_password = @$setting['merchant_password'];
        $receiver_email = @$setting['receiver_email'];
        include_once('CheckOut/NangLuongCheckOut.php');
        $NL = new NangLuongCheckOut($merchant_id,$merchant_password,$receiver_email);
        $token = $this->input->get('token');
        $nl_result = $nlcheckout->GetTransactionDetail($token);
        if($nl_result){
            $nl_errorcode           = (string)$nl_result->error_code;
            $nl_transaction_status  = (string)$nl_result->transaction_status;
            if($nl_errorcode == '00') {
                if($nl_transaction_status == '00') {
                    $ph = new Payments_History();
                    $ph->where(array('Member_ID' => $this->user_id,'Return_ID' => $order_id,"Status" => "pendding"))->get_raw()->row_array();
                    if(isset($ph) && $ph!=null) {
                        $arr = array(
                            'Status' => 'success',
                            "Updateat" => date('Y-m-d H:i:s')
                        );
                        $ph->where(array('Member_ID' => $this->user_id,'Return_ID' => $order_id,'Type' => 'baokim'))->update($arr);
                        $this->update_success($order_id);
                        redirect(base_url('/upgrade/success/'));
                    }
                }
            }  
        }
        redirect(base_url('/upgrade/?method=nganluong&type=huy-bo'));
    }


    private function update_success($return_id = null){
        $ph = new Payments_History();
        $mu = new Member_Upgrades();
        $check = $mu->where(array("Member_ID" => $this->user_id))->get_raw()->row_array();
        $upgrade = $ph->get_record_payment($return_id);
        $datime = date('Y-m-d H:i:s'); 
        if($record != null){                      
            if($check == null){
                $endday = date('Y-m-d', strtotime('+'.$upgrade["Number_Month"].' month'));
                $mu->Member_ID = $this->user_id;
                $mu->Start_Day = $datime;
                $mu->Upgrades_ID = $upgrade['ID'];
                $mu->End_Day   = $endday;
                $mu->Createat  = $datime;
                $mu->Updateat  = $datime;
                $mu->save();
            }else{
                if($check['Upgrades_ID'] == $upgrade['ID']){
                    $endday = date("Y-m-d", strtotime('+'.$upgrade["Number_Month"].' month',strtotime($check["End_Day"])));
                    $data_update = array(
                        "End_Day" => $endday,
                        "Updateat" => $datime
                    );
                }
                else{
                    $endday = date('Y-m-d', strtotime('+'.$upgrade["Number_Month"].' month'));
                    $data_update = array(
                        "End_Day" => $endday,
                        "Updateat" => $datime,
                        "Upgrades_ID" => $package_id
                    );
                }
                $mu->where("Member_ID",$this->user_id)->update($data_update);
            }
            return true;
        }
        return false;
    }
}
