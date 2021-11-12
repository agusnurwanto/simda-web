<?php namespace Modules\Master\Controllers\Rekening;
/**
 * Master > Rekening > Akun
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Akun extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_rek_1';
	
	function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
        $this->database_config('default');
	}
	
	public function index()
	{
		$this->set_breadcrumb
		(
			array
			(
				'master/rekening/akun'				=> phrase('akun')
			)
		);
		
		$this->set_title('Master Akun')
		->set_icon('mdi mdi-access-point')
		->set_primary('kd_rek_1')
        ->unset_action('export, print, pdf')
		->unset_truncate('nm_rek_1')
		->set_field('nm_rek_1', 'textarea, hyperlink', 'master/rekening/kelompok', array('akun' => 'kd_rek_1'))
		->set_field
		(
			array
			(
				'kd_rek_1'							=> 'last_insert, readonly',
			)
		)
		->add_class
		(
			array
			(
				'nm_rek_1'							=> 'autofocus'
			)
		)
		->set_alias
		(
			array
			(
                'kd_rek_1'							=> 'Akun',
				'nm_rek_1'							=> 'Nama Rekening Akun'
			)
		)
		->set_validation
		(
			array
			(
				'nm_rek_1'							=> 'required'
			)
		)
		->order_by('kd_rek_1')
        ->render($this->_table);
	}
}
