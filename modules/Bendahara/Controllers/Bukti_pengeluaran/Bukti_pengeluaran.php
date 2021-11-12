<?php namespace Modules\Bendahara\Controllers\Bukti_pengeluaran;
//use Config\Validation;

/**
 * Bendahara > Bukti Pengeluaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Bukti_pengeluaran extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spj_bukti';

	public function __construct()
	{
		parent::__construct();

        $this->_urusan								= service('request')->getGet('kd_urusan');

        if(!$this->_urusan)
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
        }

		$this->set_permission();
		$this->set_theme('backend');

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
                if(empty(service('request')->getPost('kd_prog') || empty(service('request')->getPost('kd_rekening'))))
                {
                    return throw_exception(403, 'Bidang Rekening Program dibutuhkan ...');
                }
            }

            list($r1, $r2, $r3, $r4, $r5, $r6, $r7)	= array_pad(explode('.', service('request')->getPost('kd_prog')), 5, 0);
            list($r8, $r9, $r10, $r11, $r12)	    = array_pad(explode('.', service('request')->getPost('kd_rekening')), 5, 0);

            $no_spd									= $this->model->query
            ('
                SELECT
                    ta_spd_rinc.no_spd
                FROM
                    ta_spd_rinc
                INNER JOIN ta_spd ON ta_spd_rinc.no_spd = ta_spd.no_spd
                WHERE
                    ta_spd_rinc.tahun = ' . get_userdata('year') . '
                    AND ta_spd_rinc.kd_urusan = ' . $r1 . '
                    AND ta_spd_rinc.kd_bidang = ' . $r2 . '
                    AND ta_spd_rinc.kd_unit = ' . $r3 . '
                    AND ta_spd_rinc.kd_sub = ' . $r4 . '
                    AND ta_spd_rinc.kd_prog = ' . $r5 . '
                    AND ta_spd_rinc.id_prog = ' . $r6 . '
                    AND ta_spd_rinc.kd_keg = ' . $r7 . '
                    AND ta_spd_rinc.kd_rek_1 = ' . $r8 . '
					AND ta_spd_rinc.kd_rek_2 = ' . $r9 . '
					AND ta_spd_rinc.kd_rek_3 = ' . $r10 . '
					AND ta_spd_rinc.kd_rek_4 = ' . $r11 . '
					AND ta_spd_rinc.kd_rek_5 = ' . $r12 . '
                GROUP BY ta_spd_rinc.no_spd
                ORDER BY ta_spd_rinc.no_spd DESC
            ')
                ->row('no_spd');

            $pejabat								= $this->model->query
            ('
            SELECT
                ta_sub_unit.nm_pimpinan AS nm_pa,
                ta_sub_unit.nip_pimpinan AS nip_pa,
                ta_sub_unit.jbt_pimpinan AS jbt_pa,
                ta_sub_unit_jab.nama AS nm_bendahara,
                ta_sub_unit_jab.nip AS nip_bendahara,
                ta_sub_unit_jab.jabatan AS jbt_bendahara
            FROM
                ta_sub_unit
            INNER JOIN ta_sub_unit_jab ON 
                ta_sub_unit_jab.tahun = ta_sub_unit.tahun
                AND ta_sub_unit_jab.kd_urusan = ta_sub_unit.kd_urusan
                AND ta_sub_unit_jab.kd_bidang = ta_sub_unit.kd_bidang
                AND ta_sub_unit_jab.kd_unit = ta_sub_unit.kd_unit
                AND ta_sub_unit_jab.kd_sub = ta_sub_unit.kd_sub
            WHERE
                ta_sub_unit_jab.tahun = ' . get_userdata('year') . '
                AND ta_sub_unit_jab.kd_urusan = ' . service('request')->getGet('kd_urusan') . '
                AND ta_sub_unit_jab.kd_bidang = ' . service('request')->getGet('kd_bidang') . '
                AND ta_sub_unit_jab.kd_unit = ' . service('request')->getGet('kd_unit') . '
                AND ta_sub_unit_jab.kd_sub = ' . service('request')->getGet('kd_sub') . '
                AND ta_sub_unit_jab.kd_jab = 4
        ')
                ->row();

			$this->set_default
			(
				array
				(
					'kd_urusan'						=> $r1,
					'kd_bidang'						=> $r2,
					'kd_unit'						=> $r3,
					'kd_sub'						=> $r4,
					'kd_prog'						=> $r5,
					'id_prog'						=> $r6,
					'kd_keg'						=> $r7,
					'kd_rek_1'						=> $r8,
					'kd_rek_2'						=> $r9,
					'kd_rek_3'						=> $r10,
					'kd_rek_4'						=> $r11,
					'kd_rek_5'						=> $r12,
                    'no_spd'						=> $no_spd,
                    'nm_pa'						    => $pejabat->nm_pa,
                    'nip_pa'						=> $pejabat->nip_pa,
                    'jbt_pa'						=> $pejabat->jbt_pa,
                    'nm_bendahara'					=> $pejabat->nm_bendahara,
                    'nip_bendahara'					=> $pejabat->nip_bendahara,
                    'jbt_bendahara'					=> $pejabat->jbt_bendahara
				)
			);
		}

		if(in_array($this->_method, array('create', 'update')))
		{
			$this->set_field('kd_prog', 'custom_format', 'callback_kode_program');
		}
		else
		{
			$this->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4');
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
				'bendahara/bukti_pengeluaran/sub_unit' => 'Bendahara Pengeluaran UP/GU'
			)
		);
		$this->set_title('Bukti Pengeluaran')
		->set_icon('mdi mdi-rhombus-split')
		->set_primary('tahun, no_bukti, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, id_prog, kd_pembayaran, no_spd, nm_penerima, alamat, nm_bendahara, nip_bendahara, jbt_bendahara, nm_pa, nip_pa, jbt_pa, no_spm, jn_spm, no_spj_panjar, no_bku, bank_penerima, rek_penerima, npwp, tgl_buat, tgl_edit, tgl_cetak, cair, tgl_cair, kd_sumber, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_5, nm_sumber')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_keg, no_spd, nm_bendahara, nip_bendahara, jbt_bendahara, nm_pa, nip_pa, jbt_pa, no_spm, jn_spm, no_spj_panjar, no_bku, tgl_buat, tgl_edit, tgl_cetak, cair, tgl_cair, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, kd_urusan, kd_bidang, id_prog, no_spd, nm_bendahara, nip_bendahara, jbt_bendahara, nm_pa, nip_pa, jbt_pa, no_spm, jn_spm, no_spj_panjar, no_bku, tgl_buat, tgl_edit, tgl_cetak, cair, tgl_cair, kd_sumber, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_5')
		->unset_truncate('uraian')
		->column_order('no_bukti, tgl_bukti, kd_unit, kd_rek_4, nilai')
		->field_order('kd_prog, no_bukti, tgl_bukti, uraian, nilai, kd_pembayaran, nm_penerima, alamat, npwp')
		->view_order('kd_unit, kd_sub, kd_prog, kd_keg, kd_rek_4, no_bukti, tgl_bukti, uraian, nilai, kd_pembayaran, nm_penerima, alamat, npwp')
		//->add_action('toolbar', 'bukti_pengeluaran_panjar', 'Panjar', 'btn-warning --modal', 'mdi mdi-radio-tower', array('no_bukti' => 'no_bukti'))
		->add_action('option', 'potongan', 'Potongan', 'btn-success ajax', 'mdi mdi-content-cut', array('kd_urusan' => service('request')->getGet('kd_urusan'), 'kd_bidang' => service('request')->getGet('kd_bidang'), 'kd_unit' => service('request')->getGet('kd_unit'), 'kd_sub' => service('request')->getGet('kd_sub'), 'kd_prog' => 'kd_prog', 'id_prog' => 'id_prog', 'kd_keg' => 'kd_keg', 'no_bukti' => 'no_bukti'))
		->set_alias
		(
			array
			(
				'kd_prog'							=> 'Program',
				'no_bukti'							=> 'Nomor Bukti',
				'tgl_bukti'							=> 'Tanggal Bukti',
				'kd_rek_4'							=> 'Rekening',
				'kd_pembayaran'						=> 'Cara Pembayaran',
				'nm_penerima'						=> 'Nama Penerima',
				'alamat'							=> 'Alamat Penerima',
				'bank_penerima'						=> 'Bank Penerima',
				'rek_penerima'						=> 'Rekening Penerima',
				'npwp'								=> 'Npwp',
				'kd_sumber'							=> 'Sumber Dana',
				'nm_sumber'							=> 'Sumber Dana'
			)
		)
		->field_position
		(
			array
			(
				'kd_pembayaran'						=> 2,
				'nm_penerima'						=> 2,
				'alamat'							=> 2,
				'bank_penerima'						=> 2,
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
			'kd_pembayaran',
			'radio',
			array
			(
				1									=> '<label class="badge badge-success">Tunai</label>',
				2									=> '<label class="badge badge-warning">Bank</label>'
			)
		)
		->set_validation
		(
			array
			(
				'no_bukti'							=> 'required',
				'tgl_bukti'							=> 'required',
				'uraian'							=> 'required',
				'kd_pembayaran'						=> 'required',
                'nilai'								=> 'callback_validasi_nilai',
				'kd_sumber'							=> 'required'
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
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'jn_spm'							=> '2',
				'cair'								=> '0',
				'tgl_buat'							=> date("Y-m-d h:i:sa")
			)
		)
        ->set_relation
        (
            'kd_sumber',
            'ref_sumber_dana.kd_sumber',
            '{ref_sumber_dana.kd_sumber}. {ref_sumber_dana.nm_sumber}',
            array
            (
                'ref_sumber_dana.kd_sumber'			=> 3
            )
        )
        /*
        ->set_relation
        (
            'nama_pptk',
            'ref_entry.nm_penandatangan',
            '{ref_entry.nm_penandatangan}',
            array
            (
                'ref_entry.tahun'					=> get_userdata('year'),
                'ref_entry.kd_penandatangan'		=> get_userdata('year')
            )
        )
        */
		->merge_content('{kd_unit}.{kd_sub} . {kd_prog}.{kd_keg}', 'Kegiatan')
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
        ->order_by('no_bukti')
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

	public function kode_rekening_kd_rek4($params = array())
	{
		$exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		$query										= $this->model->select
		('
			kd_rek_1,
			kd_rek_2,
			kd_rek_3,
			kd_rek_4,
			kd_rek_5,
			nm_rek_5
		')
			->get_where
			(
				'ref_rek_5',
				array
				(
					'ref_rek_5.kd_rek_1'				=> $params['kd_rek_1']['original'],
					'ref_rek_5.kd_rek_2'				=> $params['kd_rek_2']['original'],
					'ref_rek_5.kd_rek_3'				=> $params['kd_rek_3']['original'],
					'ref_rek_5.kd_rek_4'				=> $params['kd_rek_4']['original'],
					'ref_rek_5.kd_rek_5'				=> $params['kd_rek_5']['original']
				),
				NULL,
				NULL,
				50
			)
			->result();

		$rekening									= null;

		foreach($query as $key => $val)
		{
			$rekening								= $exists;
		}

		return $rekening;
	}

	public function kode_program($params = array())
	{
		ini_set('memory_limit', '-1');

		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0) . '.' . (isset($params['kd_keg']['original']) ? $params['kd_keg']['original'] : 0);

        $query									    = $this->model->query
        ('
                SELECT
                    ta_spd_rinc.kd_urusan,
                    ta_spd_rinc.kd_bidang,
                    ta_spd_rinc.kd_unit,
                    ta_spd_rinc.kd_sub,
                    ta_spd_rinc.kd_prog,
                    ta_spd_rinc.id_prog,
                    ta_spd_rinc.kd_keg,
                    ta_kegiatan.ket_kegiatan
                FROM
                    ta_spd_rinc
                INNER JOIN ta_spd ON ta_spd_rinc.no_spd = ta_spd.no_spd
                INNER JOIN ta_kegiatan ON ta_spd_rinc.kd_urusan = ta_kegiatan.kd_urusan
                       AND ta_spd_rinc.kd_bidang = ta_kegiatan.kd_bidang
                       AND ta_spd_rinc.kd_unit = ta_kegiatan.kd_unit
                       AND ta_spd_rinc.kd_sub = ta_kegiatan.kd_sub
                       AND ta_spd_rinc.kd_prog = ta_kegiatan.kd_prog
                       AND ta_spd_rinc.id_prog = ta_kegiatan.id_prog 
                       AND ta_spd_rinc.kd_keg = ta_kegiatan.kd_keg
                WHERE
                    ta_spd_rinc.kd_urusan = ' . service('request')->getGet('kd_urusan') . '
                    AND ta_spd_rinc.kd_bidang = ' . service('request')->getGet('kd_bidang') . '
                    AND ta_spd_rinc.kd_unit = ' . service('request')->getGet('kd_unit') . '
                    AND ta_spd_rinc.kd_sub = ' . service('request')->getGet('kd_sub') . '
                    AND ta_kegiatan.kd_keg != 0
                GROUP BY
                    ta_spd_rinc.kd_urusan,
                    ta_spd_rinc.kd_bidang,
                    ta_spd_rinc.kd_unit,
                    ta_spd_rinc.kd_sub,
                    ta_spd_rinc.kd_prog,
                    ta_spd_rinc.id_prog,
                    ta_spd_rinc.kd_keg,
                    ta_kegiatan.ket_kegiatan
                ORDER BY
                    ta_spd_rinc.kd_urusan,
                    ta_spd_rinc.kd_bidang,
                    ta_spd_rinc.kd_unit,
                    ta_spd_rinc.kd_sub,
                    ta_spd_rinc.kd_prog,
                    ta_spd_rinc.id_prog,
                    ta_spd_rinc.kd_keg,
                    ta_kegiatan.ket_kegiatan
            ')
            ->result();

		$options									= null;
		$output										= null;
		foreach($query as $key => $val)
		{
			$options								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->kd_keg . ' - ' . $val->ket_kegiatan . '</option>';
		}

		$output										.= '
			<div class="form-group">
				<select name="kd_prog" class="form-control form-control-sm report-dropdown" to-change=".rekening">
					<option value="">Silakan pilih Program</option>
					' . $options . '
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Rekening
				</label>
				<select name="kd_rekening" class="form-control form-control-sm rekening get-dropdown-content" disabled>
					<option value="">Silakan pilih Program terlebih dahulu</option>
				</select>
			</div>
		';

		return $output;
	}

	private function _dropdown()
	{
		$primary									= service('request')->getPost('primary');
		$list										= $primary != 'all' ? explode(".", $primary) : null;
		$element									= service('request')->getPost('element');
		$options									= null;

		if('.rekening' == $element)
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
				->join
				(
					'ref_rek_5',
					'ref_rek_5.kd_rek_1 = ta_spd_rinc.kd_rek_1 AND
				ref_rek_5.kd_rek_2 = ta_spd_rinc.kd_rek_2 AND
				ref_rek_5.kd_rek_3 = ta_spd_rinc.kd_rek_3 AND
				ref_rek_5.kd_rek_4 = ta_spd_rinc.kd_rek_4 AND
				ref_rek_5.kd_rek_5 = ta_spd_rinc.kd_rek_5'
				)
				->get_where
				(
					'ta_spd_rinc',
					array
					(
						'ta_spd_rinc.kd_urusan'		=> $list[0],
						'ta_spd_rinc.kd_bidang'		=> $list[1],
						'ta_spd_rinc.kd_unit'		=> $list[2],
						'ta_spd_rinc.kd_sub'		=> $list[3],
						'ta_spd_rinc.kd_prog'		=> $list[4],
						'ta_spd_rinc.id_prog'		=> $list[5]
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
					$options						.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '">' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . ' - ' . $val->nm_rek_5 . '</option>';
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
