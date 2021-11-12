<?php namespace Modules\Master\Controllers\Rekening;
/**
 * Master > Rekening > Rincian
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rincian extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_rek_5';
	
	function __construct()
	{
		parent::__construct();
		
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
						Akun
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_rek_1 . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_rek_1 . '
					</label>
				</div>
                <div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						Kelompok
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_rek_2 . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_rek_2 . '
					</label>
				</div>
                <div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						Jenis
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_rek_3 . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_rek_3 . '
					</label>
				</div>
                <div class="row text-sm">
					<label class="col-12 col-sm-2 text-muted text-uppercase mb-0">
						Obyek
					</label>
					<label class="col-2 col-sm-1 mb-0">
						' . $header->kd_rek_4 . '
					</label>
					<label class="col-10 col-sm-9 text-uppercase mb-0">
						' . $header->nm_rek_4 . '
					</label>
				</div>
			');
        }

		$this->set_breadcrumb
		(
			array
			(
				'master/rekening/akun'				=> phrase('akun'),
				'../../rekening/kelompok'			=> phrase('kelompok'),
				'../../rekening/jenis'			    => phrase('jenis'),
				'../../rekening/obyek'			    => phrase('obyek')
			)
		);
		
		$this->set_title('Master Rincian Obyek')
		->set_icon('mdi mdi-access-point')
		->set_primary('kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
        ->unset_action('export, print, pdf')
        ->unset_field('kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4')
		->unset_truncate('nm_rek_5')
		->set_field
		(
			array
			(
				'kd_rek_5'							=> 'last_insert, readonly',
			)
		)
		->add_class
		(
			array
			(
				'nm_rek_5'							=> 'autofocus'
			)
		)
		->set_alias
		(
			array
			(
                'kd_rek_1'							=> 'Akun',
                'kd_rek_2'							=> 'Kelompok',
                'kd_rek_3'							=> 'Jenis',
                'kd_rek_4'							=> 'Obyek',
                'kd_rek_5'							=> 'Rincian Obyek',
				'nm_rek_5'							=> 'Nama Rekening Rincian Obyek'
			)
		)
		->set_validation
		(
			array
			(
				'nm_rek_5'							=> 'required'
			)
		)
        ->set_default
        (
            array
            (
                'kd_rek_1'						    => service('request')->getGet('akun'),
                'kd_rek_2'						    => service('request')->getGet('kelompok'),
                'kd_rek_3'						    => service('request')->getGet('jenis'),
                'kd_rek_4'						    => service('request')->getGet('obyek')
            )
        )
        ->where
        (
            array
            (
                'kd_rek_1'						    => service('request')->getGet('akun'),
                'kd_rek_2'						    => service('request')->getGet('kelompok'),
                'kd_rek_3'						    => service('request')->getGet('jenis'),
                'kd_rek_4'						    => service('request')->getGet('obyek')
            )
        )
		->order_by('kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
        ->render($this->_table);
	}
    private function _header()
    {
        $query										= $this->model->select
        ('
			ref_rek_1.kd_rek_1,
			ref_rek_1.nm_rek_1,
			ref_rek_2.kd_rek_2,
			ref_rek_2.nm_rek_2,
            ref_rek_3.kd_rek_3,
			ref_rek_3.nm_rek_3,
            ref_rek_4.kd_rek_4,
			ref_rek_4.nm_rek_4
		')
        ->join
        (
            'ref_rek_3',
            'ref_rek_3.kd_rek_3 = ref_rek_4.kd_rek_3 AND ref_rek_3.kd_rek_2 = ref_rek_4.kd_rek_2 AND ref_rek_3.kd_rek_1 = ref_rek_4.kd_rek_1'
        )
        ->join
        (
            'ref_rek_2',
            'ref_rek_2.kd_rek_2 = ref_rek_3.kd_rek_2 AND ref_rek_2.kd_rek_1 = ref_rek_3.kd_rek_1'
        )
        ->join
        (
            'ref_rek_1',
            'ref_rek_1.kd_rek_1 = ref_rek_2.kd_rek_1'
        )
        ->get_where
        (
            'ref_rek_4',
            array
            (
                'ref_rek_4.kd_rek_1'				=> service('request')->getGet('akun'),
                'ref_rek_4.kd_rek_2'				=> service('request')->getGet('kelompok'),
                'ref_rek_4.kd_rek_3'				=> service('request')->getGet('jenis'),
                'ref_rek_4.kd_rek_4'				=> service('request')->getGet('obyek')
            ),
            1
        )
            ->row();

        return $query;
    }
}
