<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Bidang
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Bidang extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_bidang';
	private $_title									= null;
	
	function __construct()
	{
		parent::__construct();

        $this->_urusan								= service('request')->getGet('kd_urusan');

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
				'master/data/urusan'				=> phrase('urusan')
			)
		);

		if($this->_urusan)
		{
			$query									= $this->model->select('ref_urusan.kd_urusan, ref_urusan.nm_urusan')
			->get_where
			(
				'ref_urusan',
				array
				(
					'ref_urusan.kd_urusan'			=> $this->_urusan
				), 1
			)
			->row();

			$this->set_description
			('
				<div class="row text-sm">
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
			')
			->unset_column('nm_fungsi')
			->unset_field('kd_urusan')
			->unset_action('export, print, pdf')
			->set_default
			(
				array
				(
					'kd_urusan'						=> $this->_urusan
				)
			)
			->set_relation
			(
				'kd_fungsi',
				'ref_fungsi.kd_fungsi',
				'{ref_fungsi.kd_fungsi}. {ref_fungsi.nm_fungsi}'
			)
			->select('kd_urusan')
			->join('ref_urusan', 'ref_urusan.kd_urusan = ref_bidang.kd_urusan')
			->where
			(
				array
				(
					'kd_urusan'						=> $this->_urusan
				)
			);
		}
		else
		{
			$this->set_relation
			(
				'kd_fungsi',
				'ref_fungsi.kd_fungsi',
				'{ref_fungsi.kd_fungsi}. {ref_fungsi.nm_fungsi}'
			)
			->set_relation
			(
				'kd_urusan',
				'ref_urusan.kd_urusan',
				'{ref_urusan.kd_urusan}. {ref_urusan.nm_urusan}',
				array
				(
					//'ref__urusan.tahun'				=> get_userdata('year')
				),
				NULL,
				array
				(
					'ref_urusan.kd_urusan'			=> 'ASC'
				)
			);
		}

        $this->set_title(phrase('master_bidang'))
        ->set_primary('kd_urusan, kd_bidang')
        ->set_icon('mdi mdi-access-point')
        ->unset_action('export, print, pdf')
        ->unset_column('kd_urusan')
        ->unset_truncate('nm_bidang')
        ->column_order('kode_urusan, kd_bidang, nm_bidang')
        ->field_order('kd_urusan')
        ->merge_content('{kode_urusan}.{kd_bidang}', phrase('kode'))
        ->set_field('nm_bidang', 'textarea, hyperlink', 'master/data/program', array('kd_urusan' => 'kd_urusan', 'kd_bidang' => 'kd_bidang'))
        ->set_field
        (
            array
            (
                'kd_bidang'						    => 'last_insert'
            )
        )
        ->add_class
        (
            array
            (
                'nm_bidang'						    => 'autofocus',
            )
        )
        ->set_alias
        (
            array
            (
                'kd_bidang'						=> 'Kode',
                'nm_bidang'						=> 'Bidang',
                'nm_urusan'						=> 'Nama Urusan',
                'kd_fungsi'						=> 'Fungsi',
                'nm_fungsi'						=> 'Fungsi'
            )
        )
        ->set_validation
        (
            array
            (
                'kd_bidang'						=> 'required',
                'nm_bidang'						=> 'required',
                'kd_fungsi'						=> 'required'
            )
        )
        ->select('ref_urusan.kd_urusan AS kode_urusan')
        ->join('ref_urusan', 'ref_urusan.kd_urusan = ref_bidang.kd_urusan')
        ->order_by('kd_urusan, kd_bidang')
        ->render($this->_table);
	}

}
