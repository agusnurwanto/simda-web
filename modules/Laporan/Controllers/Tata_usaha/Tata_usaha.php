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

		$this->report								= new \Modules\Laporan\Models\Tata_usaha();

		$this->_template							= 'Modules\Laporan\Views\\' . service('request')->uri->getSegment(2) . (service('request')->uri->getSegment(3) ? '\\' . service('request')->uri->getSegment(3) : null);

		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}

        $this->kd_sub                               = !empty(service('request')->getGet('sub_unit')) ? service('request')->getGet('sub_unit') : '%';
		//print_r($this->kd_sub);exit;
		if(!empty(service('request')->getGet('unit')) && service('request')->getGet('unit') != 'all'){
			list
				(
					$this->kd_urusan,
					$this->kd_bidang,
					$this->kd_unit
				)									= array_pad(explode('.', service('request')->getGet('unit')), 7, 0);
		}
		else
        {
            $this->kd_urusan                        = "'%'";
            $this->kd_bidang                        = "'%'";
            $this->kd_unit                          = "'%'";
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
		$this->set_title('Tata Usaha')
		->set_icon('mdi mdi-cash-multiple')
		->set_output('results', $this->_laporan())
		->render();
	}

	/**
	 * Laporan Tata Usaha
	 */
	public function register_spp()
	{
		/*if(!($this->kd_sub))
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
		}*/

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan,
            'kd_bidang'								=> $this->kd_bidang,
            'kd_unit'								=> $this->kd_unit,
            'kd_sub'								=> $this->kd_sub,
            'periode_awal'							=> service('request')->getGet('periode_awal'),
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jn_spm'							    => service('request')->getGet('jn_spm'),
            'jn_dok'							    => service('request')->getGet('jn_dok')
		);

		$this->_title								= 'Register Spp';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->register_spp($params);

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

	public function spm_anggaran()
	{
		if( '%' == service('request')->getGet('jn_spm'))
		{
			return throw_exception(301, 'Silakan memilih No SPM terlebih dahulu...', current_page('../'));
		}

		$params										= array
		(
            'tahun'									=> get_userdata('year'),
            'no_spm'							    => service('request')->getGet('jn_spm')
		);

		$this->_title								= 'SPM Anggaran';
		$this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
		$this->_output								= $this->report->spm_anggaran($params);

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

    public function register_spm()
    {
/*        if(!($this->kd_sub))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', current_page('../'));
        }*/

        $params										= array
        (
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan,
            'kd_bidang'								=> $this->kd_bidang,
            'kd_unit'								=> $this->kd_unit,
            'kd_sub'								=> $this->kd_sub,
            'periode_awal'							=> service('request')->getGet('periode_awal'),
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jn_spm'							    => service('request')->getGet('jn_spm'),
            'jn_dok'							    => service('request')->getGet('jn_dok')
        );

        $this->_title								= 'Register Spm';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_spm($params);

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

    public function register_penolakan_penerbitan_spm()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jn_spm'							    => service('request')->getGet('jn_spm')
        );

        $this->_title								= 'Register Penolakan Penerbitan Spm';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_penolakan_penerbitan_spm($params);

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

    public function register_penerimaan_spj()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir')
        );

        $this->_title								= 'Register Penerimaan Spj';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_penerimaan_spj($params);

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

    public function register_pengesahan_spj()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir')
        );

        $this->_title								= 'Register Pengesahan Spj';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_pengesahan_spj($params);

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

    public function register_penolakan_spj()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir')
        );

        $this->_title								= 'Register Penolakan Pengesahan Spj';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_penolakan_spj($params);

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

    public function register_sp2d()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jn_spm'							    => service('request')->getGet('jn_spm')
        );

        $this->_title								= 'Register SP2D';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_sp2d($params);

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

    public function register_sp2d_tu()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir'),
            'jn_spm'							    => service('request')->getGet('jn_spm')
        );

        $this->_title								= 'Register SP2D TU yang Belum DI-SPJ-kan';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_sp2d_tu($params);

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

    public function register_spj_sp2d()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir')
        );

        $this->_title								= 'Register SPJ - SP2D';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_spj_sp2d($params);

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

    public function register_spp_sp2d()
    {
        if(!($this->kd_sub))
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
            'periode_akhir'							=> service('request')->getGet('periode_akhir')
        );

        $this->_title								= 'Register SPP - SP2D (UP, TU, LS)';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_spp_sp2d($params);

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

    public function pengesahan_spj()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Pengesahan SPJ';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->pengesahan_spj($params);

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

    public function laporan_pengesahan_spj()
    {
        if(!(service('request')->getGet('no_pengesahan')))
        {
            return throw_exception(301, 'Silakan memilih No Pengesahan terlebih dahulu...', current_page('../'));
        }

        $params										= array
        (
            'tahun'									=> get_userdata('year'),
            'kd_urusan'								=> $this->kd_urusan,
            'kd_bidang'								=> $this->kd_bidang,
            'kd_unit'								=> $this->kd_unit,
            'kd_sub'								=> $this->kd_sub,
            'no_pengesahan'							=> service('request')->getGet('no_pengesahan')
        );

        $this->_title								= 'Laporan Pengesahan SPJ';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->laporan_pengesahan_spj($params);

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

    public function pengawasan_anggaran()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Pengawasan Anggaran Definitif Per Kegiatan';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->pengawasan_anggaran($params);

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

    public function register_kontrak()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Register Kontrak / SPK';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_kontrak($params);

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

    public function daftar_realisasi()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Daftar Realisasi Pembayaran Kontrak';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->daftar_realisasi($params);

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

    public function realisasi_pembayaran()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Realisasi Pembayaran Per Nomor Kontrak';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->realisasi_pembayaran($params);

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

    public function register_sp3b()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Register SP3B';
        $this->_pageSize							= (3 == service('request')->getGet('kd_perubahan') ? '13in 8.5in' : null);
        $this->_output								= $this->report->register_sp3b($params);

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

    public function kendali_rincian_kegiatan_per_opd()
    {
        if(!($this->kd_sub))
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

        $this->_title								= 'Kendali Rincian Kegiatan per OPD';
        $this->_pageSize							= '13in 8.5in';
        $this->_output								= $this->report->kendali_rincian_kegiatan_per_opd($params);

        if(!($this->_output['data']))
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
                'title'								=> 'Register SPP',
                'description'						=> 'Laporan Register SPP',
                'icon'								=> 'mdi-chart-arc',
                'color'								=> 'bg-primary',
                'placement'							=> 'left',
                'controller'						=> 'register_spp',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_spm'					    => $this->_spm('', 'Jenis'),
                    'jenis_dok'					    => $this->_dok()
                    //'tanggal_cetak'					=> $this->_tanggal_cetak()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'SPM Anggaran',
                'description'						=> 'Laporan SPM Anggaran',
                'icon'								=> 'mdi-chart-bell-curve',
                'color'								=> 'bg-teal',
                'placement'							=> 'left',
                'controller'						=> 'spm_anggaran',
                'parameter'							=> array
                (
                    'no_spm'					    => $this->_spm('spm', 'No SPM'),
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register SPM',
                'description'						=> 'Laporan Register SPM',
                'icon'								=> 'mdi-chart-areaspline',
                'color'								=> 'bg-danger',
                'placement'							=> 'left',
                'controller'						=> 'register_spm',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_spm'					    => $this->_spm('', 'Jenis SPM'),
                    'jenis_dok'					    => $this->_dok()
                    //'tanggal_cetak'					=> $this->_tanggal_cetak()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register Penolakan Penerbitan SPM',
                'description'						=> 'Laporan Register Penolakan Penerbitan SPM',
                'icon'								=> 'mdi-chart-bar',
                'color'								=> 'bg-maroon',
                'placement'							=> 'left',
                'controller'						=> 'register_penolakan_penerbitan_spm',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_spm'					    => $this->_spm('', 'Jenis SPP'),
                    //'tanggal_cetak'					=> $this->_tanggal_cetak()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register Penerimaan SPJ',
                'description'						=> 'Laporan Register Penerimaan SPJ',
                'icon'								=> 'mdi-comment-account-outline',
                'color'								=> 'bg-success',
                'placement'							=> 'left',
                'controller'						=> 'register_penerimaan_spj',
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
                'title'								=> 'Register Pengesahaan SPJ',
                'description'						=> 'Laporan Register Pengesahaan SPJ',
                'icon'								=> 'mdi-chart-bar-stacked',
                'color'								=> 'bg-info',
                'placement'							=> 'left',
                'controller'						=> 'register_pengesahan_spj',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    //'tanggal_cetak'					=> $this->_tanggal_cetak()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register Penolakan Pengesahan SPJ',
                'description'						=> 'Laporan Bendahara Pengeluaran - Laporan SPJ',
                'icon'								=> 'mdi-comment-check-outline',
                'color'								=> 'bg-primary',
                'placement'							=> 'left',
                'controller'						=> 'register_penolakan_spj',
                'parameter'							=> array
                (
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    //'tanggal_cetak'					=> $this->_tanggal_cetak()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register SP2D',
                'description'						=> 'Laporan Register SP2D',
                'icon'								=> 'mdi-chart-pie',
                'color'								=> 'bg-teal',
                'placement'							=> 'left',
                'controller'						=> 'register_sp2d',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'jenis_spm'					    => $this->_spm('', 'Jenis SPP'),
                    //'tanggal_cetak'					=> $this->_tanggal_cetak()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Register SP2D TU yang Belum DI-SPJ-kan',
                'description'						=> 'Laporan Register SP2D TU yang Belum DI-SPJ-kan',
                'icon'								=> 'mdi-soy-sauce',
                'color'								=> 'bg-danger',
                'placement'							=> 'left',
                'controller'						=> 'register_sp2d_tu',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
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
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
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
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
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
                    'unit_sub_unit'					=> $this->_unit_sub_unit(),
                    'bulan'					        => $this->_month(),
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
                    'spj'					        => $this->_spj()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Pengawasan Anggaran Definitif Per Kegiatan',
                'description'						=> 'Laporan Pengawasan Anggaran Definitif Per Kegiatan',
                'icon'								=> 'mdi-cash-register',
                'color'								=> 'bg-success',
                'placement'							=> 'right',
                'controller'						=> 'pengawasan_anggaran',
                'parameter'							=> array
                (
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit()
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
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit()
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
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit()
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
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit()
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
                    'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit()
                )
            ),
            array
            (
                //'user_group'						=> array(1),
                'title'								=> 'Kendali Rincian Kegiatan per OPD',
                'description'						=> 'Kendali Rincian Kegiatan per OPD',
                'icon'								=> 'mdi-book-multiple',
                'color'								=> 'bg-teal',
                'placement'							=> 'right',
                'controller'						=> 'kendali_rincian_kegiatan_per_opd',
                'parameter'							=> array
                (
                    //'tanggal_periode'				=> $this->_tanggal_periode(),
                    'unit_sub_unit'					=> $this->_unit_sub_unit_all()
                )
            ),
        );
    }

	/**
	 * Function Dropdown Sub Unit
	 */
    private function _spj()
    {
        $this->model->database_config('default');

        $output										= null;
        $query                                      = $this->model
                                                    ->select('ta_pengesahan_spj_rinc.no_pengesahan')
                                                    ->join('ta_pengesahan_spj', 'ta_pengesahan_spj_rinc.no_pengesahan = ta_pengesahan_spj.no_pengesahan')
                                                    ->order_by('ta_pengesahan_spj_rinc.no_pengesahan', 'ASC')
                                                    ->group_by('ta_pengesahan_spj_rinc.no_pengesahan')
                                                    ->get_where('ta_pengesahan_spj_rinc')
                                                    ->result_array();

        if($query)
        {
            foreach($query as $key => $val)
            {
                $output								.= '<option value="' . $val['no_pengesahan'] . '">' . $val['no_pengesahan'] . '</option>';
            }
        }
        $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					No. Pengesahaan
				</label>
				<select name="no_pengesahan" class="form-control form-control-sm">
					' . $output . '
				</select>
			</div>
		';
        return $output;
    }

    private function _spm($jenis = null, $nama = null)
    {
        $this->model->database_config('default');

        $output										= '<option value="%">Silahkan Pilih</option>';

        if($jenis == 'spm')
        {
            $query									= $this->model
                                                    ->select('ta_spm.no_spm AS jn_spm')
                                                    ->join('ta_spm_rinc', 'ta_spm.no_spm = ta_spm.no_spm')
                                                    ->order_by('ta_spm.no_spm', 'ASC')
                                                    ->group_by('ta_spm.no_spm')
                                                    ->get_where('ta_spm')
                                                    ->result_array();
        }
        else
        {
            $query									= $this->model
                                                    ->select('jn_spm, nm_jn_spm')
                                                    ->order_by('jn_spm', 'ASC')
                                                    ->get_where('ref_jenis_spm')
                                                    ->result_array();
        }

        if($query)
        {
            foreach($query as $key => $val)
            {
                if($jenis == 'spm')
                {
                    $output                         .= '<option value="' . $val['jn_spm'] . '">' . $val['jn_spm'] . '</option>';
                }
                else
                {
                    $output							.= '<option value="' . $val['jn_spm'] . '">' . $val['jn_spm'] . ' ' . $val['nm_jn_spm'] . '</option>';
                }

            }
        }
        $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					' . $nama . '
				</label>
				<select name="jn_spm" class="form-control form-control-sm">
					' . $output . '
				</select>
			</div>
		';
        return $output;
    }

    private function _dok()
    {
        $output										= '
			<div class="form-group mb-1">
				<label class="control-label mb-1">
					Jenis Dokumen
				</label>
				<select name="jn_dok" class="form-control form-control-sm">
					<option value="%">Pilih Semua</option>
					<option value="0">0 Draft</option>
					<option value="1">1 Final</option>
					<option value="2">2 Batal</option>
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
				$query		                        = $this->model->query
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
				$options							= '<option value="%">Pilih Semua Sub Unit</option>';

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
			$id_sub			                        = get_userdata('sub_unit');
			$query			                        = $this->model->query
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

	private function _unit_sub_unit_all()
	{
		// Global Administrator
		if(in_array(get_userdata('group_id'), array(1)))
		{
			$id_unit								= service('request')->getPost('primary');
			if($id_unit)
			{
				$query		                        = $this->model->query
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
				$options							= '<option value="%">Pilih Semua Sub Unit</option>';

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

				$options							= '<option value="all">Pilih Semua Unit</option>';
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
			$id_sub			                        = get_userdata('sub_unit');
			$query			                        = $this->model->query
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
