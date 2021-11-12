<?php namespace Modules\Apis\Controllers;
/**
 * APIs > Anggaran
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
		// must be called after set_theme()
		$this->database_config('default');
	}
	
	public function index()
	{
		/*list
		(
			$kd_urusan,
			$kd_bidang,
			$kd_unit,
			$kd_sub,
			$kd_prog,
			$kd_keg,
			$kd_keg_sub
		)											= array_pad(explode('.', $this->input->post('kode_sub_kegiatan')), 6, null);*/
		$tahun											= (service('request')->getPost('tahun') ? service('request')->getPost('tahun') : date("Y"));
		//$periode_awal								= $this->input->post('periode_awal');
		//$periode_akhir								= $this->input->post('periode_akhir');
		//print_r($tahun);exit;
		$query										= $this->model->query
		('
			SELECT
				ta_rask_arsip.kd_rek_1,
				ta_rask_arsip.kd_rek_2,
				ta_rask_arsip.kd_rek_3,
				ref_rek_3.nm_rek_3,
				SUM (ta_rask_arsip.total) AS anggaran
			FROM
				ta_rask_arsip
			INNER JOIN ref_rek_3 ON ta_rask_arsip.kd_rek_1 = ref_rek_3.kd_rek_1
			AND ta_rask_arsip.kd_rek_2 = ref_rek_3.kd_rek_2
			AND ta_rask_arsip.kd_rek_3 = ref_rek_3.kd_rek_3
			WHERE
				ta_rask_arsip.tahun = ' . $tahun . '
			AND ta_rask_arsip.kd_perubahan = (
				SELECT
					MAX (kd_perubahan)
				FROM
					ta_rask_arsip
			)
			GROUP BY
				ta_rask_arsip.kd_rek_1,
				ta_rask_arsip.kd_rek_2,
				ta_rask_arsip.kd_rek_3,
				ref_rek_3.nm_rek_3
			ORDER BY
				ta_rask_arsip.kd_rek_1 ASC,
				ta_rask_arsip.kd_rek_2 ASC,
				ta_rask_arsip.kd_rek_3 ASC
		')
		->result();
		
		$output										= array();
		
		if($query)
		{
			foreach($query as $key => $val)
			{
				$output[]							= array
				(
					'rekening_1'					=> $val->kd_rek_1,
					'rekening_2'					=> $val->kd_rek_2,
					'rekening_3'					=> $val->kd_rek_3,
					'nama_rekening_3'				=> $val->nm_rek_3,
					'anggaran'						=> $val->anggaran
				);
			}
		}
		
		return make_json($output);
	}
}
