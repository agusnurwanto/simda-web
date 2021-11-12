<?php namespace Modules\Master\Controllers\Rekening;
/**
 * Master > Rekening > Jenis
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Jenis extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_rek_3';
	
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
			');
        }

		$this->set_breadcrumb
		(
			array
			(
				'master/rekening/akun'				=> phrase('akun'),
				'../../rekening/kelompok'			=> phrase('kelompok')
			)
		);
		
		$this->set_title('Master Jenis')
		->set_icon('mdi mdi-access-point')
		->set_primary('kd_rek_1, kd_rek_2, kd_rek_3')
        ->unset_action('export, print, pdf')
        ->unset_field('kd_rek_1, kd_rek_2')
		->unset_truncate('nm_rek_3')
		->set_field('nm_rek_3', 'textarea, hyperlink', 'master/rekening/obyek', array('akun' => 'kd_rek_1', 'kelompok' => 'kd_rek_2', 'jenis' => 'kd_rek_3'))
		->set_field
		(
			array
			(
				'kd_rek_3'							=> 'last_insert, readonly',
			)
		)
		->add_class
		(
			array
			(
				'nm_rek_3'							=> 'autofocus'
			)
		)
		->set_alias
		(
			array
			(
                'kd_rek_1'							=> 'Akun',
                'kd_rek_2'							=> 'Kelompok',
                'kd_rek_3'							=> 'Jenis',
				'nm_rek_3'							=> 'Nama Rekening Jenis'
			)
		)
		->set_validation
		(
			array
			(
				'nm_rek_3'							=> 'required'
			)
		)
        ->set_default
        (
            array
            (
                'kd_rek_1'						    => service('request')->getGet('akun'),
                'kd_rek_2'						    => service('request')->getGet('kelompok')
            )
        )
        ->where
        (
            array
            (
                'kd_rek_1'						    => service('request')->getGet('akun'),
                'kd_rek_2'						    => service('request')->getGet('kelompok')
            )
        )
		->order_by('kd_rek_1, kd_rek_2, kd_rek_3')
        ->set_field('saldonorm', 'custom_format', 'callback_kode_saldonorm')
        ->render($this->_table);
	}

    public function kode_saldonorm($params = array())
    {
        $exists										= (isset($params['saldonorm']['original']) ? $params['saldonorm']['original'] : 'D');

        if(in_array($this->_method, array('create')) || in_array($this->_method, array('update')))
        {
            $content								= '<select name="saldonorm" class="form-control">
                                                        <option value="D" '. ($exists == 'D' ? ' selected' : null) .'>DEBET</option>
                                                        <option value="K" '. ($exists == 'K' ? ' selected' : null) .'>KREDIT</option>
                                                    </select>';
        }
        else
        {
            $content								= $exists;
        }

        return $content;
    }

    private function _header()
    {
        $query										= $this->model->select
        ('
			ref_rek_1.kd_rek_1,
			ref_rek_1.nm_rek_1,
			ref_rek_2.kd_rek_2,
			ref_rek_2.nm_rek_2
		')
        ->join
        (
            'ref_rek_1',
            'ref_rek_1.kd_rek_1 = ref_rek_2.kd_rek_1'
        )
        ->get_where
        (
            'ref_rek_2',
            array
            (
                'ref_rek_2.kd_rek_1'				=> service('request')->getGet('akun'),
                'ref_rek_2.kd_rek_2'				=> service('request')->getGet('kelompok')
            ),
            1
        )
            ->row();

        return $query;
    }
}
