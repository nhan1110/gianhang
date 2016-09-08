<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rate extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $secret = '6LejPCcTAAAAAMGS0Sckk1onmnmUGiEhe5_bg1Td';

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->type_member = $this->user_info["type_member"];
        }
        $this->data["is_login"] = $this->is_login;
        $this->data["user_info"] = $this->user_info;
    }

    public function get_rate(){
    	$this->_is_ajax();
    	$data = array('status' => 'error');
    	$url = $this->input->post('url');
    	$limit = 6;
    	$offset = 0;
    	if(!(isset($url) && $url!=null)){
    		die(json_encode($data));
    	}
    	$rate_average = new Rates();
        $rate_average->select_avg('Num_Rate');
        $rate_average->where(array('URL' => $url))->get(1);

        $tracking = new Tracking();
        $tracking->where(array('URL' => $url))->get(1);

        $tracking_rate = new Tracking_Rate();
        $tracking_rate->where(array('URL' => $url))->get(1);

    	$member = new Member();
    	$rate = new Rates();

        $result = $rate->where(array('URL' => $url, 'Member_ID' => $this->user_id))->get(1);

        $data['record'] = array(
            'title' => @$result->Title,
            'content' => @$result->Content,
            'num_rate' => @$result->Num_Rate
        );

    	$sql = "SELECT c.*,m.Avatar,m.Firstname,m.Lastname
    			FROM $rate->table AS c
    			INNER JOIN $member->table AS m ON m.ID = c.Member_ID
    			WHERE c.URL = '$url'
    			ORDER BY c.ID DESC
    			LIMIT $offset, $limit";
        $data['count']  = $arr['count']   = (isset($tracking->Num_Rate) && $tracking->Num_Rate != null) ? $tracking->Num_Rate : 0;
        $arr['result']  = $rate->query($sql);
        $data['average']  = $arr['average'] = isset($rate_average->Num_Rate) && $rate_average->Num_Rate != null ? ROUND($rate_average->Num_Rate,2) : 0;
        $arr['tracking_rate'] = $tracking_rate;
        $data['responsive'] = $this->load->view("fontend/rate/get_rate_all",$arr,true);
    	$data['status'] = 'success';
    	die(json_encode($data));
    }

    public function get_rate_more(){
    	$this->_is_ajax();
    	$data = array('status' => 'error');
    	$url = $this->input->post('url');
    	$limit = 6;
    	$offset = ($this->input->post('paging') != null && is_numeric($this->input->post('paging'))) ? ($this->input->post('paging')-1) : 0;
    	$offset = $offset*$limit;
        if(!(isset($url) && $url!=null)){
    		die(json_encode($data));
    	}
    	$rate_average = new Rates();
        $rate_average->select_avg('Num_Rate');
        $rate_average->where(array('URL' => $url))->get(1);

        $tracking = new Tracking();
        $tracking->where(array('URL' => $url))->get(1);

    	$member = new Member();
    	$rate = new Rates();
    	$sql = "SELECT c.*,m.Avatar,m.Firstname,m.Lastname
    			FROM $rate->table AS c
    			INNER JOIN $member->table AS m ON m.ID = c.Member_ID
    			WHERE c.URL = '$url'
    			ORDER BY c.ID DESC
    			LIMIT $offset, $limit";
        $arr['result']  = $rate->query($sql);
        $data['responsive'] = $this->load->view("fontend/rate/get_rate",$arr,true);
    	$data['count']  = (isset($tracking->Num_Rate) && $tracking->Num_Rate != null) ? $tracking->Num_Rate : 0;
        $data['status'] = 'success';
    	die(json_encode($data));
    }

    public function add(){
    	$this->_is_login();
    	$this->_is_ajax();
        $data = array('status' => 'error');
        $verifyResponse = $this->fetchData('https://www.google.com/recaptcha/api/siteverify?secret='.$this->secret.'&response='.$this->input->post('g-recaptcha-response'));
        $responseData = json_decode($verifyResponse);
        if (!$responseData->success) {
          $data['status'] = 'fail';
          $data['message'] = 'CAPTCHA không được nhập chính xác. Vui lòng thử lại lần nữa.';
          die(json_encode($data));
        }
        
        $rate = new Rates();
        $rate->where(array('Member_ID' => $this->user_id ,'URL' => $this->input->post('url')))->get(1);
        if(isset($rate->ID) && $rate->ID !=null){
            $this->edit($rate->ID);
        	return;
        }
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
            $this->form_validation->set_rules('num_rate', 'Num Rate', 'trim|required');
            $this->form_validation->set_rules('url', 'URL', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $data['status'] = 'fail';
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                die(json_encode($data));
            }
            else{
                $rate = new Rates();
                $rate->Title = strip_tags($this->input->post('title'));
                $rate->Content  = preg_replace("/<img[^>]+\>/i", "(image) ",$this->input->post('content'),'<img>');
                $rate->Num_Rate  = $this->input->post('num_rate');
                $rate->Member_ID = $this->user_id;
                $rate->URL  = $this->input->post('url');
                $rate->Createdat = date('Y-m-d H:i:s');
                $rate->save();
                $rate_id = $rate->get_id_last_save();
                $url = $this->input->post('url');
                if($rate_id > 0){
                    $tracking = new Tracking();
        			$tracking->where(array('URL' => $url))->get(1);
                    if(isset($tracking->ID) && $tracking->ID != null ){
                    	$num_rates = $tracking->Num_Rate + 1;
                    	$arr = array(
                    		'Num_Rate' => $num_rates
                    	);
                    	$tracking->where(array('URL' => $url))->update($arr);
                    }
                    else{
                    	$tracking = new Tracking();
                    	$tracking->URL = $url;
                    	$tracking->Num_Rate = 1;
                    	$tracking->Num_View = 0;
                    	$tracking->Num_Comment = 0;
                    	$tracking->save();
                    }

                    $num_rate = $this->input->post('num_rate');
                    $tracking_rate = new Tracking_Rate();
                    $tracking_rate->where(array('URL' => $url))->get(1);
                    if(isset($tracking_rate->ID) && $tracking_rate->ID != null ){
                    	$arr = array(
                    		'Num_1' => $tracking_rate->Num_1 + (isset($num_rate) && $num_rate == 1 ? 1 : 0),
                    		'Num_2' => $tracking_rate->Num_2 + (isset($num_rate) && $num_rate == 2 ? 1 : 0),
                    		'Num_3' => $tracking_rate->Num_3 + (isset($num_rate) && $num_rate == 3 ? 1 : 0),
                    		'Num_4' => $tracking_rate->Num_4 + (isset($num_rate) && $num_rate == 4 ? 1 : 0),
                    		'Num_5' => $tracking_rate->Num_5 + (isset($num_rate) && $num_rate == 5 ? 1 : 0),
                    	);
                    	$tracking_rate->where(array('URL' => $url))->update($arr);
                    }
                    else{
                    	$tracking_rate = new Tracking_Rate();
                    	$tracking_rate->URL = $url;
                    	$tracking_rate->Num_1 = isset($num_rate) && $num_rate == 1 ? 1 : 0;
                    	$tracking_rate->Num_2 = isset($num_rate) && $num_rate == 2 ? 1 : 0;
                    	$tracking_rate->Num_3 = isset($num_rate) && $num_rate == 3 ? 1 : 0;
                    	$tracking_rate->Num_4 = isset($num_rate) && $num_rate == 4 ? 1 : 0;
                    	$tracking_rate->Num_5 = isset($num_rate) && $num_rate == 5 ? 1 : 0;
                    	$tracking_rate->save();
                    }

                    $data['status'] = 'success';
                    $rate = new Rates();
                    $member = new Member();
                    $sql = "SELECT c.*,m.Avatar,m.Firstname,m.Lastname
			    			FROM $rate->table AS c
			    			INNER JOIN $member->table AS m ON m.ID = c.Member_ID
			    			WHERE c.ID = '$rate_id'";
			        $result['result']  = $rate->query($sql);
                    $data['update_tracking'] = $this->_responsive($rate_id);
                    $data['action'] = 'add';
                    $data['responsive'] = $this->load->view("fontend/rate/get_rate",$result,true);
                }
            }
        }
        die(json_encode($data));
    }

    public function edit($rate_id){
        $data = array('status' => 'error');
        if( !(isset($rate_id) && $rate_id != null) ){
            die(json_encode($data));
        }
        $rate = new Rates();
        $rate->where(array('ID' => $rate_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($rate->ID) && $rate->ID !=null )){
            die(json_encode($data));
        }
        $url = @$rate->URL;
        $num_rate_last = @$rate->Num_Rate;
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
            $this->form_validation->set_rules('num_rate', 'Num Rate', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $data['status'] = 'fail';
                $data['message'] = 'Vui lòng nhập đầy đủ thông tin.';
                die(json_encode($data));
            }
            else{
                $arr = array(
                    'Title' => strip_tags($this->input->post('title')),
                    'Content'  => preg_replace("/<img[^>]+\>/i", "(image) ",$this->input->post('content')),
                    'Num_Rate'  => $this->input->post('num_rate')
                );
                $rate = new Rates();
                if( $rate->where(array('ID' => $rate_id,'Member_ID' => $this->user_id))->update($arr) ){
                    $num_rate = $this->input->post('num_rate');
                    $tracking_rate = new Tracking_Rate();
                    $tracking_rate->where(array('URL' => $url))->get(1);
                    if(isset($tracking_rate->ID) && $tracking_rate->ID != null ){
                    	$arr = array(
                    		'Num_1' => $tracking_rate->Num_1 + (isset($num_rate) && $num_rate == 1 ? 1 : 0) - (isset($num_rate_last) && $num_rate_last == 1 ? 1 : 0),
                    		'Num_2' => $tracking_rate->Num_2 + (isset($num_rate) && $num_rate == 2 ? 1 : 0) - (isset($num_rate_last) && $num_rate_last == 2 ? 1 : 0),
                    		'Num_3' => $tracking_rate->Num_3 + (isset($num_rate) && $num_rate == 3 ? 1 : 0) - (isset($num_rate_last) && $num_rate_last == 3 ? 1 : 0),
                    		'Num_4' => $tracking_rate->Num_4 + (isset($num_rate) && $num_rate == 4 ? 1 : 0) - (isset($num_rate_last) && $num_rate_last == 4 ? 1 : 0),
                    		'Num_5' => $tracking_rate->Num_5 + (isset($num_rate) && $num_rate == 5 ? 1 : 0) - (isset($num_rate_last) && $num_rate_last == 5 ? 1 : 0),
                    	);
                    	$tracking_rate->where(array('URL' => $url))->update($arr);
                    }

                    $result = $rate->where(array('ID' => $rate_id))->get(1);
                    $data['record'] = array(
                        'title' => @$result->Title,
                        'content' => @$result->Content,
                        'num_rate' => @$result->Num_Rate
                    );
                    $data['rate_id'] = $rate_id;
                    $data['status'] = 'success';
                    $data['action'] = 'edit';
                    $data['update_tracking'] = $this->_responsive($rate_id);
                }
            }
        }
        die(json_encode($data));
    }

    public function delete($rate_id = null){
        $this->_is_login();
    	$this->_is_ajax();
        $data = array('status' => 'error');
        if(isset($rate_id) && $rate_id != null){
            die(json_encode($data));
        }
        $url = $this->input->post('url');
        $rate = new Rates();
        $rate->where(array('ID' => $rate_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($rate->ID) && $rate->ID !=null )){
            die(json_encode($data));
        }
        $url = @$rate->URL;
        $num_rate_last = @$rate->Num_Rate;
        $data['responsive'] = $this->_responsive($rate_id);
        $rate->delete_by_id($rate->ID);
        
        $tracking = new Tracking();
		$tracking->where(array('URL' => $url))->get(1);
        if(isset($tracking) && $tracking != null ){
        	$num_rates = @$tracking->Num_Rate;
        	if(is_numeric($num_rates) && $num_rates > 0 ){
        		$num_rates = $num_rates - 1;
        	}
        	$arr = array(
        		'Num_Rate' => $num_rates
        	);
        	$tracking->where(array('URL' => $url))->update($arr);
        }

        $tracking_rate = new Tracking_Rate();
        $tracking_rate->where(array('URL' => $url))->get(1);
        if(isset($tracking_rate) && $tracking_rate != null ){
        	$arr = array(
        		'Num_1' => $tracking_rate->Num_1 - (isset($num_rate_last) && $num_rate_last == 1 ? 1 : 0),
        		'Num_2' => $tracking_rate->Num_2 - (isset($num_rate_last) && $num_rate_last == 2 ? 1 : 0),
        		'Num_3' => $tracking_rate->Num_3 - (isset($num_rate_last) && $num_rate_last == 3 ? 1 : 0),
        		'Num_4' => $tracking_rate->Num_4 - (isset($num_rate_last) && $num_rate_last == 4 ? 1 : 0),
        		'Num_5' => $tracking_rate->Num_5 - (isset($num_rate_last) && $num_rate_last == 5 ? 1 : 0),
        	);
        	$tracking_rate->where(array('URL' => $url))->update($arr);
        }
        $data['status'] = 'success';
        die(json_encode($data));
    }

    function _responsive($rate_id = null){
        $rate = new Rates();
        $rate->where(array('ID' => $rate_id,'Member_ID' => $this->user_id))->get(1);
        $url = @$rate->URL;

        $tracking_rate = new Tracking_Rate();
        $tracking_rate->where(array('URL' => $url))->get(1);

        $tracking = new Tracking();
        $tracking->where(array('URL' => $url))->get(1);

        $rate_average = new Rates();
        $rate_average->select_avg('Num_Rate');
        $rate_average->where(array('URL' => $url))->get(1);

        $responsive = array();
        $responsive['count']  = @$tracking->Num_Rate;
        $responsive['tracking_rate'] = array(
        	'Num_1' => @$tracking_rate->Num_1,
        	'Num_2' => @$tracking_rate->Num_2,
        	'Num_3' => @$tracking_rate->Num_3,
        	'Num_4' => @$tracking_rate->Num_4,
        	'Num_5' => @$tracking_rate->Num_5
        );
        $responsive['average'] = isset($rate_average->Num_Rate) && $rate_average->Num_Rate != null ? ROUND($rate_average->Num_Rate,2) : 0;
        return $responsive;
    }

    function _is_login(){
    	if(!$this->is_login){
    		if ($this->input->is_ajax_request()) {
	            die(json_encode(array('status' => 'error')));
	        } else {
	            redirect(base_url());
	        }
    	}
    }
    function _is_ajax(){
    	if(!$this->input->is_ajax_request()){
	        die(json_encode(array('status' => 'error')));
    	}
    }

    private function fetchData($url,$data = null){
        $curl = $url;
        if(isset($data) && $data !=null && is_array($data)) {
          $request = '?';
          $i = 0;
          foreach ($data as $key => $value) {
              $request .= $key.'='.urlencode($value);
              if($i < count($data) - 1 ){
                 $request .='&';
              }
              $i++;
          }
          $curl = $url.$request;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt($ch, CURLOPT_URL, $curl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}