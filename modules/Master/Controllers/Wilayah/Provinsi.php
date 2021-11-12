<?php namespace Modules\Master\Controllers\Wilayah;
/**
 * Master > Wilayah > Provinsi
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Provinsi extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$this->set_title('Master Data Provinsi')
		->set_icon('mdi mdi-map-legend')
		->unset_column('id')
		->unset_field('id')
		->unset_view('id')
		->set_field('kode', 'last_insert, sprintf', null, '%02d')
		->set_field('provinsi', 'hyperlink', 'master/wilayah/regional', array('provinsi' => 'id'))
		->set_validation
		(
			array
			(
				'kode'								=> 'required|numeric|is_unique[ref__provinsi.kode.id.' . service('request')->getGet('id') . ']',
				'provinsi'							=> 'required|'
			)
		)
		->render('ref__provinsi');
	}
}
