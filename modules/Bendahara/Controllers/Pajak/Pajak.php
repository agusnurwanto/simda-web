<?php namespace Modules\Bendahara\Controllers\Pajak;
/**
 * Bendahara > Pajak
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pajak extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_pajak';

	public function __construct()
	{
		parent::__construct();

		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}

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
			$this->set_field('kd_prog', 'custom_format', 'callback_kode_kegiatan');
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
				'bendahara/pajak/sub_unit'			=> 'Bendahara Pengeluaran Pajak',
			)
		);
		$this->set_title('Pajak')
		->set_icon('mdi mdi-shape-plus')
		->set_primary('tahun, no_bukti, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, d_k, ntpn')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, d_k')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, d_k')
		->unset_truncate('uraian')
		->column_order('kd_prog, no_bukti, tgl_bukti, no_bku, ntpn, nama_penyetor, keterangan')
		->field_position
		(
			array
			(
				'nama_penyetor'						=> 2,
				'no_bku'							=> 2,
				'keterangan'						=> 2,
				'ntpn'								=> 2
			)
		)
		->set_field
		(
			array
			(
				'tgl_bukti'							=> 'datepicker'
			)
		)
		->set_alias
		(
			array
			(
				'kd_prog'							=> 'Program'
			)
		)
		->set_validation
		(
			array
			(
				'no_bukti'							=> 'required|',
				'tgl_bukti'							=> 'required|',
				'nama_penyetor'						=> 'required|',
				'no_bku'							=> 'required|',
				'keterangan'						=> 'required|',
				'ntpn'								=> 'required|'
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
				'kd_sub'							=> service('request')->getGet('kd_sub')
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
				<select name="belanja" class="form-control form-control-sm report-dropdown belanja" disabled>
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
