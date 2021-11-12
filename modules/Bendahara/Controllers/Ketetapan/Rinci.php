<?php namespace Modules\Bendahara\Controllers\Ketetapan;
/**
 * Bendahara > Ketetapan > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
    private $_table																	= 'ta_skp_rinc';
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
			if(service('request')->getPost('program') == 'all'){
				$this->set_default
				(
					array
					(
						'kd_urusan'						    						=> service('request')->getGet('kd_urusan'),
						'kd_bidang'						    						=> service('request')->getGet('kd_bidang'),
						'kd_unit'						    						=> service('request')->getGet('kd_unit'),
						'kd_sub'						    						=> service('request')->getGet('kd_sub'),
						'kd_prog'						    						=> '0',
						'id_prog'						    						=> '0',
						'kd_keg'						   							=> '0'
					)
				);
			}else{
				if (service('request')->getPost('program') != 'all'){
					list($r1, $r2, $r3, $r4, $r5, $r6, $r7)							= array_pad(explode('.', service('request')->getPost('program')), 5, 0);

					$this->set_default
					(
						array
						(
							'kd_urusan'						    					=> $r1,
							'kd_bidang'						    					=> $r2,
							'kd_unit'						    					=> $r3,
							'kd_sub'						    					=> $r4,
							'kd_prog'						    					=> $r5,
							'id_prog'						    					=> $r6,
							'kd_keg'						   						=> $r7,
						)
					);
				}
			}

			if(service('request')->getPost('rekening') != 'all'){
				list($r1, $r2, $r3, $r4, $r5)										= array_pad(explode('.', service('request')->getPost('rekening')), 5, 0);

				$this->set_default
				(
					array
					(
						'kd_rek_1'						    						=> $r1,
						'kd_rek_2'						    						=> $r2,
						'kd_rek_3'						    						=> $r3,
						'kd_rek_4'						    						=> $r4,
						'kd_rek_5'						    						=> $r5,
					)
				);
			}
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
						no ketetapan
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . $header['query']->no_skp . '
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						tanggal ketetapan
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . date("d F Y", strtotime($header['query']->tgl_skp)) . '
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
				'bendahara/ketetapan/sub_unit'		=> 'Bendahara Penerimaan Ketetapan',
				'../ketetapan'						=> 'Ketetapan'
			)
		);

		$this->set_title('Rinc Ketetapan')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, no_skp, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_skp, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3')
		->unset_field('tahun, no_skp, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_prog, kd_keg, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, no_skp, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_id')
		->field_prepend
		(
			array
			(
				'nilai'    					    	=> 'Rp'
			)
		)
		->set_alias
		(
			array
			(
				'kd_rek_1'							=> 'Rekening',
				'kd_rek_4'							=> 'Kode Rekening',
				'kd_rek_5'							=> 'Uraian',
				'no_id'							    => 'No. Urut'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'nilai'							    => 'price_format'
			)
		)
		->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1')
		->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
		->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_skp'							=> service('request')->getGet('no_skp')
			)
		)
		->set_validation
		(
			array
			(
				//'kd_rek_1'						=> 'required|callback_validasi_kd_rek_1',
				'nilai'							    => 'required|numeric',
				'keterangan'						=> 'required|'
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
				'no_skp'							=> service('request')->getGet('no_skp')
			)
		)
		->render($this->_table);
    }

	public function validasi_kd_rek_1($value = 0)
	{
		if(service('request')->getPost('program') == 'all')
		{
			return 'Bidang Rekening dibutuhkan';
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

	public function after_update()
	{
		return throw_exception(301, phrase('data_was_successfully_updated'), current_page('../'));
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_skp.no_skp,
			ta_skp.tgl_skp,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
			->join
			(
				'ref_sub_unit',
				'ref_sub_unit.kd_urusan = ta_skp.kd_urusan and
			ref_sub_unit.kd_bidang = ta_skp.kd_bidang and
			ref_sub_unit.kd_unit = ta_skp.kd_unit and
			ref_sub_unit.kd_sub = ta_skp.kd_sub'
			)
			->get_where
			(
				'ta_skp',
				array
				(
					'ta_skp.tahun'					=> get_userdata('year'),
					'ta_skp.kd_urusan'				=> service('request')->getGet('kd_urusan'),
					'ta_skp.kd_bidang'				=> service('request')->getGet('kd_bidang'),
					'ta_skp.kd_unit'				=> service('request')->getGet('kd_unit'),
					'ta_skp.kd_sub'					=> service('request')->getGet('kd_sub'),
					'ta_skp.no_skp'					=> service('request')->getGet('no_skp')
				)
			)
			->row();

		$query_total								= $this->model->select
		('
			SUM(nilai) AS nilai
		')
			->get_where
			(
				'ta_skp_rinc',
				array
				(
					'ta_skp_rinc.kd_urusan'			=> service('request')->getGet('kd_urusan'),
					'ta_skp_rinc.kd_bidang'			=> service('request')->getGet('kd_bidang'),
					'ta_skp_rinc.kd_unit'			=> service('request')->getGet('kd_unit'),
					'ta_skp_rinc.kd_sub'			=> service('request')->getGet('kd_sub'),
					'ta_skp_rinc.no_skp'			=> service('request')->getGet('no_skp')
				)
			)
			->row();

		$output = array
		(
			'query'       => $query,
			'query_total' => $query_total
		);

		return $output;
	}

}
