<?php namespace Modules\Bendahara\Controllers\Bukti_penerimaan;
use Config\Validation;

/**
 * Bendahara > Bukti Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Bukti_penerimaan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_bukti_penerimaan';

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
				'bendahara/bukti_penerimaan/sub_unit' => 'Bendahara Penerimaan Bukti Penerimaan'
			)
		);
		$this->set_title('Bukti Penerimaan')
		->set_icon('mdi mdi-rhombus-split')
		->set_primary('tahun, no_bukti, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, nama, alamat, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_truncate('uraian')
		->column_order('no_bku')
		->field_order('no_bukti, tgl_bukti, tgl_bukti, no_bku, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
		->view_order('no_bukti, tgl_bukti, tgl_bukti, no_bku, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
		->set_field
		(
			'uraian',
			'hyperlink',
			'bendahara/bukti_penerimaan/rinci',
			array
			(
				'no_bukti'							=> 'no_bukti'
			)
		)
		->field_position
		(
			array
			(
				'nama'								=> 2,
				'alamat'							=> 2,
				'nm_penandatangan'					=> 2,
				'nip_penandatangan'					=> 2,
				'jbt_penandatangan'					=> 2
			)
		)
		->set_field
		(
			array
			(
				'tgl_bukti'							=> 'datepicker'
			)
		)
		->set_field
		(
			'ketetapan',
			'radio',
			array
			(
				0									=> '<label class="badge badge-success">Tanpa Ketetapan</label>',
				1									=> '<label class="badge badge-primary">Dengan Ketetapan</label>'
			)
		)
		->set_alias
		(
			array
			(
				'no_bukti'							=> 'Nomor Bukti',
				'tgl_bukti'							=> 'Tanggal Bukti',
				'nama'								=> 'Nama Penyetor',
				'alamat'							=> 'Alamat Penyetor',
				'nm_penandatangan'					=> 'Nama Penandatangan',
				'nip_penandatangan'					=> 'Nip Penandatangan',
				'jbt_penandatangan'					=> 'Jabatan Penandatangan'
			)
		)
		->set_validation
		(
			array
			(
				'no_bukti'							=> 'required|',
				'tgl_bukti'							=> 'required|',
				'no_bku'							=> 'required|',
				'uraian'							=> 'required|',
				'ketetapan'							=> 'required|'
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
