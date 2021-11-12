<?php namespace Modules\Tata_usaha\Controllers\Kontrak;
/**
 * Tata Usaha > Kontrak > Addendum
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Addendum extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_kontrak_addendum';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');

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
                    <label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						No Kontrak
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . service('request')->getGet('no_kontrak') . '
					</label>
				</div>
			');
		}

		$this->set_breadcrumb
		(
			array
			(
				'tata_usaha/kontrak'				=> 'Tata Usaha > Kontrak'
			)
		);
		
		$this->set_title('Kontrak')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, no_kontrak, no_addendum')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_kontrak, waktu, nilai')
		->unset_field('tahun, no_kontrak')
		->unset_view('tahun')
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
				'tgl_addendum'						=> 'datepicker',
                'nilai'								=> 'price_format'
			)
		)
		->set_alias
		(
			array
			(
				'no_addendum'						=> 'Nomor addendum',
				'tgl_addendum'						=> 'Tanggal'
			)
		)
		->set_validation
		(
			array
			(
				'no_addendum'						=> 'required',
				'tgl_kontrak'						=> 'required',
                'nilai'								=> 'callback_validasi_nilai',
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_kontrak'						=> service('request')->getGet('no_kontrak')
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_kontrak'						=> service('request')->getGet('no_kontrak')
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
