<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Anggaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Anggaran_kas extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Anggaran Kas
	 */
	public function anggaran_kas($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ta_kegiatan.kd_urusan,
				ta_kegiatan.kd_bidang,
				ta_kegiatan.kd_unit,
				ta_kegiatan.kd_sub,
				ta_kegiatan.kd_prog,
				ta_kegiatan.id_prog,
				ta_kegiatan.kd_keg,

				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit,
				ta_program.ket_program AS nm_program,

				ta_kegiatan.ket_kegiatan AS nm_kegiatan,
				ta_kegiatan.pagu_anggaran AS pagu
			FROM
				ta_kegiatan 
		    INNER JOIN ta_program ON 
				ta_kegiatan.id_prog = ta_program.id_prog AND
				ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
				ta_kegiatan.kd_prog = ta_program.kd_prog AND
				ta_kegiatan.kd_sub = ta_program.kd_sub AND
				ta_kegiatan.kd_unit = ta_program.kd_unit AND
				ta_kegiatan.kd_urusan = ta_program.kd_urusan
			INNER JOIN ref_sub_unit ON 
				ta_program.kd_urusan = ref_sub_unit.kd_urusan AND
				ta_program.kd_bidang = ref_sub_unit.kd_bidang AND
				ta_program.kd_unit = ref_sub_unit.kd_unit AND
				ta_program.kd_sub = ref_sub_unit.kd_sub
			INNER JOIN ref_unit ON 
				ref_sub_unit.kd_bidang = ref_unit.kd_bidang AND
				ref_sub_unit.kd_unit = ref_unit.kd_unit AND
				ref_sub_unit.kd_urusan = ref_unit.kd_urusan
			INNER JOIN ref_bidang ON 
				ref_unit.kd_bidang = ref_bidang.kd_bidang AND
				ref_unit.kd_urusan = ref_bidang.kd_urusan
			INNER JOIN ref_urusan ON 
				ref_bidang.kd_urusan = ref_urusan.kd_urusan
			WHERE
				ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
				AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				AND ta_kegiatan.kd_prog = ' . $params['kd_prog'] . '
				AND ta_kegiatan.id_prog = ' . $params['id_prog'] . '
				AND ta_kegiatan.kd_keg = ' . $params['kd_keg'] . '
		')
			->row();
/*		$tanggal_query								= $this->query
		('
			SELECT
				ref__renja_jenis_anggaran.tanggal_anggaran_kas
			FROM
				ref__renja_jenis_anggaran
			WHERE
				ref__renja_jenis_anggaran.kode = ' . $header_query->id_jenis_anggaran . '
			LIMIT 1
		')
			->row('tanggal_anggaran_kas');*/
		$data_query									= $this->query
		('
			SELECT
				ref_rek_3.kd_rek_1 AS id_rek_3,
				ref_rek_4.kd_rek_2 AS id_rek_4,
				ref_rek_5.kd_rek_3 AS id_rek_5,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_4.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_3.nm_rek_3 AS uraian_rek_3,
				ref_rek_4.nm_rek_4 AS uraian_rek_4,
				ref_rek_5.nm_rek_5 AS uraian_rek_5,
			       
                pagu_rek_3.pagu_rek_3,
				pagu_rek_4.pagu_rek_4,
				pagu_rek_5.pagu_rek_5,
				
				(ta_rencana.jan + ta_rencana.feb + ta_rencana.mar) AS rencana_rek_5_tw_1,
				(ta_rencana.apr + ta_rencana.mei + ta_rencana.jun) AS rencana_rek_5_tw_2,
				(ta_rencana.jul + ta_rencana.agt + ta_rencana.sep) AS rencana_rek_5_tw_3,
				(ta_rencana.okt + ta_rencana.nop + ta_rencana.des) AS rencana_rek_5_tw_4,
				
				rencana_rek_4.rencana_rek_4_tw_1,
				rencana_rek_4.rencana_rek_4_tw_2,
				rencana_rek_4.rencana_rek_4_tw_3,
				rencana_rek_4.rencana_rek_4_tw_4,
				
				rencana_rek_3.rencana_rek_3_tw_1,
				rencana_rek_3.rencana_rek_3_tw_2,
				rencana_rek_3.rencana_rek_3_tw_3,
				rencana_rek_3.rencana_rek_3_tw_4
			FROM
				ta_rencana
			INNER JOIN ta_belanja ON 
				ta_rencana.kd_urusan = ta_belanja.kd_urusan AND
				ta_rencana.kd_bidang = ta_belanja.kd_bidang AND
				ta_rencana.kd_unit = ta_belanja.kd_unit AND
				ta_rencana.kd_sub = ta_belanja.kd_sub AND
				ta_rencana.kd_prog = ta_belanja.kd_prog AND
				ta_rencana.id_prog = ta_belanja.id_prog AND
				ta_rencana.kd_keg = ta_belanja.kd_keg
			INNER JOIN ref_rek_5 ON 
				ta_belanja.kd_rek_1 = ref_rek_5.kd_rek_1 AND
				ta_belanja.kd_rek_2 = ref_rek_5.kd_rek_2 AND
				ta_belanja.kd_rek_3 = ref_rek_5.kd_rek_3 AND
				ta_belanja.kd_rek_4 = ref_rek_5.kd_rek_4 AND
				ta_belanja.kd_rek_5 = ref_rek_5.kd_rek_5
			INNER JOIN ref_rek_4 ON 
				ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
				ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
				ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
				ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
			INNER JOIN ref_rek_3 ON 
				ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
				ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
				ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
			INNER JOIN ref_rek_2 ON 
				ref_rek_3.kd_rek_1 = ref_rek_2.kd_rek_1 AND
				ref_rek_3.kd_rek_2 = ref_rek_2.kd_rek_2
			INNER JOIN ref_rek_1 ON 
				ref_rek_2.kd_rek_1 = ref_rek_1.kd_rek_1
			LEFT JOIN (
				SELECT
					ta_belanja.kd_rek_5,
					Sum(ta_belanja_rinc_sub.total) AS pagu_rek_5
				FROM
					ta_belanja_rinc_sub
				INNER JOIN ta_belanja_rinc ON 
					ta_belanja_rinc_sub.id_prog = ta_belanja_rinc.id_prog AND
					ta_belanja_rinc_sub.kd_bidang = ta_belanja_rinc.kd_bidang AND
					ta_belanja_rinc_sub.kd_keg = ta_belanja_rinc.kd_keg AND
					ta_belanja_rinc_sub.kd_prog = ta_belanja_rinc.kd_prog AND
					ta_belanja_rinc_sub.kd_rek_1 = ta_belanja_rinc.kd_rek_1 AND
					ta_belanja_rinc_sub.kd_rek_2 = ta_belanja_rinc.kd_rek_2 AND
					ta_belanja_rinc_sub.kd_rek_3 = ta_belanja_rinc.kd_rek_3 AND
					ta_belanja_rinc_sub.kd_rek_4 = ta_belanja_rinc.kd_rek_4 AND
					ta_belanja_rinc_sub.kd_rek_5 = ta_belanja_rinc.kd_rek_5 AND
					ta_belanja_rinc_sub.kd_sub = ta_belanja_rinc.kd_sub AND
					ta_belanja_rinc_sub.kd_unit = ta_belanja_rinc.kd_unit AND
					ta_belanja_rinc_sub.kd_urusan = ta_belanja_rinc.kd_urusan AND
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc
				INNER JOIN ta_belanja ON 
					ta_belanja_rinc.id_prog = ta_belanja.id_prog AND
					ta_belanja_rinc.kd_bidang = ta_belanja.kd_bidang AND
					ta_belanja_rinc.kd_keg = ta_belanja.kd_keg AND
					ta_belanja_rinc.kd_prog = ta_belanja.kd_prog AND
					ta_belanja_rinc.kd_rek_1 = ta_belanja.kd_rek_1 AND
					ta_belanja_rinc.kd_rek_2 = ta_belanja.kd_rek_2 AND
					ta_belanja_rinc.kd_rek_3 = ta_belanja.kd_rek_3 AND
					ta_belanja_rinc.kd_rek_4 = ta_belanja.kd_rek_4 AND
					ta_belanja_rinc.kd_rek_5 = ta_belanja.kd_rek_5 AND
					ta_belanja_rinc.kd_sub = ta_belanja.kd_sub AND
					ta_belanja_rinc.kd_unit = ta_belanja.kd_unit AND
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ta_belanja.kd_rek_5
			) AS pagu_rek_5 ON pagu_rek_5.kd_rek_5 = ref_rek_5.kd_rek_5
			LEFT JOIN (
				SELECT
					ref_rek_5.kd_rek_4,
					Sum(ta_belanja_rinc_sub.total) AS pagu_rek_4
				FROM
					ta_belanja_rinc_sub
				INNER JOIN ta_belanja_rinc ON 
					ta_belanja_rinc_sub.id_prog = ta_belanja_rinc.id_prog AND
					ta_belanja_rinc_sub.kd_bidang = ta_belanja_rinc.kd_bidang AND
					ta_belanja_rinc_sub.kd_keg = ta_belanja_rinc.kd_keg AND
					ta_belanja_rinc_sub.kd_prog = ta_belanja_rinc.kd_prog AND
					ta_belanja_rinc_sub.kd_rek_1 = ta_belanja_rinc.kd_rek_1 AND
					ta_belanja_rinc_sub.kd_rek_2 = ta_belanja_rinc.kd_rek_2 AND
					ta_belanja_rinc_sub.kd_rek_3 = ta_belanja_rinc.kd_rek_3 AND
					ta_belanja_rinc_sub.kd_rek_4 = ta_belanja_rinc.kd_rek_4 AND
					ta_belanja_rinc_sub.kd_rek_5 = ta_belanja_rinc.kd_rek_5 AND
					ta_belanja_rinc_sub.kd_sub = ta_belanja_rinc.kd_sub AND
					ta_belanja_rinc_sub.kd_unit = ta_belanja_rinc.kd_unit AND
					ta_belanja_rinc_sub.kd_urusan = ta_belanja_rinc.kd_urusan AND
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc
				INNER JOIN ta_belanja ON 
					ta_belanja_rinc.id_prog = ta_belanja.id_prog AND
					ta_belanja_rinc.kd_bidang = ta_belanja.kd_bidang AND
					ta_belanja_rinc.kd_keg = ta_belanja.kd_keg AND
					ta_belanja_rinc.kd_prog = ta_belanja.kd_prog AND
					ta_belanja_rinc.kd_rek_1 = ta_belanja.kd_rek_1 AND
					ta_belanja_rinc.kd_rek_2 = ta_belanja.kd_rek_2 AND
					ta_belanja_rinc.kd_rek_3 = ta_belanja.kd_rek_3 AND
					ta_belanja_rinc.kd_rek_4 = ta_belanja.kd_rek_4 AND
					ta_belanja_rinc.kd_rek_5 = ta_belanja.kd_rek_5 AND
					ta_belanja_rinc.kd_sub = ta_belanja.kd_sub AND
					ta_belanja_rinc.kd_unit = ta_belanja.kd_unit AND
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan
				INNER JOIN ref_rek_5 ON 
					ta_belanja.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_belanja.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_belanja.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_belanja.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_belanja.kd_rek_5 = ref_rek_5.kd_rek_5
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_5.kd_rek_4
			) AS pagu_rek_4 ON pagu_rek_4.kd_rek_4 = ref_rek_4.kd_rek_4
			LEFT JOIN (
				SELECT
					ref_rek_4.kd_rek_3,
					Sum(ta_belanja_rinc_sub.total) AS pagu_rek_3
				FROM
					ta_belanja_rinc_sub
				INNER JOIN ta_belanja_rinc ON 
					ta_belanja_rinc_sub.id_prog = ta_belanja_rinc.id_prog AND
					ta_belanja_rinc_sub.kd_bidang = ta_belanja_rinc.kd_bidang AND
					ta_belanja_rinc_sub.kd_keg = ta_belanja_rinc.kd_keg AND
					ta_belanja_rinc_sub.kd_prog = ta_belanja_rinc.kd_prog AND
					ta_belanja_rinc_sub.kd_rek_1 = ta_belanja_rinc.kd_rek_1 AND
					ta_belanja_rinc_sub.kd_rek_2 = ta_belanja_rinc.kd_rek_2 AND
					ta_belanja_rinc_sub.kd_rek_3 = ta_belanja_rinc.kd_rek_3 AND
					ta_belanja_rinc_sub.kd_rek_4 = ta_belanja_rinc.kd_rek_4 AND
					ta_belanja_rinc_sub.kd_rek_5 = ta_belanja_rinc.kd_rek_5 AND
					ta_belanja_rinc_sub.kd_sub = ta_belanja_rinc.kd_sub AND
					ta_belanja_rinc_sub.kd_unit = ta_belanja_rinc.kd_unit AND
					ta_belanja_rinc_sub.kd_urusan = ta_belanja_rinc.kd_urusan AND
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc
				INNER JOIN ta_belanja ON 
					ta_belanja_rinc.id_prog = ta_belanja.id_prog AND
					ta_belanja_rinc.kd_bidang = ta_belanja.kd_bidang AND
					ta_belanja_rinc.kd_keg = ta_belanja.kd_keg AND
					ta_belanja_rinc.kd_prog = ta_belanja.kd_prog AND
					ta_belanja_rinc.kd_rek_1 = ta_belanja.kd_rek_1 AND
					ta_belanja_rinc.kd_rek_2 = ta_belanja.kd_rek_2 AND
					ta_belanja_rinc.kd_rek_3 = ta_belanja.kd_rek_3 AND
					ta_belanja_rinc.kd_rek_4 = ta_belanja.kd_rek_4 AND
					ta_belanja_rinc.kd_rek_5 = ta_belanja.kd_rek_5 AND
					ta_belanja_rinc.kd_sub = ta_belanja.kd_sub AND
					ta_belanja_rinc.kd_unit = ta_belanja.kd_unit AND
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan
				INNER JOIN ref_rek_5 ON 
					ta_belanja.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_belanja.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_belanja.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_belanja.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_belanja.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_4.kd_rek_3
			) AS pagu_rek_3 ON pagu_rek_3.kd_rek_3 = ref_rek_3.kd_rek_3
			LEFT JOIN (
				SELECT
					ref_rek_5.kd_rek_4,
					Sum(ta_rencana.jan + ta_rencana.feb + ta_rencana.mar) AS rencana_rek_4_tw_1,
					Sum(ta_rencana.apr + ta_rencana.mei + ta_rencana.jun) AS rencana_rek_4_tw_2,
					Sum(ta_rencana.jul + ta_rencana.agt + ta_rencana.sep) AS rencana_rek_4_tw_3,
					Sum(ta_rencana.okt + ta_rencana.nop + ta_rencana.des) AS rencana_rek_4_tw_4
				FROM
					ta_rencana
				INNER JOIN ta_belanja ON 
					ta_rencana.kd_urusan = ta_belanja.kd_urusan AND
					ta_rencana.kd_bidang = ta_belanja.kd_bidang AND
					ta_rencana.kd_unit = ta_belanja.kd_unit AND
					ta_rencana.kd_sub = ta_belanja.kd_sub AND
					ta_rencana.kd_prog = ta_belanja.kd_prog AND
					ta_rencana.id_prog = ta_belanja.id_prog AND
					ta_rencana.kd_keg = ta_belanja.kd_keg
				INNER JOIN ref_rek_5 ON 
					ta_belanja.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_belanja.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_belanja.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_belanja.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_belanja.kd_rek_5 = ref_rek_5.kd_rek_5
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_5.kd_rek_4
			) AS rencana_rek_4 ON rencana_rek_4.kd_rek_4 = ref_rek_4.kd_rek_4
			LEFT JOIN (
				SELECT
					ref_rek_4.kd_rek_3,
					Sum(ta_rencana.jan + ta_rencana.feb + ta_rencana.mar) AS rencana_rek_3_tw_1,
					Sum(ta_rencana.apr + ta_rencana.mei + ta_rencana.jun) AS rencana_rek_3_tw_2,
					Sum(ta_rencana.jul + ta_rencana.agt + ta_rencana.sep) AS rencana_rek_3_tw_3,
					Sum(ta_rencana.okt + ta_rencana.nop + ta_rencana.des) AS rencana_rek_3_tw_4
				FROM
					ta_rencana
				INNER JOIN ta_belanja ON 
					ta_rencana.kd_urusan = ta_belanja.kd_urusan AND
					ta_rencana.kd_bidang = ta_belanja.kd_bidang AND
					ta_rencana.kd_unit = ta_belanja.kd_unit AND
					ta_rencana.kd_sub = ta_belanja.kd_sub AND
					ta_rencana.kd_prog = ta_belanja.kd_prog AND
					ta_rencana.id_prog = ta_belanja.id_prog AND
					ta_rencana.kd_keg = ta_belanja.kd_keg
				INNER JOIN ref_rek_5 ON 
					ta_belanja.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_belanja.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_belanja.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_belanja.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_belanja.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_4.kd_rek_3
			) AS rencana_rek_3 ON rencana_rek_3.kd_rek_3 = ref_rek_3.kd_rek_3
			WHERE
				ta_rencana.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_rencana.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_rencana.kd_unit = ' . $params['kd_unit'] . '
				AND ta_rencana.kd_sub = ' . $params['kd_sub'] . '
				AND ta_rencana.kd_prog = ' . $params['kd_prog'] . '
				AND ta_rencana.id_prog = ' . $params['id_prog'] . '
				AND ta_rencana.kd_keg = ' . $params['kd_keg'] . '
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC,
				ref_rek_4.kd_rek_4 ASC,
				ref_rek_5.kd_rek_5 ASC
		')
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'tanggal_anggaran_kas'					=> $params['tahun'],
			'data'									=> $data_query
		);
		//print_r($output);exit;
		return $output;
	}

	public function rekapitulasi_anggaran_kas_kegiatan($params)
	{
		if($params['kd_unit'] == 'all' || $params['kd_unit'] == NULL)
		{
			$unit									= "'%'";
			$unit_query								= $this->query
			('
				SELECT
					ref__settings.jabatan_kepala_keuangan AS jabatan,
					ref__settings.nama_kepala_keuangan AS nama_pejabat,
					ref__settings.nip_kepala_keuangan AS nip_pejabat
				FROM
					ref__settings
				WHERE
					ref__settings.tahun = ' . $tahun . '
				LIMIT 1
			')
				->row();
		}
		else
		{
			$unit_query								= $this->query
			('
				SELECT
					ref_urusan.kd_urusan,
					ref_bidang.kd_bidang,
					ref_unit.kd_unit,
					ref_urusan.nm_urusan,
					ref_bidang.nm_bidang,
					ref_unit.nm_unit,
					ta_sub_unit.jbt_pimpinan AS jabatan,
					ta_sub_unit.nm_pimpinan AS nama_pejabat,
					ta_sub_unit.nip_pimpinan AS nip_pejabat
				FROM
					ref_sub_unit
					INNER JOIN ta_sub_unit ON 
						ref_sub_unit.kd_bidang = ta_sub_unit.kd_bidang AND
						ref_sub_unit.kd_sub = ta_sub_unit.kd_sub AND
						ref_sub_unit.kd_unit = ta_sub_unit.kd_unit AND
						ref_sub_unit.kd_urusan = ta_sub_unit.kd_urusan
					INNER JOIN ref_unit ON 
						ref_sub_unit.kd_bidang = ref_unit.kd_bidang AND
						ref_sub_unit.kd_unit = ref_unit.kd_unit AND
						ref_sub_unit.kd_urusan = ref_unit.kd_urusan
					INNER JOIN ref_bidang ON 
						ref_unit.kd_bidang = ref_bidang.kd_bidang AND
						ref_unit.kd_urusan = ref_bidang.kd_urusan
					INNER JOIN ref_urusan ON 
						ref_bidang.kd_urusan = ref_urusan.kd_urusan
				WHERE
					ref_sub_unit.kd_urusan = ' . $params['kd_urusan'] . '
					AND ref_sub_unit.kd_bidang = ' . $params['kd_bidang'] . '
					AND ref_sub_unit.kd_unit = ' . $params['kd_unit'] . '
					AND ref_sub_unit.kd_sub = ' . $params['kd_sub'] . '
			')
				->row();
		}

		if($params['kd_sub'] == 'all' || $params['kd_sub'] == NULL)
		{
			$sub_unit								= "'%'";
		}

		$data										= $this->query
		('
			SELECT
				ref_urusan.kd_urusan AS id_urusan,
				ref_bidang.kd_bidang AS id_bidang,
				ref_program.kd_prog AS id_program,
				ta_kegiatan.kd_keg AS id_kegiatan,
				ref_urusan.kd_urusan AS kode_urusan,
				ref_bidang.kd_bidang AS kode_bidang,
				ref_unit.kd_unit AS kode_unit,
				ref_sub_unit.kd_sub AS kode_sub,
				ref_program.kd_prog AS kode_program,
				ta_kegiatan.kd_keg AS kode_kegiatan,
                ref_urusan.nm_urusan AS nama_urusan,
				ref_bidang.nm_bidang AS nama_bidang,
				ref_program.ket_program AS nama_program,
				ta_kegiatan.ket_kegiatan AS nama_kegiatan,
				ta_kegiatan.pagu_anggaran AS pagu,
				rencana.tw_1,
				rencana.tw_2,
				rencana.tw_3,
				rencana.tw_4
			FROM
				ta_kegiatan
			INNER JOIN ta_program ON 
				ta_kegiatan.id_prog = ta_program.id_prog AND
				ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
				ta_kegiatan.kd_prog = ta_program.kd_prog AND
				ta_kegiatan.kd_sub = ta_program.kd_sub AND
				ta_kegiatan.kd_unit = ta_program.kd_unit AND
				ta_kegiatan.kd_urusan = ta_program.kd_urusan
			INNER JOIN ref_sub_unit ON 
				ta_program.kd_urusan = ref_sub_unit.kd_urusan AND
				ta_program.kd_bidang = ref_sub_unit.kd_bidang AND
				ta_program.kd_unit = ref_sub_unit.kd_unit AND
				ta_program.kd_sub = ref_sub_unit.kd_sub
			INNER JOIN ref_unit ON 
				ref_sub_unit.kd_bidang = ref_unit.kd_bidang AND
				ref_sub_unit.kd_unit = ref_unit.kd_unit AND
				ref_sub_unit.kd_urusan = ref_unit.kd_urusan
			INNER JOIN ref_program ON 
				ta_program.kd_urusan = ref_program.kd_urusan AND
				ta_program.kd_bidang = ref_program.kd_bidang AND
				ta_program.kd_prog = ref_program.kd_prog
			INNER JOIN ref_bidang ON 
				ref_unit.kd_urusan = ref_bidang.kd_urusan AND
				ref_unit.kd_bidang = ref_bidang.kd_bidang
			INNER JOIN ref_urusan ON 
				ref_bidang.kd_urusan = ref_urusan.kd_urusan
			LEFT JOIN (
				SELECT
					ta_belanja.kd_keg,
					Sum((ta_rencana.jan + ta_rencana.feb + ta_rencana.mar)) AS tw_1,
					Sum((ta_rencana.apr + ta_rencana.mei + ta_rencana.jun)) AS tw_2,
					Sum((ta_rencana.jul + ta_rencana.agt + ta_rencana.sep)) AS tw_3,
					Sum((ta_rencana.okt + ta_rencana.nop + ta_rencana.des)) AS tw_4
				FROM
					ta_kegiatan
					INNER JOIN ta_belanja ON 
						ta_kegiatan.id_prog = ta_belanja.id_prog AND
						ta_kegiatan.kd_bidang = ta_belanja.kd_bidang AND
						ta_kegiatan.kd_keg = ta_belanja.kd_keg AND
						ta_kegiatan.kd_prog = ta_belanja.kd_prog AND
						ta_kegiatan.kd_sub = ta_belanja.kd_sub AND
						ta_kegiatan.kd_unit = ta_belanja.kd_unit AND
						ta_kegiatan.kd_urusan = ta_belanja.kd_urusan AND
						ta_kegiatan.tahun = ta_belanja.tahun
					INNER JOIN ta_program ON 
						ta_kegiatan.id_prog = ta_program.id_prog AND
						ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
						ta_kegiatan.kd_prog = ta_program.kd_prog AND
						ta_kegiatan.kd_sub = ta_program.kd_sub AND
						ta_kegiatan.kd_unit = ta_program.kd_unit AND
						ta_kegiatan.kd_urusan = ta_program.kd_urusan AND
						ta_kegiatan.tahun = ta_program.tahun
					INNER JOIN ta_rencana ON 
						ta_kegiatan.id_prog = ta_rencana.id_prog AND
						ta_kegiatan.kd_bidang = ta_rencana.kd_bidang AND
						ta_kegiatan.kd_keg = ta_rencana.kd_keg AND
						ta_kegiatan.kd_prog = ta_rencana.kd_prog AND
						ta_kegiatan.kd_sub = ta_rencana.kd_sub AND
						ta_kegiatan.kd_unit = ta_rencana.kd_unit AND
						ta_kegiatan.kd_urusan = ta_rencana.kd_urusan AND
						ta_kegiatan.tahun = ta_rencana.tahun
					INNER JOIN ref_sub_unit ON 
						ta_kegiatan.kd_urusan = ref_sub_unit.kd_urusan AND
						ta_kegiatan.kd_bidang = ref_sub_unit.kd_bidang AND
						ta_kegiatan.kd_unit = ref_sub_unit.kd_unit AND
						ta_kegiatan.kd_sub = ref_sub_unit.kd_sub
				WHERE
					ref_sub_unit.kd_unit LIKE ' . $params['kd_unit'] . ' AND
					ref_sub_unit.kd_sub LIKE ' . $params['kd_sub'] . '
				GROUP BY
					ta_belanja.kd_keg
			) AS rencana ON rencana.kd_keg = ta_kegiatan.kd_keg
			WHERE
				ref_sub_unit.kd_unit LIKE ' . $params['kd_unit'] . ' AND
				ref_sub_unit.kd_sub LIKE ' . $params['kd_sub'] . '
			ORDER BY
				ref_sub_unit.kd_sub ASC,
				ta_kegiatan.kd_keg ASC
		')
			->result();
		$output										= array
		(
			'unit'									=> $unit_query,
			'data'									=> $data
		);
		//print_r($output);exit;
		return $output;
	}

	public function rekapitulasi_anggaran_kas_per_bulan($params)
	{
//		$header_query								= $this->db->query
//		('
//			SELECT
//				ref__settings.jabatan_sekretaris_daerah,
//				ref__settings.nama_sekretaris_daerah,
//				ref__settings.nip_sekretaris_daerah
//			FROM
//				ref__settings
//			WHERE
//				ref__settings.tahun = ' . $tahun . '
//		')
//			->row();
		$data										= $this->query
		('
			SELECT
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_sub_unit.nm_sub_unit AS nm_sub,
				anggaran.plafon,
				rencana.jan,
				rencana.feb,
				rencana.mar,
				rencana.apr,
				rencana.mei,
				rencana.jun,
				rencana.jul,
				rencana.agt,
				rencana.sep,
				rencana.okt,
				rencana.nop,
				rencana.des
			FROM
				ref_sub_unit
			LEFT JOIN (
				SELECT
					ta_program.kd_sub,
					Sum(ta_belanja_rinc_sub.total) AS plafon
				FROM
					dbo.ta_belanja_rinc_sub
					INNER JOIN
					dbo.ta_belanja_rinc
					ON 
						ta_belanja_rinc_sub.id_prog = ta_belanja_rinc.id_prog AND
						ta_belanja_rinc_sub.kd_bidang = ta_belanja_rinc.kd_bidang AND
						ta_belanja_rinc_sub.kd_keg = ta_belanja_rinc.kd_keg AND
						ta_belanja_rinc_sub.kd_prog = ta_belanja_rinc.kd_prog AND
						ta_belanja_rinc_sub.kd_rek_1 = ta_belanja_rinc.kd_rek_1 AND
						ta_belanja_rinc_sub.kd_rek_2 = ta_belanja_rinc.kd_rek_2 AND
						ta_belanja_rinc_sub.kd_rek_3 = ta_belanja_rinc.kd_rek_3 AND
						ta_belanja_rinc_sub.kd_rek_4 = ta_belanja_rinc.kd_rek_4 AND
						ta_belanja_rinc_sub.kd_rek_5 = ta_belanja_rinc.kd_rek_5 AND
						ta_belanja_rinc_sub.kd_sub = ta_belanja_rinc.kd_sub AND
						ta_belanja_rinc_sub.kd_unit = ta_belanja_rinc.kd_unit AND
						ta_belanja_rinc_sub.kd_urusan = ta_belanja_rinc.kd_urusan AND
						ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc
					INNER JOIN
					dbo.ta_kegiatan
					ON 
						ta_belanja_rinc.kd_urusan = ta_kegiatan.kd_urusan AND
						ta_belanja_rinc.kd_bidang = ta_kegiatan.kd_bidang AND
						ta_belanja_rinc.kd_unit = ta_kegiatan.kd_unit AND
						ta_belanja_rinc.kd_sub = ta_kegiatan.kd_sub AND
						ta_belanja_rinc.kd_prog = ta_kegiatan.kd_prog AND
						ta_belanja_rinc.id_prog = ta_kegiatan.id_prog AND
						ta_belanja_rinc.kd_keg = ta_kegiatan.kd_keg
					INNER JOIN
					dbo.ta_program
					ON 
						ta_kegiatan.id_prog = ta_program.id_prog AND
						ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
						ta_kegiatan.kd_prog = ta_program.kd_prog AND
						ta_kegiatan.kd_sub = ta_program.kd_sub AND
						ta_kegiatan.kd_unit = ta_program.kd_unit AND
						ta_kegiatan.kd_urusan = ta_program.kd_urusan
				GROUP BY
					ta_program.kd_sub
			) AS anggaran ON anggaran.kd_sub = ref_sub_unit.kd_sub
			LEFT JOIN (
				SELECT
					ta_program.kd_sub,
					Sum(ta_rencana.jan) AS jan,
					Sum(ta_rencana.feb) AS feb,
					Sum(ta_rencana.mar) AS mar,
					Sum(ta_rencana.apr) AS apr,
					Sum(ta_rencana.mei) AS mei,
					Sum(ta_rencana.jun) AS jun,
					Sum(ta_rencana.jul) AS jul,
					Sum(ta_rencana.agt) AS agt,
					Sum(ta_rencana.sep) AS sep,
					Sum(ta_rencana.okt) AS okt,
					Sum(ta_rencana.nop) AS nop,
					Sum(ta_rencana.des) AS des
				FROM
					dbo.ta_belanja
					INNER JOIN
					dbo.ta_kegiatan
					ON 
						ta_belanja.id_prog = ta_kegiatan.id_prog AND
						ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
						ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
						ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
						ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
						ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
						ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
					INNER JOIN
					dbo.ta_rencana
					ON 
						ta_rencana.id_prog = ta_kegiatan.id_prog AND
						ta_kegiatan.kd_bidang = ta_rencana.kd_bidang AND
						ta_kegiatan.kd_keg = ta_rencana.kd_keg AND
						ta_kegiatan.kd_prog = ta_rencana.kd_prog AND
						ta_kegiatan.kd_sub = ta_rencana.kd_sub AND
						ta_kegiatan.kd_unit = ta_rencana.kd_unit AND
						ta_kegiatan.kd_urusan = ta_rencana.kd_urusan
					INNER JOIN
					dbo.ta_program
					ON 
						ta_kegiatan.id_prog = ta_program.id_prog AND
						ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
						ta_kegiatan.kd_prog = ta_program.kd_prog AND
						ta_kegiatan.kd_sub = ta_program.kd_sub AND
						ta_kegiatan.kd_unit = ta_program.kd_unit AND
						ta_kegiatan.kd_urusan = ta_program.kd_urusan
				GROUP BY
					ta_program.kd_sub
			) AS rencana ON rencana.kd_sub = ref_sub_unit.kd_sub
			ORDER BY
				ref_sub_unit.kd_urusan ASC,
				ref_sub_unit.kd_bidang ASC,
				ref_sub_unit.kd_unit ASC,
				ref_sub_unit.kd_sub ASC
		')
			->result();
		$output										= array
		(
			//'header'								=> $header_query,
			'data'									=> $data
		);
		//print_r($output);exit;
		return $output;
	}

}
