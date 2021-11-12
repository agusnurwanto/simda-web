<?php namespace Modules\Bendahara\Controllers\Mutasi;
/**
 * Bendahara > Mutasi
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Mutasi extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_mutasi_kas';

	public function __construct()
	{
		parent::__construct();

		$this->set_permission();
		$this->set_theme('backend');

		// must be called after set_theme()
		$this->database_config('default');

		$this->_urusan								= service('request')->getGet('kd_urusan');

		if(!$this->_urusan)
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
		}
	}

	public function index()
	{
        if(service('request')->getPost('_token'))
        {
            if(in_array($this->_method, array('create')))
            {
                if(empty(service('request')->getPost('kd_prog') || empty(service('request')->getPost('kd_rekening'))))
                {
                    return throw_exception(403, 'Bidang Rekening Program dibutuhkan ...');
                }
            }

        }

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
				'bendahara/mutasi/sub_unit'			=> 'Bendahara Pengeluaran Mutasi',
			)
		);

		$this->set_title('Mutasi')
		->set_icon('mdi mdi-smoking')
		->set_primary('tahun, no_bukti, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, tgl_input, operator')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, tgl_input, operator')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, tgl_input, operator')
		->unset_truncate('uraian')
		->column_order('no_bukti, tgl_bukti, no_bku, uraian, nilai')

		->field_position
		(
			array
			(
				'uraian'							=> 2,
				'nilai'								=> 2,
				'kd_mutasi'							=> 2,
				'rek_penerima'						=> 2,
				'npwp'								=> 2
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
				'tgl_bukti'							=> 'datepicker',
				'nilai'								=> 'price_format'
			)
		)
		->set_field
		(
			'kd_mutasi',
			'radio',
			array
			(
				1									=> '<label class="badge badge-success">Kas Bank ke Kas Tunai</label>',
				2									=> '<label class="badge badge-warning">Kas Tunai ke Kas Bank</label>'
			)
		)
		->set_alias
		(
			array
			(
				'kd_mutasi'							=> 'Kode Mutasi'
			)
		)
		->set_validation
		(
			array
			(
				'no_bukti'							=> 'required',
				'tgl_bukti'							=> 'required',
				'no_bku'							=> 'required',
                'nilai'								=> 'callback_validasi_nilai',
				'uraian'							=> 'required',
				'kd_mutasi'							=> 'required'
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
