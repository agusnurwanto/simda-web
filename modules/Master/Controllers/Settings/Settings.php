<?php namespace Modules\Master\Controllers\Settings;
/**
 * Master > Data > Bidang
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Settings extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref__settings';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		$this->insert_on_update_fail();
		$this->set_method('update');
	}
	
	public function index()
	{
		$this->set_title('Master Setting')
		->set_icon('mdi mdi-wrench')
		
		->unset_field('tahun')
		
		->set_field
		(
			array
			(
				'logo_laporan'						=> 'image'
			)
		)
		
		->set_field
		(
			'versi_simda',
			'radio',
			array
			(
				0									=> 'Versi 2.7.0.10 kebawah atau sama (Menggunakan Jurnal)',
				1									=> 'Versi 2.7.0.12 (Menggunakan SP3B dan SP2B)'
			)
		)
		
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		->render($this->_table);
	}
}
