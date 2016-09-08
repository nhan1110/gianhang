<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter Inflector Helpers
 *
 * Customised singular and plural helpers.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team, stensi
 * @link		http://codeigniter.com/user_guide/helpers/inflector_helper.html
 */
// --------------------------------------------------------------------

/**
 * Singular
 *
 * Takes a plural word and makes it singular (improved by stensi)
 *
 * @access	public
 * @param	string
 * @return	str
 */
if (!function_exists('backend_url')) {
    function backend_url($path = '') {
        return base_url() . 'backend/' . $path;
    }
}

if (!function_exists('skin_url')) {
    function skin_url($path = '') {
        return base_url() . 'skins/' . $path;
    }
}

if (!function_exists('skin_admin_url')) {
    function skin_admin_url($path = '') {
        return base_url() . 'skins/admin/' . $path;
    }
}

if (!function_exists('admin_url')) {
    function admin_url($path = '') {
        return base_url() . 'admin/' . $path;
    }
}

if (!function_exists('get_option_multilevel')) {
    function get_option_multilevel($collection,$selected_value="",$is_group=false,$level=0, $max_level=0,$parent_id=0) {
        $strreturn = '';
        if ($collection != null && count($collection) > 0) {
	        foreach ($collection as $key => $value) {
	        	if ($parent_id == $value['Parent_ID']) {
	        		if ($is_group) {
	        			$strreturn .= '<optgroup data-level="' . $level . '" data-id="' . $value['Slug'] . '" label="' . $value['Name'] . '">';
	        			if ($level < $max_level) {
			        		$strreturn .= get_option_multilevel($collection, $selected_value, $is_group, ($level + 1), $max_level , $value['ID']);
			        	}
			        	$strreturn .= '</optgroup>';
	        		} else {
	        			$strreturn .= '<option data-slug="' . @$value['Slug'] . '" value="' . $value['Slug'] . '"';
			        	if ($value['ID'] == $selected_value || @$value['Slug'] == $selected_value) {
			        		$strreturn .= ' selected ';
			        	}
			        	$space = ($level == 0) ? "" : str_repeat("......", $level) . " ";
			        	$strreturn .= '>' . $space . $value['Name'] . '</option>';
			        	if ($level < $max_level) {
			        		$strreturn .= get_option_multilevel($collection, $selected_value, $is_group, ($level + 1), $max_level, $value['ID']);
			        	}
	        		}
	        	}
	        }
		}
        return $strreturn;
    }
}

if (!function_exists('select_option')) {
    function select_option($group,$selected,$default='',$other='') {
        $return = '<select '.$other.'>';
        $return .= '<option value="'.$default.'"> -- Select -- </option>';
        foreach ($group as $key => $value) {
        	$return .= '<option value="' . $key . '"';
        	if ($key == $selected) {
        		$return .= ' selected ';
        	}
        	$return .= '>' . $value . '</option>';
        }
        $return .= '</select>';
        
        return $return;
    }
}

if (!function_exists('dropdownlist')) {
    function dropdownlist($collection, $selected) {
        $group = $collection;
        if (is_object($collection)) {
            $group = json_decode(json_encode($collection),TRUE);
        }
        $return = '';
        foreach ($group as $key => $value) {
            $return .= '<option value="' . $key . '"';
            if ($key == $selected) {
                $return .= ' selected ';
            }
            $return .= '>' . $value . '</option>';
        }
        
        return $return;
    }
}

if (!function_exists('get_paging')) {
    function get_paging($array_init) 
    {
        $config                = array();
        $config["base_url"]    = $array_init["base_url"];
        $config["total_rows"]  = $array_init["total_rows"];
        $config["per_page"]    = $array_init["per_page"];
        $config["uri_segment"] = $array_init["segment"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&raquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        return $config;
    }
}

if (!function_exists('select_option')) {
    function select_option($group,$selected,$default='',$other='') {
        $return = '<select '.$other.'>';
        $return .= '<option value="'.$default.'"> -- Select -- </option>';
        foreach ($group as $key => $value) {
        	$return .= '<option value="' . $key . '"';
        	if ($key == $selected) {
        		$return .= ' selected ';
        	}
        	$return .= '>' . $value . '</option>';
        }
        $return .= '</select>';
        
        return $return;
    }
}

if (!function_exists('paging')) {
    function paging($total_rows, $per_page, $url, $current_page = null, $show_number_page = 5) {
        $arr_url = explode("?", $url);
        $url = $arr_url[0];
        if (substr($url,-1) === '/') {
            $url = substr($url,0,strlen($url)-1);
        }
        $query_string = @$arr_url[1];
        if ($query_string != null && !empty($query_string)) {
            $query_string = "?" . $query_string;
        }

        $total_page = ceil($total_rows / $per_page);
        if ($total_page > 1) {
            $start = 1; // 1
            $end = $show_number_page; // 5
            $center = ceil($show_number_page / 2); // 3
            if ($current_page == null || $current_page <= $center) {
                $start = 1;
            } else { // > 2
                if ($current_page > ($total_page - $center)) {
                    $start = $total_page - $show_number_page + 1;
                    $end = $total_page;
                } else {
                    $start = $current_page - $center + 1; // 2
                    $end = $current_page + $center - 1; // 6
                }
            }
            if ($end > $total_page) {
                $end = $total_page;
            }
            

            $html = '<ul class = "pagination pagination-md  no-margin pull-right">';
            if ($current_page > 1) {
                $html .="<li><a href = '" . $url . "/".$query_string."'>Start</a></li>";
            }
            $active = '';
            for ($i = $start; $i <= $end; $i++) {
                if ($i == $current_page) {
                    $active = 'class="active"';
                } else {
                    $active = '';
                }
                $html .= "<li " . $active . "><a href='" . $url . "/" . $i . "/".$query_string."'>" . $i . "</a></li>";
            }
            if ($current_page < $total_page) {
                $html .= "<li><a href = '" . $url . "/" . $total_page . "/".$query_string."'>End</a></li>";
            }
            $html .="</ul>";
            return $html;
        }
        return "";
    }
}
if (!function_exists('get_price')) {
    function get_price($product_id){
        if(!(isset($product_id) && $product_id !=null)) return null;
        $product_price = new Product_Price();
        $product_price->where(array('Product_ID' => $product_id))->get(1);
        if( !(isset($product_price->ID) && $product_price->ID!=null) ) return null;
        $price = array();
        if($product_price->Is_Main == 0){
            $price['price'] = 'Liên hệ';
            $price['Number_Price'] = 0;
        }
        else{
            $price['price'] = $product_price->Price;
            $price['Number_Price'] = $product_price->Number_Price;
        }
        
        if(@$product_price->Special_Start!=null && @$product_price->Special_End!=null){
            $today = time();
            $start_date = strtotime($product_price->Special_Start);
            $end_date = strtotime($product_price->Special_End);

            if($today >= $start_date && $today <= $end_date){
                if(@$product_price->Special_Price !=null){
                    $price['sale'] = $product_price->Special_Price;
                }
                else if(@$product_price->Special_Percent !=null && is_numeric($product_price->Special_Percent)){
                    if($product_price->Is_Main == 1){
                        $price['sale'] = $product_price->Number_Price - ($product_price->Number_Price*$product_price->Special_Percent/100);
                    }
                }
            }
        }

        return $price;
    }
}
if (!function_exists('qrcode')) {
    function qrcode($link){
        include_once("phpqrcode/qrlib.php");
        $matrixPointSize = 10;
        $errorCorrectionLevel = 'L';
        $filename = 'uploads/qrcode/'.time().'.png';
        $path_file = FCPATH.$filename;
        QRcode::png($link, $path_file, $errorCorrectionLevel, $matrixPointSize, 2);
        QRtools::timeBenchmark();
        return '/'.$filename;
    }
}