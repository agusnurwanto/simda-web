<?php namespace Modules\Laporan\Controllers\Bendahara;
/**
 * Laporan > Bendahara > Dokumen Kendali
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Dokumen_kendali extends \Aksara\Laboratory\Core
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

		$this->_tanggal_cetak						= date('Y-m-d');

		helper('custom');

		$this->report								= new \Modules\Laporan\Models\Dokumen_kendali();

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
		$this->set_title('Laporan Dokumen Kendali')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}

	/**
	 * Laporan Dokumen Kendali
	 */
	public function kartu_kendali()
	{
		if(!($this->kd_keg))
		{
			return throw_exception(301, 'Silakan memilih Kegiatan terlebih dahulu...', current_page('../'));
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

		$this->_title								= 'Kartu Kendali';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->kartu_kendali($params);

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

	public function kartu_kendali_btl()
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
		);

		$this->_title								= 'Kartu Kendali BTL';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->kartu_kendali_btl($params);

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

	public function kartu_kendali_pembiayaan()
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
		);

		$this->_title								= 'Kartu Kendali Pembiayaan';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->kartu_kendali_pembiayaan($params);

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

    public function rincian_kartu_kendali_kegiatan()
    {
        if(!($this->kd_keg))
        {
            return throw_exception(301, 'Silakan memilih Kegiatan terlebih dahulu...', current_page('../'));
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

        $this->_title								= 'Rincian Kartu Kendali Kegiatan';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->rincian_kartu_kendali_kegiatan($params);

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

    public function rincian_kartu_kendali_btl()
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
        );

        $this->_title								= 'Rincian Kartu Kendali BTL';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->rincian_kartu_kendali_btl($params);

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

    public function rincian_kartu_kendali_pembiayaan()
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
        );

        $this->_title								= 'Rincian Kartu Kendali Pembiayaan';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->rincian_kartu_kendali_pembiayaan($params);

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

    public function rekap_pengeluaran()
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
        );

        $this->_title								= 'Rekap Pengeluaran';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->rekap_pengeluaran($params);

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

    public function bku_rincian_obyek()
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
        );

        $this->_title								= 'BKU Rincian Obyek';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->bku_rincian_obyek($params);

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

    public function posisi_Kas()
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

        $this->_title								= 'Posisi Kas Bendahara Pengeluaran';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->posisi_Kas($params);

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

    public function kartu_kendali_penyediaan()
    {
        if(!($this->kd_keg))
        {
            return throw_exception(301, 'Silakan memilih Kegiatan terlebih dahulu...', current_page('../'));
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

        $this->_title								= 'Kartu Kendali Penyediaan';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->kartu_kendali_penyediaan($params);

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
				'title'								=> 'Kartu Kendali',
				'description'						=> 'Laporan Kartu Kendali',
				'icon'								=> 'mdi-chart-arc',
				'color'								=> 'bg-primary',
				'placement'							=> 'left',
				'controller'						=> 'kartu_kendali',
				'parameter'							=> array
				(
                    'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_sub_kegiatan(),
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Kartu Kendali BTL',
				'description'						=> 'Laporan Kartu Kendali BTL',
				'icon'								=> 'mdi-chart-bell-curve',
				'color'								=> 'bg-teal',
				'placement'							=> 'left',
				'controller'						=> 'kartu_kendali_btl',
				'parameter'							=> array
				(
                    'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_unit_sub_unit(),
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Kartu Kendali Pembiayaan',
				'description'						=> 'Laporan Kartu Kendali Pembiayaan',
				'icon'								=> 'mdi-chart-areaspline',
				'color'								=> 'bg-danger',
				'placement'							=> 'left',
				'controller'						=> 'kartu_kendali_pembiayaan',
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
				'title'								=> 'Rincian Kartu Kendali Kegiatan',
				'description'						=> 'Laporan Rincian Kartu Kendali Kegiatan',
				'icon'								=> 'mdi-chart-bar',
				'color'								=> 'bg-maroon',
				'placement'							=> 'left',
				'controller'						=> 'rincian_kartu_kendali_kegiatan',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_sub_kegiatan(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Rincian Kartu Kendali BTL',
				'description'						=> 'Laporan Rincian Kartu Kendali BTL',
				'icon'								=> 'mdi-comment-account-outline',
				'color'								=> 'bg-success',
				'placement'							=> 'left',
				'controller'						=> 'rincian_kartu_kendali_btl',
				'parameter'							=> array
				(
                    'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_unit_sub_unit()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Rincian Kartu Kendali Pembiayaan',
				'description'						=> 'Laporan Rincian Kartu Kendali Pembiayaan',
				'icon'								=> 'mdi-comment-check-outline',
				'color'								=> 'bg-primary',
				'placement'							=> 'right',
				'controller'						=> 'rincian_kartu_kendali_pembiayaan',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'sub_kegiatan'					=> $this->_unit_sub_unit(),
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Rekap Pengeluaran Per Rincian Obyek',
				'description'						=> 'Laporan Rekap Pengeluaran Per Rincian Obyek',
				'icon'								=> 'mdi-chart-pie',
				'color'								=> 'bg-teal',
				'placement'							=> 'right',
				'controller'						=> 'rekap_pengeluaran',
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
				'title'								=> 'Buku Rincian Obyek Belanja',
				'description'						=> 'Laporan Buku Rincian Obyek Belanja',
				'icon'								=> 'mdi-chart-donut',
				'color'								=> 'bg-danger',
				'placement'							=> 'right',
				'controller'						=> 'bku_rincian_obyek',
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
				'title'								=> 'Posisi Kas Bendahara Pengeluaran',
				'description'						=> 'Laporan Posisi Kas Bendahara Pengeluaran',
				'icon'								=> 'mdi-chart-bubble',
				'color'								=> 'bg-maroon',
				'placement'							=> 'right',
				'controller'						=> 'posisi_Kas',
				'parameter'							=> array
				(
                    'bulan'					        => $this->_month(),
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_unit_sub_unit(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			),
			array
			(
				//'user_group'						=> array(1),
				'title'								=> 'Kartu Kendali Penyediaan Dana Anggaran',
				'description'						=> 'Laporan Kartu Kendali Penyediaan Dana Anggaran',
				'icon'								=> 'mdi-chart-donut-variant',
				'color'								=> 'bg-success',
				'placement'							=> 'right',
				'controller'						=> 'kartu_kendali_penyediaan',
				'parameter'							=> array
				(
					'tanggal_periode'				=> $this->_tanggal_periode(),
					'unit_sub_unit'					=> $this->_sub_kegiatan(),
					//'tanggal_cetak'					=> $this->_tanggal_cetak()
				)
			)
		);
	}

	/**
	 * Function Dropdown Sub Unit
	 */
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
						'ref__program.id !='		=> NULL,
						'ref__sub.id'				=> $this->_sub_unit,
						'ref__sub.id_unit'			=> $this->_unit
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
