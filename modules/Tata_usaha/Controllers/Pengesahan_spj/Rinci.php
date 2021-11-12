<?php namespace Modules\Tata_usaha\Controllers\Pengesahan_spj;
/**
 * Tata Usaha > Pengesahan SPJ > Rinci
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rinci extends \Aksara\Laboratory\Core
{
    private $_table									= 'ta_pengesahan_spj_rinc';
	
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
		if(service('request')->getPost('token'))
		{
			if(service('request')->getPost('kegiatan') != 'all')
			{
				list($r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12)	= array_pad(explode('.', service('request')->getPost('kegiatan')), 5, 0);

				$this->set_default
				(
					array
					(
						'kd_urusan'					=> $r1,
						'kd_bidang'					=> $r2,
						'kd_unit'					=> $r3,
						'kd_sub'					=> $r4,
						'kd_prog'					=> $r5,
						'id_prog'					=> $r6,
						'kd_keg'					=> $r7,
						'kd_rek_1'					=> $r8,
						'kd_rek_2'					=> $r9,
						'kd_rek_3'					=> $r10,
						'kd_rek_4'					=> $r11,
						'kd_rek_5'					=> $r12,
					)
				);
			}
		}
		
		/*
		$header										= $this->_header();
		
		if(!$header)
		{
			$this->set_description
			('
				<div class="row text-sm border-bottom">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						sub unit
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header['query']->kd_urusan . '.' . $header['query']->kd_bidang . '.' . $header['query']->kd_unit . '.' . $header['query']->kd_sub . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header['query']->nm_sub_unit . '
					</label>
				</div>
				<div class="row text-sm border-bottom">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						no spp
					</label>
					<label class="col-2 col-sm-6 mb-0">
						' . $header['query']->no_spp . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah total usulan
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
                            Rp. ' . number_format(($header['query_total']->usulan), 2) . '
                        </b>
					</label>
				</div>
				<div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						tanggal spp
					</label>
					<label class="col-2 col-sm-6 mb-0">
						' . date("d F Y", strtotime($header['query']->tgl_spp)) . '
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						jumlah total disetujui
					</label>
					<label class="col-2 col-sm-2 text-uppercase mb-0">
						<b class="text-danger">
                            Rp. ' . number_format(($header['query_total']->nilai), 2) . '
                        </b>
					</label>
				</div>
			');
		}
		*/
		
		$this->set_breadcrumb
		(
			array
			(
				'tata_usaha/pengesahan_spj/sub_unit'	=> 'Tata Usaha',
				'..'						        								=> 'Spj',
				'../pengesahan_spj'					=> 'Pengesahan Spj'
			)
		);
		
		$this->set_title('Rinc Pengesahan SPJ')
		->set_icon('mdi mdi-snowflake')
		->set_primary('tahun, no_pengesahan, kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf, create')
		->unset_column('tahun, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, no_bukti, tgl_bukti, no_spj_panjar, no_spd, kd_rek_1, kd_rek_2, kd_rek_3')
		->unset_field('tahun, no_id, no_spd, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, no_bukti, tgl_bukti, no_spj_panjar, no_spd, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, no_id, no_spj_panjar, kd_urusan, kd_bidang, kd_unit, kd_sub, id_prog, kd_rek_1, kd_rek_2, kd_rek_3')
		//->field_order('no_id')
		
		->field_prepend
		(
			array
			(
				'nilai_usulan'						=> 'Rp',
				'nilai_setuju'						=> 'Rp'
			)
		)
		->set_alias
		(
			array
			(
				'kd_rek_1'							=> 'Rekening',
				'kd_rek_4'							=> 'Rekening',
				'kd_rek_5'							=> 'Uraian Rekening'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'no_pengesahan'						=> 'readonly',
				'nilai_usulan'						=> 'price_format',
				'nilai_setuju'						=> 'price_format',
				'tgl_bukti'							=> 'datepicker'
			)
		)
		
		->merge_content('{kd_prog}.{kd_keg}', 'Kegiatan')
		->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
		->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')
		
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year')
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
				'no_pengesahan'						=> service('request')->getGet('no_pengesahan')
			)
		)
		->render($this->_table);
    }
	
	public function kode_rekening_kd_rek4($params = array())
	{
		$exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

		return $exists;
	}
	
	public function kode_rekening_kd_rek5($params = array())
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
				'ref_rek_5.kd_rek_1'				=> $params['kd_rek_1']['original'],
				'ref_rek_5.kd_rek_2'				=> $params['kd_rek_2']['original'],
				'ref_rek_5.kd_rek_3'				=> $params['kd_rek_3']['original'],
				'ref_rek_5.kd_rek_4'				=> $params['kd_rek_4']['original'],
				'ref_rek_5.kd_rek_5'				=> $params['kd_rek_5']['original']
			)
		)
		->result();
		
		$rekening									= null;
		
		foreach($query as $key => $val)
		{
			$rekening								= $val->nm_rek_5;
		}
		
		return $rekening;
	}
	
	/*
	private function _header()
	{
		$query										= $this->model->select
		('
			ta_spp.no_spp,
			ta_spp.tgl_spp,
			ta_spd_rinc.no_spd,
			ta_spd_rinc.nilai,
			ref_sub_unit.kd_urusan,
			ref_sub_unit.kd_bidang,
			ref_sub_unit.kd_unit,
			ref_sub_unit.kd_sub,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ta_spd_rinc',
			'ta_spd_rinc.kd_urusan = ta_spp.kd_urusan AND ta_spd_rinc.kd_bidang = ta_spp.kd_bidang AND ta_spd_rinc.kd_unit = ta_spp.kd_unit AND ta_spd_rinc.kd_sub = ta_spp.kd_sub'
		)
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_spp.kd_urusan AND ref_sub_unit.kd_bidang = ta_spp.kd_bidang AND ref_sub_unit.kd_unit = ta_spp.kd_unit AND ref_sub_unit.kd_sub = ta_spp.kd_sub'
		)
		->get_where
		(
			'ta_spp',
			array
			(
				'ta_spp.tahun'						=> get_userdata('year'),
				'ta_spp.kd_urusan'					=> service('request')->getGet('kd_urusan'),
				'ta_spp.kd_bidang'					=> service('request')->getGet('kd_bidang'),
				'ta_spp.kd_unit'					=> service('request')->getGet('kd_unit'),
				'ta_spp.kd_sub'						=> service('request')->getGet('kd_sub'),
				'ta_spp.no_spp'						=> service('request')->getGet('no_spp')
			)
		)
		->row();

		$query_total								= $this->model->select
		('
			SUM(usulan) AS usulan,
			SUM(nilai) AS nilai
		')
		->get_where
		(
			'ta_spp_rinc',
			array
			(
				'ta_spp_rinc.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_spp_rinc.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_spp_rinc.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_spp_rinc.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_spp_rinc.no_spp'				=> service('request')->getGet('no_spp')
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
	*/
}
