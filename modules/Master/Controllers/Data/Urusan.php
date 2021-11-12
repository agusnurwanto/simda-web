<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Urusan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Urusan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_urusan';
	
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
				'master/data/urusan'				=> phrase('urusan')
			)
		);
		
		$this->set_title('Master Urusan')
		->set_icon('mdi mdi-access-point')
		->set_primary('kd_urusan')
		->unset_truncate('nm_urusan')
		->unset_action('export, print, pdf')
		->field_size
		(
			array
			(
				'kd_urusan'							=> 'col-3',
				'nm_urusan'							=> 'col-12'
			)
		)
		->set_field('nm_urusan', 'textarea, hyperlink', 'master/data/bidang', array('kd_urusan' => 'kd_urusan'))
		->set_field
		(
			array
			(
				'kd_urusan'							=> 'last_insert',
			)
		)
		->add_class
		(
			array
			(
				'nm_urusan'							=> 'autofocus'
			)
		)
		->set_alias
		(
			array
			(
				'kd_urusan'							=> 'Kode',
				'nm_urusan'							=> 'Uraian Urusan'
			)
		)
		->set_validation
		(
			array
			(
				'kd_urusan'							=> 'required',
				'nm_urusan'							=> 'required'
			)
		)
		->order_by('kd_urusan')
        ->render($this->_table);
	}
}
