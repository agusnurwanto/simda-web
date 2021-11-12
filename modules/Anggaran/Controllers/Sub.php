<?php namespace Modules\Anggaran\Controllers;
/**
 * Anggaran > Sub
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sub extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_belanja_rinc';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_theme('backend');
		$this->database_config('default');
		$this->set_permission();
	}
	
	public function index()
	{
		$header										= $this->_header();
		
		if($header)
		{
			$this->set_description
			('
				<div class="row text-sm border-bottom">
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
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						rekening
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_rek_1 . '.' . $header->kd_rek_2 . '.' . $header->kd_rek_3 . '.' . sprintf('%02d', $header->kd_rek_4) . '.' . sprintf('%02d', $header->kd_rek_5) . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_rek_5 . '
					</label>
				</div>
			');
		}

		$this->set_breadcrumb
		(
			array
			(
				'anggaran'							=> 'Anggaran',
				'sub_unit'							=> 'Sub Unit',
				'../kegiatan'						=> 'Kegiatan',
				'../rekening'						=> 'Rekening'
			)
		);
		$this->set_title('Sub Rincian')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_rinc')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, nm_sumber')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg')
		->unset_truncate('keterangan')
		->set_field
		(
			'keterangan',
			'hyperlink',
			'anggaran/rincian',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'kd_prog'							=> 'kd_prog',
				'id_prog'							=> 'id_prog',
				'kd_keg'							=> 'kd_keg',
				'kd_rek_1'							=> 'kd_rek_1',
				'kd_rek_2'							=> 'kd_rek_2',
				'kd_rek_3'							=> 'kd_rek_3',
				'kd_rek_4'							=> 'kd_rek_4',
				'kd_rek_5'							=> 'kd_rek_5',
				'no_rinc'							=> 'no_rinc'
			)
		)
		->set_field
		(
			array
			(
				'no_rinc'							=> 'last_insert, readonly'
			)
		)
		->set_alias
		(
			array
			(
				'no_rinc'							=> 'Kode',
				'keterangan'						=> 'Uraian',
				'kd_sumber'							=> 'Sumber Dana',
				'nm_sumber'							=> 'Sumber Dana'
			)
		)
		//->merge_content('{kd_rek_1}.{kd_rek_2}.{kd_rek_3}.{kd_rek_4}.{kd_rek_5}.{no_rinc}', 'Kode')
		
		->set_validation
		(
			array
			(
				'keterangan'						=> 'required|',
				'kd_sumber'							=> 'required|'
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
				'kd_prog'							=> service('request')->getGet('kd_prog'),
				'id_prog'							=> service('request')->getGet('id_prog'),
				'kd_keg'							=> service('request')->getGet('kd_keg'),
				'kd_rek_1'							=> service('request')->getGet('kd_rek_1'),
				'kd_rek_2'							=> service('request')->getGet('kd_rek_2'),
				'kd_rek_3'							=> service('request')->getGet('kd_rek_3'),
				'kd_rek_4'							=> service('request')->getGet('kd_rek_4'),
				'kd_rek_5'							=> service('request')->getGet('kd_rek_5')
			)
		)
		->set_relation
		(
			'kd_sumber',
			'ref_sumber_dana.kd_sumber',
			'{ref_sumber_dana.kd_sumber}. {ref_sumber_dana.nm_sumber}'
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
				'kd_prog'							=> service('request')->getGet('kd_prog'),
				'id_prog'							=> service('request')->getGet('id_prog'),
				'kd_keg'							=> service('request')->getGet('kd_keg'),
				'kd_rek_1'							=> service('request')->getGet('kd_rek_1'),
				'kd_rek_2'							=> service('request')->getGet('kd_rek_2'),
				'kd_rek_3'							=> service('request')->getGet('kd_rek_3'),
				'kd_rek_4'							=> service('request')->getGet('kd_rek_4'),
				'kd_rek_5'							=> service('request')->getGet('kd_rek_5')
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
			ta_kegiatan.ket_kegiatan,
			ref_rek_5.kd_rek_1,
			ref_rek_5.kd_rek_2,
			ref_rek_5.kd_rek_3,
			ref_rek_5.kd_rek_4,
			ref_rek_5.kd_rek_5,
			ref_rek_5.nm_rek_5,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ta_kegiatan',
			'ta_kegiatan.kd_urusan = ta_belanja.kd_urusan and ta_kegiatan.kd_bidang = ta_belanja.kd_bidang and ta_kegiatan.kd_unit = ta_belanja.kd_unit and ta_kegiatan.kd_sub = ta_belanja.kd_sub and ta_kegiatan.kd_keg = ta_belanja.kd_keg'
		)
		->join
		(
			'ref_rek_5',
			'ref_rek_5.kd_rek_1 = ta_belanja.kd_rek_1 and ref_rek_5.kd_rek_2 = ta_belanja.kd_rek_2 and ref_rek_5.kd_rek_3 = ta_belanja.kd_rek_3 and ref_rek_5.kd_rek_4 = ta_belanja.kd_rek_4 and ref_rek_5.kd_rek_5 = ta_belanja.kd_rek_5'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan and ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang and ref_sub_unit.kd_unit = ta_kegiatan.kd_unit and ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
		)
		->get_where
		(
			'ta_belanja',
			array
			(
				'ta_belanja.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_belanja.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_belanja.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_belanja.kd_sub'					=> service('request')->getGet('kd_sub'),
				'ta_belanja.kd_keg'					=> service('request')->getGet('kd_keg'),
				'ta_belanja.kd_rek_1'				=> service('request')->getGet('kd_rek_1'),
				'ta_belanja.kd_rek_2'				=> service('request')->getGet('kd_rek_2'),
				'ta_belanja.kd_rek_3'				=> service('request')->getGet('kd_rek_3'),
				'ta_belanja.kd_rek_4'				=> service('request')->getGet('kd_rek_4'),
				'ta_belanja.kd_rek_5'				=> service('request')->getGet('kd_rek_5')
			)
		)
		->row();
		
		return $query;
	}
}
