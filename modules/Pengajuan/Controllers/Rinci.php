<?php namespace Modules\Pengajuan\Controllers;
/**
 * Pengajuan > Rinci
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
			return throw_exception(301, 'Silakan memilih kegiatan terlebih dahulu...', base_url('pengajuan/kegiatan'));
		}
		
		if(service('request')->getPost('get_content'))
		{
			return $this->_get_content(service('request')->getPost('primary'));
		}
	}
	
	public function index()
	{
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
		
		/* set the default post data */
		if(service('request')->getPost('token') && in_array($this->_method, array('create', 'update')))
		{
			$data									= explode('.', service('request')->getPost('Kd_Rek_5'));
			if(sizeof($data) !== 5)
			{
				//
			}
			$this->set_default
			(
				array
				(
					'Kd_Urusan'						=> $this->_kegiatan->Kd_Urusan,
					'Kd_Bidang'						=> $this->_kegiatan->Kd_Bidang,
					'Kd_Unit'						=> $this->_kegiatan->Kd_Unit,
					'Kd_Sub'						=> $this->_kegiatan->Kd_Sub,
					'Kd_Prog'						=> $this->_kegiatan->Kd_Prog,
					'ID_Prog'						=> $this->_kegiatan->ID_Prog,
					'Kd_Keg'						=> $this->_kegiatan->Kd_Keg,
					'Kd_Rek_1'						=> $data[0],
					'Kd_Rek_2'						=> $data[1],
					'Kd_Rek_3'						=> $data[2],
					'Kd_Rek_4'						=> $data[3],
					'Kd_Rek_5'						=> $data[4],
					'Nm_Rek_5'						=> $this->_connector()->select('Ref_Rek_5.Nm_Rek_5')
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
							'Ta_Belanja.Kd_Urusan'	=> $this->_kegiatan->Kd_Urusan,
							'Ta_Belanja.Kd_Bidang'	=> $this->_kegiatan->Kd_Bidang,
							'Ta_Belanja.Kd_Unit'	=> $this->_kegiatan->Kd_Unit,
							'Ta_Belanja.Kd_Sub'		=> $this->_kegiatan->Kd_Sub,
							'Ta_Belanja.Kd_Prog'	=> $this->_kegiatan->Kd_Prog,
							'Ta_Belanja.ID_Prog'	=> $this->_kegiatan->ID_Prog,
							'Ta_Belanja.Kd_Keg'		=> $this->_kegiatan->Kd_Keg,
							'Ta_Belanja.Kd_Rek_1'	=> $data[0],
							'Ta_Belanja.Kd_Rek_2'	=> $data[1],
							'Ta_Belanja.Kd_Rek_3'	=> $data[2],
							'Ta_Belanja.Kd_Rek_4'	=> $data[3],
							'Ta_Belanja.Kd_Rek_5'	=> $data[4]
						),
						1
					)
					->row('Nm_Rek_5')
				)
			);
		}
		
		$this->set_title('Rincian Pengajuan')
		->set_description
		('
			<div class="row text-sm">
				<label class="control-label col-4 col-md-3 text-sm text-muted text-uppercase mb-0">
					Kegiatan
				</label>
				<label class="control-label col-8 col-md-9 text-sm text-uppercase mb-0">
					' . $this->_header()->Kd_Prog . '.' . $this->_header()->Kd_Keg . ' ' . $this->_header()->Ket_Kegiatan . '
				</label>
			</div>
		')
		->set_icon('mdi mdi-file-replace-outline')
		
		->set_breadcrumb
		(
			array
			(
				'pengajuan/sub_unit'				=> 'Sub Unit',
				'..'								=> 'Pengajuan',
				'kegiatan'							=> 'Kegiatan'
			)
		)
		
		->unset_column('id, id_pengajuan_kegiatan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg, nilai_rekomendasi')
		->unset_field('id, id_pengajuan_kegiatan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg, Kd_Rek_1, Kd_Rek_2, Kd_Rek_3, Kd_Rek_4, Nm_Rek_5, nilai_rekomendasi, status_rekomendasi')
		->unset_view('id, id_pengajuan_kegiatan, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg')
		->unset_action('print, export, pdf')
		
		->add_action('toolbar', '../../laporan/administrasi/surat_pengajuan', 'Surat Pengajuan', 'btn-warning ajax', 'mdi mdi-cloud-print-outline', array('pengajuan' => service('request')->getGet('id_pengajuan'), 'method' => 'embed'), true)
		->add_action('toolbar', '../../laporan/administrasi/lampiran_pengajuan', 'Lampiran Pengajuan', 'btn-success ajax', 'mdi mdi-cloud-print-outline', array('pengajuan' => service('request')->getGet('id_pengajuan'), 'method' => 'embed'), true)
		
		->set_field('Kd_Rek_5', 'dropdown', $this->_rekening(), ($selected_item ? $selected_item->Kd_Rek_1 . '.' . $selected_item->Kd_Rek_2 . '.' . $selected_item->Kd_Rek_3 . '.' . $selected_item->Kd_Rek_4 . '.' . $selected_item->Kd_Rek_5 : 0))
		->set_field
		(
			array
			(
				'nilai'								=> 'price_format',
				'Kd_Rek_4'							=> 'sprintf',
				'Kd_Rek_5'							=> 'sprintf'
			)
		)
		->set_field('Nm_Rek_5', 'hyperlink', 'pengajuan/children', array('id_pengajuan_rinci' => 'id'))
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
		
		->add_class('Kd_Rek_5', 'get-dropdown-content')
		
		->merge_content('{Kd_Rek_1}.{Kd_Rek_2}.{Kd_Rek_3}.{Kd_Rek_4}.{Kd_Rek_5}', 'Kode')
		->set_validation
		(
			array
			(
				'Kd_Rek_5'							=> 'callback_validate_dropdown',
				'nilai'								=> 'required|number_format'
			)
		)
		->set_default
		(
			array
			(
				'id_pengajuan_kegiatan'				=> $this->_kegiatan->id
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
	
	public function validate_dropdown($value = 0)
	{
		$valid										= explode('.', $value);
		
		if(sizeof($valid) != 5)
		{
			return 'Rekening yang Anda pilih tidak tersedia';
		}
		
		$this->database_config('default');
		
		$valid										= $this->model->get_where
		(
			'Ref_Rek_5',
			array
			(
				'Kd_Rek_1'							=> $valid[0],
				'Kd_Rek_2'							=> $valid[1],
				'Kd_Rek_3'							=> $valid[2],
				'Kd_Rek_4'							=> $valid[3],
				'Kd_Rek_5'							=> $valid[4]
			)
		)
		->row();
		
		if(!$valid)
		{
			return 'Rekening yang Anda pilih tidak tersedia';
		}
		
		return true;
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
			Kd_Prog,
			Kd_Keg,
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
		->row();
		//print_r($query);exit;
		return $query;
	}
	
	private function _get_content($params = 0)
	{
		$this->permission->must_ajax();
		
		$params										= explode('.', $params);
		if(sizeof($params) !== 5)
		{
			$html									= '<div class="alert alert-warning">Rekening yang Anda pilih tidak tersedia dalam database</div>';
		}
		else
		{
			$this->database_config('default');
			
			$anggaran								= $this->model->query
			('
				SELECT
					SUM (Total) AS anggaran
				FROM
					Ta_RASK_Arsip
				WHERE
				(
					Kd_Perubahan =
					(
						SELECT
							MAX (Kd_Perubahan) AS Expr1
						FROM
							Ta_RASK_Arsip AS Ta_RASK_Arsip_1
					)
				)
				AND Kd_Urusan = ' . $this->_kegiatan->Kd_Urusan . '
				AND Kd_Bidang = ' . $this->_kegiatan->Kd_Bidang . '
				AND Kd_Unit = ' . $this->_kegiatan->Kd_Unit . '
				AND Kd_Sub = ' . $this->_kegiatan->Kd_Sub . '
				AND Kd_Prog = ' . $this->_kegiatan->Kd_Prog . '
				AND ID_Prog = ' . $this->_kegiatan->ID_Prog . '
				AND Kd_Keg = ' . $this->_kegiatan->Kd_Keg . '
				AND Kd_Rek_1 = ' . $params[0] . '
				AND Kd_Rek_2 = ' . $params[1] . '
				AND Kd_Rek_3 = ' . $params[2] . '
				AND Kd_Rek_4 = ' . $params[3] . '
				AND Kd_Rek_5 = ' . $params[4] . '
				GROUP BY
					Kd_Urusan,
					Kd_Bidang,
					Kd_Unit,
					Kd_Sub,
					Kd_Prog,
					ID_Prog,
					Kd_Keg,
					Kd_Rek_1,
					Kd_Rek_2,
					Kd_Rek_3,
					Kd_Rek_4,
					Kd_Rek_5
			')
			->row('anggaran');
			
			$rencana								= 0 /*$this->model->query
			('
				SELECT
					SUM (Total) AS rencana
				FROM
					Ta_Rencana_Arsip
				WHERE
				(
					Kd_Perubahan =
					(
						SELECT
							MAX (Kd_Perubahan) AS Expr1
						FROM
							Ta_Rencana_Arsip AS Ta_Rencana_Arsip_1
					)
				)
				AND Kd_Urusan = ' . $this->_kegiatan->Kd_Urusan . '
				AND Kd_Bidang = ' . $this->_kegiatan->Kd_Bidang . '
				AND Kd_Unit = ' . $this->_kegiatan->Kd_Unit . '
				AND Kd_Sub = ' . $this->_kegiatan->Kd_Sub . '
				AND Kd_Prog = ' . $this->_kegiatan->Kd_Prog . '
				AND ID_Prog = ' . $this->_kegiatan->ID_Prog . '
				AND Kd_Keg = ' . $this->_kegiatan->Kd_Keg . '
				AND Kd_Rek_1 = ' . $params[0] . '
				AND Kd_Rek_2 = ' . $params[1] . '
				AND Kd_Rek_3 = ' . $params[2] . '
				AND Kd_Rek_4 = ' . $params[3] . '
				AND Kd_Rek_5 = ' . $params[4] . '
				GROUP BY
					Kd_Urusan,
					Kd_Bidang,
					Kd_Unit,
					Kd_Sub,
					Kd_Prog,
					ID_Prog,
					Kd_Keg,
					Kd_Rek_1,
					Kd_Rek_2,
					Kd_Rek_3,
					Kd_Rek_4,
					Kd_Rek_5
			')
			->row('rencana')*/;
			
			$html									= '
				<div class="alert alert-info">
					<div class="row">
						<label class="col-4 d-block">
							Rencana
						</label>
						<label class="col-8 d-block font-weight-bold">
							Rp. ' . number_format($rencana) . '
						</label>
						<label class="col-4 d-block">
							Anggaran
						</label>
						<label class="col-8 d-block font-weight-bold">
							Rp. ' . number_format($anggaran) . '
						</label>
					</div>
				</div>
			';
		}
		return make_json
		(
			array
			(
				'html'								=> $html
			)
		);
	}
}
