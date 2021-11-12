<?php namespace Modules\Bud\Controllers\Sp2b;
/**
 * BUD > SP2B
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Sp2b extends \Aksara\Laboratory\Core
{
	private $_table									= 'ta_sp2b';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->set_permission();
		$this->set_theme('backend');
		
		// must be called after set_theme()
		$this->database_config('default');
		
		$this->_urusan								= service('request')->getGet('kd_urusan');
		
		if(!$this->_urusan)
		{
			return throw_exception(301, 'Silakan memilih Sub Unit terlebih dahulu...', go_to('sub_unit'));
		}
	}

	public function index()
	{
		$header										= $this->_header();
		
		if(!$header)
		{
			$this->set_description
			('				
				<div class="row text-sm border-bottom">
					<div class="col-2 col-sm-2 text-muted text-sm">
						SUB UNIT
					</div>
					<div class="col-2 col-sm-1 font-weight text-sm">
						' . $header['query']->kd_urusan . '.' . $header['query']->kd_bidang . '.' . $header['query']->kd_unit . '.' . $header['query']->kd_sub . '
					</div>
					<div class="col-2 col-sm-2 font-weight text-sm">
						' . $header['query']->nm_sub_unit . '
					</div>
				</div>
				<div class="row text-sm border-bottom">
					<div class="col-2 col-sm-2 text-muted text-sm">
						NO. SPM
					</div>
					<div class="col-4 col-sm-4 font-weight text-sm">
						
					</div>
					<div class="col-4 col-sm-2 font-weight text-sm">
						NILAI SPM
					</div>
					<div class="col-4 col-sm-2 font-weight-bold text-sm">
						<b class="text-danger">
							Rp. ' . number_format((0), 2) . '
						</b>
					</div>
				</div>
				<div class="row text-sm border-bottom">
					<div class="col-2 col-sm-2 text-muted text-sm">
						TANGGAL SPM
					</div>
					<div class="col-4 col-sm-4 font-weight text-sm">
						
					</div>
					<div class="col-4 col-sm-2 font-weight text-sm">
						POTONGAN
					</div>
					<div class="col-4 col-sm-2 font-weight-bold text-sm">
						<b class="text-danger">
							Rp. ' . number_format((0), 2) . '
						</b>
					</div>
				</div>
				</div>
				<div class="row text-sm">
					<div class="col-2 col-sm-2 text-muted text-sm">
						JENIS TAGIHAN
					</div>
					<div class="col-4 col-sm-4 font-weight text-sm">
						
					</div>
					<div class="col-4 col-sm-2 font-weight text-sm">
						JML YANG DIBAYARKAN
					</div>
					<div class="col-4 col-sm-2 font-weight-bold text-sm">
						<b class="text-danger">
							Rp. ' . number_format((0), 2) . '
						</b>
					</div>
				</div>
			');
		}
		
		$this->set_breadcrumb
		(
			array
			(
				'../bud/sp2b/sub_unit'				=> 'Sub Unit',
				'..'								=> 'Sp2b'
			)
		);
		
		$this->set_title('SP2D')
		->set_icon('mdi mdi-parachute-outline')
		->set_primary('tahun, no_sp2d, no_spm, kd_bank')
		/*
        ->unset_action('export, print, pdf')
        ->unset_column('tahun, no_spm, kd_bank, no_bku, nm_penandatangan, nip_penandatangan, jbt_penandatangan')
        ->unset_field('tahun')
        ->unset_view('tahun')
        ->unset_truncate('keterangan')
        ->field_order('no_spm, no_sp2d, tgl_sp2d, no_bku, kd_bank, keterangan')
        ->view_order('no_spm, no_sp2d, tgl_sp2d, no_bku, kd_bank, keterangan')

        ->set_field
        (
            array
            (
                'no_bku'						    => 'last_insert, disabled',
                'tgl_sp2d'				    		=> 'datepicker',
            )
        )
        ->field_position
        (
            array
            (
                'nm_penandatangan'					=> 2,
                'nip_penandatangan'					=> 2,
                'jbt_penandatangan'					=> 2,
            )
        )
        ->set_field
        (
            'kd_bank',
            'radio',
            array
            (
                1									=> 'Bank Jabar Banten'
            )
        )
        ->set_alias
        (
            array
            (
                'no_spm'							=> 'No SPM',
                'no_sp2d'							=> 'No SP2D',
                'tgl_sp2d'							=> 'Tanggal SP2D',
                'keterangan'						=> 'Uraian',
                'no_bku'						    => 'No BKU',
                'kd_bank'						    => 'Bank Pembayar',
                'nm_penandatangan'					=> 'Nama',
                'nip_penandatangan'					=> 'NIP',
                'jbt_penandatangan'					=> 'Jabatan',
            )
        )
        ->set_validation
        (
            array
            (
                'no_spd'							=> 'required||callback_validasi_spd',
                'no_spm'						    => 'required|',
                'no_sp2d'						    => 'required|',
                'tgl_sp2d'						    => 'required|',
                'keterangan'						=> 'required|',
            )
        )
        ->set_default
        (
            array
            (
                'tahun'								=> get_userdata('year')
            )
        )
        ->where
        (
            array
            (
                'tahun'								=> get_userdata('year'),
                'no_spm'							=> service('request')->getGet('no_spm'),
            )
        )
		*/
		->render($this->_table);
	}
	
    private function _header()
    {
        $query										= $this->model->select
        ('
			ta_kegiatan.kd_urusan,
			ta_kegiatan.kd_bidang,
			ta_kegiatan.kd_unit,
			ta_kegiatan.kd_sub,
			ta_kegiatan.kd_keg,
			ta_kegiatan.kd_prog,
			ta_kegiatan.ket_kegiatan,
			ref_sub_unit.nm_sub_unit
		')
		->join
		(
			'ref_sub_unit',
			'ref_sub_unit.kd_urusan = ta_kegiatan.kd_urusan and ref_sub_unit.kd_bidang = ta_kegiatan.kd_bidang and ref_sub_unit.kd_unit = ta_kegiatan.kd_unit and ref_sub_unit.kd_sub = ta_kegiatan.kd_sub'
		)
		->get_where
		(
			'ta_kegiatan',
			array
			(
				'ta_kegiatan.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_kegiatan.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_kegiatan.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_kegiatan.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_kegiatan.kd_keg'				=> 0
			)
		)
		->row();
		
        $query_total								= $this->model->select
        ('
            SUM(ta_spm_rinc.nilai) AS nilai
		')
		->get_where
		(
			'ta_spm_rinc',
			array
			(
				'ta_spm_rinc.kd_urusan'				=> service('request')->getGet('kd_urusan'),
				'ta_spm_rinc.kd_bidang'				=> service('request')->getGet('kd_bidang'),
				'ta_spm_rinc.kd_unit'				=> service('request')->getGet('kd_unit'),
				'ta_spm_rinc.kd_sub'				=> service('request')->getGet('kd_sub'),
				'ta_spm_rinc.no_spm'				=> service('request')->getGet('no_spm')
			)
		)
		->row();
		
        $output										= array
        (
            'query'									=> $query,
            'query_total'							=> $query_total
        );
		
        return $output;
    }
}
