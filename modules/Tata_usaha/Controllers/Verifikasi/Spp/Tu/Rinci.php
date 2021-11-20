<?php namespace Modules\Tata_usaha\Controllers\Verifikasi\Spp\Tu;
/**
 * Tata Usaha > Verifikasi > SPP > TU > Rinci
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

		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}
	}

	public function index()
	{
		if(service('request')->getPost('token'))
		{
			//var_dump(service('request')->getPost('kegiatan'));die;
			if(service('request')->getPost('kegiatan') != 'all' && !empty(service('request')->getPost('kegiatan')))
			{
				list($r1, $r2, $r3, $r4, $r5, $r6, $r7)		= array_pad(explode('.', service('request')->getPost('kegiatan')), 5, 0);
				
				$this->set_default
				(
					array
					(
						'kd_urusan'					=> $r1,
						'kd_bidang'					=> $r2,
						'kd_unit'					=> $r3,
						'kd_sub'					=> $r4,
						'kd_prog'					=> $r5,
						'id_prog'					=> $r6,
						'kd_keg'					=> $r7
					)
				);
			}
			
			if(service('request')->getPost('belanja') != 'all')
			{
				list($r1, $r2, $r3, $r4, $r5)		= array_pad(explode('.', service('request')->getPost('belanja')), 5, 0);
				
				$this->set_default
				(
					array
					(
						'kd_rek_1'					=> $r1,
						'kd_rek_2'					=> $r2,
						'kd_rek_3'					=> $r3,
						'kd_rek_4'					=> $r4,
						'kd_rek_5'					=> $r5,
					)
				);
			}
		}
		
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
				'tata_usaha/verifikasi/spp/tu/sub_unit'	=> 'Tata Usaha Verifikasi SPP TU',
				'../verifikasi/spp/tu'					=> 'Spp Tu'
			)
		);
		
		$this->set_title('Rinc SPP Tambah Uang Persediaan')
		->set_icon('mdi mdi-sack')
		->set_primary('ta_spp_rinc.tahun, ta_spp_rinc.no_spp, ta_spp_rinc.kd_urusan, ta_spp_rinc.kd_bidang, ta_spp_rinc.kd_unit, ta_spp_rinc.kd_sub, ta_spp.jns_tagihan')
		->unset_action('export, print, pdf, create, delete')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_spp, kd_sumber, no_id, nm_sumber')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_prog, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_spp, kd_sumber')
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
				'kd_keg'							=> 'Kegiatan',
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
		->set_field('kd_keg', 'custom_format', 'callback_kode_rekening_kd_keg')
		
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_spp'							=> service('request')->getGet('no_spp'),
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
		->set_relation
		(
			'no_spp',
			'ta_spp.no_spp',
			'{ta_spp.no_spp}',
			array
			(
				'ta_spp.no_spp'							=> 'ta_spp_rinc.no_spp'
			)
		)
		->where
		(
			array
			(
				'ta_spp_rinc.tahun'								=> get_userdata('year'),
				'ta_spp_rinc.kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'ta_spp_rinc.kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'ta_spp_rinc.kd_unit'							=> service('request')->getGet('kd_unit'),
				'ta_spp_rinc.kd_sub'							=> service('request')->getGet('kd_sub'),
				'ta_spp_rinc.no_spp'							=> service('request')->getGet('no_spp'),
				'ta_spp.jn_spp'							=> service('request')->getGet('jn_spp')
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

	public function kode_rekening_kd_keg($params = array())
	{
		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0);
		
		$existsbelanja								= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		$output										= null;
		$query										= $this->model->select
		('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			kd_prog,
			id_prog,
			kd_keg,
			ket_kegiatan
		')
		->order_by('kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg', 'ASC')
		->get_where
		(
			'ta_kegiatan',
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'kd_prog'							=> 2,
				'id_prog'							=> 101,
				'kd_keg'							=> 1
			)
		)
		->result_array();

		$query_belanja								= $this->model->select
		('
			ref_rek_5.kd_rek_1,
			ref_rek_5.kd_rek_2,
			ref_rek_5.kd_rek_3,
			ref_rek_5.kd_rek_4,
			ref_rek_5.kd_rek_5,
			ref_rek_5.nm_rek_5
		')
		->join
		(
			'ref_rek_5',
			'ref_rek_5.kd_rek_1 = ta_belanja_rinc_sub.kd_rek_1 AND ref_rek_5.kd_rek_2 = ta_belanja_rinc_sub.kd_rek_2 AND ref_rek_5.kd_rek_3 = ta_belanja_rinc_sub.kd_rek_3 AND ref_rek_5.kd_rek_4 = ta_belanja_rinc_sub.kd_rek_4 AND ref_rek_5.kd_rek_5 = ta_belanja_rinc_sub.kd_rek_5'
		)
		->order_by
		('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			kd_prog,
			id_prog,
			kd_keg
		')
		->get_where
		(
			'ta_belanja_rinc_sub',
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'kd_prog'							=> 2,
				'id_prog'							=> 101,
				'kd_keg'							=> 1
			),
			80
		)
		->result_array();
		
		if($query)
		{
			$options								= null;
			$options2								= null;
			
			foreach($query as $key => $val)
			{
				$options							.= '<option value="' . $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . '.' . $val['kd_prog'] . '.' . $val['id_prog'] . '.' . $val['kd_keg'] . '"' . ($exists == $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . '.' . $val['kd_prog'] . '.' . $val['id_prog'] ? ' selected' : null) . '>' . $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . '.' . $val['kd_prog'] . '.' . $val['id_prog'] . '.' . $val['kd_keg'] . ' - ' . $val['ket_kegiatan'] . '</option>';
			}
			
			foreach($query_belanja as $key => $val)
			{
				$options2							.= '<option value="' . $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '.' . $val['kd_rek_3'] . '.' . $val['kd_rek_4'] . '.' . $val['kd_rek_5'] . '"' . ($existsbelanja == $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '.' . $val['kd_rek_3'] . '.' . $val['kd_rek_4'] . '.' . $val['kd_rek_5'] ? ' selected' : null) . '>' . $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '.' . $val['kd_rek_3'] . '.' . $val['kd_rek_4'] . '.' . $val['kd_rek_5'] . ' - ' . $val['nm_rek_5'] . '</option>';
			}
			
			$output									.= '
				<div class="form-group">
					<select name="kegiatan" class="form-control form-control-sm report-dropdown" to-change=".belanja" disabled>
						<option value="all">Silakan pilih Kegiatan</option>
						' . $options . '
					</select>
				</div>
				<div class="form-group">
					<label class="control-label">
						Rekening
					</label>
					<select name="belanja" class="form-control form-control-sm report-dropdown belanja" disabled>
						<option value="all">Silakan pilih Kegiatan terlebih dahulu</option>
						' . $options2 . '
					</select>
				</div>
			';
		}
		
		return $output;
	}

	private function _dropdown()
	{
		$this->database_config('default');
		
		$primary									= service('request')->getPost('primary');
		$list										= $primary != 'all' ? explode(".", $primary) : null;
		$element									= service('request')->getPost('element');
		$options									= null;

		if('.belanja' == $element)
		{
			$query									= $this->model->select
			('
				ref_rek_5.kd_rek_1,
				ref_rek_5.kd_rek_2,
				ref_rek_5.kd_rek_3,
				ref_rek_5.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_5.nm_rek_5
			')
			->join
			(
				'ref_rek_5',
				'ref_rek_5.kd_rek_1 = ta_belanja_rinc_sub.kd_rek_1 AND ref_rek_5.kd_rek_2 = ta_belanja_rinc_sub.kd_rek_2 AND ref_rek_5.kd_rek_3 = ta_belanja_rinc_sub.kd_rek_3 AND ref_rek_5.kd_rek_4 = ta_belanja_rinc_sub.kd_rek_4 AND ref_rek_5.kd_rek_5 = ta_belanja_rinc_sub.kd_rek_5'
			)
			->order_by
			('
				kd_urusan,
				kd_bidang,
				kd_unit,
				kd_sub,
				kd_prog,
				id_prog,
				kd_keg
			')
			->get_where
			(
				'ta_belanja_rinc_sub',
				array
				(
					'kd_urusan'						=> $list[0],
					'kd_bidang'						=> $list[1],
					'kd_unit'						=> $list[2],
					'kd_sub'						=> $list[3],
					'kd_prog'						=> $list[4],
					'id_prog'						=> $list[5],
					'kd_keg'						=> $list[6]
				),
				80
			)
			->result();
			
			if($query)
			{
				//$options							= ('unit' == service('request')->getPost('referer') ? '<option value="all">Semua Sub Unit</option>' : '<option value="">Silakan pilih Kode Rekening</option>');
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '">' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . ' - ' . $val->nm_rek_5 . '</option>';
				}
			}
		}
		
		return make_json
		(
			array
			(
				'results'							=> $options,
				'element'							=> $element,
				'html'								=> ($options ? $options : '<option value="">Data yang dipilih tidak mendapatkan hasil</options>')
			)
		);
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
