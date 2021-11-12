<?php namespace Modules\Laporan\Controllers\Pembukuan;
/**
 * Laporan > Pembukuan > Basis
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Basis extends \Aksara\Laboratory\Core
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

	private $kd_akun;
	private $kd_kelompok;
	private $kd_jenis;
    private $kd_obyek;
    private $kd_rincian;

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

		$this->unset_action('create, read, update, delete, export, print, pdf');

		$this->_tanggal_cetak						= date('Y-m-d');

		helper('custom');

		$this->report								= new \Modules\Laporan\Models\Pembukuan();

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

        if(!empty(service('request')->getGet('jenis'))){
            list
                (
                    $this->kd_akun,
                    $this->kd_kelompok,
                    $this->kd_jenis
                )									= array_pad(explode('.', service('request')->getGet('jenis')), 7, 0);
        }

	}

	public function index()
	{
		$this->set_title('Laporan Basis')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}

	/**
	 * Laporan Pembukuan Basis
	 */
	public function rekening()
	{
		$params										= array
		(
			'tahun'									=> get_userdata('year'),
			'rekening'								=> service('request')->getGet('level_rekening')
		);

		$this->_title								= 'REKENING';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->rekening($params);

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

	public function jurnal()
	{
        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan ? $this->kd_urusan : '%',
            'kd_bidang'								=> $this->kd_bidang ? $this->kd_bidang : '%',
            'kd_unit'								=> $this->kd_unit ? $this->kd_unit : '%',
            'kd_sub'								=> $this->kd_sub ? $this->kd_sub : '%',
            'periode_awal'							=> service('request')->getGet('periode_awal'),
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jenis_jurnal'							=> service('request')->getGet('jenis_jurnal')
		);

		$this->_title								= 'JURNAL';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->jurnal($params);

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

	public function buku_besar()
	{
        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan ? $this->kd_urusan : '%',
            'kd_bidang'								=> $this->kd_bidang ? $this->kd_bidang : '%',
            'kd_unit'								=> $this->kd_unit ? $this->kd_unit : '%',
            'kd_sub'								=> $this->kd_sub ? $this->kd_sub : '%',
            'kd_akun'								=> $this->kd_akun ? $this->kd_akun : '%',
            'kd_kelompok'							=> $this->kd_kelompok ? $this->kd_kelompok : '%',
            'kd_jenis'								=> $this->kd_jenis ? $this->kd_jenis : '%',
            'periode_awal'							=> service('request')->getGet('periode_awal'),
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'level_rekening'						=> service('request')->getGet('level_rekening')
		);

		$this->_title								= 'Buku Besar';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->buku_besar($params);

        if(!($this->_output))
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

	public function buku_besar_pembantu()
	{
        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan ? $this->kd_urusan : '%',
            'kd_bidang'								=> $this->kd_bidang ? $this->kd_bidang : '%',
            'kd_unit'								=> $this->kd_unit ? $this->kd_unit : '%',
            'kd_sub'								=> $this->kd_sub ? $this->kd_sub : '%',
            'kd_akun'								=> $this->kd_akun ? $this->kd_akun : '%',
            'kd_kelompok'							=> $this->kd_kelompok ? $this->kd_kelompok : '%',
            'kd_jenis'								=> $this->kd_jenis ? $this->kd_jenis : '%',
            'kd_obyek'								=> $this->kd_obyek ? $this->kd_obyek : '%',
            'kd_rincian'							=> $this->kd_rincian ? $this->kd_rincian : '%',
            'periode_awal'							=> service('request')->getGet('periode_awal'),
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'level_rekening'						=> service('request')->getGet('level_rekening')
		);

		$this->_title								= 'Buku Besar Pembantu';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->buku_besar_pembantu($params);

        if(!($this->_output))
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

	public function buku_besar_pembantu_bukti()
	{
        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan ? $this->kd_urusan : '%',
            'kd_bidang'								=> $this->kd_bidang ? $this->kd_bidang : '%',
            'kd_unit'								=> $this->kd_unit ? $this->kd_unit : '%',
            'kd_sub'								=> $this->kd_sub ? $this->kd_sub : '%',
            'kd_akun'								=> $this->kd_akun ? $this->kd_akun : '%',
            'kd_kelompok'							=> $this->kd_kelompok ? $this->kd_kelompok : '%',
            'kd_jenis'								=> $this->kd_jenis ? $this->kd_jenis : '%',
            'kd_obyek'								=> $this->kd_obyek ? $this->kd_obyek : '%',
            'kd_rincian'							=> $this->kd_rincian ? $this->kd_rincian : '%',
            'periode_awal'							=> service('request')->getGet('periode_awal'),
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'level_rekening'						=> service('request')->getGet('level_rekening')
		);

		$this->_title								= 'Buku Besar Pembantu (per No. Bukti)';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->buku_besar_pembantu_bukti($params);

//        if(!($this->_output['surplus_query']))
//        {
//            return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
//        }

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

	public function neraca()
	{
        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan ? $this->kd_urusan : '%',
            'kd_bidang'								=> $this->kd_bidang ? $this->kd_bidang : '%',
            'kd_unit'								=> $this->kd_unit ? $this->kd_unit : '%',
            'kd_sub'								=> $this->kd_sub ? $this->kd_sub : '%',
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jenis_laporan'							=> service('request')->getGet('jenis_laporan')
		);

		$this->_title								= 'Neraca';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->neraca($params);

        if(!($this->_output['data_query']))
        {
            return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
        }

		if(1 == service('request')->getGet('jenis_laporan'))
		{
			$this->_template						= $this->_template . '_setelah_penggabungan';
		}
		elseif(2 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_setelah_penggabungan_sap';
        }
        elseif(5 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_sebelum_penggabungan';
        }
        elseif(6 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_sebelum_penggabungan_sap';
        }
        elseif(7 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_lajur';
        }

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

	public function realisasi_anggaran()
	{
        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan ? $this->kd_urusan : '%',
            'kd_bidang'								=> $this->kd_bidang ? $this->kd_bidang : '%',
            'kd_unit'								=> $this->kd_unit ? $this->kd_unit : '%',
            'kd_sub'								=> $this->kd_sub ? $this->kd_sub : '%',
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jenis_laporan'							=> service('request')->getGet('jenis_laporan'),
            'level_rekening'						=> service('request')->getGet('level_rekening'),
            'kd_prog'								=> $this->kd_prog ? $this->kd_prog : '%',
            'id_prog'								=> $this->id_prog ? $this->id_prog : '%',
            'kd_keg'								=> $this->kd_keg ? $this->kd_keg : '%'
		);

		$this->_title								= 'Laporan Realisasi Anggaran';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->realisasi_anggaran($params);

        if(!($this->_output['data_query']))
        {
            return throw_exception(301, 'Data Laporan '.$this->_title.' Tidak Ada !', current_page('../'));
        }

		if(1 == service('request')->getGet('jenis_laporan'))
		{
			$this->_template						= $this->_template . '_lra';
		}
		elseif(2 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_lra_sap';
        }
        elseif(5 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_lra_periode';
        }
        elseif(7 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_lra_semester';
        }
        elseif(8 == service('request')->getGet('jenis_laporan'))
        {
            $this->_template						= $this->_template . '_lra_sumber_dana';
        }

		$this->miscellaneous						= new \Aksara\Libraries\Miscellaneous();

		$shortlink									= $this->miscellaneous->shortlink_generator(current_page(), 's');
		$this->_output['qrcode']					= $this->miscellaneous->qrcode_generator($shortlink);

		/* execute the thread */
		$this->_execute();
	}

    public function memo_pembukuan()
    {
        if( '%' == (service('request')->getGet('jenis_jurnal')))
        {
            return throw_exception(301, 'Silakan memilih No Bukti terlebih dahulu...', current_page('../'));
        }

        $params										= array
        (
            'tahun'									=> get_userdata('year'),
            'jenis_jurnal'							=> service('request')->getGet('jenis_jurnal')
        );

        $this->_title								= 'Memo Pembukuan';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->memo_pembukuan($params);

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
                'title'								=> 'Rekening',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-chart-arc',
                'color'								=> 'bg-primary',
                'placement'							=> 'left',
                'controller'						=> 'rekening',
                'parameter'							=> array
                (
                    'rekening'					    => $this->_level_rekening(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Jurnal',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-chart-bell-curve',
                'color'								=> 'bg-teal',
                'placement'							=> 'left',
                'controller'						=> 'jurnal',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jurnal'					    => $this->_jurnal('Jenis Jurnal'),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Buku Besar',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-chart-areaspline',
                'color'								=> 'bg-danger',
                'placement'							=> 'left',
                'controller'						=> 'buku_besar',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_rekening'				=> $this->_level_rekening('Buku Besar'),
                    'rekening'					    => $this->_rekening(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Buku Besar Pembantu',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-chart-bar',
                'color'								=> 'bg-maroon',
                'placement'							=> 'left',
                'controller'						=> 'buku_besar_pembantu',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_rekening'				=> $this->_level_rekening('Buku Besar Pembantu'),
                    'rekening'					    => $this->_rekening('4', '5'),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Buku Besar Pembantu (per No. Bukti)',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-comment-account-outline',
                'color'								=> 'bg-success',
                'placement'							=> 'left',
                'controller'						=> 'buku_besar_pembantu_bukti',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_rekening'				=> $this->_level_rekening('Buku Besar Pembantu'),
                    'rekening'					    => $this->_rekening('4', '5'),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Neraca',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-chart-bar-stacked',
                'color'								=> 'bg-info',
                'placement'							=> 'left',
                'controller'						=> 'neraca',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_laporan'					=> $this->_jenis_laporan(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Laporan Realisasi Anggaran',
                'description'						=> 'Laporan Pembukuan',
                'icon'								=> 'mdi-comment-check-outline',
                'color'								=> 'bg-primary',
                'placement'							=> 'left',
                'controller'						=> 'realisasi_anggaran',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_laporan'					=> $this->_jenis_laporan('realisasi'),
                    'rekening'					    => $this->_level_rekening(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Memo Pembukuan',
                'description'						=> 'Laporan Memo Pembukuan',
                'icon'								=> 'mdi-chart-pie',
                'color'								=> 'bg-teal',
                'placement'							=> 'left',
                'controller'						=> 'memo_pembukuan',
                'parameter'							=> array
                (
                    'jurnal'					    => $this->_jurnal('No Bukti'),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Memo Jural',
                'description'						=> 'Laporan Memo Jural',
                'icon'								=> 'mdi-soy-sauce',
                'color'								=> 'bg-danger',
                'placement'							=> 'left',
                'controller'						=> 'memo_jural',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register SPJ - SP2D',
                'description'						=> 'Laporan Register SPJ - SP2D',
                'icon'								=> 'mdi-paper-cut-vertical',
                'color'								=> 'bg-primary',
                'placement'							=> 'right',
                'controller'						=> 'register_spj_sp2d',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register SPP - SP2D (UP, TU, LS)',
                'description'						=> 'Laporan Register SPP - SP2D (UP, TU, LS)',
                'icon'								=> 'mdi-mushroom-outline',
                'color'								=> 'bg-teal',
                'placement'							=> 'right',
                'controller'						=> 'register_spp_sp2d',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Pengesahan SPJ',
                'description'						=> 'Laporan Pengesahan SPJ',
                'icon'								=> 'mdi-star-half',
                'color'								=> 'bg-danger',
                'placement'							=> 'right',
                'controller'						=> 'pengesahan_spj',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Laporan Pengesahan SPJ',
                'description'						=> 'Laporan Pengesahan SPJ',
                'icon'								=> 'mdi-gas-cylinder',
                'color'								=> 'bg-maroon',
                'placement'							=> 'right',
                'controller'						=> 'laporan_pengesahan_spj',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Pengawasan Anggaran Definitid Per Kegiatan',
                'description'						=> 'Laporan Pengawasan Anggaran Definitid Per Kegiatan',
                'icon'								=> 'mdi-cash-register',
                'color'								=> 'bg-success',
                'placement'							=> 'right',
                'controller'						=> 'pengawasan_anggaran',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register Kontrak / SPK',
                'description'						=> 'Laporan Register Kontrak / SPK',
                'icon'								=> 'mdi-chart-donut',
                'color'								=> 'bg-info',
                'placement'							=> 'right',
                'controller'						=> 'register_kontrak',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Daftar Realisasi Pembayaran Kontrak',
                'description'						=> 'Laporan Daftar Realisasi Pembayaran Kontrak',
                'icon'								=> 'mdi-chart-bubble',
                'color'								=> 'bg-primary',
                'placement'							=> 'right',
                'controller'						=> 'daftar_realisasi',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Realisasi Pembayaran Per Nomor Kontrak',
                'description'						=> 'Laporan Realisasi Pembayaran Per Nomor Kontrak',
                'icon'								=> 'mdi-book',
                'color'								=> 'bg-teal',
                'placement'							=> 'right',
                'controller'						=> 'realisasi_pembayaran',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register SP3B',
                'description'						=> 'Laporan Register SP3B',
                'icon'								=> 'mdi-book-multiple',
                'color'								=> 'bg-danger',
                'placement'							=> 'right',
                'controller'						=> 'register_sp3b',
                'parameter'							=> array
                (
                    //'unit_sub_unit'					=> $this->_unit_sub_unit(),
                )
            ),
        );
    }

	/**
	 * Function Dropdown Sub Unit
	 */
    private function _level_rekening($jenis = null)
    {
        if($jenis == 'Buku Besar')
        {
            $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					Level Rekening
				</label>
				<select name="level_rekening" class="form-control form-control-sm">
					<option value="2">2 KELOMPOK</option>
					<option value="3">3 JENIS</option>
				</select>
			</div>
		';
        }
        elseif($jenis == 'Buku Besar Pembantu')
        {
            $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					Level Rekening
				</label>
				<select name="level_rekening" class="form-control form-control-sm">
					<option value="4">4 OBYEK</option>
					<option value="5">5 RINCIAN OBYEK</option>
				</select>
			</div>
		';
        }
        else
        {
            $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					Level Rekening
				</label>
				<select name="level_rekening" class="form-control form-control-sm">
					<option value="2">2 KELOMPOK</option>
					<option value="3">3 JENIS</option>
					<option value="4">4 OBYEK</option>
					<option value="5">5 RINCIAN OBYEK</option>
				</select>
			</div>
		';
        }

        return $output;
    }

    private function _jurnal($jenis = null)
    {
        $output										= null;
        $query										= null;
        if($jenis == 'Jenis Jurnal')
        {
            $query                                  = $this->model
                                                    ->select('kd_jurnal, nm_jurnal')
                                                    ->order_by('nm_jurnal', 'ASC')
                                                    ->get_where('ref_jurnal')
                                                    ->result_array();
        }

        if($jenis == 'No Bukti')
        {
            $query                                  = $this->model
                                                    ->select('ta_jurnal.no_bukti AS kd_jurnal, ta_jurnal.no_bukti AS nm_jurnal')
                                                    ->from('ta_jurnal')
                                                    ->join('ta_jurnal_rinc','ta_jurnal.no_bukti = ta_jurnal_rinc.no_bukti')
                                                    ->order_by('ta_jurnal.no_bukti', 'ASC')
                                                    ->group_by('ta_jurnal.no_bukti')
                                                    ->result_array();
        }

        if($query)
        {
            $output							        = '<option value="%">Silakan pilih</option>';
            foreach($query as $key => $val)
            {
                $output								.= '<option value="' . $val['kd_jurnal'] . '">' . $val['nm_jurnal'] . '</option>';
            }
        }
        $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					' . $jenis . '
				</label>
				<select name="jenis_jurnal" class="form-control form-control-sm">
					' . $output . '
				</select>
			</div>
		';
        return $output;
    }

    private function _jenis_laporan($jenis = null)
    {
        if($jenis == 'realisasi')
        {
            $output									= '
                                                    <div class="form-group mb-1">
                                                        <label class="control-label mb-1">
                                                            Jenis Laporan
                                                        </label>
                                                        <select name="jenis_laporan" class="form-control form-control-sm">
                                                            <option value="1">1 LRA</option>
                                                            <option value="2">2 LRA (SAP)</option>
                                                            <option value="5">5 LRA Per Periode</option>
                                                            <option value="7">7 LRA Semester Pertama dan Prognosis</option>
                                                            <option value="8">8 LRA Per Sumber Dana</option>
                                                            <option value="9">9 LRA Prognosis Permendagri</option>
                                                            <option value="10">10 Rekap LRA Prognosis Permendagri</option>
                                                            <option value="11">11 LRA Permendagri 32</option>
                                                        </select>
                                                    </div>
		                                            ';
        }
        else
        {
            $output									= '
                                                    <div class="form-group mb-1">
                                                        <label class="control-label mb-1">
                                                            Jenis Laporan
                                                        </label>
                                                        <select name="jenis_laporan" class="form-control form-control-sm">
                                                            <option value="1">1 NERACA SETELAH PENGGABUNGAN</option>
                                                            <option value="2">2 NERACA SETELAH PENGGABUNGAN (SAP)</option>
                                                            <option value="5">5 NERACA SEBELUM PENGGABUNGAN</option>
                                                            <option value="6">6 NERACA SEBELUM PENGGABUNGAN (SAP)</option>
                                                            <option value="7">7 NERACA LAJUR</option>
                                                        </select>
                                                    </div>
		                                            ';
        }

        return $output;
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

	private function _rekening($rek4 = null, $rek5 = null)
	{
        $this->model->database_config('default');
        $query		                                = $this->model->query
        ('
            SELECT
                ref_rek_1.kd_rek_1,
                ref_rek_1.nm_rek_1
            FROM
                ref_rek_1
        ')
            ->result();

        $options							        = '<option value="%">Pilih Semua</option>';
        if($query)
        {
            foreach($query as $key => $val)
            {
                $options					        .= '<option value="' . $val->kd_rek_1 . '">' . $val->kd_rek_1 . '. ' . $val->nm_rek_1 . '</option>';
            }
            return '
                <div class="form-group mb-1">
                    <label class="control-label mb-1">
                        Akun
                    </label>
                    <select name="akun" class="form-control bordered form-control-sm report-dropdown" placeholder="Silakan Pilih Unit" to-change=".akun">
                        ' . $options . '
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label class="control-label mb-1">
                        Kelompok
                    </label>
                    <select name="kelompok" class="form-control bordered form-control-sm report-dropdown akun" placeholder="Pilih Akun terlebih dahulu" to-change=".kelompok" disabled>
                        
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label class="control-label mb-1">
                        Jenis
                    </label>
                    <select name="jenis" class="form-control bordered form-control-sm report-dropdown kelompok" placeholder="Pilih Kelompok terlebih dahulu" to-change=".jenis" disabled>
                        
                    </select>
                </div>
                ' . ($rek4 ? '
                <div class="form-group mb-1">
                    <label class="control-label mb-1">
                        Obyek
                    </label>
                    <select name="obyek" class="form-control bordered form-control-sm report-dropdown jenis" placeholder="Pilih Jenis terlebih dahulu" to-change=".obyek" disabled>
                        
                    </select>
                </div>
                ' : null) . '
                ' . ($rek5 ? '
                <div class="form-group mb-1">
                    <label class="control-label mb-1">
                        Rincian Obyek
                    </label>
                    <select name="rincian" class="form-control bordered form-control-sm report-dropdown obyek" placeholder="Pilih Obyek terlebih dahulu" disabled>
                        
                    </select>
                </div>
                ' : null) . '
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
        elseif('.akun' == $element)
        {
            $query									= $this->model->select
            ('
				ref_rek_2.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_2.nm_rek_2
			')
                ->order_by('ref_rek_2.kd_rek_2')
                ->get_where
                (
                    'ref_rek_2',
                    array
                    (
                        'ref_rek_2.kd_rek_1'		=> $list[0]
                    ),
                    NULL,
                    NULL,
                    50,
                )
                ->result_array();
            if($query)
            {
                $options							= '<option value="%">Silakan pilih Kelompok</option>';
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '">' . $val['kd_rek_2'] . '. ' . $val['nm_rek_2'] . '</option>';
                }
            }
        }
        elseif('.kelompok' == $element)
        {
            $query									= $this->model->select
            ('
				ref_rek_3.kd_rek_1,
				ref_rek_3.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_3.nm_rek_3
			')
                ->order_by('ref_rek_3.kd_rek_3')
                ->get_where
                (
                    'ref_rek_3',
                    array
                    (
                        'ref_rek_3.kd_rek_1'		=> $list[0],
                        'ref_rek_3.kd_rek_2'		=> $list[1]
                    ),
                    NULL,
                    NULL,
                    50,
                )
                ->result_array();
            if($query)
            {
                $options							= '<option value="%">Silakan pilih Jenis</option>';
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '.' . $val['kd_rek_3'] . '">' . $val['kd_rek_3'] . '. ' . $val['nm_rek_3'] . '</option>';
                }
            }
        }
        elseif('.jenis' == $element)
        {
            $query									= $this->model->select
            ('
				ref_rek_4.kd_rek_1,
				ref_rek_4.kd_rek_2,
				ref_rek_4.kd_rek_3,
				ref_rek_4.kd_rek_4,
				ref_rek_4.nm_rek_4
			')
                ->order_by('ref_rek_4.kd_rek_4')
                ->get_where
                (
                    'ref_rek_4',
                    array
                    (
                        'ref_rek_4.kd_rek_1'		=> $list[0],
                        'ref_rek_4.kd_rek_2'		=> $list[1],
                        'ref_rek_4.kd_rek_3'		=> $list[2]
                    ),
                    NULL,
                    NULL,
                    50,
                )
                ->result_array();
            if($query)
            {
                $options							= '<option value="%">Silakan pilih Obyek</option>';
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '.' . $val['kd_rek_3'] . '.' . $val['kd_rek_4'] . '">' . $val['kd_rek_4'] . '. ' . $val['nm_rek_4'] . '</option>';
                }
            }
        }
        elseif('.obyek' == $element)
        {
            $query									= $this->model->select
            ('
				ref_rek_5.kd_rek_1,
				ref_rek_5.kd_rek_2,
				ref_rek_5.kd_rek_3,
				ref_rek_5.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_5.nm_rek_5
			')
                ->order_by('ref_rek_5.kd_rek_5')
                ->get_where
                (
                    'ref_rek_5',
                    array
                    (
                        'ref_rek_5.kd_rek_1'		=> $list[0],
                        'ref_rek_5.kd_rek_2'		=> $list[1],
                        'ref_rek_5.kd_rek_3'		=> $list[1],
                        'ref_rek_5.kd_rek_4'		=> $list[1]
                    ),
                    NULL,
                    NULL,
                    50,
                )
                ->result_array();
            if($query)
            {
                $options							= '<option value="%">Silakan pilih Rincian Obyek</option>';
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val['kd_rek_1'] . '.' . $val['kd_rek_2'] . '.' . $val['kd_rek_3'] . '.' . $val['kd_rek_4'] . '.' . $val['kd_rek_4'] . '">' . $val['kd_rek_5'] . '. ' . $val['nm_rek_5'] . '</option>';
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
