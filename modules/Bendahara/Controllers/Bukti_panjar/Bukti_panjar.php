<?php namespace Modules\Bendahara\Controllers\Bukti_panjar;
/**
 * Bendahara > Bukti Panjar
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Bukti_panjar extends \Aksara\Laboratory\Core
{
    private $_table									= 'ta_spj_panjar';

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
        if('dropdown' == service('request')->getPost('trigger'))
        {
            return $this->_dropdown();
        }

		if(service('request')->getPost('_token'))
		{
			list($r1, $r2, $r3, $r4, $r5, $r6)	    = array_pad(explode('.', service('request')->getPost('program')), 5, 0);

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
					'kd_keg'						=> service('request')->getPost('kegiatan')
				)
			);
		}

		if(in_array($this->_method, array('create', 'update')))
		{
			$this->set_field('kd_prog', 'custom_format', 'callback_kode_program');
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
				'bendahara/bukti_panjar/sub_unit'	=> 'Bendahara Pengeluaran Bukti Panjar',
			)
		);
		$this->set_title('Bukti Panjar')
		->set_icon('mdi mdi-radio-tower')
		->set_primary('tahun, no_spj, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, no_sp2d')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, no_sp2d')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, no_sp2d')
		->unset_truncate('keterangan')
		->field_order('kd_prog, kd_keg')
		->view_order('kd_prog, kd_keg')
		->set_field
		(
			'keterangan',
			'hyperlink',
			'bendahara/bukti_panjar/rinci',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'kd_prog'							=> 'kd_prog',
				'id_prog'							=> 'id_prog',
				'kd_keg'							=> 'kd_keg',
				'no_spj'							=> 'no_spj'
			)
		)
		->field_position
		(
			array
			(
				'tgl_spj'							=> 2,
				'no_bku'							=> 2,
				'keterangan'						=> 2,
			)
		)
		->set_field
		(
			array
			(
				'tgl_spj'							=> 'datepicker'
			)
		)
		->set_alias
		(
			array
			(
				'kd_prog'							=> 'Program',
				'kd_keg'							=> 'Kegiatan',
				'no_spj'							=> 'Nomor Spj',
				'tgl_spj'							=> 'Tanggal Spj'
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
		->set_validation
		(
			array
			(
				//'no_bukti'							=> 'required|',
				//'tgl_bukti'							=> 'required|',
				//'no_bku'							=> 'required|',
				//'nilai'								=> 'required|',
				//'uraian'							=> 'required|',
				//'kd_mutasi'							=> 'required|'
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

	public function kode_program($params = array())
	{
		ini_set('memory_limit', '-1');

		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0);

		$query										= $this->model->select
		('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			kd_prog,
			id_prog,
			ket_program
		')
			->get_where
			(
				'ta_program',
				array
				(
					'tahun'				            => get_userdata('year'),
					'kd_urusan'			            => service('request')->getGet('kd_urusan'),
					'kd_bidang'			            => service('request')->getGet('kd_bidang'),
					'kd_unit'			            => service('request')->getGet('kd_unit'),
					'kd_sub'				        => service('request')->getGet('kd_sub'),
					'kd_prog >'			            => 0
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
			$options								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . ' - ' . $val->ket_program . '</option>';
		}

		$output										.= '
			<div class="form-group">
				<select name="program" class="form-control form-control-sm report-dropdown" to-change=".kegiatan">
					<option value="all">Silakan pilih Program</option>
					' . $options . '
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Kegiatan
				</label>
				<select name="kegiatan" class="form-control form-control-sm kegiatan get-dropdown-content" disabled>
					<option value="all">Silakan pilih Program terlebih dahulu</option>
				</select>
			</div>
		';

		return $output;
	}

	private function _dropdown()
	{
		$primary									= service('request')->getPost('primary');
		$list										= $primary != 'all' ? explode(".", $primary) : null;
		$element									= service('request')->getPost('element');
		$options									= null;

		if('.kegiatan' == $element)
		{
			$query									= $this->model->select
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
				->get_where
				(
					'ta_kegiatan',
					array
					(
						'kd_urusan'					=> $list[0],
						'kd_bidang'					=> $list[1],
						'kd_unit'					=> $list[2],
						'kd_sub'					=> $list[3],
						'kd_prog'					=> $list[4],
						'id_prog'					=> $list[5]
					),
					NULL,
					NULL,
					50,
				)
				->result();

			if($query)
			{
				//$options							= ('unit' == service('request')->getPost('referer') ? '<option value="all">Semua Sub Unit</option>' : '<option value="">Silakan pilih Kode Rekening</option>');
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val->kd_keg . '">' . $val->kd_keg . ' . ' . $val->ket_kegiatan . '</option>';
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
