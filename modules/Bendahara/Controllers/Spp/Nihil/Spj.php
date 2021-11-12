<?php namespace Modules\Bendahara\Controllers\Spp\Nihil;
/**
 * Bendahara > SPP > Nihil > SPJ
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Spj extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_pengesahan_spj_rinc';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
		
		$this->_urusan								= service('request')->getGet('kd_urusan');
		
		if(!$this->_urusan)
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
		}
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
				'bendahara/spp/gu/sub_unit'			=> 'Bendahara Pengeluaran SPP NIHIL'
			)
		);
		
		$this->set_title('SPJ')
		->set_icon('mdi mdi-skype')
		->set_primary('tahun, no_pengesahan, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf, create, delete, update')
		->unset_column('tahun, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, no_bukti, tgl_bukti, no_spj_panjar, no_spd, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, nilai_usulan, nilai_setuju')
		->unset_field('tahun, no_id, no_spd, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, no_bukti, tgl_bukti, no_spj_panjar, no_spd, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, no_id, no_spj_panjar, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_rek_1, kd_rek_2, kd_rek_3')
		->unset_truncate('keterangan')
		
		->set_field
		(
			'keterangan',
			'hyperlink',
			'bendahara/spp/nihil',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'no_pengesahan'						=> 'no_pengesahan',
				'keterangan'						=> 'keterangan'
			)
		)
		
		->field_prepend
		(
			array
			(
				'nilai_usulan'						=> 'Rp',
				'nilai_setuju'						=> 'Rp'
			)
		)
		->set_alias
		(
			array
			(
				'no_pengesahan'						=> 'Nomor Pengesahan',
				'tgl_pengesahan'					=> 'Tanggal Pengesahan',
				'no_spj'							=> 'Nomor Spj'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'no_pengesahan'						=> 'readonly',
				'nilai_usulan'						=> 'price_format',
				'nilai_setuju'						=> 'price_format',
				'tgl_bukti'							=> 'datepicker',
				'tgl_pengesahan'					=> 'datepicker'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		->select
		('
			no_spj,
			tgl_pengesahan,
			no_spj,
			keterangan
		')
		->join
		(
			'ta_pengesahan_spj',
			'ta_pengesahan_spj.no_pengesahan = ta_pengesahan_spj_rinc.no_pengesahan'
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> 1000
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
