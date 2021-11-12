<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > RKA
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Rka extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query RKA
	 */
	public function rka_skpd($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit,
				ta_sub_unit.nm_pimpinan AS nama_pejabat,
				ta_sub_unit.jbt_pimpinan AS nama_jabatan,
				ta_sub_unit.nip_pimpinan AS nip_pejabat
			FROM
				ref_sub_unit
				INNER JOIN ta_sub_unit ON ta_sub_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ta_sub_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ta_sub_unit.kd_unit = ref_sub_unit.kd_unit
					AND ta_sub_unit.kd_sub = ref_sub_unit.kd_sub
				INNER JOIN ref_unit ON ref_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ref_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ref_unit.kd_unit = ref_sub_unit.kd_unit
				INNER JOIN ref_bidang ON ref_bidang.kd_urusan = ta_sub_unit.kd_urusan
					AND ref_bidang.kd_bidang = ta_sub_unit.kd_bidang
				INNER JOIN ref_urusan ON ref_bidang.kd_urusan = ref_urusan.kd_urusan
			WHERE
				ref_sub_unit.kd_urusan = ' . $params['kd_urusan'] . '
				AND ref_sub_unit.kd_bidang = ' . $params['kd_bidang'] . '
				AND ref_sub_unit.kd_unit = ' . $params['kd_unit'] . '
				AND ref_sub_unit.kd_sub = ' . $params['kd_sub'] . '
		')
			->row();
		$pendapatan_query							= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
               	Sum(ta_pendapatan_rinc.total) AS subtotal_rek_3,
                rek_2.subtotal_rek_2,
				rek_1.subtotal_rek_1
			FROM
				ta_pendapatan_rinc
			INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
			INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
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
					ref_rek_3.kd_rek_2,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_2
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				INNER JOIN ref_rek_3 ON 
					ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
					ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
					ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
				WHERE
					ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_3.kd_rek_2
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2
			LEFT JOIN (
				SELECT
					ref_rek_2.kd_rek_1,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_1
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
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
				WHERE
				ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_2.kd_rek_1
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1
			WHERE
				ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
				AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
			GROUP BY
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC
		')
			->result();
		$belanja_query								= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
                Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_3,
				rek_2.subtotal_rek_2,
				rek_1.subtotal_rek_1
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
				ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
				ta_belanja_rinc.tahun = ta_belanja.tahun
			INNER JOIN ta_kegiatan ON 
				ta_belanja.id_prog = ta_kegiatan.id_prog AND
				ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
				ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
				ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
				ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
				ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
				ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
				ta_belanja.tahun = ta_kegiatan.tahun
			INNER JOIN ta_program ON 
				ta_kegiatan.id_prog = ta_program.id_prog AND
				ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
				ta_kegiatan.kd_prog = ta_program.kd_prog AND
				ta_kegiatan.kd_sub = ta_program.kd_sub AND
				ta_kegiatan.kd_unit = ta_program.kd_unit AND
				ta_kegiatan.kd_urusan = ta_program.kd_urusan AND
				ta_kegiatan.tahun = ta_program.tahun
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
					ref_rek_3.kd_rek_2,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_2
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
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
					ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
					ta_belanja.tahun = ta_kegiatan.tahun
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan AND
					ta_kegiatan.tahun = ta_program.tahun
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
				WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_3.kd_rek_2
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2
			LEFT JOIN (
				SELECT
					ref_rek_2.kd_rek_1,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_1
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
						ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
						ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
						ta_belanja.id_prog = ta_kegiatan.id_prog AND
						ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
						ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
						ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
						ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
						ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
						ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
						ta_belanja.tahun = ta_kegiatan.tahun
				INNER JOIN ta_program ON 
						ta_kegiatan.id_prog = ta_program.id_prog AND
						ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
						ta_kegiatan.kd_prog = ta_program.kd_prog AND
						ta_kegiatan.kd_sub = ta_program.kd_sub AND
						ta_kegiatan.kd_unit = ta_program.kd_unit AND
						ta_kegiatan.kd_urusan = ta_program.kd_urusan AND
						ta_kegiatan.tahun = ta_program.tahun
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
				WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_2.kd_rek_1
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1
			WHERE
				ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
				AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
			GROUP BY
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC
		')
			->result();
		$pembiayaan_query							= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				Sum(ta_pembiayaan_rinc.total) AS subtotal_rek_3,
				rek_2.subtotal_rek_2,
				rek_1.subtotal_rek_1
			FROM
				ta_pembiayaan_rinc
			INNER JOIN ta_pembiayaan ON 
					ta_pembiayaan_rinc.id_prog = ta_pembiayaan.id_prog AND
					ta_pembiayaan_rinc.kd_bidang = ta_pembiayaan.kd_bidang AND
					ta_pembiayaan_rinc.kd_keg = ta_pembiayaan.kd_keg AND
					ta_pembiayaan_rinc.kd_prog = ta_pembiayaan.kd_prog AND
					ta_pembiayaan_rinc.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND
					ta_pembiayaan_rinc.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND
					ta_pembiayaan_rinc.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND
					ta_pembiayaan_rinc.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND
					ta_pembiayaan_rinc.kd_rek_5 = ta_pembiayaan.kd_rek_5 AND
					ta_pembiayaan_rinc.kd_sub = ta_pembiayaan.kd_sub AND
					ta_pembiayaan_rinc.kd_unit = ta_pembiayaan.kd_unit AND
					ta_pembiayaan_rinc.kd_urusan = ta_pembiayaan.kd_urusan AND
					ta_pembiayaan_rinc.tahun = ta_pembiayaan.tahun
			INNER JOIN ref_rek_5 ON 
					ta_pembiayaan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pembiayaan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pembiayaan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pembiayaan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pembiayaan.kd_rek_5 = ref_rek_5.kd_rek_5
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
					ref_rek_3.kd_rek_2,
					Sum(ta_pembiayaan_rinc.total) AS subtotal_rek_2
				FROM
					ta_pembiayaan_rinc
				INNER JOIN ta_pembiayaan ON 
					ta_pembiayaan_rinc.id_prog = ta_pembiayaan.id_prog AND
					ta_pembiayaan_rinc.kd_bidang = ta_pembiayaan.kd_bidang AND
					ta_pembiayaan_rinc.kd_keg = ta_pembiayaan.kd_keg AND
					ta_pembiayaan_rinc.kd_prog = ta_pembiayaan.kd_prog AND
					ta_pembiayaan_rinc.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND
					ta_pembiayaan_rinc.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND
					ta_pembiayaan_rinc.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND
					ta_pembiayaan_rinc.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND
					ta_pembiayaan_rinc.kd_rek_5 = ta_pembiayaan.kd_rek_5 AND
					ta_pembiayaan_rinc.kd_sub = ta_pembiayaan.kd_sub AND
					ta_pembiayaan_rinc.kd_unit = ta_pembiayaan.kd_unit AND
					ta_pembiayaan_rinc.kd_urusan = ta_pembiayaan.kd_urusan AND
					ta_pembiayaan_rinc.tahun = ta_pembiayaan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pembiayaan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pembiayaan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pembiayaan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pembiayaan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pembiayaan.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				INNER JOIN ref_rek_3 ON 
					ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
					ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
					ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
				WHERE
					ta_pembiayaan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pembiayaan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pembiayaan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pembiayaan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_3.kd_rek_2
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2
			LEFT JOIN (
				SELECT
					ref_rek_2.kd_rek_1,
					Sum(ta_pembiayaan_rinc.total) AS subtotal_rek_1
				FROM
				ta_pembiayaan_rinc
				INNER JOIN ta_pembiayaan ON 
						ta_pembiayaan_rinc.id_prog = ta_pembiayaan.id_prog AND
						ta_pembiayaan_rinc.kd_bidang = ta_pembiayaan.kd_bidang AND
						ta_pembiayaan_rinc.kd_keg = ta_pembiayaan.kd_keg AND
						ta_pembiayaan_rinc.kd_prog = ta_pembiayaan.kd_prog AND
						ta_pembiayaan_rinc.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND
						ta_pembiayaan_rinc.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND
						ta_pembiayaan_rinc.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND
						ta_pembiayaan_rinc.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND
						ta_pembiayaan_rinc.kd_rek_5 = ta_pembiayaan.kd_rek_5 AND
						ta_pembiayaan_rinc.kd_sub = ta_pembiayaan.kd_sub AND
						ta_pembiayaan_rinc.kd_unit = ta_pembiayaan.kd_unit AND
						ta_pembiayaan_rinc.kd_urusan = ta_pembiayaan.kd_urusan AND
						ta_pembiayaan_rinc.tahun = ta_pembiayaan.tahun
				INNER JOIN ref_rek_5 ON 
						ta_pembiayaan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
						ta_pembiayaan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
						ta_pembiayaan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
						ta_pembiayaan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
						ta_pembiayaan.kd_rek_5 = ref_rek_5.kd_rek_5
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
				WHERE
					ta_pembiayaan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pembiayaan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pembiayaan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pembiayaan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_2.kd_rek_1
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1
			WHERE
				ta_pembiayaan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_pembiayaan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_pembiayaan_rinc.kd_unit = ' . $params['kd_unit'] . '
				AND ta_pembiayaan_rinc.kd_sub = ' . $params['kd_sub'] . '
			GROUP BY
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC
		')
			->result();
		$tim_anggaran_query							= $this->query
		('
			SELECT
				ta_tim_anggaran.nama AS nama_tim,
				ta_tim_anggaran.nip AS nip_tim,
				ta_tim_anggaran.jabatan AS jabatan_tim,
				ta_tim_anggaran.no_urut AS kode,
			    0 AS id
			FROM
				ta_tim_anggaran
			WHERE
				ta_tim_anggaran.tahun = ' . $params['tahun'] . '
			AND ta_tim_anggaran.kd_tim = 1
			ORDER BY
				ta_tim_anggaran.no_urut
		')
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'pendapatan'							=> $pendapatan_query,
			'belanja'								=> $belanja_query,
			'pembiayaan'							=> $pembiayaan_query,
			'tim_anggaran'							=> $tim_anggaran_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function rka_pendapatan_skpd($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit,
				ta_sub_unit.nm_pimpinan AS nama_pejabat,
				ta_sub_unit.jbt_pimpinan AS nama_jabatan,
				ta_sub_unit.nip_pimpinan AS nip_pejabat
			FROM
				ref_sub_unit
				INNER JOIN ta_sub_unit ON ta_sub_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ta_sub_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ta_sub_unit.kd_unit = ref_sub_unit.kd_unit
					AND ta_sub_unit.kd_sub = ref_sub_unit.kd_sub
				INNER JOIN ref_unit ON ref_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ref_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ref_unit.kd_unit = ref_sub_unit.kd_unit
				INNER JOIN ref_bidang ON ref_bidang.kd_urusan = ta_sub_unit.kd_urusan
					AND ref_bidang.kd_bidang = ta_sub_unit.kd_bidang
				INNER JOIN ref_urusan ON ref_bidang.kd_urusan = ref_urusan.kd_urusan
			WHERE
				ref_sub_unit.kd_urusan = ' . $params['kd_urusan'] . '
				AND ref_sub_unit.kd_bidang = ' . $params['kd_bidang'] . '
				AND ref_sub_unit.kd_unit = ' . $params['kd_unit'] . '
				AND ref_sub_unit.kd_sub = ' . $params['kd_sub'] . '
		')
			->row();
		$data_query									= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_4.kd_rek_4 AS id_rek_4,
				ref_rek_5.kd_rek_5 AS id_rek_5,
				ta_pendapatan_rinc.no_id AS id_pendapatan_rinci,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_4.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				ref_rek_4.nm_rek_4,
				ref_rek_5.nm_rek_5,
                ta_pendapatan_rinc.no_id AS kd_anggaran_pendapatan_rinci,
				ta_pendapatan_rinc.keterangan AS nama_rincian,
                ta_pendapatan_rinc.sat_1 AS vol_1,
				ta_pendapatan_rinc.sat_1 AS vol_2,
				ta_pendapatan_rinc.sat_1 AS vol_3,
				ta_pendapatan_rinc.nilai_1 AS satuan_1,
				ta_pendapatan_rinc.nilai_1 AS satuan_2,
				ta_pendapatan_rinc.nilai_1 AS satuan_3,
                ta_pendapatan_rinc.nilai_rp AS nilai,
				ta_pendapatan_rinc.jml_satuan AS vol_123,
				ta_pendapatan_rinc.satuan123 AS satuan_123,
                ta_pendapatan_rinc.total,
                rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2,
				rek_3.subtotal_rek_3,
				rek_4.subtotal_rek_4,
				rek_5.subtotal_rek_5
			FROM
				ta_pendapatan_rinc
			INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan
			INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
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
					ta_pendapatan_rinc.kd_rek_5,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_5
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				WHERE
					ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ta_pendapatan_rinc.kd_rek_5
			) AS rek_5 ON rek_5.kd_rek_5 = ref_rek_5.kd_rek_5
			LEFT JOIN (
				SELECT
					ref_rek_5.kd_rek_4,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_4
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
				WHERE
					ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_5.kd_rek_4
			) AS rek_4 ON rek_4.kd_rek_4 = ref_rek_4.kd_rek_4
            LEFT JOIN (
				SELECT
					ref_rek_4.kd_rek_3,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_3
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				WHERE
					ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_4.kd_rek_3
			) AS rek_3 ON rek_3.kd_rek_3 = ref_rek_3.kd_rek_3
			LEFT JOIN (
				SELECT
					ref_rek_3.kd_rek_2,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_2
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				INNER JOIN ref_rek_3 ON 
					ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
					ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
					ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
				WHERE
					ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_3.kd_rek_2
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2
			LEFT JOIN (
				SELECT
					ref_rek_2.kd_rek_1,
					Sum(ta_pendapatan_rinc.total) AS subtotal_rek_1
				FROM
					ta_pendapatan_rinc
				INNER JOIN ta_pendapatan ON 
					ta_pendapatan_rinc.id_prog = ta_pendapatan.id_prog AND
					ta_pendapatan_rinc.kd_bidang = ta_pendapatan.kd_bidang AND
					ta_pendapatan_rinc.kd_keg = ta_pendapatan.kd_keg AND
					ta_pendapatan_rinc.kd_prog = ta_pendapatan.kd_prog AND
					ta_pendapatan_rinc.kd_rek_1 = ta_pendapatan.kd_rek_1 AND
					ta_pendapatan_rinc.kd_rek_2 = ta_pendapatan.kd_rek_2 AND
					ta_pendapatan_rinc.kd_rek_3 = ta_pendapatan.kd_rek_3 AND
					ta_pendapatan_rinc.kd_rek_4 = ta_pendapatan.kd_rek_4 AND
					ta_pendapatan_rinc.kd_rek_5 = ta_pendapatan.kd_rek_5 AND
					ta_pendapatan_rinc.kd_sub = ta_pendapatan.kd_sub AND
					ta_pendapatan_rinc.kd_unit = ta_pendapatan.kd_unit AND
					ta_pendapatan_rinc.kd_urusan = ta_pendapatan.kd_urusan AND
					ta_pendapatan_rinc.tahun = ta_pendapatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pendapatan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pendapatan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pendapatan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pendapatan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pendapatan.kd_rek_5 = ref_rek_5.kd_rek_5
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
				WHERE
				ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_2.kd_rek_1
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1
			WHERE
				ta_pendapatan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_pendapatan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_pendapatan_rinc.kd_unit = ' . $params['kd_unit'] . '
				AND ta_pendapatan_rinc.kd_sub = ' . $params['kd_sub'] . '
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC,
				ref_rek_4.kd_rek_4 ASC,
				ref_rek_5.kd_rek_5 ASC
		')
			->result();
		$tim_anggaran_query							= $this->query
		('
			SELECT
				ta_tim_anggaran.nama AS nama_tim,
				ta_tim_anggaran.nip AS nip_tim,
				ta_tim_anggaran.jabatan AS jabatan_tim,
				ta_tim_anggaran.no_urut AS kode,
			    0 AS id
			FROM
				ta_tim_anggaran
			WHERE
				ta_tim_anggaran.tahun = ' . $params['tahun'] . '
			AND ta_tim_anggaran.kd_tim = 1
			ORDER BY
				ta_tim_anggaran.no_urut
		')
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'data'									=> $data_query,
			'tim_anggaran'							=> $tim_anggaran_query,
			'tanggal'								=> $params['tahun']
		);
		//print_r($output);exit;
		return $output;
	}

	public function rka_belanja_skpd($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit,
				ta_sub_unit.nm_pimpinan AS nama_pejabat,
				ta_sub_unit.jbt_pimpinan AS nama_jabatan,
				ta_sub_unit.nip_pimpinan AS nip_pejabat
			FROM
				ref_sub_unit
				INNER JOIN ta_sub_unit ON ta_sub_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ta_sub_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ta_sub_unit.kd_unit = ref_sub_unit.kd_unit
					AND ta_sub_unit.kd_sub = ref_sub_unit.kd_sub
				INNER JOIN ref_unit ON ref_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ref_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ref_unit.kd_unit = ref_sub_unit.kd_unit
				INNER JOIN ref_bidang ON ref_bidang.kd_urusan = ta_sub_unit.kd_urusan
					AND ref_bidang.kd_bidang = ta_sub_unit.kd_bidang
				INNER JOIN ref_urusan ON ref_bidang.kd_urusan = ref_urusan.kd_urusan
			WHERE
				ref_sub_unit.kd_urusan = ' . $params['kd_urusan'] . '
				AND ref_sub_unit.kd_bidang = ' . $params['kd_bidang'] . '
				AND ref_sub_unit.kd_unit = ' . $params['kd_unit'] . '
				AND ref_sub_unit.kd_sub = ' . $params['kd_sub'] . '
		')
			->row();
		$data_query									= $this->query
		('
			SELECT
				ref_urusan.kd_urusan AS id_urusan,
				ref_bidang.kd_bidang AS id_bidang,
				ref_program.kd_prog AS id_program,
				ta_kegiatan.kd_keg AS id_kegiatan,

                ref_urusan.kd_urusan,
				ref_bidang.kd_bidang,
				ref_program.kd_prog,
				ta_kegiatan.kd_keg,

				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_program.ket_program,
				ta_kegiatan.ket_kegiatan,

				ref_sumber_dana.kd_sumber AS kode,
				ref_sumber_dana.nm_sumber AS nama_sumber_dana,

				NULL AS kecamatan,
				NULL AS kelurahan,
				NULL AS map_address,
				NULL AS alamat_detail,

				anggaran_urusan.belanja_operasi_urusan,
				anggaran_urusan.belanja_modal_urusan,
				anggaran_urusan.belanja_tidak_terduga_urusan,
				anggaran_urusan.belanja_transfer_urusan,
				pagu_1_urusan.pagu_1_urusan,

				anggaran_bidang.belanja_operasi_bidang,
				anggaran_bidang.belanja_modal_bidang,
				anggaran_bidang.belanja_tidak_terduga_bidang,
				anggaran_bidang.belanja_transfer_bidang,
				pagu_1_bidang.pagu_1_bidang,

				anggaran_program.belanja_operasi_program,
				anggaran_program.belanja_modal_program,
				anggaran_program.belanja_tidak_terduga_program,
				anggaran_program.belanja_transfer_program,
				pagu_1_program.pagu_1_program,

				anggaran_kegiatan.belanja_operasi_kegiatan,
				anggaran_kegiatan.belanja_modal_kegiatan,
				anggaran_kegiatan.belanja_tidak_terduga_kegiatan,
				anggaran_kegiatan.belanja_transfer_kegiatan,
				pagu_1_kegiatan.pagu_1_kegiatan
			FROM
				ta_kegiatan
			INNER JOIN
				ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
			INNER JOIN ref_program ON 
					ta_program.kd_urusan = ref_program.kd_urusan AND
					ta_program.kd_bidang = ref_program.kd_bidang AND
					ta_program.kd_unit = ref_program.kd_prog
			INNER JOIN ref_bidang ON 
					ref_program.kd_bidang = ref_bidang.kd_bidang AND
					ref_program.kd_urusan = ref_bidang.kd_urusan
			INNER JOIN ref_urusan ON 
					ref_bidang.kd_urusan = ref_urusan.kd_urusan
			INNER JOIN ref_sumber_dana ON 
					ta_kegiatan.kd_sumber = ref_sumber_dana.kd_sumber
			LEFT JOIN (
				SELECT
					ref_bidang.kd_urusan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 1 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_operasi_urusan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 2 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_modal_urusan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 3 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_tidak_terduga_urusan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 4 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_transfer_urusan
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
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
				INNER JOIN ref_program ON 
					ta_program.kd_urusan = ref_program.kd_urusan AND
					ta_program.kd_bidang = ref_program.kd_bidang AND
					ta_program.kd_unit = ref_program.kd_prog
				INNER JOIN ref_bidang ON 
					ref_program.kd_bidang = ref_bidang.kd_bidang AND
					ref_program.kd_urusan = ref_bidang.kd_urusan
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
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_bidang.kd_urusan
			) AS anggaran_urusan ON anggaran_urusan.kd_urusan = ref_urusan.kd_urusan
			LEFT JOIN (
				SELECT
					ref_program.kd_bidang,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 1 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_operasi_bidang,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 2 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_modal_bidang,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 3 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_tidak_terduga_bidang,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 4 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_transfer_bidang
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
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
				INNER JOIN ref_program ON 
					ta_program.kd_urusan = ref_program.kd_urusan AND
					ta_program.kd_bidang = ref_program.kd_bidang AND
					ta_program.kd_unit = ref_program.kd_prog
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
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_program.kd_bidang
			) AS anggaran_bidang ON anggaran_bidang.kd_bidang = ref_bidang.kd_bidang
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_prog,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 1 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_operasi_program,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 2 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_modal_program,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 3 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_tidak_terduga_program,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 4 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_transfer_program
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
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
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
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ta_kegiatan.kd_prog
			) AS anggaran_program ON anggaran_program.kd_prog = ta_program.kd_prog
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_keg,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 1 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_operasi_kegiatan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 2 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_modal_kegiatan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 3 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_tidak_terduga_kegiatan,
					SUM(CASE WHEN ref_rek_1.kd_rek_1 = 5 AND ref_rek_2.kd_rek_2 = 4 THEN ta_belanja_rinc_sub.total ELSE 0 END) AS belanja_transfer_kegiatan
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
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
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
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ta_kegiatan.kd_keg
			) AS anggaran_kegiatan ON anggaran_kegiatan.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_keg,
					Sum(ta_kegiatan.pagu_anggaran) AS pagu_1_kegiatan
				FROM
					ta_kegiatan
				INNER JOIN
					ta_program ON ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ta_kegiatan.kd_keg
			) AS pagu_1_kegiatan ON pagu_1_kegiatan.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_prog,
					Sum(ta_kegiatan.pagu_anggaran) AS pagu_1_program
				FROM
					ta_kegiatan
				INNER JOIN
					ta_program ON ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ta_kegiatan.kd_prog
			) AS pagu_1_program ON pagu_1_program.kd_prog = ta_program.kd_prog
			LEFT JOIN (
				SELECT
					ref_program.kd_bidang,
					Sum(ta_kegiatan.pagu_anggaran) AS pagu_1_bidang
				FROM
					dbo.ta_kegiatan
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
				INNER JOIN ref_program ON 
					ta_program.kd_urusan = ref_program.kd_urusan AND
					ta_program.kd_bidang = ref_program.kd_bidang AND
					ta_program.kd_prog = ref_program.kd_prog
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_program.kd_bidang
			) AS pagu_1_bidang ON pagu_1_bidang.kd_bidang = ref_bidang.kd_bidang
			LEFT JOIN (
				SELECT
					ref_bidang.kd_urusan,
					Sum(ta_kegiatan.pagu_anggaran) AS pagu_1_urusan
				FROM
					ta_kegiatan
				INNER JOIN ta_program ON 
					ta_kegiatan.id_prog = ta_program.id_prog AND
					ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
					ta_kegiatan.kd_prog = ta_program.kd_prog AND
					ta_kegiatan.kd_sub = ta_program.kd_sub AND
					ta_kegiatan.kd_unit = ta_program.kd_unit AND
					ta_kegiatan.kd_urusan = ta_program.kd_urusan
				INNER JOIN ref_program ON 
					ta_program.kd_urusan = ref_program.kd_urusan AND
					ta_program.kd_bidang = ref_program.kd_bidang AND
					ta_program.kd_prog = ref_program.kd_prog
				INNER JOIN ref_bidang ON 
					ref_program.kd_bidang = ref_bidang.kd_bidang AND
					ref_program.kd_urusan = ref_bidang.kd_urusan
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_bidang.kd_urusan
			) AS pagu_1_urusan ON pagu_1_urusan.kd_urusan = ref_urusan.kd_urusan
			WHERE
				ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
				AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
			ORDER BY
				ref_urusan.kd_urusan ASC,
				ref_bidang.kd_bidang ASC,
				ref_program.kd_prog ASC,
				ta_kegiatan.kd_keg ASC
		')
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'data'									=> $data_query
		);
		//print_r($output);exit;
		return $output;
	}

	public function rka_rincian_belanja($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ref_urusan.kd_urusan,
				ref_bidang.kd_bidang,
				ref_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ta_program.kd_prog AS kd_program,
				ta_kegiatan.kd_keg,

				ta_capaian_program.tolak_ukur,
				ta_capaian_program.target_angka AS target,
				ta_capaian_program.target_uraian AS satuan,

				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit AS nm_sub,
				ta_program.ket_program AS nm_program,
				ta_kegiatan.ket_kegiatan AS kegiatan,
				kegiatan_pagu.total_pagu_kegiatan,
				kegiatan_pagu_1.total_pagu_kegiatan_1
			FROM
				ta_kegiatan
			INNER JOIN ta_program ON 
				ta_kegiatan.id_prog = ta_program.id_prog AND
				ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
				ta_kegiatan.kd_prog = ta_program.kd_prog AND
				ta_kegiatan.kd_sub = ta_program.kd_sub AND
				ta_kegiatan.kd_unit = ta_program.kd_unit AND
				ta_kegiatan.kd_urusan = ta_program.kd_urusan
			INNER JOIN ta_capaian_program ON 
				ta_program.id_prog = ta_capaian_program.id_prog AND
				ta_program.kd_bidang = ta_capaian_program.kd_bidang AND
				ta_program.kd_prog = ta_capaian_program.kd_prog AND
				ta_program.kd_sub = ta_capaian_program.kd_sub AND
				ta_program.kd_unit = ta_capaian_program.kd_unit AND
				ta_program.kd_urusan = ta_capaian_program.kd_urusan
			INNER JOIN ref_sub_unit ON 
				ta_capaian_program.kd_urusan = ref_sub_unit.kd_urusan AND
				ta_capaian_program.kd_bidang = ref_sub_unit.kd_bidang AND
				ta_capaian_program.kd_unit = ref_sub_unit.kd_unit AND
				ta_capaian_program.kd_sub = ref_sub_unit.kd_sub
			INNER JOIN ref_unit ON 
				ref_sub_unit.kd_bidang = ref_unit.kd_bidang AND
				ref_sub_unit.kd_unit = ref_unit.kd_unit AND
				ref_sub_unit.kd_urusan = ref_unit.kd_urusan
			INNER JOIN ref_bidang  ON 
				ref_unit.kd_bidang = ref_bidang.kd_bidang AND
				ref_unit.kd_urusan = ref_bidang.kd_urusan
			INNER JOIN ref_urusan ON 
				ref_bidang.kd_urusan = ref_urusan.kd_urusan
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS total_pagu_kegiatan
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
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
					AND ta_kegiatan.kd_prog = ' . $params['kd_prog'] . '
					AND ta_kegiatan.id_prog = ' . $params['id_prog'] . '
					AND ta_kegiatan.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ta_kegiatan.kd_keg
			) AS kegiatan_pagu ON kegiatan_pagu.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_keg,
					Sum(ta_kegiatan.pagu_anggaran) AS total_pagu_kegiatan_1
				FROM
					ta_kegiatan
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
					AND ta_kegiatan.kd_prog = ' . $params['kd_prog'] . '
					AND ta_kegiatan.id_prog = ' . $params['id_prog'] . '
					AND ta_kegiatan.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ta_kegiatan.kd_keg
			) AS kegiatan_pagu_1 ON kegiatan_pagu_1.kd_keg = ta_kegiatan.kd_keg
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
		$indikator_kegiatan_query					= $this->query
		('
			SELECT
				ta_indikator.no_id AS jns_indikator,
				ta_indikator.kd_indikator,
				ta_indikator.tolak_ukur,
				ta_indikator.target_angka AS target,
				ta_indikator.target_uraian AS satuan
			FROM
				ta_indikator
			WHERE
                ta_indikator.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_indikator.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_indikator.kd_unit = ' . $params['kd_unit'] . '
				AND ta_indikator.kd_sub = ' . $params['kd_sub'] . '
				AND ta_indikator.kd_prog = ' . $params['kd_prog'] . '
				AND ta_indikator.id_prog = ' . $params['id_prog'] . '
				AND ta_indikator.kd_keg = ' . $params['kd_keg'] . '
			ORDER BY
				ta_indikator.no_id ASC,
				ta_indikator.kd_indikator ASC
		')
			->result();
		$belanja_query								= $this->query
		('
			SELECT
				ta_belanja.kd_keg AS id_keg_sub,
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_4.kd_rek_4 AS id_rek_4,
				ref_rek_5.kd_rek_5 AS id_rek_5,
				ta_belanja_rinc.no_rinc AS id_belanja_sub,
				ta_belanja_rinc_sub.no_id AS id_belanja_rinci,

                ta_kegiatan.kd_keg AS kd_keg_sub,
                ta_kegiatan.ket_kegiatan AS kegiatan_sub,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_4.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ta_belanja_rinc.no_rinc AS kd_belanja_sub,
				ta_belanja_rinc_sub.no_id AS kd_belanja_rinci,

                ta_kegiatan.kd_keg AS kegiatan_sub,
				ta_kegiatan.lokasi AS kecamatan,
				ta_kegiatan.lokasi AS kelurahan,
				ta_kegiatan.lokasi AS alamat_detail,
				ta_kegiatan.waktu_pelaksanaan AS waktu_pelaksanaan_mulai,
				ta_kegiatan.waktu_pelaksanaan AS waktu_pelaksanaan_sampai,
				ref_sumber_dana.nm_sumber AS nama_sumber_dana,

				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				ref_rek_4.nm_rek_4,
				ref_rek_5.nm_rek_5,

				ta_belanja_rinc.keterangan AS nama_sub_rincian,
				ta_belanja_rinc_sub.keterangan AS nama_rincian,
                ta_belanja_rinc_sub.sat_1 AS vol_1,
				ta_belanja_rinc_sub.sat_2 AS vol_2,
				ta_belanja_rinc_sub.sat_3 AS vol_3,
				ta_belanja_rinc_sub.nilai_1 AS satuan_1,
				ta_belanja_rinc_sub.nilai_2 AS satuan_2,
				ta_belanja_rinc_sub.nilai_3 AS satuan_3,
                ta_belanja_rinc_sub.nilai_rp AS nilai,
				ta_belanja_rinc_sub.jml_satuan AS vol_123,
				ta_belanja_rinc_sub.satuan123 AS satuan_123,
                ta_belanja_rinc_sub.total,

                rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2,
				rek_3.subtotal_rek_3,
				rek_4.subtotal_rek_4,
				rek_5.subtotal_rek_5,
				belanja_sub.subtotal_rinci
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
			INNER JOIN ta_kegiatan ON 
				ta_belanja.id_prog = ta_kegiatan.id_prog AND
				ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
				ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
				ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
				ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
				ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
				ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
			INNER JOIN ref_sumber_dana ON 
				ta_belanja.kd_sumber = ref_sumber_dana.kd_sumber
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
					ref_rek_2.kd_rek_1,
					ta_belanja.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_1
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
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc AND
					ta_belanja_rinc_sub.tahun = ta_belanja_rinc.tahun
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
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
					ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
					ta_belanja.tahun = ta_kegiatan.tahun
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
				WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_2.kd_rek_1,
					ta_belanja.kd_keg
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1 AND rek_1.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ref_rek_3.kd_rek_2,
					ta_belanja.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_2
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
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc AND
					ta_belanja_rinc_sub.tahun = ta_belanja_rinc.tahun
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
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
					ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
					ta_belanja.tahun = ta_kegiatan.tahun
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
				WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_3.kd_rek_2,
					ta_belanja.kd_keg
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2 AND rek_2.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ref_rek_4.kd_rek_3,
					ta_belanja.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_3
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
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc AND
					ta_belanja_rinc_sub.tahun = ta_belanja_rinc.tahun
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
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
					ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
					ta_belanja.tahun = ta_kegiatan.tahun
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
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_4.kd_rek_3,
					ta_belanja.kd_keg
			) AS rek_3 ON rek_3.kd_rek_3 = ref_rek_3.kd_rek_3 AND rek_3.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ref_rek_5.kd_rek_4,
					ta_belanja.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_4
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
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc AND
					ta_belanja_rinc_sub.tahun = ta_belanja_rinc.tahun
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
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
					ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
					ta_belanja.tahun = ta_kegiatan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_belanja.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_belanja.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_belanja.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_belanja.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_belanja.kd_rek_5 = ref_rek_5.kd_rek_5
				WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_5.kd_rek_4,
					ta_belanja.kd_keg
			) AS rek_4 ON rek_4.kd_rek_4 = ref_rek_4.kd_rek_4 AND rek_4.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
		            ta_belanja_rinc_sub.no_rinc,
		            ta_belanja_rinc.kd_keg,
		            Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_5
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
                        ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc AND
                        ta_belanja_rinc_sub.tahun = ta_belanja_rinc.tahun
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
                        ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
                        ta_belanja_rinc.tahun = ta_belanja.tahun
                INNER JOIN ta_kegiatan ON
                        ta_belanja.id_prog = ta_kegiatan.id_prog AND
                        ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
                        ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
                        ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
                        ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
                        ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
                        ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
                        ta_belanja.tahun = ta_kegiatan.tahun
		        WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
		        GROUP BY
		            ta_belanja_rinc_sub.no_rinc,
		            ta_belanja_rinc.kd_keg
			) AS rek_5 ON rek_5.no_rinc = ta_belanja_rinc.no_rinc AND rek_5.kd_keg = ta_kegiatan.kd_keg
			LEFT JOIN (
				SELECT
					ta_belanja_rinc_sub.no_rinc,
					ta_belanja_rinc.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rinci
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
					ta_belanja_rinc_sub.no_rinc = ta_belanja_rinc.no_rinc AND
					ta_belanja_rinc_sub.tahun = ta_belanja_rinc.tahun
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
					ta_belanja_rinc.kd_urusan = ta_belanja.kd_urusan AND
					ta_belanja_rinc.tahun = ta_belanja.tahun
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan AND
					ta_belanja.tahun = ta_kegiatan.tahun
				WHERE
					ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ta_belanja_rinc_sub.no_rinc,
					ta_belanja_rinc.kd_keg
			) AS belanja_sub ON belanja_sub.no_rinc = ta_belanja_rinc.no_rinc AND belanja_sub.kd_keg = ta_kegiatan.kd_keg
			WHERE
				ta_belanja_rinc_sub.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_belanja_rinc_sub.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_belanja_rinc_sub.kd_unit = ' . $params['kd_unit'] . '
				AND ta_belanja_rinc_sub.kd_sub = ' . $params['kd_sub'] . '
				AND ta_belanja_rinc_sub.kd_prog = ' . $params['kd_prog'] . '
				AND ta_belanja_rinc_sub.id_prog = ' . $params['id_prog'] . '
				AND ta_belanja_rinc_sub.kd_keg = ' . $params['kd_keg'] . '
		')
			->result();
		$tim_anggaran_query							= $this->query
		('
			SELECT
				ta_tim_anggaran.nama AS nama_tim,
				ta_tim_anggaran.nip AS nip_tim,
				ta_tim_anggaran.jabatan AS jabatan_tim,
				ta_tim_anggaran.no_urut AS kode,
			    0 AS id
			FROM
				ta_tim_anggaran
			WHERE
				ta_tim_anggaran.tahun = ' . $params['tahun'] . '
			AND ta_tim_anggaran.kd_tim = 1
			ORDER BY
				ta_tim_anggaran.no_urut
		')
			->result();
/*		$tanggal_query								= $this->query
		('
			SELECT
				ref__tanggal.tanggal_rka
			FROM
				ref__tanggal
			WHERE
				ref__tanggal.tahun = ' . $tahun . '
			LIMIT 1
		')
			->row();*/
/*		$approval									= $this->model->query
		('
			SELECT
				ta__asistensi_setuju.perencanaan,
				ta__asistensi_setuju.waktu_verifikasi_perencanaan,
				ta__asistensi_setuju.nama_operator_perencanaan,
				ta__asistensi_setuju.keuangan,
				ta__asistensi_setuju.waktu_verifikasi_keuangan,
				ta__asistensi_setuju.nama_operator_keuangan,
				ta__asistensi_setuju.setda,
				ta__asistensi_setuju.waktu_verifikasi_setda,
				ta__asistensi_setuju.nama_operator_setda,
				ta__asistensi_setuju.ttd_1,
				ta__asistensi_setuju.ttd_2,
				ta__asistensi_setuju.ttd_3
			FROM
				ta__asistensi_setuju
			INNER JOIN ta__kegiatan_sub ON ta__asistensi_setuju.id_keg_sub = ta__kegiatan_sub.id
			WHERE
				ta__kegiatan_sub.id_keg = ' . $kegiatan . '
		')
			->result();*/
		$output										= array
		(
			'header'								=> $header_query,
			'indikator'								=> $indikator_kegiatan_query,
			'belanja'								=> $belanja_query,
			'tim_anggaran'							=> $tim_anggaran_query,
			'tanggal'								=> $params['tahun'],
			'approval'								=> null
		);
		//print_r($output);exit;
		return $output;
	}

	public function rka_sub_kegiatan($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ref_urusan.kd_urusan,
				ref_bidang.kd_bidang,
				ref_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ta_program.kd_prog AS kd_program,
                ta_kegiatan.kd_keg,

				ta_capaian_program.tolak_ukur,
				ta_capaian_program.target_angka AS target,
				ta_capaian_program.target_uraian AS satuan,

				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit AS nm_sub,
				ta_program.ket_program AS nm_program,

				ta_kegiatan.ket_kegiatan AS kegiatan,
				ta_kegiatan.kd_keg AS kd_keg_sub,
				0 kegiatan_sub,
				ta_kegiatan.pagu_anggaran AS pagu,
				0 AS pagu_1,
				ta_kegiatan.waktu_pelaksanaan AS waktu_pelaksanaan_mulai,
				ta_kegiatan.waktu_pelaksanaan AS waktu_pelaksanaan_sampai,
				ta_kegiatan.kelompok_sasaran,
				0 AS map_address,
				0 AS alamat_detail,
				0 AS kelurahan,
				0 AS kecamatan,
				0 AS id_jenis_anggaran,
				0 AS pilihan,
				sub_kegiatan_pagu.total_anggaran_sub_kegiatan,
				0 as nm_model
			FROM
				ta_kegiatan
			INNER JOIN ta_program ON 
				ta_kegiatan.id_prog = ta_program.id_prog AND
				ta_kegiatan.kd_bidang = ta_program.kd_bidang AND
				ta_kegiatan.kd_prog = ta_program.kd_prog AND
				ta_kegiatan.kd_sub = ta_program.kd_sub AND
				ta_kegiatan.kd_unit = ta_program.kd_unit AND
				ta_kegiatan.kd_urusan = ta_program.kd_urusan
			INNER JOIN ta_capaian_program ON 
				ta_program.id_prog = ta_capaian_program.id_prog AND
				ta_program.kd_bidang = ta_capaian_program.kd_bidang AND
				ta_program.kd_prog = ta_capaian_program.kd_prog AND
				ta_program.kd_sub = ta_capaian_program.kd_sub AND
				ta_program.kd_unit = ta_capaian_program.kd_unit AND
				ta_program.kd_urusan = ta_capaian_program.kd_urusan
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
			LEFT JOIN (
				SELECT
					ta_kegiatan.kd_keg,
					Sum(ta_belanja_rinc_sub.total) AS total_anggaran_sub_kegiatan
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
				INNER JOIN ta_kegiatan ON 
					ta_belanja.id_prog = ta_kegiatan.id_prog AND
					ta_belanja.kd_bidang = ta_kegiatan.kd_bidang AND
					ta_belanja.kd_keg = ta_kegiatan.kd_keg AND
					ta_belanja.kd_prog = ta_kegiatan.kd_prog AND
					ta_belanja.kd_sub = ta_kegiatan.kd_sub AND
					ta_belanja.kd_unit = ta_kegiatan.kd_unit AND
					ta_belanja.kd_urusan = ta_kegiatan.kd_urusan
				WHERE
					ta_kegiatan.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_kegiatan.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_kegiatan.kd_unit = ' . $params['kd_unit'] . '
					AND ta_kegiatan.kd_sub = ' . $params['kd_sub'] . '
					AND ta_kegiatan.kd_prog = ' . $params['kd_prog'] . '
					AND ta_kegiatan.id_prog = ' . $params['id_prog'] . '
					AND ta_kegiatan.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ta_kegiatan.kd_keg
			) AS sub_kegiatan_pagu ON sub_kegiatan_pagu.kd_keg = ta_kegiatan.kd_keg
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
		$sumber_dana_query							= $this->query
		('
			SELECT DISTINCT
				ref_sumber_dana.nm_sumber AS nama_sumber_dana
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
			INNER JOIN ref_sumber_dana ON 
				ta_belanja.kd_sumber = ref_sumber_dana.kd_sumber
			WHERE
				ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
				AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
				AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
				AND ta_belanja.id_prog = ' . $params['id_prog'] . '
				AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
		')
			->result();
		$indikator_kegiatan_query					= $this->query
		('
			SELECT
				ta_indikator.no_id AS jns_indikator,
				ta_indikator.kd_indikator,
				ta_indikator.tolak_ukur,
				ta_indikator.target_angka AS target,
				ta_indikator.target_uraian AS satuan
			FROM
				ta_indikator
			WHERE
				ta_indikator.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_indikator.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_indikator.kd_unit = ' . $params['kd_unit'] . '
				AND ta_indikator.kd_sub = ' . $params['kd_sub'] . '
				AND ta_indikator.kd_prog = ' . $params['kd_prog'] . '
				AND ta_indikator.id_prog = ' . $params['id_prog'] . '
				AND ta_indikator.kd_keg = ' . $params['kd_keg'] . '
			ORDER BY
				ta_indikator.no_id ASC,
				ta_indikator.kd_indikator ASC
		')
			->result();
/*		$indikator_sub_kegiatan_query						= $this->query
		('
			SELECT
				ta__indikator_sub.jns_indikator,
				ta__indikator_sub.kd_indikator,
				ta__indikator_sub.tolak_ukur,
				ta__indikator_sub.target,
				ta__indikator_sub.satuan
			FROM
				ta__indikator_sub
			WHERE
				ta__indikator_sub.id_keg_sub = ' . $sub_kegiatan . '
			ORDER BY
				ta__indikator_sub.jns_indikator ASC,
				ta__indikator_sub.kd_indikator ASC
		')
			->result();*/
		$belanja_query								= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_4.kd_rek_4 AS id_rek_4,
				ref_rek_5.kd_rek_5 AS id_rek_5,
				ta_belanja_rinc.no_rinc AS id_belanja_sub,
				ta_belanja_rinc_sub.no_id AS id_belanja_rinci,

				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_4.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ta_belanja_rinc.no_rinc AS kd_belanja_sub,
				ta_belanja_rinc_sub.no_id AS kd_belanja_rinci,

				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				ref_rek_4.nm_rek_4,
				ref_rek_5.nm_rek_5,

                ta_belanja_rinc.keterangan AS nama_sub_rincian,
				ta_belanja_rinc_sub.keterangan AS nama_rincian,
                ta_belanja_rinc_sub.sat_1 AS vol_1,
				ta_belanja_rinc_sub.sat_2 AS vol_2,
				ta_belanja_rinc_sub.sat_3 AS vol_3,
				ta_belanja_rinc_sub.nilai_1 AS satuan_1,
				ta_belanja_rinc_sub.nilai_2 AS satuan_2,
				ta_belanja_rinc_sub.nilai_3 AS satuan_3,
                ta_belanja_rinc_sub.nilai_rp AS nilai,
				ta_belanja_rinc_sub.jml_satuan AS vol_123,
				ta_belanja_rinc_sub.satuan123 AS satuan_123,
                ta_belanja_rinc_sub.total,

				rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2,
				rek_3.subtotal_rek_3,
				rek_4.subtotal_rek_4,
				rek_5.subtotal_rek_5,
				belanja_sub.subtotal_rinci
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
					ref_rek_2.kd_rek_1,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_1
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
				INNER JOIN ref_rek_3 ON 
					ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
					ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
					ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
				INNER JOIN ref_rek_2 ON 
					ref_rek_3.kd_rek_1 = ref_rek_2.kd_rek_1 AND
					ref_rek_3.kd_rek_2 = ref_rek_2.kd_rek_2
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_2.kd_rek_1
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1
			LEFT JOIN (
				SELECT
					ref_rek_3.kd_rek_2,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_2
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
				INNER JOIN ref_rek_3 ON 
					ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
					ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
					ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
				WHERE
					ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
					AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
					AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
					AND ta_belanja.id_prog = ' . $params['id_prog'] . '
					AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
				GROUP BY
					ref_rek_3.kd_rek_2
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2
			LEFT JOIN (
				SELECT
					ref_rek_4.kd_rek_3,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_3
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
			) AS rek_3 ON rek_3.kd_rek_3 = ref_rek_3.kd_rek_3
            LEFT JOIN (
				SELECT
					ref_rek_5.kd_rek_4,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_4
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
				INNER JOIN ref_rek_5
				ON 
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
			) AS rek_4 ON rek_4.kd_rek_4 = ref_rek_4.kd_rek_4
            LEFT JOIN (
				SELECT
					ta_belanja_rinc.no_rinc,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rek_5
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
					ta_belanja_rinc.no_rinc
			) AS rek_5 ON rek_5.no_rinc = ta_belanja_rinc.no_rinc
			LEFT JOIN (
				SELECT
					ta_belanja_rinc_sub.no_rinc,
					Sum(ta_belanja_rinc_sub.total) AS subtotal_rinci
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
					ta_belanja_rinc_sub.no_rinc
			) AS belanja_sub ON belanja_sub.no_rinc = ta_belanja_rinc.no_rinc
			WHERE
				ta_belanja.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_belanja.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_belanja.kd_unit = ' . $params['kd_unit'] . '
				AND ta_belanja.kd_sub = ' . $params['kd_sub'] . '
				AND ta_belanja.kd_prog = ' . $params['kd_prog'] . '
				AND ta_belanja.id_prog = ' . $params['id_prog'] . '
				AND ta_belanja.kd_keg = ' . $params['kd_keg'] . '
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC,
				ref_rek_4.kd_rek_4 ASC,
				ref_rek_5.kd_rek_5 ASC
		')
			->result();
		//print_r($belanja_query);exit;
		$tim_anggaran_query							= $this->query
		('
			SELECT
				ta_tim_anggaran.nama AS nama_tim,
				ta_tim_anggaran.nip AS nip_tim,
				ta_tim_anggaran.jabatan AS jabatan_tim,
				ta_tim_anggaran.no_urut AS kode,
			    0 AS id
			FROM
				ta_tim_anggaran
			WHERE
				ta_tim_anggaran.tahun = ' . $params['tahun'] . '
			AND ta_tim_anggaran.kd_tim = 1
			ORDER BY
				ta_tim_anggaran.no_urut
		')
			->result();
		if(isset($header_query))
		{
			$jenis_anggaran			= 9;
		}
		else
		{
			$jenis_anggaran			= 9;//$header_query->id_jenis_anggaran;
		}
/*		$tanggal_query								= $this->query
		('
			SELECT
				ref__renja_jenis_anggaran.tanggal_rka
			FROM
				ref__renja_jenis_anggaran
			WHERE
				ref__renja_jenis_anggaran.kode = ' . $jenis_anggaran . '
			LIMIT 1
		')
			->row();*/
/*		$approval									= $this->model->query
		('
			SELECT
				ta__asistensi_setuju.perencanaan,
				ta__asistensi_setuju.waktu_verifikasi_perencanaan,
				ta__asistensi_setuju.nama_operator_perencanaan,
				ta__asistensi_setuju.keuangan,
				ta__asistensi_setuju.waktu_verifikasi_keuangan,
				ta__asistensi_setuju.nama_operator_keuangan,
				ta__asistensi_setuju.setda,
				ta__asistensi_setuju.waktu_verifikasi_setda,
				ta__asistensi_setuju.nama_operator_setda,
				ta__asistensi_setuju.ttd_1,
				ta__asistensi_setuju.ttd_2,
				ta__asistensi_setuju.ttd_3
			FROM
				ta__asistensi_setuju
			WHERE
				ta__asistensi_setuju.id_keg_sub = ' . $sub_kegiatan . ' AND
				ta__asistensi_setuju.kode_perubahan = ' . $jenis_anggaran . '
			LIMIT 1
		')
			->row();*/
		//echo $this->db->last_query();exit;
		//print_r($indikator_query);exit;
		$output										= array
		(
			'header'								=> $header_query,
			'sumber_dana'							=> $sumber_dana_query,
			'indikator'								=> $indikator_kegiatan_query,
			'indikator_sub'							=> null,
			'belanja'								=> $belanja_query,
			'tim_anggaran'							=> $tim_anggaran_query,
			'tanggal'								=> $params['tahun'],
			'approval'								=> null
		);
		//print_r($output);exit;
		return $output;
	}

	public function rka_pembiayaan_skpd($params)
	{
		$header_query								= $this->query
		('
			SELECT
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ref_sub_unit.nm_sub_unit,
				ta_sub_unit.nm_pimpinan AS nama_pejabat,
				ta_sub_unit.jbt_pimpinan AS nama_jabatan,
				ta_sub_unit.nip_pimpinan AS nip_pejabat
			FROM
				ref_sub_unit
				INNER JOIN ta_sub_unit ON ta_sub_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ta_sub_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ta_sub_unit.kd_unit = ref_sub_unit.kd_unit
					AND ta_sub_unit.kd_sub = ref_sub_unit.kd_sub
				INNER JOIN ref_unit ON ref_unit.kd_urusan = ref_sub_unit.kd_urusan
					AND ref_unit.kd_bidang = ref_sub_unit.kd_bidang
					AND ref_unit.kd_unit = ref_sub_unit.kd_unit
				INNER JOIN ref_bidang ON ref_bidang.kd_urusan = ta_sub_unit.kd_urusan
					AND ref_bidang.kd_bidang = ta_sub_unit.kd_bidang
				INNER JOIN ref_urusan ON ref_bidang.kd_urusan = ref_urusan.kd_urusan
			WHERE
				ref_sub_unit.kd_urusan = ' . $params['kd_urusan'] . '
				AND ref_sub_unit.kd_bidang = ' . $params['kd_bidang'] . '
				AND ref_sub_unit.kd_unit = ' . $params['kd_unit'] . '
				AND ref_sub_unit.kd_sub = ' . $params['kd_sub'] . '
		')
			->row();
		$pembiayaan_query							= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				Sum(ta_pembiayaan_rinc.total) AS subtotal_rek_3,
				rek_2.subtotal_rek_2,
				rek_1.subtotal_rek_1
			FROM
				ta_pembiayaan_rinc
			INNER JOIN ta_pembiayaan ON 
					ta_pembiayaan_rinc.id_prog = ta_pembiayaan.id_prog AND
					ta_pembiayaan_rinc.kd_bidang = ta_pembiayaan.kd_bidang AND
					ta_pembiayaan_rinc.kd_keg = ta_pembiayaan.kd_keg AND
					ta_pembiayaan_rinc.kd_prog = ta_pembiayaan.kd_prog AND
					ta_pembiayaan_rinc.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND
					ta_pembiayaan_rinc.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND
					ta_pembiayaan_rinc.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND
					ta_pembiayaan_rinc.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND
					ta_pembiayaan_rinc.kd_rek_5 = ta_pembiayaan.kd_rek_5 AND
					ta_pembiayaan_rinc.kd_sub = ta_pembiayaan.kd_sub AND
					ta_pembiayaan_rinc.kd_unit = ta_pembiayaan.kd_unit AND
					ta_pembiayaan_rinc.kd_urusan = ta_pembiayaan.kd_urusan AND
					ta_pembiayaan_rinc.tahun = ta_pembiayaan.tahun
			INNER JOIN ref_rek_5 ON 
					ta_pembiayaan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pembiayaan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pembiayaan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pembiayaan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pembiayaan.kd_rek_5 = ref_rek_5.kd_rek_5
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
					ref_rek_3.kd_rek_2,
					Sum(ta_pembiayaan_rinc.total) AS subtotal_rek_2
				FROM
					ta_pembiayaan_rinc
				INNER JOIN ta_pembiayaan ON 
					ta_pembiayaan_rinc.id_prog = ta_pembiayaan.id_prog AND
					ta_pembiayaan_rinc.kd_bidang = ta_pembiayaan.kd_bidang AND
					ta_pembiayaan_rinc.kd_keg = ta_pembiayaan.kd_keg AND
					ta_pembiayaan_rinc.kd_prog = ta_pembiayaan.kd_prog AND
					ta_pembiayaan_rinc.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND
					ta_pembiayaan_rinc.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND
					ta_pembiayaan_rinc.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND
					ta_pembiayaan_rinc.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND
					ta_pembiayaan_rinc.kd_rek_5 = ta_pembiayaan.kd_rek_5 AND
					ta_pembiayaan_rinc.kd_sub = ta_pembiayaan.kd_sub AND
					ta_pembiayaan_rinc.kd_unit = ta_pembiayaan.kd_unit AND
					ta_pembiayaan_rinc.kd_urusan = ta_pembiayaan.kd_urusan AND
					ta_pembiayaan_rinc.tahun = ta_pembiayaan.tahun
				INNER JOIN ref_rek_5 ON 
					ta_pembiayaan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
					ta_pembiayaan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
					ta_pembiayaan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
					ta_pembiayaan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
					ta_pembiayaan.kd_rek_5 = ref_rek_5.kd_rek_5
				INNER JOIN ref_rek_4 ON 
					ref_rek_5.kd_rek_1 = ref_rek_4.kd_rek_1 AND
					ref_rek_5.kd_rek_2 = ref_rek_4.kd_rek_2 AND
					ref_rek_5.kd_rek_3 = ref_rek_4.kd_rek_3 AND
					ref_rek_5.kd_rek_4 = ref_rek_4.kd_rek_4
				INNER JOIN ref_rek_3 ON 
					ref_rek_4.kd_rek_1 = ref_rek_3.kd_rek_1 AND
					ref_rek_4.kd_rek_2 = ref_rek_3.kd_rek_2 AND
					ref_rek_4.kd_rek_3 = ref_rek_3.kd_rek_3
				WHERE
					ta_pembiayaan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pembiayaan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pembiayaan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pembiayaan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_3.kd_rek_2
			) AS rek_2 ON rek_2.kd_rek_2 = ref_rek_2.kd_rek_2
			LEFT JOIN (
				SELECT
					ref_rek_2.kd_rek_1,
					Sum(ta_pembiayaan_rinc.total) AS subtotal_rek_1
				FROM
				ta_pembiayaan_rinc
				INNER JOIN ta_pembiayaan ON 
						ta_pembiayaan_rinc.id_prog = ta_pembiayaan.id_prog AND
						ta_pembiayaan_rinc.kd_bidang = ta_pembiayaan.kd_bidang AND
						ta_pembiayaan_rinc.kd_keg = ta_pembiayaan.kd_keg AND
						ta_pembiayaan_rinc.kd_prog = ta_pembiayaan.kd_prog AND
						ta_pembiayaan_rinc.kd_rek_1 = ta_pembiayaan.kd_rek_1 AND
						ta_pembiayaan_rinc.kd_rek_2 = ta_pembiayaan.kd_rek_2 AND
						ta_pembiayaan_rinc.kd_rek_3 = ta_pembiayaan.kd_rek_3 AND
						ta_pembiayaan_rinc.kd_rek_4 = ta_pembiayaan.kd_rek_4 AND
						ta_pembiayaan_rinc.kd_rek_5 = ta_pembiayaan.kd_rek_5 AND
						ta_pembiayaan_rinc.kd_sub = ta_pembiayaan.kd_sub AND
						ta_pembiayaan_rinc.kd_unit = ta_pembiayaan.kd_unit AND
						ta_pembiayaan_rinc.kd_urusan = ta_pembiayaan.kd_urusan AND
						ta_pembiayaan_rinc.tahun = ta_pembiayaan.tahun
				INNER JOIN ref_rek_5 ON 
						ta_pembiayaan.kd_rek_1 = ref_rek_5.kd_rek_1 AND
						ta_pembiayaan.kd_rek_2 = ref_rek_5.kd_rek_2 AND
						ta_pembiayaan.kd_rek_3 = ref_rek_5.kd_rek_3 AND
						ta_pembiayaan.kd_rek_4 = ref_rek_5.kd_rek_4 AND
						ta_pembiayaan.kd_rek_5 = ref_rek_5.kd_rek_5
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
				WHERE
					ta_pembiayaan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
					AND ta_pembiayaan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
					AND ta_pembiayaan_rinc.kd_unit = ' . $params['kd_unit'] . '
					AND ta_pembiayaan_rinc.kd_sub = ' . $params['kd_sub'] . '
				GROUP BY
					ref_rek_2.kd_rek_1
			) AS rek_1 ON rek_1.kd_rek_1 = ref_rek_1.kd_rek_1
			WHERE
				ta_pembiayaan_rinc.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_pembiayaan_rinc.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_pembiayaan_rinc.kd_unit = ' . $params['kd_unit'] . '
				AND ta_pembiayaan_rinc.kd_sub = ' . $params['kd_sub'] . '
			GROUP BY
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_1.nm_rek_1,
				ref_rek_2.nm_rek_2,
				ref_rek_3.nm_rek_3,
				rek_1.subtotal_rek_1,
				rek_2.subtotal_rek_2
			ORDER BY
				ref_rek_1.kd_rek_1 ASC,
				ref_rek_2.kd_rek_2 ASC,
				ref_rek_3.kd_rek_3 ASC
		')
			->result();
		$tim_anggaran_query							= $this->query
		('
			SELECT
				ta_tim_anggaran.nama AS nama_tim,
				ta_tim_anggaran.nip AS nip_tim,
				ta_tim_anggaran.jabatan AS jabatan_tim,
				ta_tim_anggaran.no_urut AS kode,
			    0 AS id
			FROM
				ta_tim_anggaran
			WHERE
				ta_tim_anggaran.tahun = ' . $params['tahun'] . '
			AND ta_tim_anggaran.kd_tim = 1
			ORDER BY
				ta_tim_anggaran.no_urut
		')
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'pembiayaan'							=> $pembiayaan_query,
			'tim_anggaran'							=> $tim_anggaran_query,
			'tanggal'								=> $params['tahun']
		);
		//print_r($output);exit;
		return $output;
	}

	public function rekening($params)
	{
		$data_query									= $this->query
		('
			SELECT
				ref_rek_1.kd_rek_1 AS id_rek_1,
				ref_rek_2.kd_rek_2 AS id_rek_2,
				ref_rek_3.kd_rek_3 AS id_rek_3,
				ref_rek_4.kd_rek_4 AS id_rek_4,
				ref_rek_5.kd_rek_5 AS id_rek_5,
				ref_rek_1.kd_rek_1,
				ref_rek_2.kd_rek_2,
				ref_rek_3.kd_rek_3,
				ref_rek_4.kd_rek_4,
				ref_rek_5.kd_rek_5,
				ref_rek_1.nm_rek_1 AS uraian_rek_1,
				ref_rek_2.nm_rek_2 AS uraian_rek_2,
				ref_rek_3.nm_rek_3 AS uraian_rek_3,
				ref_rek_4.nm_rek_4 AS uraian_rek_4,
				ref_rek_5.nm_rek_5 AS uraian_rek_5,
				ref_rek_5.peraturan
			FROM
				ref_rek_5
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
			WHERE
				ref_rek_1.kd_rek_1 LIKE ' . $params['kd_rek_1'] . '
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
			'data'									=> $data_query
		);
		//print_r($output);exit;
		return $output;
	}

	public function sumber_dana($params)
	{
		$data_query									= $this->query
		('
			SELECT
				ref_sumber_dana.kd_sumber AS id_sumber,
				ref_sumber_dana.kd_sumber,
				ref_sumber_dana.nm_sumber
			FROM
				ref_sumber_dana
			ORDER BY
				ref_sumber_dana.kd_sumber ASC
		')
			->result();
		$output										= array
		(
			'data'									=> $data_query
		);
		//print_r($output);exit;
		return $output;
	}

}
