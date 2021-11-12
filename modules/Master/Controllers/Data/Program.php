<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Program
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Program extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_program';
	private $_title									= null;
	
	function __construct()
	{
		parent::__construct();

        $this->_urusan								= service('request')->getGet('kd_urusan');
        $this->_bidang								= service('request')->getGet('kd_bidang');
		
		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
	}

	public function index()
	{
		if($this->_bidang)
		{
			$query									= $this->model->select('ref_urusan.kd_urusan, ref_urusan.nm_urusan, ref_bidang.kd_bidang, ref_bidang.nm_bidang')
			->join('ref_urusan', 'ref_urusan.kd_urusan = ref_bidang.kd_urusan')
			->get_where
			(
				'ref_bidang',
				array
				(
					'ref_bidang.kd_urusan'			=> $this->_urusan,
					'ref_bidang.kd_bidang'			=> $this->_bidang
				), 1
			)
			->row();

			$this->set_description
			('
				<div class="row text-sm border-bottom">
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
				<div class="row text-sm">
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
			')
			->where
			(
				array
				(
					'kd_urusan'						=> $this->_urusan,
					'kd_bidang'						=> $this->_bidang
				)
			)
            ->unset_field('kd_urusan, kd_bidang')
            ->set_default
            (
                array
                (
                    'kd_urusan'						=> $this->_urusan,
                    'kd_bidang'						=> $this->_bidang
                )
            );
		}
		else
		{
			// tdk bisa join 2 table
/*			$this->set_relation
			(
				'kd_urusan, kd_bidang',
				'ref_urusan.kd_urusan, ref_bidang.kd_bidang',
				'{ref_urusan.kd_urusan}.{ref_bidang.kd_bidang} {ref_bidang.nm_bidang}',
				null,
				array
				(
					array
					(
						'ref_urusan',
						'ref_urusan.kd_urusan = ref_bidang.kd_urusan'
					)
				),
				array
				(
					'ref_bidang.kd_bidang'			=> 'ASC'
				),
				'ref_urusan.kd_urusan, ref_bidang.kd_bidang, ref_bidang.nm_bidang'
			);*/
		}

        $this->set_breadcrumb
        (
            array
            (
                'master/data/urusan'				=> phrase('urusan'),
                '../bidang'							=> phrase('bidang')
            )
        );

        $this->set_title(phrase('master_program'))
        ->set_icon('mdi mdi-access-point')
        ->set_primary('kd_urusan, kd_bidang, kd_prog')
        ->unset_action('export, print, pdf')
        ->unset_truncate('ket_program')
        ->column_order('kd_urusan, nm_program')
        ->field_order('kd_bidang')
        ->set_field('ket_program', 'textarea, hyperlink', 'master/data/kegiatan', array('kd_urusan' => 'kd_urusan', 'kd_bidang' => 'kd_bidang', 'kd_prog' => 'kd_prog'))
        ->set_field
        (
            array
            (
                'kd_prog'						    => 'last_insert, readonly'
            )
        )
        ->add_class
        (
            array
            (
                'ket_program'					    => 'autofocus'
            )
        )
        ->set_validation
        (
            array
            (
                'ket_program'					    => 'required'
            )
        )
        ->set_alias
        (
            array
            (
                'kd_urusan'						    => 'Urusan',
                'kd_bidang'						    => 'Bidang',
                'kd_prog'						    => 'Program',
                'ket_program'					    => 'Uraian Nama Program'
            )
        )
        ->order_by('kd_urusan, kd_bidang, kd_prog')
        ->render($this->_table);
	}
}
