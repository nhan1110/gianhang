<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hook_Admin_Menu {

    public function load_menu() 
    {
    	$ci = &get_instance();
        $ci->load->library('session');
	        
    	if ($ci->session->userdata('admin_logged_in') !== FALSE) {
    		if ($ci->session->userdata('menu_admin') === NULL || $ci->session->userdata('menu_admin') === FALSE) {
		        $modules = new Modules();
		        $modules->order_by('Order', 'ASC');
		        $modules->get();
		        $category = array(
		            'items' => array(),
		            'parents' => array()
		        );
		        foreach ($modules as $item) {
		            // Creates entry into items array with current menu item id ie. $menu['items'][1]
		            $category['items'][$item->ID] = array(
		                'key' => $item->Module_Key,
		                'title' => $item->Module_Name,
		                'url' => $item->Module_Url,
		                'class' => $item->Module_Class,
		                'id' => $item->ID
		            );
		            // Creates entry into parents array. Parents array contains a list of all items with children
		            $category['parents'][$item->Parent_ID][] = $item->ID;
		        }
		        $ci->session->set_userdata('menu_admin', $this->build_tree(0, $category, "sidebar-menu", 0));
        	}
	    }
    }
    
    private function build_tree($parent, $menu, $id="", $level=0) {
        $html = "";
        if (isset($menu['parents'][$parent]) && $level < 3) {
            $cls = '';
            if ($parent == 0 && $level == 0) {
                $cls = 'sidebar-menu';
            } else if ($level == 1) {
            	$cls = 'treeview-menu';
            }
            $html .= '<ul id="' . $id . '" class="'.$cls.'">';
            foreach ($menu['parents'][$parent] as $itemId) {
            	if ($level == 0) {
            		$html .= '<li class="header">' . $menu['items'][$itemId]['title'] . '</li>';
            		$html .= $this->build_tree($itemId, $menu, "", ($level + 1));
            	} else if ($level <= 2) {
            		$html .= '<li>';
            		$html .= '<a href="' . $menu['items'][$itemId]['url'] . '"><i class="' . $menu['items'][$itemId]['class'] . '"></i> <span>' . $menu['items'][$itemId]['title'] . '</span></a>';
            		$html .= $this->build_tree($itemId, $menu, "", ($level + 1));
                	$html .= "</li>";
            	}
            }
            $html .= "</ul>";
        }
        return $html;
    }
}
