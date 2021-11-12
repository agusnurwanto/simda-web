<?php namespace Modules\Anggaran\Controllers\Pendapatan;
/**
 * Anggaran > Pendapatan > Rekening
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rekening extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_pendapatan';

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
        if('true' == service('request')->getPost('get_total_barang'))
        {
            return $this->_keterangan_rekening(service('request')->getPost('id_barang'));
        }

        if('rekening' == service('request')->getPost('method'))
        {
            return $this->_rekening();
        }

        if(service('request')->getPost('_token'))
        {
            list($r1, $r2, $r3, $r4, $r5)			= array_pad(explode('.', service('request')->getPost('rekening')), 5, 0);

            $this->set_default
            (
                array
                (
                    'kd_rek_1'						=> $r1,
                    'kd_rek_2'						=> $r2,
                    'kd_rek_3'						=> $r3,
                    'kd_rek_4'						=> $r4,
                    'kd_rek_5'						=> $r5,
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

		$this->set_breadcrumb
		(
			array
			(
				'anggaran/pendapatan/sub_unit'		=> 'Anggaran Pendapatan'
			)
		);

		$this->set_title('Rekening')
		->set_icon('mdi mdi-check-box-outline')
		->set_primary('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
		->unset_action('export, print, pdf')
        ->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_pendapatan, kd_rek_1, kd_rek_2, kd_rek_3, kd_sumber')
        ->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_pendapatan, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_sumber')
        ->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_prog, id_prog, kd_keg, kd_pendapatan, kd_rek_1, kd_rek_2, kd_rek_3, kd_sumber')
        ->set_alias
        (
            array
            (
                'kd_rek_1'							=> 'Rekening',
                'kd_rek_4'							=> 'Kode Rekening',
                'kd_rek_5'							=> 'Uraian'
            )
        )
        ->add_class
        (
            array
            (
                'kd_rek_5'							=> 'rekening'
            )
        )
        ->set_relation
        (
            'kd_rek_5',
            'ref_rek_5.kd_rek_5',
            '{ref_rek_5.kd_rek_1}.{ref_rek_5.kd_rek_2}.{ref_rek_5.kd_rek_3}.{ref_rek_5.kd_rek_4}.{ref_rek_5.kd_rek_5}. {ref_rek_5.nm_rek_5}',
            array
            (
                'ref_rek_5.kd_rek_1'				=> 4
            ),
            null,
            array
            (
                'ref_rek_5.kd_rek_1'			    => 'ASC',
                'ref_rek_5.kd_rek_2'			    => 'ASC',
                'ref_rek_5.kd_rek_3'		        => 'ASC',
                'ref_rek_5.kd_rek_4'		        => 'ASC',
                'ref_rek_5.kd_rek_5'		        => 'ASC'
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
                'kd_prog'							=> '0',
                'id_prog'							=> '0',
                'kd_keg'							=> '0',
                'kd_pendapatan'						=> '1'
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
                'kd_prog'							=> '0',
                'id_prog'							=> '0',
                'kd_keg'							=> '0',
                'kd_rek_1'							=> '4'
            )
        )
        //->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1')
        //->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
        //->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')
		->render($this->_table);
	}

    public function kode_rekening_kd_rek1($params = array())
    {
        ini_set('memory_limit', '-1');

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
                    'ref_rek_5.kd_rek_1'				=> 4
                ),
                NULL,
                NULL,
                50
            )
            ->result();

        $option										= '<option value="all">Silahkan Pilih</option>';

        foreach($query as $key => $val)
        {
            $option									.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '"' . ($exists == $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . '  ' . $val->nm_rek_5 . '</option>';
        }

        return '<select name="rekening" class="form-control get-dropdown-content">' . $option . '</select>';
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
                ),
                NULL,
                NULL,
                50
            )
            ->result();

        $uri										= array
        (
            'kd_urusan'								=> service('request')->getGet('kd_urusan'),
            'kd_bidang'								=> service('request')->getGet('kd_bidang'),
            'kd_unit'								=> service('request')->getGet('kd_unit'),
            'kd_sub'								=> service('request')->getGet('kd_sub'),
            'kd_rek_1'								=> $params['kd_rek_1']['original'],
            'kd_rek_2'								=> $params['kd_rek_2']['original'],
            'kd_rek_3'								=> $params['kd_rek_3']['original'],
            'kd_rek_4'								=> $params['kd_rek_4']['original'],
            'kd_rek_5'								=> $params['kd_rek_5']['original']
        );

        $rekening									= null;

        foreach($query as $key => $val)
        {
            $rekening								= $val->nm_rek_5;
        }

        $content									= '
			<a href="' . base_url('anggaran/pendapatan/rincian/', $uri) . '" class="--xhr">
				<b data-toggle="tooltip" title="' . phrase('click_to_open') . '">
					' . $rekening . '
				</b>
			</a>
		';

        return $content;
    }

    private function _kegiatan()
    {
        var_dump('ada'); die;
        if(service('request')->getPost('id'))
        {
            $urusan									= $this->model->query
            ('
				SELECT
					ref__urusan.kd_urusan,
					ref__bidang.kd_bidang,
					ref__urusan.nm_urusan,
					ref__bidang.nm_bidang
				FROM
					ta__program
				INNER JOIN ref__program ON ta__program.id_prog = ref__program.id
				INNER JOIN ref__bidang ON ref__program.id_bidang = ref__bidang.id
				INNER JOIN ref__urusan ON ref__bidang.id_urusan = ref__urusan.id
				WHERE
					ta__program.id = ' . service('request')->getPost('id') . '
				LIMIT 1
			')
                ->row();
            $detail_program							= '
				<table class="table table-bordered table-sm">
					<tbody>
						<tr>
							<td>
								Urusan
							</td>
							<td>
								' . (isset($urusan->kd_urusan) ? $urusan->kd_urusan : 0) . '
							</td>
							<td>
								' . (isset($urusan->nm_urusan) ? $urusan->nm_urusan : NULL) . '
							</td>
						</tr>
						<tr>
							<td>
								Bidang
							</td>
							<td>
								' . (isset($urusan->kd_urusan) ? $urusan->kd_urusan . '.' . $urusan->kd_bidang : 0) . '
							</td>
							<td>
								' . (isset($urusan->nm_bidang) ? $urusan->nm_bidang : NULL) . '
							</td>
						</tr>
					</tbody>
				</table>
			';
        }
        else
        {
            $detail_program							= '';
        }

        $capaian_program							= 0;
        if($this->_id)
        {
            $capaian_program						= $this->model->select('capaian_program')->get_where('ta__kegiatan', array('id' => $this->_id), 1)->row('capaian_program');
        }
        $query										= $this->model->get_where('ta__program_capaian', array('id_prog' => service('request')->getPost('id')))->result_array();
        $output										= null;
        if($query)
        {
            foreach($query as $key => $val)
            {
                $output								.= '
					<label class="control-label" style="display:block">
						<input type="radio" name="capaian_program" value="' . $val['id'] . '"' . ($capaian_program == $val['id'] ? ' checked' : null) . ' />
						' . $val['tolak_ukur'] . '
					</label>
				';
            }
            $output									= '
				<div class="alert alert-warning checkbox-wrapper" style="margin-top:12px">
					' . $output . '
					<label class="control-label" style="display:block">
						<input type="radio" name="capaian_program" value="0"' . (!$capaian_program ? ' checked' : null) . ' />
						Tidak satupun
					</label>
				</div>
			';
        }

        $kegiatan									= null;
        $selected_kegiatan							= $this->model->select('id_kegiatan')->get_where
        (
            $this->_table,
            array
            (
                'id'								=> $this->_id
            )
        )
            ->row('id_kegiatan');

        $id_program									= $this->model->select('id_prog')->get_where('ta__program', array('id' => service('request')->getPost('id')), 1)->row('id_prog');

        $query_kegiatan								= $this->model->select
        ('
			ref__kegiatan.id,
			ref__kegiatan.kd_kegiatan,
			ref__kegiatan.nm_kegiatan
		')
            ->get_where
            (
                'ref__kegiatan',
                array
                (
                    'tahun'								=> get_userdata('year'),
                    'id_program'						=> $id_program

                )

            )
            ->result();

        if($query_kegiatan)
        {
            foreach($query_kegiatan as $key => $val)
            {
                $kegiatan							.= '<option value="' . $val->id . '"' . ($selected_kegiatan == $val->id ? ' selected' : null) . '>' . $val->kd_kegiatan . '. ' . $val->nm_kegiatan . '</option>';
            }
        }

        $last_insert								= $this->model->select_max('kd_keg')->get_where('ta__kegiatan', array('id_prog' => service('request')->getPost('id')), 1)->row('kd_keg');

        make_json
        (
            array
            (
                'detail_program'					=> $detail_program,
                'html'								=> $output,
                'kegiatan'							=> $kegiatan,
                'last_insert'						=> ('create' == $this->_method ? ($last_insert > 0 ? $last_insert + 1 : 1) : 'ignore')
            )
        );
    }

	private function _rekening()
	{
		return make_json
		(
			array
			(
				'detail_rekening'					=> 'abc',
				'html'								=> 'def'
			)
		);
	}

    private function _keterangan_rekening($rekening = null)
    {
        if($rekening)
        {
            list($r1, $r2, $r3, $r4, $r5)			= array_pad(explode('.', $rekening), 5, 0);
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
				INNER JOIN ref_rek_4 ON ref_rek_4.kd_rek_1 = ref_rek_5.kd_rek_1 
                            AND ref_rek_4.kd_rek_2 = ref_rek_5.kd_rek_2 
                            AND ref_rek_4.kd_rek_3 = ref_rek_5.kd_rek_3 
                            AND ref_rek_4.kd_rek_4 = ref_rek_5.kd_rek_4
				INNER JOIN ref_rek_3 ON ref_rek_3.kd_rek_1 = ref_rek_4.kd_rek_1 
                            AND ref_rek_3.kd_rek_2 = ref_rek_4.kd_rek_2 
                            AND ref_rek_3.kd_rek_3 = ref_rek_4.kd_rek_3
				INNER JOIN ref_rek_2 ON ref_rek_2.kd_rek_1 = ref_rek_3.kd_rek_1 
                            AND ref_rek_2.kd_rek_2 = ref_rek_3.kd_rek_2
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

        return make_json
        (
            array
            (
                'html'								=> $detail_rekening
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
			),
			1
		)
		->row();

		return $query;
	}
}
