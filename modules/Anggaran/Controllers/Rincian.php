<?php namespace Modules\Anggaran\Controllers;
/**
 * Anggaran > Rincian
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rincian extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_belanja_rinc_sub';
	
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
				<div class="row text-sm border-bottom">
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
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						sub rincian
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->no_rinc . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->keterangan . '
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
				'../rekening'						=> 'Rekening',
				'../sub'							=> 'Sub Rincian'
			)
		);
		
		$this->set_title('Rincian')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_rinc, no_id')

		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_rinc, sat_1, sat_2, sat_3, nilai_1, nilai_2, nilai_3')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_rinc')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, no_rinc')
		
		->column_order('no_id, keterangan, jml_satuan, nilai_rp, total')
		->field_order('no_id, keterangan, nilai_rp, nilai_1, sat_1, nilai_2, sat_2, nilai_3, sat_3, satuan_123, jml_satuan, total')
		->view_order('no_id, keterangan, nilai_rp, nilai_1, sat_1, nilai_2, sat_2, nilai_3, sat_3, satuan_123, jml_satuan, total')
		
		->merge_content('{jml_satuan} ({satuan123})', phrase('volume'))
		->merge_field('no_id, keterangan, nilai_rp')
		->merge_field('nilai_1, sat_1')
		->merge_field('nilai_2, sat_2')
		->merge_field('nilai_3, sat_3')
		->merge_field('jml_satuan, satuan123')

		->field_size
		(
			array
			(
				'no_id'								=> 'col-2',
				'keterangan'						=> 'col-7',
				'nilai_rp'							=> 'col-3',
				'nilai_1'							=> 'col-5',
				'sat_1'								=> 'col-7',
				'nilai_2'							=> 'col-5',
				'sat_2'								=> 'col-7',
				'nilai_3'							=> 'col-5',
				'sat_3'								=> 'col-7',
				'jml_satuan'						=> 'col-5',
				'satuan123'							=> 'col-7'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'nilai_1'							=> 'price_format',
				'nilai_2'							=> 'price_format',
				'nilai_3'							=> 'price_format',
				'nilai_rp'							=> 'price_format',
				'jml_satuan'						=> 'readonly',
				'satuan123'							=> 'readonly',
				'total'								=> 'price_format, readonly'
			)
		)
		->set_validation
		(
			array
			(
				//'no_id'								=> 'required|is_unique[ta_belanja_rinc_sub.no_id.no_id.' . service('request')->getPost('no_id') . '.kd_urusan.' . service('request')->getGet('kd_urusan') . '.kd_bidang.' . service('request')->getGet('kd_bidang') . '.kd_unit.' . service('request')->getGet('kd_unit') . '.kd_sub.' . service('request')->getGet('kd_sub') . '.kd_keg.' . service('request')->getGet('kd_keg') . '.kd_prog.' . service('request')->getGet('kd_prog') . '.id_prog.' . service('request')->getGet('id_prog') . '.kd_rek_1.' . service('request')->getGet('kd_rek_1') . '.kd_rek_2.' . service('request')->getGet('kd_rek_2') . '.kd_rek_3.' . service('request')->getGet('kd_rek_3') . '.kd_rek_4.' . service('request')->getGet('kd_rek_4') . '.kd_rek_5.' . service('request')->getGet('kd_rek_5') . '.no_rinc.' . service('request')->getGet('no_rinc') . ']',
				'nilai_1'							=> 'required',
				'keterangan'						=> 'required',
				'nilai_rp'							=> 'required'
			)
		)
		->add_class
		(
			array
			(
				'nilai_rp'							=> 'sum_field',
				'nilai_1'							=> 'sum_field',
				'nilai_2'							=> 'sum_field',
				'nilai_3'							=> 'sum_field',
				'total'								=> 'sum_total',
				'sat_1'								=> 'merge-text',
				'sat_2'								=> 'merge-text',
				'sat_3'								=> 'merge-text',
				'satuan123'							=> 'merge-text-result',
				'jml_satuan'						=> 'sum_volume'
			)
		)
		->set_alias
		(
			array
			(
				'no_id'								=> 'Kode',
				'jml_satuan'						=> 'Jumlah Satuan'
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
				'kd_rek_5'							=> service('request')->getGet('kd_rek_5'),
				//'no_rinc'							=> service('request')->getGet('no_rinc')
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
				'kd_prog'							=> service('request')->getGet('kd_prog'),
				'id_prog'							=> service('request')->getGet('id_prog'),
				'kd_keg'							=> service('request')->getGet('kd_keg'),
				'kd_rek_1'							=> service('request')->getGet('kd_rek_1'),
				'kd_rek_2'							=> service('request')->getGet('kd_rek_2'),
				'kd_rek_3'							=> service('request')->getGet('kd_rek_3'),
				'kd_rek_4'							=> service('request')->getGet('kd_rek_4'),
				'kd_rek_5'							=> service('request')->getGet('kd_rek_5'),
				//'no_rinc'							=> service('request')->getGet('no_rinc')
			)
		)
		->modal_size('modal-lg')
		->render($this->_table);
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_belanja_rinc.kd_urusan,
			ta_belanja_rinc.kd_bidang,
			ta_belanja_rinc.kd_unit,
			ta_belanja_rinc.kd_sub,
			ta_belanja_rinc.kd_keg,
			ta_belanja_rinc.kd_rek_1,
			ta_belanja_rinc.kd_rek_2,
			ta_belanja_rinc.kd_rek_3,
			ta_belanja_rinc.kd_rek_4,
			ta_belanja_rinc.kd_rek_5,
			ta_belanja_rinc.no_rinc,
			ta_belanja_rinc.keterangan,
			ta_kegiatan.ket_kegiatan,
			ref_rek_5.nm_rek_5,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ta_belanja',
			'ta_belanja.kd_urusan = ta_belanja_rinc.kd_urusan AND ta_belanja.kd_bidang = ta_belanja_rinc.kd_bidang AND ta_belanja.kd_unit = ta_belanja_rinc.kd_unit AND ta_belanja.kd_sub = ta_belanja_rinc.kd_sub AND ta_belanja.kd_keg = ta_belanja_rinc.kd_keg AND ta_belanja.kd_rek_1 = ta_belanja_rinc.kd_rek_1 AND ta_belanja.kd_rek_2 = ta_belanja_rinc.kd_rek_2 AND ta_belanja.kd_rek_3 = ta_belanja_rinc.kd_rek_3 AND ta_belanja.kd_rek_4 = ta_belanja_rinc.kd_rek_4 AND ta_belanja.kd_rek_5 = ta_belanja_rinc.kd_rek_5'
		)
		->join
		(
			'ta_kegiatan',
			'ta_kegiatan.kd_urusan = ta_belanja.kd_urusan AND ta_kegiatan.kd_bidang = ta_belanja.kd_bidang AND ta_kegiatan.kd_unit = ta_belanja.kd_unit AND ta_kegiatan.kd_sub = ta_belanja.kd_sub AND ta_kegiatan.kd_keg = ta_belanja.kd_keg'
		)
		->join
		(
			'ref_rek_5',
			'ref_rek_5.kd_rek_1 = ta_belanja.kd_rek_1 AND ref_rek_5.kd_rek_2 = ta_belanja.kd_rek_2 AND ref_rek_5.kd_rek_3 = ta_belanja.kd_rek_3 AND ref_rek_5.kd_rek_4 = ta_belanja.kd_rek_4 AND ref_rek_5.kd_rek_5 = ta_belanja.kd_rek_5'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan AND ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang AND ref_sub_unit.kd_unit = ta_kegiatan.kd_unit AND ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
		)
		->get_where
		(
			'ta_belanja_rinc',
			array
			(
				'ta_belanja_rinc.kd_urusan'			=> service('request')->getGet('kd_urusan'),
				'ta_belanja_rinc.kd_bidang'			=> service('request')->getGet('kd_bidang'),
				'ta_belanja_rinc.kd_unit'			=> service('request')->getGet('kd_unit'),
				'ta_belanja_rinc.kd_sub'			=> service('request')->getGet('kd_sub'),
				'ta_belanja_rinc.kd_keg'			=> service('request')->getGet('kd_keg'),
				'ta_belanja_rinc.kd_rek_1'			=> service('request')->getGet('kd_rek_1'),
				'ta_belanja_rinc.kd_rek_2'			=> service('request')->getGet('kd_rek_2'),
				'ta_belanja_rinc.kd_rek_3'			=> service('request')->getGet('kd_rek_3'),
				'ta_belanja_rinc.kd_rek_4'			=> service('request')->getGet('kd_rek_4'),
				'ta_belanja_rinc.kd_rek_5'			=> service('request')->getGet('kd_rek_5'),
				//'ta_belanja_rinc.no_rinc'			=> service('request')->getGet('no_rinc')
			)
		)
		->row();
		
		return $query;
	}
}
