<?php namespace Modules\Bendahara\Controllers\Sisa_up;
/**
 * Bendahara > Sisa Up
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sisa_up extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_s3up';

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
				'bendahara/sisa_up/sub_unit'		=> 'Bendahara Pengeluaran Sisa Up',
			)
		);
		$this->set_title('Sisa Up')
		->set_icon('mdi mdi-soccer-field')
		->set_primary('tahun, no_bukti, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_bank, d_k, kd_pembayaran, nm_bank')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, d_k')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, d_k')
		->unset_truncate('keterangan')
		//->column_order('no_bukti, tgl_bukti, no_bku, uraian, nilai, keterangan')
		->field_position
		(
			array
			(
				'keterangan'						=> 2,
				'kd_bank'							=> 2,
				'kd_pembayaran'						=> 2,
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
			'kd_bank',
			'radio',
			array
			(
				1									=> '<label class="badge badge-info">Tunai</label>',
				2									=> '<label class="badge badge-primary">Bank</label>'
			)
		)
		->set_field
		(
			'd_k',
			'radio',
			array
			(
				'D'									=> '<label class="badge badge-success">Pemberian</label>',
				'K'									=> '<label class="badge badge-warning">Pengembalian</label>'
			)
		)
		->set_alias
		(
			array
			(
				'no_bukti'							=> 'Nomor Bukti',
				'tgl_bukti'							=> 'Tanggal Bukti',
				'kd_bank'							=> 'Jenis Bank',
				'kd_pembayaran'						=> 'Jenis Pembayaran',
				'd_k'								=> 'Jenis Panjar'
			)
		)
		->set_validation
		(
			array
			(
				'no_bukti'							=> 'required|',
				'tgl_bukti'							=> 'required|',
				'no_bku'							=> 'required|',
				'nilai'								=> 'required|',
				'kd_bank'							=> 'required|',
				'kd_pembayaran'						=> 'required|',
				'keterangan'						=> 'required|'
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
				'd_k'								=> 'D'
			)
		)
		->set_relation
		(
			'kd_pembayaran',
			'ref_bank.kd_bank',
			'{ref_bank.no_rekening} - {ref_bank.nm_bank}',
			array
			(
				//'ref_bank.tahun'					=> get_userdata('year')
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
