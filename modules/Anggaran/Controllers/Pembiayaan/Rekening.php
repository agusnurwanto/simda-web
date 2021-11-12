<?php namespace Modules\Anggaran\Controllers\Pembiayaan;
/**
 * Anggaran > Pembiayaan > Rekening
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rekening extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_pembiayaan';

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
				'anggaran/pembiayaan/sub_unit'		=> 'Sub Unit'
			)
		);

		$this->set_title('Pembiayaan')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_sumber')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, kd_sumber')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_sumber')
		->set_alias
		(
			array
			(
				'kd_rek_1'							=> 'Rekening',
				'kd_rek_4'							=> 'Kode',
				'kd_rek_5'							=> 'Uraian',
				'kd_sumber'							=> 'Sumber Dana',
				'nm_sumber'							=> 'Sumber Dana',
			)
		)
		->set_validation
		(
			array
			(
				//'kd_rek_1'							=> 'required||callback_validasi_rekening',
				//'kd_sumber'							=> 'required|'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'kd_prog'							=> '0',
				'id_prog'							=> '0',
				'kd_keg'							=> '0'
			)
		)
		->set_relation
		(
			'kd_sumber',
			'ref_sumber_dana.kd_sumber',
			'{ref_sumber_dana.kd_sumber}. {ref_sumber_dana.nm_sumber}'
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
				'kd_prog'							=> 0,
				'id_prog'							=> 0,
				'kd_keg'							=> 0,
				'kd_rek_1'							=> 6
			)
		)
		->render($this->_table);
	}

	public function validasi_rekening($value = 0)
	{
		var_dump($value); die;
		list($r1, $r2, $r3, $r4, $r5)				= array_pad(explode('.', $value), 5, 0);

		$query										= $this->model->get_where
		(
			'ref_rek_5',
			array
			(
				'kd_rek_1'							=> $r1,
				'kd_rek_2'							=> $r2,
				'kd_rek_3'							=> $r3,
				'kd_rek_4'							=> $r4,
				'kd_rek_5'							=> $r5
			)
		)
			->row();

		if(!$query)
		{
			return 'Rekening yang Anda pilih tidak tersedia';
		}

		return true;
	}

	public function kode_rekening_kd_rek1($params = array())
	{
		ini_set('memory_limit', '-1');

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
					'ref_rek_5.kd_rek_1'				=> 4
				),
				NULL,
				NULL,
				50
			)
			->result();

		$option										= '<option value="all">Silahkan Pilih</option>';

		foreach($query as $key => $val)
		{
			$option									.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '"' . ($exists == $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . '  ' . $val->nm_rek_5 . '</option>';
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
					'ref_rek_5.kd_rek_1'				=> $params['kd_rek_1']['original'],
					'ref_rek_5.kd_rek_2'				=> $params['kd_rek_2']['original'],
					'ref_rek_5.kd_rek_3'				=> $params['kd_rek_3']['original'],
					'ref_rek_5.kd_rek_4'				=> $params['kd_rek_4']['original'],
					'ref_rek_5.kd_rek_5'				=> $params['kd_rek_5']['original']
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
				),
				NULL,
				NULL,
				50
			)
			->result();

		$uri										= array
		(
			'kd_urusan'								=> service('request')->getGet('kd_urusan'),
			'kd_bidang'								=> service('request')->getGet('kd_bidang'),
			'kd_unit'								=> service('request')->getGet('kd_unit'),
			'kd_sub'								=> service('request')->getGet('kd_sub'),
			'kd_rek_1'								=> $params['kd_rek_1']['original'],
			'kd_rek_2'								=> $params['kd_rek_2']['original'],
			'kd_rek_3'								=> $params['kd_rek_3']['original'],
			'kd_rek_4'								=> $params['kd_rek_4']['original'],
			'kd_rek_5'								=> $params['kd_rek_5']['original']
		);

		$rekening									= null;

		foreach($query as $key => $val)
		{
			$rekening								= $val->nm_rek_5;
		}

		$content									= '
			<a href="' . base_url('anggaran/pendapatan/rincian/', $uri) . '" class="--xhr">
				<b data-toggle="tooltip" title="' . phrase('click_to_open') . '">
					' . $rekening . '
				</b>
			</a>
		';

		return $content;
	}

	public function after_update()
	{
		return throw_exception(301, phrase('data_was_successfully_updated'), current_page('../'));
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
