<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('rename_file')) {

    function rename_file($src, $folder, $name) {
        $filePath = $src;
        $fileObj = new SplFileObject($filePath);
        $name_flie = explode("/", $name);
        $RandomNum = uniqid();
        $ImageName = str_replace(' ', '-', strtolower($name_flie[(count($name_flie) - 1)]));
        $ImageType = explode(".", $name_flie[(count($name_flie) - 1)]);
        $ImageType = $ImageType[(count($ImageType) - 1)];
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt = str_replace('.', '', $ImageExt);
        $ImageName = str_replace("." . $ImageExt, "", $ImageName);
        $ImageName = preg_replace("/.[[.s]{3,4}$/", "", $ImageName);
        $NewImageName = md5($ImageName) . '_' . $RandomNum . '.' . $ImageExt;
        rename($filePath, FCPATH . $folder . $NewImageName);
        return $NewImageName;
    }

}
if (!function_exists('crop_image')) {
    function crop_image($image, $type, $folder) {
        $data = array("status" => "error", 'name' => '');
        //$folder="/images/avatars/";
        if (isset($_POST['x']) && isset($_POST['y'])) {
            $x = intval($_POST['x']);
            $y = intval($_POST['y']);
            $w = intval($_POST['w']);
            $h = intval($_POST['h']);
            $image_w = intval($_POST['image_w']);
            $image_h = intval($_POST['image_h']);
            if ($w > 0 && $h > 0 && $image_w > 0 && $image_h > 0) {
                $src = "." . $folder . $image;
                $size = getimagesize($src);

                $w_current = $size[0];
                $h_current = $size[1];

                $x *= ($w_current / $image_w);
                $w *= ($w_current / $image_w);

                $y *= ($h_current / $image_h);
                $h *= ($h_current / $image_h);

                $path = $folder . $image;
                $dstImg = imagecreatetruecolor($w, $h);
                $dat = file_get_contents($src);
                $vImg = imagecreatefromstring($dat);
                if ($type == 'png') {
                    imagealphablending($dstImg, false);
                    imagesavealpha($dstImg, true);
                    $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
                    imagefilledrectangle($dstImg, 0, 0, $w, $h, $transparent);
                    //imagecolortransparent($dstImg, $transparent);
                    imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                    imagepng($dstImg, $src);
                } else {
                    imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                    imagejpeg($dstImg, $src);
                }
                imagedestroy($dstImg);

                $src = FCPATH . $folder . $image;
                $name = rename_file($src, $folder, $image);
                $data['name'] = $name;
                $data["status"] = "success";
            }
        }
        return $data;
    }
}
if (!function_exists('check_ajax')) {
    function check_ajax($requets = "post") {
        $CI = get_instance();
        if (!$CI->input->is_ajax_request()) {
            redirect(base_url());
        } else {
            if ($requets == "post" && !$CI->input->post()) {
                die(json_encode(array("messenger" => "error")));
            }
            if ($requets == "get" && !$CI->input->get()) {
                die(json_encode(array("messenger" => "error")));
            }
        }
    }
}
if (!function_exists('getuserip')) {
    function getuserip() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

}
if (!function_exists('set_token')) {

    function set_token() {
        return md5(uniqid());
    }

}
if (!function_exists('_token')) {

    function _token() {
        /* $token     = set_token();
          $old_token = "";
          $CI = get_instance();
          if( $CI->session->userdata('user_info') ){
          $user_info = $CI->session->userdata('user_info');
          if($CI->input->post()){
          if($CI->input->post("_token")){
          $filter = array(
          "user_id"    => $user_info["id"],
          "$user_info" => $CI->input->post("_token")
          );
          $record = $CI->Common_model->get_record("user_activity",$filter);
          if(count($record) == 0){
          return false;
          }
          }
          }
          $user_info["token_activity"] = $token;
          $CI->session->unset_userdata('user_info');
          $CI->session->set_userdata('user_info',$user_info);
          $arg_activity = array(
          "_token"    => $token,
          "ip"      => getuserip()
          );
          $CI->Common_model->update("user_activity",$arg_activity,array("user_id" => $user_info["id"]));
          return $token;
          } */
        return true;
    }

}

if (!function_exists('show_attribute')) {
    function show_attribute( $attribute = array(),$arg_parent = array() ,$item_activer = "") {
        $id = $attribute["ID"];
        $type = $attribute["Value"];
        $name = $attribute["Name"];
        $slug = $attribute["Slug"];
        $group_id = $attribute["Group_ID"];
        $validate = $attribute["Validate"];
        $required = $attribute["Require"];
        $type_system = $attribute["Type"];
        $unit = $attribute["Unit"];
        $messenger_error = $attribute["Messenger_Error"];
        $list_parent = [];
        $name_attribute = 'attribute[' . $group_id . "-" . $id . '][]';
        if (is_array($arg_parent) && count($arg_parent) > 0) {
            foreach ($arg_parent AS $key => $value) {
                if ($value["Parent_ID"] == $id) {
                    $list_parent[] = $value;
                }
            }
        }
        $attribute_validate = "";
        $attribute_required = "";
        $required_text = "";
        $required_in = "";
        if ($required > 0) {
            $attribute_required = "( * ";
            $required_text = "data-validate = 'true'";
            $required_in = "data-required = 'true'";
        }
        if ($validate !== "") {
            $required_text = "data-validate = 'true'";
            $validate = json_decode($validate, true);
            $attribute_validate = " data-min = '" . @$validate["min_length"] . "' data-max = '" . @$validate["max_length"] . "'";
        }
        if ($required > 0) {
            $attribute_required .= " )";
        }
        $html = "<fieldset><legend>" . $name . " " . $attribute_required . "</legend> <div id='" . $id . "'>";
        switch ($type) {
            case "multipleselect":
                $html .= "<ul class='nav-multiselect attribute' data-type ='".$type."' data-group= 'true' " . $required_in . " " . $required_text . " >";
                if (count($list_parent) > 0) {
                    $offset = 0;
                    foreach ($list_parent AS $key => $value) {
                        if ($offset == 0)
                            $html .= '<li class="none"><input type="checkbox" value="{[-]}" name="' . $name_attribute . '" checked="checked"> </li>';
                        $activer = "";
                        if (is_array($item_activer) && count($item_activer) > 0) {
                            foreach ($item_activer as $key => $value_activer) {
                                if ($value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                                    $arg_value = explode("{[-]}", $value_activer["Value"]);
                                    if (in_array($value["Name"], $arg_value) == true) {
                                        $activer = "checked";
                                    }
                                }
                            }
                        }
                        $html .='<li>
                                    <div class="checkbox">
                                        <input type="checkbox" id="attribute-' . $value["Slug"] . '-' . $value["ID"] . '" value="' . $value["Name"] . '" name="' . $name_attribute . '" ' . $activer . '>
                                        <label for="attribute-' . $value["Slug"] . '-' . $value["ID"] . '"><span>' . $value["Name"] . '</span></label>
                                    </div>
                                </li>';
                        $offset ++;
                    }
                }
                $html .="</ul>";
                break;
            case "select":
                if($unit != ""){
                    $html .='<div class="form-group"> 
                                <div class="input-group"> 
                                    <span class="input-group-addon">'.$unit.'</span>'; 
                    $html .= "<select class='form-control' data-type ='".$type."' name ='" . $name_attribute . "' " . $required_in . " " . $required_text . ">";
                    if (count($list_parent) > 0) {
                        $html .='<option value="{[-]}" id="default">- Lựa chọn -</option>';
                        foreach ($list_parent AS $key => $value) {
                            $activer = "";
                            if (is_array($item_activer) && count($item_activer) > 0) {
                                foreach ($item_activer as $key => $value_activer) {
                                    if ($value["Name"] == $value_activer["Value"] && $value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                                        $activer = "selected";
                                    }
                                }
                            }
                            $html .='<option value="' . $value["Name"] . '" id="' . $value["Slug"] . '" ' . $activer . '>' . $value["Name"] . '</option>';
                        }
                    }
                    $html .="</select>";               
                    $html .='   </div>
                            </div>';
                }else{
                    $html .= "<select class='form-control' data-type ='".$type."' name ='" . $name_attribute . "' " . $required_in . " " . $required_text . ">";
                    if (count($list_parent) > 0) {
                        $html .='<option value="{[-]}" id="default">- Lựa chọn -</option>';
                        foreach ($list_parent AS $key => $value) {
                            $activer = "";
                            if (is_array($item_activer) && count($item_activer) > 0) {
                                foreach ($item_activer as $key => $value_activer) {
                                    if ($value["Name"] == $value_activer["Value"] && $value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                                        $activer = "selected";
                                    }
                                }
                            }
                            $html .='<option value="' . $value["Name"] . '" id="' . $value["Slug"] . '" ' . $activer . '>' . $value["Name"] . '</option>';
                        }
                    }
                    $html .="</select>";
                }
                break;
            case "multipleradio":
                $html .= "<ul class='nav-check attribute' data-type ='".$type."' data-group = 'true' " . $required_in . " " . $required_text . ">";
                if (count($list_parent) > 0) {
                    $offset = 0;
                    foreach ($list_parent AS $key => $value) {
                        if ($offset == 0)
                            $html .= '<li class="none"><input type="radio" value="{[-]}" name="' . $name_attribute . '" checked="checked"> </li>';
                        $activer = "";
                        if (is_array($item_activer) && count($item_activer) > 0) {
                            foreach ($item_activer as $key => $value_activer) {

                                if ($value["Name"] == $value_activer["Value"] && $value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                                    $activer = "checked";
                                }
                            }
                        }
                        $html .='<li>
                                    <div class="checkbox">
                                        <input type="radio" id="attribute-' . $value["Slug"] . '-' . $value["ID"] . '" value="' . $value["Name"] . '" name="' . $name_attribute . '" ' . $activer . '>
                                        <label for="attribute-' . $value["Slug"] . '-' . $value["ID"] . '"><span>' . $value["Name"] . '</span></label>
                                    </div>
                                </li>';
                        $offset++;
                    }
                }
                $html .="</ul>";
                break;
            case "number":
                $activer = "";
                if (is_array($item_activer) && count($item_activer) > 0) {
                    foreach ($item_activer as $key => $value_activer) {
                        if ($value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                            $activer = $value_activer["Value"];
                        }
                    }
                }
                if($unit != ""){
                    $html .='<div class="form-group"> 
                                <div class="input-group"> 
                                    <span class="input-group-addon">'.$unit.'</span> ';
                                    $html .= "<input type ='number' data-type ='".$type."' id='" . $slug . "' value='" . $activer . "' " . $attribute_validate . " class='form-control' name ='" . $name_attribute . "' " . $required_in . " " . $required_text . ">";
                            $html .='</div>
                            </div>';
                }else{
                    $html .= "<input type ='number' data-type ='".$type."' id='" . $slug . "' value='" . $activer . "' " . $attribute_validate . " class='form-control' name ='" . $name_attribute . "' " . $required_in . " " . $required_text . ">";
                }
                
                break;
            case "date":
                $activer = "";
                if (is_array($item_activer) && count($item_activer) > 0) {
                    foreach ($item_activer as $key => $value_activer) {
                        if ($value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                            $activer = $value_activer["Value"];
                        }
                    }
                }
                $html .= '<div class="input-group"><div class="input-group-addon"> <i class="fa fa-calendar"></i></div><input type="text" value="' . $activer . '" class="form-control pull-right" name="' . $name_attribute . '" id="date-filed" data-type ="'.$type.'" ' . $required_in . ' ' . $required_text . '></div>';
                break;
            case "textarea":
                $activer = "";
                if (is_array($item_activer) && count($item_activer) > 0) {
                    foreach ($item_activer as $key => $value_activer) {
                        if ($value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                            $activer = $value_activer["Value"];
                        }
                    }
                }
                $html .= '<textarea class="form-control" data-type ="'.$type.'" name="' . $name_attribute . '" ' . $attribute_validate . ' ' . $required_in . ' ' . $required_text . '>' . $activer . '</textarea>';
                break;
            default:
                $activer = "";
                if (is_array($item_activer) && count($item_activer) > 0) {
                    foreach ($item_activer as $key => $value_activer) {
                        if ($value_activer["Attribute_ID"] == $id && $value_activer["Group_ID"] == $group_id) {
                            $activer = $value_activer["Value"];
                        }
                    }
                }
                if($unit != ""){
                    $html .='<div class="form-group"> 
                                <div class="input-group"> 
                                    <span class="input-group-addon">'.$unit.'</span> ';
                                    $html .= "<input type ='text' data-type ='".$type."' value='" . str_replace("'", "&#39;", $activer) . "' id='" . $slug . "' class='form-control' name ='" . $name_attribute . "' " . $attribute_validate . " " . $required_in . " " . $required_text . ">";
                        $html .='</div>
                            </div>';
                }else{
                    $html .= "<input type ='text' data-type ='".$type."' value='" . str_replace("'", "&#39;", $activer) . "' id='" . $slug . "' class='form-control' name ='" . $name_attribute . "' " . $attribute_validate . " " . $required_in . " " . $required_text . ">";
                }
        }
        $html.="</div><p class='messenger_error'>".$messenger_error."</p></fieldset>";
        return $html;
    }

}

if (!function_exists('get_folder_photo')) {

    function get_folder_photo($class = '') {
        $CI = get_instance();
        $member_id = 0;
        if ($CI->session->userdata('user_info')) {
            $user_info = $CI->session->userdata('user_info');
            $member_id = $user_info["id"];
        }
        if ($member_id == 0) {
            return '';
        }

        $folder = new Media_Folder();
        $folder->where(array(
            'Member_ID' => $member_id,
            'Status' => 0
        ));
        $folder->order_by('Folder_Name', 'ASC');
        $all_folder = $folder->get();
        $folders = array(
            'items' => array(),
            'parents' => array()
        );
        foreach ($all_folder as $items) {
            $folders['items'][$items->ID] = array(
                'slug' => $items->Slug,
                'name' => $items->Folder_Name,
                'parent_id' => $items->Parents_ID,
                'id' => $items->ID
            );
            $folders['parents'][$items->Parents_ID][] = $items->ID;
        }
        return build_folder_tree(0, $folders, $class);
    }

}

if (!function_exists('build_folder_tree')) {

    function build_folder_tree($parent, $menu, $class = "") {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $cls = '';
            if ($parent == 0) {
                $cls = 'class="' . $class . '"';
            }
            $html .= "<ul " . $cls . ">\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li data-id='" . $menu['items'][$itemId]['id'] . "'>
                    			<i class='fa-folder-open-o fa'></i>  <span class='name'>" . $menu['items'][$itemId]['name'] . "</span>
                    		    <div class='action-folder'>
                                   <p><a title='Thêm thư mục' class='add' href='#'><i class='fa fa-plus'></i> Thêm thư mục</a></p>
                                   <p><a title='Chỉnh sữa thư mục' class='rename'><img src='" . skin_url() . "/images/edit.png'> Sữa tên thư mục</a></p>
                                   <p><a title='Xóa thư mục' class='delete'><img src='" . skin_url() . "/images/cross.png'> Xóa thư mục</a></p>
                                </div>
                              </li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li class='sub-folder closes' data-id='" . $menu['items'][$itemId]['id'] . "'>
                                <span class='toggle'><i class='fa-caret-left fa'></i></span>
                    			<i class='fa-folder-open-o fa'></i>  <span class='name'>" . $menu['items'][$itemId]['name'] . "</span>
                                <div class='action-folder'>
                                   <p><a title='Thêm thư mục' class='add' href='#'><i class='fa fa-plus'></i> Thêm thư mục</a></p>
                                   <p><a title='Chỉnh sữa thư mục' class='rename'><img src='" . skin_url() . "/images/edit.png'> Sữa tên thư mục</a></p>
                                   <p><a title='Xóa thư mục' class='delete'><img src='" . skin_url() . "/images/cross.png'> Xóa thư mục</a></p>
                                </div>";
                    $html .= build_folder_tree($itemId, $menu);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }

}