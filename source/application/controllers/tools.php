<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tools extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
    }
	
    public function cronjob_notification_admin() {
        // Count member joined today
        $member_model = new Member();
        $joined_number = $member_model->where('Createat >', date('Y-m-d') . ' 00:00:00')->where('Createat <=', date('Y-m-d') . ' 23:59:59')->count();
        if ($joined_number > 0) {
        	$model = new Cronjobnotification_model();
            $model->Title = 'Có ' . $joined_number . ' thành viên mới đăng ký hôm nay';
            $model->Createdat = date('Y-m-d H:i:s');
            $model->Type_Notification = '1';// Join Member
            $model->Status = '0';// Unread
            $model->save();
        }
    	
    	// Count member upgrade account today
    	$member_upgrade_model = new Member_Upgrades();
        $upgrade_number = $member_upgrade_model->where('Createat >', date('Y-m-d') . ' 00:00:00')->where('Createat <=', date('Y-m-d') . ' 23:59:59')->count();
        if ($upgrade_number > 0) {
        	$model = new Cronjobnotification_model();
            $model->Title = 'Có ' . $upgrade_number . ' thành viên mới nâng cấp hôm nay';
            $model->Createdat = date('Y-m-d H:i:s');
            $model->Type_Notification = '2';// Upgrade Member
            $model->Status = '0';// Unread
            $model->save();
        }
        
        // 
    }
}