<?php namespace Modules\Laporan\Controllers\Anggaran;
/**
 * Laporan > Anggaran > DPA
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Dpa extends \Aksara\Laboratory\Core
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
	private $kd_rek_1;

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

		$this->unset_action('create, read, update, delete, export, print, pdf');

		$this->_tanggal_cetak						= date('Y-m-d');

		helper('custom');

		$this->report								= new \Modules\Laporan\Models\Dpa();

		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null) . (service('request')->uri->getSegment(4) ? '\\' . service('request')->uri->getSegment(4) : null);

		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}

		$this->kd_sub                               = service('request')->getGet('sub_unit');

		if(!empty(service('request')->getGet('unit'))){
			list
				(
					$this->kd_urusan,
					$this->kd_bidang,
					$this->kd_unit
				)									= array_pad(explode('.', service('request')->getGet('unit')), 7, 0);
		}

		if(!empty(service('request')->getGet('kegiatan'))){
			list
				(
					$this->kd_urusan,
					$this->kd_bidang,
					$this->kd_unit,
					$this->kd_sub,
					$this->kd_prog,
					$this->id_prog,
					$this->kd_keg
				)									= array_pad(explode('.', service('request')->getGet('kegiatan')), 7, 0);
		}
	}

	public function index()
	{
		$this->set_title('Laporan Anggaran DPA')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}

	/**
	 * Laporan DPA
	 */
	public function dpa_skpd()
	{
		if(!($this->kd_unit))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}

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

		$this->_title								= 'DPA SKPD';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->dpa_skpd($params);

		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

	public function dpa_pendapatan_skpd()
	{
		if(!($this->kd_unit))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}

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

		$this->_title								= 'DPA SKPD';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->dpa_pendapatan_skpd($params);

		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

	public function dpa_belanja_skpd()
	{
		if(!($this->kd_unit))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}

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

		$this->_title								= 'DPA SKPD';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->dpa_belanja_skpd($params);

		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

	public function dpa_rincian_belanja()
	{
		if(!($this->kd_unit))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}

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

		$this->_title								= 'DPA SKPD';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->dpa_rincian_belanja($params);

		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

	public function dpa_sub_kegiatan()
	{
		if(!($this->kd_unit))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}

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

		$this->_title								= 'DPA SKPD';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->dpa_sub_kegiatan($params);

		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

	public function dpa_pembiayaan_skpd()
	{
		if(!($this->kd_unit))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}

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

		$this->_title								= 'DPA SKPD';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->dpa_pembiayaan_skpd($params);

		if(3 == service('request')->getGet('kd_perubahan'))
		{
			$this->_template						= $this->_template . '_perubahan';
		}

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
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

		$header										= $this->model->get_where
		(
			'ref__settings',
			array
			(
				'tahun'								=> get_userdata('year')
			),
			1
		)
		->row();

		/* prepare object data */
		$data										= array
		(
			'title'									=> $this->_title,
			'nama_pemda'							=> (isset($header->nama_pemda) ? $header->nama_pemda : 'PEMERINTAH KOTA BEKASI'),
			'nama_daerah'							=> (isset($header->nama_daerah) ? $header->nama_daerah : 'Kota Bekasi'),
			'logo_laporan'							=> get_image('settings', (isset($header->logo_laporan) ? $header->logo_laporan : get_setting('app_icon')), 'thumb'),
			'tanggal_cetak'							=> date_indo($this->_tanggal_cetak),
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
				//'user_group'						=> array(1),
				'title'								=> 'Laporan DPA - SKPD',
				'description'						=> 'Dokumen Pelaksanaan Anggaran SKPD',
				'icon'								=> 'mdi-chart-arc',
				'color'								=> 'bg-primary',
				'placement'							=> 'left',
				'controller'						=> 'dpa_skpd',
				'parameter'							=> array
				(
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'jenis_anggaran'				=> $this->_jenis_anggaran()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Laporan DPA - Pendapatan SKPD',
				'description'						=> 'Dokumen Pelaksanaan Anggaran Pendapatan SKPD',
				'icon'								=> 'mdi-chart-bell-curve',
				'color'								=> 'bg-teal',
				'placement'							=> 'left',
				'controller'						=> 'dpa_pendapatan_skpd',
				'parameter'							=> array
				(
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'jenis_anggaran'				=> $this->_jenis_anggaran()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Laporan DPA - Belanja SKPD',
				'description'						=> 'Dokumen Pelaksanaan Anggaran Belanja SKPD',
				'icon'								=> 'mdi-chart-areaspline',
				'color'								=> 'bg-danger',
				'placement'							=> 'left',
				'controller'						=> 'dpa_belanja_skpd',
				'parameter'							=> array
				(
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'jenis_anggaran'				=> $this->_jenis_anggaran()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Laporan DPA - Rincian Belanja SKPD',
				'description'						=> 'Dokumen Pelaksanaan Anggaran Rincian Belanja',
				'icon'								=> 'mdi-chart-bar',
				'color'								=> 'bg-maroon',
				'placement'							=> 'left',
				'controller'						=> 'dpa_rincian_belanja',
				'parameter'							=> array
				(
					'sub_kegiatan'					=> $this->_sub_kegiatan(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'laporan DPA - Sub Kegiatan SKPD',
				'description'						=> 'Dokumen Pelaksanaan Anggaran Sub Kegiatan SKPD',
				'icon'								=> 'mdi-comment-account-outline',
				'color'								=> 'bg-success',
				'placement'							=> 'left',
				'controller'						=> 'dpa_sub_kegiatan',
				'parameter'							=> array
				(
					'sub_kegiatan'					=> $this->_sub_kegiatan(),
					//'jenis_anggaran'				=> $this->_jenis_anggaran(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Laporan DPA - Pembiayaan SKPD',
				'description'						=> 'Dokumen Pelaksanaan Anggaran Pembiayaan SKPD',
				'icon'								=> 'mdi-chart-bar-stacked',
				'color'								=> 'bg-info',
				'placement'							=> 'left',
				'controller'						=> 'dpa_pembiayaan_skpd',
				'parameter'							=> array
				(
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			)
		);
	}

	/**
	 * Function Dropdown Sub Unit
	 */
	private function _jenis_anggaran()
	{
		$output									= 'NULL';
		$query										= 	$this->model->query
		('
			SELECT
				ref__renja_jenis_anggaran.id,
				ref__renja_jenis_anggaran.kode,
				ref__renja_jenis_anggaran.nama_jenis_anggaran
			FROM
				ref__renja_jenis_anggaran
			WHERE
				ref__renja_jenis_anggaran.id > 8
			ORDER BY
				ref__renja_jenis_anggaran.kode ASC
		')
			->result();

		if($query)
		{
			foreach($query as $key => $val)
			{
				$output									.= '<option value="' . $val->id . '">' . $val->kode . '. ' . $val->nama_jenis_anggaran . '</option>';
			}
		}

		$output										= '
			<div class="form-group mb-2">
				<label class="d-block text-muted">
					Jenis Anggaran
				</label>
				<select name="jenis_anggaran" class="form-control form-control-sm">
					' . $output . '
				</select>
			</div>
		';
		return $output;
	}

	private function _unit_sub_unit()
	{
		// Global Administrator
		if(in_array(get_userdata('group_id'), array(1)))
		{
			$id_unit								= service('request')->getPost('primary');
			if($id_unit)
			{
				$query		= $this->model->query
				('
								SELECT
									ref__sub.id,
									ref__sub.kd_sub,
									ref__sub.nm_sub
								FROM
									ref__sub
								WHERE
									ref__sub.id_unit = ' . $id_unit . '
								ORDER BY
									ref__sub.kd_sub ASC
							')
					->result();
				$options							= '<option value="all">Pilih Semua Sub Unit</option>';

				if($query)
				{
					foreach($query as $key => $val)
					{
						$options					.= '<option value="' . $val->id . '">' . $val->kd_sub . '. ' . $val->nm_sub . '</option>';
					}
				}

				make_json
				(
					array
					(
						'html'						=> $options
					)
				);
			}
			else
			{
				$this->model->database_config('default');

				$query		                        = $this->model->query
				('
					SELECT
						ref_unit.kd_urusan,
						ref_unit.kd_bidang,
						ref_unit.kd_unit,
						ref_unit.nm_unit
					FROM
						ref_unit
				')
					->result();

				$options							= '<option value="">Silakan Pilih Unit</option>';
				if($query)
				{
					foreach($query as $key => $val)
					{
						$options					.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '">' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '. ' . $val->nm_unit . '</option>';
					}
					return '
						<div class="form-group mb-1">
							<label class="control-label mb-1">
								Unit
							</label>
							<select name="unit" class="form-control bordered form-control-sm report-dropdown" placeholder="Silakan Pilih Unit" to-change=".sub_unit">
								' . $options . '
							</select>
						</div>
						<div class="form-group mb-1">
							<label class="control-label mb-1">
								Sub Unit
							</label>
							<select name="sub_unit" class="form-control bordered form-control-sm sub_unit" placeholder="Pilih Unit terlebih dahulu" disabled>
								
							</select>
						</div>
					';
				}
			}
		}
		else // Unit
		{
			$id_sub			= get_userdata('sub_unit');
			$query			= $this->model->query
			('
								SELECT
									ref__sub.id,
									ref__sub.kd_sub,
									ref__sub.nm_sub
								FROM
									ref__sub
								WHERE
									ref__sub.id_unit = ' . $id_sub . '
								ORDER BY
									ref__sub.kd_sub ASC
							')
				->result();
			$options								= null;

			if($query)
			{
				$options							= '<option value="all">Pilih Semua Sub Unit</option>';
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val->id . '">' . $val->kd_sub . '. ' . $val->nm_sub . '</option>';
				}
			}

			return '
				<div class="form-group mb-1">
					<label class="control-label mb-1">
						Sub Unit
					</label>
					<select name="sub_unit" class="form-control bordered form-control-sm" placeholder="Silakan pilih Sub Unit">
						' . $options . '
					</select>
				</div>
			';
		}
	}

	private function _sub_kegiatan()
	{
		$output										= null;
		// Super Admin, Admin Perencanaan, Admin Keuangan, Admin Monev, Admin RUP, Tim Asistensi, TAPD TTD, Bidang Bappeda, Keuangan, Sekretariat, Pemeriksa
		if(in_array(get_userdata('group_id'), array(1)))
		{
			$this->model->database_config('default');

			$query									= $this->model
				->select
				('
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_sub_unit.nm_sub_unit
			')
				->get_where('ref_sub_unit', array('ref_sub_unit.kd_sub !=' => NULL))
				->result_array();
			if($query)
			{
				$options							= null;
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . '">' . $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . ' ' . $val['nm_sub_unit'] . '</option>';
				}
				$output								.= '
					<div class="form-group mb-1">
						<label class="control-label mb-1">
							Sub Unit
						</label>
						<select name="sub_unit" class="form-control form-control-sm report-dropdown" to-change=".program">
							<option value="">Silakan pilih Sub Unit</option>
							' . $options . '
						</select>
					</div>
					<div class="form-group mb-1">
						<label class="control-label mb-1">
							Program
						</label>
						<select name="program" class="form-control form-control-sm report-dropdown program" to-change=".kegiatan" disabled>
							<option value="">Silakan pilih Sub Unit terlebih dahulu</option>
						</select>
					</div>
					<div class="form-group mb-1">
						<label class="control-label mb-1">
							Kegiatan
						</label>
						<select name="kegiatan" class="form-control form-control-sm report-dropdown kegiatan" to-change=".sub_kegiatan" disabled>
							<option value="">Silakan pilih Program terlebih dahulu</option>
						</select>
					</div>
				';
			}
		}
		// Grup Sub Unit
		elseif(in_array(get_userdata('group_id'), array(11, 12)))
		{
			$query									= $this->model->select
			('
				ta__program.id,
				ref__program.kd_program,
				ref__program.nm_program
			')
				->join
				(
					'ta__program',
					'ref__program.id = ta__program.id_prog'
				)
				->join
				(
					'ref__sub',
					'ref__sub.id = ta__program.id_sub'
				)
				->order_by('ref__program.kd_program', 'ASC')
				->get_where
				(
					'ref__program',
					array
					(
						'ref__program.id !='			=> NULL,
						'ref__sub.id'					=> $this->_sub_unit,
						'ref__sub.id_unit'				=> $this->_unit
					)
				)
				->result_array();

			if($query)
			{
				$options							= null;
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val['id'] . '">' . $val['kd_program'] . '. ' . $val['nm_program'] . '</option>';
				}
				$output								.= '
					<div class="form-group mb-1">
						<label class="control-label mb-1">
							Program
						</label>
						<select name="program" class="form-control form-control-sm report-dropdown" to-change=".kegiatan">
							<option value="">Silakan pilih Program</option>
							' . $options . '
						</select>
					</div>
					<div class="form-group mb-1">
						<label class="control-label mb-1">
							Kegiatan
						</label>
						<select name="kegiatan" class="form-control form-control-sm report-dropdown kegiatan" to-change=".sub_kegiatan" disabled>
							<option value="">Silakan pilih Program terlebih dahulu</option>
						</select>
					</div>
					<div class="form-group mb-1">
						<label class="control-label mb-1">
							Sub Kegiatan
						</label>
						<select name="sub_kegiatan" class="form-control form-control-sm sub_kegiatan" disabled>
							<option value="">Silakan pilih Kegiatan terlebih dahulu</option>
						</select>
					</div>
				';
			}
		}
		else
		{
			return false;
		}

		return $output;
	}

	private function _dropdown()
	{
		$this->model->database_config('default');

		$primary									= service('request')->getPost('primary');
		$list										= $primary != 'all' ? explode(".", $primary) : null;
		$element									= service('request')->getPost('element');
		$options									= null;

		if('.sub_unit' == $element)
		{
			$query									= $this->model->select
			('
				kd_urusan,
				kd_bidang,
				kd_unit,
				kd_sub,
				nm_sub_unit
			')
				->order_by('kd_sub')
				->get_where
				(
					'ref_sub_unit',
					array
					(
						'kd_urusan'					=> $list[0],
						'kd_bidang'					=> $list[1],
						'kd_unit'					=> $list[2]
					),
					NULL,
					NULL,
					50,
				)
				->result();

			if($query)
			{
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val->kd_sub . '">' . $val->kd_sub . '. ' . $val->nm_sub_unit . '</option>';
				}
			}
		}
		elseif('.program' == $element)
		{
			$query									= $this->model->select
			('
				ta_program.kd_urusan,
				ta_program.kd_bidang,
				ta_program.kd_unit,
				ta_program.kd_sub,
				ta_program.kd_prog,
				ta_program.id_prog,
				ta_program.ket_program
			')
				->order_by('ta_program.kd_prog')
				->get_where
				(
					'ta_program',
					array
					(
						'ta_program.kd_urusan'		=> $list[0],
						'ta_program.kd_bidang'		=> $list[1],
						'ta_program.kd_unit'		=> $list[2],
						'ta_program.kd_sub'		    => $list[3]
					),
					NULL,
					NULL,
					50,
				)
				->result_array();
			if($query)
			{
				$options							= '<option value="">Silakan pilih Program</option>';
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . '.' . $val['kd_prog'] . '.' . $val['id_prog'] . '">' . $val['kd_prog'] . '. ' . $val['ket_program'] . '</option>';
				}
			}
		}
		elseif('.kegiatan' == $element)
		{
			$query									= $this->model->select
			('
				ta_kegiatan.kd_urusan,
				ta_kegiatan.kd_bidang,
				ta_kegiatan.kd_unit,
				ta_kegiatan.kd_sub,
				ta_kegiatan.kd_prog,
				ta_kegiatan.id_prog,
				ta_kegiatan.kd_keg,
				ta_kegiatan.ket_kegiatan
			')
				->order_by('ta_kegiatan.kd_keg')
				->get_where
				(
					'ta_kegiatan',
					array
					(
						'ta_kegiatan.kd_urusan'		=> $list[0],
						'ta_kegiatan.kd_bidang'		=> $list[1],
						'ta_kegiatan.kd_unit'		=> $list[2],
						'ta_kegiatan.kd_sub'		=> $list[3],
						'ta_kegiatan.kd_prog'		=> $list[4],
						'ta_kegiatan.id_prog'		=> $list[5]
					),
					NULL,
					NULL,
					50,
				)
				->result_array();
			if($query)
			{
				$options							= '<option value="">Silakan pilih Kegiatan</option>';
				foreach($query as $key => $val)
				{
					$options						.= '<option value="' . $val['kd_urusan'] . '.' . $val['kd_bidang'] . '.' . $val['kd_unit'] . '.' . $val['kd_sub'] . '.' . $val['kd_prog'] . '.' . $val['id_prog'] . '.' . $val['kd_keg'] . '">' . $val['kd_keg'] . '. ' . $val['ket_kegiatan'] . '</option>';
				}
			}
		}

		make_json
		(
			array
			(
				'results'							=> $options,
				'element'							=> $element,
				'html'								=> ($options ? $options : '<option value="">Data yang dipilih tidak mendapatkan hasil</options>')
			)
		);
	}

	private function _tanggal_cetak()
	{
		$options									= '
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group mb-1">
						<label class="text-muted d-block">
							Tanggal Cetak
						</label>
						<input type="text" name="tanggal_cetak" class="form-control form-control-sm bordered" placeholder="Pilih Tanggal" value="' . date('d M Y') . '" role="datepicker" readonly />
					</div>
				</div>
			</div>
		';

		return $options;
	}

}
