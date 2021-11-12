<?php namespace Modules\Laporan\Controllers\Bendahara;
/**
 * Laporan > Bendahara > Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Penerimaan extends \Aksara\Laboratory\Core
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

		//$this->_periode_awal						= ($this->input->get('periode_awal') ? $this->input->get('periode_awal') : date(get_userdata('year') . '-01-01'));
		//$this->_periode_akhir						= ($this->input->get('periode_akhir') ? $this->input->get('periode_akhir') : date(get_userdata('year') . '-12-31'));
		$this->_tanggal_cetak                       = date('Y-m-d');

		helper('custom');

		$this->report								= new \Modules\Laporan\Models\Penerimaan();

		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null) . (service('request')->uri->getSegment(4) ? '\\' . service('request')->uri->getSegment(4) : null);

		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}

		$this->kd_sub                               = service('request')->getGet('sub_unit');
		$this->kd_rek_1                             = service('request')->getGet('rekening');

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
		$this->set_title('Laporan Penerimaan')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}

	/**
	 * Laporan Bendahara Penerimaan
	 */
	public function bukti_penerimaan()
	{
		if('all' == (service('request')->getGet('nomor')))
		{
			return throw_exception(301, 'Silakan memilih No Bukti terlebih dahulu...', current_page('../'));
		}

		$params										= array
		(
			'tahun'									=> get_userdata('year'),
			'no_bukti'								=> service('request')->getGet('nomor')
		);

		$this->_title								= 'Bukti Penerimaan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->bukti_penerimaan($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function sts()
	{
		if('all' == (service('request')->getGet('nomor')))
		{
			return throw_exception(301, 'Silakan memilih No STS terlebih dahulu...', current_page('../'));
		}

		$params										= array
		(
			'tahun'									=> get_userdata('year'),
			'no_sts'								=> service('request')->getGet('nomor')
		);

		$this->_title								= 'STS';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->sts($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function rekapitulasi_penerimaan()
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
			'periode_awal'							=> service('request')->getGet('periode_awal'),
			'periode_akhir'						    => service('request')->getGet('periode_akhir')
		);

		$this->_title								= 'Rekapitulasi Penerimaan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->rekapitulasi_penerimaan($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function bku_pembantu()
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
			'kd_sub'								=> $this->kd_sub
		);

		$this->_title								= 'Buku Pembantu Per Rincian Penerimaan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->bku_pembantu($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function spj_pendapatan()
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
			'bulan'								    => service('request')->getGet('bulan')
		);

		$this->_title								= 'SPJ Pendapatan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->spj_pendapatan($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function bku_penerimaan()
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
			'kd_sub'								=> $this->kd_sub
		);

		$this->_title								= 'Buku Kas Penerimaan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->bku_penerimaan($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function register_sts()
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
			'kd_sub'								=> $this->kd_sub
		);

		$this->_title								= 'Register STS';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->register_sts($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function reg_tanda_bukti()
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
			'kd_sub'								=> $this->kd_sub
		);

		$this->_title								= 'Register Tanda Bukti Penerimaan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->reg_tanda_bukti($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function reg_ketetapan_pendapatan()
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
			'kd_sub'								=> $this->kd_sub
		);

		$this->_title								= 'Register Ketetapan Pendapatan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->reg_ketetapan_pendapatan($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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

	public function bku_pendapatan_harian()
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
			'kd_sub'								=> $this->kd_sub
		);

		$this->_title								= 'Buku Pendapatan Harian';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->bku_pendapatan_harian($params);

		if(!($this->_output['data_query']))
		{
			return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
		}

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
			'qrcode'								=> $this->_output['qrcode'],
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
				'title'								=> 'Tanda Bukti Penerimaan',
				'description'						=> 'Laporan Tanda Bukti Penerimaan',
				'icon'								=> 'mdi-chart-arc',
				'color'								=> 'bg-primary',
				'placement'							=> 'left',
				'controller'						=> 'bukti_penerimaan',
				'parameter'							=> array
				(
					'bukti'					        => $this->_nomor('bukti')
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'STS',
				'description'						=> 'Laporan STS',
				'icon'								=> 'mdi-chart-bell-curve',
				'color'								=> 'bg-teal',
				'placement'							=> 'left',
				'controller'						=> 'sts',
				'parameter'							=> array
				(
					'sts'					        => $this->_nomor('sts')
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Buku Rekapitulasi Penerimaan',
				'description'						=> 'Laporan Buku Rekapitulasi Penerimaan',
				'icon'								=> 'mdi-chart-areaspline',
				'color'								=> 'bg-danger',
				'placement'							=> 'left',
				'controller'						=> 'rekapitulasi_penerimaan',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Buku Pembantu Per Rincian Penerimaan',
				'description'						=> 'Laporan Buku Pembantu Per Rincian Penerimaan',
				'icon'								=> 'mdi-chart-bar',
				'color'								=> 'bg-maroon',
				'placement'							=> 'left',
				'controller'						=> 'bku_pembantu',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'SPJ Pendapatan',
				'description'						=> 'Laporan SPJ Pendapatan',
				'icon'								=> 'mdi-comment-account-outline',
				'color'								=> 'bg-success',
				'placement'							=> 'left',
				'controller'						=> 'spj_pendapatan',
				'parameter'							=> array
				(
					'sub_kegiatan'					=> $this->_unit_sub_unit(),
					'bulan'					        => $this->_month(),
					//'jenis_anggaran'				=> $this->_jenis_anggaran(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Buku Kas Penerimaan',
				'description'						=> 'Laporan Buku Kas Penerimaan',
				'icon'								=> 'mdi-comment-check-outline',
				'color'								=> 'bg-primary',
				'placement'							=> 'right',
				'controller'						=> 'bku_penerimaan',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Register STS',
				'description'						=> 'Laporan Register STS',
				'icon'								=> 'mdi-chart-pie',
				'color'								=> 'bg-teal',
				'placement'							=> 'right',
				'controller'						=> 'register_sts',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Register Tanda Bukti Penerimaan',
				'description'						=> 'Laporan Register Tanda Bukti Penerimaan',
				'icon'								=> 'mdi-chart-donut',
				'color'								=> 'bg-danger',
				'placement'							=> 'right',
				'controller'						=> 'reg_tanda_bukti',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Register Ketetapan Pendapatan',
				'description'						=> 'Laporan Register Ketetapan Pendapatan',
				'icon'								=> 'mdi-chart-bubble',
				'color'								=> 'bg-maroon',
				'placement'							=> 'right',
				'controller'						=> 'reg_ketetapan_pendapatan',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Buku Pendapatan Harian',
				'description'						=> 'Laporan Buku Pendapatan Harian',
				'icon'								=> 'mdi-chart-donut-variant',
				'color'								=> 'bg-success',
				'placement'							=> 'right',
				'controller'						=> 'bku_pendapatan_harian',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			)
		);
	}

	/**
	 * Function Dropdown Sub Unit
	 */
	private function _nomor($no_jenis = null)
	{
		$this->model->database_config('default');
		$output										= null;
		$query										= null;

		if($no_jenis == 'bukti')
		{
			$query									= $this->model
													->select('ta_bukti_penerimaan_rinc.no_bukti')
													->join('ta_bukti_penerimaan','ta_bukti_penerimaan_rinc.no_bukti = ta_bukti_penerimaan.no_bukti')
													->group_by('ta_bukti_penerimaan_rinc.no_bukti')
													->order_by('ta_bukti_penerimaan_rinc.no_bukti', 'ASC')
													->get_where('ta_bukti_penerimaan_rinc')
													->result_array();
		}
		elseif($no_jenis == 'sts')
		{
			$query									= $this->model
													->select('ta_sts_rinc.no_sts AS no_bukti')
													->join('ta_sts','ta_sts_rinc.no_sts = ta_sts.no_sts')
													->group_by('ta_sts_rinc.no_sts')
													->order_by('ta_sts_rinc.no_sts', 'ASC')
													->get_where('ta_sts_rinc')
													->result_array();
		}

		$output								        .= '<option value="all">Silahkan Pilih</option>';
		if($query)
		{
			foreach($query as $key => $val)
			{
				$output								.= '<option value="' . $val['no_bukti'] . '">' . $val['no_bukti'] . '</option>';
			}
		}

		$output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					No ' . $no_jenis . '
				</label>
				<select name="nomor" class="form-control form-control-sm">
					' . $output . '
				</select>
			</div>
		';

		return $output;
	}

	private function _month()
	{
		$output										= null;

		$output										= '
													<div class="form-group mb-1">
														<label class="control-label mb-1">
															Bulan
														</label>
														<select name="bulan" class="form-control form-control-sm">
															<option value="01">Januari</option>
															<option value="02">Februari</option>
															<option value="03">Maret</option>
															<option value="04">April</option>
															<option value="05">Mei</option>
															<option value="06">Juni</option>
															<option value="07">Juli</option>
															<option value="08">Agustus</option>
															<option value="09">September</option>
															<option value="10">Oktober</option>
															<option value="11">November</option>
															<option value="12">Desember</option>
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

	private function _tanggal_periode()
	{
		$options									= '
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="text-muted d-block">
							Periode Awal
						</label>
						<input type="text" name="periode_awal" class="form-control form-control-sm bordered" placeholder="Pilih Tanggal" value="01 Jan ' . get_userdata('year') . '" role="datepicker" readonly />
					</div>
				</div>
				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="text-muted d-block">
							Periode Akhir
						</label>
						<input type="text" name="periode_akhir" class="form-control form-control-sm bordered" placeholder="Pilih Tanggal" value="' . date('d M ' . get_userdata('year') . '') . '" role="datepicker" readonly />
					</div>
				</div>
			</div>
		';

		return $options;
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
