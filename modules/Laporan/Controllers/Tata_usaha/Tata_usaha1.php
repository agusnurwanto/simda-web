<?php namespace Modules\Laporan\Controllers\Tata_usaha;
/**
 * Laporan > Tata Usaha
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Tata_usaha extends \Aksara\Laboratory\Core
{
	private $_title;
	private $_pageSize;
	private $_output;
	
	private $Kd_Urusan;
	private $Kd_Bidang;
	private $Kd_Unit;
	private $Kd_Sub;
	private $Kd_Prog;
	private $ID_Prog;
	private $Kd_Keg;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		$this->unset_action('create, read, update, delete, export, print, pdf');
		
		if('kegiatan' == service('request')->getGet('render') && service('request')->getPost('primary'))
		{
			return $this->_sub_unit();
		}
		
		helper('custom');
		
		$this->report								= new \Modules\Laporan\Models\Tata_usaha();
		
		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null);
		
		list
		(
			$this->Kd_Urusan,
			$this->Kd_Bidang,
			$this->Kd_Unit,
			$this->Kd_Sub,
			$this->Kd_Prog,
			$this->ID_Prog,
			$this->Kd_Keg
		)											= array_pad(explode('.', service('request')->getGet('dropdown')), 7, 0);
	}
	
	public function index()
	{
		$this->set_title('Laporan Tata Usaha')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}
	
	/**
	 * Laporan RKA 2.2.1
	 */
	public function kartu_kendali()
	{
		$params										= array
		(
			'Tahun'									=> get_userdata('year'),
			'Kd_Urusan'								=> $this->Kd_Urusan,
			'Kd_Bidang'								=> $this->Kd_Bidang,
			'Kd_Unit'								=> $this->Kd_Unit,
			'Kd_Sub'								=> $this->Kd_Sub,
			'Kd_Prog'								=> $this->Kd_Prog,
			'ID_Prog'								=> $this->ID_Prog,
			'Kd_Keg'								=> $this->Kd_Keg,
			'D1'									=> date('Y-m-d H:i:s')
		);
		
		$this->_title								= 'Kartu Kendali';
		$this->_pageSize							= '13in 8.5in';
		$this->_output								= $this->laporan->kartu_kendali($params);
		
		/* execute the thread */
		$this->_execute();
	}
	
	/**
	 * Laporan DPA 2.2.1
	 */
	public function realisasi_definitif_kegiatan()
	{
		$params										= array
		(
			'Tahun'									=> get_userdata('year'),
			'Kd_Urusan'								=> $this->Kd_Urusan,
			'Kd_Bidang'								=> $this->Kd_Bidang,
			'Kd_Unit'								=> $this->Kd_Unit,
			'Kd_Sub'								=> $this->Kd_Sub,
			'D1'									=> date('Y-m-d H:i:s')
		);
		
		$this->_title								= 'Realisasi Definitif Kegiatan';
		$this->_pageSize							= '13in 8.5in';
		$this->_output								= $this->laporan->realisasi_definitif_kegiatan($params);
		
		/* execute the thread */
		$this->_execute();
	}
	
	private function _execute()
	{
		if(!(array_filter($this->_output)))
		{
			return throw_exception(404, 'Belum dapat menampilkan laporan yang Anda minta. Pastikan untuk melengkapi kolom yang diminta apabila tersedia...', current_page('../'));
		}
		
		/* prepare object data */
		$data										= array
		(
			'title'									=> $this->_title,
			'results'								=> $this->_output
		);
		
		//print_r($data);exit;
		
		if(in_array(service('request')->getGet('method'), array('embed', 'download', 'export')))
		{
			/**
			 * Method document
			 */
			$this->_output							= view($this->_template, $data);
			
			$this->document							= new \Aksara\Libraries\Document;
			
			$this->document->pageSize($this->_pageSize);
			
			return $this->document->generate($this->_output, $this->_title, service('request')->getGet('method'));
		}
		
		echo view($this->_template, $data);
	}
	
	/**
	 * Daftar laporan yang akan ditampilkan
	 */
	private function _laporan()
	{
		return array
		(
			array
			(
				'user_group'						=> array(1),
				'title'								=> 'Kartu Kendali',
				'description'						=> 'Laporan Kartu Kendali',
				'icon'								=> 'mdi-file-check',
				'color'								=> 'bg-success',
				'placement'							=> 'left',
				'controller'						=> 'kartu_kendali',
				'sub_unit'							=> $this->_sub_unit(true)
			),
			array
			(
				'user_group'						=> null,
				'title'								=> 'Realisasi Definitif Kegiatan',
				'description'						=> 'Laporan Realisasi Definitif Kegiatan',
				'icon'								=> 'mdi-chart-areaspline',
				'color'								=> 'bg-primary',
				'placement'							=> 'left',
				'controller'						=> 'realisasi_definitif_kegiatan',
				'sub_unit'							=> $this->_sub_unit()
			)
		);
	}
	
	private function _sub_unit($has_children = false)
	{
		$this->model->database_config('default');
		
		if('kegiatan' == service('request')->getGet('render') && service('request')->getPost('primary'))
		{
			$this->permission->must_ajax();
			
			list
			(
				$kd_urusan,
				$kd_bidang,
				$kd_unit,
				$kd_sub
			)										= array_pad(explode('.', service('request')->getPost('primary')), 4, 0);
			
			$query									= $this->model->get_where
			(
				'ta_kegiatan',
				array
				(
					'tahun'							=> get_userdata('year'),
					'kd_urusan'						=> $kd_urusan,
					'kd_bidang'						=> $kd_bidang,
					'kd_unit'						=> $kd_unit,
					'kd_sub'						=> $kd_sub
				)
			)
			->result();
			
			$option									= array();
			
			if($query)
			{
				foreach($query as $key => $val)
				{
					$option[]						= array
					(
						'id'						=> $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg,
						
						'text'						=> $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . ' - ' . $val->ket_kegiatan
					);
				}
			}
			
			return make_json
			(
				array
				(
					'data'							=> $option,
					'label'							=> 'Kegiatan',
					'name'							=> 'dropdown',
					'placeholder'					=> 'Silakan pilih kegiatan'
				)
			);
		}
		else
		{
			$query									= $this->model->get_where
			(
				'ref_sub_unit'
			)
			->result();
			
			$option									= '<option value="">Silakan pilih sub unit</option>';
			
			if($query)
			{
				foreach($query as $key => $val)
				{
					$option							.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '">' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . ' - ' . $val->nm_sub_unit . '</option>';
				}
			}
		}
		
		return '
			<div class="form-group">
				<label class="text-muted d-block" for="kegiatan_input">
					Sub Unit
				</label>
				<select name="dropdown" class="form-control" placeholder="Silakan memilih sub unit"' . ($has_children ? ' data-next="' . current_page(null, array('render' => 'kegiatan')) . '"' : null) . '>
					' . $option . '
				</select>
			</div>
		';
	}
}
