<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';
$route['home/styled'] = "home/styled";
$route['admin'] = "admin/login";
$route['admin/(:any)'] = "admin/$1";
$route['admin/attribute'] = "admin/attributes";
$route['admin/attributeset'] = "admin/categories_type";
$route['admin/payment/(:any)'] = "admin/payment/index/$1";
$route['danh-muc/(:any)'] = "categories_type/index/$1";
$route['san-pham/(:any)'] = "product/details/$1";
$route['san-pham/them-moi-san-pham'] = "product/add_product";
$route['san-pham/(:any)/(:any)'] = "product/details/$1/$2";
$route['loai-san-pham/(:any)'] = 'category/index/$1';
$route['tim-kiem'] = 'search/index';
/*Favorite*/
$route['yeu-thich/chuyen-muc/(:any)'] = 'favorite/view/$1';
$route['yeu-thich/them-chuyen-muc'] = 'favorite/add/';
$route['yeu-thich/chuyen-chuyen-muc'] = 'favorite/move';
$route['yeu-thich/chinh-sua-chuyen-muc'] = 'favorite/edit';
$route['favorite/delete/(:any)'] = 'favorite/delete/$1';
$route['yeu-thich/thay-doi-anh'] = 'favorite/change_banner/';
$route['yeu-thich/(:any)'] = 'favorite/index/$1';
$route['yeu-thich'] = 'favorite/index';
/*History*/
$route['da-xem/cap-nhap'] = 'member_view/get_result';
$route['da-xem'] = 'member_view/index';
/*Profile*/
$route['tai-khoan/chinh-sua-thong-tin'] = 'profile/update_profile';
$route['tai-khoan/thay-doi-mat-khau'] = 'profile/chang_password';
/* End of file routes.php */
/* Location: ./application/config/routes.php */






