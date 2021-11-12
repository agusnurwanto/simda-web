<?php namespace Modules\Bud\Controllers\Sp2b;
/**
 * BUD > SP2B > SP3B
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sp3b extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_sp3b';
	
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
						sub unit
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_urusan . '.' . $header->kd_bidang . '.' . $header->kd_unit . '.' . $header->kd_sub . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_sub_unit . '
					</label>
				</div>
			');
		}
		
		$this->set_breadcrumb
		(
			array
			(
				'bud/sp3b/sub_unit'					=> 'Sub Unit'
			)
		);
		
		$this->set_title('SP3B')
		->set_icon('mdi mdi-sign-direction')
		->set_primary('tahun, no_sp3b, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_edit')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, periode, nm_penandatangan, nip_penandatangan, jbt_penandatangan, kd_edit')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, periode, nm_penandatangan, nip_penandatangan, jbt_penandatangan, kd_edit')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, periode, nm_penandatangan, nip_penandatangan, jbt_penandatangan, kd_edit')
		->unset_truncate('uraian')
		
		->set_field
		(
			'uraian',
			'hyperlink',
			'bud/sp2d',
			array
			(
				'no_spm'							=> 'uraian'
			)
		)
		->set_field
		(
			array
			(
				'tgl_spd'							=> 'datepicker',
			)
		)
		->set_alias
		(
			array
			(
				'no_sp3b'							=> 'Nomor SP3B',
				'tgl_sp3b'							=> 'Tanggal SP3B',
				'nm_penandatangan'					=> 'Nama',
				'nip_penandatangan'					=> 'NIP',
				'jbt_penandatangan'					=> 'Jabatan',
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub')
			)
		)
		->render($this->_table);
	}
	
	private function _header()
	{
		$query										= $this->model->select
		('
			ta_kegiatan.kd_urusan,
			ta_kegiatan.kd_bidang,
			ta_kegiatan.kd_unit,
			ta_kegiatan.kd_sub,
			ta_kegiatan.kd_keg,
			ta_kegiatan.kd_prog,
			ta_kegiatan.ket_kegiatan,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan and ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang and ref_sub_unit.kd_unit = ta_kegiatan.kd_unit and ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
		)
		->get_where
		(
			'ta_kegiatan',
			array
			(
				'ta_kegiatan.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_kegiatan.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_kegiatan.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_kegiatan.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_kegiatan.kd_keg'				=> 0
			)
		)
		->row();
		
		return $query;
	}
}
