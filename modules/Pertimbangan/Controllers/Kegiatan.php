<?php namespace Modules\Pertimbangan\Controllers;
/**
 * Pertimbangan > Kegiatan
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
		$this->unset_action('create, delete');
		
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
		if(1 == service('request')->getGet('tolak'))
		{
			return $this->_tolak();
		}
		
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
		
		$this->set_title('Pertimbangan Kegiatan')
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
			</div>
		')
		->set_icon('mdi mdi-file-document-box-multiple-outline')
		
		->add_action('submit', null, 'Tolak', 'btn btn-danger --confirm-tolak', 'mdi mdi-hand', array('tolak' => 1))
		
		->unset_column('id, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, ID_Prog, id_pengajuan')
		->unset_field('id, id_pengajuan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, nama_kegiatan, status_pertimbangan')
		->unset_view('id, id_pengajuan')
		
		->set_field
		(
			array
			(
				'nilai_pertimbangan'				=> 'price_format',
				'Kd_Prog'							=> 'sprintf',
				'Kd_Keg'							=> 'sprintf'
			)
		)
		->set_field
		(
			'status_pertimbangan',
			'radio',
			array
			(
				0									=> '<span class="badge badge-warning">Usulan</span>',
				1									=> '<span class="badge badge-success">Diterima</span>',
				2									=> '<span class="badge badge-danger">Ditolak</span>'
			)
		)
		/* set field dropdown dan set default selected, karena kode terpecah */
		->set_field('Kd_Keg', 'dropdown, disabled', $this->_kegiatan(), ($selected_item ? $selected_item->Kd_Prog . '.' . $selected_item->ID_Prog . '.' . $selected_item->Kd_Keg : 0))
		//->set_field('nama_kegiatan', 'hyperlink', 'pertimbangan/rinci', array('id_pengajuan_kegiatan' => 'id'))
		
		->merge_content('{Kd_Prog}.{Kd_Keg}', 'Kode')
		->set_validation
		(
			array
			(
				'nilai_pertimbangan'				=> 'required|numeric'
			)
		)
		->set_default
		(
			array
			(
				'id_pengajuan'						=> $this->_pengajuan->id,
				'nilai_pertimbangan'				=> $this->_nilai_pertimbangan()
			)
		)
		->where
		(
			array
			(
				'id_pengajuan'						=> $this->_pengajuan->id
			)
		)
		->set_alias
		(
			array
			(
				'Kd_Keg'							=> 'Kegiatan',
				//'nilai_pertimbangan'				=> 'Nilai',
				'status_pertimbangan'				=> 'Status'
			)
		)
		->render($this->_table);
	}
	
	private function _tolak()
	{
		if($this->model->update($this->_table, array('nilai_pertimbangan' => 0, 'status_pertimbangan' => 2), array('id' => service('request')->getGet('id')), 1))
		{
			return throw_exception(301, 'Rekomendasi yang dipilih telah ditolak');
		}
		
		return throw_exception(404, 'Rekomendasi yang dipilih tidak tersedia. Penolakan dibatalkan...');
	}
	
	private function _nilai_pertimbangan()
	{
		if(service('request')->getPost('token') && service('request')->getPost('nilai_pertimbangan'))
		{
			$query									= service('request')->getPost('nilai_pertimbangan');
		}
		else
		{
			$query									= $this->model->select('nilai_pertimbangan')->get_where
			(
				'ta__pengajuan_kegiatan',
				array
				(
					'id'							=> service('request')->getGet('id')
				)
			)
			->row('nilai_pertimbangan');
			
			if(!$query)
			{
				$query								= $this->model->select_sum('nilai_rekomendasi')->get_where
				(
					'ta__pengajuan_rinci',
					array
					(
						'id_pengajuan_kegiatan'		=> service('request')->getGet('id'),
						'status_rekomendasi'		=> 1
					)
				)
				->row('nilai_rekomendasi');
			}
		}
		
		return $query;
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
		
		$query										= $this->model->select
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
	
	private function _connector()
	{
		/* get sql server connection */
		$connection									= $this->model->get_where('ref__koneksi', array('tahun' => date('Y')), 1)->row();
		
		/* check if connection is found */
		if(!$connection)
		{
			/* otherwise, throw the exception */
			return false;
		}
		
		/* define config */
		$config										= array
		(
			'hostname' 								=> $this->encryption->decrypt($connection->hostname) . ($this->encryption->decrypt($connection->port) ? ',' . $this->encryption->decrypt($connection->port) : null),
			'username'								=> $this->encryption->decrypt($connection->username),
			'password' 								=> $this->encryption->decrypt($connection->password),
			'database' 								=> $this->encryption->decrypt($connection->database),
			'dbdriver' 								=> $connection->driver
		);
		
		/* load the new database connection with the defined config */
		return $this->load->database($config, TRUE);
	}
}
