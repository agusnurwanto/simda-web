<?php namespace Modules\Tata_usaha\Controllers\Verifikasi\Spp\Up;
/**
 * Tata Usaha > Verifikasi > SPP > UP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spp_rinc';
	
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
				<div class="row text-sm border-bottom">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						sub unit
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header['query']->kd_urusan . '.' . $header['query']->kd_bidang . '.' . $header['query']->kd_unit . '.' . $header['query']->kd_sub . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header['query']->nm_sub_unit . '
					</label>
				</div>
				<div class="row text-sm border-bottom">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						no spp
					</label>
					<label class="col-2 col-sm-6 mb-0">
						' . $header['query']->no_spp . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah total usulan
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
							Rp. ' . number_format(($header['query_total']->usulan), 2) . '
						</b>
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						tanggal spp
					</label>
					<label class="col-2 col-sm-6 mb-0">
						' . date("d F Y", strtotime($header['query']->tgl_spp)) . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah total disetujui
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
							Rp. ' . number_format(($header['query_total']->nilai), 2) . '
						</b>
					</label>
				</div>
			');
		}
		
		$this->set_breadcrumb
		(
			array
			(
				'tata_usaha/verifikasi/spp/up/sub_unit'	=> 'Tata Usaha Verifikasi SPP UP',
				'../verifikasi/spp/up'					=> 'Spp UP'
			)
		);
		
		$this->set_title('Rinc SPP Uang Persediaan')
		->set_icon('mdi mdi-reflect-vertical')
		->set_primary('tahun, no_spp, kd_urusan, kd_bidang, kd_unit, kd_sub, jns_tagihan')
		->unset_action('export, print, pdf, create, delete')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_spp, kd_sumber, no_id, nm_sumber')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_spp, kd_sumber')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_spp, no_id')
		->field_prepend
		(
			array
			(
				'usulan'							=> 'Rp',
				'nilai'								=> 'Rp'
			)
		)
		->set_alias
		(
			array
			(
				'kd_rek_1'							=> 'Rekening',
				'kd_rek_4'							=> 'Kode Rekening',
				'kd_rek_5'							=> 'Uraian',
				'usulan'							=> 'Nilai Usulan',
				'nilai'								=> 'Nilai Setuju',
				'no_id'								=> 'No. Urut',
				'nm_sumber'							=> 'Sumber Dana',
				'kd_sumber'							=> 'Sumber Dana'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'usulan'							=> 'price_format, readonly',
				'nilai'								=> 'price_format'
			)
		)
		
		->merge_content('{kd_prog}.{kd_keg}', 'Kegiatan')
		->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
		->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')

		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'no_spp'							=> service('request')->getGet('no_spp'),
				'kd_prog'							=> '0',
				'id_prog'							=> '0',
				'kd_keg'							=> '0',
				'kd_rek_1'							=> '1',
				'kd_rek_2'							=> '1',
				'kd_rek_3'							=> '1',
				'kd_rek_4'							=> '3',
				'kd_rek_5'							=> '1',
				'kd_sumber'							=> '3',
			)
		)
		->set_validation
		(
			array
			(
				'usulan'							=> 'required|numeric',
				'nilai'								=> 'required|numeric|callback_validasi_nilai'
			)
		)
		->set_relation
		(
			'kd_sumber',
			'ref_sumber_dana.kd_sumber',
			'{ref_sumber_dana.kd_sumber}. {ref_sumber_dana.nm_sumber}',
			array
			(
				'kd_sumber'							=> 3
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
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'no_spp'							=> service('request')->getGet('no_spp'),
				'jn_spp'							=> service('request')->getGet('jn_spp')
			)
		)
		->render($this->_table);
	}

	public function validasi_nilai($value = 0)
	{
		if(!$value)
		{
			return 'Bidang Nilai Usulan dibutuhkan';
		}
		
		$query										= $this->model->select
		('
			usulan,
		')
		->get_where
		(
			'ta_spp_rinc',
			array
			(
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'no_spp'							=> service('request')->getGet('no_spp'),
			)
		)
		->row();
		
		if($value > $query->usulan)
		{
			return 'Nilai disetujui lebih besar dari nilai usulan';
		}
		
		return true;
	}

	public function kode_rekening_kd_rek1($params = array())
	{
		ini_set('memory_limit', '-1');
		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0) . '.' . (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);
		
		$kd_urusan									= service('request')->getGet('kd_urusan');
		$kd_bidang									= service('request')->getGet('kd_bidang');
		$kd_unit									= service('request')->getGet('kd_unit');
		$kd_sub										= service('request')->getGet('kd_sub');
		
		$option										= '<option value="all">Silahkan Pilih</option>';
		
		if(service('request')->getGet('jn_spp') == '1')
		{
			$query									= $this->model->select
			('
				' . $kd_urusan . ' AS kd_urusan,
				' . $kd_bidang . ' AS kd_bidang,
				' . $kd_unit . ' AS kd_unit,
				' . $kd_sub . ' AS kd_sub,
				0 AS kd_prog,
				0 AS id_prog,
				0 AS kd_keg,
				"Non Program" ket_kegiatan,
				ref_rek_5.kd_rek_1,
				ref_rek_5.kd_rek_2,
				ref_rek_5.kd_rek_3,
				ref_rek_5.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_5.nm_rek_5
			')
			->get_where
			(
				'ref_rek_5',
				array
				(
					'ref_rek_5.kd_rek_1'			=> 1,
					'ref_rek_5.kd_rek_2'			=> 1,
					'ref_rek_5.kd_rek_3'			=> 1,
					'ref_rek_5.kd_rek_4'			=> 3,
					'ref_rek_5.kd_rek_5'			=> 1
				)
			)
			->result();
		}
		else
		{
			$query									= $this->model->select
			('
				ta_kegiatan.kd_urusan,
				ta_kegiatan.kd_bidang,
				ta_kegiatan.kd_unit,
				ta_kegiatan.kd_sub,
				ta_kegiatan.kd_prog,
				ta_kegiatan.id_prog,
				ta_kegiatan.kd_keg,
				ta_kegiatan.ket_kegiatan,
				ref_rek_5.kd_rek_1,
				ref_rek_5.kd_rek_2,
				ref_rek_5.kd_rek_3,
				ref_rek_5.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_5.nm_rek_5
			')
			->join
			(
				'ta_belanja',
				'ta_belanja.kd_urusan = ta_kegiatan.kd_urusan and
			ta_belanja.kd_bidang = ta_kegiatan.kd_bidang and
			ta_belanja.kd_unit = ta_kegiatan.kd_unit and
			ta_belanja.kd_sub = ta_kegiatan.kd_sub and
			ta_belanja.kd_prog = ta_kegiatan.kd_prog and
			ta_belanja.id_prog = ta_kegiatan.id_prog and
			ta_belanja.kd_keg = ta_kegiatan.kd_keg'
			)
			->join
			(
				'ref_rek_5',
				'ref_rek_5.kd_rek_1 = ta_belanja.kd_rek_1 and
			ref_rek_5.kd_rek_2 = ta_belanja.kd_rek_2 and
			ref_rek_5.kd_rek_3 = ta_belanja.kd_rek_3 and
			ref_rek_5.kd_rek_4 = ta_belanja.kd_rek_4 and
			ref_rek_5.kd_rek_5 = ta_belanja.kd_rek_5'
			)
			/*
			->join
			(
				'ta_spp_rinc',
				'ta_spp_rinc.kd_rek_1 = ta_belanja.kd_rek_1 and
					ta_spp_rinc.kd_rek_2 = ta_belanja.kd_rek_2 and
					ta_spp_rinc.kd_rek_3 = ta_belanja.kd_rek_3 and
					ta_spp_rinc.kd_rek_4 = ta_belanja.kd_rek_4 and
					ta_spp_rinc.kd_rek_5 = ta_belanja.kd_rek_5 and
					ta_spp_rinc.kd_urusan = ta_belanja.kd_urusan and
					ta_spp_rinc.kd_bidang = ta_belanja.kd_bidang and
					ta_spp_rinc.kd_unit = ta_belanja.kd_unit and
					ta_spp_rinc.kd_sub = ta_belanja.kd_sub and
					ta_spp_rinc.kd_prog = ta_belanja.kd_prog and
					ta_spp_rinc.kd_keg = ta_belanja.kd_keg'
			)
			*/
			->get_where
			(
				'ta_kegiatan',
				array
				(
					'ta_belanja.tahun'				=> get_userdata('year'),
					'ta_belanja.kd_urusan'			=> service('request')->getGet('kd_urusan'),
					'ta_belanja.kd_bidang'			=> service('request')->getGet('kd_bidang'),
					'ta_belanja.kd_unit'			=> service('request')->getGet('kd_unit'),
					'ta_belanja.kd_sub'				=> service('request')->getGet('kd_sub'),
					'ta_belanja.kd_prog'			=> 2,
					'ta_belanja.kd_keg'				=> 1
				)
			)
			->result();
		}
		
		foreach($query as $key => $val)
		{
			$option									.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . '.' .$val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . ' - ' . $val->ket_kegiatan . ' (' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . ' ' . $val->nm_rek_5 . ')</option>';
		}
		
		return '<select name="kegiatan" class="form-control">' . $option . '</select>';
	}

	public function kode_rekening_kd_rek4($params = array())
	{
		$exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		return $exists;
	}

	public function kode_rekening_kd_rek5($params = array())
	{
		$query										= $this->model->select
		('
			kd_rek_1,
			kd_rek_2,
			kd_rek_3,
			kd_rek_4,
			kd_rek_5,
			nm_rek_5
		')
		->get_where
		(
			'ref_rek_5',
			array
			(
				'ref_rek_5.kd_rek_1'				=> $params['kd_rek_1']['original'],
				'ref_rek_5.kd_rek_2'				=> $params['kd_rek_2']['original'],
				'ref_rek_5.kd_rek_3'				=> $params['kd_rek_3']['original'],
				'ref_rek_5.kd_rek_4'				=> $params['kd_rek_4']['original'],
				'ref_rek_5.kd_rek_5'				=> $params['kd_rek_5']['original']
			)
		)
		->result();
		
		$rekening									= null;
		
		foreach($query as $key => $val)
		{
			$rekening								= $val->nm_rek_5;
		}
		
		return $rekening;
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_spp.no_spp,
			ta_spp.tgl_spp,
			ta_spd_rinc.no_spd,
			ta_spd_rinc.nilai,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ta_spd_rinc',
			'ta_spd_rinc.kd_urusan = ta_spp.kd_urusan AND ta_spd_rinc.kd_bidang = ta_spp.kd_bidang AND ta_spd_rinc.kd_unit = ta_spp.kd_unit AND ta_spd_rinc.kd_sub = ta_spp.kd_sub'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_spp.kd_urusan AND ref_sub_unit.kd_bidang = ta_spp.kd_bidang AND ref_sub_unit.kd_unit = ta_spp.kd_unit AND ref_sub_unit.kd_sub = ta_spp.kd_sub'
		)
		->get_where
		(
			'ta_spp',
			array
			(
				'ta_spp.tahun'						=> get_userdata('year'),
				'ta_spp.kd_urusan'					=> service('request')->getGet('kd_urusan'),
				'ta_spp.kd_bidang'					=> service('request')->getGet('kd_bidang'),
				'ta_spp.kd_unit'					=> service('request')->getGet('kd_unit'),
				'ta_spp.kd_sub'						=> service('request')->getGet('kd_sub'),
				'ta_spp.no_spp'						=> service('request')->getGet('no_spp')
			)
		)
		->row();
		
		$query_total								= $this->model->select
		('
			SUM(usulan) AS usulan,
			SUM(nilai) AS nilai
		')
		->get_where
		(
			'ta_spp_rinc',
			array
			(
				'ta_spp_rinc.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_spp_rinc.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_spp_rinc.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_spp_rinc.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_spp_rinc.no_spp'				=> service('request')->getGet('no_spp')
			)
		)
		->row();
		
		$output										= array
		(
			'query'									=> $query,
			'query_total'							=> $query_total
		);

		return $output;
	}
}
