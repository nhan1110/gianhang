<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hook_Admin_Inbox {

    public function load_inbox() 
    {
    	$ci = &get_instance();
        $ci->load->library('session');
	        
    	if ($ci->session->userdata('admin_logged_in') !== FALSE) {
    		if ($ci->session->userdata('inbox_admin') === NULL || $ci->session->userdata('inbox_admin') === FALSE) {
		        $model = new Cronjobnotification_model();
		        $model->order_by('Createdat', 'DESC');//->where('Status','0')
		        $model->get();
		        
		        $model_count = new Cronjobnotification_model();
		        $count = $model_count->where('Status','0')->count();
		        
		        $html = '<li class="dropdown notifications-menu">
                           	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           		<i class="fa fa-bell-o"></i>
                           		<span class="label label-warning">' . $count . '</span>
                           </a>
                           <ul class="dropdown-menu">
                              	<li class="header">Bạn có ' . $count . ' thông báo</li>
                              	<li>
                                 	<ul class="menu">';
		        
		        foreach ($model as $item) {
		        	$html .= '	<li>
	                               	<a href="#">
	                               		<i class="fa fa-users text-aqua"></i> ' . $item->Title . '
	                               </a>
	                            </li>';
		        }
		        
		        $html .= '		</ul>
		        			</li>
                            <li class="footer"><a href="'.base_url('admin/notification_admin/').'">View all</a></li>
                        </ul>
                	</li>';
		        $ci->session->set_userdata('notification_admin', $html);
        	}
	    }
    }
}
