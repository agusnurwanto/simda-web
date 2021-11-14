<?php namespace Modules\Anggaran\Controllers;
/**
 * Anggaran > Kegiatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Kegiatan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_kegiatan';

	public function __construct()
	{
		parent::__construct();

		if('dropdown' == service('request')->getPost('trigger'))
		{
			return $this->_dropdown();
		}

		if('true' == service('request')->getPost('get_total_barang'))
		{
			return $this->_keterangan_rekening(service('request')->getPost('id_barang'));
		}

		$this->set_theme('backend');
		$this->set_permission();

		// must be called after set_theme()
		$this->database_config('default');
	}

	public function index()
	{
		if(service('request')->getPost('token'))
		{
			list($r1, $r2, $r3, $r4, $r5, $r6, $r7)	= array_pad(explode('.', service('request')->getPost('program')), 5, 0);

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
					'kd_keg'						=> $r7, // last insert belum nemu
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
						Sub Unit
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
				'anggaran'							=> 'Anggaran',
				'sub_unit'							=> 'Sub Unit'
			)
		);
		$this->set_title('Kegiatan')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('ta_kegiatan.tahun, ta_kegiatan.kd_urusan, ta_kegiatan.kd_bidang, ta_kegiatan.kd_unit, ta_kegiatan.kd_sub')
		->unset_action('export, print, pdf')
		->unset_column('tahun,  kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, lokasi, kelompok_sasaran, status_kegiatan, waktu_pelaksanaan, kd_sumber')
		->unset_field('tahun, kd_bidang, kd_unit, kd_sub, kd_urusan, id_prog, kd_prog, ket_kegiatan')
		->unset_view('tahun, kd_urusan, kd_unit, kd_sub, kd_prog, id_prog, kd_prog, kd_keg')
		->unset_truncate('ket_kegiatan')
		->field_order('kd_keg, ket_kegiatan, waktu_pelaksanaan, status_kegiatan, kd_sumber')
		->column_order('kd_program90, ket_kegiatan, pagu_anggaran')
		->add_action('option', 'berkas', 'Berkas', 'btn-success  --modal', 'mdi mdi-file-cabinet', array('tahun' => get_userdata('year'), 'urusan' => 'kd_urusan', 'bidang' => 'kd_bidang', 'unit' => 'kd_unit', 'sub_unit' => 'kd_sub', 'program' => 'kd_prog', 'id_prog' => 'id_prog', 'kegiatan' => 'kd_keg'))
		/*
		->add_action('toolbar', '../../anggaran/pendapatan/rekening', 'Pendapatan', 'btn-info --xhr', 'mdi mdi-printer', array('kd_urusan' => service('request')->getGet('kd_urusan'), 'kd_bidang' => service('request')->getGet('kd_bidang'), 'kd_unit' => service('request')->getGet('kd_unit'), 'kd_sub' => service('request')->getGet('kd_sub')))
		->add_action('toolbar', '../../anggaran/btl/rekening', 'BTL', 'btn-danger --xhr', 'mdi mdi-printer', array('kd_urusan' => service('request')->getGet('kd_urusan'), 'kd_bidang' => service('request')->getGet('kd_bidang'), 'kd_unit' => service('request')->getGet('kd_unit'), 'kd_sub' => service('request')->getGet('kd_sub')))
		->add_action('toolbar', '../../anggaran/pembiayaan/rekening', 'Pembiayaan', 'btn-success --xhr', 'mdi mdi-printer', array('kd_urusan' => service('request')->getGet('kd_urusan'), 'kd_bidang' => service('request')->getGet('kd_bidang'), 'kd_unit' => service('request')->getGet('kd_unit'), 'kd_sub' => service('request')->getGet('kd_sub')))
		*/
        ->merge_content('{kd_program90}.{kd_kegiatan90}.{kd_sub_kegiatan}', 'Kode')
		->field_prepend
		(
			array
			(
				'pagu_anggaran'						=> 'Rp'
			)
		)
		->set_field
		(
			'ket_kegiatan',
			'hyperlink',
			'anggaran/rekening',
			array
			(
				'kd_urusan'							=> 'kd_urusan',
				'kd_bidang'							=> 'kd_bidang',
				'kd_unit'							=> 'kd_unit',
				'kd_sub'							=> 'kd_sub',
				'kd_prog'							=> 'kd_prog',
				'id_prog'							=> 'id_prog',
				'kd_keg'							=> 'kd_keg'
			)
		)
		->set_alias
		(
			array
			(
				'ket_kegiatan'						=> 'Uraian',
				'kd_keg'							=> 'Kegiatan',
				'pagu_anggaran'						=> 'Pagu Anggaran',
				'kd_sumber'							=> 'Sumber Dana',
				//'lokasi'							=> 'Lokasi Kegiatan',
			)
		)
		->set_field
		(
			array
			(
				'kd_keg'							=> 'last_insert',
				'lokasi'							=> 'textarea',
				'kelompok_sasaran'					=> 'textarea',
				'pagu_anggaran'						=> 'price_format'
			)
		)
		->set_field
		(
			'status_kegiatan',
			'radio',
			array
			(
				1									=> 'Baru',
				2									=> 'Lanjutan'
			)
		)
		->field_position
		(
			array
			(
				'kd_sumber'							=> 2,
				'status_kegiatan'					=> 2,
				'lokasi'							=> 2,
				'pagu_anggaran'						=> 2
			)
		)
		->set_validation
		(
			array
			(
				'kd_prog'							=> 'required||callback_validasi_program',
				'ket_kegiatan'						=> 'required|',
				'status_kegiatan'					=> 'required|',
				'pagu_anggaran'						=> 'required|numeric|'
			)
		)
		->set_default
		(
			array
			(
				'tahun'								=> get_userdata('year')
			)
		)
		->set_field('kd_keg', 'custom_format', 'callback_kode_kegiatan')
		->where
		(
			array
			(
				'ta_kegiatan.tahun'								=> get_userdata('year'),
				'ta_kegiatan.kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'ta_kegiatan.kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'ta_kegiatan.kd_unit'							=> service('request')->getGet('kd_unit'),
				'ta_kegiatan.kd_sub'							=> service('request')->getGet('kd_sub'),
				'ta_kegiatan.kd_prog > '						=> 0
			)
		)
		->select('ref_kegiatan_mapping.kd_program90, ref_kegiatan_mapping.kd_kegiatan90, ref_kegiatan_mapping.kd_sub_kegiatan')
		->join('ref_kegiatan_mapping', 'ref_kegiatan_mapping.kd_urusan = ta_kegiatan.kd_urusan AND ref_kegiatan_mapping.kd_bidang = ta_kegiatan.kd_bidang AND ref_kegiatan_mapping.kd_prog = ta_kegiatan.kd_prog AND ref_kegiatan_mapping.kd_keg = ta_kegiatan.kd_keg')
        // ->order_by
        // (
        //     array
        //     (
        //         'kd_program90'						=> 'ASC',
        //         'kd_kegiatan90'						=> 'ASC',
        //         'kd_sub_kegiatan'					=> 'ASC'
        //     )
        // )
		->render($this->_table);
	}

	public function validasi_program($value = 0)
	{
		list($r1, $r2, $r3, $r4, $r5, $r6)			= array_pad(explode('.', $value), 5, 0);

		$query										= $this->model->get_where
		(
			'ta_program',
			array
			(
				'ta_program.tahun'					=> get_userdata('year'),
				'ta_program.kd_urusan'				=> $r1,
				'ta_program.kd_bidang'				=> $r2,
				'ta_program.kd_unit'				=> $r3,
				'ta_program.kd_sub'					=> $r4,
				'ta_program.kd_prog'				=> $r5,
				'ta_program.id_prog'				=> $r6
			),
			1
		)
		->row();

		if(!$query)
		{
			return 'Program tidak tersedia'. $value;
		}

		return true;
	}

	public function kode_kegiatan($params = array())
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
			ta_kegiatan.ket_kegiatan
		')
		->join
		(
			'ta_kegiatan',
			'ta_kegiatan.kd_urusan = ta_program.kd_urusan AND
			ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
			ta_kegiatan.kd_unit = ta_program.kd_unit AND
			ta_kegiatan.kd_sub = ta_program.kd_sub AND
			ta_kegiatan.kd_prog = ta_program.kd_prog AND
			ta_kegiatan.id_prog = ta_program.id_prog'
		)
		->get_where
		(
			'ta_program',
			array
			(
				'ta_program.tahun'					=> get_userdata('year'),
				'ta_program.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_program.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_program.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_program.kd_sub'					=> service('request')->getGet('kd_sub'),
				'ta_program.kd_prog >'				=> 0
			),
			NULL,
			NULL,
			50
		)
		->result();

		$options									= null;
		$output										= null;
		foreach($query as $key => $val)
		{
			$options								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '.' . $val->kd_keg . ' - ' . $val->ket_kegiatan . '</option>';
		}

		$output										.= '
			<div class="form-group">
				<select name="kegiatan" class="form-control form-control-sm report-dropdown" to-change=".belanja">
					<option value="all">Silakan pilih Kegiatan</option>
					' . $options . '
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Rekening
				</label>
				<select name="belanja" class="form-control form-control-sm belanja get-dropdown-content" disabled>
					<option value="all">Silakan pilih Program terlebih dahulu</option>
				</select>
			</div>
		';

		return $output;
	}

	private function _dropdown()
	{
		// get db simda
		$this->database_config('default');

		$primary									= service('request')->getPost('primary');
		$list										= $primary != 'all' ? explode(".", $primary) : null;
		$element									= service('request')->getPost('element');
		$options									= null;

		if('.belanja' == $element)
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
					'ref_rek_5.kd_rek_1 = ta_belanja_rinc.kd_rek_1 AND 
					ref_rek_5.kd_rek_2 = ta_belanja_rinc.kd_rek_2 AND
				 	ref_rek_5.kd_rek_3 = ta_belanja_rinc.kd_rek_3 AND 
				 	ref_rek_5.kd_rek_4 = ta_belanja_rinc.kd_rek_4 AND 
				 	ref_rek_5.kd_rek_5 = ta_belanja_rinc.kd_rek_5'
				)
				->order_by
				('
				kd_urusan,
				kd_bidang,
				kd_unit,
				kd_sub,
				kd_prog,
				id_prog,
				kd_keg
			')
				->get_where
				(
					'ta_belanja_rinc',
					array
					(
						'kd_urusan'						=> $list[0],
						'kd_bidang'						=> $list[1],
						'kd_unit'						=> $list[2],
						'kd_sub'						=> $list[3],
						'kd_prog'						=> $list[4],
						'id_prog'						=> $list[5],
						'kd_keg'						=> $list[6]
					),
					NULL,
					NULL,
					50,
				)
				->result();

			if($query)
			{
				//$options							= ('unit' == service('request')->getPost('referer') ? '<option value="all">Semua Sub Unit</option>' : '<option value="">Silakan pilih Kode Rekening</option>');
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

	private function _keterangan_rekening($id = 0)
	{
		// get db simda
		$this->database_config('default');

		if($id)
		{
			list($r1, $r2, $r3, $r4, $r5)			= array_pad(explode('.', $id), 5, 0);
			$urusan									= $this->model->query
			('
				SELECT
					ref_rek_5.kd_rek_1,
					ref_rek_5.kd_rek_2,
					ref_rek_5.kd_rek_3,
					ref_rek_5.kd_rek_4,
					ref_rek_5.kd_rek_5,
					ref_rek_1.nm_rek_1,
					ref_rek_2.nm_rek_2,
					ref_rek_3.nm_rek_3,
					ref_rek_4.nm_rek_4,
					ref_rek_5.nm_rek_5
				FROM
					ref_rek_5
				INNER JOIN ref_rek_4 ON ref_rek_4.kd_rek_1 = ref_rek_5.kd_rek_1 and ref_rek_4.kd_rek_2 = ref_rek_5.kd_rek_2 and ref_rek_4.kd_rek_3 = ref_rek_5.kd_rek_3 and ref_rek_4.kd_rek_4 = ref_rek_5.kd_rek_4
				INNER JOIN ref_rek_3 ON ref_rek_3.kd_rek_1 = ref_rek_4.kd_rek_1 and ref_rek_3.kd_rek_2 = ref_rek_4.kd_rek_2 and ref_rek_3.kd_rek_3 = ref_rek_4.kd_rek_3
				INNER JOIN ref_rek_2 ON ref_rek_2.kd_rek_1 = ref_rek_3.kd_rek_1 and ref_rek_2.kd_rek_2 = ref_rek_3.kd_rek_2
				INNER JOIN ref_rek_1 ON ref_rek_1.kd_rek_1 = ref_rek_2.kd_rek_1
				WHERE
					ref_rek_5.kd_rek_1 = ' .$r1 . '
				AND	ref_rek_5.kd_rek_2 = ' .$r2 . '
				AND	ref_rek_5.kd_rek_3 = ' .$r3 . '
				AND	ref_rek_5.kd_rek_4 = ' .$r4 . '
				AND	ref_rek_5.kd_rek_5 = ' .$r5 . '
			')
				->row();

			$detail_rekening						= '
				<table class="table table-bordered table-sm" style="margin-top:15px">
					<tbody>
						<tr>
							<td class="text-sm" width="20%">
								Akun
							</td>
							<td class="text-sm" width="15%">
								' . (isset($urusan->kd_rek_1) ? $urusan->kd_rek_1 : 0) . '
							</td>
							<td class="text-sm" width="65%">
								<!--<a href="' . base_url('laporan/anggaran/rka/rekening', array('rekening' => 926, 'method' => 'embed', 'tanggal_cetak' => date('Y-m-d'))) . '" class="btn btn-info btn-sm float-right" target="_blank">
									<i class="mdi mdi-printer"></i>
								</a>-->
								' . (isset($urusan->nm_rek_1) ? $urusan->nm_rek_1 : NULL) . '
							</td>
						</tr>
						<tr>
							<td class="text-sm">
								Kelompok
							</td>
							<td class="text-sm">
								' . (isset($urusan->kd_rek_2) ? $urusan->kd_rek_1 . '.' . $urusan->kd_rek_2 : 0) . '
							</td>
							<td class="text-sm">
								' . (isset($urusan->nm_rek_2) ? $urusan->nm_rek_2 : NULL) . '
							</td>
						</tr>
						<tr>
							<td class="text-sm">
								Jenis
							</td>
							<td class="text-sm">
								' . (isset($urusan->kd_rek_3) ? $urusan->kd_rek_1 . '.' . $urusan->kd_rek_3 . '.' . $urusan->kd_rek_3 : 0) . '
							</td>
							<td class="text-sm">
								' . (isset($urusan->nm_rek_3) ? $urusan->nm_rek_3 : NULL) . '
							</td>
						</tr>
						<tr>
							<td class="text-sm">
								Objek
							</td>
							<td class="text-sm">
								' . (isset($urusan->kd_rek_4) ? $urusan->kd_rek_1 . '.' . $urusan->kd_rek_2 . '.' . $urusan->kd_rek_3 . '.' . $urusan->kd_rek_4 : 0) . '
							</td>
							<td class="text-sm">
								' . (isset($urusan->nm_rek_4) ? $urusan->nm_rek_4 : NULL) . '
							</td>
						</tr>
						<tr>
							<td class="text-sm">
								Rincian Objek
							</td>
							<td class="text-sm">
								' . (isset($urusan->kd_rek_5) ? $urusan->kd_rek_1 . '.' . $urusan->kd_rek_2 . '.' . $urusan->kd_rek_3 . '.' . $urusan->kd_rek_4 . '.' . $urusan->kd_rek_5 : 0) . '
							</td>
							<td class="text-sm">
								' . (isset($urusan->nm_rek_5) ? $urusan->nm_rek_5 : NULL) . '
							</td>
						</tr>
					</tbody>
				</table>
			';
		}
		else
		{
			$detail_rekening						= '';
		}

		$query										= $this->model->select('nm_rek_5')->get_where
		(
			'ref_rek_5',
			array
			(
				'kd_rek_1'							=> $r1,
				'kd_rek_2'							=> $r2,
				'kd_rek_3'							=> $r3,
				'kd_rek_4'							=> $r4,
				'kd_rek_5'							=> $r5
			)
		)
			->row('nm_rek_5');

		/*		return make_json
				(
					array
					(
						'html'								=> $detail_rekening .'<div class="alert alert-info checkbox-wrapper" style="margin-top:15px">' . ($query ? $query : 'Belum ada keterangan untuk rekening yang dipilih') . '</div>'
					)
				);*/

		return make_json
		(
			array
			(
				'detail_program'					=> $detail_rekening,
				'html'								=> '<div class="alert alert-dark checkbox-wrapper" style="margin-top:15px">' . ($query ? $query : 'Belum ada keterangan untuk rekening yang dipilih') . '</div>'
			)
		);
	}

	private function _filter()
	{
		$output										= null;

		$query										= $this->model->get_where
		(
			'ta_program',
			array
			(
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub'),
				'id_prog > '						=> '0',
				'tahun'								=> get_userdata('year')
		  )
		)
		->result();

		if($query)
		{
			foreach($query as $key => $val)
			{
				$output								.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . '"' . ($val->kd_urusan == service('request')->getGet('kd_urusan') && $val->kd_bidang == service('request')->getGet('kd_bidang') && $val->kd_unit == service('request')->getGet('kd_unit') && $val->kd_sub == service('request')->getGet('kd_sub') && $val->kd_prog == service('request')->getGet('kd_prog') && $val->id_prog == service('request')->getGet('id_prog') ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '.' . $val->kd_prog . '.' . $val->id_prog . ' - ' . $val->ket_program . '</option>';
			}
		}

		$output										  = '
			<select name="program" class="form-control input-sm bordered" placeholder="Filter berdasar Program">
				<option value="all">Semua Program</option>
				' . $output . '
			</select>
		';

		return $output;
	}

	private function _header()
	{
		$query										= $this->model->get_where
		(
			'ref_sub_unit',
			array
			(
				'kd_urusan'							=> service('request')->getGet('kd_urusan'),
				'kd_bidang'							=> service('request')->getGet('kd_bidang'),
				'kd_unit'							=> service('request')->getGet('kd_unit'),
				'kd_sub'							=> service('request')->getGet('kd_sub')
			),
			1
		)
		->row();

		return $query;
	}
}
