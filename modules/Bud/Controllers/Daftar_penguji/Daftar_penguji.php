<?php namespace Modules\Bud\Controllers\Daftar_penguji;
/**
 * BUD > Daftar Penguji
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Daftar_penguji extends \Aksara\Laboratory\Core
{
    private $_table									= 'ta_penguji';
	
	public function __construct()
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
                'bud/daftar_penguji/sub_unit'		=> 'Sub Unit'
            )
        );
		
        $this->set_title('Daftar Penguji SP2D')
        ->set_icon('mdi mdi-sheep')
        ->set_primary('tahun, no_penguji, tgl_penguji, kd_bank')
        ->unset_action('export, print, pdf')
        ->unset_column('tahun, nm_penandatangan, nip_penandatangan, jbt_penandatangan, tgl_buat, tgl_edit, tgl_cetak')
        ->unset_field('tahun, nm_penandatangan, nip_penandatangan, jbt_penandatangan, tgl_buat, tgl_edit, tgl_cetak')
        ->unset_view('tahun, nm_penandatangan, nip_penandatangan, jbt_penandatangan, tgl_buat, tgl_edit, tgl_cetak')
		
        ->set_field
        (
            'keterangan',
            'hyperlink',
            'bud/daftar_penguji/rincian',
            array
            (
                'no_penguji'						=> 'no_penguji'
            )
        )
        ->set_field
        (
            array
            (
                'tgl_penguji'						=> 'datepicker'
            )
        )
        ->set_alias
        (
            array
            (
                'kd_bank'							=> 'Bank',
                'tgl_penguji'						=> 'Tanggal',
            )
        )
        ->set_field
        (
            'kd_bank',
            'radio',
            array
            (
                1									=> '<label class="badge badge-success" >Bank Jabar Banten</label>'
            )
        )
        ->set_validation
        (
            array
            (
                'no_penguji'						=> 'required|',
                'tgl_penguji'						=> 'required|',
                'kd_bank'						    => 'required|',
                'keterangan'						=> 'required|'
            )
        )
        ->set_default
        (
            array
            (
                'tahun'								=> get_userdata('year'),
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
