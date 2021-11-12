<?php namespace Modules\Bendahara\Controllers\Spj;
/**
 * Bendahara > SPJ
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Spj extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spj';

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
		if(in_array($this->_method, array('create', 'update')))
		{
			if(in_array($this->_method, array('update')))
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
				'bendahara/spj/sub_unit'			=> 'Bendahara Pengeluaran'
			)
		);
		$this->set_title('SPJ')
		->set_icon('mdi mdi-skype')
		->set_primary('tahun, no_spj, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, jn_spj, kd_edit, no_spm, no_bukti')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, jn_spj, kd_edit, no_spm, no_bku, no_bukti')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, jn_spj, kd_edit, no_spm, no_bukti')
		->unset_truncate('keterangan')
		->set_field
		(
			'keterangan',
			'hyperlink',
			'bendahara/spj/rinci',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'no_spj'							=> 'no_spj'
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
				'no_spj'							=> 'Nomor Spj',
				'tgl_spj'							=> 'Tanggal Spj'
			)
		)
		->set_validation
		(
			array
			(
				//'no_spj'							=> 'required|callback_validasi_no_spj',
				'no_spj'							=> 'required',
				'tgl_spj'						    => 'required',
				'keterangan'						=> 'required'
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
				'jn_spj'							=> '2',
				'no_bku'							=> '0',
				'kd_edit'							=> '0'
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
				'jn_spp'							=> 1
			)
		)
		->render($this->_table);
	}

	public function validasi_no_spj($value = 0)
	{
		$query										= $this->model->select
		('
			no_spj
		')
			->get_where
			(
				'ta_spj',
				array
				(
					'ta_spj.no_spj'			        => '0003/spj'
				)
			)
			->row();

		if(!$query)
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
