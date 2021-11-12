<?php namespace Modules\Bendahara\Controllers\Bukti_penerimaan;
use Config\Validation;

/**
 * Bendahara > Bukti Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_bukti_penerimaan_rinc';

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
		if(service('request')->getPost('token'))
		{
			list($r1, $r2, $r3, $r4, $r5)			= array_pad(explode('.', service('request')->getPost('rekening')), 5, 0);

			$this->set_default
			(
				array
				(
					'kd_rek_1'						=> $r1,
					'kd_rek_2'						=> $r2,
					'kd_rek_3'						=> $r3,
					'kd_rek_4'						=> $r4,
					'kd_rek_5'						=> $r5
				)
			);
		}

		if(in_array($this->_method, array('create', 'update')))
		{
			$this->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1');
		}
		else
		{
			$this->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4');
			$this->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5');
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
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						no bukti
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . $header['query']->no_bukti . '
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						tanggal bukti
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . date("d F Y", strtotime($header['query']->tgl_bukti)) . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah rincian
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
				'bendahara/bukti_penerimaan/sub_unit' => 'Bendahara Penerimaan Bukti Penerimaan',
				'../bukti_penerimaan' 				=> 'Bukti Penerimaan'
			)
		);
		$this->set_title('Rinc Bukti Penerimaan')
		->set_icon('mdi mdi-rhombus-split')
		->set_primary('tahun, no_bukti, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_bukti, kd_rek_1, kd_rek_2, kd_rek_3')
		->unset_field('tahun, no_bukti, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, no_bukti, kd_rek_2, kd_rek_3, kd_rek_4')
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
				'kd_rek_1'							=> 'Rekening',
				'kd_rek_4'							=> 'Kode Rekening',
				'kd_rek_5'							=> 'Uraian Rekening',
				'no_bukti'							=> 'Nomor Bukti'
			)
		)
		->set_field
		(
			array
			(
				'nilai'								=> 'price_format'
			)
		)
		->set_validation
		(
			array
			(
				//'kd_rek_1'							=> 'required|callback_validasi_kd_rek_1',
				'nilai'								=> 'required|numeric',
				'tgl_bukti'							=> 'required|'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_bukti'							=> service('request')->getGet('no_bukti')
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_bukti'							=> service('request')->getGet('no_bukti')
			)
		)
		->render($this->_table);
	}

	public function validasi_kd_rek_1($value = 0)
	{
		if(service('request')->getPost('program') == 'all')
		{
			return 'Bidang rekening dibutuhkan';
		}

		return true;
	}

	public function kode_rekening_kd_rek1($params = array())
	{
		$exists										        						= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

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
					'ref_rek_5.kd_rek_1'			=> 4
				),
				NULL,
				NULL,
				50
			)
			->result();

		$option										= null;
		$option				                        .= '<option value="all">Silahkan Pilih</option>';
		foreach($query as $key => $val)
		{
			$option									.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '"' . ($exists == $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . ' - ' . $val->nm_rek_5 . '</option>';
		}

		return '<select name="rekening" class="form-control">' . $option . '</select>';
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
					'ref_rek_5.kd_rek_1'			=> $params['kd_rek_1']['original'],
					'ref_rek_5.kd_rek_2'			=> $params['kd_rek_2']['original'],
					'ref_rek_5.kd_rek_3'			=> $params['kd_rek_3']['original'],
					'ref_rek_5.kd_rek_4'			=> $params['kd_rek_4']['original'],
					'ref_rek_5.kd_rek_5'			=> $params['kd_rek_5']['original']
				),
				NULL,
				NULL,
				50
			)
			->result();

		$rekening                                   = null;
		foreach($query as $key => $val)
		{
			$rekening = $exists;
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
					'ref_rek_5.kd_rek_1'			=> $params['kd_rek_1']['original'],
					'ref_rek_5.kd_rek_2'			=> $params['kd_rek_2']['original'],
					'ref_rek_5.kd_rek_3'			=> $params['kd_rek_3']['original'],
					'ref_rek_5.kd_rek_4'			=> $params['kd_rek_4']['original'],
					'ref_rek_5.kd_rek_5'			=> $params['kd_rek_5']['original']
				),
				NULL,
				NULL,
				50
			)
			->result();

		$rekening                                   = null;
		foreach($query as $key => $val)
		{
			$rekening = $val->nm_rek_5;
		}

		return $rekening;
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_bukti_penerimaan.no_bukti,
			ta_bukti_penerimaan.tgl_bukti,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
			->join
			(
				'ref_sub_unit',
				'ref_sub_unit.kd_urusan = ta_bukti_penerimaan.kd_urusan and
				ref_sub_unit.kd_bidang = ta_bukti_penerimaan.kd_bidang and
				ref_sub_unit.kd_unit = ta_bukti_penerimaan.kd_unit and
				ref_sub_unit.kd_sub = ta_bukti_penerimaan.kd_sub'
			)
			->get_where
			(
				'ta_bukti_penerimaan',
				array
				(
					'ta_bukti_penerimaan.tahun'		=> get_userdata('year'),
					'ta_bukti_penerimaan.kd_urusan'	=> service('request')->getGet('kd_urusan'),
					'ta_bukti_penerimaan.kd_bidang'	=> service('request')->getGet('kd_bidang'),
					'ta_bukti_penerimaan.kd_unit'	=> service('request')->getGet('kd_unit'),
					'ta_bukti_penerimaan.kd_sub'	=> service('request')->getGet('kd_sub'),
					'ta_bukti_penerimaan.no_bukti'	=> service('request')->getGet('no_bukti')
				)
			)
			->row();

		$query_total								= $this->model->select
		('
			SUM(nilai) AS nilai
		')
			->get_where
			(
				'ta_bukti_penerimaan_rinc',
				array
				(
					'ta_bukti_penerimaan_rinc.no_bukti' => service('request')->getGet('no_bukti')
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
