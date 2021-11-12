<?php namespace Modules\Anggaran\Controllers;
/**
 * Anggaran > Kegiatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Berkas extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta__kegiatan';
	function __construct()
	{
		parent::__construct();
        /*if(in_array(get_userdata('group_id'), array(9, 10)))
        {
            $this->_sub_kegiatan					= get_userdata('sub_level_1');
        }
		else
		{
			$this->_sub_kegiatan					= $this->input->get('sub_kegiatan');
		}
		
		if(!$this->_sub_kegiatan)
		{
			return throw_exception(301, 'silakan memilih Sub Kegiatan terlebih dahulu', go_to('pendapatan/sub_kegiatan'));
		}
		elseif(!$this->input->get('id'))
		{
			return throw_exception(301, 'silakan memilih Pendapatan terlebih dahulu', go_to('pendapatan'));
		}
		
		$this->_primary								= $this->input->get('id');*/
		$this->_kd_urusan							= service('request')->getGet('urusan');
		$this->_kd_bidang							= service('request')->getGet('bidang');
		$this->_kd_unit								= service('request')->getGet('unit');
		$this->_kd_sub								= service('request')->getGet('sub_unit');
		$this->_kd_prog								= service('request')->getGet('program');
		$this->_id_prog								= service('request')->getGet('id_prog');
		$this->_kd_keg								= service('request')->getGet('kegiatan');
		
		$this->set_permission();
		$this->set_theme('backend');
		$this->parent_module('kegiatan');
		$this->set_upload_path('kegiatan');
		$this->insert_on_update_fail(true);
	}
	
	public function index()
	{
		$this
		->set_method('update')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg')
		->set_field
		(
			array
			(
				'berkas_rka'						=> 'files',
				'berkas_dpa'						=> 'files'
			)
		)
		->set_alias
		(
			array
			(
				'berkas_rka'						=> 'Berkas RKA',
				'berkas_dpa'						=> 'Berkas DPA'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> $this->_kd_urusan,
				'kd_bidang'							=> $this->_kd_bidang,
				'kd_unit'							=> $this->_kd_unit,
				'kd_sub'							=> $this->_kd_sub,
				'kd_prog'							=> $this->_kd_prog,
				'id_prog'							=> $this->_id_prog,
				'kd_keg'							=> $this->_kd_keg
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> $this->_kd_urusan,
				'kd_bidang'							=> $this->_kd_bidang,
				'kd_unit'							=> $this->_kd_unit,
				'kd_sub'							=> $this->_kd_sub,
				'kd_prog'							=> $this->_kd_prog,
				'id_prog'							=> $this->_id_prog,
				'kd_keg'							=> $this->_kd_keg
			)
		)
		->render($this->_table);
	}
}