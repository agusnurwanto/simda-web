<?php namespace Modules\Tata_usaha\Controllers\Pengesahan_spj;
/**
 * Tata Usaha > Pengesahan SPJ
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pengesahan_spj extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_pengesahan_spj';
	
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
		$cek_id										= $this->model->select
		('
			no_pengesahan
		')
		->get_where
		(
			'ta_pengesahan_spj',
			array
			(
				'no_spj'							=> service('request')->getGet('no_spj')
			)
		)
		->row();
		
		if($cek_id)
		{
			$this->unset_action('create');
		}
		
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
				'tata_usaha/pengesahan_spj/sub_unit'	=> 'Tata Usaha',
				'../spj'								=> 'SPJ'
			)
		);
		
		$this->set_title('Pengesahan SPJ')
		->set_icon('mdi mdi-snowflake')
		->set_primary('tahun, no_pengesahan, no_spj')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_spj, no_tolak, ket_tolak')
		->unset_field('tahun, no_spj, no_tolak, ket_tolak')
		->unset_view('tahun')
		->unset_truncate('keterangan')
		
		->set_field
		(
			'keterangan',
			'hyperlink',
			'tata_usaha/pengesahan_spj/rinci',
			array
			(
				'no_pengesahan'						=> 'no_pengesahan'
			)
		)
		->set_field
		(
			array
			(
				'tgl_pengesahan'					=> 'datepicker'
			)
		)
		/*
		->set_alias
		(
			array
			(
				'no_pengesahan'						=> 'Nomor Spj',
				'tgl_pengesahan'					=> 'Tanggal Spj'
			)
		)
		*/
		->set_validation
		(
			array
			(
				'no_pengesahan'						=> 'required|',
				'tgl_pengesahan'					=> 'required|',
				'no_bku'							=> 'required|',
				'keterangan'						=> 'required|'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_spj'							=> service('request')->getGet('no_spj')
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_spj'							=> service('request')->getGet('no_spj')
			)
		)
		->render($this->_table);
	}

	public function after_insert()
	{
		$this->database_config('default');
		
		$query										= $this->model->select
		('
			no_spj,
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			kd_prog,
			id_prog,
			kd_keg,
			kd_rek_1,
			kd_rek_2,
			kd_rek_3,
			kd_rek_4,
			kd_rek_5,
			no_bukti,
			tgl_bukti,
			nilai,
			no_spj_panjar,
			no_spd
		')
		->get_where
		(
			'ta_spj_rinc',
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'no_spj'							=> service('request')->getGet('no_spj')
			)
		)
		->row();
		
		$data										= array
		(
			'tahun'									=> get_userdata('year'),
			'no_pengesahan'							=> trim(service('request')->getPost('no_pengesahan')),
			'no_id'									=> '1',
			'kd_urusan'								=> service('request')->getGet('kd_urusan'),
			'kd_bidang'								=> service('request')->getGet('kd_bidang'),
			'kd_unit'								=> service('request')->getGet('kd_unit'),
			'kd_sub'								=> service('request')->getGet('kd_sub'),
			'kd_prog'								=> $query->kd_prog,
			'id_prog'								=> $query->id_prog,
			'kd_keg'								=> $query->kd_keg,
			'kd_rek_1'								=> $query->kd_rek_1,
			'kd_rek_2'								=> $query->kd_rek_2,
			'kd_rek_3'								=> $query->kd_rek_3,
			'kd_rek_4'								=> $query->kd_rek_4,
			'kd_rek_5'								=> $query->kd_rek_5,
			'nilai_usulan'							=> $query->nilai,
			'nilai_setuju'							=> $query->nilai,
			'no_bukti'								=> $query->no_bukti,
			'tgl_bukti'								=> $query->tgl_bukti,
			'no_spj_panjar'							=> $query->no_spj_panjar,
			'no_spd'								=> $query->no_spd,
		);
		
		$this->model->insert('ta_pengesahan_spj_rinc', $data);
		
		return true;
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
