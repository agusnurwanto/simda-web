<?php namespace Modules\Master\Controllers\Sinkronisasi;
/**
 * Master > Sinkronisasi
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sinkronisasi extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		//$this->set_permission(1);
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$this->set_title('Master Sinkronisasi')
		->set_icon('mdi mdi-sync')
		->render();
	}
}
