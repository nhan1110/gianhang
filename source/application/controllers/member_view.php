<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member_View extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $filter = array();
    private $type = array();
    private $per_page = 12;

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->type_member = $this->user_info["type_member"];
        }
        $this->filter = array('today','yesterday','-3 Day','-7 Day','-15 Day',"-1 Month","-2 Month","-3 Month","-6 Month","-1 Year",'All');
        $this->type = array('product','stand');
        $this->data["is_login"] = $this->is_login;
        $this->data["user_info"] = $this->user_info;
    }

    public function index(){
        $json = $this->input->cookie('member_viewed',true);
        $paging = 1;
        $list_id = '';
        if($this->is_login){
            $sql = "SELECT p.*,m.Path_Thumb,mv.Date_Created AS time_view,mv.ID AS view_id
                    FROM Member_Viewed AS mv
                    INNER JOIN Products AS p ON mv.URL = concat('/product/details/',p.ID)
                    LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                    LEFT JOIN Media_Product AS mp ON mp.Product_ID = p.ID
                    LEFT JOIN Media AS m ON m.ID = mp.Media_ID
                    WHERE mv.Member_ID = $this->user_id AND p.Disable = '0'
                    ORDER BY mv.ID DESC
                    LIMIT 0 , $this->per_page ";

            $sql_count = "SELECT count(p.ID) AS count
                    FROM Member_Viewed AS mv
                    INNER JOIN Products AS p ON mv.URL = concat('/product/details/',p.ID)
                    LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                    WHERE mv.Member_ID = $this->user_id AND p.Disable = '0'
                    ORDER BY mv.ID DESC";


            $this->data['result'] = $this->Common_model->query_raw($sql);
            $result_count = $this->Common_model->query_raw($sql_count);
            $this->data['count'] = isset($result_count[0]['count']) && $result_count[0]['count']!=null ? $result_count[0]['count'] : 0;

        }
        else{
            $list_id .= '(';
            if(isset($json) && $json!=null){
                $history = json_decode($json,true);
                $temp = @$history['product'];
                if(isset($temp) && $temp != null && is_array($temp)){
                    foreach ($temp as $key => $value) {
                        $list_id .= $value.',';
                    }
                }
            }
            $list_id .= '-1)';
            $sql = "SELECT p.*,m.Path_Thumb
                    FROM Products AS p
                    LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                    LEFT JOIN Media_Product AS mp ON mp.Product_ID = p.ID
                    LEFT JOIN Media AS m ON m.ID = mp.Media_ID
                    WHERE p.ID IN $list_id AND p.Disable = '0'
                    LIMIT 0 , $this->per_page ";

            $sql_count = "SELECT count(p.ID) AS count
                    FROM Products AS p
                    LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                    WHERE p.ID IN $list_id AND p.Disable = '0'";

            $this->data['result'] = $this->Common_model->query_raw($sql);
            $result_count = $this->Common_model->query_raw($sql_count);
            $this->data['count'] = isset($result_count[0]['count']) && $result_count[0]['count']!=null ? $result_count[0]['count'] : 0;
        }
        $this->data['offset'] = $paging;
        $this->data['per_page'] = $this->per_page;
        $this->data['type'] = 'product';
        $this->data['value'] = 'today';
        $this->load->view('fontend/block/header', $this->data);
        $this->load->view('fontend/history/index',$this->data);
        $this->load->view('fontend/block/footer',$this->data);
    }

    public function get_result(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $type = 'product';
        $value = 'today';
        $paging = $this->input->post('paging')!=null && is_numeric($this->input->post('paging')) ? abs($this->input->post('paging')) : 1;
        if($this->input->post('type') != null && in_array($this->input->post('type'), $this->type)){
            $type = $this->input->post('type');
        }
        if($this->input->post('value') != null && in_array($this->input->post('value'), $this->filter) && $this->input->post('value') != 'All'){
            $value = $this->input->post('value');
        }

        $date = date('Y-m-d 23:59:59',strtotime('now'));
        if($value != 'today'){
            $date = date('Y-m-d 23:59:59',strtotime($value));
        }

        $this->data['offset'] = $paging;
        $this->data['per_page'] = $this->per_page;
        $this->data['type'] = $type;
        $this->data['value'] = $value;
        $this->data['count'] = 0;
        $list_id = '';
        if($this->is_login){
            if($type == 'stand'){

            }
            else{
            	$offset = ($paging-1)*$this->per_page;
                $sql = "SELECT p.*,m.Path_Thumb,mv.Date_Created AS time_view,mv.ID AS view_id
                    FROM Member_Viewed AS mv
                    INNER JOIN Products AS p ON mv.URL = concat('/product/details/',p.ID)
                    LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                    LEFT JOIN Media_Product AS mp ON mp.Product_ID = p.ID
                    LEFT JOIN Media AS m ON m.ID = mp.Media_ID
                    WHERE mv.Member_ID = $this->user_id AND p.Disable = '0' AND mv.Date_Created <= '$date'
                    ORDER BY mv.ID DESC
                    LIMIT $offset , $this->per_page ";


                $sql_count = "SELECT count(p.ID) AS count
                        FROM Member_Viewed AS mv
                        INNER JOIN Products AS p ON mv.URL = concat('/product/details/',p.ID)
                        LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                        WHERE mv.Member_ID = $this->user_id AND p.Disable = '0' AND mv.Date_Created <= '$date'
                        ORDER BY mv.ID DESC";

                $this->data['result'] = $this->Common_model->query_raw($sql);
	            $result_count = $this->Common_model->query_raw($sql_count);
	            $this->data['count'] = isset($result_count[0]['count']) && $result_count[0]['count']!=null ? $result_count[0]['count'] : 0;
            }
        }
        else{
            $json = $this->input->cookie('member_viewed',true);
            if(isset($json) && $json!=null){
                $history = json_decode($json,true);
                if($type == 'product'){
                    $temp = $history['product'];
                    $list_id .= '(';
                    if(isset($temp) && $temp != null && is_array($temp)){
                        foreach ($temp as $key => $value) {
                            $list_id .= $value.',';
                        }
                    }
                    $list_id .= '-1)';

                    $sql = "SELECT p.*,m.Path_Thumb
                            FROM Products AS p
                            LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                            LEFT JOIN Media_Product AS mp ON mp.Product_ID = p.ID
                            LEFT JOIN Media AS m ON m.ID = mp.Media_ID
                            WHERE p.ID IN $list_id AND p.Disable = '0'
                            LIMIT 0 , $this->per_page ";

                    $sql_count = "SELECT count(p.ID) AS count
                            FROM Products AS p
                            LEFT JOIN Member AS mb ON mb.ID = p.Member_ID
                            WHERE p.ID IN $list_id AND p.Disable = '0'";

                    $this->data['result'] = $this->Common_model->query_raw($sql);
                    $result_count = $this->Common_model->query_raw($sql_count);
                    $this->data['count'] = isset($result_count[0]['count']) && $result_count[0]['count']!=null ? $result_count[0]['count'] : 0;
                }
                else{
                    $temp = $history['stand'];
                    if(isset($temp) && $temp != null && is_array($temp)){
                        $list_id .= '(';
                        foreach ($temp as $key => $value) {
                            $list_id .= $value.',';
                        }
                        $list_id .= '-1)';
                    }
                }
            }
        }
        $data['status'] = 'success';
        $data['responsive'] = $this->load->view('fontend/history/result',$this->data,true);
    	die(json_encode($data));
    }
}