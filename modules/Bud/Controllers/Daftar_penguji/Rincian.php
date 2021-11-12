<?php namespace Modules\Bud\Controllers\Daftar_penguji;
/**
 * BUD > Daftar Penguji > Rincian
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rincian extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_sp2d';
	
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
		$header										= $this->_header();
		
		if($header)
		{
			$this->set_description
			('
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						No Penguji
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header['query']->no_penguji . '
					</label>
				</div>
			');
		}
		
		$this->set_breadcrumb
		(
			array
			(
				'../bud/spd/daftar_penguji'			=> 'Sub Unit',
				'..'								=> 'Daftar Penguji SP2D'
			)
		);
		
		$this->set_title('Sp2d Rincian')
		->set_icon('mdi mdi-sheep')
		->set_primary('tahun, no_sp2d, no_spm, kd_bank')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_spm, kd_bank, no_bku, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
		->unset_field('tahun, kd_bank, no_bku, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
		->unset_view('tahun, kd_bank, no_bku, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
		->unset_truncate('keterangan')
		
		/*
		->field_prepend
		(
			array
			(
				'nilai'    							=> 'Rp'
			)
		)
		->set_field
		(
			array
			(
				'nilai'								=> 'price_format',
			)
		)
		*/
		->set_alias
		(
			array
			(
				'no_sp2d'							=> 'Nomor SP2D',
				'tgl_sp2d'							=> 'Tanggal SP2D'
			)
		)
		/*
		->set_validation
		(
			array
			(
				'no_spd'							=> 'required||callback_validasi_spd',
				'tgl_spd'							=> 'required|'
			)
		)
		*/
		/*
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'kd_edit'							=> 1,
			)
		)
		*/
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		->render($this->_table);
	}
	
	private function _header()
	{
		$query										= $this->model->select
		('
			ta_penguji.no_penguji
		')
		->get_where
		(
			'ta_penguji',
			array
			(
				'ta_penguji.no_penguji'				=> service('request')->getGet('no_penguji')
			)
		)
		->row();
		
		$output										= array
		(
			'query'									=> $query
		);
		
		return $output;
	}
}
