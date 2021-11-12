<?php namespace Modules\Apis\Controllers;
/**
 * APIs > Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Penerimaan extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		//$this->set_permission(1); // only user with group id 1 can access this module
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$data										= file_get_contents('http://10.200.7.201/penerimaan/api/result');
		print_r(json_decode($data));
	}
}
