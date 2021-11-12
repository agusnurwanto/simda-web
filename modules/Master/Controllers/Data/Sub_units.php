<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Sub Unit
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sub_units extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_sub_unit';
	
	function __construct()
	{
		parent::__construct();

		if(empty(service('request')->getGet('kd_urusan')))
        {
            return throw_exception(301, 'Silakan memilih Master Unit terlebih dahulu...', go_to('units'));
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
                'master/data/units'				    => phrase('units')
            )
        );

        $this->set_title('Master Sub Unit')
        ->set_icon('mdi mdi-access-point')
        ->set_primary('kd_urusan, kd_bidang, kd_unit, kd_sub')
        ->unset_action('export, print, pdf')
        ->unset_field('kd_urusan, kd_bidang, kd_bidang, kd_unit')
        ->unset_truncate('nm_sub_unit')
        ->merge_content('{kd_urusan}.{kd_bidang}.{kd_unit}.{kd_sub}', phrase('kode'))
        ->add_class
        (
            array
            (
                'nm_sub_unit'					    => 'autofocus'
            )
        )
        ->set_validation
        (
            array
            (
                'kd_sub'					        => 'required',
                'nm_sub_unit'					    => 'required'
            )
        )
        ->set_alias
        (
            array
            (
                'kd_sub'					        => 'Sub Unit',
                'nm_sub_unit'					    => 'Uraian Nama Sub Unit'
            )
        )
        ->set_default
        (
            array
            (
                'kd_urusan'						    => service('request')->getGet('kd_urusan'),
                'kd_bidang'						    => service('request')->getGet('kd_bidang'),
                'kd_unit'						    => service('request')->getGet('kd_unit')
            )
        )
        ->where
        (
            array
            (
                'kd_urusan'						    => service('request')->getGet('kd_urusan'),
                'kd_bidang'						    => service('request')->getGet('kd_bidang'),
                'kd_unit'						    => service('request')->getGet('kd_unit')
            )
        )
        ->set_field('kd_sub', 'custom_format', 'callback_kd_sub')
        ->render($this->_table);
	}

    public function kd_sub()
    {
        $last_code								    = $this->model->select_max
        (
        'kd_sub'
        )
            ->get_where
            ('ref_sub_unit',
                array
                (
                    'kd_urusan'                     => service('request')->getGet('kd_urusan'),
                    'kd_bidang'					    => service('request')->getGet('kd_bidang'),
                    'kd_unit'					    => service('request')->getGet('kd_unit')
                ),
                1)
            ->row('kd_sub');

        if(in_array($this->_method, array('create')))
        {
            $last_code                              = $last_code + 1;
            $options								= '<div class="form-group">
                                                        <input name="kd_sub" class="form-control" value="' . $last_code . '">
                                                    </div>';
        }
        else
        {
            $options								= '<div class="form-group">
                                                        <input name="kd_sub" class="form-control" value="' . $last_code . '">
                                                    </div>';
        }

        return $options;
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
                'kd_unit'							=> service('request')->getGet('kd_unit')
            ),
            1
        )
            ->row();

        return $query;
    }

}
