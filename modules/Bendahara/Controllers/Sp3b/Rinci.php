<?php namespace Modules\Bendahara\Controllers\Sp3b;
/**
 * Bendahara > SP3B > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_sp3b_rinc';

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
		if(service('request')->getPost('token'))
		{
			list($r1, $r2, $r3, $r4, $r5, $r6, $r7)	= array_pad(explode('.', service('request')->getPost('program')), 5, 0);

			$this->set_default
			(
				array
				(
					'kd_urusan'						=> $r1,
					'kd_bidang'						=> $r2,
					'kd_unit'						=> $r3,
					'kd_sub'						=> $r4,
					'kd_prog'						=> $r5,
					'id_prog'						=> $r6,
					'kd_keg'						=> $r7, // last insert belum nemu
				)
			);
		}

		if(in_array($this->_method, array('create', 'update')))
		{
			$this->set_field('kd_prog', 'custom_format', 'callback_kode_kegiatan')
			->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1');
		}
		else
		{
			$this->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
			->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5');
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
						' . $header['query']->kd_urusan . '.' . $header['query']->kd_bidang . '.' . $header['query']->kd_unit . '.' . $header['query']->kd_sub . '
					</label>
					<label class="col-2 col-sm-5 text-uppercase mb-0">
						' . $header['query']->nm_sub_unit . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah pendapatan
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
							Rp. ' . number_format((0), 2) . '
						</b>
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						no sp3b
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . $header['query']->no_sp3b . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah belanja
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
				'bendahara/sub_unit'				=> 'Bendahara',
				'../sp3b'							=> 'Sp3b'
			)
		);
		$this->set_title('Rinc SP3B')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, no_sp3b, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_sp3b, no_id')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_sp3b')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_id')
		->field_order('no_id')
		->field_prepend
		(
			array
			(
				'nilai'								=> 'Rp'
			)
		)
		->set_alias
		(
			array
			(
				'kd_prog'							=> 'Program',
				'kd_rek_4'							=> 'Kode Rekening',
				'kd_rek_5'							=> 'Uraian',
				'no_id'								=> 'No. Urut'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'nilai'								=> 'price_format'
			)
		)
		->merge_content('{kd_prog}.{kd_keg}', 'Kegiatan')
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_sp3b'							=> service('request')->getGet('no_sp3b')
			)
		)
		->set_validation
		(
			array
			(
				//'kd_prog'							=> 'required||callback_validasi_kd_rek_1',
				'nilai'								=> 'required|numeric|',
				'kd_rek_1'							=> 'required|',
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
				'no_sp3b'							=> service('request')->getGet('no_sp3b')
			)
		)
		->render($this->_table);
	}

	public function validasi_kd_rek_1($value = 0)
	{
		if(service('request')->getPost('kegiatan') == 'all')
		{
			return 'Bidang Rekening dibutuhkan';
		}

		list($r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12)	= array_pad(explode('.', service('request')->getPost('kegiatan')), 5, 0);

		$query										= $this->model->select
		('
			no_spp,
			ta_spp_rinc.kd_rek_1,
			ta_spp_rinc.kd_rek_2,
			ta_spp_rinc.kd_rek_3,
			ta_spp_rinc.kd_rek_4,
			ta_spp_rinc.kd_rek_5
		')
		->get_where
		(
			'ta_spp_rinc',
			array
			(
				'kd_urusan'							=> $r1,
				'kd_bidang'							=> $r2,
				'kd_unit'							=> $r3,
				'kd_sub'							=> $r4,
				'kd_prog'							=> $r5,
				'id_prog'							=> $r6,
				'kd_keg'							=> $r7,
				'kd_rek_1'							=> $r8,
				'kd_rek_2'							=> $r9,
				'kd_rek_3'							=> $r10,
				'kd_rek_4'							=> $r11,
				'kd_rek_5'							=> $r12,
				'no_spp'							=> service('request')->getGet('no_spp'),
			)
		)
		->row();

		if(isset($query))
		{
			return 'No Rekening '. $query->kd_rek_1 . '.' . $query->kd_rek_2 . '.' . $query->kd_rek_3 . '.' . $query->kd_rek_4 . '.' . $query->kd_rek_5 . ' sudah terdaftar di No SPP '. $query->no_spp;
		}

		return true;
	}

	public function kode_kegiatan($params = array())
	{
		ini_set('memory_limit', '-1');

		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0);

		$query										= $this->model->select
		('
			ta_program.kd_urusan,
			ta_program.kd_bidang,
			ta_program.kd_unit,
			ta_program.kd_sub,
			ta_program.kd_prog,
			ta_program.id_prog,
			ta_kegiatan.kd_keg,
			ta_kegiatan.ket_kegiatan
		')
			->join
			(
				'ta_kegiatan',
				'ta_kegiatan.kd_urusan = ta_program.kd_urusan AND
			ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
			ta_kegiatan.kd_unit = ta_program.kd_unit AND
			ta_kegiatan.kd_sub = ta_program.kd_sub AND
			ta_kegiatan.kd_prog = ta_program.kd_prog AND
			ta_kegiatan.id_prog = ta_program.id_prog'
			)
			->get_where
			(
				'ta_program',
				array
				(
					'ta_program.tahun'					=> get_userdata('year'),
					'ta_program.kd_urusan'				=> service('request')->getGet('kd_urusan'),
					'ta_program.kd_bidang'				=> service('request')->getGet('kd_bidang'),
					'ta_program.kd_unit'				=> service('request')->getGet('kd_unit'),
					'ta_program.kd_sub'					=> service('request')->getGet('kd_sub'),
					'ta_program.kd_prog >'				=> 0
				),
				NULL,
				NULL,
				50
			)
			->result();

		$options									= null;
		$output										= null;
		foreach($query as $key => $val)
		{
			$options								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . ' - ' . $val->ket_kegiatan . '</option>';
		}

		$output										.= '
			<div class="form-group">
				<select name="kegiatan" class="form-control form-control-sm report-dropdown" to-change=".belanja">
					<option value="all">Silakan pilih Program</option>
					' . $options . '
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Kegiatan
				</label>
				<select name="belanja" class="form-control form-control-sm report-dropdown belanja" to-change=".anggaran" disabled>
					<option value="all">Silakan pilih Program terlebih dahulu</option>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Anggaran
				</label>
				<select name="anggaran" class="form-control form-control-sm report-dropdown anggaran" disabled>
					<option value="all">Silakan pilih Program terlebih dahulu</option>
				</select>
			</div>
		';

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
					//NULL,
					//NULL,
					50
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

		make_json
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
			$rekening								= $exists;
		}

		return $rekening;
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
			ta_sp3b_rinc.no_sp3b,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ta_sp3b_rinc',
			'ta_sp3b_rinc.kd_urusan = ta_sp3b.kd_urusan AND ta_sp3b_rinc.kd_bidang = ta_sp3b.kd_bidang AND ta_sp3b_rinc.kd_unit = ta_sp3b.kd_unit AND ta_sp3b_rinc.kd_sub = ta_sp3b.kd_sub'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_sp3b.kd_urusan AND ref_sub_unit.kd_bidang = ta_sp3b.kd_bidang AND ref_sub_unit.kd_unit = ta_sp3b.kd_unit AND ref_sub_unit.kd_sub = ta_sp3b.kd_sub'
		)
		->get_where
		(
			'ta_sp3b',
			array
			(
				'ta_sp3b.tahun'						=> get_userdata('year'),
				'ta_sp3b.kd_urusan'					=> service('request')->getGet('kd_urusan'),
				'ta_sp3b.kd_bidang'					=> service('request')->getGet('kd_bidang'),
				'ta_sp3b.kd_unit'					=> service('request')->getGet('kd_unit'),
				'ta_sp3b.kd_sub'					=> service('request')->getGet('kd_sub'),
				'ta_sp3b.no_sp3b'					=> service('request')->getGet('no_sp3b')
			)
		)
		->row();

		$query_total								= $this->model->select
		('
			SUM(nilai) AS nilai
		')
		->get_where
		(
			'ta_sp3b_rinc',
			array
			(
				'ta_sp3b_rinc.kd_urusan'			=> service('request')->getGet('kd_urusan'),
				'ta_sp3b_rinc.kd_bidang'			=> service('request')->getGet('kd_bidang'),
				'ta_sp3b_rinc.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_sp3b_rinc.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_sp3b_rinc.no_sp3b'				=> service('request')->getGet('no_sp3b')
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
