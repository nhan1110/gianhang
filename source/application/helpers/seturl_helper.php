<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('slugify'))
{
	function skin_url($url="")
	{ 
		return base_url("skins/".$url."");
	}
}

if (!function_exists('sendmail')) {
    function sendmail($to, $subject, $content, $other = null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";
        $CI = & get_instance();
        $CI->load->library('email');
        $CI->email->set_mailtype("html");
        $CI->email->from('gianhangcuatoi@gmail.com', 'Giang Hàng Của Tôi');
        $CI->email->to($to);
        if ($other != null && $other != '') {
            $CI->email->cc($other);
        }
        $CI->email->subject($subject);
        $CI->email->message($content);
        $CI->email->send();
    }

};
