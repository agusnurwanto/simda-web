<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Kegiatan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Kegiatan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_kegiatan';
	private $_title									= null;
	
	function __construct()
	{
		parent::__construct();

        $this->_urusan								= service('request')->getGet('kd_urusan');
        $this->_bidang								= service('request')->getGet('kd_bidang');
        $this->_prog								= service('request')->getGet('kd_prog');

		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
	}
	
	public function index()
	{
		$this->set_breadcrumb
		(
			array
			(
				'master/data/urusan'				=> phrase('urusan'),
				'../bidang'							=> phrase('bidang'),
				'../program'						=> phrase('program')
			)
		);

		if($this->_prog)
		{
			$query									= $this->model->select('ref_urusan.kd_urusan, ref_urusan.nm_urusan, ref_bidang.kd_bidang, ref_bidang.nm_bidang, ref_program.kd_prog, ref_program.ket_program')
			->join('ref_bidang', 'ref_bidang.kd_bidang = ref_program.kd_bidang')
			->join('ref_urusan', 'ref_urusan.kd_urusan = ref_bidang.kd_urusan')
			->get_where
			(
				'ref_program',
				array
				(
					'ref_program.kd_urusan'			=> $this->_urusan,
					'ref_program.kd_bidang'			=> $this->_bidang,
					'ref_program.kd_prog'			=> $this->_prog
				), 1
			)
			->row();

			$this->set_description
			('
				<div class="row border-bottom">
					<div class="col-12 col-sm-2 text-muted text-uppercase">
						Urusan
					</div>
					<div class="col-4 col-sm-1 font-weight-bold">
						' . (isset($query->kd_urusan) ? $query->kd_urusan : 0) . '
					</div>
					<div class="col-8 col-sm-9 font-weight-bold">
						' . (isset($query->nm_urusan) ? $query->nm_urusan : null) . '
					</div>
				</div>
				<div class="row border-bottom">
					<div class="col-12 col-sm-2 text-muted text-uppercase">
						Bidang
					</div>
					<div class="col-4 col-sm-1 font-weight-bold">
						' . (isset($query->kd_urusan) ? $query->kd_urusan : 0) . '.' . (isset($query->kd_bidang) ? $query->kd_bidang : 0) . '
					</div>
					<div class="col-8 col-sm-9 font-weight-bold">
						' . (isset($query->nm_bidang) ? $query->nm_bidang : null) . '
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-2 text-muted text-uppercase">
						Program
					</div>
					<div class="col-4 col-sm-1 font-weight-bold">
						' . (isset($query->kd_urusan) ? $query->kd_urusan : 0) . '.' . (isset($query->kd_bidang) ? $query->kd_bidang : 0) . '.' . (isset($query->kd_prog) ? $query->kd_prog : 0) . '
					</div>
					<div class="col-8 col-sm-9 font-weight-bold">
						' . (isset($query->ket_program) ? $query->ket_program : null) . '
					</div>
				</div>
			')
			->where
			(
				array
				(
					'kd_urusan'						=> $this->_urusan,
					'kd_bidang'						=> $this->_bidang,
					'kd_prog'						=> $this->_prog
				)
			)
			->set_default
			(
				array
				(
                    'kd_urusan'						=> $this->_urusan,
                    'kd_bidang'						=> $this->_bidang,
                    'kd_prog'						=> $this->_prog
				)
			);
		}
		else
		{
			/*$this->where
			(
				array
				(
					//'tahun'							=> get_userdata('year')
				)
			)
			->set_default
			(
				array
				(
					//'tahun'							=> get_userdata('year')
				)
			)
			->set_relation
			(
				'kd_prog',
				'ref_program.kd_prog',
				'{ref_urusan.kd_urusan}.{ref_bidang.kd_bidang}.{ref_program.kd_program} {ref_program.nm_program}',
				array
				(
					//'ref_program.tahun'				=> get_userdata('year')
				),
				array
				(
					array
					(
						'ref_bidang',
						'ref_bidang.kd_bidang = ref_program.kd_bidang'
					),
					array
					(
						'ref_urusan',
						'ref_urusan.kd_urusan = ref_bidang.kd_urusan'
					)
				)
			//	'ref_bidang.kd_bidang, ref_program.kd_program'
			);*/
		}

        $this->set_title(phrase('master_kegiatan'))
        ->set_icon('mdi mdi-access-point')
        ->set_primary('kd_urusan, kd_bidang, kd_prog, kd_keg')
        ->unset_action('export, print, pdf')
        ->unset_field('kd_urusan, kd_bidang, kd_prog')
        ->column_order('kd_urusan, nm_kegiatan')
        ->field_order('kd_program, kd_kegiatan')
        ->set_field
        (
            array
            (
                'kd_keg'					        => 'last_insert, readonly'
            )
        )
        ->add_class
        (
            array
            (
                'ket_kegiatan'					    => 'autofocus'
            )
        )
        ->set_validation
        (
            array
            (
                'ket_kegiatan'					    => 'required'
            )
        )
        ->set_alias
        (
            array
            (
                'kd_urusan'						    => 'Urusan',
                'kd_bidang'						    => 'Bidang',
                'kd_prog'						    => 'Program',
                'kd_keg'						    => 'Kegiatan',
                'ket_kegiatan'					    => 'Uraian Nama Kegiatan'
            )
        )
        ->order_by('kd_urusan, kd_bidang, kd_prog, kd_keg')
        ->render($this->_table);
	}
}
