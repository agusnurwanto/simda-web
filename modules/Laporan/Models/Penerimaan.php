<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Penerimaan extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Penerimaan
	 */
	public function bukti_penerimaan($params)
	{
		$tahun                                      = $params['tahun'];
		$no_bukti                                   = $params['no_bukti'];

		$header_query								= $this->query
		("
			SELECT
				B.nm_sub_unit
			FROM
				ta_bukti_penerimaan A
			INNER JOIN
				ref_sub_unit B ON A.kd_urusan = B.kd_urusan AND
				A.kd_bidang = B.kd_bidang AND
				A.kd_unit = B.kd_unit AND
				A.kd_sub = B.kd_sub
			WHERE
				Tahun = '$tahun' AND
				no_bukti = '$no_bukti'
		")
			->row();

		$data_query								    = $this->query
		("
			SELECT
				B.No_Bukti,
				B.Tgl_Bukti,
				B.Nama,
				B.Alamat,
				B.Uraian,
				CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_Gab,
				C.Nm_Rek_5,
				A.Nilai,
				B.Nm_Penandatangan,
				B.Nip_Penandatangan,
				B.Jbt_Penandatangan,
				E.Nm_Sub_Unit
			FROM
				Ta_Bukti_Penerimaan_Rinc A 
			INNER JOIN
				Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND
				A.No_Bukti = B.No_Bukti
			INNER JOIN
				Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 AND
				A.Kd_Rek_2 = C.Kd_Rek_2 AND
				A.Kd_Rek_3 = C.Kd_Rek_3 AND
				A.Kd_Rek_4 = C.Kd_Rek_4 AND
				A.Kd_Rek_5 = C.Kd_Rek_5
			INNER JOIN
				Ta_Sub_Unit D ON B.Tahun = D.Tahun AND
				B.Kd_Urusan = D.Kd_Urusan AND
				B.Kd_Bidang = D.Kd_Bidang AND
				B.Kd_Unit = D.Kd_Unit AND
				B.Kd_Sub = D.Kd_Sub
			INNER JOIN
				Ref_Sub_Unit E ON D.Kd_Urusan = E.Kd_Urusan AND
				D.Kd_Bidang = E.Kd_Bidang AND
				D.Kd_Unit = E.Kd_Unit AND
				D.Kd_Sub = E.Kd_Sub 
			WHERE (B.Tahun = '$tahun') AND (B.No_Bukti = '$no_bukti')
		")
			->result();

		$output										= array
		(
			'header_query'							=> $header_query,
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function sts($params)
	{
		$tahun                                      = $params['tahun'];
		$no_sts                                     = $params['no_sts'];

		$header_query								= $this->query
		("
			SELECT
				B.nm_sub_unit
			FROM
				ta_sts A
			INNER JOIN
				ref_sub_unit B ON A.kd_urusan = B.kd_urusan AND
				A.kd_bidang = B.kd_bidang AND
				A.kd_unit = B.kd_unit AND
				A.kd_sub = B.kd_sub
			WHERE
				Tahun = '$tahun' AND
				No_STS = '$no_sts'
		")
			->row();

		$data_query								    = $this->query
		("
			SELECT
				B.No_STS,
				B.Tgl_STS,
				D.Nm_Bank,
				D.No_Rekening,
				CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_Gab,
				C.Nm_Rek_5,
				A.Nilai,
				E.Nm_Pimpinan,
				E.Nip_Pimpinan,
				E.Jbt_Pimpinan,
				B.Nm_Penandatangan,
				B.Nip_Penandatangan,
				B.Jbt_Penandatangan
			FROM
				Ta_STS_Rinc A 
			INNER JOIN
				Ta_STS B ON A.Tahun = B.Tahun AND
				A.No_STS = B.No_STS
			INNER JOIN
				Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 AND
				A.Kd_Rek_2 = C.Kd_Rek_2 AND
				A.Kd_Rek_3 = C.Kd_Rek_3 AND
				A.Kd_Rek_4 = C.Kd_Rek_4 AND
				A.Kd_Rek_5 = C.Kd_Rek_5
			INNER JOIN
				Ref_Bank D ON B.Kd_Bank = D.Kd_Bank
			INNER JOIN
				Ta_Sub_Unit E ON B.Tahun = E.Tahun AND
				B.Kd_Urusan = E.Kd_Urusan AND
				B.Kd_Bidang = E.Kd_Bidang AND
				B.Kd_Unit = E.Kd_Unit AND
				B.Kd_Sub = E.Kd_Sub
			WHERE
				(B.Tahun = '$tahun') AND
				(B.No_STS = '$no_sts')
		")
			->result();

		$output										= array
		(
			'header_query'							=> $header_query,
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function rekapitulasi_penerimaan($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$data_query								    = $this->query
		("
			SELECT
				B.Kd_UrusanA,
				B.Kd_BidangA,
				B.Kd_UnitA,
				B.Kd_SubA,
				B.Kd_Urusan_Gab,
				B.Kd_Bidang_Gab,
				B.Kd_Unit_Gab,
				B.Kd_Sub_Gab,
				B.Nm_Urusan_Gab,
				B.Nm_Bidang_Gab,
				B.Nm_Unit_Gab,
				B.Nm_Sub_Unit_Gab,
				A.Kd_Rek_1,
				A.Kd_Rek_2,
				A.Kd_Rek_3,
				A.Kd_Rek_4,
				A.Kd_Rek_5,
				A.Kd_Rek_2_Gab,
				A.Kd_Rek_3_Gab,
				A.Kd_Rek_4_Gab,
				A.Kd_Rek_5_Gab,
				A.Nm_Rek_2,
				A.Nm_Rek_3,
				A.Nm_Rek_4,
				A.Nm_Rek_5,
				A.Tgl_Bukti,
				A.No_Bukti,
				A.Jumlah,
				B.Nm_Pimpinan,
				B.Nip_Pimpinan,
				B.Jbt_Pimpinan,
				B.Nm_Bendahara,
				B.Nip_Bendahara,
				B.Jbt_Bendahara
			FROM
			(
				SELECT
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
					A.Kd_Rek_4,
					A.Kd_Rek_5,
					E.Nm_Rek_2,
					D.Nm_Rek_3,
					C.Nm_Rek_4,
					B.Nm_Rek_5,
					CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) AS Kd_Rek_2_Gab,
					CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) AS Kd_Rek_3_Gab,
					CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) AS Kd_Rek_4_Gab,
					CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_5_Gab,
					A.Tgl_Bukti,
					A.No_Bukti,
					A.Jumlah
				FROM
				(
					SELECT
						B.Tgl_Bukti,
						B.No_Bukti,
						A.Kd_Rek_1,
						A.Kd_Rek_2,
						A.Kd_Rek_3,
						A.Kd_Rek_4,
						A.Kd_Rek_5,
						SUM(A.Nilai) AS Jumlah
					FROM
						Ta_Bukti_Penerimaan_Rinc A
					INNER JOIN
						Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND
						A.No_Bukti = B.No_Bukti
					WHERE
						(B.Tgl_Bukti BETWEEN '$d1' AND '$d2') AND
						(B.Tahun = '$tahun') AND
						(B.Kd_Urusan LIKE '$kd_urusan') AND
						(B.Kd_Bidang LIKE '$kd_bidang') AND
						(B.Kd_Unit LIKE '$kd_unit') AND
						(B.Kd_Sub LIKE '$kd_sub')
					GROUP BY B.No_BKU, B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
					
					UNION ALL
					
					SELECT
						B.Tgl_STS,
						B.No_STS,
						A.Kd_Rek_1,
						A.Kd_Rek_2,
						A.Kd_Rek_3,
						A.Kd_Rek_4,
						A.Kd_Rek_5,
						SUM(A.Nilai) AS Jumlah
					FROM
						Ta_STS_Rinc A
					INNER JOIN
						Ta_STS B ON A.Tahun = B.Tahun AND
						A.No_STS = B.No_STS
					WHERE
						(B.Tgl_STS BETWEEN '$d1' AND '$d2') AND
						(B.Kd_SKPD = 2) AND
						(B.Tahun = '$tahun') AND
						(B.Kd_Urusan LIKE '$kd_urusan') AND
						(B.Kd_Bidang LIKE '$kd_bidang') AND
						(B.Kd_Unit LIKE '$kd_unit') AND
						(B.Kd_Sub LIKE '$kd_sub')
					GROUP BY B.No_BKU, B.Tgl_STS, B.No_STS, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
					
					UNION ALL
					
					SELECT
						B.Tgl_Bukti,
						B.No_Bukti,
						A.Kd_Rek_1,
						A.Kd_Rek_2,
						A.Kd_Rek_3,
						A.Kd_Rek_4,
						A.Kd_Rek_5,
                       SUM(CASE A.D_K
                               WHEN 'D' THEN -A.Nilai
                               ELSE A.Nilai
                           END) AS Jumlah
					FROM
						Ta_Penyesuaian_Rinc A
					INNER JOIN
						Ta_Penyesuaian B ON A.Tahun = B.Tahun AND
						A.No_Bukti = B.No_Bukti
					WHERE
						(B.Tgl_Bukti BETWEEN '$d1' AND '$d2') AND
						(B.Tahun = '$tahun') AND
						(B.Kd_Urusan LIKE '$kd_urusan') AND
						(B.Kd_Bidang LIKE '$kd_bidang') AND
						(B.Kd_Unit LIKE '$kd_unit') AND
						(B.Kd_Sub LIKE '$kd_sub') AND
						(B.Jns_P1 = 2) AND
						((B.Kd_SKPD = 2) OR ((B.Kd_SKPD = 1) AND
						(B.Jn_SPM IN (1, 3))) OR (B.Jns_P2 = 1))
					GROUP BY B.No_BKU, B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
					
					UNION ALL
					
					SELECT
						B.Tgl_Bukti,
						B.No_Bukti,
						A.Kd_Rek_1,
						A.Kd_Rek_2,
						A.Kd_Rek_3,
						A.Kd_Rek_4,
						A.Kd_Rek_5,
						SUM(CASE A.D_K
						       WHEN 'D' THEN -A.Nilai
						       ELSE A.Nilai
						   END) AS Jumlah
					FROM
						Ta_Jurnal_Rinc A
					INNER JOIN
						Ta_Jurnal B ON A.Tahun = B.Tahun AND
						A.No_Bukti = B.No_Bukti
					WHERE
						(B.Tgl_Bukti BETWEEN '$d1' AND '$d2') AND
						(B.Tahun = '$tahun') AND
						(B.Kd_Urusan LIKE '$kd_urusan') AND
						(B.Kd_Bidang LIKE '$kd_bidang') AND
						(B.Kd_Unit LIKE '$kd_unit') AND
						(B.Kd_Sub LIKE '$kd_sub') AND
						(A.Kd_Rek_1 = 4)
					GROUP BY B.No_BKU, B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
				) A
			INNER JOIN
				Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 AND
				A.Kd_Rek_2 = B.Kd_Rek_2 AND
				A.Kd_Rek_3 = B.Kd_Rek_3 AND
				A.Kd_Rek_4 = B.Kd_Rek_4 AND
				A.Kd_Rek_5 = B.Kd_Rek_5 
			INNER JOIN
				Ref_Rek_4 C ON B.Kd_Rek_1 = C.Kd_Rek_1 AND
				B.Kd_Rek_2 = C.Kd_Rek_2 AND
				B.Kd_Rek_3 = C.Kd_Rek_3 AND 
				B.Kd_Rek_4 = C.Kd_Rek_4 
			INNER JOIN
				Ref_Rek_3 D ON C.Kd_Rek_1 = D.Kd_Rek_1 AND
				C.Kd_Rek_2 = D.Kd_Rek_2 AND
				C.Kd_Rek_3 = D.Kd_Rek_3
		    INNER JOIN
				Ref_Rek_2 E ON D.Kd_Rek_1 = E.Kd_Rek_1 AND
			D.Kd_Rek_2 = E.Kd_Rek_2
			) A,
			(
				SELECT
					'$kd_urusan' AS Kd_UrusanA,
					'$kd_bidang' AS Kd_BidangA,
					'$kd_unit' AS Kd_UnitA,
					'$kd_sub' AS Kd_SubA,
					'$kd_urusan' AS Kd_Urusan_Gab,
					'$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) AS Kd_Bidang_Gab,
					'$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) AS Kd_Unit_Gab,
					'$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) + ' . ' + RIGHT('0' +  '$kd_sub', 2) AS Kd_Sub_Gab,
					E.Nm_Urusan AS Nm_Urusan_Gab, D.Nm_Bidang AS Nm_Bidang_Gab, C.Nm_Unit AS Nm_Unit_Gab, B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
					A.Nm_Pimpinan AS Nm_Pimpinan, A.Nip_Pimpinan AS Nip_Pimpinan, A.Jbt_Pimpinan AS Jbt_Pimpinan,
					G.Nm_Bendahara, G.Nip_Bendahara, G.Jbt_Bendahara
				FROM
					Ta_Sub_Unit A 
				INNER JOIN
					Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND
					A.Kd_Bidang = B.Kd_Bidang AND
					A.Kd_Unit = B.Kd_Unit AND
					A.Kd_Sub = B.Kd_Sub
				INNER JOIN
					Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND
					B.Kd_Bidang = C.Kd_Bidang AND
					B.Kd_Unit = C.Kd_Unit
				INNER JOIN
					Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND
					C.Kd_Bidang = D.Kd_Bidang
				INNER JOIN
					Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
				INNER JOIN
				(
					SELECT
						TOP 1 Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub
					FROM
						Ta_Sub_Unit A
					WHERE
						(A.Tahun = '$tahun') AND
						(A.Kd_Urusan LIKE '$kd_urusan') AND
						(A.Kd_Bidang LIKE '$kd_bidang') AND
						(A.Kd_Unit LIKE '$kd_unit') AND
						(A.Kd_Sub LIKE '$kd_sub')
					ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
					) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
			    LEFT OUTER JOIN
				(
					SELECT
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub,
						MIN(Nama) AS Nm_Bendahara,
						MIN(Nip) AS Nip_Bendahara,
						MIN(Jabatan) AS Jbt_Bendahara
					FROM
						Ta_Sub_Unit_Jab A
					WHERE
						(A.Kd_Jab = 3) AND 
						(A.Tahun = '$tahun') AND
						(A.Kd_Urusan LIKE '$kd_urusan') AND
						(A.Kd_Bidang LIKE '$kd_bidang') AND
						(A.Kd_Unit LIKE '$kd_unit') AND
						(A.Kd_Sub LIKE '$kd_sub')
					GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
				) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			) B
			ORDER BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, A.Tgl_Bukti, A.No_Bukti
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function bku_pembantu($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$data_query								    = $this->query
		("
			SELECT 
			   B.Kd_UrusanA,
		       B.Kd_BidangA,
		       B.Kd_UnitA,
		       B.Kd_SubA,
		       B.Kd_Urusan_Gab,
		       B.Kd_Bidang_Gab,
		       B.Kd_Unit_Gab,
		       B.Kd_Sub_Gab,
		       B.Nm_Urusan_Gab,
		       B.Nm_Bidang_Gab,
		       B.Nm_Unit_Gab,
		       B.Nm_Sub_Unit_Gab,
		       A.Kd_Rek_1,
		       A.Kd_Rek_2,
		       A.Kd_Rek_3,
		       A.Kd_Rek_4,
		       A.Kd_Rek_5,
		       A.Kd_Rek_5_Gab,
		       A.Nm_Rek_5,
		       A.Anggaran,
		       A.Kode,
		       A.No_BKU,
		       A.Tgl_Bukti,
		       A.No_Bukti,
		       A.Jumlah,
		       B.Nm_Pimpinan,
		       B.Nip_Pimpinan,
		       B.Jbt_Pimpinan,
		       B.Nm_Bendahara,
		       B.Nip_Bendahara,
		       B.Jbt_Bendahara
		FROM (
		         SELECT
		                A.Kd_Rek_1,
		                A.Kd_Rek_2,
		                A.Kd_Rek_3,
		                A.Kd_Rek_4,
		                A.Kd_Rek_5,
		                CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' +
		                CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' +
		                RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_5_Gab,
		                B.Nm_Rek_5,
		                ISNULL(C.Anggaran, 0) AS Anggaran,
		                A.Kode,
		                A.No_BKU,
		                A.Tgl_Bukti,
		                A.No_Bukti,
		                A.Jumlah
		         FROM (
		                  SELECT
		                         2 AS Kode,
		                         B.No_BKU,
		                         B.Tgl_Bukti,
		                         B.No_Bukti,
		                         A.Kd_Rek_1,
		                         A.Kd_Rek_2,
		                         A.Kd_Rek_3,
		                         A.Kd_Rek_4,
		                         A.Kd_Rek_5,
		                         SUM(A.Nilai) AS Jumlah
		                  FROM
		                        Ta_Bukti_Penerimaan_Rinc A
						  INNER JOIN
		                       Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		                  WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
		                    AND (B.Tahun = '$tahun')
		                    AND (B.Kd_Urusan LIKE '$kd_urusan')
		                    AND (B.Kd_Bidang LIKE '$kd_bidang')
		                    AND (B.Kd_Unit LIKE '$kd_unit')
		                    AND (B.Kd_Sub LIKE '$kd_sub')
		                  GROUP BY B.No_BKU, B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		
		                  UNION ALL
		
		                  SELECT
		                         2 AS Kode,
		                         B.No_BKU,
		                         B.Tgl_STS,
		                         B.No_STS,
		                         A.Kd_Rek_1,
		                         A.Kd_Rek_2,
		                         A.Kd_Rek_3,
		                         A.Kd_Rek_4,
		                         A.Kd_Rek_5,
		                         SUM(A.Nilai) AS Jumlah
		                  FROM
		                        Ta_STS_Rinc A
						  INNER JOIN
		                       Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
		                  WHERE (B.Tgl_STS BETWEEN '$d1' AND '$d2')
		                    AND (B.Kd_SKPD = 2)
		                    AND (B.Tahun = '$tahun')
		                    AND (B.Kd_Urusan LIKE '$kd_urusan')
		                    AND (B.Kd_Bidang LIKE '$kd_bidang')
		                    AND (B.Kd_Unit LIKE '$kd_unit')
		                    AND (B.Kd_Sub LIKE '$kd_sub')
		                  GROUP BY B.No_BKU, B.Tgl_STS, B.No_STS, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		
		                  UNION ALL
		
		                  SELECT
		                         2 AS Kode,
		                         B.No_BKU,
		                         B.Tgl_Bukti,
		                         B.No_Bukti,
		                         A.Kd_Rek_1,
		                         A.Kd_Rek_2,
		                         A.Kd_Rek_3,
		                         A.Kd_Rek_4,
		                         A.Kd_Rek_5,
		                         SUM(CASE A.D_K
		                                 WHEN 'D' THEN -A.Nilai
		                                 ELSE A.Nilai
		                             END) AS Jumlah
		                  FROM
		                        Ta_Penyesuaian_Rinc A
						  INNER JOIN
		                       Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		                  WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
		                    AND (B.Tahun = '$tahun')
		                    AND (B.Kd_Urusan LIKE '$kd_urusan')
		                    AND (B.Kd_Bidang LIKE '$kd_bidang')
		                    AND (B.Kd_Unit LIKE '$kd_unit')
		                    AND (B.Kd_Sub LIKE '$kd_sub')
		                    AND (B.Jns_P1 = 2)
		                    AND ((B.Kd_SKPD = 2) OR ((B.Kd_SKPD = 1) AND (B.Jn_SPM IN (1, 3))) OR (B.Jns_P2 = 1))
		                  GROUP BY B.No_BKU, B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		
		                  UNION ALL
		
		                  SELECT
		                         2 AS Kode,
		                         B.No_BKU,
		                         B.Tgl_Bukti,
		                         B.No_Bukti,
		                         A.Kd_Rek_1,
		                         A.Kd_Rek_2,
		                         A.Kd_Rek_3,
		                         A.Kd_Rek_4,
		                         A.Kd_Rek_5,
		                         SUM(CASE A.D_K
		                                 WHEN 'D' THEN -A.Nilai
		                                 ELSE A.Nilai
		                             END) AS Jumlah
		                  FROM
		                        Ta_Jurnal_Rinc A
						  INNER JOIN
		                       Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		                  WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
		                    AND (B.Tahun = '$tahun')
		                    AND (B.Kd_Urusan LIKE '$kd_urusan')
		                    AND (B.Kd_Bidang LIKE '$kd_bidang')
		                    AND (B.Kd_Unit LIKE '$kd_unit')
		                    AND (B.Kd_Sub LIKE '$kd_sub')
		                    AND (A.Kd_Rek_1 = 4)
		                  GROUP BY B.No_BKU, B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		
		                  UNION ALL
		
		                  SELECT
		                        1 AS Kode,
								'' AS No_BKU,
								($d1 - 1) AS Tgl_STS,
								'' AS No_STS,
								A.Kd_Rek_1,
								A.Kd_Rek_2,
								A.Kd_Rek_3,
								A.Kd_Rek_4,
								A.Kd_Rek_5,
								SUM(A.Nilai) AS Jumlah
		                  FROM (
		                           SELECT
										A.Kd_Rek_1,
										A.Kd_Rek_2,
										A.Kd_Rek_3,
										A.Kd_Rek_4,
										A.Kd_Rek_5, 
										A.Nilai
		                           FROM
										Ta_Bukti_Penerimaan_Rinc A
								   INNER JOIN
		                                Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		                           WHERE (B.Tgl_Bukti < '$d1')
		                             AND (B.Tahun = '$tahun')
		                             AND (B.Kd_Urusan LIKE '$kd_urusan')
		                             AND (B.Kd_Bidang LIKE '$kd_bidang')
		                             AND (B.Kd_Unit LIKE '$kd_unit')
		                             AND (B.Kd_Sub LIKE '$kd_sub')
		
		                           UNION ALL
		
		                           SELECT
										A.Kd_Rek_1,
										A.Kd_Rek_2,
										A.Kd_Rek_3,
										A.Kd_Rek_4,
										A.Kd_Rek_5,
										A.Nilai
		                           FROM
		                                Ta_STS_Rinc A
								   INNER JOIN
		                                Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
		                           WHERE (B.Tgl_STS < '$d1')
		                             AND (B.Kd_SKPD = 2)
		                             AND (B.Tahun = '$tahun')
		                             AND (B.Kd_Urusan LIKE '$kd_urusan')
		                             AND (B.Kd_Bidang LIKE '$kd_bidang')
		                             AND (B.Kd_Unit LIKE '$kd_unit')
		                             AND (B.Kd_Sub LIKE '$kd_sub')
		
		                           UNION ALL
		
		                           SELECT
		                                  A.Kd_Rek_1,
		                                  A.Kd_Rek_2,
		                                  A.Kd_Rek_3,
		                                  A.Kd_Rek_4,
		                                  A.Kd_Rek_5,
		                                  CASE A.D_K
		                                      WHEN 'D' THEN -A.Nilai
		                                      ELSE A.Nilai
		                                      END
		                           FROM
		                                Ta_Penyesuaian_Rinc A
								   INNER JOIN
		                                Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		                           WHERE (B.Tgl_Bukti < '$d1')
		                             AND (B.Tahun = '$tahun')
		                             AND (B.Kd_Urusan LIKE '$kd_urusan')
		                             AND (B.Kd_Bidang LIKE '$kd_bidang')
		                             AND (B.Kd_Unit LIKE '$kd_unit')
		                             AND (B.Kd_Sub LIKE '$kd_sub')
		                             AND (B.Jns_P1 = 2)
		                             AND ((B.Kd_SKPD = 2) OR ((B.Kd_SKPD = 1) AND (B.Jn_SPM IN (1, 3))) OR (B.Jns_P2 = 1))
		
		                           UNION ALL
		
		                           SELECT
                                          A.Kd_Rek_1,
		                                  A.Kd_Rek_2,
		                                  A.Kd_Rek_3,
		                                  A.Kd_Rek_4,
		                                  A.Kd_Rek_5,
		                                  CASE A.D_K
		                                      WHEN 'D' THEN -A.Nilai
		                                      ELSE A.Nilai
		                                      END
		                           FROM Ta_Jurnal_Rinc A
								   INNER JOIN
		                                Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		                           WHERE (B.Tgl_Bukti < '$d1')
		                             AND (B.Tahun = '$tahun')
		                             AND (B.Kd_Urusan LIKE '$kd_urusan')
		                             AND (B.Kd_Bidang LIKE '$kd_bidang')
		                             AND (B.Kd_Unit LIKE '$kd_unit')
		                             AND (B.Kd_Sub LIKE '$kd_sub')
		                             AND (A.Kd_Rek_1 = 4)
		                       ) A
		                  GROUP BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		              ) A
		                  INNER JOIN
		              Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 AND A.Kd_Rek_2 = B.Kd_Rek_2 AND A.Kd_Rek_3 = B.Kd_Rek_3 AND A.Kd_Rek_4 = B.Kd_Rek_4 AND A.Kd_Rek_5 = B.Kd_Rek_5
	                  LEFT OUTER JOIN
		              (
		                  SELECT
								A.Kd_Rek_1,
								A.Kd_Rek_2,
								A.Kd_Rek_3,
								A.Kd_Rek_4,
								A.Kd_Rek_5,
								SUM(A.Total) AS Anggaran
		                  FROM Ta_RASK_Arsip A
		                  WHERE (A.Kd_Perubahan = (SELECT MAX(Kd_Perubahan)
		                                           FROM Ta_RASK_Arsip_Perubahan
		                                           WHERE Kd_Perubahan IN (4, 6, 8)
		                                             AND Tahun = '$tahun'
		                                             AND Tgl_Perda <= '$d2'))
		                    AND (A.Tahun = '$tahun')
		                    AND (A.Kd_Urusan LIKE '$kd_urusan')
		                    AND (A.Kd_Bidang LIKE '$kd_bidang')
		                    AND (A.Kd_Unit LIKE '$kd_unit')
		                    AND (A.Kd_Sub LIKE '$kd_sub')
		                  GROUP BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		              ) C ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND
		                     A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5
		     ) A,
		     (
		         SELECT
	                '$kd_urusan' AS Kd_UrusanA,
	                '$kd_bidang' AS Kd_BidangA,
	                '$kd_unit' AS Kd_UnitA,
	                '$kd_sub' AS Kd_SubA,
	                '$kd_urusan' AS Kd_Urusan_Gab,
	                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) AS Kd_Bidang_Gab,
	                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
	                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
	                RIGHT('0' + '$kd_sub', 2) AS Kd_Sub_Gab,
	                E.Nm_Urusan AS Nm_Urusan_Gab,
	                D.Nm_Bidang AS Nm_Bidang_Gab,
	                C.Nm_Unit AS Nm_Unit_Gab,
	                B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
	                A.Nm_Pimpinan AS Nm_Pimpinan,
	                A.Nip_Pimpinan AS Nip_Pimpinan,
	                A.Jbt_Pimpinan AS Jbt_Pimpinan,
	                G.Nm_Bendahara,
	                G.Nip_Bendahara,
	                G.Jbt_Bendahara
		         FROM
		              Ta_Sub_Unit A
                 INNER JOIN
		              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub
                 INNER JOIN
		              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
                 INNER JOIN
		              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
                 INNER JOIN
		              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
                 INNER JOIN
		              (
		                  SELECT
							TOP 1 Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub
		                  FROM
		                   Ta_Sub_Unit A
		                  WHERE (A.Tahun = '$tahun')
		                    AND (A.Kd_Urusan LIKE '$kd_urusan')
		                    AND (A.Kd_Bidang LIKE '$kd_bidang')
		                    AND (A.Kd_Unit LIKE '$kd_unit')
		                    AND (A.Kd_Sub LIKE '$kd_sub')
		                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
		              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
		                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
	                  LEFT OUTER JOIN
		              (
		                  SELECT Tahun,
		                         Kd_Urusan,
		                         Kd_Bidang,
		                         Kd_Unit,
		                         Kd_Sub,
		                         MIN(Nama)    AS Nm_Bendahara,
		                         MIN(Nip)     AS Nip_Bendahara,
		                         MIN(Jabatan) AS Jbt_Bendahara
		                  FROM Ta_Sub_Unit_Jab A
		                  WHERE (A.Kd_Jab = 3)
		                    AND (A.Tahun = '$tahun')
		                    AND (A.Kd_Urusan LIKE '$kd_urusan')
		                    AND (A.Kd_Bidang LIKE '$kd_bidang')
		                    AND (A.Kd_Unit LIKE '$kd_unit')
		                    AND (A.Kd_Sub LIKE '$kd_sub')
		                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
		              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
		                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
		     ) B
		ORDER BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, A.Kode DESC, A.Tgl_Bukti, A.No_Bukti
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function spj_pendapatan($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$bulan                                      = $params['bulan'];
		$jenis_laporan                              = '1';

		$tmpSPJ								        =
		("
			SELECT A.Kd_Rek_1,
			       A.Kd_Rek_2,
			       A.Kd_Rek_3,
			       A.Kd_Rek_4,
			       A.Kd_Rek_5,
			       SUM(A.Anggaran) AS Anggaran,
			       SUM(A.Terima_Lalu) AS Terima_Lalu,
			       SUM(A.Setor_Lalu) AS Setor_Lalu,
			       SUM(A.Terima_Ini) AS Terima_Ini,
			       SUM(A.Setor_Ini) AS Setor_Ini
			FROM (
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Total AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_RASK_Arsip A
			         WHERE (A.Kd_Rek_1 = 4)
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Perubahan = (SELECT MAX(Kd_Perubahan)
			                                  FROM Ta_RASK_Arsip_Perubahan
			                                  WHERE Tahun = '$tahun'
			                                    AND Kd_Perubahan IN (4, 6, 8)
			                                    AND (LEFT(CONVERT(varchar, Tgl_Perda, 112), 6) <=
			                                         ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))))
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                A.Nilai AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Bukti_Penerimaan_Rinc A
			                  INNER JOIN
			              Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0                                             AS Anggaran,
			                CASE B.Kd_SKPD WHEN 1 THEN 0 ELSE A.Nilai END AS Terima_Lalu,
			                A.Nilai                                       AS Setor_Lalu,
			                0                                             AS Terima_Ini,
			                0                                             AS Setor_Ini
			         FROM Ta_STS_Rinc A
			                  INNER JOIN
			              Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_STS, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                A.Nilai AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Bukti_Penerimaan_Rinc A
			                  INNER JOIN
			              Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0                                             AS Anggaran,
			                0                                             AS Terima_Lalu,
			                0                                             AS Setor_Lalu,
			                CASE B.Kd_SKPD WHEN 1 THEN 0 ELSE A.Nilai END AS Terima_Ini,
			                A.Nilai                                       AS Setor_Ini
			         FROM Ta_STS_Rinc A
			                  INNER JOIN
			              Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_STS, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (1, 3)) OR ((B.Jn_SPM = 2) AND (B.Kd_SKPD = 2)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Terima_Lalu,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (2, 3)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (B.Jns_P1 = 2)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (1, 3)) OR ((B.Jn_SPM = 2) AND (B.Kd_SKPD = 2)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Terima_Ini,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (2, 3)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Setor_Ini
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (B.Jns_P1 = 2)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Terima_Lalu,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Rek_1 = 4)
			           AND (B.Kd_Jurnal NOT IN (8, 10))
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Terima_Ini,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Setor_Ini
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Rek_1 = 4)
			           AND (B.Kd_Jurnal NOT IN (8, 10))
			     ) A
			GROUP BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		");

		$data_query								    = $this->query
		("
			SELECT C.Kd_UrusanA,
			       C.Kd_BidangA,
			       C.Kd_UnitA,
			       C.Kd_SubA,
			       C.Kd_UrusanB,
			       C.Kd_BidangB,
			       C.Kd_UnitB,
			       C.Kd_SubB,
			       C.Kd_Urusan_Gab,
			       C.Kd_Bidang_Gab,
			       C.Kd_Unit_Gab,
			       C.Kd_Sub_Gab,
			       C.Nm_Urusan_Gab,
			       C.Nm_Bidang_Gab,
			       C.Nm_Unit_Gab,
			       C.Nm_Sub_Unit_Gab,
			       B.Nm_Rek_5,
			       CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) +
			       ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' +
			       RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2)                    AS Kd_Rek_5_Gab,
			       A.Anggaran,
			       A.Terima_Lalu,
			       A.Setor_Lalu,
			       (A.Setor_Lalu - A.Terima_Lalu)                                  AS Sisa_Lalu,
			       A.Terima_Ini,
			       A.Setor_Ini,
			       (A.Setor_Ini - A.Terima_Ini)                                    AS Sisa_Ini,
			       (A.Terima_Lalu + A.Terima_Ini)                                  AS Tot_Terima,
			       (A.Setor_Lalu + A.Setor_Ini)                                    AS Tot_Setor,
			       ((A.Setor_Lalu + A.Setor_Ini) - (A.Terima_Lalu + A.Terima_Ini)) AS Tot_Sisa,
			       (A.Anggaran - (A.Terima_Lalu + A.Terima_Ini))                   AS Sisa_Anggaran,
			       C.Nm_Pimpinan,
			       C.Nip_Pimpinan,
			       C.Jbt_Pimpinan,
			       C.Nm_Bendahara,
			       C.Nip_Bendahara,
			       C.Jbt_Bendahara
			FROM ($tmpSPJ) AS A
			         INNER JOIN
			     Ref_Rek_5 B
			     ON A.Kd_Rek_1 = B.Kd_Rek_1 AND A.Kd_Rek_2 = B.Kd_Rek_2 AND A.Kd_Rek_3 = B.Kd_Rek_3 AND A.Kd_Rek_4 = B.Kd_Rek_4 AND
			        A.Kd_Rek_5 = B.Kd_Rek_5,
			     (
			         SELECT 1                                                                                  AS Kode,
			                '$kd_urusan'                                                                         AS Kd_UrusanA,
			                '$kd_bidang'                                                                         AS Kd_BidangA,
			                '$kd_unit'                                                                           AS Kd_UnitA,
			                '$kd_sub'                                                                            AS Kd_SubA,
			                CASE '$kd_urusan'
			                    WHEN '%' THEN '0'
			                    ELSE '$kd_urusan'
			                    END                                                                            AS Kd_UrusanB,
			                CASE '$kd_bidang'
			                    WHEN '%' THEN '00'
			                    ELSE RIGHT('0' + '$kd_bidang', 2)
			                    END                                                                            AS Kd_BidangB,
			                CASE '$kd_unit'
			                    WHEN '%' THEN '00'
			                    ELSE RIGHT('0' + '$kd_unit', 2)
			                    END                                                                            AS Kd_UnitB,
			                CASE '$kd_sub'
			                    WHEN '%' THEN '00'
			                    ELSE RIGHT('0' + '$kd_sub', 2)
			                    END                                                                            AS Kd_SubB,
			                '$kd_urusan'                                                                         AS Kd_Urusan_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2)                                    AS Kd_Bidang_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2)                                                            AS Kd_Sub_Gab,
			                E.Nm_Urusan                                                                        AS Nm_Urusan_Gab,
			                D.Nm_Bidang                                                                        AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                          AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                      AS Nm_Sub_Unit_Gab,
			                A.Nm_Pimpinan                                                                      AS Nm_Pimpinan,
			                A.Nip_Pimpinan                                                                     AS Nip_Pimpinan,
			                A.Jbt_Pimpinan                                                                     AS Jbt_Pimpinan,
			                G.Nm_Bendahara,
			                G.Nip_Bendahara,
			                G.Jbt_Bendahara
			         FROM Ta_Sub_Unit A
			                  INNER JOIN
			              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND
			                                A.Kd_Sub = B.Kd_Sub
			                  INNER JOIN
			              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
			                  INNER JOIN
			              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
			                  INNER JOIN
			              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
			                  INNER JOIN
			              (
			                  SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			                  FROM Ta_Sub_Unit A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
			                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
			                  LEFT OUTER JOIN
			              (
			                  SELECT Tahun,
			                         Kd_Urusan,
			                         Kd_Bidang,
			                         Kd_Unit,
			                         Kd_Sub,
			                         MIN(Nama)    AS Nm_Bendahara,
			                         MIN(Nip)     AS Nip_Bendahara,
			                         MIN(Jabatan) AS Jbt_Bendahara
			                  FROM Ta_Sub_Unit_Jab A
			                  WHERE (A.Kd_Jab = 3)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
			                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			     ) C
			ORDER BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function bku_penerimaan($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$data_query								    = $this->query
		("
			SELECT B.Kd_UrusanA,
			       B.Kd_BidangA,
			       B.Kd_UnitA,
			       B.Kd_SubA,
			       B.Kd_Urusan_Gab,
			       B.Kd_Bidang_Gab,
			       B.Kd_Unit_Gab,
			       B.Kd_Sub_Gab,
			       B.Nm_Urusan_Gab,
			       B.Nm_Bidang_Gab,
			       B.Nm_Unit_Gab,
			       B.Nm_Sub_Unit_Gab,
			       A.Tanggal,
			       A.Kode,
			       A.No_Bukti,
			       A.Kd_Rek_5_Gab,
			       A.Nm_Rek_5,
			       A.Debet,
			       A.Kredit,
			       (A.Debet - A.Kredit) AS Saldo,
			       B.Nm_Pimpinan,
			       B.Nip_Pimpinan,
			       B.Jbt_Pimpinan,
			       B.Nm_Bendahara,
			       B.Nip_Bendahara,
			       B.Jbt_Bendahara
			FROM (
			         SELECT $d1 - 1       AS Tanggal,
			                1             AS Kode,
			                ''            AS No_Bukti,
			                0             AS Kd_Rek_1,
			                0             AS Kd_Rek_2,
			                0             AS Kd_Rek_3,
			                0             AS Kd_Rek_4,
			                0             AS Kd_Rek_5,
			                ''            AS Kd_Rek_5_Gab,
			                'Saldo Awal'  AS Nm_Rek_5,
			                SUM(A.Debet)  AS Debet,
			                SUM(A.Kredit) AS Kredit
			         FROM (
			                  SELECT CASE D_K
			                             WHEN 'D' THEN Saldo
			                             ELSE 0
			                             END AS Debet,
			                         CASE D_K
			                             WHEN 'K' THEN Saldo
			                             ELSE 0
			                             END AS Kredit
			                  FROM Ta_Saldo_Awal A
			                  WHERE (Kd_Rek_1 = 1)
			                    AND (Kd_Rek_2 = 1)
			                    AND (Kd_Rek_3 = 1)
			                    AND (Kd_Rek_4 = 2)
			                    AND (Kd_Rek_5 = 1)
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (A.Tahun = '$tahun' - 1)
			                  UNION ALL
			
			                  SELECT A.Nilai AS Debet, 0 AS Kredit
			                  FROM Ta_Bukti_Penerimaan_Rinc A
			                           INNER JOIN
			                       Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                  WHERE (B.Tgl_Bukti < '$d1')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			
			                  UNION ALL
			
			                  SELECT 0 AS Debet, A.Nilai AS Kredit
			                  FROM Ta_STS_Rinc A
			                           INNER JOIN
			                       Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			                  WHERE (B.Kd_SKPD = 1)
			                    AND (B.Tgl_STS < '$d1')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			
			                  UNION ALL
			
			                  SELECT CASE A.D_K
			                             WHEN 'D' THEN A.Nilai
			                             ELSE CASE B.Jn_SPM WHEN 3 THEN A.Nilai ELSE 0 END END AS Debet,
			                         CASE A.D_K
			                             WHEN 'K' THEN A.Nilai
			                             ELSE CASE B.Jn_SPM WHEN 3 THEN A.Nilai ELSE 0 END END AS Kredit
			                  FROM Ta_Penyesuaian_Rinc A
			                           INNER JOIN
			                       Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                  WHERE (B.Tgl_Bukti < '$d1')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			                    AND (B.Jns_P1 = 2)
			                    AND ((B.Jns_P2 = 1) OR (B.Jn_SPM IN (1, 3)))
			
			                  UNION ALL
			
			                  SELECT SUM(CASE A.D_K
			                                 WHEN 'K' THEN A.Nilai
			                                 ELSE 0
			                      END)        AS Debet,
			                         SUM(CASE A.D_K
			                                 WHEN 'D' THEN A.Nilai
			                                 ELSE 0
			                             END) AS Kredit
			                  FROM Ta_Jurnal_Rinc A
			                           INNER JOIN
			                       Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                           INNER JOIN
			                       (
			                           SELECT A.Tahun, A.No_Bukti
			                           FROM Ta_Jurnal_Rinc A
			                           WHERE (A.D_K = 'D')
			                             AND (A.Kd_Rek_1 = 1)
			                             AND (A.Kd_Rek_2 = 1)
			                             AND (A.Kd_Rek_3 = 1)
			                             AND (A.Kd_Rek_4 = 2)
			                             AND (A.Kd_Rek_5 = 1)
			                           GROUP BY A.Tahun, A.No_Bukti
			                       ) C ON B.Tahun = C.Tahun AND B.No_Bukti = C.No_Bukti
			                           INNER JOIN
			                       Ref_Rek_5 D
			                       ON A.Kd_Rek_1 = D.Kd_Rek_1 AND A.Kd_Rek_2 = D.Kd_Rek_2 AND A.Kd_Rek_3 = D.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = D.Kd_Rek_4 AND A.Kd_Rek_5 = D.Kd_Rek_5
			                  WHERE (NOT ((A.D_K = 'D') AND (A.Kd_Rek_1 = 1) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND
			                              (A.Kd_Rek_4 = 2) AND (A.Kd_Rek_5 = 1)))
			                    AND (B.Tgl_Bukti < '$d1')
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (B.Kd_SKPD = '1')
			
			                  UNION ALL
			
			                  SELECT SUM(CASE A.D_K
			                                 WHEN 'K' THEN A.Nilai
			                                 ELSE 0
			                      END)        AS Debet,
			                         SUM(CASE A.D_K
			                                 WHEN 'D' THEN A.Nilai
			                                 ELSE 0
			                             END) AS Kredit
			                  FROM Ta_Jurnal_Rinc A
			                           INNER JOIN
			                       Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                           INNER JOIN
			                       (
			                           SELECT A.Tahun, A.No_Bukti
			                           FROM Ta_Jurnal_Rinc A
			                           WHERE (A.D_K = 'K')
			                             AND (A.Kd_Rek_1 = 1)
			                             AND (A.Kd_Rek_2 = 1)
			                             AND (A.Kd_Rek_3 = 1)
			                             AND (A.Kd_Rek_4 = 2)
			                             AND (A.Kd_Rek_5 = 1)
			                           GROUP BY A.Tahun, A.No_Bukti
			                       ) C ON B.Tahun = C.Tahun AND B.No_Bukti = C.No_Bukti
			                           INNER JOIN
			                       Ref_Rek_5 D
			                       ON A.Kd_Rek_1 = D.Kd_Rek_1 AND A.Kd_Rek_2 = D.Kd_Rek_2 AND A.Kd_Rek_3 = D.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = D.Kd_Rek_4 AND A.Kd_Rek_5 = D.Kd_Rek_5
			                  WHERE (NOT ((A.D_K = 'K') AND (A.Kd_Rek_1 = 1) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND
			                              (A.Kd_Rek_4 = 2) AND (A.Kd_Rek_5 = 1)))
			                    AND (B.Tgl_Bukti < '$d1')
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (B.Kd_SKPD = '1')
			              ) A
			
			         UNION ALL
			
			         SELECT A.Tgl_Bukti,
			                A.Kode,
			                A.No_Bukti,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' +
			                CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' +
			                RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_5_Gab,
			                A.Nm_Rek_5,
			                A.Debet,
			                A.Kredit
			         FROM (
			                  SELECT B.Tgl_Bukti,
			                         2            AS Kode,
			                         B.No_Bukti,
			                         A.Kd_Rek_1,
			                         A.Kd_Rek_2,
			                         A.Kd_Rek_3,
			                         A.Kd_Rek_4,
			                         A.Kd_Rek_5,
			                         C.Nm_Rek_5,
			                         SUM(A.Nilai) AS Debet,
			                         0            AS Kredit
			                  FROM Ta_Bukti_Penerimaan_Rinc A
			                           INNER JOIN
			                       Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                           INNER JOIN
			                       Ref_Rek_5 C
			                       ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5
			                  WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			                    AND (B.Tahun = '$tahun')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5,
			                           C.Nm_Rek_5
			
			                  UNION ALL
			
			                  SELECT B.Tgl_STS,
			                         2            AS Kode,
			                         B.No_STS,
			                         A.Kd_Rek_1,
			                         A.Kd_Rek_2,
			                         A.Kd_Rek_3,
			                         A.Kd_Rek_4,
			                         A.Kd_Rek_5,
			                         C.Nm_Rek_5,
			                         0            AS Debet,
			                         SUM(A.Nilai) AS Kredit
			                  FROM Ta_STS_Rinc A
			                           INNER JOIN
			                       Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			                           INNER JOIN
			                       Ref_Rek_5 C
			                       ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5
			                  WHERE (B.Kd_SKPD = 1)
			                    AND (B.Tgl_STS BETWEEN '$d1' AND '$d2')
			                    AND (B.Tahun = '$tahun')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY B.Tgl_STS, B.No_STS, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, C.Nm_Rek_5
			
			                  UNION ALL
			
			                  SELECT B.Tgl_Bukti,
			                         2                                                              AS Kode,
			                         B.No_Bukti,
			                         A.Kd_Rek_1,
			                         A.Kd_Rek_2,
			                         A.Kd_Rek_3,
			                         A.Kd_Rek_4,
			                         A.Kd_Rek_5,
			                         C.Nm_Rek_5,
			                         SUM(CASE A.D_K
			                                 WHEN 'D' THEN A.Nilai
			                                 ELSE CASE B.Jn_SPM WHEN 3 THEN A.Nilai ELSE 0 END END) AS Debet,
			                         SUM(CASE A.D_K
			                                 WHEN 'K' THEN A.Nilai
			                                 ELSE CASE B.Jn_SPM WHEN 3 THEN A.Nilai ELSE 0 END END) AS Kredit
			                  FROM Ta_Penyesuaian_Rinc A
			                           INNER JOIN
			                       Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                           INNER JOIN
			                       Ref_Rek_5 C
			                       ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5
			                  WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			                    AND (B.Tahun = '$tahun')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			                    AND (B.Jns_P1 = 2)
			                    AND ((B.Jns_P2 = 1) OR (B.Jn_SPM IN (1, 3)))
			
			                  GROUP BY B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5,
			                           C.Nm_Rek_5
			
			                  UNION ALL
			
			                  SELECT B.Tgl_Bukti,
			                         2        AS Kode,
			                         B.No_Bukti,
			                         A.Kd_Rek_1,
			                         A.Kd_Rek_2,
			                         A.Kd_Rek_3,
			                         A.Kd_Rek_4,
			                         A.Kd_Rek_5,
			                         D.Nm_Rek_5,
			                         SUM(CASE A.D_K
			                                 WHEN 'K' THEN A.Nilai
			                                 ELSE 0
			                             END) AS Debet,
			                         SUM(CASE A.D_K
			                                 WHEN 'D' THEN A.Nilai
			                                 ELSE 0
			                             END) AS Kredit
			                  FROM Ta_Jurnal_Rinc A
			                           INNER JOIN
			                       Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                           INNER JOIN
			                       (
			                           SELECT A.Tahun, A.No_Bukti
			                           FROM Ta_Jurnal_Rinc A
			                           WHERE (A.D_K = 'D')
			                             AND (A.Kd_Rek_1 = 1)
			                             AND (A.Kd_Rek_2 = 1)
			                             AND (A.Kd_Rek_3 = 1)
			                             AND (A.Kd_Rek_4 = 2)
			                             AND (A.Kd_Rek_5 = 1)
			                           GROUP BY A.Tahun, A.No_Bukti
			                       ) C ON B.Tahun = C.Tahun AND B.No_Bukti = C.No_Bukti
			                           INNER JOIN
			                       Ref_Rek_5 D
			                       ON A.Kd_Rek_1 = D.Kd_Rek_1 AND A.Kd_Rek_2 = D.Kd_Rek_2 AND A.Kd_Rek_3 = D.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = D.Kd_Rek_4 AND A.Kd_Rek_5 = D.Kd_Rek_5
			                  WHERE (NOT ((A.D_K = 'D') AND (A.Kd_Rek_1 = 1) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND
			                              (A.Kd_Rek_4 = 2) AND (A.Kd_Rek_5 = 1)))
			                    AND (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (B.Kd_SKPD = '1')
			                  GROUP BY B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5,
			                           D.Nm_Rek_5
			
			                  UNION ALL
			
			                  SELECT B.Tgl_Bukti,
			                         2        AS Kode,
			                         B.No_Bukti,
			                         A.Kd_Rek_1,
			                         A.Kd_Rek_2,
			                         A.Kd_Rek_3,
			                         A.Kd_Rek_4,
			                         A.Kd_Rek_5,
			                         D.Nm_Rek_5,
			                         SUM(CASE A.D_K
			                                 WHEN 'K' THEN A.Nilai
			                                 ELSE 0
			                             END) AS Debet,
			                         SUM(CASE A.D_K
			                                 WHEN 'D' THEN A.Nilai
			                                 ELSE 0
			                             END) AS Kredit
			                  FROM Ta_Jurnal_Rinc A
			                           INNER JOIN
			                       Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                           INNER JOIN
			                       (
			                           SELECT A.Tahun, A.No_Bukti
			                           FROM Ta_Jurnal_Rinc A
			                           WHERE (A.D_K = 'K')
			                             AND (A.Kd_Rek_1 = 1)
			                             AND (A.Kd_Rek_2 = 1)
			                             AND (A.Kd_Rek_3 = 1)
			                             AND (A.Kd_Rek_4 = 2)
			                             AND (A.Kd_Rek_5 = 1)
			                           GROUP BY A.Tahun, A.No_Bukti
			                       ) C ON B.Tahun = C.Tahun AND B.No_Bukti = C.No_Bukti
			                           INNER JOIN
			                       Ref_Rek_5 D
			                       ON A.Kd_Rek_1 = D.Kd_Rek_1 AND A.Kd_Rek_2 = D.Kd_Rek_2 AND A.Kd_Rek_3 = D.Kd_Rek_3 AND
			                          A.Kd_Rek_4 = D.Kd_Rek_4 AND A.Kd_Rek_5 = D.Kd_Rek_5
			                  WHERE (NOT ((A.D_K = 'K') AND (A.Kd_Rek_1 = 1) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND
			                              (A.Kd_Rek_4 = 2) AND (A.Kd_Rek_5 = 1)))
			                    AND (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (B.Kd_SKPD = '1')
			                  GROUP BY B.Tgl_Bukti, B.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5,
			                           D.Nm_Rek_5
			              ) A
			     ) A,
			     (
			         SELECT '$kd_urusan'                                                                         AS Kd_UrusanA,
			                '$kd_bidang'                                                                         AS Kd_BidangA,
			                '$kd_unit'                                                                           AS Kd_UnitA,
			                '$kd_sub'                                                                            AS Kd_SubA,
			                '$kd_urusan'                                                                         AS Kd_Urusan_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2)                                    AS Kd_Bidang_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2)                                                            AS Kd_Sub_Gab,
			                E.Nm_Urusan                                                                        AS Nm_Urusan_Gab,
			                D.Nm_Bidang                                                                        AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                          AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                      AS Nm_Sub_Unit_Gab,
			                A.Nm_Pimpinan                                                                      AS Nm_Pimpinan,
			                A.Nip_Pimpinan                                                                     AS Nip_Pimpinan,
			                A.Jbt_Pimpinan                                                                     AS Jbt_Pimpinan,
			                G.Nm_Bendahara,
			                G.Nip_Bendahara,
			                G.Jbt_Bendahara
			         FROM Ta_Sub_Unit A
			                  INNER JOIN
			              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND
			                                A.Kd_Sub = B.Kd_Sub
			                  INNER JOIN
			              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
			                  INNER JOIN
			              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
			                  INNER JOIN
			              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
			                  INNER JOIN
			              (
			                  SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			                  FROM Ta_Sub_Unit A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
			                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
			                  LEFT OUTER JOIN
			              (
			                  SELECT Tahun,
			                         Kd_Urusan,
			                         Kd_Bidang,
			                         Kd_Unit,
			                         Kd_Sub,
			                         MIN(Nama)    AS Nm_Bendahara,
			                         MIN(Nip)     AS Nip_Bendahara,
			                         MIN(Jabatan) AS Jbt_Bendahara
			                  FROM Ta_Sub_Unit_Jab A
			                  WHERE (A.Kd_Jab = 3)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
			                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			     ) B
			ORDER BY A.Kode DESC, A.Tanggal, A.No_Bukti, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function register_sts($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
		$kd_skpd									= '1';

		$data_query								    = $this->query
		("
			SELECT D.Kd_Urusan_Gab,
			       D.Kd_Bidang_Gab,
			       D.Kd_Unit_Gab,
			       D.Kd_Sub_Gab,
			       D.Kd_UrusanA,
			       D.Kd_BidangA,
			       D.Kd_UnitA,
			       D.Kd_SubA,
			       D.Nm_Urusan_Gab,
			       D.Nm_Bidang_Gab,
			       D.Nm_Unit_Gab,
			       D.Nm_Sub_Unit_Gab,
			       A.Tgl_STS,
			       A.No_STS,
			       A.Keterangan,
			       A.Nilai_STS
			FROM (
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                B.No_STS,
			                B.Tgl_STS,
			                B.Keterangan,
			                SUM(A.Nilai) AS Nilai_STS
			         FROM Ta_STS_Rinc A
			                  INNER JOIN
			              Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			         WHERE (B.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (B.Tgl_STS BETWEEN '$d1' AND '$d2')
			           AND (B.Kd_SKPD = '$kd_skpd')
			         GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub,
			                  B.No_STS, B.Tgl_STS, B.Keterangan
			     ) A,
			     (
			         SELECT '$kd_urusan'                                                                         AS Kd_UrusanA,
			                '$kd_bidang'                                                                         AS Kd_BidangA,
			                '$kd_unit'                                                                           AS Kd_UnitA,
			                '$kd_sub'                                                                            AS Kd_SubA,
			                '$kd_urusan'                                                                         AS Kd_Urusan_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2)                                    AS Kd_Bidang_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2)                                                            AS Kd_Sub_Gab,
			                E.Nm_Urusan                                                                        AS Nm_Urusan_Gab,
			                D.Nm_Bidang                                                                        AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                          AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                      AS Nm_Sub_Unit_Gab
			         FROM Ta_Sub_Unit A
			                  INNER JOIN
			              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND
			                                A.Kd_Sub = B.Kd_Sub
			                  INNER JOIN
			              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
			                  INNER JOIN
			              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
			                  INNER JOIN
			              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
			                  INNER JOIN
			              (
			                  SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			                  FROM Ta_Sub_Unit A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
			                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
			     ) D
			ORDER BY A.Tgl_STS, A.No_STS, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function reg_tanda_bukti($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$data_query								    = $this->query
		("
			SELECT D.Kd_Urusan_Gab,
		       D.Kd_Bidang_Gab,
		       D.Kd_Unit_Gab,
		       D.Kd_Sub_Gab,
		       D.Kd_UrusanA,
		       D.Kd_BidangA,
		       D.Kd_UnitA,
		       D.Kd_SubA,
		       D.Nm_Urusan_Gab,
		       D.Nm_Bidang_Gab,
		       D.Nm_Unit_Gab,
		       D.Nm_Sub_Unit_Gab,
		       A.Tgl_Bukti,
		       A.No_Bukti,
		       D.Nm_Pimpinan,
		       D.Nip_Pimpinan,
		       D.Jbt_Pimpinan,
		       A.Uraian,
		       A.Nilai_Bukti
		FROM (
		         SELECT A.Tahun,
		                B.Kd_Urusan,
		                B.Kd_Bidang,
		                B.Kd_Unit,
		                B.Kd_Sub,
		                B.No_Bukti,
		                B.Tgl_Bukti,
		                B.Uraian,
		                SUM(A.Nilai) AS Nilai_Bukti
		         FROM Ta_Bukti_Penerimaan_Rinc A
		                  INNER JOIN
		              Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
		         WHERE (B.Tahun = '$tahun')
		           AND (B.Kd_Urusan LIKE '$kd_urusan')
		           AND (B.Kd_Bidang LIKE '$kd_bidang')
		           AND (B.Kd_Unit LIKE '$kd_unit')
		           AND (B.Kd_Sub LIKE '$kd_sub')
		           AND (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
		         GROUP BY A.Tahun, B.Kd_Urusan, B.Kd_Bidang, B.Kd_Unit, B.Kd_Sub,
		                  B.No_Bukti, B.Tgl_Bukti, B.Uraian
		     ) A,
		     (
		         SELECT '$kd_urusan'                                                                         AS Kd_UrusanA,
		                '$kd_bidang'                                                                         AS Kd_BidangA,
		                '$kd_unit'                                                                           AS Kd_UnitA,
		                '$kd_sub'                                                                            AS Kd_SubA,
		                '$kd_urusan'                                                                         AS Kd_Urusan_Gab,
		                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2)                                    AS Kd_Bidang_Gab,
		                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
		                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
		                RIGHT('0' + '$kd_sub', 2)                                                            AS Kd_Sub_Gab,
		                E.Nm_Urusan                                                                        AS Nm_Urusan_Gab,
		                D.Nm_Bidang                                                                        AS Nm_Bidang_Gab,
		                C.Nm_Unit                                                                          AS Nm_Unit_Gab,
		                B.Nm_Sub_Unit                                                                      AS Nm_Sub_Unit_Gab,
		                A.Nm_Pimpinan                                                                      AS Nm_Pimpinan,
		                A.Nip_Pimpinan                                                                     AS Nip_Pimpinan,
		                A.Jbt_Pimpinan                                                                     AS Jbt_Pimpinan
		         FROM Ta_Sub_Unit A
		                  INNER JOIN
		              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND
		                                A.Kd_Sub = B.Kd_Sub
		                  INNER JOIN
		              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
		                  INNER JOIN
		              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
		                  INNER JOIN
		              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
		                  INNER JOIN
		              (
		                  SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
		                  FROM Ta_Sub_Unit A
		                  WHERE (A.Tahun = '$tahun')
		                    AND (A.Kd_Urusan LIKE '$kd_urusan')
		                    AND (A.Kd_Bidang LIKE '$kd_bidang')
		                    AND (A.Kd_Unit LIKE '$kd_unit')
		                    AND (A.Kd_Sub LIKE '$kd_sub')
		                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
		              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
		                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
		     ) D
		ORDER BY A.Tgl_Bukti, A.No_Bukti, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function reg_ketetapan_pendapatan($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$data_query								    = $this->query
		("
			SELECT D.Kd_Urusan_Gab,
			       D.Kd_Bidang_Gab,
			       D.Kd_Unit_Gab,
			       D.Kd_Sub_Gab,
			       D.Kd_UrusanA,
			       D.Kd_BidangA,
			       D.Kd_UnitA,
			       D.Kd_SubA,
			       D.Nm_Urusan_Gab,
			       D.Nm_Bidang_Gab,
			       D.Nm_Unit_Gab,
			       D.Nm_Sub_Unit_Gab,
			       A.Tgl_SKP,
			       A.No_SKP,
			       D.Nm_Pimpinan,
			       D.Nip_Pimpinan,
			       D.Jbt_Pimpinan,
			       A.Keterangan,
			       A.Nilai_Bukti
			FROM (
			         SELECT A.Tahun,
			                B.Kd_Urusan,
			                B.Kd_Bidang,
			                B.Kd_Unit,
			                B.Kd_Sub,
			                B.No_SKP,
			                B.Tgl_SKP,
			                B.Keterangan,
			                SUM(A.Nilai) AS Nilai_Bukti
			         FROM Ta_SKP_Rinc A
			                  INNER JOIN
			              Ta_SKP B ON A.Tahun = B.Tahun AND A.No_SKP = B.No_SKP
			         WHERE (B.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (B.Tgl_SKP BETWEEN '$d1' AND '$d2')
			         GROUP BY A.Tahun, B.Kd_Urusan, B.Kd_Bidang, B.Kd_Unit, B.Kd_Sub,
			                  B.No_SKP, B.Tgl_SKP, B.Keterangan
			     ) A,
			     (
			         SELECT '$kd_urusan'                                                                         AS Kd_UrusanA,
			                '$kd_bidang'                                                                         AS Kd_BidangA,
			                '$kd_unit'                                                                           AS Kd_UnitA,
			                '$kd_sub'                                                                            AS Kd_SubA,
			                '$kd_urusan'                                                                         AS Kd_Urusan_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2)                                    AS Kd_Bidang_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2)                                                            AS Kd_Sub_Gab,
			                E.Nm_Urusan                                                                        AS Nm_Urusan_Gab,
			                D.Nm_Bidang                                                                        AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                          AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                      AS Nm_Sub_Unit_Gab,
			                A.Nm_Pimpinan                                                                      AS Nm_Pimpinan,
			                A.Nip_Pimpinan                                                                     AS Nip_Pimpinan,
			                A.Jbt_Pimpinan                                                                     AS Jbt_Pimpinan
			         FROM Ta_Sub_Unit A
			                  INNER JOIN
			              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND
			                                A.Kd_Sub = B.Kd_Sub
			                  INNER JOIN
			              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
			                  INNER JOIN
			              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
			                  INNER JOIN
			              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
			                  INNER JOIN
			              (
			                  SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			                  FROM Ta_Sub_Unit A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
			                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
			     ) D
			ORDER BY A.Tgl_SKP, A.No_SKP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function bku_pendapatan_harian($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$tmpSPJ								        =
		("
			SELECT A.Kd_Rek_1,
			       A.Kd_Rek_2,
			       A.Kd_Rek_3,
			       A.Kd_Rek_4,
			       A.Kd_Rek_5,
			       SUM(A.Anggaran) AS Anggaran,
			       SUM(A.Terima_Lalu) AS Terima_Lalu,
			       SUM(A.Setor_Lalu) AS Setor_Lalu,
			       SUM(A.Terima_Ini) AS Terima_Ini,
			       SUM(A.Setor_Ini) AS Setor_Ini
			FROM (
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Total AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_RASK_Arsip A
			         WHERE (A.Kd_Rek_1 = 4)
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Perubahan = (SELECT MAX(Kd_Perubahan)
			                                  FROM Ta_RASK_Arsip_Perubahan
			                                  WHERE Kd_Perubahan IN (4, 6, 8)
			                                    AND Tahun = '$tahun'
			                                    AND Tgl_Perda <= '$d2'))
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                A.Nilai AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Bukti_Penerimaan_Rinc A
			                  INNER JOIN
			              Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti < '$d1')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0                                             AS Anggaran,
			                CASE B.Kd_SKPD WHEN 1 THEN 0 ELSE A.Nilai END AS Terima_Lalu,
			                A.Nilai                                       AS Setor_Lalu,
			                0                                             AS Terima_Ini,
			                0                                             AS Setor_Ini
			         FROM Ta_STS_Rinc A
			                  INNER JOIN
			              Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			         WHERE (B.Tgl_STS < '$d1')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                A.Nilai AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Bukti_Penerimaan_Rinc A
			                  INNER JOIN
			              Ta_Bukti_Penerimaan B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0                                             AS Anggaran,
			                0                                             AS Terima_Lalu,
			                0                                             AS Setor_Lalu,
			                CASE B.Kd_SKPD WHEN 1 THEN 0 ELSE A.Nilai END AS Terima_Ini,
			                A.Nilai                                       AS Setor_Ini
			         FROM Ta_STS_Rinc A
			                  INNER JOIN
			              Ta_STS B ON A.Tahun = B.Tahun AND A.No_STS = B.No_STS
			         WHERE (B.Tgl_STS BETWEEN '$d1' AND '$d2')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (1, 3)) OR ((B.Jn_SPM = 2) AND (B.Kd_SKPD = 2)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Terima_Lalu,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (2, 3)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti < '$d1')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (B.Jns_P1 = 2)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (1, 3)) OR ((B.Jn_SPM = 2) AND (B.Kd_SKPD = 2)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Terima_Ini,
			                CASE
			                    WHEN (B.Jns_P2 = 1) OR (B.Jn_SPM IN (2, 3)) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN -A.Nilai
			                            ELSE A.Nilai
			                            END
			                    ELSE 0
			                    END AS Setor_Ini
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (B.Jns_P1 = 2)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Terima_Lalu,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Setor_Lalu,
			                0       AS Terima_Ini,
			                0       AS Setor_Ini
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti < '$d1')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Rek_1 = 4)
			           AND (B.No_BKU <> 9999)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0       AS Anggaran,
			                0       AS Terima_Lalu,
			                0       AS Setor_Lalu,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Terima_Ini,
			                CASE A.D_K
			                    WHEN 'D' THEN -A.Nilai
			                    ELSE A.Nilai
			                    END AS Setor_Ini
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			           AND (A.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Rek_1 = 4)
			           AND (B.No_BKU <> 9999)
			     ) A
			GROUP BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		");

		$data_query								    = $this->query
		("
			SELECT C.Kd_UrusanA,
			       C.Kd_BidangA,
			       C.Kd_UnitA,
			       C.Kd_SubA,
			       C.Kd_UrusanB,
			       C.Kd_BidangB,
			       C.Kd_UnitB,
			       C.Kd_SubB,
			       C.Kd_Urusan_Gab,
			       C.Kd_Bidang_Gab,
			       C.Kd_Unit_Gab,
			       C.Kd_Sub_Gab,
			       C.Nm_Urusan_Gab,
			       C.Nm_Bidang_Gab,
			       C.Nm_Unit_Gab,
			       C.Nm_Sub_Unit_Gab,
			       B.Nm_Rek_5,
			       CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) +
			       ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' +
			       RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2)                    AS Kd_Rek_5_Gab,
			       A.Anggaran,
			       A.Terima_Lalu,
			       A.Setor_Lalu,
			       (A.Setor_Lalu - A.Terima_Lalu)                                  AS Sisa_Lalu,
			       A.Terima_Ini,
			       A.Setor_Ini,
			       (A.Setor_Ini - A.Terima_Ini)                                    AS Sisa_Ini,
			       (A.Terima_Lalu + A.Terima_Ini)                                  AS Tot_Terima,
			       (A.Setor_Lalu + A.Setor_Ini)                                    AS Tot_Setor,
			       ((A.Setor_Lalu + A.Setor_Ini) - (A.Terima_Lalu + A.Terima_Ini)) AS Tot_Sisa,
			       (A.Anggaran - (A.Terima_Lalu + A.Terima_Ini))                   AS Sisa_Anggaran,
			       C.Nm_Pimpinan,
			       C.Nip_Pimpinan,
			       C.Jbt_Pimpinan,
			       C.Nm_Bendahara,
			       C.Nip_Bendahara,
			       C.Jbt_Bendahara
			FROM ($tmpSPJ) AS A
			         INNER JOIN
			     Ref_Rek_5 B
			     ON A.Kd_Rek_1 = B.Kd_Rek_1 AND A.Kd_Rek_2 = B.Kd_Rek_2 AND A.Kd_Rek_3 = B.Kd_Rek_3 AND A.Kd_Rek_4 = B.Kd_Rek_4 AND
			        A.Kd_Rek_5 = B.Kd_Rek_5,
			     (
			         SELECT 1                                                                                  AS Kode,
			                '$kd_urusan'                                                                         AS Kd_UrusanA,
			                '$kd_bidang'                                                                         AS Kd_BidangA,
			                '$kd_unit'                                                                           AS Kd_UnitA,
			                '$kd_sub'                                                                            AS Kd_SubA,
			                CASE '$kd_urusan'
			                    WHEN '%' THEN '0'
			                    ELSE '$kd_urusan'
			                    END                                                                            AS Kd_UrusanB,
			                CASE '$kd_bidang'
			                    WHEN '%' THEN '00'
			                    ELSE RIGHT('0' + '$kd_bidang', 2)
			                    END                                                                            AS Kd_BidangB,
			                CASE '$kd_unit'
			                    WHEN '%' THEN '00'
			                    ELSE RIGHT('0' + '$kd_unit', 2)
			                    END                                                                            AS Kd_UnitB,
			                CASE '$kd_sub'
			                    WHEN '%' THEN '00'
			                    ELSE RIGHT('0' + '$kd_sub', 2)
			                    END                                                                            AS Kd_SubB,
			                '$kd_urusan'                                                                         AS Kd_Urusan_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2)                                    AS Kd_Bidang_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
			                '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2)                                                            AS Kd_Sub_Gab,
			                E.Nm_Urusan                                                                        AS Nm_Urusan_Gab,
			                D.Nm_Bidang                                                                        AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                          AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                      AS Nm_Sub_Unit_Gab,
			                A.Nm_Pimpinan                                                                      AS Nm_Pimpinan,
			                A.Nip_Pimpinan                                                                     AS Nip_Pimpinan,
			                A.Jbt_Pimpinan                                                                     AS Jbt_Pimpinan,
			                G.Nm_Bendahara,
			                G.Nip_Bendahara,
			                G.Jbt_Bendahara
			         FROM Ta_Sub_Unit A
			                  INNER JOIN
			              Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND
			                                A.Kd_Sub = B.Kd_Sub
			                  INNER JOIN
			              Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit
			                  INNER JOIN
			              Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang
			                  INNER JOIN
			              Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
			                  INNER JOIN
			              (
			                  SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			                  FROM Ta_Sub_Unit A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND
			                     A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub
			                  LEFT OUTER JOIN
			              (
			                  SELECT Tahun,
			                         Kd_Urusan,
			                         Kd_Bidang,
			                         Kd_Unit,
			                         Kd_Sub,
			                         MIN(Nama)    AS Nm_Bendahara,
			                         MIN(Nip)     AS Nip_Bendahara,
			                         MIN(Jabatan) AS Jbt_Bendahara
			                  FROM Ta_Sub_Unit_Jab A
			                  WHERE (A.Kd_Jab = 3)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
			                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			     ) C
			ORDER BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

}
