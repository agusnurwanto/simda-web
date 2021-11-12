<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Pembukuan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pembukuan extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Pembukuan/basis
	 */
    public function rekening($params)
    {
		$query										= $this->query
		(
			'BEGIN SET NOCOUNT ON EXEC RptLRA_SumberDana ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END',
			array
			(
				2021, // Tahun
				1, // Kd_Urusan
				1, // Kd_Bidang
				1, // Kd_Unit
				1, // Kd_Sub
				'', // Kd_Prog
				'', // Id_Prog
				'', // Kd_Keg
				4, // Level
				'2021-01-01', // D1
				'2021-12-31' // D2
			)
		)
		->result();

        print_r($query); die;
    }

}
