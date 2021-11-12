<?php namespace Modules\Tester\Controllers;
/**
 * Tester
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Tester extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		//$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
	}
	
	public function index()
	{
		$this->set_title('Tester')
		->set_icon('mdi mdi-alpha-t-box-outline')
		->set_primary('Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub')
		->set_relation
		(
			'Kd_Urusan, Kd_Bidang, Kd_Unit',
			'Ref_Unit.Kd_Urusan, Ref_Unit.Kd_Bidang, Ref_Unit.Kd_Unit',
			'{Ref_Unit.Kd_Urusan}.{Ref_Unit.Kd_Bidang}.{Ref_Unit.Kd_Unit} - {Ref_Unit.Nm_Unit}'
		)
		->merge_content('{Kd_Urusan_masking}.{Kd_Bidang}.{Kd_Unit}.{Kd_Sub}', 'Kode')
		->column_order('Kd_Urusan_masking')
		->set_alias
		(
			array
			(
				'Kd_Urusan'							=> 'Unit'
			)
		)
		->render('Ref_Sub_Unit');
	}
}
