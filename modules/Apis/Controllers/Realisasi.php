<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @version			2.1.0
 * @author			Aby Dahana
 * @author			Ganjar Nugraha
 * @profile			abydahana.github.io
 * @profile			www.ganjar.id
 */
class Realisasi extends Aksara
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		list
		(
			$kd_urusan,
			$kd_bidang,
			$kd_unit,
			$kd_sub,
			$kd_prog,
			$kd_keg,
			$kd_keg_sub
		)											= array_pad(explode('.', $this->input->post('kode_sub_kegiatan')), 6, null);
		$periode_awal								= $this->input->post('periode_awal');
		$periode_akhir								= $this->input->post('periode_akhir');
		
		$query										= $this->model->query
		('
			SELECT
				ta__kegiatan_sub.tahun,
				ref__urusan.kd_urusan,
				ref__bidang.kd_bidang,
				ref__unit.kd_unit,
				ref__sub.kd_sub,
				ref__sub.nm_sub,
				ref__program.kd_program,
				ta__kegiatan.kd_keg,
				ta__kegiatan_sub.kd_keg_sub,
				ta__kegiatan_sub.kegiatan_sub,
				ta__transaksi.tanggal,
				ref__mapping.kd_rek90_1,
				ref__mapping.kd_rek90_2,
				ref__mapping.kd_rek90_3,
				ref__mapping.kd_rek90_4,
				ref__mapping.kd_rek90_5,
				ref__mapping.kd_rek90_6,
				ref__mapping.nm_rek90_6,
				Sum(ta__transaksi_rinci.nilai) AS nilai
			FROM
				ta__transaksi_rinci
			INNER JOIN ta__transaksi ON ta__transaksi_rinci.id_transaksi = ta__transaksi.id
			INNER JOIN ta__kegiatan_sub ON ta__transaksi.id_keg_sub = ta__kegiatan_sub.id
			INNER JOIN ta__kegiatan ON ta__kegiatan_sub.id_keg = ta__kegiatan.id
			INNER JOIN ta__program ON ta__kegiatan.id_prog = ta__program.id
			INNER JOIN ref__sub ON ta__program.id_sub = ref__sub.id
			INNER JOIN ref__unit ON ref__sub.id_unit = ref__unit.id
			INNER JOIN ref__bidang ON ref__unit.id_bidang = ref__bidang.id
			INNER JOIN ref__urusan ON ref__bidang.id_urusan = ref__urusan.id
			INNER JOIN ref__program ON ta__program.id_prog = ref__program.id
			INNER JOIN ta__belanja_rinci ON ta__transaksi_rinci.id_belanja_rinci = ta__belanja_rinci.id
			INNER JOIN ta__belanja_sub ON ta__belanja_rinci.id_belanja_sub = ta__belanja_sub.id
			INNER JOIN ta__belanja ON ta__belanja_sub.id_belanja = ta__belanja.id
			INNER JOIN ref__mapping ON ta__belanja.id_rek_7 = ref__mapping.id_rek_7
			WHERE
				ta__kegiatan_sub.tahun = ' . date('Y') . '
				' . ($kd_urusan ? ' AND ref__urusan.kd_urusan = ' . $kd_urusan : null) . '
				' . ($kd_bidang ? ' AND ref__bidang.kd_bidang = ' . $kd_bidang : null) . '
				' . ($kd_unit ? ' AND ref__unit.kd_unit = ' . $kd_unit : null) . '
				' . ($kd_sub ? ' AND ref__sub.kd_sub = ' . $kd_sub : null) . '
				' . ($kd_prog ? ' AND ref__program.kd_program = ' . $kd_prog : null) . '
				' . ($kd_keg ? ' AND ta__kegiatan.kd_keg = ' . $kd_keg : null) . '
				' . ($kd_keg_sub ? ' AND ta__kegiatan_sub.kd_keg_sub = ' . $kd_keg_sub : null) . '
				' . ($periode_awal && $periode_akhir ? ' AND ta__transaksi.tanggal BETWEEN \'' . $periode_awal . '\' AND \'' . $periode_akhir . '\'' : null) . '
			GROUP BY
				ta__kegiatan_sub.tahun,
				ref__urusan.kd_urusan,
				ref__bidang.kd_bidang,
				ref__sub.kd_sub,
				ref__sub.nm_sub,
				ref__program.kd_program,
				ta__kegiatan.kd_keg,
				ta__kegiatan_sub.kd_keg_sub,
				ta__kegiatan_sub.kegiatan_sub,
				ta__transaksi.tanggal,
				ref__mapping.kd_rek90_1,
				ref__mapping.kd_rek90_2,
				ref__mapping.kd_rek90_3,
				ref__mapping.kd_rek90_4,
				ref__mapping.kd_rek90_5,
				ref__mapping.kd_rek90_6,
				ref__mapping.nm_rek90_6
			ORDER BY
				ref__urusan.kd_urusan ASC,
				ref__bidang.kd_bidang ASC,
				ref__unit.kd_unit ASC,
				ref__sub.kd_sub ASC,
				ref__program.kd_program ASC,
				ta__kegiatan.kd_keg ASC,
				ta__kegiatan_sub.kd_keg_sub ASC,
				ta__transaksi.tanggal ASC,
				ref__mapping.kd_rek90_1 ASC,
				ref__mapping.kd_rek90_2 ASC,
				ref__mapping.kd_rek90_3 ASC,
				ref__mapping.kd_rek90_4 ASC,
				ref__mapping.kd_rek90_5 ASC,
				ref__mapping.kd_rek90_6 ASC
		')
		->result();
		
		$output										= array();
		
		if($query)
		{
			$prepare								= array();
			
			foreach($query as $key => $val)
			{
				$kode_sub							= $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub;
				$kode_sub_kegiatan					= $kode_sub . '.' . $val->kd_program . '.' . $val->kd_keg . '.' . $val->kd_keg_sub;
				
				if(!isset($prepare[$kode_sub]))
				{
					$prepare[$kode_sub]				= array
					(
						'tahun'						=> $val->tahun,
						'kd_urusan'					=> $val->kd_urusan,
						'kd_bidang'					=> $val->kd_bidang,
						'kd_unit'					=> $val->kd_unit,
						'kd_sub'					=> $val->kd_sub,
						'nm_sub'					=> $val->nm_sub
					);
				}
				
				if(!isset($prepare[$kode_sub]['sub_kegiatan'][$kode_sub_kegiatan]))
				{
					$prepare[$kode_sub]['sub_kegiatan'][$kode_sub_kegiatan]				= array
					(
						'kd_program'				=> $val->kd_program,
						'kd_keg'					=> $val->kd_keg,
						'kd_keg_sub'				=> $val->kd_keg_sub,
						'kegiatan'					=> $val->kegiatan_sub
					);
				}
				
				$prepare[$kode_sub]['sub_kegiatan'][$kode_sub_kegiatan]['rekening'][]	= array
				(
					'tanggal'						=> $val->tanggal,
					'kd_rek90_1'					=> $val->kd_rek90_1,
					'kd_rek90_2'					=> $val->kd_rek90_2,
					'kd_rek90_3'					=> $val->kd_rek90_3,
					'kd_rek90_4'					=> $val->kd_rek90_4,
					'kd_rek90_5'					=> $val->kd_rek90_5,
					'kd_rek90_6'					=> $val->kd_rek90_6,
					'nm_rek90_6'					=> $val->nm_rek90_6,
					'nilai'							=> $val->nilai
				);
			}
			
			if($prepare)
			{
				foreach($prepare as $key => $val)
				{
					$sub_kegiatan				= array();
					
					if($val['sub_kegiatan'])
					{
						foreach($val['sub_kegiatan'] as $_key => $_val)
						{
							$sub_kegiatan[]		= $_val;
						}
					}
					
					$val['sub_kegiatan']		= $sub_kegiatan;
					
					$output[]					= $val;
				}
			}
		}
		
		return make_json($output);
	}
}
