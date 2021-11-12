<?php namespace Modules\Anggaran\Controllers;
/**
 * Anggaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Anggaran extends \Aksara\Laboratory\Core
{
	public function __construct()
	{
		parent::__construct();
		
		return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
	}
}
