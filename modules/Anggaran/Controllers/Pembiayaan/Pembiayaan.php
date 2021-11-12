<?php namespace Modules\Anggaran\Controllers\Pembiayaan;
/**
 * Anggaran > Pembiayaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pembiayaan extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();

        $this->set_permission();
        $this->set_theme('backend');
		
		// must be called after set_theme()
        $this->database_config('default');

		return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
	}
}
