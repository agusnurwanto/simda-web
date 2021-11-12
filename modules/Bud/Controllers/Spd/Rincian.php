<?php namespace Modules\Bud\Controllers\Spd;
/**
 * BUD > SPD > Rincian
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rincian extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_spd_rinc';
	
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
		if(service('request')->getPost('token'))
		{
			list($r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12)	= array_pad(explode('.', service('request')->getPost('program')), 5, 0);
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
					'kd_rek_5'						=> $r12
				)
			);
		}
		
		$header										= $this->_header();
		
		if($header)
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
				
				<div class="row text-sm">
					<div class="col-4 col-sm-2 text-muted text-sm">
						NO. SPD
					</div>
					<div class="col-4 col-sm-6 font-weight text-sm">
						' . $header['query']->no_spd . '
					</div>
					<div class="col-4 col-sm-2 font-weight text-sm">
						JUMLAH SPD
					</div>
					<div class="col-4 col-sm-2 font-weight-bold text-sm">
						<b class="text-danger">
							Rp. ' . number_format(($header['query_total']->nilai), 2) . '
						</b>
					</div>
				</div>
			');
		}
		
		$this->set_breadcrumb
		(
			array
			(
				'../bud/spd/sub_unit'				=> 'Sub Unit',
				'..'								=> 'Spd'
			)
		);
		
		$this->set_title('Spd Rincian')
		->set_icon('mdi mdi-paw')
		->set_primary('tahun, no_spd, no_id, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_action('export, print, pdf')
		->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, no_spd, no_id, id_prog, kd_rek_1, kd_rek_2, kd_rek_3')
		->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_edit, kd_keg, id_prog, kd_prog, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_edit, kd_keg, id_prog, kd_prog, kd_rek_1, kd_rek_2, kd_rek_3')
		->field_order('no_id')

		->field_prepend
		(
			array
			(
				'nilai'    							=> 'Rp'
			)
		)
		->set_field
		(
			array
			(
				'no_id'								=> 'last_insert, readonly',
				'nilai'						        => 'price_format'
			)
		)
		->set_alias
		(
			array
			(
				'no_id'							    => 'Nomor Urut',
				'no_spd'							=> 'Nomor SPD',
				'kd_rek_1'							=> 'Rekening',
				'kd_rek_4'							=> 'Rekening',
				'kd_rek_5'							=> 'Uraian'
			)
		)
		->set_validation
		(
			array
			(
				'no_spd'							=> 'required||callback_validasi_spd',
				'nilai'					    	    => 'required|',
				'kd_rek_1'					    	=> 'required|'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		->merge_content('0{kd_prog} . 0{kd_keg}', 'Kegiatan')
		->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1')
		->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
		->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')
		
		->set_relation
		(
			'no_spd',
			'ta_spd.no_spd',
			'{ta_spd.no_spd}',
				array
				(
					'tahun'							=> get_userdata('year'),
					'kd_urusan'						=> service('request')->getGet('kd_urusan'),
					'kd_bidang'						=> service('request')->getGet('kd_bidang'),
					'kd_unit'						=> service('request')->getGet('kd_unit'),
					'kd_sub'						=> service('request')->getGet('kd_sub'),
					'no_spd'						=> service('request')->getGet('no_spd')
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
				'no_spd'							=> service('request')->getGet('no_spd')
			)
		)
		->render($this->_table);
	}
	
	public function kode_rekening_kd_rek1($params = array())
	{
		ini_set('memory_limit', '-1');
		
		$exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0) . '.' . (isset($params['kd_prog']['original']) ? $params['kd_prog']['original'] : 0) . '.' . (isset($params['id_prog']['original']) ? $params['id_prog']['original'] : 0);
		
		$query										= $this->model->select
		('
			ta_program.kd_urusan,
			ta_program.kd_bidang,
			ta_program.kd_unit,
			ta_program.kd_sub,
			ta_program.kd_prog,
			ta_program.id_prog,
			ta_kegiatan.kd_keg,
			ta_kegiatan.ket_kegiatan,
			ref_rek_5.kd_rek_1,
			ref_rek_5.kd_rek_2,
			ref_rek_5.kd_rek_3,
			ref_rek_5.kd_rek_4,
			ref_rek_5.kd_rek_5,
			ref_rek_5.nm_rek_5
		')
		->join
		(
			'ta_program',
			'ta_program.kd_urusan = ta_belanja.kd_urusan and 
				ta_program.kd_bidang = ta_belanja.kd_bidang and 
				ta_program.kd_unit = ta_belanja.kd_unit and 
				ta_program.kd_sub = ta_belanja.kd_sub and
				ta_program.kd_prog = ta_belanja.kd_prog and
				ta_program.id_prog = ta_belanja.id_prog'
		)
		->join
		(
			'ta_kegiatan',
			'ta_kegiatan.kd_urusan = ta_belanja.kd_urusan and 
				ta_kegiatan.kd_bidang = ta_belanja.kd_bidang and 
				ta_kegiatan.kd_unit = ta_belanja.kd_unit and 
				ta_kegiatan.kd_sub = ta_belanja.kd_sub and
				ta_kegiatan.kd_prog = ta_belanja.kd_prog and
				ta_kegiatan.id_prog = ta_belanja.id_prog'
		)
		->join
		(
			'ref_rek_5',
			'ref_rek_5.kd_rek_5 = ta_belanja.kd_rek_5 and 
				ref_rek_5.kd_rek_4 = ta_belanja.kd_rek_4 and 
				ref_rek_5.kd_rek_3 = ta_belanja.kd_rek_3 and 
				ref_rek_5.kd_rek_2 = ta_belanja.kd_rek_2 and
				ref_rek_5.kd_rek_1 = ta_belanja.kd_rek_1'
		)
		->get_where
		(
			'ta_belanja',
			array
			(
				'ta_program.tahun'					=> get_userdata('year'),
				'ta_program.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_program.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_program.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_program.kd_sub'					=> service('request')->getGet('kd_sub'),
				'ta_program.kd_prog >'				=> 0
			)
		)
		->result();
		
		$return										= null;
		$option										= '<option value="all">Silahkan Pilih</option>';
		
		foreach($query as $key => $val)
		{
			$option									.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . '.' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . ' - ' . $val->ket_kegiatan . ' (' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . ' - ' . $val->nm_rek_5 . ')</option>';
		}
		
		return '<select name="program" class="form-control">' . $option . '</select>';
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
			)
		)
		->result();
		
		$rekening									= null;
		
		foreach($query as $key => $val)
		{
			$rekening								= $exists;
		}
		
		return $rekening;
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
	
	public function validasi_spd($value = 0)
	{
		$query										= $this->model->get_where
		(
			'ta_spd',
			array
			(
				'tahun'								=> get_userdata('year'),
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub')
			)
		)
		->row();
		
		if(!$query)
		{
			return 'Nomor SPD dibutuhkan yang dipilih tidak tersedia';
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
			ref_sub_unit.nm_sub_unit,
			ta_spd.no_spd
		')
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan and ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang and ref_sub_unit.kd_unit = ta_kegiatan.kd_unit and ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
		)
		->join
		(
			'ta_spd',
			'ta_spd.kd_urusan = ref_sub_unit.kd_urusan and ta_spd.kd_bidang = ref_sub_unit.kd_bidang and ta_spd.kd_unit = ref_sub_unit.kd_unit and ta_spd.kd_sub = ref_sub_unit.kd_sub'
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
				'ta_kegiatan.kd_keg'				=> 0,
				'ta_spd.no_spd'				        => service('request')->getGet('no_spd')
			)
		)
		->row();

		$query_total								= $this->model->select
		('
			SUM(nilai) AS nilai
		')
		->get_where
		(
			'ta_spd_rinc',
			array
			(
				'ta_spd_rinc.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_spd_rinc.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_spd_rinc.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_spd_rinc.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_spd_rinc.no_spd'				=> service('request')->getGet('no_spd')
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
