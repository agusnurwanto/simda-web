<?php namespace Modules\Bendahara\Controllers\Ketetapan;
/**
 * Bendahara > Ketetapan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Ketetapan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_skp';

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
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('/sub_unit'));
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
				'bendahara/ketetapan/sub_unit'		=> 'Bendahara Penerimaan Ketetapan'
			)
		);
		$this->set_title('Ketetapan')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, no_skp, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_ref, tgl_ref')
		->unset_field('tahun, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_truncate('keterangan')
		->set_field
		(
			'keterangan',
			'hyperlink',
			'bendahara/ketetapan/rinci',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'no_skp'							=> 'no_skp'
			)
		)
		->field_position
		(
			array
			(
				'no_ref'							=> 2,
				'tgl_ref'							=> 2
			)
		)
		->set_field
		(
			array
			(
				'tgl_skp'							=> 'datepicker',
				'tgl_ref'							=> 'datepicker'
			)
		)
		->set_alias
		(
			array
			(
				'no_skp'							=> 'No Ketetapan',
				'no_ref'							=> 'No Ref',
				'tgl_skp'							=> 'Tanggal Ketetapan',
				'tgl_ref'							=> 'Tanggal Ref'
			)
		)
		->set_validation
		(
			array
			(
				'no_skp'							=> 'required|callback_validasi_no_skp',
				'tgl_skp'							=> 'required|',
				'no_ref'							=> 'required|',
				'keterangan'						=> 'required|',
				'tgl_ref'							=> 'required|',
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

	public function validasi_no_skp($value = 0)
	{
		$query										= $this->model->select
		('
			no_skp,
			tgl_skp
		')
		->get_where
		(
			'ta_skp',
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'no_skp'							=> $value
			)
		)
		->row();

		if(!$value)
		{
			return 'Bidang Nomor SKP dibutuhkan';
		}

		if(isset($query))
		{
			return 'No SKP ' . $value . ' sudah terdaftar';
		}

		return true;
	}

	public function before_update()
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
