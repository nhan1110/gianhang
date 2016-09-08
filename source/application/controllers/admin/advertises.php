<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Advertises extends MY_Controller {
  private $data;
  public function __construct() {
    parent::__construct();
  }
  public function index() {
    $advertise = new Advertise();
    $this->data["record"] = $advertise->get_all_advertise();
    $this->data["title_curent"] = "Advertise";
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/index',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function add(){
    if($this->input->post()){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('block_page', 'Block page', 'required');
      $this->form_validation->set_rules('company_name', 'Company name', 'required');
      $this->form_validation->set_rules('description', 'Description', 'required');
      $this->form_validation->set_rules('web_addresses', 'Web addresses company', 'required');
      $this->form_validation->set_rules('email', 'Email company', 'required|valid_email');
      if ($this->form_validation->run() == TRUE)
      {
        $today = date("Y-m-d H:i:s");  
        $company = $this->input->post("company_name");
        $email = $this->input->post("email");
        $address = $this->input->post("address");
        $phone_number = $this->input->post("phone_number");
        $web_addresses = $this->input->post("web_addresses");
        $description = $this->input->post("description");
        $content = $this->input->post("content");
        $level = $this->input->post("level");
        $start_day = $this->input->post("start_day");
        $end_day = $this->input->post("end_day");
        $start_day = new DateTime($start_day);
        $end_day = new DateTime($end_day);
        $status = $this->input->post("status");
        $block_page = $this->input->post("block_page");
        $advertise = new Advertise();
        $advertise->Block_Page_ID = $block_page;
        $advertise->Company_Name = $company;
        $advertise->Addresses = $address;
        $advertise->Content = $content;
        $advertise->Description = $description;
        $advertise->Email = $email;
        $advertise->Phone = $phone_number;
        $advertise->Web_Addresses = $web_addresses;
        $advertise->Createat = $today;
        $advertise->Disable = $status;
        $advertise->Start_Day =  $start_day->format('Y-m-d H:i:s');
        $advertise->End_Day = $end_day->format('Y-m-d H:i:s');
        $advertise->save();
        $id_advertise = $advertise->db->insert_id();
        if($id_advertise){
          if(isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0){
            $name = explode(".", $_FILES["logo"]["name"]);
            $upload_path = FCPATH.'uploads/advertise/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, TRUE);
            }
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'png|jpg';
            $config['max_size'] = (10*1024); // Byte
            $config['file_name'] = $this->gen_slug($name[0] .'-'. time());
            $this->load->library('upload', $config);
            $flie_logo = "";
            if($this->upload->do_upload("logo")){
              $flie_logo = '/uploads/advertise/'.$config['file_name'].'.'.$name[count($name) - 1]; 
              $data_update = array("Logo" => $flie_logo);
              $advertise->where("ID", $id_advertise)->update($data_update);
            }
          }
          redirect(base_url("admin/advertises/edit/".$id_advertise));
        }
      }
    }
    $path = '../../../skins/js/ckfinder';
    $this->_editor($path, '350px');
    $record_block_page = new Advertise_Block_Page();
    $this->data["block_page"] = $record_block_page->where("Disable","0")->get_raw()->result_array();
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/add',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function edit($id = null){
    if($id !== null){
      	$advertise = new Advertise();
        $this->data["record"] = $advertise->where("ID",$id)->get_raw()->row_array();
	    if(!empty($this->data["record"])){
	    	if($this->input->post()){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('block_page', 'Block page', 'required');
				$this->form_validation->set_rules('company_name', 'Company name', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				$this->form_validation->set_rules('web_addresses', 'Web addresses company', 'required');
				$this->form_validation->set_rules('email', 'Email company', 'required|valid_email');
				if ($this->form_validation->run() == TRUE){
					$company = $this->input->post("company_name");
			        $email = $this->input->post("email");
			        $address = $this->input->post("address");
			        $phone_number = $this->input->post("phone_number");
			        $web_addresses = $this->input->post("web_addresses");
			        $description = $this->input->post("description");
			        $content = $this->input->post("content");
			        $level = $this->input->post("level");
			        $start_day = $this->input->post("start_day");
			        $end_day = $this->input->post("end_day");
			        $start_day = new DateTime($start_day);
			        $end_day = new DateTime($end_day);
			        $status = $this->input->post("status");
			        $block_page = $this->input->post("block_page");
			        $data_update["Block_Page_ID"] = $block_page;
			        $data_update["Company_Name"] = $company;
			        $data_update["Addresses"] = $address;
			        $data_update["Content"] = $content;
			        $data_update["Description"] = $description;
			        $data_update["Email"] = $email;
			        $data_update["Phone"] = $phone_number;
			        $data_update["Web_Addresses"] = $web_addresses;
			        $data_update["Disable"] = $status;
			        $data_update["Start_Day"] =  $start_day->format('Y-m-d H:i:s');
			        $data_update["End_Day"] = $end_day->format('Y-m-d H:i:s');
			        if(isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0){
			            $name = explode(".", $_FILES["logo"]["name"]);
			            $upload_path = FCPATH.'uploads/advertise/';
			            if (!is_dir($upload_path)) {
			                mkdir($upload_path, 0755, TRUE);
			            }
			            $config['upload_path'] = $upload_path;
			            $config['allowed_types'] = 'png|jpg';
			            $config['max_size'] = (10*1024); // Byte
			            $config['file_name'] = $this->gen_slug($name[0] .'-'. time());
			            $this->load->library('upload', $config);
			            if($this->upload->do_upload("logo")){
			              $flie_logo = '/uploads/advertise/'.$config['file_name'].'.'.$name[count($name) - 1]; 
			              $data_update["Logo"] = $flie_logo;
			            }
			        }
			        $advertise->where("ID",$id)->update($data_update);
			        redirect(base_url("admin/advertises/edit/".$id));
				}	
	    	}
			$path = '../../../skins/js/ckfinder';
			$this->_editor($path, '350px');
			$record_block_page = new Advertise_Block_Page();
			$this->data["block_page"] = $record_block_page->where("Disable","0")->get_raw()->result_array();
			$this->load->view('backend/include/header',$this->data);
			$this->load->view('backend/advertise/edit',$this->data);
			$this->load->view('backend/include/footer',$this->data);
		}
      
    }else{
		redirect(base_url("admin/advertises/"));
    }
  }
  public function block(){
    $block = new Advertise_Block();
    $this->data["record"] = $block->get_raw()->result_array();
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/block',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function page(){
    $block = new Advertise_Page();
    $this->data["record"] = $block->get_raw()->result_array();
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/page',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function block_page(){
    $block_page = new Advertise_Block_Page();
    $record = $block_page->get_list_advertise();
    $this->data["record"] = $record;
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/block_page',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function add_block(){
    if($this->input->post()){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('description', 'Description', 'required');
      $this->form_validation->set_rules('status', 'Status', 'required');
      if ($this->form_validation->run() == TRUE) {
        $this->load->library('Helperclass');
        $title = $this->input->post("title");
        $slug = $this->helperclass->slug("Advertise_Block", "slug", $title);     
        $date = date("Y-m-d H:i:s");
        $advertise_block = new Advertise_Block();
        $advertise_block->Title = $title;
        $advertise_block->Slug = $slug;
        $advertise_block->Description = $this->input->post("description");
        $advertise_block->Disable = $this->input->post("status");
        $advertise_block->Createat = $date;
        $advertise_block->save();
        $id = $advertise_block->db->insert_id();
        redirect(base_url("admin/advertises/edit_block/".$id));
      } 
    }
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/add_block',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function edit_block($id){
      $advertise_block = new Advertise_Block();
      $record = $advertise_block->where("ID",$id)->get_raw()->row_array();
      if(!empty($record)){
        if($this->input->post()){
          $this->load->library('form_validation');
          $this->form_validation->set_rules('title', 'Title', 'required');
          $this->form_validation->set_rules('description', 'Description', 'required');
          $this->form_validation->set_rules('status', 'Status', 'required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->library('Helperclass');
            $title = $this->input->post("title");   
            if($title != $record["Title"]){
              $slug = $this->helperclass->slug("Advertise_Block", "slug", $title);  
              $data_update["Slug"] = $slug ;
              $data_update["Title"] = $title ;
            }
            $data_update["Description"] = $this->input->post("description"); ;
            $data_update["Disable"] = $this->input->post("status");
            $advertise_block->where("ID",$id)->update($data_update);
            redirect(base_url("admin/advertises/edit_block/".$id));
          }
        }
        $this->data["record"] = $record;
        $this->load->view('backend/include/header',$this->data);
        $this->load->view('backend/advertise/edit_block',$this->data);
        $this->load->view('backend/include/footer',$this->data);
      }else{
        redirect(base_url("admin/advertises/block/"));
      }
  }
  public function add_page(){
    if($this->input->post()){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('description', 'Description', 'required');
      $this->form_validation->set_rules('status', 'Status', 'required');
      $this->form_validation->set_rules('template_view', 'Template', 'required');
      if ($this->form_validation->run() == TRUE) {
        $this->load->library('Helperclass');
        $title = $this->input->post("title");
        $slug = $this->helperclass->slug("Advertise_Page", "slug", $title);     
        $date = date("Y-m-d H:i:s");
        $advertise_page = new Advertise_Page();
        $advertise_page->Page = $title;
        $advertise_page->Slug = $slug;
        $advertise_page->Description = $this->input->post("description");
        $advertise_page->Disable = $this->input->post("status");
        $advertise_page->Template_View = $this->input->post("template_view");
        $advertise_page->Createat = $date;
        $advertise_page->save();
        $id = $advertise_page->db->insert_id();
        redirect(base_url("admin/advertises/edit_page/".$id));
      } 
    }
    $path = '../../../skins/js/ckfinder';
    $this->_editor($path, '350px');
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/add_page',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function edit_page($id){
      $advertise_page = new Advertise_Page();
      $record = $advertise_page->where("ID",$id)->get_raw()->row_array();
      if(!empty($record)){
        if($this->input->post()){
          $this->load->library('form_validation');
          $this->form_validation->set_rules('title', 'Title', 'required');
          $this->form_validation->set_rules('description', 'Description', 'required');
          $this->form_validation->set_rules('status', 'Status', 'required');
          $this->form_validation->set_rules('template_view', 'Template', 'required');
          if ($this->form_validation->run() == TRUE) {
            $this->load->library('Helperclass');
            $title = $this->input->post("title");   
            if($title != $record["Page"]){
              $slug = $this->helperclass->slug("Advertise_Page", "slug", $title);  
              $data_update["Slug"] = $slug ;
              $data_update["Page"] = $title ;
            }
            $data_update["Description"] = $this->input->post("description");
            $data_update["Template_View"] = $this->input->post("template_view");
            $data_update["Disable"] = $this->input->post("status");
            $advertise_page->where("ID",$id)->update($data_update);
            redirect(base_url("admin/advertises/edit_page/".$id));
          }
        }
        $path = '../../../skins/js/ckfinder';
        $this->_editor($path, '350px');
        $this->data["record"] = $record;
        $this->load->view('backend/include/header',$this->data);
        $this->load->view('backend/advertise/edit_page',$this->data);
        $this->load->view('backend/include/footer',$this->data);
      }else{
        redirect(base_url("admin/advertises/page/"));
      }
  }
  
  public function add_block_page(){
    if($this->input->post()){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('block', 'Block', 'required');
      $this->form_validation->set_rules('page', 'Page', 'required');
      $this->form_validation->set_rules('price', 'Price', 'required');
      $this->form_validation->set_rules('number_resgier', 'Number resgier', 'required');
      $this->form_validation->set_rules('status', 'Status', 'required');
      if ($this->form_validation->run() == TRUE) {
        $date = date("Y-m-d H:i:s");
        $this->load->library('Helperclass');
        $name = $this->input->post("name");
        $slug = $this->helperclass->slug("Advertise_Block_Page", "slug", $name);     
        $block_page = new Advertise_Block_Page();
        $block_page->Name = $name;
        $block_page->Slug = $slug;
        $block_page->Page_ID = $this->input->post("page");
        $block_page->Block_ID = $this->input->post("block");
        $block_page->Price = $this->input->post("price");
        $block_page->Number_Resgier = $this->input->post("number_resgier");
        $block_page->Description = $this->input->post("description");
        $block_page->Createat = $date;
        $block_page->Disable = $this->input->post("status");
        $block_page->save();
        $id = $block_page->db->insert_id();
        redirect(base_url("admin/advertises/edit_block_page/".$id));
      }
    }
    
    $block = new Advertise_Block();
    $this->data["record"]["block"] = $block->where("Disable","0")->get_raw()->result_array();
    $this->load->view('backend/include/header',$this->data);
    $this->load->view('backend/advertise/add_block_page',$this->data);
    $this->load->view('backend/include/footer',$this->data);
  }
  public function get_page(){
    check_ajax();
    $id = $this->input->post("id");
    $data["success"] = "error";
    $page = new Advertise_Page();
    $data["page"] = $page->get_page_unique($id);
    $data["success"] = "success";
    die(json_encode($data));
  }
  public function edit_block_page($id = null){
    $block_page = new Advertise_Block_Page();
    $record = $block_page->where("ID",$id)->get_raw()->row_array();
    if(!empty($record)){
      if($this->input->post()){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('block', 'Block', 'required');
        $this->form_validation->set_rules('page', 'Page', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('number_resgier', 'Number resgier', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == TRUE) {

          $data_update = array(
            "Page_ID" => $this->input->post("page"),
            "Block_ID" => $this->input->post("block"),
            "Price" => $this->input->post("price"),
            "Number_Resgier" => $this->input->post("number_resgier"),
            "Description" => $this->input->post("description"),
            "Disable" => $this->input->post("status")
          );
          $this->load->library('Helperclass');
            $title = $this->input->post("name");   
            if($title != $record["Name"]){
              $slug = $this->helperclass->slug("Advertise_Block_Page", "slug", $title);  
              $data_update["Slug"] = $slug ;
              $data_update["Name"] = $title ;
            }
          $block_page->where("ID",$id)->update($data_update);
          redirect(base_url("admin/advertises/edit_block_page/".$id));
        }
      }
      $page = new Advertise_Page();
      $block = new Advertise_Block();
      $this->data["record"]["block"] = $block->where("Disable","0")->get_raw()->result_array();
      $this->data["record"]["page"] = $page->where("Disable","0")->get_raw()->result_array();
      $this->data["record"]["block_page"] = $record;
      $this->load->view('backend/include/header',$this->data);
      $this->load->view('backend/advertise/edit_block_page',$this->data);
      $this->load->view('backend/include/footer',$this->data);
    }else{
      redirect(base_url("admin/advertises/block_page/"));
    }
  }
  public function delete($table=null,$id=null){
    $arg_table = ["block","page","block_page","advertises"];
    if(in_array($table, $arg_table)){
      $table_set = null;
      switch ($table) {
        case 'block':
          $table_set = "Advertise_Block";
          break;
        case 'block_page':
          $table_set = "Advertise_Block_Page";
          break;
        case 'page':
          $table_set = "Advertise_Page";
          break;
        default:
          $table_set = "Advertise";
          break;
      }
      if(!empty($table_set))
         $this->db->delete($table_set, array('ID' => $id));
       redirect(base_url("admin/advertises/".$table));
    }else{
      redirect(base_url("admin/advertises/"));
    }
  }
  public function disable($table=null,$id=null){
    $arg_table = ["block","page","block_page","advertises"];
    if(in_array($table, $arg_table)){
      $table_set = null;
      switch ($table) {
        case 'block':
          $table_set = new Advertise_Block();
          break;
        case 'block_page':
          $table_set = new Advertise_Block_Page();
          break;
        case 'page':
          $table_set = new Advertise_Page();
          break;
        default:
          $table_set = new Advertise();
          break;
      }
      if(!empty($table_set)){
        $record = $table_set->where("ID",$id)->get_raw()->row_array();
        if(!empty($record)){
          $data_update = array("Disable" => "0");
          if($record["Disable"] == "0")
            $data_update = array("Disable" => "1");
          $table_set->where("ID",$id)->update($data_update);
        }
      }
      redirect(base_url("admin/advertises/".$table));
    }else{
      redirect(base_url("admin/advertises/"));
    }
  }
  private function _editor($path,$height) {
      //Loading Library For Ckeditor
      $this->load->library('ckeditor');
      $this->load->library('ckfinder');
      //configure base path of ckeditor folder 
      $this->ckeditor->basePath = base_url().'skins/js/ckeditor/';
      $this->ckeditor->config['toolbar'] = 'Full';
      $this->ckeditor->config['language'] = 'vi';
      $this->ckeditor->config['height'] = $height;
      //configure ckfinder with ckeditor config 
      $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
  }
  private function gen_slug($str) {
    $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
    $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
  }
}
