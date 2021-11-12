<?php namespace Modules\Master\Controllers\Wilayah;
/**
 * Master > Wilayah > Kecamatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Kecamatan extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		$this->_primary								= service('request')->getGet('regional');
	}
	
	public function index()
	{
		if($this->_primary)
		{
			$query									= $this->model->select
			('
				ref__regional.id,
				ref__regional.kode AS kd_regional,
				ref__regional.regional,
				ref__provinsi.kode AS kd_provinsi,
				ref__provinsi.provinsi
			')
			->join
			(
				'ref__provinsi',
				'ref__provinsi.id = ref__regional.id_provinsi'
			)
			->get_where
			(
				'ref__regional',
				array
				(
					'ref__regional.id'				=> $this->_primary
				),
				1
			)
			->row();
			if($query)
			{
				$this->set_description
				('
					<div class="row text-sm border-bottom">
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
					<div class="row text-sm">
						<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
							Regional
						</label>
						<label class="col-2 col-sm-1 mb-0">
							' . sprintf('%02d', $query->kd_provinsi) . '.' . sprintf('%04d', $query->kd_regional) . '
						</label>
						<label class="col-10 col-sm-9 text-uppercase mb-0">
							' . $query->regional . '
						</label>
					</div>
				')
				->set_default('id_regional', $query->id);
			}
		}
		else
		{
			$this->set_validation('id_regional', 'required|numeric');
		}
		
		$this->set_title('Master Data Kecamatan')
		->set_icon('mdi mdi-map-marker')
		->unset_column('id, id_regional, regional, kode_ref__regional')
		->unset_view('id, id_regional, regional, kode_ref__regional')
		->unset_field('id')
		->set_field('kode', 'last_insert, sprintf', null, '%02d')
		->set_field('kecamatan', 'hyperlink', 'master/wilayah/kelurahan', array('kecamatan' => 'id'))
		->set_relation
		(
			'id_regional',
			'ref__regional.id',
			'{ref__regional.kode} - {ref__regional.regional}'
		)
		->set_validation
		(
			array
			(
				'kode'								=> 'required|numeric|is_unique[ref__kecamatan.kode.id.' . service('request')->getGet('id') . ']',
				'kecamatan'							=> 'required|'
			)
		)
		->render('ref__kecamatan');
	}
}
