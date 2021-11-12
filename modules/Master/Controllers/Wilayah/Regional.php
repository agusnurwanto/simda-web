<?php namespace Modules\Master\Controllers\Wilayah;
/**
 * Master > Wilayah > Regional
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Regional extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		$this->_primary								= service('request')->getGet('provinsi');
	}
	
	public function index()
	{
		if($this->_primary)
		{
			$query									= $this->model->select
			('
				ref__provinsi.id,
				ref__provinsi.kode AS kd_provinsi,
				ref__provinsi.provinsi
			')
			->get_where
			(
				'ref__provinsi',
				array
				(
					'ref__provinsi.id'				=> $this->_primary
				),
				1
			)
			->row();
			if($query)
			{
				$this->set_description
				('
					<div class="row text-sm">
						<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
							Provinsi
						</label>
						<label class="col-2 col-sm-1 mb-0">
							' . sprintf('%02d', $query->kd_provinsi) . '
						</label>
						<label class="col-10 col-sm-9 text-uppercase mb-0">
							' . $query->provinsi . '
						</label>
					</div>
				')
				->set_default('id_provinsi', $query->id);
			}
		}
		else
		{
			$this->set_validation('id_provinsi', 'required|numeric');
		}
		
		$this->set_title('Master Data Kabupaten / Kota')
		->set_icon('mdi mdi-map-marker')
		->unset_column('id, id_provinsi, provinsi, kode_ref__provinsi')
		->unset_view('id, id_provinsi, provinsi, kode_ref__provinsi')
		->unset_field('id')
		->set_field('kode', 'last_insert, sprintf', null, '%04d')
		->set_field('regional', 'hyperlink', 'master/wilayah/kecamatan', array('regional' => 'id'))
		->set_relation
		(
			'id_provinsi',
			'ref__provinsi.id',
			'{ref__provinsi.kode} - {ref__provinsi.provinsi}'
		)
		->set_validation
		(
			array
			(
				'kode'								=> 'required|numeric|is_unique[ref__regional.kode.id.' . service('request')->getGet('id') . ']',
				'regional'							=> 'required|'
			)
		)
		->render('ref__regional');
	}
}
