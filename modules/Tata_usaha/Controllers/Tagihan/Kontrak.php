<?php namespace Modules\Tata_usaha\Controllers\Tagihan;
/**
 * Tata Usaha > Tagihan > Kontrak
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Kontrak extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_kontrak';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');

        $this->_urusan								= service('request')->getGet('kd_urusan');
        if(!$this->_urusan)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('../sub_unit_kontrak'));
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
                'tata_usaha/tagihan/sub_unit_kontrak' => 'Tata Usaha Tagihan'
			)
		);
		
		$this->set_title('Kontrak')
		->set_icon('mdi mdi-spotlight')
		->set_primary('tahun, no_kontrak, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf, create, update, delete')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, waktu, nm_perusahaan, bentuk, alamat, nm_pemilik, npwp, nm_bank, nm_rekening, no_rekening')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog')
        ->column_order('no_kontrak, tgl_kontrak, nilai, kd_prog, kd_keg, id_prog, keperluan')
		->unset_truncate('keperluan')
        ->merge_content('{kd_prog} . {kd_keg}', 'Program Kegiatan')
        ->set_field
        (
            'no_kontrak',
            'hyperlink',
            'tata_usaha/tagihan/tagihan_kontrak',
            array
            (
                'kd_urusan'							=> 'kd_urusan',
                'kd_bidang'							=> 'kd_bidang',
                'kd_unit'							=> 'kd_unit',
                'kd_sub'							=> 'kd_sub',
                'no_kontrak'						=> 'no_kontrak'
            )
        )
        ->field_position
        (
            array
            (
                'nm_perusahaan'						=> 2,
                'bentuk'							=> 2,
                'alamat'						    => 2,
                'nm_pemilik'						=> 2,
                'npwp'								=> 2,
                'nm_bank'							=> 2,
                'nm_rekening'						=> 2,
                'no_rekening'						=> 2
            )
        )
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
				'ur_tagihan'						=> 'textarea',
				'nilai'								=> 'price_format'
			)
		)
		->set_alias
		(
			array
			(
				'nm_perusahaan'						=> 'Nomor Perusahaan',
				'no_kontrak'						=> 'Nomor Kontrak',
				'tgl_kontrak'						=> 'Tanggal Kontrak',
				'nilai'								=> 'Nilai Kontrak',
                'nm_pemilik'						=> 'Nama Pemilik',
                'nm_bank'							=> 'Nama Bank',
                'nm_rekening'						=> 'Nama Rekening',
                'no_rekening'						=> 'Nomor Rekening'
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
				'kd_sub'							=> service('request')->getGet('kd_sub')
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

        return true;
    }

/*	public function validasi_spd($value = 0)
	{
		$query										= $this->model->get_where
		(
			'ta_spd',
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_spd'							=> $value
			)
		)
		->row();

		if($query)
		{
			return 'Nomor SPD '.$value.' Sudah Ada. Silahkan isi dengan nomor yang lain';
		}

		return true;
	}*/

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
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan AND ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang AND ref_sub_unit.kd_unit = ta_kegiatan.kd_unit AND ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
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
