<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Medias extends CI_Controller {

    private $is_login = false;
    private $user_info = array();
    private $user_id = 0;
    private $data = array();
    private $number_photo = 50;

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info') || $this->session->userdata('admin_logged_in')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            if($this->session->userdata('admin_logged_in')){
                $this->user_id = -1;
            }
        } else {
            if ($this->input->is_ajax_request()) {
                die(json_encode(array('status' => 'error')));
            } else {
                redirect(base_url());
            }
        }
        $this->data["is_login"] = $this->is_login;

    }

    public function upload() {
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $user_id = $this->user_id;
        /*$member=new Member();
        $member->where('ID',$user_id)->get();
        if ( @$this->user_info["type_member"] != "System" && !(isset($member->ID) && $member->ID != null ) ) {
            die(json_encode($data));
        }*/
        $folder_id = $this->input->post('folder_id');

        if(!(isset($folder_id) && $folder_id!=null && is_numeric($folder_id)) ){
             $folder_id = 0;
        }

        $path = FCPATH . "uploads/member";
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }
        $path = $path . "/" . $user_id;
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }

        $index = $path.'/index.html';
        if(!file_exists($index)){
            $fh = fopen($index, 'w');
            fclose($fh);
        }

        $media = new Media();
        $number_upload = $media->where(array(
            "DATE_FORMAT(Createdat ,'%Y-%m-%d') = " => date('Y-m-d'),
            'Member_ID' => $user_id
        ))->count();

        if($number_upload > $this->number_photo) {
            $data['status'] = 'fail';
            $data['message'] = 'Bạn đã upload vượt quá số lượng ảnh. Vui lòng nâng cấp tài khoản !';
            die(json_encode($data));
        }
        if (isset($_FILES['upload'])) {
            $folder = '/uploads/member/'.$user_id.'/';
            $media_folder = new Media_Folder();
            $media_folder->where(array(
                'Member_ID' => $user_id,
                'ID' => $folder_id
            ))->get();

            if(isset($media_folder->Path) && $media_folder->Path!=null){
                $folder = $media_folder->Path;
            }
            $this->load->library('image_lib');
            $this->load->library('upload');
            $response = array();
            $config = array();
            $config['upload_path'] = '.' . $folder;
            $config['allowed_types'] = 'jpg|png|gif';
            $config['max_size'] = 6*1024;
            $config['max_width'] = '5000';
            $config['max_height'] = '5000';
            $file = $_FILES;
            $count = count($file['upload']['name']);
            if( ($count + $number_upload) > $this->number_photo){
                $data['status'] = 'fail';
                $data['message'] = 'Bạn đã upload vượt quá số lượng ảnh. Vui lòng nâng cấp tài khoản !';
                die(json_encode($data));
            }
            for ($i = 0; $i < $count; $i++) {
                $_FILES['image']['name'] = $file['upload']['name'][$i];
                $_FILES['image']['type'] = $file['upload']['type'][$i];
                $_FILES['image']['tmp_name'] = $file['upload']['tmp_name'][$i];
                $_FILES['image']['error'] = $file['upload']['error'][$i];
                $_FILES['image']['size'] = $file['upload']['size'][$i];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];

                    $size = getimagesize('.' . $folder . $file_name);
                    $w_current = $size[0];
                    $h_current = $size[1];
                    if ($w_current > 1020) {
                        // resize
                        $config['source_image'] = '.' . $folder . $file_name;
                        $config['source_image'] = '.' . $folder . $file_name;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 1020;
                        $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                        $config['height'] = $size_ratio['height'];
                        $config['quality'] = 100;
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }

                    //large
                    $config['source_image'] = '.' . $folder . $file_name;
                    $config['new_image'] = '.' . $folder . "large_" . $file_name;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 640;
                    $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                    $config['height'] = $size_ratio['height'];
                    $config['quality'] = 100;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    //Thumbnail
                    $config['source_image'] = '.' . $folder . $file_name;
                    $config['new_image'] = '.' . $folder . "thumbs_" . $file_name;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 320;
                    $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                    $config['height'] = $size_ratio['height'];
                    $config['quality'] = 100;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $media = new Media();
                    $media->Path = $folder . $file_name;
                    $media->Path_Large = $folder . "large_" . $file_name;
                    $media->Path_Thumb = $folder . "thumbs_" . $file_name;
                    $media->Member_ID = $user_id;
                    $media->Createdat = date('Y-m-d H:i:s');
                    $media->Name = $file_name;
                    $media->Folder_ID = $folder_id;
                    $media->Type = $upload_data['file_type'];

                    if ($media->save()) {
                        $response[] = array(
                            'path_file' => $folder . "thumbs_" . $file_name,
                            'path_file_crop' => $folder . $file_name,
                            'photo_id' => $media->get_id_last_save(),
                            'alt' => $file_name
                        );
                    }
                }
            }

            $media = new Media();
            $number_upload = $media->where(array(
                "DATE_FORMAT(Createdat ,'%Y-%m-%d') = " => date('Y-m-d'),
                'Member_ID' => $user_id
            ))->count();
            $data['number_upload'] = $number_upload;
            $data['status'] = 'success';
            $data['response'] = $response;
        }
        die(json_encode($data));
    }

    public function get_photo_by_id($photo_id = null){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id) && $photo_id > 0)) {
            die(json_encode($data));
        }
        $user_id = $this->user_id;
        $media = new Media();
        $media->where(array('ID' => $photo_id, 'Member_ID'=>$user_id))->get();
        if(isset($media->ID) && $media->ID!=null){
            $data['status'] = 'success';
            $data['title'] = $media->Name;
            $data['description'] = $media->Description;
            $data['id'] = $media->ID;
        }
        die(json_encode($data));
    }

    public function save_photo(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $photo_id = $this->input->post('photo_id');
        if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id) && $photo_id > 0)) {
            die(json_encode($data));
        }
        $user_id = $this->user_id;
        $media = new Media();
        $media->where(array('ID' => $photo_id, 'Member_ID'=>$user_id))->get();
        if(isset($media->ID) && $media->ID!=null){
            $arr = array(
                'Name' => $this->input->post('title'),
                'Description' => $this->input->post('description')
            );
            $media = new Media();
            $media->where(array('ID' => $photo_id, 'Member_ID'=>$user_id))->update($arr);
            $data['status'] = 'success';
        }
        die(json_encode($data));
    }

    public function get_my_photo() {
        $data = array('status' => 'error');
        $paging = $this->input->post('paging');
        $keyword = $this->input->post('keyword');
        $folder_id = $this->input->post('folder_id');
        $new_image = $this->input->post('new_image');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        if (!(isset($paging) && $paging != null && is_numeric($paging) && $paging >= 0 &&
            isset($new_image) && $new_image != null && is_numeric($new_image) && $new_image >= 0 &&
            isset($folder_id) && $folder_id != null && is_numeric($folder_id) && $folder_id >= 0)) {
            die(json_encode($data));
        }
        $user_id = $this->user_id;
        /*$member=new Member();
        $member->where('ID',$user_id)->get(1);
        if ( @$this->user_info["type_member"] != "System" && !(isset($member->ID) && $member->ID != null ) ) {
            die(json_encode($data));
        }*/
        $media = new Media();
        $number_upload = $media->where(array(
            "DATE_FORMAT(Createdat ,'%Y-%m-%d') = " => date('Y-m-d'),
            'Member_ID' => $user_id
        ))->count();
        $data['number_upload'] = $number_upload;

        $folder = new Media_Folder();
        if(isset($keyword) && $keyword!=null){
            $folders = $folder->order_by('Folder_Name','ASC')->where(array(
                'Member_ID' => $user_id,
                'Parents_ID' => $folder_id,
                'Status' => 0
            ))->like('Folder_Name',$keyword)->get();
        }
        else{
            $folders = $folder->order_by('Folder_Name','ASC')->where(array(
                'Member_ID' => $user_id,
                'Parents_ID' => $folder_id,
                'Status' => 0
            ))->get();
        }
        

        $media = new Media();
        $where = array('Member_ID' => $user_id,'Disable' => 0,'Folder_ID' => $folder_id);
        if(isset($keyword) && $keyword!=null){
            $data['total'] = $media->where($where)->like('Name',$keyword)->count() - intval($new_image);
        }
        else{
            $data['total'] = $media->where($where)->count() - intval($new_image);
        }
        if ($data['total'] > 0 || (isset($folders) && $folders!=null) ) {
            if(isset($keyword) && $keyword!=null){
                $result = $media->order_by('ID','DESC')->like('Name',$keyword)->get_where($where,12,$paging * 12 + intval($new_image) );
            }
            else{
                $result = $media->order_by('ID','DESC')->get_where($where,12,$paging * 12 + intval($new_image) );
            }
            $response = array();
            $response_folder = array();
            if(isset($result) && $result!=null) {
                foreach ($result as $key => $value) {
                    $response[] = array(
                        'id' => $value->ID,
                        'path_file' => $value->Path,
                        'thumb' => $value->Path_Thumb
                    );
                }
            }
            if($paging == 0){
                foreach ($folders as $key => $value) {
                    $response_folder[] = array(
                        'id' => $value->ID,
                        'name' => $value->Folder_Name
                    );
                }
            }
            $data['folder'] = $response_folder;
            $data['response'] = $response;
            $data['status'] = 'success';
        }

        die(json_encode($data));
    }

    public function crop_photo() {
        $data = array('status' => 'error');
        $photo_id = $this->input->post('photo_id');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id))) {
            die(json_encode($data));
        }

        $user_id = $this->user_id;
        $arr=array(
            'ID' => $photo_id,
            'Member_ID' => $user_id
        );
        $media = new Media();
        $media->where($arr)->get();
        if (isset($media->ID) && $media->ID != null ) {
            $x = intval($this->input->post('x'));
            $y = intval($this->input->post('y'));
            $w = intval($this->input->post('w'));
            $h = intval($this->input->post('h'));
            $image_w = intval($this->input->post('image_w'));
            $image_h = intval($this->input->post('image_h'));
            if ($w > 0 && $h > 0 && $image_w > 0 && $image_h > 0) {
                $src = "." . $media->Path;
                $size = getimagesize($src);

                $w_current = $size[0];
                $h_current = $size[1];

                $x *= ($w_current / $image_w);
                $w *= ($w_current / $image_w);

                $y *= ($h_current / $image_h);
                $h *= ($h_current / $image_h);


                $path_file=explode('/', $media->Path);
                $out_path='';
                foreach ($path_file as $key => $value) {
                    if($key < count($path_file) - 1 ){
                        $out_path.=$value.'/';
                    }
                }
                $ext=explode('.', $path_file[count($path_file)-1]);
                $name  = uniqid();

                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = '.' . $media->Path;
                $config['new_image'] = '.' . $out_path .$name . '.' . $ext[count($ext)-1];
                $config['maintain_ratio'] = TRUE;
                $config['x_axis'] = $x;
                $config['y_axis'] = $y;
                $config['width'] = $w;
                $config['height'] = $h;
                $config['quality'] = 100;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();


                $size = getimagesize($src);

                $w_current = $size[0];
                $h_current = $size[1];

                //large
                $config['source_image'] = '.' . $out_path .$name . '.' . $ext[count($ext)-1];
                $config['new_image'] = '.' . $out_path . 'large_' . $name . '.' . $ext[count($ext)-1];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 640;
                $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                $config['height'] = $size_ratio['height'];
                $config['quality'] = 100;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                //Thumbnail
                $config['source_image'] = '.' . $out_path . $name . '.' . $ext[count($ext)-1];
                $config['new_image'] = '.' . $out_path . 'thumbs_' . $name . '.' . $ext[count($ext)-1];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 320;
                $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                $config['height'] = $size_ratio['height'];
                $config['quality'] = 100;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                //Delete path file old
                if (isset($media->Path) && file_exists('.' . $media->Path)) {
                    unlink('.' . $media->Path);
                }

                if (isset($media->Path_Large) && file_exists('.' . $media->Path_Large)) {
                    unlink('.' . $media->Path_Large);
                }

                if (isset($media->Path_Thumb) && file_exists('.' . $media->Path_Thumb)) {
                    unlink('.' . $media->Path_Thumb);
                }

                //update name file
                $arr['Path'] = $out_path . $name . '.' . $ext[count($ext)-1];
                $arr['Path_Large'] = $out_path . 'large_' . $name . '.' . $ext[count($ext)-1];
                $arr['Path_Thumb'] = $out_path . 'thumbs_' . $name . '.' . $ext[count($ext)-1];

                $media = new Media();
                $media->where('ID',$photo_id)->update($arr);

                $data['status'] = "success";
                $data['path_file'] = $out_path . $name . '.' . $ext[count($ext)-1];
                $data['thumbs'] = $out_path . 'thumbs_' . $name . '.' . $ext[count($ext)-1];
            }
        }
        die(json_encode($data));
    }

    public function delete_photo() {
        $data = array('status' => 'error');
        $photo_id = $this->input->post('photo_id');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id))) {
            die(json_encode($data));
        }

        $user_id = $this->user_id;
        /*$member=new Member();
        $member->where('ID',$user_id)->get();

        if (isset($member->ID) && $member->ID != null) {*/

            $arr=array(
                'ID' => $photo_id,
                'Member_ID' => $user_id
            );
            $media = new Media();
            $media->where($arr)->get();
            if (isset($media->Path) && file_exists('.' . $media->Path)) {
                unlink('.' . $media->Path);
            }

            if (isset($media->Path_Large) && file_exists('.' . $media->Path_Large)) {
                unlink('.' . $media->Path_Large);
            }

            if (isset($media->Path_Thumb) && file_exists('.' . $media->Path_Thumb)) {
                unlink('.' . $media->Path_Thumb);
            }
            $media->delete_by_id($media->ID);


            $media = new Media();
            $number_upload = $media->where(array(
                "DATE_FORMAT(Createdat ,'%Y-%m-%d') = " => date('Y-m-d'),
                'Member_ID' => $user_id
            ))->count();
            $data['number_upload'] = $number_upload;


            $data['status'] = 'success';
       // }
        die(json_encode($data));
    }

    //Folder
    public function add_folder(){
        $data = array('status' => 'error');
        $name = $this->input->post('title');
        $folder_id = $this->input->post('folder_id');

        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        $user_id = $this->user_id;
        $member=new Member();
        $member->where('ID',$user_id)->get();

        if (@$this->user_info["type_member"] != "System" && ! (isset($member->ID) && $member->ID != null) ) {
            die(json_encode($data));
        }

        $folder_root = '/uploads/member/'.$user_id.'/';
        $path = FCPATH . "uploads/member";
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }
        $path = $path . "/" . $user_id;
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }

        if($folder_id != 0){

            $folder = new Media_Folder();
            $folder->where(array(
                'Member_ID' => $user_id,
                'ID' => $folder_id
            ))->get();

            if(!(isset($folder->ID) && $folder->ID!=null)){
                die(json_encode($data));
            }

            $folder_root = $folder->Path;
        }
        $slug = $this->gen_slug($name);

        $folder = new Media_Folder();
        $folder->where(array(
            'Folder_Name' => $name,
            'Parents_ID' => $folder_id,
            'Member_ID' => $user_id
        ))->get();

        $folder_slug = new Media_Folder();
        $folder->where(array(
            'Slug' => $slug,
            'Parents_ID' => $folder_id,
            'Member_ID' => $user_id
        ))->get();
        $data['id'] = $folder->ID;
        if( (isset($folder->ID) && $folder->ID!=null) || (isset($folder_slug->ID) && $folder_slug->ID!=null) ){
            $data['status'] = 'fail';
            $data['message'] = 'Thư mục này đã tồn tại. Vui lòng nhập thư mục khác';
            die(json_encode($data));
        }
        $folder = new Media_Folder();
        $folder->Folder_Name = $name;
        $folder->Slug = $slug;
        $folder->Status = 0;
        $path = FCPATH.$folder_root.$slug.'/';
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $folder->Path = $folder_root.$slug.'/';
        $folder->Parents_ID = $folder_id;
        $folder->Date_Created = date('Y-m-d H:i:s');
        $folder->Member_ID = $user_id;
        if($folder->save()){
            $data['status'] = 'success';
            $data['path'] = $path;
            $data['folder_id'] = $folder->get_id_last_save();
        }

        die(json_encode($data));
    }

    public function edit_folder(){
        $data = array('status' => 'error');
        $name = $this->input->post('title');
        $folder_id = $this->input->post('folder_id');
        $parent_folder_id = $this->input->post('parent_folder_id');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        $user_id = $this->user_id;
        $member=new Member();
        $member->where('ID',$user_id)->get();

        if (@$this->user_info["type_member"] != "System" && ! (isset($member->ID) && $member->ID != null) ) {
            die(json_encode($data));
        }
        $folder = new Media_Folder();
        $folder->where(array(
            'Member_ID' => $user_id,
            'ID' => $folder_id
        ))->get();

        if(!(isset($folder->ID) && $folder->ID!=null)){
            die(json_encode($data));
        }
        if($parent_folder_id !=0 ){
            $folder = new Media_Folder();
            $folder->where(array(
                'Member_ID' => $user_id,
                'ID' => $parent_folder_id
            ))->get();

            if(!(isset($folder->ID) && $folder->ID!=null)){
                die(json_encode($data));
            }
        }

        $folder = new Media_Folder();
        $folder->where(array(
            'Folder_Name' => $name,
            'Parents_ID' => $parent_folder_id,
            'Member_ID' => $user_id
        ))->get();

        if(isset($folder->ID) && $folder->ID!=null){
            $data['status'] = 'fail';
            $data['message'] = 'Thư mục này đã tồn tại. Vui lòng nhập thư mục khác';
            die(json_encode($data));
        }
        $folder = new Media_Folder();
        $arr = array('Folder_Name' => $name);
        $folder->where(array(
            'Member_ID' => $user_id,
            'ID' => $folder_id
        ))->update($arr);

        $data['status'] = 'success';

        die(json_encode($data));
    }

    public function delete_folder($folder_id = null){
        $data = array('status' => 'error');
        if(!$this->input->is_ajax_request() || !(isset($folder_id) && $folder_id!=null && is_numeric($folder_id)) ){
            die(json_encode($data));
        }
        $user_id = $this->user_id;
        $member=new Member();
        $member->where('ID',$user_id)->get();
        if (@$this->user_info["type_member"] != "System" && ! (isset($member->ID) && $member->ID != null) ) {
            die(json_encode($data));
        }
        $folder = new Media_Folder();
        $folder->where(array(
            'Member_ID' => $user_id,
            'ID' => $folder_id
        ))->get();

        if(!(isset($folder->ID) && $folder->ID!=null)){
            die(json_encode($data));
        }

        $path = $folder->Path;

        $arr = array('Status' => 1);
        $folder->where(array('Member_ID' => $user_id))->like('Path',$path)->update($arr);

        $arr = array('Disable' => 1);
        $media = new Media();
        $media->where('Member_ID',$user_id)->like('Path',$path)->update($arr);

        $data['status'] = 'success';

        die(json_encode($data));
    }

    //Function private
    private function ratio_image($original_width, $original_height, $new_width = 0, $new_heigh = 0) {
        $size['width'] = $new_width;
        $size['height'] = $new_heigh;
        if ($new_heigh != 0) {
            $size['width'] = intval(($original_wdith / $original_height) * $new_height);
        }
        if ($new_width != 0) {
            $size['height'] = intval(($original_height / $original_width) * $new_width);
        }
        return $size;
    }

    private function gen_slug($str) {
        $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ");
        $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A ", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-");
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), str_replace($a, $b, $str)));
    }
    function upload_image_content(){
        check_ajax();
        if(isset($_FILES["files"])){
            die(json_encode($_FILES["files"]));
        }
    }
}