<?php namespace Modules\Bendahara\Controllers\Bukti_pengeluaran;
/**
 * Bendahara > Bukti Pengeluaran Potongan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Potongan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spj_pot';

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
		if(service('request')->getPost('_token'))
		{
			list($r1, $r2, $r3, $r4)			    = array_pad(explode('.', service('request')->getPost('rekening')), 5, 0);

            $kode_pot_rek							= $this->model->query
            ('
                SELECT
                    ta_spj_pot.kd_pot_rek
                FROM
                    ta_spj_pot
                WHERE
                    ta_spj_pot.tahun = ' . get_userdata('year') . '
                    AND ta_spj_pot.kd_pot_rek = ' . $r4 . '
            ')
                ->row('kd_pot_rek');

            if(in_array($this->_method, array('create')))
            {
                if(empty(service('request')->getPost('rekening')))
                {
                    return throw_exception(403, 'Bidang Rekening Potongan Bukti Pengeluaran dibutuhkan ...');
                }

                if($r4 == $kode_pot_rek)
                {
                    return throw_exception(403, 'Rekening Potongan Bukti Pengeluaran sudah ada ...');
                }
            }

			$this->set_default
			(
				array
				(
					'kd_pot_rek'					=> $r4
				)
			);
		}

		if(in_array($this->_method, array('create', 'update')))
		{
			if(in_array($this->_method, array('create', 'update')))
			{
				$query_spj							= $this->model->select
				('
					no_bukti
				')
					->get_where
					(
						'ta_spj_rinc',
						array
						(
							'tahun'					=> get_userdata('year'),
							'no_bukti'				=> service('request')->getGet('no_bukti')
						)
					)
					->row('no_bukti');

				if($query_spj == service('request')->getGet('no_bukti'))
				{
					return throw_exception(301, 'Nomor Bukti ' . $query_spj . ' Sudah di-SPJ-kan');
				}
			}

			$this->set_field('kd_pot_rek', 'custom_format', 'callback_kode_rekening_kd_rek1');
		}
		else
		{
			$this->set_field('kd_pot_rek', 'custom_format', 'callback_kode_rekening_kd_rek1_uraian');
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
						' . $header['query']->kd_urusan . '.' . $header['query']->kd_bidang . '.' . $header['query']->kd_unit . '.' . $header['query']->kd_sub . '
					</label>
					<label class="col-2 col-sm-5 text-uppercase mb-0">
						' . $header['query']->nm_sub_unit . '
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						no bukti
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . $header['query']->no_bukti . '
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						tanggal bukti
					</label>
					<label class="col-2 col-sm-6 text-uppercase mb-0">
						' . date("d F Y", strtotime($header['query']->tgl_bukti)) . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah bukti potongan
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
                            Rp. ' . number_format(($header['query_total']->nilai), 2) . '
                        </b>
					</label>
				</div>
			');
		}

		$this->set_breadcrumb
		(
			array
			(
				'bendahara/bukti_pengeluaran'		=> 'Bendahara Pengeluaran UP/GU',
				'../bukti_pengeluaran'				=> 'Bukti Pengeluaran'
			)
		);
		$this->set_title('Potongan Bukti Pengeluaran')
		->set_icon('mdi mdi-rhombus-split')
		->set_primary('tahun, no_bukti')
		->unset_action('export, print, pdf')
		->unset_column('tahun, no_bukti, kd_billing, ntpn, tgltrx_ntpn, tglbuku_ntpn')
		->unset_field('tahun, no_bukti, ntpn, tgltrx_ntpn, tglbuku_ntpn')
		->unset_view('tahun, ntpn, tgltrx_ntpn, tglbuku_ntpn')
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
				'nilai'								=> 'price_format'
			)
		)
		->set_alias
		(
			array
			(
				'kd_pot_rek'						=> 'Rekening Potongan',
				'nilai'						        => 'Nilai Potongan',
				'kd_billing'						=> 'Kode Billing'
			)
		)
		->set_validation
		(
			array
			(
				'kd_billing'						=> 'callback_validasi_kd_billing',
				'nilai'								=> 'callback_validasi_nilai'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_bukti'							=> service('request')->getGet('no_bukti')
			)
		)
		->where
		(
			array
			(
				'tahun'								=> get_userdata('year'),
				'no_bukti'							=> service('request')->getGet('no_bukti')
			)
		)
        ->order_by
        (
            array
            (
                'kd_pot_rek'						=> 'ASC'
            )
        )
		->render($this->_table);
	}

    public function validasi_kd_billing($value = 0)
    {
        if(!$value)
        {
            return true;
        }

        if(strlen($value) < 15)
        {
            return 'Kode Billing harus 15 digit !';
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

	public function kode_rekening_kd_rek1($params = array())
	{
		$exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 7) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 1) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 1) . '.' . (isset($params['kd_pot_rek']['original']) ? $params['kd_pot_rek']['original'] : 0);
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
					'ref_rek_5.kd_rek_1'			=> 7,
					'ref_rek_5.kd_rek_2'			=> 1,
					'ref_rek_5.kd_rek_3'			=> 1
				),
				NULL,
				NULL,
				50
			)
			->result();

		$option										= '<option value="">Silahkan Pilih Rekening</option>';
		foreach($query as $key => $val)
		{
			$option									.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '"' . ($exists == $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 ? ' selected' : null) . '>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . '  ' . $val->nm_rek_5 . '</option>';
		}

		return '<select name="rekening" class="form-control">' . $option . '</select>';
	}

	public function kode_rekening_kd_rek1_uraian($params = array())
	{
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
					'ref_rek_5.kd_rek_1'				=> 7,
					'ref_rek_5.kd_rek_2'				=> 1,
					'ref_rek_5.kd_rek_3'				=> 1,
					'ref_rek_5.kd_rek_4'				=> $params['kd_pot_rek']['original']
				),
				NULL,
				NULL,
				50
			)
			->row();

		$rekening									= null;
		if(isset($query))
		{
			$rekening								.= '' . $query->kd_rek_1 . '.' . $query->kd_rek_2 . '.' . $query->kd_rek_3 . '.' . sprintf('%02d', $query->kd_rek_4) . '.' . sprintf('%02d', $query->kd_rek_5) . '  ' . $query->nm_rek_5 . '';
		}

		return $rekening;
	}

	private function _header()
	{
		$query										= $this->model->select
		('
			ta_spj_bukti.no_bukti,
			ta_spj_bukti.tgl_bukti,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
			->join
			(
				'ref_sub_unit',
				'ref_sub_unit.kd_urusan = ta_spj_bukti.kd_urusan and
				ref_sub_unit.kd_bidang = ta_spj_bukti.kd_bidang and
				ref_sub_unit.kd_unit = ta_spj_bukti.kd_unit and
				ref_sub_unit.kd_sub = ta_spj_bukti.kd_sub'
			)
			->get_where
			(
				'ta_spj_bukti',
				array
				(
					'ta_spj_bukti.tahun'			=> get_userdata('year'),
					'ta_spj_bukti.kd_urusan'		=> service('request')->getGet('kd_urusan'),
					'ta_spj_bukti.kd_bidang'		=> service('request')->getGet('kd_bidang'),
					'ta_spj_bukti.kd_unit'			=> service('request')->getGet('kd_unit'),
					'ta_spj_bukti.kd_sub'			=> service('request')->getGet('kd_sub'),
					'ta_spj_bukti.no_bukti'			=> service('request')->getGet('no_bukti')
				)
			)
			->row();

		$query_total								= $this->model->select
		('
			SUM(nilai) AS nilai
		')
			->get_where
			(
				'ta_spj_pot',
				array
				(
					'ta_spj_pot.no_bukti'			=> service('request')->getGet('no_bukti')
				)
			)
			->row();

		$output										= array
		(
			'query'									=> $query,
			'query_total'							=> $query_total
		);

		return $output;
	}
}
