<?php namespace Modules\Anggaran\Controllers\Pendapatan;
/**
 * Anggaran > Pendapatan > Sub Unit
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sub_unit extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_sub_unit';
	
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
		if(!get_userdata('sub_unit') && get_userdata('group_id') == 1)
		{
			$this->add_filter($this->_filter());
		}
		
		/*
		if(service('request')->getGet('unit'))
		{
			list
			(
				$kd_urusan,
				$kd_bidang,
				$kd_unit
			)										= explode('.', service('request')->getGet('unit'));

			$this->where
			(
				array
				(
					'kd_urusan'						=> $kd_urusan,
					'kd_bidang'						=> $kd_bidang,
					'kd_unit'						=> $kd_unit
				)
			);
		}
		*/
		
		$this->set_breadcrumb
		(
			array
			(
				'anggaran/pendapatan/sub_unit'		=> 'Anggaran Pendapatan'
			)
		);
		
		$this->set_title('Silakan memilih Sub Unit')
		->set_icon('mdi mdi-square-inc-cash')
		->set_primary('kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('create, update, delete, print, export, pdf')
		->merge_content('{kd_urusan}.{kd_bidang}.{kd_unit}.{kd_sub}', 'Kode')
		->set_field
		(
			'nm_sub_unit',
			'hyperlink',
			'anggaran/pendapatan/rekening',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub'
			)
		)
		->set_alias('nm_sub_unit', 'Sub Unit')
		->render($this->_table);
	}
	
	private function _filter()
	{
		$output										= null;
		$query										= $this->model->get_where('ref_unit')->result();
		
		if($query)
		{
			foreach($query as $key => $val)
			{
				$output								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '"' . (service('request')->getGet('unit') == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . ' - ' . $val->nm_unit . '</option>';
			}
		}
		
		$output										= '
			<select name="unit" class="form-control input-sm bordered" placeholder="Filter berdasar Unit">
				<option value="all">Semua Unit</option>
				' . $output . '
			</select>
		';
		
		return $output;
	}
}
