<?php namespace Modules\Pertimbangan\Controllers;
/**
 * Pertimbangan > Sub Unit
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sub_unit extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
		
		$this->unset_action('create, read, update, delete');
	}
	
	public function index()
	{
		$this->set_title('Silakan pilih Sub Unit')
		->set_icon('mdi mdi-sitemap')
		
		/* karena tidak ada default primary key */
		->set_primary('Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub')
		
		->set_field('Nm_Sub_Unit', 'hyperlink', 'pertimbangan', array('Kd_Urusan' => 'Kd_Urusan', 'Kd_Bidang' => 'Kd_Bidang', 'Kd_Unit' => 'Kd_Unit', 'Kd_Sub' => 'Kd_Sub'))
		
		->merge_content('{Kd_Urusan}.{Kd_Bidang}.{Kd_Unit}.{Kd_Sub}', 'Kode')
		->set_alias('Nm_Sub_Unit', 'Sub Unit')
		->render('Ref_Sub_Unit');
	}
}
