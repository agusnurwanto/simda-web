<?php namespace Modules\Master\Controllers\Sinkronisasi;
/**
 * Master > Sinkronisasi > Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Penerimaan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta__penerimaan';
	
	public function __construct()
	{
		parent::__construct();
		
		//$this->set_permission(1); // only user with group id 1 can access this module
		$this->set_theme('backend');
	}
	
	public function index()
	{
		$data										= @file_get_contents('http://10.100.1.105/penerimaan/api/result');
		$data										= json_decode($data);
		$prepare									= array();
		
		if($data)
		{
			foreach($data as $key => $val)
			{
				$kd_rek_1							= explode('.', $val->kd_rek2);
				$kd_rek_2							= explode('.', $val->kd_rek2);
				$kd_rek_3							= explode('.', $val->kd_rek3);
				$kd_rek_4							= explode('.', $val->kd_rek4);
				$prepare[]							= array
				(
					'nomor'							=> $val->nomor,
					'nm_unit'						=> ($val->nm_unit ? $val->nm_unit : ''),
					'tgl_masuk'						=> $val->tgl_masuk,
					'nilai'							=> $val->nilai,
					'kode'							=> ($val->kode_rek ? $val->kode_rek : 0),
					'nama_rekening'					=> ($val->nama_rekening ? $val->nama_rekening : ''),
					'kd_rek_1'						=> (isset($kd_rek_1[0]) ? $kd_rek_1[0] : 0),
					'kd_rek_2'						=> (isset($kd_rek_2[1]) ? $kd_rek_2[1] : 0),
					'kd_rek_3'						=> (isset($kd_rek_3[2]) ? $kd_rek_3[2] : 0),
					'kd_rek_4'						=> (isset($kd_rek_4[3]) ? $kd_rek_4[3] : 0)
				);
			}
		}
		
		if($prepare)
		{
			$this->model->truncate($this->_table);
			if($this->model->insert_batch($this->_table, $prepare, sizeof($prepare)))
			{
				return throw_exception(301, 'Berhasil melakukan sinkronisasi penerimaan. Sebanyak <b>' . number_format(sizeof($prepare)) . '</b> data berhasil disimpan.');
			}
		}
		
		return throw_exception(404, 'Tidak dapat melakukan sinkronisasi penerimaan. Data yang diperoleh tidak dapat dieksekusi...');
	}
}
