<?php
class api_sms{

	//Mã MerchantID dang kí trên Bảo Kim
	$merchant_id = ;//'';
	//Api username 
	$api_username = '';//'soundkindusaorg';
	//Api Pwd d
	$api_password = '';//'kbGG9XzeUH73YRgJrYsB';
	//mat khau di kem ma website dang kí trên B?o Kim
	$secure_code = '';//'8356a6cb0896eaa8';

	$user_the_cao = '';

	$pass_the_cao = '';

	function __construct($merchant_id,$api_username,$api_password,$secure_code,$user_the_cao,$pass_the_cao){
		$this->merchant_id = $merchant_id
		$this->api_username = $api_username;
		$this->api_password = $api_password;
		$this->secure_code = $secure_code;
		$this->user_the_cao = $user_the_cao;
		$this->pass_the_cao = $pass_the_cao;
	}
	/*
	    'type_card' => 'VNP',// VNP hoặc VMS hoặc VIETTEL,VCOIN,GATE 
		MOBI: Thẻ cào MobiFone
		VINA: Thẻ cào VinaPhone
		VIETEL: Thẻ cào Viettel
		VTC: Thẻ cào VTC Coin
		GATE: Thẻ cào FPT Gate
	*/
	function cardPay($pin_card, $card_serial, $type_card, $_order_id){
	    //date_default_timezone_set('Asia/Ho_Chi_Minh');

	    //define('CORE_API_HTTP_USR', 'merchant_19002');
		//define('CORE_API_HTTP_PWD', '19002mQ2L8ifR11axUuCN9PMqJrlAHFS04o');
	    
	    

	    $arrayPost = array(
			'merchant_id' => $this->merchant_id,
			'api_username' => $this->api_username,
			'api_password' => $this->api_password,
			'transaction_id' => $_order_id,
			'card_id' => $type_card ,
			'pin_field' => $pin_card,
			'seri_field' => $card_serial ,
			'algo_mode' =>'hmac'
		);
	    ksort($arrayPost);
		$data_sign = hash_hmac('SHA1',implode('',$arrayPost),$this->secure_code);
		$arrayPost['data_sign'] = $data_sign;
		$bk = 'https://www.baokim.vn/the-cao/restFul/send';
		$curl = curl_init($bk);
		curl_setopt_array($curl, array(
			CURLOPT_POST => true,
			CURLOPT_HEADER => false,
			CURLINFO_HEADER_OUT => true,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HTTPAUTH => CURLAUTH_DIGEST|CURLAUTH_BASIC,
			CURLOPT_USERPWD => $this->user_the_cao.':'.$this->pass_the_cao,
			CURLOPT_POSTFIELDS => http_build_query($arrayPost)
		));

		$data = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$result = json_decode($data,true);
		
		$kq['status'] = 'error';
		$kq['responsive'] = $result;
		if($status == 200){
			$kq['status'] = 'success';
			$kq['time'] = time();
		}
	    return $kq;
	}
}