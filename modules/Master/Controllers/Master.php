<?php namespace Modules\Master\Controllers;
/**
 * Master
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Master extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$this->set_title('Master')
		->set_icon('mdi mdi-briefcase-edit-outline')
		->render();
	}
}
