<?php namespace Modules\Laporan\Controllers\Anggaran;
/**
 * Laporan > Anggaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Anggaran extends \Aksara\Laboratory\Core
{
	private $_title;
	private $_pageSize;
	private $_output;

	private $kd_urusan;
	private $kd_bidang;
	private $kd_unit;
	private $kd_sub;
	private $kd_prog;
	private $id_prog;
	private $kd_keg;
	
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
		
		$this->report								= new \Modules\Laporan\Models\Anggaran();
		
		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null);
		
		list
		(
			$this->kd_urusan,
			$this->kd_bidang,
			$this->kd_unit,
			$this->kd_sub,
			$this->kd_prog,
			$this->id_prog,
			$this->kd_keg
		)											= array_pad(explode('.', service('request')->getGet('dropdown')), 7, 0);
	}
	
	public function index()
	{
		$this->set_title('Laporan Anggaran')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}
	
	/**
	 * Laporan RKA 2.2.1
	 */
	public function rka_221()
	{
		$params										= array
		(
			'tahun'									=> get_userdata('year'),
			'kd_urusan'								=> $this->kd_urusan,
			'kd_bidang'								=> $this->kd_bidang,
			'kd_unit'								=> $this->kd_unit,
			'kd_sub'								=> $this->kd_sub,
			'kd_prog'								=> $this->kd_prog,
			'id_prog'								=> $this->id_prog,
			'kd_keg'								=> $this->kd_keg,
			'kd_perubahan'							=> service('request')->getGet('kd_perubahan')
		);
		
		$this->_title								= 'RKA 2.2.1';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->laporan->rka_221($params);
		
		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}
		
		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();
		
		$shortlink									= $this->miscellaneous->shortlink_generator(current_page());
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);
		
		/* execute the thread */
		$this->_execute();
	}
	
	/**
	 * Laporan DPA 2.2.1
	 */
	public function dpa_221()
	{
		$params										= array
		(
			'tahun'									=> get_userdata('year'),
			'kd_urusan'								=> $this->kd_urusan,
			'kd_bidang'								=> $this->kd_bidang,
			'kd_unit'								=> $this->kd_unit,
			'kd_sub'								=> $this->kd_sub,
			'kd_prog'								=> $this->kd_prog,
			'id_prog'								=> $this->id_prog,
			'kd_keg'								=> $this->kd_keg
		);
		
		$this->_title								= 'DPA 2.2.1';
		$this->_pageSize							= (5 == service('request')->getGet('kd_perubahan') || 6 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->laporan->dpa_221($params);
		
		if(5 == service('request')->getGet('kd_perubahan') || 6 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}
		
		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();
		
		$shortlink									= $this->miscellaneous->shortlink_generator(current_page());
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);
		
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
				'title'								=> 'RKA 2.2.1',
				'description'						=> 'Laporan Rencana Kinerja dan Anggaran 2.2.1',
				'icon'								=> 'mdi-file-document',
				'color'								=> 'bg-success',
				'placement'							=> 'left',
				'controller'						=> 'rka_221',
				'sub_unit'							=> $this->_sub_unit(true),
				'perubahan'							=> $this->_perubahan_rka()
			),
			array
			(
				'user_group'						=> null,
				'title'								=> 'DPA 2.2.1',
				'description'						=> 'Laporan Dokumen Pelaksanaan Anggaran 2.2.1',
				'icon'								=> 'mdi-file-chart',
				'color'								=> 'bg-primary',
				'placement'							=> 'left',
				'controller'						=> 'dpa_221',
				'sub_unit'							=> $this->_sub_unit(true),
				'perubahan'							=> $this->_perubahan()
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
	
	private function _perubahan_rka()
	{
		return '
			<div class="form-group">
				<label class="text-muted d-block">
					Kode Perubahan
				</label>
				<label>
					<input type="radio" name="kd_perubahan" value="1" checked>
					Murni
				</label>
				&nbsp;
				<label>
					<input type="radio" name="kd_perubahan" value="3">
					Perubahan
				</label>
			</div>
		';
	}
	
	private function _perubahan()
	{
		return '
			<div class="form-group">
				<label class="text-muted d-block">
					Kode Perubahan
				</label>
				<label>
					<input type="radio" name="kd_perubahan" value="4" checked>
					Murni
				</label>
				&nbsp;
				<label>
					<input type="radio" name="kd_perubahan" value="5">
					Pergeseran
				</label>
				&nbsp;
				<label>
					<input type="radio" name="kd_perubahan" value="6">
					Perubahan
				</label>
			</div>
		';
	}
}
