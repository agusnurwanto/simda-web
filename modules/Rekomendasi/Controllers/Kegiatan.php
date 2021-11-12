<?php namespace Modules\Rekomendasi\Controllers;
/**
 * Rekomendasi > Kegiatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Kegiatan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta__pengajuan_kegiatan';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		$this->unset_action('create, read, update, delete');
		
		$this->_pengajuan							= $this->model->get_where
		(
			'ta__pengajuan',
			array
			(
				'id'								=> service('request')->getGet('id_pengajuan')
			),
			1
		)
		->row();
		
		if(!$this->_pengajuan)
		{
			return throw_exception(301, 'Silakan memilih sub unit terlebih dahulu...', base_url('pengajuan'));
		}
	}
	
	public function index()
	{
		/* mendapatkan kode untuk default selected kegiatan ketika update */
		$selected_item								= $this->model->select('Kd_Prog, ID_Prog, Kd_Keg')->get_where
		(
			$this->_table,
			array
			(
				'id'								=> service('request')->getGet('id')
			)
		)
		->row();
		
		/* set the default post data */
		if(service('request')->getPost('token') && in_array($this->_method, array('create', 'update')))
		{
			$data									= explode('.', service('request')->getPost('Kd_Keg'));
			if(sizeof($data) !== 3)
			{
				//
			}
			
			$this->set_default
			(
				array
				(
					'Kd_Urusan'						=> $this->_pengajuan->Kd_Urusan,
					'Kd_Bidang'						=> $this->_pengajuan->Kd_Bidang,
					'Kd_Unit'						=> $this->_pengajuan->Kd_Unit,
					'Kd_Sub'						=> $this->_pengajuan->Kd_Sub,
					'Kd_Prog'						=> $data[0],
					'ID_Prog'						=> $data[1],
					'Kd_Keg'						=> $data[2],
					'nama_kegiatan'					=> $this->_connector()->select('Ket_Kegiatan')->get_where
					(
						'Ta_Kegiatan',
						array
						(
							'Kd_Urusan'				=> $this->_pengajuan->Kd_Urusan,
							'Kd_Bidang'				=> $this->_pengajuan->Kd_Bidang,
							'Kd_Unit'				=> $this->_pengajuan->Kd_Unit,
							'Kd_Sub'				=> $this->_pengajuan->Kd_Sub,
							'Kd_Prog'				=> $data[0],
							'ID_Prog'				=> $data[1],
							'Kd_Keg'				=> $data[2]
						),
						1
					)
					->row('Ket_Kegiatan')
				)
			);
		}
		
		$this->set_title('Pengajuan Kegiatan')
		->set_description
		('
			<div class="row text-sm">
				<label class="control-label col-md-4 col-4 text-sm text-muted text-uppercase no-margin">
					Sub Unit
				</label>
				<label class="control-label col-md-8  col-8 text-sm text-uppercase no-margin">
					' . $this->_header() . '
				</label>
			</div>
		')
		->set_icon('mdi mdi-file-document-box-multiple-outline')
		
		->set_breadcrumb
		(
			array
			(
				'../rekomendasi/sub_unit'			=> 'Sub Unit',
				'..'								=> 'Rekomendasi'
			)
		)
		
		->unset_column('id, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, ID_Prog, id_pengajuan, status_pertimbangan')
		->unset_field('id, id_pengajuan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, nama_kegiatan, status_pertimbangan')
		->unset_view('id, id_pengajuan, status_pertimbangan')
		
		->set_field
		(
			array
			(
				'nilai_pertimbangan'				=> 'price_format',
				'Kd_Prog'							=> 'sprintf',
				'Kd_Keg'							=> 'sprintf'
			)
		)
		
		/* set field dropdown dan set default selected, karena kode terpecah */
		->set_field('Kd_Keg', 'dropdown', $this->_kegiatan(), ($selected_item ? $selected_item->Kd_Prog . '.' . $selected_item->ID_Prog . '.' . $selected_item->Kd_Keg : 0))
		->set_field('nama_kegiatan', 'hyperlink', 'rekomendasi/rinci', array('id_pengajuan_kegiatan' => 'id'))
		
		->merge_content('{Kd_Prog}.{Kd_Keg}', 'Kode')
		->set_validation
		(
			array
			(
				'Kd_Keg'							=> 'callback_validate_dropdown'
			)
		)
		->set_default
		(
			array
			(
				'id_pengajuan'						=> $this->_pengajuan->id
			)
		)
		->where
		(
			array
			(
				'id_pengajuan'						=> $this->_pengajuan->id
			)
		)
		->set_alias('Kd_Keg', 'Kegiatan')
		->render($this->_table);
	}
	
	public function validate_dropdown($value = 0)
	{
		$valid										= explode('.', $value);
		
		if(sizeof($valid) != 3)
		{
			return 'Kegiatan yang Anda pilih tidak tersedia';
		}
		
		$this->database_config('default');
		
		$valid										= $this->model->get_where
		(
			'Ta_Kegiatan',
			array
			(
				'Kd_Urusan'							=> $this->_pengajuan->Kd_Urusan,
				'Kd_Bidang'							=> $this->_pengajuan->Kd_Bidang,
				'Kd_Unit'							=> $this->_pengajuan->Kd_Unit,
				'Kd_Sub'							=> $this->_pengajuan->Kd_Sub,
				'Kd_Prog'							=> $valid[0],
				'ID_Prog'							=> $valid[1],
				'Kd_Keg'							=> $valid[2]
			)
		)
		->row();
		
		if(!$valid)
		{
			return 'Kegiatan yang Anda pilih tidak tersedia';
		}
		
		return true;
	}
	
	private function _kegiatan()
	{
		$this->database_config('default');
		
		$query										= $this->model->get_where
		(
			'Ta_Kegiatan',
			array
			(
				'Kd_Urusan'							=> $this->_pengajuan->Kd_Urusan,
				'Kd_Bidang'							=> $this->_pengajuan->Kd_Bidang,
				'Kd_Unit'							=> $this->_pengajuan->Kd_Unit,
				'Kd_Sub'							=> $this->_pengajuan->Kd_Sub
			)
		)
		->result();
		
		$output										= array();
		if($query)
		{
			foreach($query as $key => $val)
			{
				//$kode								= $val->Kd_Urusan . '.' . $val->Kd_Bidang . '.' . $val->Kd_Unit . '.' . $val->Kd_Sub . '.' . $val->Kd_Prog . '.' . $val->ID_Prog . '.' . $val->Kd_Keg;
				$kode								= $val->Kd_Prog . '.' . $val->ID_Prog . '.' . $val->Kd_Keg;
				$output[$kode]						= $val->Kd_Prog . '.' . $val->Kd_Keg . ' - ' . $val->Ket_Kegiatan;
			}
		}
		
		return $output;
	}
	
	private function _header()
	{
		$this->database_config('default');
		
		$query										= $this->select
		('
			Nm_Sub_unit
		')
		->get_where
		(
			'Ref_Sub_Unit',
			array
			(
				'Kd_Urusan'							=> $this->_pengajuan->Kd_Urusan,
				'Kd_Bidang'							=> $this->_pengajuan->Kd_Bidang,
				'Kd_Unit'							=> $this->_pengajuan->Kd_Unit,
				'Kd_Sub'							=> $this->_pengajuan->Kd_Sub
			)
		)
		->row('Nm_Sub_unit');
		//print_r($query);exit;
		return $query;
	}
}
