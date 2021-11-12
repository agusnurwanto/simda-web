<?php namespace Modules\Master\Controllers\Anggaran;
/**
 * Master > Anggaran > Penandatangan Dokumen
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Penandatangan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_entry';
	private $_title									= null;
	
	function __construct()
	{
		parent::__construct();

        if(empty(service('request')->getGet('kd_urusan')))
        {
            return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('../sub_unit'));
        }

		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
	}

	public function index()
	{
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
				'master/anggaran/sub_unit'		    => phrase('sub_unit')
			)
		);

        $this->set_title(phrase('master_penandatangan_dokumen'))
        ->set_primary('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, kd_penandatangan')
        ->set_icon('mdi mdi-access-point')
        ->unset_action('export, print, pdf')
        ->unset_column('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub, jns_dokumen')
        ->unset_field('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub')
        ->unset_view('tahun, kd_urusan, kd_bidang, kd_unit, kd_sub')
        ->unset_truncate('nm_penandatangan, nip_penandatangan, jbt_penandatangan')
        ->set_field
        (
            array
            (
                'kd_penandatangan'					=> 'last_insert'
            )
        )
        ->add_class
        (
            array
            (
                'nm_penandatangan'					=> 'autofocus',
            )
        )
        ->set_alias
        (
            array
            (
                'kd_penandatangan'					=> 'No',
                'nm_penandatangan'					=> 'Nama',
                'nip_penandatangan'					=> 'Nip',
                'jbt_penandatangan'					=> 'Jabatan'
            )
        )
        ->set_validation
        (
            array
            (
                'nm_penandatangan'					=> 'required',
                'nip_penandatangan'					=> 'required',
                'jbt_penandatangan'					=> 'required'
            )
        )
        ->set_default
        (
            array
            (
                'tahun'								=> get_userdata('year'),
                'kd_urusan'						    => service('request')->getGet('kd_urusan'),
                'kd_bidang'						    => service('request')->getGet('kd_bidang'),
                'kd_unit'						    => service('request')->getGet('kd_unit'),
                'kd_sub'						    => service('request')->getGet('kd_sub')
            )
        )
        ->where
        (
            array
            (
                'kd_urusan'						    => service('request')->getGet('kd_urusan'),
                'kd_bidang'						    => service('request')->getGet('kd_bidang'),
                'kd_unit'						    => service('request')->getGet('kd_unit'),
                'kd_sub'						    => service('request')->getGet('kd_sub')
            )
        )
        ->order_by('kd_penandatangan')
        ->render($this->_table);
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
