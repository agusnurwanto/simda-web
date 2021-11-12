<?php namespace Modules\Bendahara\Controllers\Bukti_panjar;
/**
 * Bendahara > Bukti Panjar > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
    private $_table									= 'ta_spj_panjar_rinc';

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
		if(service('request')->getPost('_token'))
		{
			list($r1, $r2, $r3, $r4, $r5, $r6)      = array_pad(explode('.', service('request')->getPost('rekening')), 5, 0);

			$this->set_default
			(
				array
				(
					'kd_rek_1'						=> $r1,
					'kd_rek_2'						=> $r2,
					'kd_rek_3'						=> $r3,
					'kd_rek_4'						=> $r4,
					'kd_rek_5'						=> $r5,
					'no_spd'						=> $r6
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
						no spj
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . $header['query']->no_spj . '
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						tanggal spj
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						' . date("d F Y", strtotime($header['query']->tgl_spj)) . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						sisa panjar
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
                            Rp. ' . number_format((0), 2) . '
                        </b>
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah spj panjar
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
				'bendahara/bukti_panjar/sub_unit'	=> 'Bendahara Pengeluaran Bukti Panjar',
				'../bukti_panjar'					=> 'Bukti Panjar'
			)
		);
		$this->set_title('Rinc Bukti Panjar')
		->set_icon('mdi mdi-radio-tower')
		->set_primary('tahun, no_spj, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_bukti')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_spj, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_5, kd_pembayaran, no_spd, kd_sumber')
		->unset_field('tahun, no_spj, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, kd_pembayaran, no_spd, kd_sumber')
		->unset_view('tahun, no_spj, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_5, kd_pembayaran, no_spd, kd_sumber')
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
				'kd_rek_4'							=> 'Kode Rekening'
			)
		)
		->set_field
		(
			array
			(
				'nilai'								=> 'price_format',
				'tgl_bukti'							=> 'datepicker'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_spj'							=> service('request')->getGet('no_spj'),
				'kd_sumber'							=> '1',
				'kd_pembayaran'						=> '2'
			)
		)
		->set_validation
		(
			array
			(
				'kd_rek_1'						    => 'required|callback_validasi_kd_rek_1',
				'nilai'								=> 'required|numeric',
				'no_bukti'							=> 'required',
				'tgl_bukti'							=> 'required'
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
		ini_set('memory_limit', '-1');

		$exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		$query										= $this->model->select
		('
			ta_spd_rinc.kd_urusan,
			ta_spd_rinc.kd_bidang,
			ta_spd_rinc.kd_urusan,
			ta_spd_rinc.kd_unit,
			ta_spd_rinc.kd_sub,
			ta_spd_rinc.kd_prog,
			ta_spd_rinc.id_prog,
			ta_spd_rinc.kd_keg,
			ref_rek_5.kd_rek_1,
			ref_rek_5.kd_rek_2,
			ref_rek_5.kd_rek_3,
			ref_rek_5.kd_rek_4,
			ref_rek_5.kd_rek_5,
			ref_rek_5.nm_rek_5,
			ta_spd.no_spd
		')
			->join
			(
				'ta_spd',
				'ta_spd.kd_urusan = ta_spd_rinc.kd_urusan AND
				ta_spd.kd_bidang = ta_spd_rinc.kd_bidang AND
				ta_spd.kd_unit = ta_spd_rinc.kd_unit AND
				ta_spd.kd_sub = ta_spd_rinc.kd_sub AND
				ta_spd.no_spd = ta_spd_rinc.no_spd'
			)
			->join
			(
				'ref_rek_5',
				'ref_rek_5.kd_rek_1 = ta_spd_rinc.kd_rek_1 AND
				ref_rek_5.kd_rek_2 = ta_spd_rinc.kd_rek_2 AND
				ref_rek_5.kd_rek_3 = ta_spd_rinc.kd_rek_3 AND
				ref_rek_5.kd_rek_4 = ta_spd_rinc.kd_rek_4 AND
				ref_rek_5.kd_rek_5 = ta_spd_rinc.kd_rek_5'
			)
			->get_where
			(
				'ta_spd_rinc',
				array
				(
					'ta_spd_rinc.tahun'				=> get_userdata('year'),
					'ta_spd_rinc.kd_urusan'			=> service('request')->getGet('kd_urusan'),
					'ta_spd_rinc.kd_bidang'			=> service('request')->getGet('kd_bidang'),
					'ta_spd_rinc.kd_unit'			=> service('request')->getGet('kd_unit'),
					'ta_spd_rinc.kd_sub'			=> service('request')->getGet('kd_sub'),
					'ta_spd_rinc.kd_prog'			=> service('request')->getGet('kd_prog'),
					'ta_spd_rinc.id_prog'			=> service('request')->getGet('id_prog'),
					'ta_spd_rinc.kd_keg'			=> service('request')->getGet('kd_keg')
				),
				NULL,
				NULL,
				50
			)
			->result();

		$option										= '<option value="all">Silahkan Pilih Rekeing</option>';

		foreach($query as $key => $val)
		{
			$option									.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '.' . $val->no_spd . '"' . ($exists == $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . ' - ' . $val->nm_rek_5 . '</option>';
		}

		return '<select name="rekening" class="form-control kd_rek_1">' . $option . '</select>';
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

		$rekening									= null;

		foreach($query as $key => $val)
		{
			$rekening								= $exists;
		}

		return $rekening;
	}

	public function after_update()
	{
		return throw_exception(301, phrase('data_was_successfully_updated'), current_page('../'));
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_spj_panjar.no_spj,
			ta_spj_panjar.tgl_spj,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_spj_panjar.kd_urusan and
		ref_sub_unit.kd_bidang = ta_spj_panjar.kd_bidang and
		ref_sub_unit.kd_unit = ta_spj_panjar.kd_unit and
		ref_sub_unit.kd_sub = ta_spj_panjar.kd_sub'
		)
		->get_where
		(
			'ta_spj_panjar',
			array
			(
				'ta_spj_panjar.tahun'				=> get_userdata('year'),
				'ta_spj_panjar.kd_urusan'			=> service('request')->getGet('kd_urusan'),
				'ta_spj_panjar.kd_bidang'			=> service('request')->getGet('kd_bidang'),
				'ta_spj_panjar.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_spj_panjar.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_spj_panjar.no_spj'				=> service('request')->getGet('no_spj')
			)
		)
		->row();

		$query_total								= $this->model->select
		('
			SUM(nilai) AS nilai
		')
		->get_where
		(
			'ta_spj_panjar_rinc',
			array
			(
				'ta_spj_panjar_rinc.no_spj'			=> service('request')->getGet('no_spj')
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
