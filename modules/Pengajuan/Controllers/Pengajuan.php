<?php namespace Modules\Pengajuan\Controllers;
/**
 * Pengajuan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pengajuan extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta__pengajuan';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		/* ambil kode sub berdasarkan sub level */
		$this->_sub_level_1							= $this->model->select('sub_level_1')->get_where
		(
			'app__users_privileges',
			array
			(
				'user_id'							=> get_userdata('user_id')
			),
			1
		)
		->row('sub_level_1');
		
		list($urusan, $bidang, $unit, $sub)			= array_pad(explode('.', $this->_sub_level_1), 4, 0);
		
		$this->_kd_urusan							= ($urusan ? $urusan : service('request')->getGet('Kd_Urusan'));
		$this->_kd_bidang							= ($bidang ? $bidang : service('request')->getGet('Kd_Bidang'));
		$this->_kd_unit								= ($unit ? $unit : service('request')->getGet('Kd_Unit'));
		$this->_kd_sub								= ($sub ? $sub : service('request')->getGet('Kd_Sub'));
		
		if(!$this->_kd_urusan || !$this->_kd_bidang || !$this->_kd_unit || !$this->_kd_sub)
		{
			return throw_exception(301, 'Silakan memilih sub unit terlebih dahulu...', base_url('pengajuan/sub_unit'));
		}
	}
	
	public function index()
	{
		$this->set_title('Pengajuan')
		->set_icon('mdi mdi-format-list-checks')
		
		->set_breadcrumb
		(
			array
			(
				'sub_unit'							=> 'Sub Unit'
			)
		)
		
		->unset_column('id, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub')
		->unset_field('id, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub')
		->unset_action('print, export, pdf')
		->add_action('option', '../laporan/administrasi/surat_pengajuan', 'Surat Pengajuan', 'btn-warning ajax', 'mdi mdi-cloud-print-outline', array('pengajuan' => 'id', 'method' => 'embed'), true)
		->add_action('option', '../laporan/administrasi/lampiran_pengajuan', 'Lampiran Pengajuan', 'btn-success ajax', 'mdi mdi-cloud-print-outline', array('pengajuan' => 'id', 'method' => 'embed'), true)
		->set_field
		(
			array
			(
				'tanggal_pengajuan'					=> 'datepicker',
				'tanggal_pencairan'					=> 'datepicker',
				'uraian'							=> 'textarea'
			)
		)
		->set_field('uraian', 'hyperlink', 'pengajuan/kegiatan', array('id_pengajuan' => 'id'))
		->set_validation
		(
			array
			(
				'tanggal_pengajuan'					=> 'required|valid_date',
				'tanggal_pencairan'					=> 'required|valid_date',
				'uraian'							=> 'required|'
			)
		)
		->column_order('Kd_Urusan, uraian')
		//->merge_content('{Kd_Urusan}.{Kd_Bidang}.{Kd_Unit}.{Kd_Sub}', 'Kode')
		->set_default
		(
			array
			(
				'Kd_Urusan'							=> $this->_kd_urusan,
				'Kd_Bidang'							=> $this->_kd_bidang,
				'Kd_Unit'							=> $this->_kd_unit,
				'Kd_Sub'							=> $this->_kd_sub
			)
		)
		->set_field
		(
			'flag',
			'radio',
			array
			(
				0									=> '<label class="label bg-navy">BTL</label>',
				1									=> '<label class="label bg-green">Mengikat</label>',
				2									=> '<label class="label bg-yellow">Reguler</label>'
			)
		)
		->where
		(
			array
			(
				'Kd_Urusan'							=> $this->_kd_urusan,
				'Kd_Bidang'							=> $this->_kd_bidang,
				'Kd_Unit'							=> $this->_kd_unit,
				'Kd_Sub'							=> $this->_kd_sub
			)
		)
		->render($this->_table);
	}
}
