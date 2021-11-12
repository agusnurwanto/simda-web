<?php namespace Modules\Bendahara\Controllers\Spj;
/**
 * Bendahara > SPJ > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spj_rinc';

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
			if(service('request')->getPost('kegiatan') != 'all')
			{
				$query								= $this->model->select
				('
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
					no_spj_panjar,
					kd_pembayaran,
					nilai,
					no_spd,
					nm_penerima,
					alamat,
					uraian
				')
				->get_where
				(
					'ta_spj_bukti',
					array
					(
						'tahun'						=> get_userdata('year'),
						'kd_urusan'					=> service('request')->getGet('kd_urusan'),
						'kd_bidang'					=> service('request')->getGet('kd_bidang'),
						'kd_unit'					=> service('request')->getGet('kd_unit'),
						'kd_sub'					=> service('request')->getGet('kd_sub'),
						'no_bukti'					=> service('request')->getPost('kegiatan'),
					)
				)
				->row();

				$this->set_default
				(
					array
					(
						'kd_urusan'					=> $query->kd_urusan,
						'kd_bidang'					=> $query->kd_bidang,
						'kd_unit'					=> $query->kd_unit,
						'kd_sub'					=> $query->kd_sub,
						'kd_prog'					=> $query->kd_prog,
						'id_prog'					=> $query->id_prog,
						'kd_keg'					=> $query->kd_keg,
						'kd_rek_1'					=> $query->kd_rek_1,
						'kd_rek_2'					=> $query->kd_rek_2,
						'kd_rek_3'					=> $query->kd_rek_3,
						'kd_rek_4'					=> $query->kd_rek_4,
						'kd_rek_5'					=> $query->kd_rek_5,
						'no_bukti'					=> $query->no_bukti,
						'tgl_bukti'					=> $query->tgl_bukti,
						'no_spj_panjar'				=> $query->no_spj_panjar,
						'kd_pembayaran'				=> $query->kd_pembayaran,
						'nilai'						=> $query->nilai,
						'no_spd'					=> $query->no_spd,
						'nm_penerima'				=> $query->nm_penerima,
						'alamat_penerima'			=> $query->alamat,
						'uraian'					=> $query->uraian,
						'no_spj'					=> service('request')->getGet('no_spj'),
					)
				);
			}
		}

		if(in_array($this->_method, array('create', 'update', 'delete')))
		{
			if(in_array($this->_method, array('create', 'update', 'delete')))
			{
				$query_spj							= $this->model->select
				('
					no_spj
				')
					->get_where
					(
						'ta_pengesahan_spj',
						array
						(
							'tahun'					=> get_userdata('year'),
							'no_spj'				=> service('request')->getGet('no_spj')
						)
					)
					->row('no_spj');

				if($query_spj == service('request')->getGet('no_spj'))
				{
					return throw_exception(301, 'Nomor SPJ ' . $query_spj . ' tidak dapat di ubah karena sudah disahkan/ditolak');
				}
			}
		}

		/*
		$header										= $this->_header();
		if(!$header)
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
		*/

		$this->set_breadcrumb
		(
			array
			(
				'bendahara/spj/sub_unit'			=> 'Bendahara Pengeluaran',
				'..'								=> 'Spj'
			)
		);

		$this->set_title('Rinc SPJ')
		->set_icon('mdi mdi-skype')
		->set_primary('tahun, no_spj, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_spj, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_rek_1, kd_rek_2, kd_rek_3, no_bukti, tgl_bukti, no_spj_panjar, kd_pembayaran, no_spd, nm_penerima, alamat_penerima, uraian')
		->unset_field('tahun, no_spj, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_bukti, tgl_bukti, no_spj_panjar, kd_pembayaran, no_spd, nm_penerima, alamat_penerima, uraian, nilai')
		->unset_view('tahun, no_spj, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, no_spj_panjar')
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
				'kd_rek_4'							=> 'Rekening',
				'kd_rek_5'							=> 'Uraian Rekening',
				'no_id'								=> 'No. ID',
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
		->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1')
		->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
		->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		/*
		->set_validation
		(
			array
			(
				'nilai_usulan'						=> 'required|numeric',
				'no_id'								=> 'required|callback_validasi_kd_rek_1'
			)
		)
		*/
		->where
		(
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

	public function kode_rekening_kd_rek1($params = array())
	{
		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0) . '.' . (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		$query										= $this->model->query
		('
			SELECT
				ta_spj_bukti.kd_urusan,
				ta_spj_bukti.kd_bidang,
				ta_spj_bukti.kd_unit,
				ta_spj_bukti.kd_sub,
				ta_spj_bukti.kd_prog,
				ta_spj_bukti.id_prog,
				ta_spj_bukti.kd_keg,
				ta_spj_bukti.no_bukti,
				ta_spj_bukti.nilai,
				ta_spj_bukti.kd_rek_1,
				ta_spj_bukti.kd_rek_2,
				ta_spj_bukti.kd_rek_3,
				ta_spj_bukti.kd_rek_4,
				ta_spj_bukti.kd_rek_5,
				ref_rek_5.nm_rek_5
			FROM
				ta_spj_bukti
			JOIN ref_rek_5 ON
				ref_rek_5.kd_rek_1 = ta_spj_bukti.kd_rek_1 and
				ref_rek_5.kd_rek_2 = ta_spj_bukti.kd_rek_2 and
				ref_rek_5.kd_rek_3 = ta_spj_bukti.kd_rek_3 and
				ref_rek_5.kd_rek_4 = ta_spj_bukti.kd_rek_4 and
				ref_rek_5.kd_rek_5 = ta_spj_bukti.kd_rek_5
			WHERE
				ta_spj_bukti.tahun = ' . get_userdata('year') . '
				AND ta_spj_bukti.kd_urusan = ' . service('request')->getGet('kd_urusan') . '
				AND ta_spj_bukti.kd_bidang = ' . service('request')->getGet('kd_bidang') . '
				AND ta_spj_bukti.kd_unit = ' . service('request')->getGet('kd_unit') . '
				AND ta_spj_bukti.kd_sub = ' . service('request')->getGet('kd_sub') . '
				AND ta_spj_bukti.kd_sumber = 3
				AND	NOT EXISTS(SELECT ta_spj_rinc.no_bukti FROM ta_spj_rinc WHERE ta_spj_rinc.no_bukti = ta_spj_bukti.no_bukti)
		')
		->result();

		$options									= '<option value="all">Silahkan Pilih</option>';

		foreach($query as $key => $val)
		{
			$options																.= '<option value="' . $val->no_bukti . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->no_bukti . ' (' . sprintf('%02d', $val->kd_prog) . '.' . sprintf('%02d', $val->kd_keg) . ' . ' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . ' ' . $val->nm_rek_5 . ') ' . number_format($val->nilai,2) . '</option>';
		}

		return '<select name="kegiatan" class="form-control">' . $options . '</select>';
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

	/*
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
			'ta_spd_rinc.kd_urusan = ta_spp.kd_urusan and
		ta_spd_rinc.kd_bidang = ta_spp.kd_bidang and
		ta_spd_rinc.kd_unit = ta_spp.kd_unit and
		ta_spd_rinc.kd_sub = ta_spp.kd_sub'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_spp.kd_urusan and
		ref_sub_unit.kd_bidang = ta_spp.kd_bidang and
		ref_sub_unit.kd_unit = ta_spp.kd_unit and
		ref_sub_unit.kd_sub = ta_spp.kd_sub'
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
	*/
}
