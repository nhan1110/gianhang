<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();

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

    public function add($url = ''){
        if(isset($url) && $url != null && $url != ''){
            $ip = $this->_get_client_ip();
            $browser = $this->_get_browser();
            $os = $this->_get_os();
            if($browser != "Unknown Browser" && $os!= "Unknown OS Platform"){
                $tracking_view_check = new Tracking_View();
                $tracking_view_check->where(array('URL' => $url,'IP' => $ip))->get(1);
                if( !(isset($tracking_view_check->ID) && $tracking_view_check->ID !=null) ){
                    $tracking_view = new Tracking_View();
                    $tracking_view->URL = $url;
                    $tracking_view->BROW = $browser;
                    $tracking_view->IP = $ip;
                    $tracking_view->OS = $os;
                    $tracking_view->Date = date('Y-m-d H:i:s');
                    if($tracking_view->save()){
                        $tracking = new Tracking();
                        $tracking->where(array('URL' => $url))->get(1);
                        if(isset($tracking->ID) && $tracking->ID != null ){
                            $num_view = $tracking->Num_View + 1;
                            $arr = array(
                                'Num_View' => $num_view
                            );
                            $tracking->where(array('URL' => $url))->update($arr);
                        }
                        else{
                            $tracking = new Tracking();
                            $tracking->URL = $url;
                            $tracking->Num_Rate = 0;
                            $tracking->Num_View = 1;
                            $tracking->Num_Comment = 0;
                            $tracking->save();
                        }
                    }
                }
            }
        }
    }


    function _get_client_ip() {
        return $this->session->userdata('ip_address');

        /*
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;*/
    }
    function _get_os() { 
        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";
        $os_array =   array(
        	'/Windows nt 10.0/i'    =>  'Windows 10',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform   =  $value;
            }
        }   
        return $os_platform;
    }

    function _get_browser() {
        $user_agent     =   $this->session->userdata('user_agent');//$_SERVER['HTTP_USER_AGENT'];
        $browser        =   "Unknown Browser";
        $browser_array  =   array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $browser  = $value;
            }
        }
        return $browser;
    }
}