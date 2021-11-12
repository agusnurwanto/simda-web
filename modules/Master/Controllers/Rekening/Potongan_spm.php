<?php namespace Modules\Master\Controllers\Rekening;
/**
 * Master > Rekening > Potongan SPM
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Potongan_spm extends \Aksara\Laboratory\Core
{
	private $_table									= 'ref_pot_spm_rek';
	private $_title									= null;
	
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
            list($r1, $r2, $r3, $r4, $r5)			= array_pad(explode('.', service('request')->getPost('rekening')), 5, 0);

            $this->set_default
            (
                array
                (
                    'kd_rek_1'						=> $r1,
                    'kd_rek_2'						=> $r2,
                    'kd_rek_3'						=> $r3,
                    'kd_rek_4'						=> $r4,
                    'kd_rek_5'						=> $r5
                )
            );
        }

		$this->set_breadcrumb
		(
			array
			(
				'master/anggaran/sub_unit'		    => phrase('sub_unit')
			)
		);

        $this->set_title(phrase('master_penandatangan_dokumen'))
        ->set_primary('kd_pot_rek, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, kd_pot')
        ->set_icon('mdi mdi-access-point')
        ->unset_action('export, print, pdf')
        ->unset_column('kd_rek_1, kd_rek_2, kd_rek_3')
        ->unset_field('kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5')
        ->unset_view('kd_rek_1, kd_rek_2, kd_rek_3')
        ->set_field
        (
            array
            (
                'kd_pot_rek'					    => 'last_insert, readonly'
            )
        )
        ->set_alias
        (
            array
            (
                'kd_pot_rek'					    => 'Kode',
                'kd_pot'					        => 'Potongan',
                'nm_pot'					        => 'Nama Potongan',
                'kd_rek_1'					        => 'Rekening',
                'kd_rek_4'					        => 'Rekening',
                'kd_rek_5'					        => 'Uraian Rekening'
            )
        )
        ->set_relation
        (
            'kd_pot',
            'ref_pot_spm.kd_pot',
            '{ref_pot_spm.kd_pot}. {ref_pot_spm.nm_pot}',
            null,
            null,
            array
            (
                'ref_pot_spm.kd_pot'				=> 'ASC'
            )
        )
        ->set_field('kd_rek_1', 'custom_format', 'callback_kode_rekening_kd_rek1')
        ->set_field('kd_rek_4', 'custom_format', 'callback_kode_rekening_kd_rek4')
        ->set_field('kd_rek_5', 'custom_format', 'callback_kode_rekening_kd_rek5')
        ->order_by('kd_pot_rek')
        ->render($this->_table);
	}

    public function kode_rekening_kd_rek1($params = array())
    {
        ini_set('memory_limit', '-1');

        $exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

        $query										= $this->model->select
        ('
			kd_rek_1,
			kd_rek_2,
			kd_rek_3,
			kd_rek_4,
			kd_rek_5,
			nm_rek_5
		')
            ->get_where
            (
                'ref_rek_5',
                array
                (
                    'ref_rek_5.kd_rek_1'				=> 7
                )
            )
            ->result();

        $option				                        = '<option value="all">Silahkan Pilih</option>';

        foreach($query as $key => $val)
        {
            $option									.= '<option value="' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 . '"' . ($exists == $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . $val->kd_rek_4 . '.' . $val->kd_rek_5 ? ' selected' : null) . '>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . ' - ' . $val->nm_rek_5 . '</option>';
        }

        return '<select name="rekening" class="form-control" placeholder="Silakan pilih rekening">' . $option . '</select>';
    }

    public function kode_rekening_kd_rek4($params = array())
    {
        $exists										= (isset($params['kd_rek_1']['original']) ? $params['kd_rek_1']['original'] : 0) . '.' . (isset($params['kd_rek_2']['original']) ? $params['kd_rek_2']['original'] : 0) . '.' . (isset($params['kd_rek_3']['original']) ? $params['kd_rek_3']['original'] : 0) . '.' . (isset($params['kd_rek_4']['original']) ? $params['kd_rek_4']['original'] : 0) . '.' . (isset($params['kd_rek_5']['original']) ? $params['kd_rek_5']['original'] : 0);

        $query										= $this->model->select
        ('
			kd_rek_1,
			kd_rek_2,
			kd_rek_3,
			kd_rek_4,
			kd_rek_5,
			nm_rek_5
		')
            ->get_where
            (
                'ref_rek_5',
                array
                (
                    'ref_rek_5.kd_rek_1'				=> $params['kd_rek_1']['original'],
                    'ref_rek_5.kd_rek_2'				=> $params['kd_rek_2']['original'],
                    'ref_rek_5.kd_rek_3'				=> $params['kd_rek_3']['original'],
                    'ref_rek_5.kd_rek_4'				=> $params['kd_rek_4']['original'],
                    'ref_rek_5.kd_rek_5'				=> $params['kd_rek_5']['original']
                )
            )
            ->result();

        $rekening									= null;

        foreach($query as $key => $val)
        {
            $rekening								= $exists;
        }

        return $rekening;
    }

    public function kode_rekening_kd_rek5($params = array())
    {
        $query										= $this->model->select
        ('
			kd_rek_1,
			kd_rek_2,
			kd_rek_3,
			kd_rek_4,
			kd_rek_5,
			nm_rek_5
		')
            ->get_where
            (
                'ref_rek_5',
                array
                (
                    'ref_rek_5.kd_rek_1'				=> $params['kd_rek_1']['original'],
                    'ref_rek_5.kd_rek_2'				=> $params['kd_rek_2']['original'],
                    'ref_rek_5.kd_rek_3'				=> $params['kd_rek_3']['original'],
                    'ref_rek_5.kd_rek_4'				=> $params['kd_rek_4']['original'],
                    'ref_rek_5.kd_rek_5'				=> $params['kd_rek_5']['original']
                )
            )
            ->result();

        $rekening									= null;

        foreach($query as $key => $val)
        {
            $rekening								= $val->nm_rek_5;
        }

        $content									= $rekening;

        return $content;
    }

}
