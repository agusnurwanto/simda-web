<?php namespace Modules\Master\Controllers\Rekening;
/**
 * Master > Rekening > Kelompok
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Kelompok extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_rek_2';
	
	function __construct()
	{
		parent::__construct();

        if('dropdown' == service('request')->getPost('trigger'))
        {
            return $this->_dropdown();
        }

        $this->_akun								= service('request')->getGet('akun');

		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
        $this->database_config('default');
	}
	
	public function index()
	{
        $header										= $this->_header();

        if($this->_akun)
        {
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
			');
            }

            $this->unset_field('kd_rek_1')
            ->set_field
            (
                array
                (
                    'kd_rek_2'							=> 'last_insert, readonly',
                )
            )
            ->set_default
            (
                array
                (
                    'kd_rek_1'						    => service('request')->getGet('akun')
                )
            )
            ->where
            (
                array
                (
                    'kd_rek_1'						    => service('request')->getGet('akun')
                )
            );
        }
        else
        {
            if(service('request')->getPost('_token'))
            {
                $this->set_default
                (
                    array
                    (
                        'kd_rek_1'					=> service('request')->getPost('kd_rek_1'),
                        'kd_rek_2'					=> service('request')->getPost('kd_rek_2')
                    )
                );
            }

            $this->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1')
            ->unset_field('kd_rek_2');
        }

		$this->set_breadcrumb
		(
			array
			(
				'master/rekening/akun'				=> phrase('akun')
			)
		);
		
		$this->set_title('Master Kelompok')
		->set_icon('mdi mdi-access-point')
		->set_primary('kd_rek_1, kd_rek_2')
        ->unset_action('export, print, pdf')
		->unset_truncate('nm_rek_2')
		->set_field('nm_rek_2', 'textarea, hyperlink', 'master/rekening/jenis', array('akun' => 'kd_rek_1', 'kelompok' => 'kd_rek_2'))
		->add_class
		(
			array
			(
				'nm_rek_2'							=> 'autofocus'
			)
		)
		->set_alias
		(
			array
			(
                'kd_rek_1'							=> 'Akun',
                'kd_rek_2'							=> 'Kelompok',
				'nm_rek_2'							=> 'Nama Rekening Kelompok'
			)
		)
		->set_validation
		(
			array
			(
				'nm_rek_2'							=> 'required'
			)
		)
		->order_by('kd_rek_1, kd_rek_2')
        ->render($this->_table);
	}

    public function kode_rekening_kd_rek1($params = array())
    {
        $exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) ;

        $query										= $this->model->select
        ('
			ref_rek_1.kd_rek_1,
			ref_rek_1.nm_rek_1
		')
            ->get_where
            (
                'ref_rek_1',
                array
                (
//                    'ref_urusan.tahun'			    => get_userdata('year')
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
            $options								.= '<option value="' . $val->kd_rek_1 . '"' . ($exists == $val->kd_rek_1 ? ' selected' : null) . '>' . $val->kd_rek_1 . '. ' . $val->nm_rek_1 . '</option>';
        }

        if(in_array($this->_method, array('create')) || in_array($this->_method, array('update')))
        {
            $output									.= '
                <div class="form-group">
                    <select name="kd_rek_1" class="form-control form-control-sm report-dropdown" to-change=".kelompok">
                        <option value="">Silakan pilih Akun</option>
                        ' . $options . '
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Kelompok
                    </label>
                    <select name="kd_rek_2" class="form-control form-control-sm kelompok get-dropdown-content" disabled>
                        <option value="">Silakan pilih Akun terlebih dahulu</option>
                    </select>
                </div>
            ';
        }
        else
        {
            $output                                 .= $exists;
        }

        return $output;
    }

    private function _dropdown()
    {
        $this->database_config('default');
        $primary									= service('request')->getPost('primary');
        $list										= $primary != '' ? explode(".", $primary) : null;
        $element									= service('request')->getPost('element');
        $options									= null;

        if('.kelompok' == $element)
        {
            $last_code								= $this->model->select_max
            ('
                kd_rek_2
            ')
                ->get_where
                (
                    'ref_rek_2',
                    array
                    (
                        'kd_rek_1'                  => $list[0]
                    ),
                    1)
                ->row('kd_rek_2');

            $last_code                              = $last_code + 1;
            $options						        .= '<option value="' . $last_code . '">' . $last_code . '</option>';
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

    private function _header()
    {
        $query										= $this->model->get_where
        (
            'ref_rek_1',
            array
            (
                'kd_rek_1'						    => service('request')->getGet('akun')
            ),
            1
        )
            ->row();

        return $query;
    }
}
