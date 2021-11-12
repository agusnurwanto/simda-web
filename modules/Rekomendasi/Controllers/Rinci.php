<?php namespace Modules\Rekomendasi\Controllers;
/**
 * Rekomendasi > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta__pengajuan_rinci';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		$this->unset_action('create, read, delete');
		
		$this->_kegiatan							= $this->model->get_where
		(
			'ta__pengajuan_kegiatan',
			array
			(
				'id'								=> service('request')->getGet('id_pengajuan_kegiatan')
			),
			1
		)
		->row();
		
		if(!$this->_kegiatan)
		{
			return throw_exception(301, 'Silakan memilih kegiatan terlebih dahulu...', base_url('rekomendasi/kegiatan'));
		}
	}
	
	public function index()
	{
		if(1 == service('request')->getGet('tolak'))
		{
			return $this->_tolak();
		}
		
		/* mendapatkan kode untuk default selected rekening ketika update */
		$selected_item								= $this->model->select('Kd_Rek_1, Kd_Rek_2, Kd_Rek_3, Kd_Rek_4, Kd_Rek_5')->get_where
		(
			$this->_table,
			array
			(
				'id'								=> service('request')->getGet('id')
			)
		)
		->row();
		
		$this->set_title('Rincian Rekomendasi')
		->set_description
		('
			<div class="row text-sm">
				<label class="control-label col-4 col-md-3 text-sm text-muted text-uppercase mb-0">
					Kegiatan
				</label>
				<label class="control-label col-8 col-md-9 text-sm text-uppercase mb-0">
					' . $this->_header() . '
				</label>
			</div>
		')
		->set_icon('mdi mdi-file-replace-outline')
		
		->add_action('submit', null, 'Tolak', 'btn btn-danger --confirm-tolak', 'mdi mdi-hand', array('tolak' => 1))
		
		->set_breadcrumb
		(
			array
			(
				'rekomendasi/sub_unit'				=> 'Sub Unit',
				'..'								=> 'Rekomendasi',
				'kegiatan'							=> 'Kegiatan'
			)
		)
		
		->unset_column('id, id_pengajuan_kegiatan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg')
		->unset_field('id, id_pengajuan_kegiatan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg, Kd_Rek_1, Kd_Rek_2, Kd_Rek_3, Kd_Rek_4, Nm_Rek_5, status_rekomendasi')
		->unset_view('id, id_pengajuan_kegiatan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg')
		
		->set_field
		(
			array
			(
				'nilai'								=> 'price_format, disabled',
				'nilai_rekomendasi'					=> 'price_format',
				'Kd_Rek_4'							=> 'sprintf',
				'Kd_Rek_5'							=> 'sprintf'
			)
		)
		->set_field
		(
			'status_rekomendasi',
			'radio',
			array
			(
				0									=> '<span class="badge badge-warning">Usulan</span>',
				1									=> '<span class="badge badge-success">Diterima</span>',
				2									=> '<span class="badge badge-danger">Ditolak</span>'
			)
		)
		
		->set_field('Kd_Rek_5', 'dropdown, disabled', $this->_rekening(), ($selected_item ? $selected_item->Kd_Rek_1 . '.' . $selected_item->Kd_Rek_2 . '.' . $selected_item->Kd_Rek_3 . '.' . $selected_item->Kd_Rek_4 . '.' . $selected_item->Kd_Rek_5 : 0))
		//->set_field('Nm_Rek_5', 'hyperlink', 'pengajuan/children', array('id_pengajuan_rinci' => 'id'))
		
		->merge_content('{Kd_Rek_1}.{Kd_Rek_2}.{Kd_Rek_3}.{Kd_Rek_4}.{Kd_Rek_5}', 'Kode')
		->set_validation
		(
			array
			(
				'nilai_rekomendasi'					=> 'required|number_format'
			)
		)
		->set_default
		(
			array
			(
				'id_pengajuan_kegiatan'				=> $this->_kegiatan->id,
				'status_rekomendasi'				=> 1
			)
		)
		->where
		(
			array
			(
				'id_pengajuan_kegiatan'				=> $this->_kegiatan->id
			)
		)
		->set_alias
		(
			array
			(
				'Kd_Rek_5'							=> 'Rekening',
				'Nm_Rek_5'							=> 'Rekening',
				'status_rekomendasi'				=> 'Status'
			)
		)
		->render($this->_table);
	}
	
	private function _tolak()
	{
		if($this->model->update($this->_table, array('nilai_rekomendasi' => 0, 'status_rekomendasi' => 2), array('id' => service('request')->getGet('id')), 1))
		{
			return throw_exception(301, 'Pengajuan yang dipilih telah ditolak');
		}
		
		return throw_exception(404, 'Pengajuan yang dipilih tidak tersedia. Penolakan dibatalkan...');
	}
	
	private function _rekening()
	{
		$this->database_config('default');
		
		$query										= $this->model->select
		('
			Ta_Belanja.*,
			Ref_Rek_5.Nm_Rek_5
		')
		->join
		(
			'Ref_Rek_5',
			'Ref_Rek_5.Kd_Rek_1 = Ta_Belanja.Kd_Rek_1 AND Ref_Rek_5.Kd_Rek_2 = Ta_Belanja.Kd_Rek_2 AND Ref_Rek_5.Kd_Rek_3 = Ta_Belanja.Kd_Rek_3 AND Ref_Rek_5.Kd_Rek_4 = Ta_Belanja.Kd_Rek_4 AND Ref_Rek_5.Kd_Rek_5 = Ta_Belanja.Kd_Rek_5'
		)
		->get_where
		(
			'Ta_Belanja',
			array
			(
				'Kd_Urusan'							=> $this->_kegiatan->Kd_Urusan,
				'Kd_Bidang'							=> $this->_kegiatan->Kd_Bidang,
				'Kd_Unit'							=> $this->_kegiatan->Kd_Unit,
				'Kd_Sub'							=> $this->_kegiatan->Kd_Sub,
				'Kd_Prog'							=> $this->_kegiatan->Kd_Prog,
				'ID_Prog'							=> $this->_kegiatan->ID_Prog,
				'Kd_Keg'							=> $this->_kegiatan->Kd_Keg
			)
		)
		->result();
		
		$output										= array();
		if($query)
		{
			foreach($query as $key => $val)
			{
				//$kode								= $val->Kd_Urusan . '.' . $val->Kd_Bidang . '.' . $val->Kd_Unit . '.' . $val->Kd_Sub . '.' . $val->Kd_Prog . '.' . $val->ID_Prog . '.' . $val->Kd_Keg . '.' . $val->Kd_Rek_1 . '.' . $val->Kd_Rek_2 . '.' . $val->Kd_Rek_3 . '.' . $val->Kd_Rek_4 . '.' . $val->Kd_Rek_5;
				$kode								= $val->Kd_Rek_1 . '.' . $val->Kd_Rek_2 . '.' . $val->Kd_Rek_3 . '.' . $val->Kd_Rek_4 . '.' . $val->Kd_Rek_5;
				$output[$kode]						= $kode . ' - ' . $val->Nm_Rek_5;
			}
		}
		
		return $output;
	}
	
	private function _header()
	{
		$this->database_config('default');
		
		$query										= $this->model->select
		('
			Ket_Kegiatan
		')
		->get_where
		(
			'Ta_Kegiatan',
			array
			(
				'Kd_Urusan'							=> $this->_kegiatan->Kd_Urusan,
				'Kd_Bidang'							=> $this->_kegiatan->Kd_Bidang,
				'Kd_Unit'							=> $this->_kegiatan->Kd_Unit,
				'Kd_Sub'							=> $this->_kegiatan->Kd_Sub,
				'Kd_Prog'							=> $this->_kegiatan->Kd_Prog,
				'ID_Prog'							=> $this->_kegiatan->ID_Prog,
				'Kd_Keg'							=> $this->_kegiatan->Kd_Keg
			)
		)
		->row('Ket_Kegiatan');
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
