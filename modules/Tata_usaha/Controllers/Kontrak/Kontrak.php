<?php namespace Modules\Tata_usaha\Controllers\Kontrak;
/**
 * Tata Usaha > Kontrak
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
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }

		// must be called after set_theme()
		$this->database_config('default');
	}

	public function index()
	{
        if('dropdown' == service('request')->getPost('trigger'))
        {
            return $this->_dropdown();
        }

		if(service('request')->getPost('_token'))
		{
            if(in_array($this->_method, array('create')))
            {
                if(empty(service('request')->getPost('program')))
                {
                    return throw_exception(403, 'Bidang Program Kegiatan dibutuhkan ...');
                }
            }

            list($r1, $r2, $r3, $r4, $r5, $r6)	    = array_pad(explode('.', service('request')->getPost('program')), 5, 0);
            list($r7)	                            = array_pad(explode('.', service('request')->getPost('kegiatan')), 5, 0);

            $this->set_default
            (
                array
                (
                    'kd_urusan'					    => $r1,
                    'kd_bidang'					    => $r2,
                    'kd_unit'					    => $r3,
                    'kd_sub'					    => $r4,
                    'kd_prog'					    => $r5,
                    'id_prog'					    => $r6,
                    'kd_keg'					    => $r7
                )
            );
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

        if(in_array($this->_method, array('create', 'update'))){
            $this->set_field('kd_prog', 'custom_format', 'callback_kode_program');
        }
        else
        {
            $this->set_field('kd_prog', 'custom_format', 'callback_kode_program_uraian');
            $this->set_field('kd_keg', 'custom_format', 'callback_kode_kegiatan_uraian');
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
		->set_primary('tahun, no_kontrak, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, waktu, nm_perusahaan, bentuk, alamat, nm_pemilik, npwp, nm_bank, nm_rekening, no_rekening')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_keg, id_prog')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog')
		->column_order('kd_prog, no_kontrak, tgl_kontrak, nilai')
		->view_order('kd_prog, kd_keg, no_kontrak, tgl_kontrak, nilai')
		->set_field
		(
			'no_kontrak',
			'hyperlink',
			'tata_usaha/kontrak/addendum',
			array
			(
				'no_kontrak'						=> 'no_kontrak'
			)
		)
		->field_position
		(
			array
			(
				'nm_perusahaan'						=> 2,
				'bentuk'							=> 2,
				'alamat'							=> 2,
				'nm_pemilik'						=> 2,
				'npwp'								=> 2,
				'nm_bank'							=> 3,
				'nm_rekening'						=> 3,
				'no_rekening'						=> 3
			)
		)
		->set_field
		(
			array
			(
				'tgl_kontrak'						=> 'datepicker',
				'nilai'								=> 'price_format'
			)
		)
		->set_alias
		(
			array
			(
				'no_kontrak'						=> 'No Kontrak',
				'tgl_kontrak'						=> 'Tanggal',
				'kd_prog'							=> 'Program',
				'kd_keg'							=> 'Kegiatan'
			)
		)
		->set_validation
		(
			array
			(
				'no_kontrak'						=> 'required|callback_validasi_no_kontrak',
                'nilai'								=> 'callback_validasi_nilai',
				'tgl_kontrak'						=> 'required'
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
	
	public function validasi_no_kontrak($value = 0)
	{
        if(in_array($this->_method, array('create')))
        {
            $query										= $this->model->select
            ('
			    no_kontrak,
			    tgl_kontrak
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
                        'kd_sub'							=> service('request')->getGet('kd_sub'),
                        'no_kontrak'						=> $value
                    )
                )
                ->row();

            if(isset($query))
            {
                return 'No Kontrak ' . $value . ' sudah terdaftar';
            }
        }
		
		return true;
	}

    public function validasi_nilai($value = 0)
    {
        if(!$value)
        {
            return 'Bidang Nilai dibutuhkan !';
        }

        return true;
    }
	
	public function kode_program($params = array())
	{
		$exists										=(isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0);
		
		$query										= $this->model->select
		('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			kd_prog,
			id_prog,
			ket_program
		')
		->get_where
		(
			'ta_program',
			array
			(
				'tahun'					            => get_userdata('year'),
				'kd_urusan'				            => service('request')->getGet('kd_urusan'),
				'kd_bidang'				            => service('request')->getGet('kd_bidang'),
				'kd_unit'				            => service('request')->getGet('kd_unit'),
				'kd_sub'					        => service('request')->getGet('kd_sub'),
				'kd_prog >'				            => 0
			)
		)
		->result();

        $options									= null;
        $output										= null;
		foreach($query as $key => $val)
		{
            $options								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . ' - ' . $val->ket_program .'</option>';
		}

        $output										.= '
			<div class="form-group">
				<select name="program" class="form-control form-control-sm report-dropdown" to-change=".kegiatan">
					<option value="">Silakan pilih Program</option>
					' . $options . '
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Kegiatan
				</label>
				<select name="kegiatan" class="form-control form-control-sm kegiatan get-dropdown-content" disabled>
					<option value="">Silakan pilih Program terlebih dahulu</option>
				</select>
			</div>
		';

        return $output;
	}

    public function kode_program_uraian($params = array())
    {
        $query										= $this->model->select
        ('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			kd_prog,
			ket_program
		')
            ->get_where
            (
                'ta_program',
                array
                (
                    'tahun'					            => get_userdata('year'),
                    'kd_urusan'				            => $params['kd_urusan']['original'],
                    'kd_bidang'				            => $params['kd_bidang']['original'],
                    'kd_unit'				            => $params['kd_unit']['original'],
                    'kd_sub'					        => $params['kd_sub']['original'],
                    'kd_prog'					        => $params['kd_prog']['original'],
                    'id_prog'					        => $params['id_prog']['original']
                )
            )
            ->row();

        $program									= null;
        if(isset($query))
        {
            $program								.= '' . $query->kd_urusan . '.' . $query->kd_bidang . '.' . $query->kd_unit . '.' . $query->kd_sub . '' . $query->kd_prog . ' - ' . $query->ket_program . '';
        }

        return $program;
    }

    public function kode_kegiatan_uraian($params = array())
    {
        $query										= $this->model->select
        ('
			kd_keg,
			ket_kegiatan
		')
            ->get_where
            (
                'ta_kegiatan',
                array
                (
                    'tahun'					            => get_userdata('year'),
                    'kd_urusan'				            => $params['kd_urusan']['original'],
                    'kd_bidang'				            => $params['kd_bidang']['original'],
                    'kd_unit'				            => $params['kd_unit']['original'],
                    'kd_sub'					        => $params['kd_sub']['original'],
                    'kd_prog'					        => $params['kd_prog']['original'],
                    'id_prog'					        => $params['id_prog']['original'],
                    'kd_keg'					        => $params['kd_keg']['original']
                ),
                NULL,
                NULL,
                50,
            )
            ->row();

        $program									= null;
        if(isset($query))
        {
            $program								.= '' . $query->kd_keg . ' - ' . $query->ket_kegiatan . '';
        }

        return $program;
    }

    private function _dropdown()
    {
        $primary									= service('request')->getPost('primary');
        $list										= $primary != '' ? explode(".", $primary) : null;
        $element									= service('request')->getPost('element');
        $options									= null;

        if('.kegiatan' == $element)
        {
            $query									= $this->model->select
            ('
			    kd_keg,
			    ket_kegiatan
		    ')
                ->get_where
                (
                    'ta_kegiatan',
                    array
                    (
                        'kd_urusan'		            => $list[0],
                        'kd_bidang'		            => $list[1],
                        'kd_unit'		            => $list[2],
                        'kd_sub'		            => $list[3],
                        'kd_prog'		            => $list[4],
                        'id_prog'		            => $list[5]
                    )
                )
                ->result();

            if($query)
            {
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val->kd_keg . '">' . $val->kd_keg . ' - ' . $val->ket_kegiatan . '</option>';
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
