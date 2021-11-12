<?php namespace Modules\Tata_usaha\Controllers\Tagihan;
/**
 * Tata Usaha > Kontrak
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Non_kontrak extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_tagihan';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');

        $this->_urusan								= service('request')->getGet('kd_urusan');

        if(!$this->_urusan)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('../sub_unit_non_kontrak'));
        }
		
		// must be called after set_theme()
		$this->database_config('default');
	}

	public function index()
	{
		$header										= $this->_header();
		if($header)
		{
			$this->set_description
			('
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						sub unit
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_urusan . '.' . $header->kd_bidang . '.' . $header->kd_unit . '.' . $header->kd_sub . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_sub_unit . '
					</label>
				</div>
			');
		}
		
		$this->set_breadcrumb
		(
			array
			(
                'tata_usaha/tagihan/sub_unit_non_kontrak' => 'Tata Usaha Tagihan'
			)
		);
		
		$this->set_title('Non Kontrak')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, no_tagihan, kd_urusan, kd_bidang, kd_unit, kd_sub')
        ->unset_action('export, print, pdf')
        ->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_kontrak, realisasi_fisik, pct_um, nilai_um')
        ->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_kontrak, realisasi_fisik, pct_um, nilai_um')
        ->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_kontrak, realisasi_fisik, pct_um, nilai_um')
        ->unset_truncate('ur_tagihan')
        ->field_prepend
        (
            array
            (
                'nilai'								=> 'Rp'
            )
        )
        ->set_field
        (
            array
            (
                'tgl_tagihan'						=> 'datepicker',
                'nilai'								=> 'price_format'
            )
        )
        ->set_alias
        (
            array
            (
                'no_tagihan'						=> 'Nomor Tagihan',
                'tgl_tagihan'						=> 'Tanggal',
                'jns_tagihan'						=> 'Jenis',
                'nm_tagihan'						=> 'Jenis',
                'ur_tagihan'						=> 'Keterangan',
                'nilai'						        => 'Nilai'
            )
        )
        ->set_validation
        (
            array
            (
                'no_tagihan'						=> 'required',
                'jns_tagihan'						=> 'required',
                'ur_tagihan'						=> 'required',
                'nilai'								=> 'callback_validasi_nilai'
            )
        )
        ->set_default
        (
            array
            (
                'tahun'								=> get_userdata('year'),
                'kd_urusan'							=> service('request')->getGet('kd_urusan'),
                'kd_bidang'							=> service('request')->getGet('kd_bidang'),
                'kd_unit'							=> service('request')->getGet('kd_unit'),
                'kd_sub'							=> service('request')->getGet('kd_sub')
            )
        )
        ->set_relation
        (
            'jns_tagihan',
            'ref_jenis_tagihan.jns_tagihan',
            '{ref_jenis_tagihan.jns_tagihan} - {ref_jenis_tagihan.nm_tagihan}',
            array
            (
                'ref_jenis_tagihan.jns_tagihan IN'	=> array('1', '5')
                ),
            null,
            array
            (
                'ref_jenis_tagihan.jns_tagihan'		=> 'ASC'
            )
        )
        ->where
        (
            array
            (
                'tahun'								=> get_userdata('year'),
                'kd_urusan'							=> service('request')->getGet('kd_urusan'),
                'kd_bidang'							=> service('request')->getGet('kd_bidang'),
                'kd_unit'							=> service('request')->getGet('kd_unit'),
                'kd_sub'							=> service('request')->getGet('kd_sub'),
                //'no_kontrak'                      => null // belum bisa
            )
        )
        ->render($this->_table);
	}

    public function validasi_nilai($value = 0)
    {
        if(!$value)
        {
            return 'Bidang Nilai dibutuhkan !';
        }

        $query_nilai							    = $this->model->select
        ('
			nilai
		')
		->get_where
		(
			'ta_kontrak',
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub')
				//'no_kontrak'						=> service('request')->getGet('no_kontrak') // nomor kontrak null
			)
		)
		->row('nilai');
		
        if($query_nilai < $value)
        {
            return 'Total Nilai Tagihan lebih besar dari Nilai Kontrak !!! <br> Total Nilai Tagihan Rp. ' . number_format($value, 2) . ' <br> Nilai Kontrak Rp. ' . number_format($query_nilai, 2). '';
        }

        return true;
    }
	
	private function _header()
	{
		$query										= $this->model->select
		('
			ta_kegiatan.kd_urusan,
			ta_kegiatan.kd_bidang,
			ta_kegiatan.kd_unit,
			ta_kegiatan.kd_sub,
			ta_kegiatan.kd_keg,
			ta_kegiatan.kd_prog,
			ta_kegiatan.ket_kegiatan,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan and ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang and ref_sub_unit.kd_unit = ta_kegiatan.kd_unit and ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
		)
		->get_where
		(
			'ta_kegiatan',
			array
			(
				'ta_kegiatan.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_kegiatan.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_kegiatan.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_kegiatan.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_kegiatan.kd_keg'				=> 0
			)
		)
		->row();
		
		return $query;
	}
}