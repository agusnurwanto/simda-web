<?php namespace Modules\Master\Controllers\Anggaran;
/**
 * Master > Anggaran > Tim Anggaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Tim_anggaran extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_tim_anggaran';
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
				'master/anggaran/tim_anggaran'		=> phrase('tim_anggaran')
			)
		);

        $this->set_title(phrase('master_tim_anggaran'))
        ->set_primary('tahun, kd_tim, no_urut')
        ->set_icon('mdi mdi-access-point')
        ->unset_action('export, print, pdf')
        ->unset_column('tahun')
        ->unset_field('tahun')
        ->unset_view('tahun')
        ->unset_truncate('nama, nip, jabatan')
        ->column_order('no_urut, kd_tim, nm_tim')
        ->set_field
        (
            array
            (
                'no_urut'						    => 'last_insert'
            )
        )
        ->add_class
        (
            array
            (
                'nama'						        => 'autofocus',
            )
        )
        ->set_alias
        (
            array
            (
                'kd_tim'						    => 'Kode Tim',
                'nm_tim'						    => 'Kode Tim'
            )
        )
        ->set_validation
        (
            array
            (
                'kd_tim'						    => 'required',
                'no_urut'						    => 'required',
                'nama'						        => 'required',
                'nip'						        => 'required',
                'jabatan'						    => 'required'
            )
        )
        ->set_default
        (
            array
            (
                'tahun'								=> get_userdata('year')
            )
        )
        ->set_relation
        (
            'kd_tim',
            'ref_kode_tim.kd_tim',
            '{ref_kode_tim.kd_tim}. {ref_kode_tim.nm_tim}',
            null,
            null,
            array
            (
                'ref_kode_tim.kd_tim'				=> 'ASC'
            )
        )
        ->order_by('kd_tim, no_urut')
        ->render($this->_table);
	}

}
