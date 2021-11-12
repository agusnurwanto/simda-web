<?php namespace Modules\Bendahara\Controllers\Bukti_pengeluaran;
use Config\Validation;

/**
 * Bendahara > Bukti Pengeluaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Bukti_pengeluaran_panjar extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spj_bukti';

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
			if(in_array($this->_method, array('update')))
			{
				$query_spj							= $this->model->select
				('
					no_bukti
				')
					->get_where
					(
						'ta_spj_rinc',
						array
						(
							'tahun'					=> get_userdata('year'),
							'no_bukti'				=> service('request')->getGet('no_bukti')
						)
					)
					->row('no_bukti');

				if($query_spj == service('request')->getGet('no_bukti'))
				{
					return throw_exception(301, 'Nomor Bukti ' . $query_spj . ' Sudah di-SPJ-kan');
				}
			}

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
				'bendahara/bukti_pengeluaran/sub_unit' => 'Bendahara Pengeluaran UP/GU'
			)
		);
		$this->set_title('Bukti Pengeluaran')
		->set_icon('mdi mdi-rhombus-split')
		->set_primary('tahun, no_bukti, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, id_prog, kd_pembayaran, no_spd, nm_penerima, alamat, nm_bendahara, nip_bendahara, jbt_bendahara, nm_pa, nip_pa, jbt_pa, no_spm, jn_spm, no_spj_panjar, no_bku, bank_penerima, rek_penerima, npwp, tgl_buat, tgl_edit, tgl_cetak, cair, tgl_cair, kd_sumber, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_5')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, no_spd, nm_bendahara, nip_bendahara, jbt_bendahara, nm_pa, nip_pa, jbt_pa, no_spm, jn_spm, no_spj_panjar, no_bku, tgl_buat, tgl_edit, tgl_cetak, cair, tgl_cair, kd_sumber, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, no_spd, nm_bendahara, nip_bendahara, jbt_bendahara, nm_pa, nip_pa, jbt_pa, no_spm, jn_spm, no_spj_panjar, no_bku, tgl_buat, tgl_edit, tgl_cetak, cair, tgl_cair, kd_sumber, kd_rek_1, kd_rek_2, kd_rek_3')
		->unset_truncate('uraian')
		->column_order('kd_unit, kd_rek_4')
		->field_order('kd_rek_1, no_bukti, tgl_bukti, uraian, nilai, kd_pembayaran, nm_penerima, alamat, npwp')
		->set_field
		(
			'uraian',
			'hyperlink',
			'bendahara/bukti_pengeluaran/potongan',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'kd_prog'							=> 'kd_prog',
				'id_prog'							=> 'id_prog',
				'kd_keg'							=> 'kd_keg',
				'no_bukti'							=> 'no_bukti'
			)
		)
		->field_position
		(
			array
			(
				'kd_pembayaran'						=> 2,
				'nm_penerima'						=> 2,
				'alamat'							=> 2,
				'bank_penerima'						=> 2,
				'rek_penerima'						=> 2,
				'npwp'								=> 2
			)
		)
		->field_prepend
		(
			array
			(
				'nilai'								=> 'Rp'
			)
		)
		->set_field
		(
			array
			(
				'tgl_bukti'							=> 'datepicker',
				'nilai'								=> 'price_format'
			)
		)
		->set_field
		(
			'kd_pembayaran',
			'radio',
			array
			(
				1									=> '<label class="badge badge-success">Tunai </label>',
				2									=> '<label class="badge badge-warning">Bank</label>'
			)
		)
		->set_alias
		(
			array
			(
				'kd_rek_1'							=> 'Rekening',
				'no_bukti'							=> 'Nomor Bukti',
				'tgl_bukti'							=> 'Tanggal Bukti',
				'kd_rek_4'							=> 'Kode Rekening',
				'kd_pembayaran'						=> 'Cara Pembayaran',
				'nm_penerima'						=> 'Nama Penerima',
				'alamat'							=> 'Alamat Penerima',
				'bank_penerima'						=> 'Bank Penerima',
				'rek_penerima'						=> 'Rekening Penerima',
				'npwp'								=> 'Npwp'
			)
		)
		/*
		->set_validation
		(
			array
			(
				'no_tagihan'						=> 'required||callback_validasi_no_tagihan',
				'no_spp'							=> 'required|',
				'uraian'							=> 'required|',
			)
		)
		*/
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'jn_spm'							=> '2',
				'cair'								=> '0',
				'kd_sumber'							=> '1',
				'tgl_buat'							=> date("Y-m-d h:i:sa")
			)
		)
		/*
		->set_relation
		(
			'nama_pptk',
			'ref_entry.nm_penandatangan',
			'{ref_entry.nm_penandatangan}',
			array
			(
				'ref_entry.tahun'					=> get_userdata('year'),
				'ref_entry.kd_penandatangan'		=> get_userdata('year')
			)
		)
		*/
		->merge_content('{kd_unit}.{kd_sub} . {kd_prog}.{kd_keg}', 'Kegiatan')
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

	public function validasi_no_tagihan($value = 0)
	{
		if(!$value)
		{
			return 'Bidang Nomor Kontrak dibutuhkan';
		}

		return true;
	}

	public function kode_rekening_kd_rek1($params = array())
	{
		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0) . '.' . (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		$query										= $this->model->query
		('
			SELECT
				*
			FROM
				ta_spj_panjar_rinc
			JOIN ta_spj_panjar ON
				ta_spj_panjar.no_spj = ta_spj_panjar_rinc.no_spj
			JOIN ref_rek_5 ON
				ref_rek_5.kd_rek_1 = ta_spj_panjar_rinc.kd_rek_1 and
				ref_rek_5.kd_rek_2 = ta_spj_panjar_rinc.kd_rek_2 and
				ref_rek_5.kd_rek_3 = ta_spj_panjar_rinc.kd_rek_3 and
				ref_rek_5.kd_rek_4 = ta_spj_panjar_rinc.kd_rek_4 and
				ref_rek_5.kd_rek_5 = ta_spj_panjar_rinc.kd_rek_5
			WHERE
				ta_spj_panjar.tahun = ' . get_userdata('year') . '
				AND ta_spj_panjar.kd_urusan = ' . service('request')->getGet('kd_urusan') . '
				AND ta_spj_panjar.kd_bidang = ' . service('request')->getGet('kd_bidang') . '
				AND ta_spj_panjar.kd_unit = ' . service('request')->getGet('kd_unit') . '
				AND ta_spj_panjar.kd_sub = ' . service('request')->getGet('kd_sub') . '
				AND	NOT EXISTS (SELECT ta_spj_bukti.no_bukti FROM ta_spj_bukti WHERE ta_spj_bukti.no_bukti = ta_spj_panjar_rinc.no_bukti)
		')
			->result();

		$options									= '<option value="all">Silahkan Pilih</option>';

		foreach($query as $key => $val)
		{
			$options																.= '<option value="' . $val->no_bukti . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->no_spj . ' (' . sprintf('%02d', $val->kd_prog) . '.' . sprintf('%02d', $val->kd_keg) . ' . ' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . ' ' . $val->nm_rek_5 . ') Rp. ' . number_format($val->nilai,2) . '</option>';
		}

		return '<select name="kegiatan" class="form-control">' . $options . '</select>';
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
