<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shop extends CI_Controller {

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
        } else {
            if ($this->input->is_ajax_request()) {
                die(json_encode(array('status' => 'error')));
            } else {
                redirect(base_url());
            }
        }
        $this->data["is_login"] = $this->is_login;
        $member_company = new Member_Company();
        $member_company->where('Member_ID', $this->user_id)->get(1);
        $this->data['company'] = $member_company;
    }

    public function index(){
    	$this->load->view('fontend/shop/header');
        $this->load->view('fontend/shop/index');
        $this->load->view('fontend/shop/footer');
    }

    public function edit(){
    	$this->load->view('fontend/shop/edit/header',$this->data);
        $this->load->view('fontend/shop/edit/index',$this->data);
        $this->load->view('fontend/shop/edit/footer',$this->data);
    }

    public function category(){
    	$this->load->view('fontend/shop/header');
        $this->load->view('fontend/shop/category');
        $this->load->view('fontend/shop/footer');
    }

    public function cart(){
    	$this->load->view('fontend/shop/header');
        $this->load->view('fontend/shop/cart');
        $this->load->view('fontend/shop/footer');
    }

    public function single(){
    	$this->load->view('fontend/shop/header');
        $this->load->view('fontend/shop/single');
        $this->load->view('fontend/shop/footer');
    }

    public function get_menu_by_group($group_id = null){
        $data['status'] = 'error';
        $member_menu_group = new Member_Group_Menu();
        $member_menu_group->where(array('ID' => $group_id,'Member_ID' => $this->user_id))->get(1);
        if(!(isset($member_menu_group->ID) && $member_menu_group->ID!=null)){
            die(json_encode($data));
        }
        $member_menus = new Member_Menu();
        $member_menus->where(array('Group_ID' => $group_id , 'Member_ID' => $this->user_id));
        $member_menus->order_by('Sort_Menu', 'ASC');
        $member_menus->get();
        foreach ($member_menus as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items->ID] = array(
                'class' => $items->Class_Menu,
                'url' => $items->URL,
                'title' => $items->Title,
                'type' => $items->Type_Menu,
                'id' => $items->ID
            );
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items->Parent_ID][] = $items->ID;
        }
        $data['status'] = 'success';
        $data['reponse'] = $this->build_menu(0, $menu, "nav navbar-nav megamenu");
        die(json_encode($data));
    }

    public function save_logo() {
        $data = array('status' => 'error');
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        if ( !$this->input->is_ajax_request() || !(isset($member->ID) && $member->ID != null) ) {
           die(json_encode($data)); 
        }
        $member_company = new Member_Company();
        $member_company->where('Member_ID', $user_id)->get(1);

        if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
            $output_dir = "./uploads/shop/";
            $output_url = "/uploads/shop/";
            $filename = $_FILES['fileupload']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION); //type image
            $RandomNum = time();
            $ImageName = str_replace(' ', '-', strtolower($_FILES['fileupload']['name']));
            $ImageType = $_FILES['fileupload']['type']; //"image/png", image/jpeg etc.
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.', '', $ImageExt);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
            if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir . $NewImageName)) {
                $data1 = crop_image($NewImageName, $ext, $output_url);
                if ($data1["status"] = "success") {
                    if (isset($member_company->Company_Logo) && $member_company->Company_Logo != null && file_exists('.' . $member->Company_Logo)) {
                        unlink('.' . $member_company->Company_Logo);
                    }
                    $path = $output_url . $data1["name"];

                    if(isset($member_company->Member_ID) && $member_company->Member_ID!=null){
                    	$member_company->update('Company_Logo', $path);
                    }
                    else{
                    	$member_company = new Member_Company();
                    	$member_company->Company_Logo = $path;
                    	$member_company->Member_ID = $user_id;
                    	$member_company->save();
                    }
                    $data['name'] = $path;
                    $data["status"] = "success";
                }
            }
        }
        die(json_encode($data));
    }

    public function save_banner() {
        $data = array('status' => 'error');
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        if ( !$this->input->is_ajax_request() || !(isset($member->ID) && $member->ID != null) ) {
           die(json_encode($data)); 
        }
        $member_company = new Member_Company();
        $member_company->where('Member_ID', $user_id)->get(1);

        if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
            $output_dir = "./uploads/shop/";
            $output_url = "/uploads/shop/";
            $filename = $_FILES['fileupload']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION); //type image
            $RandomNum = time();
            $ImageName = str_replace(' ', '-', strtolower($_FILES['fileupload']['name']));
            $ImageType = $_FILES['fileupload']['type']; //"image/png", image/jpeg etc.
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.', '', $ImageExt);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
            if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir . $NewImageName)) {
                $data1 = crop_image($NewImageName, $ext, $output_url);
                if ($data1["status"] = "success") {
                    if (isset($member_company->Company_Banner) && $member_company->Company_Banner != null && file_exists('.' . $member->Company_Banner)) {
                        unlink('.' . $member_company->Company_Banner);
                    }
                    $path = $output_url . $data1["name"];

                    if(isset($member_company->Member_ID) && $member_company->Member_ID!=null){
                    	$member_company->update('Company_Banner', $path);
                    }
                    else{
                    	$member_company = new Member_Company();
                    	$member_company->Company_Banner = $path;
                    	$member_company->Member_ID = $user_id;
                    	$member_company->save();
                    }
                    $data['name'] = $path;
                    $data["status"] = "success";
                }
            }
        }
        die(json_encode($data));
    }

    public function save_setting_website(){
        $data = array('status' => 'error');
        $user_id = $this->user_id;
        $member = new Member();
        $member->where('ID', $user_id)->get(1);
        if ( !$this->input->is_ajax_request() || !(isset($member->ID) && $member->ID != null) ) {
           die(json_encode($data)); 
        }
        $customize = $this->input->post('customize');

        $body = @$customize['body'];
        $body_style = array(
        	'bg_image' => @$body['bg_image'],
        	'bg_color' => @$body['bg_color'],
        	'color_body_text' => @$body['color_body_text'],
        	'color_body_link' => @$body['color_body_link'],
        	'color_body_link_hover' => @$body['color_body_link_hover'],
        	'font_size_body' => @$body['font_size_body']
        );

        $content_style = array(
        	'bg_content_image' => @$body['bg_content_image'],
        	'bg_content_color' => @$body['bg_content_color']
        );

        $footer = @$customize['footer'];
        $footer_style = array(
        	'bg_image' => @$footer['bg_image'],
        	'bg_color' => @$footer['bg_color'],
        	'color_text' => @$footer['color_text'],
        	'color_text_link' => @$footer['color_text_link'],
        	'color_text_link_hover' => @$footer['color_text_link_hover']
        );

        $header_main = @$customize['header_main'];
        $header_style = array(
        	'bg_image' => @$header_main['bg_image'],
        	'bg_color' => @$header_main['bg_color'],
        	'color_text' => @$header_main['color_text'],
        	'color_text_link' => @$header_main['color_text_link'],
        	'color_text_link_hover' => @$header_main['color_text_link_hover']
        );

        $powered = @$customize['powered'];
        $powered_style = array(
        	'bg_image' => @$powered['bg_image'],
        	'bg_color' => @$powered['bg_color'],
        	'color_text' => @$powered['color_text'],
        	'color_text_link' => @$powered['color_text_link']
        );


        $pav_mainnav = @$customize['pav_mainnav'];
        $menu_style = array(
        	'bg_color' => @$pav_mainnav['bg_color'],
        	'text_color' => @$pav_mainnav['text_color'],
        	'text_color_link' => @$pav_mainnav['text_color_link']
        );

        $product = @$customize['product'];
        $modules = @$customize['modules'];

        $json = array(
        	'body' => $body_style,
        	'content' => $content_style,
        	'footer' => $footer_style,
        	'header' => $header_style,
        	'menu' => $menu_style,
        	'powered' => $powered_style
        );

        $mw = new Member_Setting_Website();
        $mw->where(array('Member_ID' => $user_id,'Key' => 'web_setting'))->get(1);
        if(isset($mw->ID) && $mw->ID != null){
        	$arr = array(
        		'Value' => json_encode($json)
        	);
        	$mw->update($arr);
        }
        else{
        	$mw = new Member_Setting_Website();
        	$mw->Member_ID = $user_id;
            $mw->Key = 'web_setting';
        	$mw->Value = json_encode($json);
        	$mw->save();
        }

        $data['reponse'] = $this->input->post();
        die(json_encode($data));
    }

    private function get_meta_setting($key,$arr){
        foreach ($arr as $item => $value) {
           if($key == $item){
                return $value;
           }
        }
        return null;
    }

    private function build_menu_admin($parent, $menu, $id = "") {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $cls = '';
            if ($parent == 0) {
                $cls = $id;
            }
            $html .= "<ul id='" . $cls . "'>\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n  
                                <div class='ns-row'>
                                  <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                                  <div class='ns-url'>" . $menu['items'][$itemId]['url'] . "</div>
                                  <div class='ns-actions'>
                                     <a href='#' class='edit-menu' data-id='".$menu['items'][$itemId]['id']."' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
                                     <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
                                     <a href='#' class='slider-menu'><i class='fa fa-chevron-down'></i></a>
                                     <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                  </div>
                               </div>
                             </li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $href = '';
                    if (isset($menu['items'][$itemId]['url']) && $menu['items'][$itemId]['url'] != null && $menu['items'][$itemId]['url'] != '') {
                        $href = "href='" . $menu['items'][$itemId]['url'] . "'";
                    }
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n
                              <div class='ns-row'>
                                  <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                                  <div class='ns-url'>" . $menu['items'][$itemId]['url'] . "</div>
                                  <div class='ns-actions'>
                                     <a href='#' class='edit-menu' data-id='".$menu['items'][$itemId]['id']."' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
                                     <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
                                     <a href='#' class='slider-menu'><i style='font-size: 13px;' class='fa fa-chevron-down'></i></a>
                                     <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                  </div>
                               </div>";
                    $html .= $this->build_menu_admin($itemId, $menu);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

    private function build_menu($parent, $menu, $class = "") {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $cls = '';
            if ($parent == 0) {
                $cls = "class='" . $class . "'";
            }
            $html .= "<ul ".$cls.">";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $target = '';
                    if(@$menu['items'][$itemId]['type'] == 'blank'){
                        $target = 'target="_blank"';
                    }
                    $html .= "<li><a ".$target." href='".$menu['items'][$itemId]['url']."'>".$menu['items'][$itemId]['title']."</a></li>";
                }
                if (isset($menu['parents'][$itemId])) {
                    $target = '';
                    if(@$menu['parents'][$itemId]['type'] == 'blank'){
                        $target = 'target="_blank"';
                    }
                    $html .= "<li><a ".$target." href='".$menu['items'][$itemId]['url']."'>".$menu['items'][$itemId]['title']."</a>";
                    $html .= $this->build_menu($itemId, $menu);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }
}