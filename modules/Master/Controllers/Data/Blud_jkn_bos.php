<?php namespace Modules\Master\Controllers\Data;
/**
 * Master > Data > Blud Jkn Bos
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Blud_jkn_bos extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_blu';
	
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
        if(service('request')->getPost('_token'))
        {
            list($r1, $r2, $r3, $r4)			    = array_pad(explode('.', service('request')->getPost('kd_urusan')), 5, 0);

            $this->set_default
            (
                array
                (
                    'kd_urusan'						=> $r1,
                    'kd_bidang'						=> $r2,
                    'kd_unit'						=> $r3,
                    'kd_sub'						=> $r4
                )
            );
        }

		$this->set_breadcrumb
		(
			array
			(
                'master/data/blud_jkn_bos'		    => phrase('Unit Organisasi')
			)
		);
		
		$this->set_title('Master Unit Organisiasi Blud Jkn Bos')
		->set_icon('mdi mdi-access-point')
		->set_primary('kd_urusan, kd_bidang, kd_unit, kd_sub')
		->unset_action('export, print, pdf')
        ->unset_column('kd_urusan, kd_bidang')
		->unset_field('kd_bidang, kd_unit, kd_sub')
		->set_alias
		(
			array
			(
				'kd_urusan'							=> 'Urusan',
				'kd_bidang'							=> 'Bidang',
				'kd_unit'							=> 'Kode',
				'kd_sub'							=> 'Uraian Sub Unit'
			)
		)
		->set_validation
		(
			array
			(
				'jenis'							    => 'required'
			)
		)
        ->set_field('kd_urusan', 'custom_format', 'callback_kd_urusan')
        ->set_field('kd_unit', 'custom_format', 'callback_kd_unit')
        ->set_field('kd_sub', 'custom_format', 'callback_kd_sub')
        ->set_field('jenis', 'custom_format', 'callback_jenis')
		->order_by('kd_urusan, kd_bidang, kd_unit, kd_sub')
        ->render($this->_table);
	}

    public function kd_urusan($params = array())
    {
        ini_set('memory_limit', '-1');

        $exists										= (isset($params['kd_urusan']['original']) ? $params['kd_urusan']['original'] : 0) . '.' . (isset($params['kd_bidang']['original']) ? $params['kd_bidang']['original'] : 0) . '.' . (isset($params['kd_unit']['original']) ? $params['kd_unit']['original'] : 0) . '.' . (isset($params['kd_sub']['original']) ? $params['kd_sub']['original'] : 0);

        $query										= $this->model->select
        ('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			nm_sub_unit
		')
            ->get_where
            (
                'ref_sub_unit',
                array
                (
                    //'ref_rek_5.kd_rek_1'				=> 7
                )
            )
            ->result();

        $option				                        = '<option value="">Silahkan Pilih</option>';

        foreach($query as $key => $val)
        {
            $option									.= '<option value="' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '"' . ($exists == $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub ? ' selected' : null) . '>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '. ' . $val->nm_sub_unit . '</option>';
        }

        return '<select name="kd_urusan" class="form-control" placeholder="Silakan pilih rekening">' . $option . '</select>';
    }

    public function kd_unit($params = array())
    {
        $query										= $this->model->select
        ('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			nm_sub_unit
		')
            ->get_where
            (
                'ref_sub_unit',
                array
                (
                    'ref_sub_unit.kd_urusan'		=> $params['kd_urusan']['original'],
                    'ref_sub_unit.kd_bidang'		=> $params['kd_bidang']['original'],
                    'ref_sub_unit.kd_unit'			=> $params['kd_unit']['original'],
                    'ref_sub_unit.kd_sub'			=> $params['kd_sub']['original']
                )
            )
            ->result();

        $rekening									= null;

        foreach($query as $key => $val)
        {
            $rekening								= $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub;
        }

        $content									= $rekening;

        return $content;
    }

    public function kd_sub($params = array())
    {
        $query										= $this->model->select
        ('
			kd_urusan,
			kd_bidang,
			kd_unit,
			kd_sub,
			nm_sub_unit
		')
            ->get_where
            (
                'ref_sub_unit',
                array
                (
                    'ref_sub_unit.kd_urusan'		=> $params['kd_urusan']['original'],
                    'ref_sub_unit.kd_bidang'		=> $params['kd_bidang']['original'],
                    'ref_sub_unit.kd_unit'			=> $params['kd_unit']['original'],
                    'ref_sub_unit.kd_sub'			=> $params['kd_sub']['original']
                )
            )
            ->result();

        $rekening									= null;

        foreach($query as $key => $val)
        {
            $rekening								= $val->nm_sub_unit;
        }

        $content									= $rekening;

        return $content;
    }

    public function jenis($params = array())
    {

        $exists										= (isset($params['jenis']['original']) ? $params['jenis']['original'] : 0);

        if(in_array($this->_method, array('create')) || in_array($this->_method, array('update')))
        {
            $content								= '<select name="jenis" class="form-control" placeholder="Silakan pilih jenis">
                                                        <option value="1" '. ($exists == 1 ? ' selected' : null) .'>BLUD</option>
                                                        <option value="2" '. ($exists == 2 ? ' selected' : null) .'>JKN</option>
                                                        <option value="3" '. ($exists == 3 ? ' selected' : null) .'>BOS</option>
                                                        <option value="4" '. ($exists == 4 ? ' selected' : null) .'>SATGAS COVID19</option>
                                                    </select>';
        }
        else
        {
            $content								= $exists;
        }

        return $content;
    }
}
