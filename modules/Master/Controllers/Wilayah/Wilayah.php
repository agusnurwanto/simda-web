<?php namespace Modules\Master\Controllers\Wilayah;
/**
 * Master > Wilayah
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Wilayah extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$this->set_title('Master Data Wilayah / Regional')
		->set_icon('mdi mdi-map-marker-distance')
		->render();
	}
}
