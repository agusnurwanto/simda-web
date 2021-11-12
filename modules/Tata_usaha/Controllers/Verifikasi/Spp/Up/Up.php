<?php namespace Modules\Tata_usaha\Controllers\Verifikasi\Spp\Up;
/**
 * Tata Usaha > Verifikasi > SPP > UP
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Up extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spp';
	
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
				'tata_usaha/verifikasi/spp/up/sub_unit'	=> 'Tata Usaha Verifikasi SPP UP'
			)
		);
		
		$this->set_title('SPP Uang Persediaan')
		->set_icon('mdi mdi-reflect-vertical')
		->set_primary('tahun, no_spp, kd_urusan, kd_bidang, kd_unit, kd_sub, jns_tagihan')
		->unset_action('export, print, pdf, create, update, delete')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_spd, jns_tagihan, no_spj, kd_edit, nm_penerima, alamat_penerima, bank_penerima, rek_penerima, npwp, nama_pptk, nip_pptk, no_tagihan, tgl_tagihan, realisasi_fisik, ur_tagihan, jn_spp')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_spd, jn_spp, no_spj, kd_edit, tgl_tagihan, realisasi_fisik, ur_tagihan, jns_tagihan, no_tagihan')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_spd, jns_tagihan, no_spj, kd_edit, no_tagihan, tgl_tagihan, realisasi_fisik, ur_tagihan, jn_spp')
		->unset_truncate('uraian')

		->set_field
		(
			'uraian',
			'hyperlink',
			'tata_usaha/verifikasi/spp/up/rinci',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'jn_spp'							=> 'jn_spp',
				'no_spp'							=> 'no_spp'
			)
		)
		->field_position
		(
			array
			(
				'nm_penerima'						=> 2,
				'alamat_penerima'					=> 2,
				'bank_penerima'						=> 2,
				'rek_penerima'						=> 2,
				'npwp'								=> 2
			)
		)
		->set_field
		(
			array
			(
				'tgl_spp'							=> 'datepicker'
			)
		)
		->set_field
		(
			'jns_tagihan',
			'radio',
			array
			(
				0									=> '<label class="badge badge-success">Belanja Modal Uang Muka</label>',
				1									=> '<label class="badge badge-warning">Belanja Operasional (GU)</label>',
				2									=> '<label class="badge badge-info">Belanja Modal Non Termin</label>',
				3									=> '<label class="badge badge-secondary">Belanja Modal Termin (TU)</label>',
				4									=> '<label class="badge badge-danger">Belanja Modal Termin Terakhir</label>',
				5									=> '<label class="badge badge-danger">Pembiayaan</label>'
			)
		)
		->set_alias
		(
			array
			(
				'no_spp'							=> 'Nomor Spp',
				'tgl_spp'							=> 'Tanggal',
				'jn_spp'							=> 'Jenis Spp',
				'nm_jn_spm'							=> 'Jenis Spp',
				'jns_tagihan'						=> 'Jenis Tagihan',
				'no_spd'							=> 'Nomor Spd',
				'tgl_tagihan'						=> 'Tanggal Tagihan',
				'ur_tagihan'						=> 'Uraian Tagihan',
				'nama_pptk'							=> 'Nama PPTK',
				'nip_pptk'							=> 'Nip PPTK',
				'nm_penerima'						=> 'Nama',
				'alamat_penerima'					=> 'Alamat',
				'bank_penerima'						=> 'Bank',
				'rek_penerima'						=> 'Rekening',
				'npwp'								=> 'NPWP'
			)
		)
		->set_validation
		(
			array
			(
				'no_spp'							=> 'required|callback_validasi_no_spp',
				'uraian'							=> 'required|',
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
				'jn_spp'							=> 1
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
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'jn_spp'							=> 1
			)
		)
		->render($this->_table);
	}

	public function validasi_no_spp($value = 0)
	{
		if(!$value)
		{
			return 'Bidang Nomor SPP dibutuhkan';
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
