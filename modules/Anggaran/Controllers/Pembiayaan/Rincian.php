<?php namespace Modules\Anggaran\Controllers\Pembiayaan;
/**
 * Anggaran > Pembiayaan > Rincian
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rincian extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_pembiayaan_rinc';

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
				'anggaran/pembiayaan/sub_unit'		=> 'Sub Unit',
				'../rekening'						=> 'Rekening',
			)
		);
		$this->set_title('Rincian')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_id')

		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, nilai_1, nilai_2, nilai_3, sat_1, sat_2, sat_3, , kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')

		->column_order('kd_rek_1, no_id, keterangan, jml_satuan, nilai_rp, total')
		->field_order('no_id, keterangan, nilai_rp, nilai_1, sat_1, nilai_2, sat_2, nilai_3, sat_3, satuan_123, jml_satuan, total')
		->view_order('no_id, keterangan, nilai_rp, nilai_1, sat_1, nilai_2,sat_2, nilai_3, sat_3, satuan_123, jml_satuan, total')

		->merge_content('{kd_rek_1}.{kd_rek_2}.{kd_rek_3}.{kd_rek_4}.{kd_rek_5}', 'Kode')
		->merge_content('{jml_satuan} ({satuan123})', phrase('volume'))
		->merge_field('no_id, keterangan, nilai_rp')
		->merge_field('nilai_1, sat_1')
		->merge_field('nilai_2, sat_2')
		->merge_field('nilai_3, sat_3')
		->merge_field('jml_satuan, satuan123')

		->field_prepend
		(
			array
			(
				'nilai_rp'							=> 'Rp',
				'total'								=> 'Rp',
				'jml_satuan'						=> 'Rp'
			)
		)
		->field_size
		(
			array
			(
				'no_id'								=> 'col-sm-2',
				'keterangan'						=> 'col-sm-5',
				'nilai_rp'							=> 'col-sm-5',
				'nilai_1'							=> 'col-sm-5',
				'nilai_2'							=> 'col-sm-5',
				'nilai_3'							=> 'col-sm-5',
				'jml_satuan'						=> 'col-sm-5',
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'keterangan'						=> 'textarea',
				'nilai_rp'							=> 'price_format',
				'nilai_1'							=> 'price_format',
				'nilai_2'							=> 'price_format',
				'nilai_3'							=> 'price_format',
				'satuan123'							=> 'readonly',
				'jml_satuan'						=> 'readonly',
				'total'								=> 'price_format, readonly'
			)
		)
		->add_class
		(
			array
			(
				'keterangan'						=> 'autofocus',
				'nilai_rp'							=> 'sum_field',
				'nilai_1'							=> 'sum_field',
				'nilai_2'							=> 'sum_field',
				'nilai_3'							=> 'sum_field',
				'jml_satuan'						=> 'sum_total',
				'total'								=> 'sum_total',
				'sat_1'								=> 'merge-text',
				'sat_2'								=> 'merge-text',
				'sat_3'								=> 'merge-text',
				'satuan123'							=> 'merge-text-result'
			)
		)
		->set_alias
		(
			array
			(
				'no_id'								=> 'No',
				'keterangan'						=> 'Uraian',
				'nilai_rp'							=> 'Harga Satuan',
				'sat_1'								=> 'Satuan 1',
				'sat_2'								=> 'Satuan 2',
				'sat_3'								=> 'Satuan 3',
				'nilai_1'							=> 'Volume 1',
				'nilai_2'							=> 'Volume 2',
				'nilai_3'							=> 'Volume 3',
				'jml_satuan'						=> 'Volume',
				'satuan123'							=> 'Satuan'
			)
		)
		->set_validation
		(
			array
			(
				//'no_id'							=> 'required|is_unique[ta_belanja_rinc_sub.no_id.no_id.' . service('request')->getPost('no_id') . '.kd_urusan.' . service('request')->getGet('kd_urusan') . '.kd_bidang.' . service('request')->getGet('kd_bidang') . '.kd_unit.' . service('request')->getGet('kd_unit') . '.kd_sub.' . service('request')->getGet('kd_sub') . '.kd_keg.' . service('request')->getGet('kd_keg') . '.kd_prog.' . service('request')->getGet('kd_prog') . '.id_prog.' . service('request')->getGet('id_prog') . '.kd_rek_1.' . service('request')->getGet('kd_rek_1') . '.kd_rek_2.' . service('request')->getGet('kd_rek_2') . '.kd_rek_3.' . service('request')->getGet('kd_rek_3') . '.kd_rek_4.' . service('request')->getGet('kd_rek_4') . '.kd_rek_5.' . service('request')->getGet('kd_rek_5') . '.no_rinc.' . service('request')->getGet('no_rinc') . ']',
				'nilai_1'							=> 'required',
				'sat_1'								=> 'required',
				'keterangan'						=> 'required',
				'nilai_rp'							=> 'required'
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
				'kd_prog'							=> '0',
				'id_prog'							=> '0',
				'kd_keg'							=> '0',
				'kd_rek_1'							=> service('request')->getGet('kd_rek_1'),
				'kd_rek_2'							=> service('request')->getGet('kd_rek_2'),
				'kd_rek_3'							=> service('request')->getGet('kd_rek_3'),
				'kd_rek_4'							=> service('request')->getGet('kd_rek_4'),
				'kd_rek_5'							=> service('request')->getGet('kd_rek_5'),
				'jml_satuan'						=> (service('request')->getPost('nilai_1') > 0 ? service('request')->getPost('nilai_1') : 1) * (service('request')->getPost('nilai_2') > 0 ? service('request')->getPost('nilai_2') : 1) * (service('request')->getPost('nilai_3') > 0 ? service('request')->getPost('nilai_3') : 1),
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
				'kd_prog'							=> 0,
				'id_prog'							=> 0,
				'kd_keg'							=> 0,
				'kd_rek_1'							=> service('request')->getGet('kd_rek_1'),
				'kd_rek_2'							=> service('request')->getGet('kd_rek_2'),
				'kd_rek_3'							=> service('request')->getGet('kd_rek_3'),
				'kd_rek_4'							=> service('request')->getGet('kd_rek_4'),
				'kd_rek_5'							=> service('request')->getGet('kd_rek_5')
			)
		)
		->modal_size('modal-lg')
		->render($this->_table);
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_pembiayaan.kd_urusan,
			ta_pembiayaan.kd_bidang,
			ta_pembiayaan.kd_unit,
			ta_pembiayaan.kd_sub,
			ta_pembiayaan.kd_keg,
			ta_pembiayaan.kd_rek_1,
			ta_pembiayaan.kd_rek_2,
			ta_pembiayaan.kd_rek_3,
			ta_pembiayaan.kd_rek_4,
			ta_pembiayaan.kd_rek_5,
			ref_rek_5.nm_rek_5,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ref_rek_5',
			'ref_rek_5.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND ref_rek_5.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND ref_rek_5.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND ref_rek_5.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND ref_rek_5.kd_rek_5 = ta_pembiayaan.kd_rek_5'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_pembiayaan.kd_urusan AND ref_sub_unit.kd_bidang = ta_pembiayaan.kd_bidang AND ref_sub_unit.kd_unit = ta_pembiayaan.kd_unit AND ref_sub_unit.kd_sub = ta_pembiayaan.kd_sub'
		)
		->get_where
		(
			'ta_pembiayaan',
			array
			(
				'ta_pembiayaan.kd_urusan'			=> service('request')->getGet('kd_urusan'),
				'ta_pembiayaan.kd_bidang'			=> service('request')->getGet('kd_bidang'),
				'ta_pembiayaan.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_pembiayaan.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_pembiayaan.kd_prog'				=> 0,
				'ta_pembiayaan.id_prog'				=> 0,
				'ta_pembiayaan.kd_keg'				=> 0
			)
		)
		->row();

		return $query;
	}
}
