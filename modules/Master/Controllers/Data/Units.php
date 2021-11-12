<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Unit
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Units extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_unit';
	
	function __construct()
	{
		parent::__construct();

        if('dropdown' == service('request')->getPost('trigger'))
        {
            return $this->_dropdown();
        }

		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
        $this->database_config('default');
	}
	
	public function index()
	{
        if(service('request')->getPost('_token'))
        {
            list($r1, $r2, $r3)	= array_pad(explode('.', service('request')->getPost('unit')), 5, 0);

            $this->set_default
            (
                array
                (
                    'kd_urusan'						=> $r1,
                    'kd_bidang'						=> $r2,
                    'kd_unit'						=> $r3
                )
            );
        }

		$this->set_breadcrumb
		(
			array
			(
				'master/data/units'				    => phrase('units')
			)
		);

        $this->set_title('Master Unit')
        ->set_icon('mdi mdi-access-point')
        ->set_primary('kd_urusan, kd_bidang, kd_unit')
        ->unset_action('export, print, pdf')
        ->unset_column('kd_urusan, kd_bidang, kd_unit90')
        ->unset_field('kd_bidang, kd_unit')
        ->unset_view('kd_urusan, kd_bidang')
        ->unset_truncate('nm_unit')
        ->set_field('nm_unit', 'textarea, hyperlink', 'master/data/sub_units', array('kd_urusan' => 'kd_urusan', 'kd_bidang' => 'kd_bidang', 'kd_unit' => 'kd_unit'))
        ->add_class
        (
            array
            (
                'nm_unit'						    => 'autofocus'
            )
        )
        ->set_validation
        (
            array
            (
                'nm_unit'					        => 'required'
            )
        )
        ->set_alias
        (
            array
            (
                'kd_urusan'					        => 'Kode Urusan',
                'kd_unit90'					        => 'Kode Unit90',
                'kd_unit'					        => 'Kode',
                'nm_unit'					        => 'Uraian Nama Unit'
            )
        )
        ->set_field('kd_urusan', 'custom_format', 'callback_kd_urusan')
        ->set_field('kd_unit', 'custom_format', 'callback_kd_unit')
        ->order_by('kd_urusan')
        ->render($this->_table);
	}

    public function kd_urusan($params = array())
    {
        $exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) ;

        $query										= $this->model->select
        ('
			ref_urusan.kd_urusan,
			ref_urusan.nm_urusan
		')
            ->get_where
            (
                'ref_urusan',
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
            $options								.= '<option value="' . $val->kd_urusan . '"' . ($exists == $val->kd_urusan ? ' selected' : null) . '>' . $val->kd_urusan . '. ' . $val->nm_urusan . '</option>';
        }

        $output										.= '
			<div class="form-group">
				<select name="urusan" class="form-control form-control-sm report-dropdown" to-change=".bidang">
					<option value="">Silakan pilih Kode Urusan</option>
					' . $options . '
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">
					Bidang
				</label>
				<select name="bidang" class="form-control form-control-sm report-dropdown bidang get-dropdown-content" to-change=".unit" disabled>
					<option value="">Silakan pilih Kode Urusan terlebih dahulu</option>
				</select>
			</div>
            <div class="form-group">
				<label class="control-label">
					Unit
				</label>
				<select name="unit" class="form-control form-control-sm unit get-dropdown-content" disabled>
					<option value="">Silakan pilih Kode Bidang terlebih dahulu</option>
				</select>
			</div>
		';

        return $output;
    }

    public function kd_unit($params = array())
    {
        $exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0);

        $query										= $this->model->select
        ('
			kd_urusan,
			kd_bidang,
			kd_unit
		')
            ->get_where
            (
                'ref_unit'
            )
            ->result();

        $rekening									= null;

        foreach($query as $key => $val)
        {
            $rekening								= $exists;
        }

        return $rekening;
    }

    private function _dropdown()
    {
        $this->database_config('default');
        $primary									= service('request')->getPost('primary');
        $list										= $primary != '' ? explode(".", $primary) : null;
        $element									= service('request')->getPost('element');
        $options									= null;

        if('.bidang' == $element)
        {
            $query									= $this->model->select
            ('
				kd_urusan,
				kd_bidang,
				nm_bidang
			')
                ->get_where
                (
                    'ref_bidang',
                    array
                    (
                        'ref_bidang.kd_urusan'		=> $list[0]
                    ),
                    NULL,
                    NULL,
                    50,
                )
                ->result();

            $options				                = '<option value="">Silahkan pilih Bidang</option>';
            if($query)
            {
                foreach($query as $key => $val)
                {
                    $options						.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '">' . $val->kd_urusan . '.' . $val->kd_bidang . '. ' . $val->nm_bidang . '</option>';
                }
            }
        }

        if('.unit' == $element)
        {
            $last_code								= $this->model->select_max
            ('
                kd_unit
            ')
                ->get_where
                (
                'ref_unit',
                    array
                    (
                        'kd_urusan' => $list[0],
                        'kd_bidang' => $list[1]
                    ),
            1)
                ->row('kd_unit');

            $last_code                              = $last_code + 1;
            $options						        .= '<option value="' . $list[0] . '.' . $list[1] . '.' . $last_code . '">' . $last_code . '</option>';
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
}
