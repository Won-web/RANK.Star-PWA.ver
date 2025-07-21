<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome'; // 기본은 welcome으로
$route['welcome'] = function () {
    redirect('admin/login');
};
$route['admin'] = 'admin/Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin/login'] = 'admin/Login/index';

// admin 접두어 없는 URL을 admin 하위로 강제 매핑
$route['contest/(:any)'] = 'admin/contest/$1';
$route['contest'] = 'admin/contest/index';

$route['contestant/(:any)'] = 'admin/contestant/$1';
$route['contestant'] = 'admin/contestant/index';

$route['user/(:any)'] = 'admin/user/$1';
$route['user'] = 'admin/user/index';
$route['user/purchasehistory/(:num)'] = 'admin/user/purchasehistory/$1';

$route['manager/(:any)'] = 'admin/manager/$1';
$route['manager'] = 'admin/manager/index';

$route['sales/(:any)'] = 'admin/sales/$1';
$route['sales'] = 'admin/sales/index';

$route['transaction/(:any)'] = 'admin/transaction/$1';
$route['transaction'] = 'admin/transaction/index';

$route['plans/(:any)'] = 'admin/plans/$1';
$route['plans'] = 'admin/plans/index';

$route['notice/(:any)'] = 'admin/notice/$1';
$route['notice'] = 'admin/notice/index';

$route['notification/(:any)'] = 'admin/notification/$1';
$route['notification'] = 'admin/notification/index';