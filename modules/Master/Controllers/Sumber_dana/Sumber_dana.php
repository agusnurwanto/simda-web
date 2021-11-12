<?php namespace Modules\Master\Controllers\Sumber_dana;
/**
 * Master > Anggaran > Tim Anggaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sumber_dana extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_sumber_dana';
	private $_title									= null;
	
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
				'master/sumber_dana/sumber_dana'	=> phrase('sumber_dana')
			)
		);

        $this->set_title(phrase('master_sumber_dana'))
        ->set_primary('kd_sumber')
        ->set_icon('mdi mdi-access-point')
        ->unset_action('export, print, pdf')
        ->set_field
        (
            array
            (
                'kd_sumber'						    => 'last_insert, readonly'
            )
        )
        ->add_class
        (
            array
            (
                'nm_sumber'						    => 'autofocus',
            )
        )
        ->set_alias
        (
            array
            (
                'kd_sumber'						    => 'Sumber',
                'nm_sumber'						    => 'Uraian Nama Sumber'
            )
        )
        ->set_validation
        (
            array
            (
                'nm_sumber'						    => 'required'
            )
        )
        ->order_by('kd_sumber')
        ->render($this->_table);
	}

}
