<?php namespace Modules\Bendahara\Controllers\Sp3b;
/**
 * Bendahara > SP3B
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sp3b extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_sp3b';
	
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
				'bendahara/sp3b/sub_unit'			=> 'Bendahara Pengeluaran Sp3b'
			)
		);
		
		$this->set_title('SP3B')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, no_sp3b, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, nm_penandatangan, nip_penandatangan, jbt_penandatangan, kd_edit')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_edit')
		->unset_view('tahun, kd_urusan, kd_unit, kd_unit, kd_sub, kd_edit')
		->unset_truncate('uraian')
		
		->set_field
		(
			'uraian',
			'hyperlink',
			'bendahara/sp3b/rinci',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'no_sp3b'							=> 'no_sp3b'
			)
		)
		->field_position
		(
			array
			(
				'nm_penandatangan'					=> 2,
				'nip_penandatangan'					=> 2,
				'jbt_penandatangan'					=> 2
			)
		)
		->set_field
		(
			array
			(
				'tgl_sp3b'							=> 'datepicker'
			)
		)
		->set_alias
		(
			array
			(
				'nm_penandatangan'					=> 'Nama Penandatangan',
				'nip_penandatangan'					=> 'Nip Penandatangan',
				'jbt_penandatangan'					=> 'Jabatan Penandatangan'
			)
		)
		/*
		->set_validation
		(
			array
			(
				'no_spp'							=> 'required|callback_validasi_no_spp',
				'tgl_spp'							=> 'required|',
				'jn_spp'							=> 'required|',
				'no_tagihan'						=> 'required|callback_validasi_no_tagihan',
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
				'kd_edit'							=> '0'
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
	
	public function validasi_no_spp($value = 0)
	{
		$query										= $this->model->select
		('
			no_spp,
			no_tagihan
		')
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
				'ta_spp.no_spp'						=> $value
			)
		)
		->row();
		
		if(!$value)
		{
			return 'Bidang Nomor SPP dibutuhkan';
		}
		
		if(isset($query))
		{
			return 'No SPP ' . $value . ' sudah terdaftar';
		}
		
		return true;
	}
	
	public function validasi_no_tagihan($value = 0)
	{
		$query										= $this->model->select
		('
			no_spp,
			no_tagihan
		')
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
				'ta_spp.no_spp'						=> $value
			)
		)
		->row();
		
		if(!$value)
		{
			return 'Bidang Nomor Tagihan dibutuhkan';
		}
		
		if(isset($query))
		{
			return 'Nomor Tagihan ' . $value . ' sudah terdaftar';
		}
		
		$query_kegiatan								= $this->model->select
		('
			ta_tagihan.no_tagihan,
			ta_tagihan.tgl_tagihan,
			ta_tagihan.jns_tagihan,
			ta_tagihan.realisasi_fisik,
			ta_tagihan.ur_tagihan
		')
		->get_where
		(
			'ta_tagihan',
			array
			(
				'ta_tagihan.tahun'					=> get_userdata('year'),
				'ta_tagihan.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_tagihan.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_tagihan.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_tagihan.kd_sub'					=> service('request')->getGet('kd_sub'),
				'ta_tagihan.no_tagihan'				=> $value
			)
		)
		->row();
		
		$this->set_default
		(
			array
			(
				'no_tagihan'						=> $query_kegiatan->no_tagihan,
				'tgl_tagihan'						=> $query_kegiatan->tgl_tagihan,
				'jns_tagihan'						=> $query_kegiatan->jns_tagihan,
				'realisasi_fisik'					=> $query_kegiatan->realisasi_fisik,
				'ur_tagihan'						=> $query_kegiatan->ur_tagihan
			)
		);
		
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
