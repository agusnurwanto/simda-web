<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Pengeluaran
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pengeluaran extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Pengeluaran
	 */
	public function buku_pajak($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		//$cms                                        = 'false';
		$cms								        = $this->query
		('
			SELECT
				CMS2
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $params['tahun'] . '
		')
			->row('CMS2');

		$blu_query								    = $this->query
		("
			SELECT
				Kd_Urusan
			FROM
				Ref_BLU
			WHERE
				Jenis = 4 AND
				Kd_Urusan = '$kd_urusan ' AND
				Kd_Bidang = '$kd_bidang ' AND
				Kd_Unit = '$kd_unit ' AND
				Kd_Sub = '$kd_sub'
		")
			->row();

		if(!$blu_query)
		{
			$data_query								= $this->query
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
				   CASE LEN(CONVERT(varchar, A.Kd_Prog))
				       WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
				       ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' + CASE LEN(CONVERT(varchar, A.Kd_Keg))
				                                                                        WHEN 3 THEN CONVERT(varchar, A.Kd_Keg)
				                                                                        ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Gab_Keg,
				   A.Tanggal,
				   A.No_Bukti,
				   A.Keterangan,
				   A.Debet,
				   A.Kredit,
				   (A.Debet - A.Kredit)                                                                                                     AS Saldo,
				   B.Nm_Pimpinan,
				   B.Nip_Pimpinan,
				   B.Jbt_Pimpinan,
				   B.Nm_Bendahara,
				   B.Nip_Bendahara,
				   B.Jbt_Bendahara
				FROM (
				     SELECT $d1 - 1      AS Tanggal,
				            ''           AS No_Bukti,
				            'Saldo Awal' AS Keterangan,
				            CASE
				                WHEN A.Debet > A.Kredit THEN A.Debet - A.Kredit
				                ELSE 0
				                END      AS Debet,
				            CASE
				                WHEN A.Debet > A.Kredit THEN 0
				                ELSE A.Kredit - A.Debet
				                END      AS Kredit,
				            0            AS Kd_Prog,
				            0            AS Kd_Keg
				     FROM (
				              SELECT 0 AS Debet, ISNULL(SUM(A.Nilai), 0) AS Kredit
				              FROM Ta_Pajak_Rinc A
				                       INNER JOIN
				                   Ta_Pajak B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
				              WHERE (B.Tgl_Bukti < '$d1')
				                AND (B.Kd_Urusan LIKE '$kd_urusan')
				                AND (B.Kd_Bidang LIKE '$kd_bidang')
				                AND (B.Kd_Unit LIKE '$kd_unit')
				                AND (B.Kd_Sub LIKE '$kd_sub')
				
				              UNION ALL
				
				              SELECT ISNULL(SUM(A.Nilai), 0)                                                   AS Debet,
				                     ISNULL(SUM(CASE WHEN '$cms' = 1 AND B.Cair = 1 THEN A.Nilai ELSE 0 END), 0) AS Kredit
				              FROM Ta_SPJ_Pot A
				                       INNER JOIN
				                   Ta_SPJ_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
				              WHERE (B.Tgl_Bukti < '$d1')
				                AND (B.Kd_Urusan LIKE '$kd_urusan')
				                AND (B.Kd_Bidang LIKE '$kd_bidang')
				                AND (B.Kd_Unit LIKE '$kd_unit')
				                AND (B.Kd_Sub LIKE '$kd_sub')
				          ) A
				
				     UNION ALL
				
				     SELECT B.Tgl_Bukti,
				            B.No_Bukti,
				            B.Keterangan,
				            0            AS Debet,
				            SUM(A.Nilai) AS Kredit,
				            B.Kd_Prog,
				            B.Kd_Keg
				     FROM Ta_Pajak_Rinc A
				              INNER JOIN
				          Ta_Pajak B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
				     WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
				       AND (B.Tahun = '$tahun')
				       AND (B.Kd_Urusan LIKE '$kd_urusan')
				       AND (B.Kd_Bidang LIKE '$kd_bidang')
				       AND (B.Kd_Unit LIKE '$kd_unit')
				       AND (B.Kd_Sub LIKE '$kd_sub')
				     GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Keterangan, B.Kd_Prog, B.Kd_Keg
				
				     UNION ALL
				
				     SELECT B.Tgl_Bukti,
				            B.No_Bukti,
				            B.Uraian,
				            SUM(A.Nilai)                                                   AS Debet,
				            SUM(CASE WHEN '$cms' = 1 AND B.Cair = 1 THEN A.Nilai ELSE 0 END) AS Kredit,
				            B.Kd_Prog,
				            B.Kd_Keg
				     FROM Ta_SPJ_Pot A
				              INNER JOIN
				          Ta_SPJ_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
				     WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
				       AND (B.Tahun = '$tahun')
				       AND (B.Kd_Urusan LIKE '$kd_urusan')
				       AND (B.Kd_Bidang LIKE '$kd_bidang')
				       AND (B.Kd_Unit LIKE '$kd_unit')
				       AND (B.Kd_Sub LIKE '$kd_sub')
				     GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Uraian, B.Kd_Prog, B.Kd_Keg
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
				              WHERE (A.Kd_Jab = 4)
				                AND (A.Tahun = '$tahun')
				                AND (A.Kd_Urusan LIKE '$kd_urusan')
				                AND (A.Kd_Bidang LIKE '$kd_bidang')
				                AND (A.Kd_Unit LIKE '$kd_unit')
				                AND (A.Kd_Sub LIKE '$kd_sub')
				              GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
				          ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
				                 F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
				 ) B
				ORDER BY A.Tanggal, A.No_Bukti
			")
				->result();
		}
		else
		{
			$data_query = $this->query
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
			       CASE LEN(CONVERT(varchar, A.Kd_Prog))
			           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
			           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' + CASE LEN(CONVERT(varchar, A.Kd_Keg))
			                                                                            WHEN 3 THEN CONVERT(varchar, A.Kd_Keg)
			                                                                            ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Gab_Keg,
			       A.Tanggal,
			       A.No_Bukti,
			       A.Keterangan,
			       A.Debet,
			       A.Kredit,
			       (A.Debet - A.Kredit)                                                                                                     AS Saldo,
			       B.Nm_Pimpinan,
			       B.Nip_Pimpinan,
			       B.Jbt_Pimpinan,
			       B.Nm_Bendahara,
			       B.Nip_Bendahara,
			       B.Jbt_Bendahara
			FROM (
			         SELECT $d1 - 1      AS Tanggal,
			                ''           AS No_Bukti,
			                'Saldo Awal' AS Keterangan,
			                CASE
			                    WHEN A.Debet > A.Kredit THEN A.Debet - A.Kredit
			                    ELSE 0
			                    END      AS Debet,
			                CASE
			                    WHEN A.Debet > A.Kredit THEN 0
			                    ELSE A.Kredit - A.Debet
			                    END      AS Kredit,
			                0            AS Kd_Prog,
			                0            AS Kd_Keg
			         FROM (
			                  SELECT 0 AS Debet, ISNULL(SUM(A.Nilai), 0) AS Kredit
			                  FROM Ta_PajakC_Rinc A
			                           INNER JOIN
			                       Ta_PajakC B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                  WHERE (B.Tgl_Bukti < '$d1')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			
			                  UNION ALL
			
			                  SELECT ISNULL(SUM(A.Nilai), 0) AS Debet, 0 AS Kredit
			                  FROM Ta_SPJC_Pot A
			                           INNER JOIN
			                       Ta_SPJC_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			                  WHERE (B.Tgl_Bukti < '$d1')
			                    AND (B.Kd_Urusan LIKE '$kd_urusan')
			                    AND (B.Kd_Bidang LIKE '$kd_bidang')
			                    AND (B.Kd_Unit LIKE '$kd_unit')
			                    AND (B.Kd_Sub LIKE '$kd_sub')
			              ) A
			
			         UNION ALL
			
			         SELECT B.Tgl_Bukti,
			                B.No_Bukti,
			                B.Keterangan,
			                0            AS Debet,
			                SUM(A.Nilai) AS Kredit,
			                B.Kd_Prog,
			                B.Kd_Keg
			         FROM Ta_PajakC_Rinc A
			                  INNER JOIN
			              Ta_PajakC B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			           AND (B.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			         GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Keterangan, B.Kd_Prog, B.Kd_Keg
			
			         UNION ALL
			
			         SELECT B.Tgl_Bukti,
			                B.No_Bukti,
			                B.Uraian,
			                SUM(A.Nilai) AS Debet,
			                0            AS Kredit,
			                B.Kd_Prog,
			                B.Kd_Keg
			         FROM Ta_SPJC_Pot A
			                  INNER JOIN
			              Ta_SPJC_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (B.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			           AND (B.Tahun = '$tahun')
			           AND (B.Kd_Urusan LIKE '$kd_urusan')
			           AND (B.Kd_Bidang LIKE '$kd_bidang')
			           AND (B.Kd_Unit LIKE '$kd_unit')
			           AND (B.Kd_Sub LIKE '$kd_sub')
			         GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Uraian, B.Kd_Prog, B.Kd_Keg
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
			                  WHERE (A.Kd_Jab = 4)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
			                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			     ) B
			ORDER BY A.Tanggal, A.No_Bukti
			")
				->result();
		}

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	// lewat query
	public function buku_pajak_per_jenis($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$d1										    = $params['kd_sub'];
		$d2										    = $params['kd_sub'];

		$cms2_query								    = $this->query
		('
			SELECT
				CMS2
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $params['tahun'] . '
		')
			->row();

		$blu_query								    = $this->query
		("
			SELECT
				Kd_Urusan
			FROM
				Ref_BLU
			WHERE
				Jenis = 4 AND
				Kd_Urusan = '$kd_urusan ' AND
				Kd_Bidang = '$kd_bidang ' AND
				Kd_Unit = '$kd_unit ' AND
				Kd_Sub = '$kd_sub'
		")
			->row();

		if(!empty($blu_query))
		{
			$data_query								= $this->query
			("
            SELECT B.Kd_UrusanA, B.Kd_BidangA, B.Kd_UnitA, B.Kd_SubA,
                   B.Kd_Urusan_Gab, B.Kd_Bidang_Gab, B.Kd_Unit_Gab, B.Kd_Sub_Gab,
                   B.Nm_Urusan_Gab, B.Nm_Bidang_Gab, B.Nm_Unit_Gab, B.Nm_Sub_Unit_Gab,
                   CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' + CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Gab_Keg,
                   A.Tanggal, A.No_Bukti, A.Keterangan, A.Debet, A.Kredit, (A.Debet - A.Kredit) AS Saldo,
                   A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                   A.Kd_Pot AS Kd_Pot, A.Nm_Pot AS Nm_Pot, A.Kd_Billing, A.NTPN, A.TglTrx_NTPN,
                   B.Nm_Pimpinan, B.Nip_Pimpinan, B.Jbt_Pimpinan, B.Nm_Bendahara, B.Nip_Bendahara, B.Jbt_Bendahara
            FROM
                (
                    SELECT $d1 - 1 AS Tanggal, '' AS No_Bukti, 'Saldo Awal' AS Keterangan,
                           CASE
                               WHEN A.Debet > A.Kredit THEN A.Debet - A.Kredit
                               ELSE 0
                               END AS Debet,
                           CASE
                               WHEN A.Debet > A.Kredit THEN 0
                               ELSE A.Kredit - A.Debet
                               END AS Kredit,
                           A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                           A.Kd_Pot AS Kd_Pot, A.Nm_Pot AS Nm_Pot, 0 AS Kd_Prog, 0 AS Kd_Keg, '' AS Kd_Billing, '' AS NTPN, NULL AS TglTrx_NTPN
                    FROM
                        (
                            SELECT 0 AS Debet, ISNULL(SUM(A.Nilai), 0) AS Kredit,
                                   A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                                   C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot
                            FROM Ta_Pajak_Rinc A INNER JOIN
                                 Ta_Pajak B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti INNER JOIN
                                 Ref_Pot_SPM_Rek C  ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5  INNER JOIN
                                 Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                            WHERE (B.Tgl_Bukti < $d1) AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                            GROUP BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot

                            UNION ALL

                            SELECT ISNULL(SUM(A.Nilai), 0) AS Debet, ISNULL(SUM(CASE WHEN (($cms = 1) AND (B.Cair = 1)) THEN A.Nilai ELSE 0 END), 0) AS Kredit,
                                   C.Kd_Rek_1 AS Kd_Rek_1, C.Kd_Rek_2 AS Kd_Rek_2, C.Kd_Rek_3 AS Kd_Rek_3, C.Kd_Rek_4 AS Kd_Rek_4, C.Kd_Rek_5 AS Kd_Rek_5,
                                   C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot
                            FROM Ta_SPJ_Pot A INNER JOIN
                                 Ta_SPJ_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti INNER JOIN
                                 Ref_Pot_SPM_Rek C  ON A.Kd_Pot_Rek = C.Kd_Pot_Rek INNER JOIN
                                 Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                            WHERE (B.Tgl_Bukti < $d1) AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                            GROUP BY C.Kd_Rek_1, C.Kd_Rek_2, C.Kd_Rek_3, C.Kd_Rek_4, C.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot
                        ) A

                    UNION ALL

                    SELECT B.Tgl_Bukti, B.No_Bukti, B.Keterangan,
                           0 AS Debet, SUM(A.Nilai) AS Kredit,
                           A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                           C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot, B.Kd_Prog, B.Kd_Keg, '', B.NTPN, NULL
                    FROM Ta_Pajak_Rinc A INNER JOIN
                         Ta_Pajak B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti  INNER JOIN
                         Ref_Pot_SPM_Rek C  ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5  INNER JOIN
                         Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                    WHERE (B.Tgl_Bukti BETWEEN $d1 AND $d2) AND (B.Tahun = '$tahun') AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                    GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Keterangan, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot, B.Kd_Prog, B.Kd_Keg, B.NTPN

                    UNION ALL

                    SELECT B.Tgl_Bukti, B.No_Bukti, B.Uraian,
                           SUM(A.Nilai) AS Debet, SUM(CASE WHEN (($cms = 1) AND (B.Cair = 1)) THEN A.Nilai ELSE 0 END) AS Kredit,
                           C.Kd_Rek_1 AS Kd_Rek_1, C.Kd_Rek_2 AS Kd_Rek_2, C.Kd_Rek_3 AS Kd_Rek_3, C.Kd_Rek_4 AS Kd_Rek_4, C.Kd_Rek_5 AS Kd_Rek_5,
                           C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot, B.Kd_Prog, B.Kd_Keg, A.Kd_Billing, A.NTPN, A.TglTrx_NTPN
                    FROM Ta_SPJ_Pot A INNER JOIN
                         Ta_SPJ_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti  INNER JOIN
                         Ref_Pot_SPM_Rek C  ON A.Kd_Pot_Rek = C.Kd_Pot_Rek INNER JOIN
                         Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                    WHERE (B.Tgl_Bukti BETWEEN $d1 AND $d2) AND (B.Tahun = '$tahun') AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                    GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Uraian, C.Kd_Rek_1, C.Kd_Rek_2, C.Kd_Rek_3, C.Kd_Rek_4, C.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot, B.Kd_Prog, B.Kd_Keg, A.Kd_Billing, A.NTPN, A.TglTrx_NTPN
                ) A ,
                (
                    SELECT '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                           '$kd_urusan' AS Kd_Urusan_Gab,
                           '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) AS Kd_Bidang_Gab,
                           '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) AS Kd_Unit_Gab,
                           '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) + ' . ' + RIGHT('0' +  '$kd_sub', 2) AS Kd_Sub_Gab,
                           E.Nm_Urusan AS Nm_Urusan_Gab, D.Nm_Bidang AS Nm_Bidang_Gab, C.Nm_Unit AS Nm_Unit_Gab, B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                           A.Nm_Pimpinan AS Nm_Pimpinan, A.Nip_Pimpinan AS Nip_Pimpinan, A.Jbt_Pimpinan AS Jbt_Pimpinan,
                           G.Nm_Bendahara, G.Nip_Bendahara, G.Jbt_Bendahara
                    FROM Ta_Sub_Unit A INNER JOIN
                         Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub INNER JOIN
                         Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit INNER JOIN
                         Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang INNER JOIN
                         Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan INNER JOIN
                         (
                             SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
                             FROM Ta_Sub_Unit A
                             WHERE (A.Tahun = '$tahun') AND (A.Kd_Urusan LIKE '$kd_urusan') AND (A.Kd_Bidang LIKE '$kd_bidang') AND (A.Kd_Unit LIKE '$kd_unit') AND (A.Kd_Sub LIKE '$kd_sub')
                             ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
                         ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub LEFT OUTER JOIN

                         (
                             SELECT Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, MIN(Nama) AS Nm_Bendahara, MIN(Nip) AS Nip_Bendahara, MIN(Jabatan) AS Jbt_Bendahara
                             FROM Ta_Sub_Unit_Jab A
                             WHERE (A.Kd_Jab = 4) AND (A.Tahun = '$tahun') AND (A.Kd_Urusan LIKE '$kd_urusan') AND (A.Kd_Bidang LIKE '$kd_bidang') AND (A.Kd_Unit LIKE '$kd_unit') AND (A.Kd_Sub LIKE '$kd_sub')
                             GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
                         ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
                ) B
            ORDER BY A.Tanggal, A.No_Bukti
			")
				->result();
		}
		else
		{
			$data_query								= $this->query
			("
            SELECT B.Kd_UrusanA, B.Kd_BidangA, B.Kd_UnitA, B.Kd_SubA,
                   B.Kd_Urusan_Gab, B.Kd_Bidang_Gab, B.Kd_Unit_Gab, B.Kd_Sub_Gab,
                   B.Nm_Urusan_Gab, B.Nm_Bidang_Gab, B.Nm_Unit_Gab, B.Nm_Sub_Unit_Gab,
                   CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' + CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Gab_Keg,
                   A.Tanggal, A.No_Bukti, A.Keterangan, A.Debet, A.Kredit, (A.Debet - A.Kredit) AS Saldo,
                   A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                   A.Kd_Pot AS Kd_Pot, A.Nm_Pot AS Nm_Pot, A.Kd_Billing, A.NTPN, A.TglTrx_NTPN,
                   B.Nm_Pimpinan, B.Nip_Pimpinan, B.Jbt_Pimpinan, B.Nm_Bendahara, B.Nip_Bendahara, B.Jbt_Bendahara
            FROM
                (
                    SELECT $d1 - 1 AS Tanggal, '' AS No_Bukti, 'Saldo Awal' AS Keterangan,
                           CASE
                               WHEN A.Debet > A.Kredit THEN A.Debet - A.Kredit
                               ELSE 0
                               END AS Debet,
                           CASE
                               WHEN A.Debet > A.Kredit THEN 0
                               ELSE A.Kredit - A.Debet
                               END AS Kredit,
                           A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                           A.Kd_Pot AS Kd_Pot, A.Nm_Pot AS Nm_Pot, 0 AS Kd_Prog, 0 AS Kd_Keg, '' AS Kd_Billing, '' AS NTPN, NULL AS TglTrx_NTPN
                    FROM
                        (
                            SELECT 0 AS Debet, ISNULL(SUM(A.Nilai), 0) AS Kredit,
                                   A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                                   C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot
                            FROM Ta_PajakC_Rinc A INNER JOIN
                                 Ta_PajakC B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti INNER JOIN
                                 Ref_Pot_SPM_Rek C  ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5  INNER JOIN
                                 Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                            WHERE (B.Tgl_Bukti < $d1) AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                            GROUP BY A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot

                            UNION ALL

                            SELECT ISNULL(SUM(A.Nilai), 0) AS Debet, 0 AS Kredit,
                                   C.Kd_Rek_1 AS Kd_Rek_1, C.Kd_Rek_2 AS Kd_Rek_2, C.Kd_Rek_3 AS Kd_Rek_3, C.Kd_Rek_4 AS Kd_Rek_4, C.Kd_Rek_5 AS Kd_Rek_5,
                                   C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot
                            FROM Ta_SPJC_Pot A INNER JOIN
                                 Ta_SPJC_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti INNER JOIN
                                 Ref_Pot_SPM_Rek C  ON A.Kd_Pot_Rek = C.Kd_Pot_Rek INNER JOIN
                                 Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                            WHERE (B.Tgl_Bukti < $d1) AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                            GROUP BY C.Kd_Rek_1, C.Kd_Rek_2, C.Kd_Rek_3, C.Kd_Rek_4, C.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot
                        ) A

                    UNION ALL

                    SELECT B.Tgl_Bukti, B.No_Bukti, B.Keterangan,
                           0 AS Debet, SUM(A.Nilai) AS Kredit,
                           A.Kd_Rek_1 AS Kd_Rek_1, A.Kd_Rek_2 AS Kd_Rek_2, A.Kd_Rek_3 AS Kd_Rek_3, A.Kd_Rek_4 AS Kd_Rek_4, A.Kd_Rek_5 AS Kd_Rek_5,
                           C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot, B.Kd_Prog, B.Kd_Keg, '', B.NTPN, NULL
                    FROM Ta_PajakC_Rinc A INNER JOIN
                         Ta_PajakC B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti  INNER JOIN
                         Ref_Pot_SPM_Rek C  ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND A.Kd_Rek_4 = C.Kd_Rek_4 AND A.Kd_Rek_5 = C.Kd_Rek_5  INNER JOIN
                         Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                    WHERE (B.Tgl_Bukti BETWEEN $d1 AND $d2) AND (B.Tahun = '$tahun') AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                    GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Keterangan, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot, B.Kd_Prog, B.Kd_Keg, B.NTPN

                    UNION ALL

                    SELECT B.Tgl_Bukti, B.No_Bukti, B.Uraian,
                           SUM(A.Nilai) AS Debet, 0 AS Kredit,
                           C.Kd_Rek_1 AS Kd_Rek_1, C.Kd_Rek_2 AS Kd_Rek_2, C.Kd_Rek_3 AS Kd_Rek_3, C.Kd_Rek_4 AS Kd_Rek_4, C.Kd_Rek_5 AS Kd_Rek_5,
                           C.Kd_Pot AS Kd_Pot, D.Nm_Pot AS Nm_Pot, B.Kd_Prog, B.Kd_Keg, A.Kd_Billing, A.NTPN, A.TglTrx_NTPN
                    FROM Ta_SPJC_Pot A INNER JOIN
                         Ta_SPJC_Bukti B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti  INNER JOIN
                         Ref_Pot_SPM_Rek C  ON A.Kd_Pot_Rek = C.Kd_Pot_Rek INNER JOIN
                         Ref_Pot_SPM D  ON C.Kd_Pot = D.Kd_Pot
                    WHERE (B.Tgl_Bukti BETWEEN $d1 AND $d2) AND (B.Tahun = '$tahun') AND (B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE '$kd_bidang') AND (B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND (C.Kd_Pot LIKE @Kd_Pot)
                    GROUP BY B.Tgl_Bukti, B.No_Bukti, B.Uraian, C.Kd_Rek_1, C.Kd_Rek_2, C.Kd_Rek_3, C.Kd_Rek_4, C.Kd_Rek_5, C.Kd_Pot, D.Nm_Pot, B.Kd_Prog, B.Kd_Keg, A.Kd_Billing, A.NTPN, A.TglTrx_NTPN
                ) A ,
                (
                    SELECT '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                           '$kd_urusan' AS Kd_Urusan_Gab,
                           '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) AS Kd_Bidang_Gab,
                           '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) AS Kd_Unit_Gab,
                           '$kd_urusan' + ' . ' + RIGHT('0' + '$kd_bidang', 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) + ' . ' + RIGHT('0' +  '$kd_sub', 2) AS Kd_Sub_Gab,
                           E.Nm_Urusan AS Nm_Urusan_Gab, D.Nm_Bidang AS Nm_Bidang_Gab, C.Nm_Unit AS Nm_Unit_Gab, B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                           A.Nm_Pimpinan AS Nm_Pimpinan, A.Nip_Pimpinan AS Nip_Pimpinan, A.Jbt_Pimpinan AS Jbt_Pimpinan,
                           G.Nm_Bendahara, G.Nip_Bendahara, G.Jbt_Bendahara
                    FROM Ta_Sub_Unit A INNER JOIN
                         Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub INNER JOIN
                         Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit INNER JOIN
                         Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang INNER JOIN
                         Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan INNER JOIN
                         (
                             SELECT TOP 1 Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
                             FROM Ta_Sub_Unit A
                             WHERE (A.Tahun = '$tahun') AND (A.Kd_Urusan LIKE '$kd_urusan') AND (A.Kd_Bidang LIKE '$kd_bidang') AND (A.Kd_Unit LIKE '$kd_unit') AND (A.Kd_Sub LIKE '$kd_sub')
                             ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
                         ) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub LEFT OUTER JOIN

                         (
                             SELECT Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, MIN(Nama) AS Nm_Bendahara, MIN(Nip) AS Nip_Bendahara, MIN(Jabatan) AS Jbt_Bendahara
                             FROM Ta_Sub_Unit_Jab A
                             WHERE (A.Kd_Jab = 4) AND (A.Tahun = '$tahun') AND (A.Kd_Urusan LIKE '$kd_urusan') AND (A.Kd_Bidang LIKE '$kd_bidang') AND (A.Kd_Unit LIKE '$kd_unit') AND (A.Kd_Sub LIKE '$kd_sub')
                             GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
                         ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
                ) B
            ORDER BY A.Tanggal, A.No_Bukti
			")
				->result();
		}
		$output										= array
		(
			'table_data'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function buku_panjar($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$kd_prog									= $params['kd_prog'];
		$id_prog									= $params['id_prog'];
		$kd_keg										= $params['kd_keg'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$data_query								    = $this->query
		("
	        SELECT B.Kd_UrusanA,
			       B.Kd_BidangA,
			       B.Kd_UnitA,
			       B.Kd_SubA,
			       D.Kd_ProgA,
			       D.Kd_KegA,
			       D.Kd_Bidang1                                                                                                             AS Kd_Bidang_Gab,
			       D.Kd_Bidang1 + ' . ' + B.Kd_Unit_Gab                                                                                     AS Kd_Unit_Gab,
			       D.Kd_Bidang1 + ' . ' + B.Kd_Sub_Gab                                                                                      AS Kd_Sub_Gab,
			       D.Kd_Prog_Gab,
			       D.Kd_Keg_Gab,
			       B.Nm_Urusan_Gab + ' ' + B.Nm_Bidang_Gab                                                                                  AS Nm_Bidang_Gab,
			       B.Nm_Unit_Gab,
			       B.Nm_Sub_Unit_Gab,
			       D.Ket_Program_Gab,
			       D.Ket_Kegiatan_Gab,
			       CASE LEN(CONVERT(varchar, A.Kd_Prog))
			           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
			           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' + CASE LEN(CONVERT(varchar, A.Kd_Keg))
			                                                                            WHEN 3 THEN CONVERT(varchar, A.Kd_Keg)
			                                                                            ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Gab_Keg,
			       A.Tanggal,
			       A.No_Bukti,
			       A.Keterangan,
			       A.Debet,
			       A.Kredit,
			       (A.Debet - A.Kredit)                                                                                                     AS Saldo,
			       B.Nm_Pimpinan,
			       B.Nip_Pimpinan,
			       B.Jbt_Pimpinan,
			       B.Nm_Bendahara,
			       B.Nip_Bendahara,
			       B.Jbt_Bendahara
			FROM (
			         SELECT $d1 - 1      AS Tanggal,
			                ''           AS No_Bukti,
			                'Saldo Awal' AS Keterangan,
			                CASE
			                    WHEN SUM(A.Saldo) >= 0 THEN SUM(A.Saldo)
			                    ELSE 0
			                    END      AS Debet,
			                CASE
			                    WHEN SUM(A.Saldo) >= 0 THEN 0
			                    ELSE SUM(A.Saldo)
			                    END      AS Kredit,
			                0            AS Kd_Prog,
			                0            AS Kd_Keg
			         FROM (
			                  SELECT CASE A.D_K
			                             WHEN 'D' THEN Nilai
			                             ELSE -Nilai
			                             END AS Saldo
			                  FROM Ta_Panjar A
			                  WHERE (A.Tgl_Bukti < '$d1')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (A.Kd_Prog LIKE '$kd_prog')
			                    AND (A.Id_Prog LIKE '$id_prog')
			                    AND (A.Kd_Keg LIKE '$kd_keg')
			
			                  UNION ALL
			
			                  SELECT -B.Nilai AS Saldo
			                  FROM Ta_SPJ_Panjar A
			                           INNER JOIN
			                       (
			                           SELECT Tahun, No_SPJ_Panjar, SUM(Nilai) AS Nilai
			                           FROM Ta_SPJ_Bukti
			                           WHERE (ISNULL(No_SPJ_Panjar, '') <> '')
			                           GROUP BY Tahun, No_SPJ_Panjar
			                       ) B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ_Panjar
			                  WHERE (A.Tgl_SPJ < '$d1')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (A.Kd_Prog LIKE '$kd_prog')
			                    AND (A.Id_Prog LIKE '$id_prog')
			                    AND (A.Kd_Keg LIKE '$kd_keg')
			              ) A
			
			         UNION ALL
			
			         SELECT A.Tgl_Bukti,
			                A.No_Bukti,
			                A.Keterangan,
			                CASE A.D_K
			                    WHEN 'D' THEN Nilai
			                    ELSE 0
			                    END AS Debet,
			                CASE A.D_K
			                    WHEN 'K' THEN Nilai
			                    ELSE 0
			                    END AS Kredit,
			                A.Kd_Prog,
			                A.Kd_Keg
			         FROM Ta_Panjar A
			         WHERE (A.Tgl_Bukti BETWEEN '$d1' AND '$d2')
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			
			         UNION ALL
			
			         SELECT A.Tgl_SPJ, A.No_SPJ, A.Keterangan, 0 AS Debet, B.Nilai AS Kredit, A.Kd_Prog, A.Kd_Keg
			         FROM Ta_SPJ_Panjar A
			                  INNER JOIN
			              (
			                  SELECT Tahun, No_SPJ_Panjar, SUM(Nilai) AS Nilai
			                  FROM Ta_SPJ_Bukti
			                  WHERE (ISNULL(No_SPJ_Panjar, '') <> '')
			                  GROUP BY Tahun, No_SPJ_Panjar
			              ) B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ_Panjar
			         WHERE (A.Tgl_SPJ BETWEEN '$d1' AND '$d2')
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			     ) A,
			     (
			         SELECT '$kd_urusan'                                                                     AS Kd_UrusanA,
			                '$kd_bidang'                                                                     AS Kd_BidangA,
			                '$kd_unit'                                                                       AS Kd_UnitA,
			                '$kd_sub'                                                                        AS Kd_SubA,
			                '$kd_urusan'                                                                     AS Kd_Urusan_Gab,
			                '$kd_urusan' + '.' + RIGHT('0' + '$kd_bidang', 2)                                  AS Kd_Bidang_Gab,
			                '$kd_urusan' + '.' + RIGHT('0' + '$kd_bidang', 2) + '.' + RIGHT('0' + '$kd_unit', 2) AS Kd_Unit_Gab,
			                '$kd_urusan' + '.' + RIGHT('0' + '$kd_bidang', 2) + '.' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2)                                                        AS Kd_Sub_Gab,
			                E.Nm_Urusan                                                                    AS Nm_Urusan_Gab,
			                D.Nm_Bidang                                                                    AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                      AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                  AS Nm_Sub_Unit_Gab,
			                A.Nm_Pimpinan                                                                  AS Nm_Pimpinan,
			                A.Nip_Pimpinan                                                                 AS Nip_Pimpinan,
			                A.Jbt_Pimpinan                                                                 AS Jbt_Pimpinan,
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
			                  WHERE (A.Kd_Jab = 4)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
			                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			     ) B,
			     (
			         SELECT '$kd_prog'                                                                                             AS Kd_ProgA,
			                '$kd_keg'                                                                                              AS Kd_KegA,
			                CONVERT(varchar, C.Kd_Urusan1) + '.' +
			                RIGHT('0' + CONVERT(varchar, C.Kd_Bidang1), 2)                                                       AS Kd_Bidang1,
			                CONVERT(varchar, C.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, C.Kd_Bidang1), 2) + ' . ' +
			                '$kd_urusan' + '.' + RIGHT('0' + '$kd_bidang', 2) + '.' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2) + ' . ' +
			                CASE '$kd_prog' WHEN '%' THEN '00' ELSE RIGHT('0' + '$kd_prog', 2) END                                   AS Kd_Prog_Gab,
			                CONVERT(varchar, C.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, C.Kd_Bidang1), 2) + ' . ' +
			                '$kd_urusan' + '.' + RIGHT('0' + '$kd_bidang', 2) + '.' + RIGHT('0' + '$kd_unit', 2) + ' . ' +
			                RIGHT('0' + '$kd_sub', 2) + ' . ' + CASE '$kd_prog' WHEN '%' THEN '00' ELSE RIGHT('0' + '$kd_prog', 2) END +
			                ' . ' +
			                CASE '$kd_keg' WHEN '%' THEN '00' ELSE RIGHT('0' + '$kd_keg', 2) END                                     AS Kd_Keg_Gab,
			                F.Nm_Urusan + ' ' + E.Nm_Bidang                                                                      AS Nm_Bidang_Gab,
			                C.Ket_Program                                                                                        AS Ket_Program_Gab,
			                B.Ket_Kegiatan                                                                                       AS Ket_Kegiatan_Gab,
			                B.Lokasi,
			                B.Kelompok_Sasaran
			         FROM Ta_Kegiatan B
			                  INNER JOIN
			              Ta_Program C ON B.Tahun = C.Tahun AND B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND
			                              B.Kd_Unit = C.Kd_Unit AND B.Kd_Sub = C.Kd_Sub AND B.Kd_Prog = C.Kd_Prog AND
			                              B.Id_Prog = C.Id_Prog
			                  INNER JOIN
			              (
			                  SELECT TOP 1 Tahun,
			                               Kd_Urusan,
			                               Kd_Bidang,
			                               Kd_Unit,
			                               Kd_Sub,
			                               Kd_Prog,
			                               Kd_Keg,
			                               Id_Prog
			                  FROM Ta_Kegiatan A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                    AND (A.Kd_Prog LIKE '$kd_prog')
			                    AND (A.Kd_Keg LIKE '$kd_keg')
			                    AND (A.Id_Prog LIKE '$id_prog')
			                  ORDER BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, Id_Prog, Kd_Keg
			              ) D ON B.Tahun = D.Tahun AND B.Kd_Urusan = D.Kd_Urusan AND B.Kd_Bidang = D.Kd_Bidang AND
			                     B.Kd_Unit = D.Kd_Unit AND B.Kd_Sub = D.Kd_Sub AND B.Kd_Prog = D.Kd_Prog AND B.Kd_Keg = D.Kd_Keg AND
			                     B.Id_Prog = D.Id_Prog
			                  INNER JOIN
			              Ref_Bidang E ON C.Kd_Urusan1 = E.Kd_Urusan AND C.Kd_Bidang1 = E.Kd_Bidang
			                  INNER JOIN
			              Ref_Urusan F ON E.Kd_Urusan = F.Kd_Urusan
			     ) D
			WHERE (ISNULL(A.Debet, 0) <> 0)
			   OR (ISNULL(A.Kredit, 0) <> 0)
			ORDER BY A.Tanggal, A.No_Bukti
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	// jumlah sp2d belum
	public function spj_pengeluaran($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$bulan                                      = $params['bulan'];

		$peny   								    = $this->query
		('
			SELECT
				Peny_SPJ
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $params['tahun'] . '
		')
			->row('Peny_SPJ');

		$tmpSPJ								        =
		("	
			SELECT A.Kd_Rek_1,
			       A.Kd_Rek_2,
			       A.Kd_Rek_3,
			       A.Kd_Rek_4,
			       A.Kd_Rek_5,
			       SUM(A.Anggaran) AS Anggaran,
			       SUM(A.Gaji_L) AS Gaji_L,
			       SUM(A.Gaji_I) AS Gaji_I,
			       SUM(A.LS_L) AS LS_L,
			       SUM(A.LS_I) AS LS_I,
			       SUM(A.UP_L) AS UP_L,
			       SUM(A.UP_I) AS UP_I
			FROM (
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Total AS Anggaran,
			                0       AS Gaji_L,
			                0       AS Gaji_I,
			                0       AS LS_L,
			                0       AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_RASK_Arsip A
			         WHERE (A.Kd_Rek_1 = 5)
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Perubahan = (SELECT MAX(Kd_Perubahan)
			                                  FROM Ta_RASK_Arsip_Perubahan
			                                  WHERE (Kd_Perubahan IN (4, 6, 8))
			                                    AND (LEFT(CONVERT(varchar, Tgl_Perda, 112), 6) <=
			                                         ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			                                    AND (Tahun = '$tahun')))
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
			                0,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN A.Nilai
			                    ELSE 0
			                    END AS Gaji_L,
			                0       AS Gaji_I,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE A.Nilai
			                    END AS LS_L,
			                0       AS LS_I,
			                0          UP_L,
			                0       AS UP_I
			         FROM Ta_SPM_Rinc A
			                  INNER JOIN
			              Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
			                  INNER JOIN
			              Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			         WHERE (B.Jn_SPM = 3)
			           AND (B.Kd_Edit <> 2)
			           AND (LEFT(CONVERT(varchar, C.Tgl_SP2D, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Rek_1 = 5)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0       AS Gaji_L,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN A.Nilai
			                    ELSE 0
			                    END AS Gaji_I,
			                0       AS LS_L,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE A.Nilai
			                    END AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_SPM_Rinc A
			                  INNER JOIN
			              Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
			                  INNER JOIN
			              Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			         WHERE (B.Jn_SPM = 3)
			           AND (B.Kd_Edit <> 2)
			           AND (LEFT(CONVERT(varchar, C.Tgl_SP2D, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Rek_1 = 5)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0              AS Anggaran,
			                0              AS Gaji_L,
			                0              AS Gaji_I,
			                0              AS LS_L,
			                0              AS LS_I,
			                A.Nilai_Setuju AS UP_L,
			                0              AS UP_I
			         FROM Ta_Pengesahan_SPJ_Rinc A
			                  INNER JOIN
			              Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_Pengesahan
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Pengesahan, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
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
			                0              AS Anggaran,
			                0              AS Gaji_L,
			                0              AS Gaji_I,
			                0              AS LS_L,
			                0              AS LS_I,
			                0              AS UP_L,
			                A.Nilai_Setuju AS UP_I
			         FROM Ta_Pengesahan_SPJ_Rinc A
			                  INNER JOIN
			              Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_Pengesahan
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Pengesahan, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
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
			                0,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_L,
			                0       AS Gaji_I,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_L,
			                0       AS LS_I,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS UP_L,
			                0       AS UP_I
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (B.Jns_P1 = 1)
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND ('$peny' = 1)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0       AS Gaji_L,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_I,
			                0       AS LS_L,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_I,
			                0       AS UP_L,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS UP_I
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (B.Jns_P1 = 1)
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND ('$peny' = 1)
			
			         UNION ALL
			
			         SELECT A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                CASE
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_L,
			                0       AS Gaji_I,
			                CASE
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_L,
			                0       AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Kd_Rek_1 = 5)
			           AND ('$peny' = 1)
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
			       RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2)                           AS Kd_Rek_5_Gab,
			       A.Anggaran,
			       A.Gaji_L,
			       A.Gaji_I,
			       A.Gaji_L + A.Gaji_I                                                    AS Gaji_T,
			       A.LS_L,
			       A.LS_I,
			       A.LS_L + A.LS_I                                                        AS LS_T,
			       A.UP_L,
			       A.UP_I,
			       A.UP_L + A.UP_I                                                        AS UP_T,
			       A.Gaji_L + A.Gaji_I + A.LS_L + A.LS_I + A.UP_L + A.UP_I                AS TOTAL_SPJ,
			       A.Anggaran - (A.Gaji_L + A.Gaji_I + A.LS_L + A.LS_I + A.UP_L + A.UP_I) AS SISA,
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
			                  WHERE (A.Kd_Jab = 4)
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
			'tanggal'								=> $params['tahun'],
			'bulan'								    => $params['bulan']
		);
		return $output;
	}

	// jumlah belum
	public function spj_pengeluaran_per_kegiatan($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$kd_prog									= $params['kd_prog'];
		$id_prog									= $params['id_prog'];
		$kd_keg										= $params['kd_keg'];
		$bulan                                      = $params['bulan'];

		$peny_query								    = $this->query
		('
			SELECT
				Peny_SPJ
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $params['tahun'] . '
		')
			->row('Peny_SPJ');

		$tmpSPJ								        =
		("
			SELECT A.Tahun,
			       A.Kd_Urusan,
			       A.Kd_Bidang,
			       A.Kd_Unit,
			       A.Kd_Sub,
			       A.Kd_Prog,
			       A.Kd_Keg,
			       A.Id_Prog,
			       A.Kd_Rek_1,
			       A.Kd_Rek_2,
			       A.Kd_Rek_3,
			       A.Kd_Rek_4,
			       A.Kd_Rek_5,
			       SUM(A.Anggaran) AS Anggaran,
			       SUM(A.Gaji_L) AS Gaji_L,
			       SUM(A.Gaji_I) AS Gaji_I,
			       SUM(A.LS_L) AS LS_L,
			       SUM(A.LS_I) AS LS_I,
			       SUM(A.UP_L) AS UP_L,
			       SUM(A.UP_I) AS UP_I
			FROM (
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Total AS Anggaran,
			                0       AS Gaji_L,
			                0       AS Gaji_I,
			                0       AS LS_L,
			                0       AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_RASK_Arsip A
			         WHERE ((A.Kd_Rek_1 = 5) OR ((A.Kd_Rek_1 = 6) AND (A.Kd_Rek_2 = 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Perubahan = (SELECT MAX(Kd_Perubahan)
			                                  FROM Ta_RASK_Arsip_Perubahan
			                                  WHERE (Kd_Perubahan IN (4, 6, 8))
			                                    AND (LEFT(CONVERT(varchar, Tgl_Perda, 112), 6) <=
			                                         ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			                                    AND (Tahun = '$tahun')))
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN A.Nilai
			                    ELSE 0
			                    END AS Gaji_L,
			                0       AS Gaji_I,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE A.Nilai
			                    END AS LS_L,
			                0       AS LS_I,
			                0          UP_L,
			                0       AS UP_I
			         FROM Ta_SPM_Rinc A
			                  INNER JOIN
			              Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
			                  INNER JOIN
			              Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			         WHERE (B.Jn_SPM = 3)
			           AND (B.Kd_Edit <> 2)
			           AND (LEFT(CONVERT(varchar, C.Tgl_SP2D, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND ((A.Kd_Rek_1 = 5) OR ((A.Kd_Rek_1 = 6) AND (A.Kd_Rek_2 = 2)))
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0       AS Gaji_L,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN A.Nilai
			                    ELSE 0
			                    END AS Gaji_I,
			                0       AS LS_L,
			                CASE
			                    WHEN B.Jn_SPM IN (1, 2, 4) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE A.Nilai
			                    END AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_SPM_Rinc A
			                  INNER JOIN
			              Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
			                  INNER JOIN
			              Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			         WHERE (B.Jn_SPM = 3)
			           AND (B.Kd_Edit <> 2)
			           AND (LEFT(CONVERT(varchar, C.Tgl_SP2D, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND ((A.Kd_Rek_1 = 5) OR ((A.Kd_Rek_1 = 6) AND (A.Kd_Rek_2 = 2)))
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0              AS Anggaran,
			                0              AS Gaji_L,
			                0              AS Gaji_I,
			                0              AS LS_L,
			                0              AS LS_I,
			                A.Nilai_Setuju AS UP_L,
			                0              AS UP_I
			         FROM Ta_Pengesahan_SPJ_Rinc A
			                  INNER JOIN
			              Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_Pengesahan
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Pengesahan, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0              AS Anggaran,
			                0              AS Gaji_L,
			                0              AS Gaji_I,
			                0              AS LS_L,
			                0              AS LS_I,
			                0              AS UP_L,
			                A.Nilai_Setuju AS UP_I
			         FROM Ta_Pengesahan_SPJ_Rinc A
			                  INNER JOIN
			              Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_Pengesahan
			         WHERE (LEFT(CONVERT(varchar, B.Tgl_Pengesahan, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_L,
			                0       AS Gaji_I,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_L,
			                0       AS LS_I,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS UP_L,
			                0       AS UP_I
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND (B.Jns_P1 = 1)
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND ('$peny_query' = 1)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0       AS Gaji_L,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_I,
			                0       AS LS_L,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN 0
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_I,
			                0       AS UP_L,
			                CASE
			                    WHEN B.Jn_SPM IN (2, 5) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS UP_I
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND (B.Jns_P1 = 1)
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND ('$peny_query' = 1)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                CASE
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_L,
			                0       AS Gaji_I,
			                CASE
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_L,
			                0       AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) < ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND ('$peny_query' = 1)
			           AND ((A.Kd_Rek_1 = 5) OR ((A.Kd_Rek_1 = 6) AND (A.Kd_Rek_2 = 2)))
			           AND (B.No_BKU <> 9999)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.Kd_Keg,
			                A.Id_Prog,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0       AS Gaji_L,
			                CASE
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END AS Gaji_I,
			                0       AS LS_L,
			                CASE
			                    WHEN (A.Kd_Rek_1 = 5) AND (A.Kd_Rek_2 = 1) AND (A.Kd_Rek_3 = 1) AND (A.Kd_Rek_4 = 1) THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END AS LS_I,
			                0       AS UP_L,
			                0       AS UP_I
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan LIKE '$kd_urusan')
			           AND (A.Kd_Bidang LIKE '$kd_bidang')
			           AND (A.Kd_Unit LIKE '$kd_unit')
			           AND (A.Kd_Sub LIKE '$kd_sub')
			           AND (A.Kd_Prog LIKE '$kd_prog')
			           AND (A.Kd_Keg LIKE '$kd_keg')
			           AND (A.Id_Prog LIKE '$id_prog')
			           AND (LEFT(CONVERT(varchar, B.Tgl_Bukti, 112), 6) = ('$tahun' + RIGHT('0' + CONVERT(varchar, '$bulan'), 2)))
			           AND ('$peny_query' = 1)
			           AND ((A.Kd_Rek_1 = 5) OR ((A.Kd_Rek_1 = 6) AND (A.Kd_Rek_2 = 2)))
			           AND (B.No_BKU <> 9999)
			     ) A
			GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.Kd_Keg, A.Id_Prog,
			         A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
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
			       A.Kd_Urusan,
			       A.Kd_Bidang,
			       A.Kd_Unit,
			       A.Kd_Sub,
			       A.Kd_Prog,
			       A.Kd_Keg,
			       A.Id_Prog,
			       CONVERT(varchar, F.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, F.Kd_Bidang1), 2) + ' . ' +
			       CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' +
			       RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2) + ' . ' +
			       CASE LEN(A.Kd_Prog)
			           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
			           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END AS                                                                   Kd_Prog_Gab,
			       CONVERT(varchar, F.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, F.Kd_Bidang1), 2) + ' . ' +
			       CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' +
			       RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2) + ' . ' +
			       CASE LEN(A.Kd_Prog)
			           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
			           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + ' . ' + CASE LEN(A.Kd_Keg)
			                                                                              WHEN 3 THEN CONVERT(varchar, A.Kd_Keg)
			                                                                              ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Keg_Gab,
			       F.Ket_Program,
			       E.Ket_Kegiatan,
			       B.Nm_Rek_5,
			       CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) +
			       ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' +
			       RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS                                                                               Kd_Rek_5_Gab,
			       A.Anggaran,
			       A.Gaji_L,
			       A.Gaji_I,
			       A.Gaji_L + A.Gaji_I AS                                                                                                        Gaji_T,
			       A.LS_L,
			       A.LS_I,
			       A.LS_L + A.LS_I AS                                                                                                            LS_T,
			       A.UP_L,
			       A.UP_I,
			       A.UP_L + A.UP_I AS                                                                                                            UP_T,
			       A.Gaji_L + A.Gaji_I + A.LS_L + A.LS_I + A.UP_L + A.UP_I AS                                                                    TOTAL_SPJ,
			       A.Anggaran - (A.Gaji_L + A.Gaji_I + A.LS_L + A.LS_I + A.UP_L + A.UP_I) AS                                                     SISA,
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
			        A.Kd_Rek_5 = B.Kd_Rek_5
			         INNER JOIN
			     Ta_Kegiatan E
			     ON A.Tahun = E.Tahun AND A.Kd_Urusan = E.Kd_Urusan AND A.Kd_Bidang = E.Kd_Bidang AND A.Kd_Unit = E.Kd_Unit AND
			        A.Kd_Sub = E.Kd_Sub AND A.Kd_Prog = E.Kd_Prog AND A.Kd_Keg = E.Kd_Keg AND A.Id_Prog = E.Id_Prog
			         INNER JOIN
			     Ta_Program F
			     ON E.Tahun = F.Tahun AND E.Kd_Urusan = F.Kd_Urusan AND E.Kd_Bidang = F.Kd_Bidang AND E.Kd_Unit = F.Kd_Unit AND
			        E.Kd_Sub = F.Kd_Sub AND E.Kd_Prog = F.Kd_Prog AND E.Id_Prog = F.Id_Prog,
			     (
			         SELECT '$kd_urusan'                                                                         AS Kd_UrusanA,
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
			                  WHERE (A.Kd_Jab = 4)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan LIKE '$kd_urusan')
			                    AND (A.Kd_Bidang LIKE '$kd_bidang')
			                    AND (A.Kd_Unit LIKE '$kd_unit')
			                    AND (A.Kd_Sub LIKE '$kd_sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND
			                     F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			     ) C
			ORDER BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.Kd_Keg,
			         A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun'],
			'bulan'								    => $params['bulan']
		);
		return $output;
	}

	// lewat query
	public function buku_kas_pengeluaran($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];

		$query_blu								    = $this->query
		("
			SELECT
				Kd_Urusan,
				Kd_Bidang,
				Kd_Unit,
				Kd_Sub
			FROM
				Ref_BLU
			WHERE
				Jenis = 4
			AND Kd_Urusan = '$kd_urusan'
			AND Kd_Bidang = '$kd_bidang'
			AND Kd_Unit = '$kd_unit'
			AND Kd_Sub = '$kd_sub'
		")
			->row();

		if(!empty($query_blu))
		{
			$tmp_bku								=
				("
			
			");
		}
		else
		{
			$tmp_bku								=
				("
			
			");
		}

		var_dump($query_blu);die;
		$data_query								    = $this->query
		('
			SELECT
				ta_panjar.kd_prog,
				ta_panjar.kd_keg,
				ta_panjar.tgl_bukti,
				ta_panjar.no_bukti,
				ta_panjar.keterangan AS uraian,
				ta_panjar.d_k,
				ta_panjar.nilai
			FROM
				ta_panjar
			WHERE
				ta_panjar.kd_urusan = ' . $params['kd_urusan'] . '
				AND ta_panjar.kd_bidang = ' . $params['kd_bidang'] . '
				AND ta_panjar.kd_unit = ' . $params['kd_unit'] . '
				AND ta_panjar.kd_sub = ' . $params['kd_sub'] . '
				AND ta_panjar.kd_prog = ' . $params['kd_prog'] . '
				AND ta_panjar.id_prog = ' . $params['id_prog'] . '
				AND ta_panjar.kd_keg = ' . $params['kd_keg'] . '
			ORDER BY
				ta_panjar.tgl_bukti ASC,
				ta_panjar.no_bukti ASC
		')
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'table_data'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	// jumlah belum
	public function laporan_spj($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spj                                     = $params['no_spj'];

		$peny_query								    = $this->query
		('
			SELECT
				Peny_SPJ
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $params['tahun'] . '
		')
			->row('Peny_SPJ');

		$query_spj								    = $this->query
		("
			SELECT
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.Tgl_SPJ
			FROM
				Ta_SPJ A
			WHERE
				A.Tahun = '$tahun' AND
				A.No_SPJ = '$no_spj'
		")
			->row();

		$tgl_spj_lalu								= $this->query
		("
			SELECT TOP 1 Tgl_SPJ
			FROM (
			         SELECT TOP 1 Tgl_SPJ
			         FROM Ta_SPJ A
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND ((A.Tgl_SPJ < '$query_spj->Tgl_SPJ') OR ((A.Tgl_SPJ = '$query_spj->Tgl_SPJ') AND (A.No_SPJ < '$no_spj')))
			         ORDER BY A.Tgl_SPJ DESC, A.No_SPJ DESC
			     ) A
		")
			->row('Tgl_SPJ');

		$tmpSPP                                     =
		("
			SELECT A.Tahun,
			       A.Kd_Urusan,
			       A.Kd_Bidang,
			       A.Kd_Unit,
			       A.Kd_Sub,
			       A.Kd_Prog,
			       A.ID_Prog,
			       A.Kd_Keg,
			       A.Kd_Rek_1,
			       A.Kd_Rek_2,
			       A.Kd_Rek_3,
			       A.Kd_Rek_4,
			       A.Kd_Rek_5,
			       SUM(Anggaran)   AS Anggaran,
			       SUM(A.SPJ_L)    AS SPJ_L,
			       SUM(A.SPJ_I_LS) AS SPJ_I_LS,
			       SUM(A.SPJ_I_GU) AS SPJ_I_GU
			FROM (
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Total AS Anggaran,
			                0       AS SPJ_L,
			                0       AS SPJ_I_LS,
			                0       AS SPJ_I_GU
			         FROM Ta_RASK_Arsip A
			         WHERE (A.Kd_Rek_1 = 5)
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Perubahan = (SELECT MAX(Kd_Perubahan)
			                                  FROM Ta_RASK_Arsip_Perubahan
			                                  WHERE (Tgl_Perda <= '$query_spj->Tgl_SPJ')
			                                    AND (Tahun = '$tahun')
			                                    AND (Kd_Perubahan IN (4, 6, 8))))
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                A.Nilai,
			                0,
			                0
			         FROM Ta_SPJ_Rinc A
			                  INNER JOIN
			              Ta_SPJ B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND ((B.Tgl_SPJ < '$query_spj->Tgl_SPJ') OR (B.Tgl_SPJ = '$query_spj->Tgl_SPJ' AND B.No_SPJ < '$no_spj'))
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                A.Nilai,
			                0,
			                0
			         FROM Ta_SPM_Rinc A
			                  INNER JOIN
			              Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
			                  INNER JOIN
			              Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			         WHERE (B.Jn_SPM = 3)
			           AND (B.Kd_Edit <> 2)
			           AND (C.Tgl_SP2D <= '$tgl_spj_lalu')
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND (A.Kd_Rek_1 = 5)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0,
			                A.Nilai,
			                0
			         FROM Ta_SPM_Rinc A
			                  INNER JOIN
			              Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
			                  INNER JOIN
			              Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			         WHERE (B.Jn_SPM = 3)
			           AND (B.Kd_Edit <> 2)
			           AND (C.Tgl_SP2D BETWEEN '$tgl_spj_lalu' + 1 AND '$query_spj->Tgl_SPJ')
			           AND (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND (A.Kd_Rek_1 = 5)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0,
			                0,
			                A.Nilai
			         FROM Ta_SPJ_Rinc A
			                  INNER JOIN
			              Ta_SPJ B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ
			         WHERE (A.Tahun = '$tahun')
			           AND (B.No_SPJ = '$no_spj')
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                CASE A.D_K
			                    WHEN 'D' THEN A.Nilai
			                    ELSE -A.Nilai
			                    END,
			                0,
			                0
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND (B.Jns_P1 = 1)
			           AND (B.Tgl_Bukti <= '$tgl_spj_lalu')
			           AND ('$peny_query' = 1)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0,
			                CASE B.Jn_SPM
			                    WHEN 3 THEN
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    ELSE 0
			                    END,
			                CASE B.Jn_SPM
			                    WHEN 3 THEN 0
			                    ELSE
			                        CASE A.D_K
			                            WHEN 'D' THEN A.Nilai
			                            ELSE -A.Nilai
			                            END
			                    END
			         FROM Ta_Penyesuaian_Rinc A
			                  INNER JOIN
			              Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND (B.Jns_P1 = 1)
			           AND (B.Tgl_Bukti BETWEEN '$tgl_spj_lalu' + 1 AND '$query_spj->Tgl_SPJ')
			           AND ('$peny_query' = 1)
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                CASE A.D_K
			                    WHEN 'D' THEN A.Nilai
			                    ELSE -A.Nilai
			                    END,
			                0,
			                0
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND (B.Tgl_Bukti <= '$tgl_spj_lalu')
			           AND (A.Kd_Rek_1 = 5)
			           AND ('$peny_query' = 1)
			           AND (B.Kd_Jurnal NOT IN (8, 10))
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                0,
			                0,
			                CASE A.D_K
			                    WHEN 'D' THEN A.Nilai
			                    ELSE -A.Nilai
			                    END,
			                0
			         FROM Ta_Jurnal_Rinc A
			                  INNER JOIN
			              Ta_Jurnal B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			           AND (B.Tgl_Bukti BETWEEN '$tgl_spj_lalu' + 1 AND '$query_spj->Tgl_SPJ')
			           AND (A.Kd_Rek_1 = 5)
			           AND ('$peny_query' = 1)
			           AND (B.Kd_Jurnal NOT IN (8, 10))
			     ) A
			GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2,
			         A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		");

		$data_query								    = $this->query
		("
			SELECT L.kd_program,
			       L.kd_kegiatan,
			       L.kd_sub_kegiatan,
			       E.Kd_Gab_Bidang,
			       E.Kd_Gab_Unit,
			       E.Kd_Gab_Sub,
			       RIGHT('0' + CONVERT(varchar, L.kd_program), 2)                         AS Kd_Gab_Prog,
			       RIGHT('0' + CONVERT(varchar, L.kd_program), 2) + ' . ' + L.kd_kegiatan AS Kd_Gab_Keg,
			       RIGHT('0' + CONVERT(varchar, L.kd_program), 2) + ' . ' + L.kd_kegiatan + ' . ' +
			       RIGHT('0' + CONVERT(varchar, L.kd_sub_kegiatan), 2)                    AS Kd_Gab_Sub_Keg,
			       E.Nm_Bidang_Gab,
			       E.Nm_Unit_Gab,
			       E.Nm_Sub_Unit_Gab,
			       N.nm_Program,
			       M.nm_Kegiatan,
			       L.nm_sub_kegiatan,
			       '$query_spj->Tgl_SPJ' AS Tgl_SPJ,
			       E.Nm_Pimpinan,
			       E.Nip_Pimpinan,
			       E.Jbt_Pimpinan,
			       E.Nm_Bendahara,
			       E.Nip_Bendahara,
			       E.Jbt_Bendahara,
			       A.Kode,
			       CASE A.Kode
			           WHEN 1 THEN 'I.  Yang Di-SPJ-kan saat ini'
			           ELSE 'II. Yang Tidak Di-SPJ-kan saat ini'
			           END                                                                AS Nm_Kode,
			       CONVERT(varchar, D.Kd_Rek90_1) + '.' + CONVERT(varchar, D.Kd_Rek90_2) + '.' + CONVERT(varchar, D.Kd_Rek90_3) +
			       '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Rek90_4), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Rek90_5), 2) +
			       '.' + RIGHT('0000' + CONVERT(varchar, D.Kd_Rek90_6), 4)                AS Kd_Gab_Rek,
			       O.Nm_Rek90_6,
			       A.Anggaran,
			       A.SPJ_L,
			       A.SPJ_I_LS,
			       A.SPJ_I_GU,
			       A.SPJ_L + A.SPJ_I_LS + A.SPJ_I_GU                                      AS SPJ_T,
			       A.Anggaran - (A.SPJ_L + A.SPJ_I_LS + A.SPJ_I_GU)                       AS Sisa,
			       I.Ibukota
			FROM (
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Anggaran,
			                A.SPJ_L,
			                A.SPJ_I_LS,
			                A.SPJ_I_GU,
			                1 AS Kode
			         FROM ($tmpSPP) AS A
			                  INNER JOIN
			              (
			                  SELECT A.Tahun,
			                         A.Kd_Urusan,
			                         A.Kd_Bidang,
			                         A.Kd_Unit,
			                         A.Kd_Sub,
			                         A.Kd_Prog,
			                         A.ID_Prog,
			                         A.Kd_Keg
			                  FROM Ta_SPJ_Rinc A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.No_SPJ = '$no_spj')
			                  GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
			              ) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND
			                     A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Prog = B.Kd_Prog AND
			                     A.ID_Prog = B.ID_Prog AND A.Kd_Keg = B.Kd_Keg
			
			         UNION ALL
			
			         SELECT A.Tahun,
			                A.Kd_Urusan,
			                A.Kd_Bidang,
			                A.Kd_Unit,
			                A.Kd_Sub,
			                A.Kd_Prog,
			                A.ID_Prog,
			                A.Kd_Keg,
			                A.Kd_Rek_1,
			                A.Kd_Rek_2,
			                A.Kd_Rek_3,
			                A.Kd_Rek_4,
			                A.Kd_Rek_5,
			                A.Anggaran,
			                A.SPJ_L,
			                A.SPJ_I_LS,
			                A.SPJ_I_GU,
			                2 AS Kode
                     FROM ($tmpSPP) AS A
			                  LEFT OUTER JOIN
			              (
			                  SELECT A.Tahun,
			                         A.Kd_Urusan,
			                         A.Kd_Bidang,
			                         A.Kd_Unit,
			                         A.Kd_Sub,
			                         A.Kd_Prog,
			                         A.ID_Prog,
			                         A.Kd_Keg
			                  FROM Ta_SPJ_Rinc A
			                  WHERE (A.Tahun = '$tahun')
			                    AND (A.No_SPJ = '$no_spj')
			                  GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
			              ) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND
			                     A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Prog = B.Kd_Prog AND
			                     A.ID_Prog = B.ID_Prog AND A.Kd_Keg = B.Kd_Keg
			         WHERE B.Tahun IS NULL
			     ) A
			         INNER JOIN
			     ref_rek_mapping D
			     ON A.kd_rek_1 = D.kd_rek_1 AND A.kd_rek_2 = D.kd_rek_2 AND A.kd_rek_3 = D.kd_rek_3 AND A.kd_rek_4 = D.kd_rek_4 AND
			        A.kd_rek_5 = D.kd_rek_5
			         INNER JOIN
			     ref_rek90_6 O ON D.kd_rek90_1 = O.kd_rek90_1 AND D.kd_rek90_2 = O.kd_rek90_2 AND D.kd_rek90_3 = O.kd_rek90_3 AND
			                      D.kd_rek90_4 = O.kd_rek90_4 AND D.kd_rek90_5 = O.kd_rek90_5 AND D.kd_rek90_6 = O.kd_rek90_6
			         INNER JOIN
			     ta_program C
			     ON A.tahun = C.tahun AND A.kd_urusan = C.kd_urusan AND A.kd_bidang = C.kd_bidang AND A.kd_unit = C.kd_unit AND
			        A.kd_sub = C.kd_sub AND A.kd_prog = C.kd_prog AND A.id_prog = C.id_prog
			         INNER JOIN
			     ref_kegiatan_mapping B
			     ON C.kd_urusan1 = B.kd_urusan AND C.kd_bidang1 = B.kd_bidang AND C.kd_prog = B.kd_prog AND A.kd_keg = B.kd_keg
			         INNER JOIN
			     ref_sub_kegiatan90 L
			     ON B.kd_urusan90 = L.kd_urusan AND B.kd_bidang90 = L.kd_bidang AND B.kd_program90 = L.kd_program AND
			        B.kd_kegiatan90 = L.kd_kegiatan AND B.kd_sub_kegiatan = L.kd_sub_kegiatan
			         INNER JOIN
			     ref_kegiatan90 M ON L.kd_urusan = M.kd_urusan AND L.kd_bidang = M.kd_bidang AND L.kd_program = M.kd_program AND
			                         L.kd_kegiatan = M.kd_kegiatan
			         INNER JOIN
			     ref_program90 N ON M.kd_urusan = N.kd_urusan AND M.kd_bidang = N.kd_bidang AND M.kd_program = N.kd_program
			         INNER JOIN
			     Ta_Pemda I ON A.Tahun = I.Tahun,
			     (
			         SELECT CONVERT(varchar, D.Kd_Urusan) + ' . ' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) AS Kd_Gab_Bidang,
			                C.kd_unit90                                                                           AS Kd_Gab_Unit,
			                C.kd_unit90 + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2)                      AS Kd_Gab_Sub,
			                E.Nm_Urusan + ' ' + D.Nm_Bidang                                                       AS Nm_Bidang_Gab,
			                C.Nm_Unit                                                                             AS Nm_Unit_Gab,
			                B.Nm_Sub_Unit                                                                         AS Nm_Sub_Unit_Gab,
			                A.Nm_Pimpinan                                                                         AS Nm_Pimpinan,
			                A.Nip_Pimpinan                                                                        AS Nip_Pimpinan,
			                A.Jbt_Pimpinan                                                                        AS Jbt_Pimpinan,
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
			              ref_bidang_mapping CC ON C.kd_urusan = CC.kd_urusan AND C.kd_bidang = CC.kd_bidang
			                  INNER JOIN
			              ref_bidang90 D ON CC.kd_urusan90 = D.kd_urusan AND CC.kd_bidang90 = D.kd_bidang
			                  INNER JOIN
			              ref_urusan90 E ON D.kd_urusan = E.kd_urusan
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
			                  WHERE (A.Kd_Jab = 4)
			                    AND (A.Tahun = '$tahun')
			                    AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			                    AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			                    AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			                    AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
			              ) G ON A.Tahun = G.Tahun AND A.Kd_Urusan = G.Kd_Urusan AND A.Kd_Bidang = G.Kd_Bidang AND
			                     A.Kd_Unit = G.Kd_Unit AND A.Kd_Sub = G.Kd_Sub
			         WHERE (A.Tahun = '$tahun')
			           AND (A.Kd_Urusan = '$query_spj->Kd_Urusan')
			           AND (A.Kd_Bidang = '$query_spj->Kd_Bidang')
			           AND (A.Kd_Unit = '$query_spj->Kd_Unit')
			           AND (A.Kd_Sub = '$query_spj->Kd_Sub')
			     ) E
			ORDER BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kode, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1,
			         A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function rincian_spj($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spj                                     = $params['no_spj'];

		$data_query								    = $this->query
		("
			SELECT CONVERT(varchar, A.Kd_Urusan) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2)             AS Kd_Bidang_Gab,
		       CONVERT(varchar, A.Kd_Urusan) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + ' . ' +
		       RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2)                                                       AS Kd_Unit_Gab,
		       CONVERT(varchar, A.Kd_Urusan) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + ' . ' +
		       RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2)  AS Kd_Sub_Gab,
		       CONVERT(varchar, D.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang1), 2) + ' . ' +
		       CASE LEN(CONVERT(varchar, A.Kd_Prog))
		           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
		           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END                                          AS Kd_Prog_Gab,
		       CONVERT(varchar, D.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang1), 2) + ' . ' +
		       CASE LEN(CONVERT(varchar, A.Kd_Prog))
		           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
		           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' +
		       CASE LEN(CONVERT(varchar, A.Kd_Keg))
		           WHEN 3 THEN CONVERT(varchar, A.Kd_Keg)
		           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END                                           AS Kd_Keg_Gab,
		       CONVERT(varchar, D.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang1), 2) + ' . ' +
		       CASE LEN(CONVERT(varchar, A.Kd_Prog))
		           WHEN 3 THEN CONVERT(varchar, A.Kd_Prog)
		           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + '.' +
		       CASE LEN(CONVERT(varchar, A.Kd_Keg))
		           WHEN 3 THEN CONVERT(varchar, A.Kd_Keg)
		           ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END + ' . ' +
		       CONVERT(varchar, A.Kd_Rek_1) + '.' + CONVERT(varchar, A.Kd_Rek_2) + '.' + CONVERT(varchar, A.Kd_Rek_3) + '.' +
		       RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_Gab,
		       I.Nm_Urusan + ' ' + H.Nm_Bidang                                                                   AS Nm_Bidang,
		       G.Nm_Unit,
		       F.Nm_Sub_Unit,
		       E.Nm_Pimpinan,
		       D.Ket_Program,
		       C.Ket_Kegiatan,
		       L.Nm_Rek_5,
		       B.Tgl_SPJ,
		       A.No_Bukti,
		       A.Tgl_Bukti,
		       CASE LTRIM(RTRIM(ISNULL(A.Uraian, '')))
		           WHEN '' THEN L.Nm_Rek_5
		           ELSE A.Uraian
		           END                                                                                           AS Uraian,
		       A.Nilai,
		       ISNULL(M.PPH21, 0)                                                                                AS PPH21,
		       ISNULL(M.PPH22, 0)                                                                                AS PPH22,
		       ISNULL(M.PPH23, 0)                                                                                AS PPH23,
		       ISNULL(M.PPN, 0)                                                                                  AS PPN,
		       ISNULL(M.Pot_Lainnya, 0)                                                                          AS Pot_Lainnya,
		       J.Ibukota,
		       K.Nm_Bendahara,
		       K.Nip_Bendahara,
		       K.Jbt_Bendahara
		FROM Ta_SPJ_Rinc A
		         INNER JOIN
		     Ta_SPJ B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ
		         INNER JOIN
		     Ref_Rek_5 L
		     ON A.Kd_Rek_1 = L.Kd_Rek_1 AND A.Kd_Rek_2 = L.Kd_Rek_2 AND A.Kd_Rek_3 = L.Kd_Rek_3 AND A.Kd_Rek_4 = L.Kd_Rek_4 AND
		        A.Kd_Rek_5 = L.Kd_Rek_5
		         INNER JOIN
		     Ta_Kegiatan C
		     ON A.Tahun = C.Tahun AND A.Kd_Urusan = C.Kd_Urusan AND A.Kd_Bidang = C.Kd_Bidang AND A.Kd_Unit = C.Kd_Unit AND
		        A.Kd_Sub = C.Kd_Sub AND A.Kd_Prog = C.Kd_Prog AND A.ID_Prog = C.ID_Prog AND A.Kd_Keg = C.Kd_Keg
		         INNER JOIN
		     Ta_Program D
		     ON C.Tahun = D.Tahun AND C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang AND C.Kd_Unit = D.Kd_Unit AND
		        C.Kd_Sub = D.Kd_Sub AND C.Kd_Prog = D.Kd_Prog AND C.ID_Prog = D.ID_Prog
		         INNER JOIN
		     Ta_Sub_Unit E
		     ON D.Tahun = E.Tahun AND D.Kd_Urusan = E.Kd_Urusan AND D.Kd_Bidang = E.Kd_Bidang AND D.Kd_Unit = E.Kd_Unit AND
		        D.Kd_Sub = E.Kd_Sub
		         INNER JOIN
		     Ref_Sub_Unit F
		     ON E.Kd_Urusan = F.Kd_Urusan AND E.Kd_Bidang = F.Kd_Bidang AND E.Kd_Unit = F.Kd_Unit AND E.Kd_Sub = F.Kd_Sub
		         INNER JOIN
		     Ref_Unit G ON F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND F.Kd_Unit = G.Kd_Unit
		         INNER JOIN
		     Ref_Bidang H ON G.Kd_Urusan = H.Kd_Urusan AND G.Kd_Bidang = H.Kd_Bidang
		         INNER JOIN
		     Ref_Urusan I ON H.Kd_Urusan = I.Kd_Urusan
		         INNER JOIN
		     Ta_Pemda J ON E.Tahun = J.Tahun
		         LEFT OUTER JOIN
		     (
		         SELECT A.Tahun,
		                A.Kd_Urusan,
		                A.Kd_Bidang,
		                A.Kd_Unit,
		                A.Kd_Sub,
		                A.Nama    AS Nm_Bendahara,
		                A.Nip     AS NIP_Bendahara,
		                A.Jabatan AS Jbt_Bendahara
		         FROM Ta_Sub_Unit_Jab A
		                  INNER JOIN
		              (
		                  SELECT Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab, MIN(No_Urut) AS No_Urut
		                  FROM Ta_Sub_Unit_Jab
		                  WHERE (Tahun = '$tahun')
		                    AND (Kd_Jab = 4)
		                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
		              ) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND
		                     A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Jab = B.Kd_Jab AND A.No_Urut = B.No_Urut
		     ) K ON E.Tahun = K.Tahun AND E.Kd_Urusan = K.Kd_Urusan AND E.Kd_Bidang = K.Kd_Bidang AND E.Kd_Unit = K.Kd_Unit AND
		            E.Kd_Sub = K.Kd_Sub
		         LEFT OUTER JOIN
		     (
		         SELECT A.Tahun,
		                A.No_Bukti,
		                SUM(CASE B.Kd_Pot
		                        WHEN 4 THEN A.Nilai
		                        ELSE 0
		                    END) AS PPH21,
		                SUM(CASE B.Kd_Pot
		                        WHEN 5 THEN A.Nilai
		                        ELSE 0
		                    END) AS PPH22,
		                SUM(CASE B.Kd_Pot
		                        WHEN 6 THEN A.Nilai
		                        ELSE 0
		                    END) AS PPH23,
		                SUM(CASE B.Kd_Pot
		                        WHEN 11 THEN A.Nilai
		                        ELSE 0
		                    END) AS PPN,
		                SUM(CASE B.Kd_Pot
		                        WHEN 4 THEN 0
		                        WHEN 5 THEN 0
		                        WHEN 6 THEN 0
		                        WHEN 11 THEN 0
		                        ELSE A.Nilai
		                    END) AS Pot_Lainnya
		         FROM Ta_SPJ_Pot A
		                  INNER JOIN
		              Ref_Pot_SPM_Rek B ON A.Kd_Pot_Rek = B.Kd_Pot_Rek
		         GROUP BY A.Tahun, A.No_Bukti
		     ) M ON A.Tahun = M.Tahun AND A.No_Bukti = M.No_Bukti
		WHERE (A.Tahun = '$tahun')
		  AND (A.No_SPJ = '$no_spj')
		ORDER BY A.Kd_Prog, A.Id_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5, A.Tgl_Bukti,
		         A.No_Bukti
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function spp1($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$spp_query								    = $this->query
		("
			SELECT 
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.Tgl_SPP,
				A.Jn_SPP,
				A.Tahun,
		       	B.Kd_Rek_1
			FROM Ta_SPP A, Ta_SPP_Rinc B
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = B.No_SPP
			  AND A.No_SPP = '$no_spp'
		")
			->row();
		$data_query								    = $this->query
		("
			SELECT
				B.No_SPP,
				B.Tgl_SPP,
				B.Jn_SPP,
				N.Nm_Jn_SPM,
				CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Unit), 2) AS Kd_Unit_Gab,
				CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Sub), 2) AS Kd_Sub_Gab,
				E.Nm_Unit, D.Nm_Sub_Unit, C.Alamat,
				CASE
				    WHEN K.Jml_Keg > 1 THEN '-'
				    WHEN B.Jn_SPP = 1 THEN '-'
				    WHEN K.Kd_Prog = 0 THEN CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Unit), 2) + '.00.00.5.1'
				    ELSE CONVERT(varchar, K.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, K.Kd_Bidang1), 2) + '.' + CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Unit), 2) + '.' +
				         CASE LEN(CONVERT(varchar, K.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, K.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, K.Kd_Prog), 2) END + '.' +
				         CASE LEN(CONVERT(varchar, K.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, K.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, K.Kd_Keg), 2) END + '.5.2'
				    END AS No_DPA,
				CASE
				    WHEN (I.Tgl_DPPA IS NOT NULL) THEN
				        CASE
				            WHEN B.Tgl_SPP > I.Tgl_DPPA THEN I.Tgl_DPPA
				            ELSE I.Tgl_DPA
				            END
				    ELSE I.Tgl_DPA
				    END AS Tgl_DPA,
				CASE
				    WHEN K.Jml_Keg = 1 THEN CONVERT(varchar, K.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, K.Kd_Bidang1), 2)
				    ELSE CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2)
				    END AS Kd_Bidang_Gab,
				CASE
				    WHEN K.Jml_Keg = 1 THEN K.Nm_Urusan + ' ' + K.Nm_Bidang
				    ELSE G.Nm_Urusan + ' ' + F.Nm_Bidang
				    END AS Nm_Bidang_Gab,
				CASE
				    WHEN K.Jml_Keg > 1 THEN '-'
				    WHEN K.Kd_Prog = 0 THEN '-'
				    ELSE CASE LEN(CONVERT(varchar, K.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, K.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, K.Kd_Prog), 2) END
				    END AS Kd_Prog_Gab,
				CASE
				    WHEN K.Jml_Keg > 1 THEN '-'
				    WHEN K.Kd_Prog = 0 THEN '-'
				    ELSE CASE LEN(CONVERT(varchar, K.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, K.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, K.Kd_Keg), 2) END
				    END AS Kd_Keg_Gab,
				CASE
				    WHEN K.Jml_Keg > 1 THEN '-'
				    WHEN K.Kd_Prog = 0 THEN '-'
				    ELSE K.Ket_Program
				    END AS Ket_Program,
				CASE
				    WHEN K.Jml_Keg > 1 THEN '-'
				    WHEN K.Kd_Prog = 0 THEN '-'
				    ELSE K.Ket_Kegiatan
				    END AS Ket_Kegiatan,
				M.Ur_Peraturan, M.No_Peraturan, M.Nm_Peraturan, A.Nilai_SPP, B.Uraian,
				B.Nm_Penerima, B.Alamat_Penerima, B.Bank_Penerima, B.Rek_Penerima,
				H.Nm_Bendahara, H.Nip_Bendahara, H.Jbt_Bendahara,
				B.Nama_PPTK, B.Nip_PPTK, UPPER(J.Nm_Pemda) AS Nm_Pemda, J.Logo, J.Ibukota
			FROM
			    (
			        SELECT
						Tahun,
						No_SPP,
						SUM(Usulan) AS Nilai_SPP
			        FROM
						Ta_SPP_Rinc
			        WHERE
						(Tahun = '$tahun') AND (No_SPP = '$no_spp')
			        GROUP BY Tahun, No_SPP
			    ) A 
			INNER JOIN
			    Ta_SPP B ON A.Tahun = B.Tahun AND
				A.No_SPP = B.No_SPP
			INNER JOIN
				Ta_Sub_Unit C ON B.Tahun = C.Tahun AND 
				B.Kd_Urusan = C.Kd_Urusan AND 
				B.Kd_Bidang = C.Kd_Bidang AND 
				B.Kd_Unit = C.Kd_Unit AND 
				B.Kd_Sub = C.Kd_Sub
			INNER JOIN
			    Ref_Sub_Unit D ON C.Kd_Urusan = D.Kd_Urusan AND
				C.Kd_Bidang = D.Kd_Bidang AND
				C.Kd_Unit = D.Kd_Unit AND
				C.Kd_Sub = D.Kd_Sub
			INNER JOIN
				Ref_Unit E ON D.Kd_Urusan = E.Kd_Urusan AND
				D.Kd_Bidang = E.Kd_Bidang AND
				D.Kd_Unit = E.Kd_Unit
			INNER JOIN
			    Ref_Bidang F ON E.Kd_Urusan = F.Kd_Urusan AND
				E.Kd_Bidang = F.Kd_Bidang
			INNER JOIN
				Ref_Urusan G ON F.Kd_Urusan = G.Kd_Urusan
			INNER JOIN
		    (
		        SELECT A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, Nama AS Nm_Bendahara, Nip AS Nip_Bendahara, Jabatan AS Jbt_Bendahara
		        FROM Ta_Sub_Unit_Jab A INNER JOIN
		             (
		                 SELECT Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab, MIN(No_Urut) AS No_Urut
		                 FROM Ta_Sub_Unit_Jab
		                 GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
		             ) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Jab = B.Kd_Jab AND A.No_Urut = B.No_Urut
		        WHERE (A.Tahun = '$tahun') AND (A.Kd_Jab = 4)
	    	) H ON C.Tahun = H.Tahun AND C.Kd_Urusan = H.Kd_Urusan AND C.Kd_Bidang = H.Kd_Bidang AND C.Kd_Unit = H.Kd_Unit AND C.Kd_Sub = H.Kd_Sub
			INNER JOIN
				Ta_Pemda J ON A.Tahun = J.Tahun
			INNER JOIN
				Ref_Jenis_SPM N ON B.Jn_SPP = N. Jn_SPM
			LEFT OUTER JOIN
				Ta_DASK I ON C.Tahun = I.Tahun AND 
				C.Kd_Urusan = I.Kd_Urusan AND
				C.Kd_Bidang = I.Kd_Bidang AND
				C.Kd_Unit = I.Kd_Unit AND
				C.Kd_Sub = I.Kd_Sub
			LEFT OUTER JOIN
		    (
		        SELECT
					A.Tahun, A.Uraian AS Ur_Peraturan,
					A.No_Peraturan,
	               CASE A.Kd_Peraturan
	                   WHEN 3 THEN 'Penjabaran APBD'
	                   ELSE 'Penjabaran Perubahan APBD'
	                   END AS Nm_Peraturan
		        FROM Ta_Peraturan A
				INNER JOIN
				(
					SELECT
						Tahun,
						MAX(Kd_Peraturan) AS Kd_Peraturan
					FROM
						Ta_Peraturan
					WHERE (Tahun = '$tahun') AND
						(Kd_Peraturan IN (3, 4)) AND
						(Tgl_Peraturan <= '$spp_query->Tgl_SPP')
					GROUP BY Tahun
				) B ON A.Tahun = B.Tahun AND A.Kd_Peraturan = B.Kd_Peraturan
		    ) M ON A.Tahun = M.Tahun,
		    (
		        SELECT
					A.Tahun,
					A.No_SPP,
					COUNT(*) AS Jml_Keg,
					MIN(A.Kd_Prog) AS Kd_Prog, MIN(A.Kd_Keg) AS Kd_Keg,
					MIN(A.Ket_Program) AS Ket_Program, MIN(A.Ket_Kegiatan) AS Ket_Kegiatan,
					MIN(A.Kd_Urusan1) AS Kd_Urusan1, MIN(A.Kd_Bidang1) AS Kd_Bidang1,
					MIN(A.Nm_Urusan) AS Nm_Urusan, MIN(A.Nm_Bidang) AS Nm_Bidang
		        FROM
		            (
		                SELECT
							A.Tahun,
							A.No_SPP,
							A.Kd_Prog,
							A.ID_Prog,
							A.Kd_Keg,
	                       MIN(C.Ket_Program) AS Ket_Program, MIN(B.Ket_Kegiatan) AS Ket_Kegiatan,
	                       MIN(C.Kd_Urusan1) AS Kd_Urusan1, MIN(C.Kd_Bidang1) AS Kd_Bidang1,
	                       MIN(E.Nm_Urusan) AS Nm_Urusan, MIN(D.Nm_Bidang) AS Nm_Bidang
		                FROM Ta_SPP_Rinc A
						INNER JOIN
							Ta_Kegiatan B ON A.Tahun = B.Tahun AND
							A.Kd_Urusan = B.Kd_Urusan AND
							A.Kd_Bidang = B.Kd_Bidang AND
							A.Kd_Unit = B.Kd_Unit AND
							A.Kd_Sub = B.Kd_Sub AND
							A.Kd_Prog = B.Kd_Prog AND
							A.ID_Prog = B.ID_Prog AND
							A.Kd_Keg = B.Kd_Keg
						INNER JOIN
							Ta_Program C ON B.Tahun = C.Tahun AND
							B.Kd_Urusan = C.Kd_Urusan AND
							B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit AND
							B.Kd_Sub = C.Kd_Sub AND
							B.Kd_Prog = C.Kd_Prog AND
							B.ID_Prog = C.ID_Prog
						INNER JOIN
							Ref_Bidang D ON C.Kd_Urusan1 = D.Kd_Urusan AND
							C.Kd_Bidang1 = D.Kd_Bidang
						INNER JOIN
							Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
		                WHERE (A.Tahun = '$tahun') AND
							(A.No_SPP = '$no_spp')
		                GROUP BY A.Tahun, A.No_SPP, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
		            ) A
		        GROUP BY A.Tahun, A.No_SPP
		    ) K
		")
			->row();
		$output										= array
		(
			'no_spp'							    => $no_spp,
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		//print_r($output);exit;
		return $output;
	}

	public function spp2($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$spp_query								    = $this->query
		("
			SELECT 
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.Tgl_SPP,
				A.Jn_SPP,
				A.Tahun,
		       	B.Kd_Rek_1
			FROM Ta_SPP A, Ta_SPP_Rinc B
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = B.No_SPP
			  AND A.No_SPP = '$no_spp'
		")
			->row();
		$no_sp2d								    = $this->query
		("
			SELECT 
				ISNULL(C.No_SP2D, REPLICATE(' Z ', 50)) AS no_sp2d
			FROM 
				Ta_SPP A
			INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
			LEFT OUTER JOIN Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = '$no_spp'
		")
			->row('no_sp2d');

		$jn_in                                      = array('2', '5');
		if (in_array($spp_query->Jn_SPP, $jn_in))
		{
			$tmpSPP                                =
				("
				SELECT 
				       A.Tahun,
				       B.No_SPP,
				       A.Kd_Urusan,
				       A.Kd_Bidang,
				       A.Kd_Unit,
				       A.Kd_Sub,
				       A.Kd_Prog,
				       A.ID_Prog,
				       A.Kd_Keg
				FROM 
				     Ta_Pengesahan_SPJ_Rinc A 
			    INNER JOIN
					Ta_SPP B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_SPJ
				WHERE 
					B.Tahun = '$tahun' 
				  AND B.No_SPP = '$no_spp'
				GROUP BY A.Tahun, B.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
			");
		}
		else
		{
			$tmpSPP                                =
				("
				SELECT A.Tahun,
				       A.No_SPP,
				       A.Kd_Urusan,
				       A.Kd_Bidang,
				       A.Kd_Unit,
				       A.Kd_Sub,
				       A.Kd_Prog,
				       A.ID_Prog,
				       A.Kd_Keg
				FROM 
				     Ta_SPP_Rinc A
				WHERE 
					A.Tahun = '$tahun' 
				  AND A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
			");
		}

		if ($spp_query->Jn_SPP <> '1' AND $spp_query->Jn_SPP <> '6')
		{
			$tmpSP2D                                =
				("
				SELECT 
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					ISNULL(SUM(A.SP2D_GU), 0) AS SP2D_GU,
					ISNULL(SUM(A.SP2D_LS), 0) AS SP2D_LS,
					ISNULL(SUM(A.SP2D_TU), 0) AS SP2D_TU,
					ISNULL(SUM(A.SP2D_Nihil), 0) AS SP2D_Nihil
		        FROM
		            (
		                SELECT A.Tahun,
		                       A.Kd_Urusan,
		                       A.Kd_Bidang,
		                       A.Kd_Unit,
		                       A.Kd_Sub,
		                       A.Kd_Prog,
		                       A.ID_Prog,
		                       A.Kd_Keg,
		                       0 AS SP2D_GU,
		                       A.Nilai AS SP2D_LS,
		                       0 AS SP2D_TU,
		                       0 AS SP2D_NIHIL
		                FROM 
							Ta_SPM_Rinc A 
						INNER JOIN
							Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM 
						INNER JOIN
							Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
						INNER JOIN
							($tmpSPP) AS D ON A.Tahun = D.Tahun AND
							A.Kd_Urusan = D.Kd_Urusan AND
							A.Kd_Bidang = D.Kd_Bidang AND
							A.Kd_Unit = D.Kd_Unit AND
							A.Kd_Sub = D.Kd_Sub AND
							A.Kd_Prog = D.Kd_Prog AND
							A.ID_Prog = D.ID_Prog AND
							A.Kd_Keg = D.Kd_Keg
		                WHERE ((C.Tgl_SP2D < '$spp_query->Tgl_SPP') OR ((C.Tgl_SP2D = '$spp_query->Tgl_SPP') AND (C.No_SP2D < '$no_sp2d'))) AND (B.Jn_SPM = 3)

		                UNION ALL

		                SELECT 
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							A.Kd_Prog,
							A.ID_Prog,
							A.Kd_Keg,
							CASE C.Jn_SPM
							   WHEN 2 THEN A.Nilai_Setuju
							   ELSE 0
							   END AS SP2D_GU,
							0 AS SP2D_LS,
							CASE
							   WHEN (C.Jn_SPM = 5) AND (A.Jn_SPJ = 4) THEN A.Nilai_Setuju
							   ELSE 0
							   END AS SP2D_TU,
							CASE
							   WHEN (C.Jn_SPM = 5) AND (A.Jn_SPJ = 2) THEN A.Nilai_Setuju
							   ELSE 0
							   END AS SP2D_NIHIL
		                FROM
		                    (
		                        SELECT
									B.Tahun,
									B.No_Pengesahan,
									A.Kd_Urusan,
									A.Kd_Bidang,
									A.Kd_Unit,
									A.Kd_Sub,
									A.Kd_Prog,
									A.ID_Prog,
									A.Kd_Keg,
									C.Jn_SPJ,
									SUM(A.Nilai_Setuju) AS Nilai_Setuju
		                        FROM
		                            Ta_Pengesahan_SPJ_Rinc A 
								INNER JOIN
		                            Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND
		                            A.No_Pengesahan = B.No_Pengesahan
	                            INNER JOIN
		                            Ta_SPJ C ON B.Tahun = C.Tahun AND
		                            B.No_SPJ = C.No_SPJ
		                        WHERE
		                        	C.Tahun = '$tahun' AND 
		                        	C.Kd_Urusan = '$spp_query->Kd_Urusan' AND
		                        	C.Kd_Bidang = '$spp_query->Kd_Bidang' AND
		                        	C.Kd_Unit = '$spp_query->Kd_Unit' AND
		                        	C.Kd_Sub = '$spp_query->Kd_Sub'
								GROUP BY B.Tahun, B.No_Pengesahan, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, C.Jn_SPJ
		                    ) A 
		                    INNER JOIN
		                    	Ta_SPP B ON A.Tahun = B.Tahun AND
		                        A.No_Pengesahan = B.No_SPJ
	                        INNER JOIN
			                    Ta_SPM C ON B.Tahun = C.Tahun AND
	                            B.No_SPP = C.No_SPP 
                            INNER JOIN	
			                    Ta_SP2D E ON C.Tahun = E.Tahun AND
	                            C.No_SPM = E.No_SPM
                            INNER JOIN
								($tmpSPP) AS D ON A.Tahun = D.Tahun AND
								A.Kd_Urusan = D.Kd_Urusan AND
								A.Kd_Bidang = D.Kd_Bidang AND
								A.Kd_Unit = D.Kd_Unit AND
								A.Kd_Sub = D.Kd_Sub AND
								A.Kd_Prog = D.Kd_Prog AND
								A.ID_Prog = D.ID_Prog AND
								A.Kd_Keg = D.Kd_Keg
		                WHERE ((E.Tgl_SP2D < '$spp_query->Tgl_SPP') OR ((E.Tgl_SP2D = '$spp_query->Tgl_SPP') AND (E.No_SP2D < '$no_sp2d')))

		                UNION ALL

		                SELECT 
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							A.Kd_Prog,
							A.ID_Prog,
							A.Kd_Keg,
						CASE B.Jn_SPM
						   WHEN 2 THEN
						       CASE A.D_K
						           WHEN 'D' THEN A.Nilai
						           ELSE -A.Nilai
						           END
						   ELSE 0
						   END AS SP2D_GU,
						CASE B.Jn_SPM
						   WHEN 3 THEN
						       CASE A.D_K
						           WHEN 'D' THEN A.Nilai
						           ELSE -A.Nilai
						           END
						   ELSE 0
						   END AS SP2D_LS,
						CASE B.Jn_SPM
						   WHEN 4 THEN
						       CASE A.D_K
						           WHEN 'D' THEN A.Nilai
						           ELSE -A.Nilai
						           END
						   ELSE 0
						   END AS SP2D_TU,
						CASE B.Jn_SPM
						   WHEN 5 THEN
						       CASE A.D_K
						           WHEN 'D' THEN A.Nilai
						           ELSE -A.Nilai
						           END
						   ELSE 0
						   END AS SP2D_NIHIL
		                FROM 
							Ta_Penyesuaian_Rinc A
						INNER JOIN
							Ta_Penyesuaian B ON A.Tahun = B.Tahun AND
		                    A.No_Bukti = B.No_Bukti
					    INNER JOIN
							($tmpSPP) AS D ON A.Tahun = D.Tahun AND
							A.Kd_Urusan = D.Kd_Urusan AND
							A.Kd_Bidang = D.Kd_Bidang AND
							A.Kd_Unit = D.Kd_Unit AND
							A.Kd_Sub = D.Kd_Sub AND
							A.Kd_Prog = D.Kd_Prog AND
							A.ID_Prog = D.ID_Prog AND
							A.Kd_Keg = D.Kd_Keg
		                WHERE (B.Jns_P1 = 1) AND (B.Jns_P2 IN (2, 3)) AND (B.Tgl_Bukti <= '$spp_query->Tgl_SPP')
		            ) A
		        GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
			");
		}

		if ($spp_query->Jn_SPP <> '1' AND $spp_query->Jn_SPP = '6')
		{
			$tmpSP2D                                =
				("
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					ISNULL(SUM(A.SP2D_GU), 0) AS SP2D_GU,
					ISNULL(SUM(A.SP2D_LS), 0) AS SP2D_LS,
					ISNULL(SUM(A.SP2D_TU), 0) AS SP2D_TU,
					ISNULL(SUM(A.SP2D_Nihil), 0) AS SP2D_Nihil
				FROM
				(
				    SELECT
						A.Tahun,
						A.Kd_Urusan,
						A.Kd_Bidang,
						A.Kd_Unit,
						A.Kd_Sub,
						A.Kd_Prog,
						A.ID_Prog,
						A.Kd_Keg,
						0 AS SP2D_GU,
						CASE B.Jn_SPM
						   WHEN 3 THEN A.Nilai
						   ELSE 0
						   END AS SP2D_LS,
						0 AS SP2D_TU,
						0 AS SP2D_NIHIL
				    FROM 
				         Ta_SPM_Rinc A
					INNER JOIN
						Ta_SPM B ON A.Tahun = B.Tahun AND
						A.No_SPM = B.No_SPM 
					INNER JOIN
						Ta_SP2D C ON B.Tahun = C.Tahun AND
						B.No_SPM = C.No_SPM 
					INNER JOIN
						($tmpSPP) AS D ON A.Tahun = D.Tahun AND
						A.Kd_Urusan = D.Kd_Urusan AND
						A.Kd_Bidang = D.Kd_Bidang AND
						A.Kd_Unit = D.Kd_Unit AND
						A.Kd_Sub = D.Kd_Sub AND
						A.Kd_Prog = D.Kd_Prog AND
						A.ID_Prog = D.ID_Prog AND
						A.Kd_Keg = D.Kd_Keg
				    WHERE ((C.Tgl_SP2D < '$spp_query->Tgl_SPP') OR ((C.Tgl_SP2D = '$spp_query->Tgl_SPP') AND (C.No_SP2D < '$no_sp2d'))) AND (B.Jn_SPM = 3) AND (A.Kd_Rek_1 = 6)
				) A
				GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg
			");
		}

		$data_query								    = $this->query
		("
			SELECT
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.Kd_Prog,
				A.ID_Prog,
				A.Kd_Keg,
				B.No_SPP,
				B.Tgl_SPP,
				B.Jn_SPP,
				K.Nm_Jn_SPM,
				CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Unit), 2) AS Kd_Unit_Gab,
				CONVERT(varchar, D.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, D.Kd_Sub), 2) AS Kd_Sub_Gab,
				E.Nm_Unit, D.Nm_Sub_Unit, C.Alamat,
				CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) AS Kd_Bidang_Gab,
				G.Nm_Urusan + ' ' + F.Nm_Bidang AS Nm_Bidang_Gab,
				CASE
					WHEN A.Kd_Prog = 0 THEN '-'
					ELSE CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END
				END AS Kd_Prog_Gab,
				CASE
					WHEN A.Kd_Prog = 0 THEN '-'
					ELSE CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END
				END AS Kd_Keg_Gab,
				CASE
					WHEN A.Kd_Prog = 0 THEN '-'
					ELSE Q.Ket_Program
				END AS Ket_Program,
				CASE
					WHEN A.Kd_Prog = 0 THEN '-'
					ELSE P.Ket_Kegiatan
				END AS Ket_Kegiatan,
				R.Nama AS Nama_PT, R.Bentuk, R.Alamat AS Alamat_PT, R.Nm_Pimpinan AS Nm_Pimpinan_PT,
				ISNULL(R.Nm_Bank, '') + ' ' + ISNULL(R.No_Rekening, '') AS Bank_PT, R.No_Kontrak, R.No_Addendum,
				CASE
					WHEN R.Tahun IS NULL THEN B.Uraian
					ELSE R.Keperluan
				END AS Keperluan,
				N.No_SPD AS No_Dasar, N.Tgl_SPD AS Tgl_Dasar, N.Nilai_Dasar,
				CASE B.Jn_SPP
					WHEN 1 THEN '-'
					ELSE
						CASE
						WHEN A.Kd_Prog = 0 AND '$spp_query->Kd_Rek_1' <> 6 THEN CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.00.00.5.1'
						WHEN A.Kd_Prog = 0 AND '$spp_query->Kd_Rek_1' = 6 THEN CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.00.00.6.2'
						ELSE CONVERT(varchar, Q.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, Q.Kd_Bidang1), 2) + ' . ' + CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + ' . ' +
							CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + ' . ' +
							CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END + ' . 5 . 2'
						END
				END AS No_DPA,
				CASE
				WHEN (I.Tgl_DPPA IS NOT NULL) THEN
					CASE
						WHEN B.Tgl_SPP > I.Tgl_DPPA THEN I.Tgl_DPPA
						ELSE I.Tgl_DPA
					END
				ELSE I.Tgl_DPA
				END AS Tgl_DPA,
				ISNULL(O.SP2D_GU, 0) AS Nilai_GU,
				ISNULL(O.SP2D_LS, 0) AS Nilai_LS,
				ISNULL(O.SP2D_TU, 0) AS Nilai_TU,
				ISNULL(O.SP2D_Nihil, 0) AS Nilai_Nihil,
				ISNULL(O.SP2D_GU, 0) + ISNULL(O.SP2D_LS, 0) + ISNULL(O.SP2D_TU, 0) + ISNULL(O.SP2D_Nihil, 0) AS SP2D_Total,
				L.Anggaran, M.No_SPD, M.Tgl_SPD, M.Nilai_SPD,
				H.Nm_Bendahara, H.Nip_Bendahara, H.Jbt_Bendahara,
				B.Nama_PPTK,
				B.Nip_PPTK,
				UPPER(J.Nm_Pemda) AS Nm_Pemda,
				J.Logo,
				J.Ibukota
			FROM
				($tmpSPP) A
			INNER JOIN
				Ta_SPP B ON A.Tahun = B.Tahun AND
				A.No_SPP = B.No_SPP
			INNER JOIN
				Ta_Sub_Unit C ON B.Tahun = C.Tahun AND
				B.Kd_Urusan = C.Kd_Urusan AND
				B.Kd_Bidang = C.Kd_Bidang AND
				B.Kd_Unit = C.Kd_Unit AND
				B.Kd_Sub = C.Kd_Sub
			INNER JOIN
				Ref_Sub_Unit D ON C.Kd_Urusan = D.Kd_Urusan AND
				C.Kd_Bidang = D.Kd_Bidang AND
				C.Kd_Unit = D.Kd_Unit AND
				C.Kd_Sub = D.Kd_Sub
			INNER JOIN
				Ref_Unit E ON D.Kd_Urusan = E.Kd_Urusan AND
				D.Kd_Bidang = E.Kd_Bidang AND
				D.Kd_Unit = E.Kd_Unit
			INNER JOIN
				Ta_Kegiatan P ON A.Tahun = P.Tahun AND
				A.Kd_Urusan = P.Kd_Urusan AND
				A.Kd_Bidang = P.Kd_Bidang AND
				A.Kd_Unit = P.Kd_Unit AND
				A.Kd_Sub = P.Kd_Sub AND
				A.Kd_Prog = P.Kd_Prog AND
				A.ID_Prog = P.ID_Prog AND
				A.Kd_Keg = P.Kd_Keg
			INNER JOIN
				Ta_Program Q ON P.Tahun = Q.Tahun AND
				P.Kd_Urusan = Q.Kd_Urusan AND
				P.Kd_Bidang = Q.Kd_Bidang AND
				P.Kd_Unit = Q.Kd_Unit AND
				P.Kd_Sub = Q.Kd_Sub AND
				P.Kd_Prog = Q.Kd_Prog AND
				P.ID_Prog = Q.ID_Prog
			INNER JOIN
				Ref_Bidang F ON Q.Kd_Urusan1 = F.Kd_Urusan AND Q.Kd_Bidang1 = F.Kd_Bidang INNER JOIN
				Ref_Urusan G ON F.Kd_Urusan = G.Kd_Urusan
			INNER JOIN
			(
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					Nama AS Nm_Bendahara,
					Nip AS Nip_Bendahara,
					Jabatan AS Jbt_Bendahara
				FROM Ta_Sub_Unit_Jab A 
				INNER JOIN
				(
					SELECT
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub,
						Kd_Jab,
						MIN(No_Urut) AS No_Urut
					FROM
					     Ta_Sub_Unit_Jab
					GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
				) B ON A.Tahun = B.Tahun AND
				       A.Kd_Urusan = B.Kd_Urusan AND
				       A.Kd_Bidang = B.Kd_Bidang AND
				       A.Kd_Unit = B.Kd_Unit AND
				       A.Kd_Sub = B.Kd_Sub AND
				       A.Kd_Jab = B.Kd_Jab AND
				       A.No_Urut = B.No_Urut
				WHERE (A.Tahun = '$tahun') AND (A.Kd_Jab = 4)
			) H ON C.Tahun = H.Tahun AND C.Kd_Urusan = H.Kd_Urusan AND C.Kd_Bidang = H.Kd_Bidang AND C.Kd_Unit = H.Kd_Unit AND C.Kd_Sub = H.Kd_Sub
			INNER JOIN
				Ta_Pemda J ON A.Tahun = J.Tahun
			INNER JOIN
				Ref_Jenis_SPM K ON B.Jn_SPP = K.Jn_SPM
			INNER JOIN
			(
				SELECT
					Tahun,
					Kd_Urusan,
					Kd_Bidang,
					Kd_Unit,
					Kd_Sub,
					Kd_Prog,
					ID_Prog,
					Kd_Keg,
					SUM(Anggaran) AS Anggaran
				FROM
					(
						SELECT
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub,
							CASE '$spp_query->Jn_SPP' WHEN 1 THEN 0 ELSE Kd_Prog END AS Kd_Prog,
							CASE '$spp_query->Jn_SPP' WHEN 1 THEN 0 ELSE ID_Prog END AS ID_Prog,
							CASE '$spp_query->Jn_SPP' WHEN 1 THEN 0 ELSE Kd_Keg END AS Kd_Keg, SUM(Total) AS Anggaran
						FROM
						     Ta_RASK_Arsip
						WHERE (Tahun = '$tahun') AND
						      (Kd_Perubahan = (SELECT MAX(Kd_Perubahan) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$spp_query->Tgl_SPP' AND Kd_Perubahan IN (4, 6, 8))) AND
						      (Kd_Rek_1 = 5) AND
						      ('$spp_query->Kd_Rek_1' <> 6)
						GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub,
						CASE '$spp_query->Jn_SPP' WHEN 1 THEN 0 ELSE Kd_Prog END,
						CASE '$spp_query->Jn_SPP' WHEN 1 THEN 0 ELSE ID_Prog END,
						CASE '$spp_query->Jn_SPP' WHEN 1 THEN 0 ELSE Kd_Keg END

						UNION ALL

						SELECT
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub,
							Kd_Prog,
							ID_Prog,
							Kd_Keg,
							SUM(Total) AS Anggaran
						FROM 
							Ta_RASK_Arsip
						WHERE (Tahun = '$tahun') AND
							(Kd_Perubahan = (SELECT MAX(Kd_Perubahan) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$spp_query->Tgl_SPP' AND Kd_Perubahan IN (4, 6, 8))) AND
							(Kd_Rek_1 = 6 AND Kd_Rek_2 = 2) AND
							('$spp_query->Kd_Rek_1' = 6)
						GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg

						UNION ALL

						SELECT
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub,
							Kd_Prog,
							ID_Prog,
							Kd_Keg, 0 AS Anggaran
						FROM ($tmpSPP) AS AX
					) A
				GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg
			) L ON A.Tahun = L.Tahun AND
				A.Kd_Urusan = L.Kd_Urusan AND
				A.Kd_Bidang = L.Kd_Bidang AND
				A.Kd_Unit = L.Kd_Unit AND
				A.Kd_Sub = L.Kd_Sub AND
				A.Kd_Prog = L.Kd_Prog AND
				A.ID_Prog = L.ID_Prog AND
				A.Kd_Keg = L.Kd_Keg
			INNER JOIN
			(
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					B.No_SPD,
					B.Tgl_SPD,
					SUM(A.Nilai) AS Nilai_SPD
				FROM
					Ta_SPD_Rinc A
			    INNER JOIN
					Ta_SPD B ON A.Tahun = B.Tahun AND
		            A.No_SPD = B.No_SPD
				WHERE (B.Tahun = '$tahun') AND
				      (B.Tgl_SPD <= '$spp_query->Tgl_SPP') AND
				      ('$spp_query->Jn_SPP' <> 1) AND
				      (A.Kd_Rek_1 = 5 AND '$spp_query->Kd_Rek_1' <> 6)
				GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, B.No_SPD, B.Tgl_SPD

				UNION ALL

				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					B.No_SPD,
					B.Tgl_SPD,
					SUM(A.Nilai) AS Nilai_SPD
				FROM
					Ta_SPD_Rinc A
				INNER JOIN
					Ta_SPD B ON A.Tahun = B.Tahun AND
					A.No_SPD = B.No_SPD
				WHERE
					(B.Tahun = '$tahun') AND
					(B.Tgl_SPD <= '$spp_query->Tgl_SPP') AND
					('$spp_query->Jn_SPP' <> 1) AND
					(A.Kd_Rek_1 = 6 AND
					'$spp_query->Kd_Rek_1' = 6)
				GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, B.No_SPD, B.Tgl_SPD
		
				UNION ALL
		
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					0,
					0,
					0,
					NULL,
					NULL,
					0 AS Nilai_SPD
				FROM
					Ta_SPP A
				WHERE
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp' AND
					('$spp_query->Jn_SPP' = 1)
			) M ON A.Tahun = M.Tahun AND
			       A.Kd_Urusan = M.Kd_Urusan AND
			       A.Kd_Bidang = M.Kd_Bidang AND
			       A.Kd_Unit = M.Kd_Unit AND
			       A.Kd_Sub = M.Kd_Sub AND
			       A.Kd_Prog = M.Kd_Prog AND
			       A.ID_Prog = M.ID_Prog AND
			       A.Kd_Keg = M.Kd_Keg 
			LEFT OUTER JOIN
			(
				SELECT
					B.Tahun,
					B.No_SPD,
					B.Tgl_SPD,
					SUM(A.Nilai) AS Nilai_Dasar
				FROM
					Ta_SPD_Rinc A
			    INNER JOIN
					Ta_SPD B ON A.Tahun = B.Tahun AND
					A.No_SPD = B.No_SPD
				GROUP BY B.Tahun, B.No_SPD, B.Tgl_SPD
			) N ON B.Tahun = N.Tahun AND B.No_SPD = N.No_SPD 
		    LEFT OUTER JOIN
				($tmpSP2D) O ON A.Tahun = O.Tahun AND
	             A.Kd_Urusan = O.Kd_Urusan AND
	             A.Kd_Bidang = O.Kd_Bidang AND
	             A.Kd_Unit = O.Kd_Unit AND
	             A.Kd_Sub = O.Kd_Sub AND
	             A.Kd_Prog = O.Kd_Prog AND
	             A.ID_Prog = O.ID_Prog AND
	             A.Kd_Keg = O.Kd_Keg
			LEFT OUTER JOIN
				Ta_SPP_Kontrak R ON B.Tahun = R.Tahun AND
                B.No_SPP = R.No_SPP
			LEFT OUTER JOIN
				Ta_DASK I ON C.Tahun = I.Tahun AND
				C.Kd_Urusan = I.Kd_Urusan AND
				C.Kd_Bidang = I.Kd_Bidang AND 
				C.Kd_Unit = I.Kd_Unit AND
				C.Kd_Sub = I.Kd_Sub
			ORDER BY M.Tgl_SPD, M.No_SPD
		")
			->row();
		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun'],
			'no_spp'								=> $params['no_spp']
		);
		//print_r($output);exit;
		return $output;
	}

	public function spp3($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$header_query								= $this->query
		("
			SELECT
				ta_spp_rinc.no_spp,
				ref_sub_unit.nm_sub_unit
			FROM
				ta_spp_rinc
			INNER JOIN ta_spp ON 
				ta_spp_rinc.no_spp = ta_spp.no_spp AND
				ta_spp_rinc.tahun = ta_spp.tahun
			INNER JOIN
				ref_sub_unit ON 
				ta_spp.kd_urusan = ref_sub_unit.kd_urusan AND
				ta_spp.kd_bidang = ref_sub_unit.kd_bidang AND
				ta_spp.kd_unit = ref_sub_unit.kd_unit AND
				ta_spp.kd_sub = ref_sub_unit.kd_sub
			WHERE
				ta_spp.no_spp = '$no_spp'
		")
			->row();
		$spp_query								    = $this->query
		("
			SELECT 
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.No_SPP,
				A.Tgl_SPP,
				A.Jn_SPP,
				A.Tahun,
		       	B.Kd_Rek_1
			FROM Ta_SPP A, Ta_SPP_Rinc B
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = B.No_SPP
			  AND A.No_SPP = '$no_spp'
		")
			->row();

		$jn_in                                      = array('2', '5');
		if($no_spp == $spp_query->No_SPP && in_array($spp_query->Jn_SPP, $jn_in))
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					B.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
					A.Kd_Rek_4,
					A.Kd_Rek_5,
					SUM(A.Nilai_Setuju) AS Nilai
				FROM
				     Ta_Pengesahan_SPJ_Rinc A
				INNER JOIN
					Ta_SPP B ON A.Tahun = B.Tahun AND
					A.No_Pengesahan = B.No_SPJ
				WHERE 
					B.Tahun = '$tahun' AND
					B.No_SPP = '$no_spp'
				GROUP BY A.Tahun, B.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
			");
		}
		elseif($no_spp == $spp_query->No_SPP && $spp_query->Jn_SPP == '4')
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					A.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					0,
					0,
					0,
					1,
					1,
					1,
					3,
					1,
					SUM(A.Usulan) AS Nilai
				FROM
					Ta_SPP_Rinc A
				WHERE 
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}
		else
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					A.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
					A.Kd_Rek_4,
					A.Kd_Rek_5,
					SUM(A.Usulan) AS Nilai
				FROM
					Ta_SPP_Rinc A
				WHERE
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
			");
		}

		$data_query								    = $this->query
		("
			SELECT
				B.No_SPP,
				B.Tgl_SPP,
				B.Jn_SPP,
				G.Nm_Jn_SPM,
				A.Kd_Prog,
				A.ID_Prog,
				A.Kd_Keg,
				CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END AS Kd_Prog_Gab,
				CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + ' . ' + CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Keg_Gab,
				E.Ket_Program, D.Ket_Kegiatan,
				CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek_Gab,
				C.Nm_Rek_5,
				A.Nilai,
				F.Nm_Bendahara, F.Nip_Bendahara, F.Jbt_Bendahara,
				B.Nama_PPTK, B.Nip_PPTK, UPPER(H.Nm_Pemda) AS Nm_Pemda, H.Logo, H.Ibukota
			FROM ($tmpSPP) AS A
			INNER JOIN
				Ta_SPP B ON A.Tahun = B.Tahun AND
				A.No_SPP = B.No_SPP
			INNER JOIN
				Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 AND
				A.Kd_Rek_2 = C.Kd_Rek_2 AND
				A.Kd_Rek_3 = C.Kd_Rek_3 AND
				A.Kd_Rek_4 = C.Kd_Rek_4 AND
				A.Kd_Rek_5 = C.Kd_Rek_5
			INNER JOIN
				Ta_Kegiatan D ON A.Tahun = D.Tahun AND
				A.Kd_Urusan = D.Kd_Urusan AND A.Kd_Bidang = D.Kd_Bidang AND
				A.Kd_Unit = D.Kd_Unit AND
				A.Kd_Sub = D.Kd_Sub AND
				A.Kd_Prog = D.Kd_Prog AND
				A.ID_Prog = D.ID_Prog AND
				A.Kd_Keg = D.Kd_Keg
			INNER JOIN
				Ta_Program E ON D.Tahun = E.Tahun AND
				D.Kd_Urusan = E.Kd_Urusan AND
				D.Kd_Bidang = E.Kd_Bidang AND
				D.Kd_Unit = E.Kd_Unit AND
				D.Kd_Sub = E.Kd_Sub AND
				D.Kd_Prog = E.Kd_Prog AND
				D.ID_Prog = E.ID_Prog
			INNER JOIN
			(
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					Nama AS Nm_Bendahara,
					Nip AS Nip_Bendahara,
					Jabatan AS Jbt_Bendahara
				FROM Ta_Sub_Unit_Jab A
				INNER JOIN
				(
					SELECT
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub,
						Kd_Jab,
						MIN(No_Urut) AS No_Urut
					FROM
						Ta_Sub_Unit_Jab
					GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
				) B ON A.Tahun = B.Tahun AND
					A.Kd_Urusan = B.Kd_Urusan AND
					A.Kd_Bidang = B.Kd_Bidang AND
					A.Kd_Unit = B.Kd_Unit AND
					A.Kd_Sub = B.Kd_Sub AND
					A.Kd_Jab = B.Kd_Jab AND
					A.No_Urut = B.No_Urut
				WHERE (A.Tahun = '$tahun') AND (A.Kd_Jab = 4)
			) F ON E.Tahun = F.Tahun AND E.Kd_Urusan = F.Kd_Urusan AND E.Kd_Bidang = F.Kd_Bidang AND E.Kd_Unit = F.Kd_Unit AND E.Kd_Sub = F.Kd_Sub 
			INNER JOIN
				Ref_Jenis_SPM G ON B.Jn_SPP = G.Jn_SPM
			INNER JOIN
				Ta_Pemda H ON F.Tahun = H.Tahun
			ORDER BY A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();
		$output										= array
		(
			'no_spp'							    => $no_spp,
			'header_query'							=> $header_query,
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		//print_r($data_query);exit;
		return $output;
	}

	public function spp_tu($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$header_query								= $this->query
		("
			SELECT
				ref_sub_unit.kd_urusan,
				ref_sub_unit.kd_bidang,
				ref_sub_unit.kd_unit,
				ref_sub_unit.kd_sub,
				ref_urusan.nm_urusan,
				ref_bidang.nm_bidang,
				ref_unit.nm_unit,
				ta_program.kd_prog,
				ta_kegiatan.kd_keg,
				ta_program.ket_program,
				ta_kegiatan.ket_kegiatan,
				ref_sub_unit.nm_sub_unit,
				ta_sub_unit.nm_pimpinan AS nama_pejabat,
				ta_sub_unit.jbt_pimpinan AS nama_jabatan,
				ta_sub_unit.nip_pimpinan AS nip_pejabat,
                ta_sub_unit_jab.nama AS nama_bendahara,
				ta_sub_unit_jab.jabatan AS nama_jabatan_bendahara,
				ta_sub_unit_jab.nip AS nip_bendahara,
				ta_spp.no_spp
			FROM
				ref_sub_unit
			INNER JOIN ta_sub_unit ON
				ref_sub_unit.kd_bidang = ta_sub_unit.kd_bidang AND
				ref_sub_unit.kd_sub = ta_sub_unit.kd_sub AND
				ref_sub_unit.kd_unit = ta_sub_unit.kd_unit AND
				ref_sub_unit.kd_urusan = ta_sub_unit.kd_urusan
			INNER JOIN ta_sub_unit_jab ON
				ta_sub_unit.kd_bidang = ta_sub_unit_jab.kd_bidang AND
				ta_sub_unit.kd_sub = ta_sub_unit_jab.kd_sub AND
				ta_sub_unit.kd_unit = ta_sub_unit_jab.kd_unit AND
				ta_sub_unit.kd_urusan = ta_sub_unit_jab.kd_urusan AND
				ta_sub_unit.tahun = ta_sub_unit_jab.tahun
			INNER JOIN ta_program ON
				ta_sub_unit.kd_bidang = ta_program.kd_bidang AND
				ta_sub_unit.kd_sub = ta_program.kd_sub AND
				ta_sub_unit.kd_unit = ta_program.kd_unit AND
				ta_sub_unit.kd_urusan = ta_program.kd_urusan AND
				ta_sub_unit.tahun = ta_program.tahun
			INNER JOIN ta_kegiatan ON
				ta_program.id_prog = ta_kegiatan.id_prog AND
				ta_program.kd_bidang = ta_kegiatan.kd_bidang AND
				ta_program.kd_prog = ta_kegiatan.kd_prog AND
				ta_program.kd_sub = ta_kegiatan.kd_sub AND
				ta_program.kd_unit = ta_kegiatan.kd_unit AND
				ta_program.kd_urusan = ta_kegiatan.kd_urusan AND
				ta_program.tahun = ta_kegiatan.tahun
			INNER JOIN ref_unit ON
				ref_sub_unit.kd_bidang = ref_unit.kd_bidang AND
				ref_sub_unit.kd_unit = ref_unit.kd_unit AND
				ref_sub_unit.kd_urusan = ref_unit.kd_urusan
			INNER JOIN ref_bidang ON
				ref_unit.kd_bidang = ref_bidang.kd_bidang AND
				ref_unit.kd_urusan = ref_bidang.kd_urusan
			INNER JOIN ref_urusan ON
				ref_bidang.kd_urusan = ref_urusan.kd_urusan
	        INNER JOIN ta_spp ON
                ta_sub_unit.kd_bidang = ta_spp.kd_bidang AND
                ta_sub_unit.kd_sub = ta_spp.kd_sub AND
                ta_sub_unit.kd_unit = ta_spp.kd_unit AND
                ta_sub_unit.kd_urusan = ta_spp.kd_urusan AND
                ta_sub_unit.tahun = ta_spp.tahun
			WHERE
				ta_spp.no_spp = '$no_spp'
			  AND ta_sub_unit_jab.kd_jab = '4'
		")
			->row();
		$data_query								    = $this->query
		("
			SELECT 
				B.Tgl_SPP,
				L.Nm_Pimpinan,
				L.Nip_Pimpinan,
				L.Jbt_Pimpinan,
				G.kd_program,
				G.kd_kegiatan,
				G.kd_sub_kegiatan,
				LTRIM(RTRIM(UPPER(N.Nm_Unit))) AS Nm_Unit,
				LTRIM(RTRIM(UPPER(M.Nm_Sub_Unit))) AS Nm_Sub_Unit,
				RIGHT('0' + CONVERT(varchar, G.kd_program), 2) AS Kd_Prog_Gab,
				RIGHT('0' + CONVERT(varchar, G.kd_program), 2) + ' . ' + G.kd_kegiatan AS Kd_Keg_Gab,
				RIGHT('0' + CONVERT(varchar, G.kd_program), 2) + ' . ' + G.kd_kegiatan + ' . ' +
				RIGHT('0' + CONVERT(varchar, G.kd_sub_kegiatan), 2) AS Kd_Sub_Keg_Gab,
				J.nm_program,
				I.nm_kegiatan,
				G.nm_sub_kegiatan,
				CONVERT(varchar, K.Kd_Rek90_1) + '.' + CONVERT(varchar, K.Kd_Rek90_2) + '.' + CONVERT(varchar, K.Kd_Rek90_3) +
				'.' + RIGHT('0' + CONVERT(varchar, K.Kd_Rek90_4), 2) + '.' + RIGHT('0' + CONVERT(varchar, K.Kd_Rek90_5), 2) +
				'.' + RIGHT('0000' + CONVERT(varchar, K.Kd_Rek90_6), 4) AS Kd_Rek_Gab,
				K.Nm_Rek90_6 AS Nm_Rek_5,
				A.Nilai,
				H.Total,
				O.Nm_Pemda,
				O.Ibukota
			FROM 
				Ta_SPP_Rinc A
			INNER JOIN Ta_SPP B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
			INNER JOIN
		     (
		         SELECT A.Tahun, A.No_SPP, SUM(A.Nilai) AS Total
		         FROM Ta_SPP_Rinc A
		         WHERE (A.Tahun = '$tahun')
		           AND (A.No_SPP = '$no_spp')
		         GROUP BY A.Tahun, A.No_SPP
		     ) H ON B.Tahun = H.Tahun AND B.No_SPP = H.No_SPP
			INNER JOIN
		     ref_rek_mapping C
		     ON A.Kd_Rek_1 = C.Kd_Rek_1 AND A.Kd_Rek_2 = C.Kd_Rek_2 AND A.Kd_Rek_3 = C.Kd_Rek_3 AND A.Kd_Rek_4 = C.Kd_Rek_4 AND
		        A.Kd_Rek_5 = C.Kd_Rek_5
		         INNER JOIN
		     ref_rek90_6 K ON C.kd_rek90_1 = K.kd_rek90_1 AND C.kd_rek90_2 = K.kd_rek90_2 AND C.kd_rek90_3 = K.kd_rek90_3 AND
		                      C.kd_rek90_4 = K.kd_rek90_4 AND C.kd_rek90_5 = K.kd_rek90_5 AND C.kd_rek90_6 = K.kd_rek90_6
		         INNER JOIN
		     ta_program D
		     ON A.tahun = D.tahun AND A.kd_urusan = D.kd_urusan AND A.kd_bidang = D.kd_bidang AND A.kd_unit = D.kd_unit AND
		        A.kd_sub = D.kd_sub AND A.kd_prog = D.kd_prog AND A.id_prog = D.id_prog
		         INNER JOIN
		     ref_kegiatan_mapping E
		     ON D.kd_urusan1 = E.kd_urusan AND D.kd_bidang1 = E.kd_bidang AND D.kd_prog = E.kd_prog AND A.kd_keg = E.kd_keg
		         INNER JOIN
		     ref_sub_kegiatan90 G
		     ON E.kd_urusan90 = G.kd_urusan AND E.kd_bidang90 = G.kd_bidang AND E.kd_program90 = G.kd_program AND
		        E.kd_kegiatan90 = G.kd_kegiatan AND E.kd_sub_kegiatan = G.kd_sub_kegiatan
		         INNER JOIN
		     ref_kegiatan90 I ON G.kd_urusan = I.kd_urusan AND G.kd_bidang = I.kd_bidang AND G.kd_program = I.kd_program AND
		                         G.kd_kegiatan = I.kd_kegiatan
		         INNER JOIN
		     ref_program90 J ON I.kd_urusan = J.kd_urusan AND I.kd_bidang = J.kd_bidang AND I.kd_program = J.kd_program
		         INNER JOIN
		     Ta_Sub_Unit L
		     ON B.Tahun = L.Tahun AND B.Kd_Urusan = L.Kd_Urusan AND B.Kd_Bidang = L.Kd_Bidang AND B.Kd_Unit = L.Kd_Unit AND
		        B.Kd_Sub = L.Kd_Sub
		         INNER JOIN
		     Ref_Sub_Unit M
		     ON L.Kd_Urusan = M.Kd_Urusan AND L.Kd_Bidang = M.Kd_Bidang AND L.Kd_Unit = M.Kd_Unit AND L.Kd_Sub = M.Kd_Sub
		         INNER JOIN
		     Ref_Unit N ON M.Kd_Urusan = N.Kd_Urusan AND M.Kd_Bidang = N.Kd_Bidang AND M.Kd_Unit = N.Kd_Unit
		         INNER JOIN
		     Ta_Pemda O ON L.Tahun = O.Tahun
			WHERE (A.Tahun = '$tahun')
			  AND (A.No_SPP = '$no_spp')
			  AND (B.Jn_SPP = 4)
		")
			->result();
		$output										= array
		(
			'header'								=> $header_query,
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function spp1_permendagri($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$spp_query								    = $this->query
		("
			SELECT 
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.Tgl_SPP,
				A.Jn_SPP,
				A.Tahun,
		       	B.Kd_Rek_1
			FROM Ta_SPP A, Ta_SPP_Rinc B
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = B.No_SPP
			  AND A.No_SPP = '$no_spp'
		")
			->row();
		$no_sp2d								    = $this->query
		("
			SELECT 
				ISNULL(C.No_SP2D, REPLICATE(' Z ', 50)) AS no_sp2d
			FROM 
				Ta_SPP A
			INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
			LEFT OUTER JOIN Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = '$no_spp'
		")
			->row('no_sp2d');
		$spp_tahun_query							= $this->query
		("
			SELECT 
				Tahun
			FROM 
			     Ta_SPP
			WHERE 
		      Tahun = '$tahun'
			AND No_SPP = '$no_spp'
			AND Jn_SPP IN (2, 5)
		")
			->row();
		if($spp_tahun_query)
		{
			$tmpSPPquery						    =
				("
				SELECT A.Tahun, B.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
				FROM 
				     Ta_Pengesahan_SPJ_Rinc A
				INNER JOIN
					Ta_SPP B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_SPJ
				WHERE 
				    B.Tahun = '$tahun'
					AND B.No_SPP = '$no_spp'
				GROUP BY A.Tahun, B.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}
		else
		{
			$tmpSPPquery						    =
				("
				SELECT A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
				FROM 
				     Ta_SPP_Rinc A
				WHERE 
				    A.Tahun = '$tahun'
					AND A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}

		if($spp_query->Jn_SPP <> '1' AND $spp_query <> '6')
		{
			$SP2D_query							    =
				("
				SELECT 
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					ISNULL(SUM(A.SP2D_GU), 0) AS SP2D_GU,
					ISNULL(SUM(A.SP2D_LS), 0) AS SP2D_LS,
					ISNULL(SUM(A.SP2D_TU), 0) AS SP2D_TU,
					ISNULL(SUM(A.SP2D_Nihil), 0) AS SP2D_Nihil
	        	FROM (
	                 SELECT 
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        0 AS SP2D_GU,
                        0 AS SP2D_LS,
                        0 AS SP2D_TU,
                        0 AS SP2D_NIHIL
	                 FROM ($tmpSPPquery) AS A

	                 UNION ALL

	                 SELECT A.Tahun,
	                        A.Kd_Urusan,
	                        A.Kd_Bidang,
	                        A.Kd_Unit,
	                        A.Kd_Sub,
	                        0       AS SP2D_GU,
	                        A.Nilai AS SP2D_LS,
	                        0       AS SP2D_TU,
	                        0       AS SP2D_NIHIL
	                 FROM Ta_SPM_Rinc A
	                          INNER JOIN
	                      Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
	                          INNER JOIN
	                      Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
	                          INNER JOIN
	                      ($tmpSPPquery) AS D ON A.Tahun = D.Tahun AND A.Kd_Urusan = D.Kd_Urusan AND A.Kd_Bidang = D.Kd_Bidang AND
	                                   A.Kd_Unit = D.Kd_Unit AND A.Kd_Sub = D.Kd_Sub
	                 WHERE ((C.Tgl_SP2D < '$spp_query->Tgl_SPP') OR ((C.Tgl_SP2D = '$spp_query->Tgl_SPP') AND (C.No_SP2D < '$no_sp2d')))
	                   AND (B.Jn_SPM = 3)

	                 UNION ALL

	                 SELECT A.Tahun,
	                        A.Kd_Urusan,
	                        A.Kd_Bidang,
	                        A.Kd_Unit,
	                        A.Kd_Sub,
	                        CASE C.Jn_SPM
	                            WHEN 2 THEN A.Nilai_Setuju
	                            ELSE 0
	                            END AS SP2D_GU,
	                        0       AS SP2D_LS,
	                        CASE
	                            WHEN (C.Jn_SPM = 5) AND (A.Jn_SPJ = 4) THEN A.Nilai_Setuju
	                            ELSE 0
	                            END AS SP2D_TU,
	                        CASE
	                            WHEN (C.Jn_SPM = 5) AND (A.Jn_SPJ = 2) THEN A.Nilai_Setuju
	                            ELSE 0
	                            END AS SP2D_NIHIL
	                 FROM (
	                          SELECT B.Tahun,
	                                 B.No_Pengesahan,
	                                 A.Kd_Urusan,
	                                 A.Kd_Bidang,
	                                 A.Kd_Unit,
	                                 A.Kd_Sub,
	                                 C.Jn_SPJ,
	                                 SUM(A.Nilai_Setuju) AS Nilai_Setuju
	                          FROM Ta_Pengesahan_SPJ_Rinc A
	                                   INNER JOIN
	                               Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_Pengesahan
	                                   INNER JOIN
	                               Ta_SPJ C ON B.Tahun = C.Tahun AND B.No_SPJ = C.No_SPJ
	                          WHERE C.Tahun = '$spp_query->Tahun'
	                            AND C.Kd_Urusan = '$spp_query->Kd_Urusan'
	                            AND C.Kd_Bidang = '$spp_query->Kd_Bidang'
	                            AND C.Kd_Unit = '$spp_query->Kd_Unit'
	                            AND C.Kd_Sub = '$spp_query->Kd_Sub'
	                          GROUP BY B.Tahun, B.No_Pengesahan, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, C.Jn_SPJ
	                      ) A
	                          INNER JOIN
	                      Ta_SPP B ON A.Tahun = B.Tahun AND A.No_Pengesahan = B.No_SPJ
	                          INNER JOIN
	                      Ta_SPM C ON B.Tahun = C.Tahun AND B.No_SPP = C.No_SPP
	                          INNER JOIN
	                      Ta_SP2D E ON C.Tahun = E.Tahun AND C.No_SPM = E.No_SPM
	                          INNER JOIN
	                      ($tmpSPPquery) AS D ON A.Tahun = D.Tahun AND A.Kd_Urusan = D.Kd_Urusan AND A.Kd_Bidang = D.Kd_Bidang AND
	                                   A.Kd_Unit = D.Kd_Unit AND A.Kd_Sub = D.Kd_Sub
	                 WHERE ((E.Tgl_SP2D < '$spp_query->Tgl_SPP') OR ((E.Tgl_SP2D = '$spp_query->Tgl_SPP') AND (E.No_SP2D < '$no_sp2d')))

	                 UNION ALL

	                 SELECT A.Tahun,
	                        A.Kd_Urusan,
	                        A.Kd_Bidang,
	                        A.Kd_Unit,
	                        A.Kd_Sub,
	                        CASE B.Jn_SPM
	                            WHEN 2 THEN
	                                CASE A.D_K
	                                    WHEN 'D' THEN A.Nilai
	                                    ELSE -A.Nilai
	                                    END
	                            ELSE 0
	                            END AS SP2D_GU,
	                        CASE B.Jn_SPM
	                            WHEN 3 THEN
	                                CASE A.D_K
	                                    WHEN 'D' THEN A.Nilai
	                                    ELSE -A.Nilai
	                                    END
	                            ELSE 0
	                            END AS SP2D_LS,
	                        CASE B.Jn_SPM
	                            WHEN 4 THEN
	                                CASE A.D_K
	                                    WHEN 'D' THEN A.Nilai
	                                    ELSE -A.Nilai
	                                    END
	                            ELSE 0
	                            END AS SP2D_TU,
	                        CASE B.Jn_SPM
	                            WHEN 5 THEN
	                                CASE A.D_K
	                                    WHEN 'D' THEN A.Nilai
	                                    ELSE -A.Nilai
	                                    END
	                            ELSE 0
	                            END AS SP2D_NIHIL
	                 FROM Ta_Penyesuaian_Rinc A
	                          INNER JOIN
	                      Ta_Penyesuaian B ON A.Tahun = B.Tahun AND A.No_Bukti = B.No_Bukti
	                          INNER JOIN
	                      ($tmpSPPquery) AS D ON A.Tahun = D.Tahun AND A.Kd_Urusan = D.Kd_Urusan AND A.Kd_Bidang = D.Kd_Bidang AND
	                                   A.Kd_Unit = D.Kd_Unit AND A.Kd_Sub = D.Kd_Sub
	                 WHERE (B.Jns_P1 = 1)
	                   AND (B.Jns_P2 IN (2, 3))
	                   AND (B.Tgl_Bukti <= '$spp_query->Tgl_SPP')
	             ) A
	        GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}
		elseif($spp_query->Jn_SPP <> '1' AND $spp_query = '6')
		{
			$SP2D_query							    =
				("
				SELECT A.Tahun,
	               A.Kd_Urusan,
	               A.Kd_Bidang,
	               A.Kd_Unit,
	               A.Kd_Sub,
	               ISNULL(SUM(A.SP2D_GU), 0)    AS SP2D_GU,
	               ISNULL(SUM(A.SP2D_LS), 0)    AS SP2D_LS,
	               ISNULL(SUM(A.SP2D_TU), 0)    AS SP2D_TU,
	               ISNULL(SUM(A.SP2D_Nihil), 0) AS SP2D_Nihil
		        FROM (
			        SELECT A.Tahun,
		                        A.Kd_Urusan,
		                        A.Kd_Bidang,
		                        A.Kd_Unit,
		                        A.Kd_Sub,
		                        0 AS SP2D_GU,
		                        0 AS SP2D_LS,
		                        0 AS SP2D_TU,
		                        0 AS SP2D_NIHIL
		                 FROM ($tmpSPPquery) AS A
		
		                 UNION ALL
		
		                 SELECT A.Tahun,
		                        A.Kd_Urusan,
		                        A.Kd_Bidang,
		                        A.Kd_Unit,
		                        A.Kd_Sub,
		                        0       AS SP2D_GU,
		                        CASE B.Jn_SPM
		                            WHEN 3 THEN A.Nilai
		                            ELSE 0
		                            END AS SP2D_LS,
		                        0       AS SP2D_TU,
		                        0       AS SP2D_NIHIL
		                 FROM Ta_SPM_Rinc A
		                          INNER JOIN
		                      Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPM = B.No_SPM
		                          INNER JOIN
		                      Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
		                          INNER JOIN
		                      ($tmpSPPquery) D ON A.Tahun = D.Tahun AND A.Kd_Urusan = D.Kd_Urusan AND A.Kd_Bidang = D.Kd_Bidang AND
				A.Kd_Unit = D.Kd_Unit AND A.Kd_Sub = D.Kd_Sub
		                 WHERE ((C.Tgl_SP2D < '$spp_query->Tgl_SPP') OR ((C.Tgl_SP2D = '$spp_query->Tgl_SPP') AND (C.No_SP2D < '$so_sp2d')))
		                 AND (B.Jn_SPM = 3)
		                 AND (A.Kd_Rek_1 = 6)
		             ) A
		        GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}

		$data_query								    = $this->query
		("
			SELECT D.Nm_Sub_Unit,
		       K.No_Peraturan,
		       K.Ur_Peraturan,
		       K.Nm_Peraturan,
		       G.Nm_Urusan + ' ' + F.Nm_Bidang AS Nm_Urusan,
		       B.Tgl_SPP,
		       CASE
		           WHEN B.Jn_SPP = 1 THEN 'UANG PERSEDIAAN (SPP-UP)'
		           WHEN B.Jn_SPP = 2 THEN 'GANTI UANG PERSEDIAAN (SPP-GU)'
		           WHEN B.Jn_SPP = 4 THEN 'TAMBAHAN UANG PERSEDIAAN (SPP-TU)'
		           WHEN B.Jn_SPP = 5 THEN 'NIHIL (SPP-NIHIL)'
		           WHEN B.Jn_SPP = 3 THEN
		               CASE
		                   WHEN A.Rek_2 = '5.2' THEN 'LANGSUNG BARANG DAN JASA (SPP-LS BARANG DAN JASA)'
		                   WHEN A.Rek_3 = '5.1.1' THEN 'LANGSUNG GAJI DAN TUNJANGAN (SPP-LS-GAJI-TUNJANGAN)'
		                   WHEN A.Rek_2 = '6.2' THEN 'LANGSUNG PEMBIAYAAN (SPP-LS PEMBIAYAAN)'
		                   ELSE 'LANGSUNG BELANJA PENGELUARAN PPKD'
		                   END
		           ELSE ''
		           END AS Judul,
		       CASE
		           WHEN B.Jn_SPP = 1 THEN 'Uang Persediaan'
		           WHEN B.Jn_SPP = 2 THEN 'Ganti Uang Persediaan'
		           WHEN B.Jn_SPP = 4 THEN 'Tambahan Uang Persediaan'
		           WHEN B.Jn_SPP = 5 THEN 'Nihil'
		           WHEN B.Jn_SPP = 3 THEN
		               CASE
		                   WHEN A.Rek_2 = '5.2' THEN 'Langsung Barang dan Jasa'
		                   WHEN A.Rek_3 = '5.1.1' THEN 'Langsung Gaji dan Tunjangan'
		                   WHEN A.Rek_2 = '6.2' THEN 'Langsung Pembiayaan'
		                   ELSE 'Langsung Belanja Pengeluaran PPKD'
		                   END
		           ELSE ''
		           END AS Judul2,
		       N.Nm_Rek_3 AS Jenis,
		       B.Jn_SPP,
		       A.Rek_2,
		       A.Rek_3,
		       CASE
		           WHEN B.Jn_SPP = 3 THEN
		               CASE
		                   WHEN A.Rek_2 = '5.2' THEN 'SKPD'
		                   WHEN A.Rek_3 = '5.1.1' THEN 'SKPD'
		                   WHEN A.Rek_2 = '6.2' THEN 'PPKD'
		                   ELSE 'PPKD'
		                   END
		           ELSE 'SKPD'
		           END AS Kd_SKPD,
		       CONVERT(varchar, F.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, F.Kd_Bidang), 2) AS Kd_Urusan,
		       E.kd_unit90 + '.' + right('00' + convert(varchar, D.kd_sub), 2) AS Kd_Sub,
		       CASE WHEN '$spp_query->Jn_SPP' IN (3, 4) THEN B.No_SPD ELSE M.No_SPD END AS No_SPD,
		       M.Nilai_SPD,
		       H.Nm_Bendahara,
		       H.Nip_Bendahara,
		       H.Jbt_Bendahara,
		       B.Uraian,
		       A.Nilai_SPP,
		       B.Bank_Penerima,
		       B.Rek_Penerima,
		       B.Nama_PPTK,
		       B.NIP_PPTK
		FROM (
		         SELECT Tahun,
		                No_SPP,
		                SUM(Usulan) AS Nilai_SPP,
		                MIN(CONVERT(varchar, Kd_Rek_1) + '.' + CONVERT(varchar, Kd_Rek_2)) AS Rek_2,
		                MIN(CONVERT(varchar, Kd_Rek_1) + '.' + CONVERT(varchar, Kd_Rek_2) + '.' +
		                    CONVERT(varchar, Kd_Rek_3)) AS Rek_3
		         FROM Ta_SPP_Rinc
		         WHERE (Tahun = '$tahun')
		           AND (No_SPP = '$no_spp')
		         GROUP BY Tahun, No_SPP
		     ) A
		         INNER JOIN
		     Ta_SPP B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
		         INNER JOIN
		     Ta_Sub_Unit C
		     ON B.Tahun = C.Tahun AND B.Kd_Urusan = C.Kd_Urusan AND B.Kd_Bidang = C.Kd_Bidang AND B.Kd_Unit = C.Kd_Unit AND
		        B.Kd_Sub = C.Kd_Sub
		         INNER JOIN
		     Ref_Sub_Unit D
		     ON C.Kd_Urusan = D.Kd_Urusan AND C.Kd_Bidang = D.Kd_Bidang AND C.Kd_Unit = D.Kd_Unit AND C.Kd_Sub = D.Kd_Sub
		         INNER JOIN
		     Ref_Unit E ON D.Kd_Urusan = E.Kd_Urusan AND D.Kd_Bidang = E.Kd_Bidang AND D.Kd_Unit = E.Kd_Unit
		         INNER JOIN
		     ref_bidang_mapping I ON E.Kd_Urusan = I.Kd_Urusan AND E.Kd_Bidang = I.Kd_Bidang
		         INNER JOIN
		     Ref_Bidang90 F ON I.Kd_Urusan90 = F.Kd_Urusan AND I.Kd_Bidang90 = F.Kd_Bidang
		         INNER JOIN
		     Ref_Urusan90 G ON F.Kd_Urusan = G.Kd_Urusan
		         INNER JOIN
		     (
		         SELECT A.Tahun,
		                A.Kd_Urusan,
		                A.Kd_Bidang,
		                A.Kd_Unit,
		                A.Kd_Sub,
		                Nama    AS Nm_Bendahara,
		                Nip     AS Nip_Bendahara,
		                Jabatan AS Jbt_Bendahara
		         FROM Ta_Sub_Unit_Jab A
		                  INNER JOIN
		              (
		                  SELECT Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab, MIN(No_Urut) AS No_Urut
		                  FROM Ta_Sub_Unit_Jab
		                  GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
		              ) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND
		                     A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Jab = B.Kd_Jab AND A.No_Urut = B.No_Urut
		         WHERE (A.Tahun = '$tahun')
		           AND (A.Kd_Jab = 4)
		     ) H ON C.Tahun = H.Tahun AND C.Kd_Urusan = H.Kd_Urusan AND C.Kd_Bidang = H.Kd_Bidang AND C.Kd_Unit = H.Kd_Unit AND
		            C.Kd_Sub = H.Kd_Sub
		         INNER JOIN
		     Ta_Pemda J ON A.Tahun = J.Tahun
		         INNER JOIN
		     (
		         SELECT A.Tahun,
		                A.Kd_Urusan,
		                A.Kd_Bidang,
		                A.Kd_Unit,
		                A.Kd_Sub,
		                MAX(B.No_SPD) AS No_SPD,
		                SUM(A.Nilai)  AS Nilai_SPD
		         FROM Ta_SPD_Rinc A
		                  INNER JOIN
		              Ta_SPD B ON A.Tahun = B.Tahun AND A.No_SPD = B.No_SPD
		         WHERE (B.Tahun = '$tahun')
		           AND (B.Tgl_SPD <= '$spp_query->Tgl_SPP')
		           AND ('$spp_query->Jn_SPP' <> 1)
		           AND (A.Kd_Rek_1 = 5 AND '$spp_query->Jn_SPP' <> 6)
		         GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
		
		         UNION ALL
		
		         SELECT A.Tahun,
		                A.Kd_Urusan,
		                A.Kd_Bidang,
		                A.Kd_Unit,
		                A.Kd_Sub,
		                MAX(B.No_SPD) AS No_SPD,
		                SUM(A.Nilai)  AS Nilai_SPD
		         FROM Ta_SPD_Rinc A
		                  INNER JOIN
		              Ta_SPD B ON A.Tahun = B.Tahun AND A.No_SPD = B.No_SPD
		         WHERE (B.Tahun = '$tahun')
		           AND (B.Tgl_SPD <= '$spp_query->Tgl_SPP')
		           AND ('$spp_query->Jn_SPP' <> 1)
		           AND (A.Kd_Rek_1 = 6 AND '$spp_query->Kd_Rek_1' = 6)
		         GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
		
		         UNION ALL
		
		         SELECT A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, NULL, NULL AS Nilai_SPD
		         FROM Ta_SPP A
		         WHERE A.Tahun = '$tahun'
		           AND A.No_SPP = '$no_spp'
		           AND ('$spp_query->Jn_SPP' = 1)
		     ) M ON B.Tahun = M.Tahun AND B.Kd_Urusan = M.Kd_Urusan AND B.Kd_Bidang = M.Kd_Bidang AND B.Kd_Unit = M.Kd_Unit AND
		            B.Kd_Sub = M.Kd_Sub
		         LEFT OUTER JOIN
		     (
		         SELECT A.Tahun,
		                A.Uraian AS Ur_Peraturan,
		                A.No_Peraturan,
		                CASE A.Kd_Peraturan
		                    WHEN 3 THEN 'Penjabaran APBD'
		                    ELSE 'Penjabaran Perubahan APBD'
		                    END  AS Nm_Peraturan
		         FROM Ta_Peraturan A
		                  INNER JOIN
		              (
		                  SELECT Tahun, MAX(Kd_Peraturan) AS Kd_Peraturan
		                  FROM Ta_Peraturan
		                  WHERE (Tahun = '$tahun')
		                    AND (Kd_Peraturan IN (3, 4))
		                    AND (Tgl_Peraturan <= '$spp_query->Tgl_SPP')
		                  GROUP BY Tahun
		              ) B ON A.Tahun = B.Tahun AND A.Kd_Peraturan = B.Kd_Peraturan
		     ) K ON A.Tahun = K.Tahun
		         LEFT OUTER JOIN
		     ($SP2D_query) AS O
		     ON B.Tahun = O.Tahun AND B.Kd_Urusan = O.Kd_Urusan AND B.Kd_Bidang = O.Kd_Bidang AND B.Kd_Unit = O.Kd_Unit AND
		        B.Kd_Sub = O.Kd_Sub
		         LEFT OUTER JOIN
		     (
		         SELECT CONVERT(varchar, Kd_Rek_1) + '.' + CONVERT(varchar, Kd_Rek_2) + '.' +
		                CONVERT(varchar, Kd_Rek_3) AS Rek_3,
		                Nm_Rek_3
		         FROM Ref_Rek_3
		         WHERE Kd_Rek_1 = 5
		           AND Kd_Rek_2 = 1
		           AND Kd_Rek_3 <> 1
		     ) N ON A.Rek_3 = N.Rek_3
		")
			->row();
		$output										= array
		(
			'no_spp'							    => $no_spp,
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function spp2_permendagri($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$spp_query								    = $this->query
		("
			SELECT 
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.No_SPP,
				A.Tgl_SPP,
				A.Jn_SPP,
				A.Tahun,
		       	B.Kd_Rek_1
			FROM Ta_SPP A, Ta_SPP_Rinc B
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = B.No_SPP
			  AND A.No_SPP = '$no_spp'
		")
			->row();
		$no_sp2d								    = $this->query
		("
			SELECT 
				ISNULL(C.No_SP2D, REPLICATE(' Z ', 50)) AS no_sp2d
			FROM 
				Ta_SPP A
			INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
			LEFT OUTER JOIN Ta_SP2D C ON B.Tahun = C.Tahun AND B.No_SPM = C.No_SPM
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = '$no_spp'
		")
			->row('no_sp2d');

		$jn_in                                      = array('2', '5');
		if ($spp_query->No_SPP == $no_spp && in_array($spp_query->Jn_SPP, $jn_in))
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					B.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg
				FROM
					Ta_Pengesahan_SPJ_Rinc A
				INNER JOIN
					Ta_SPP B ON A.Tahun = B.Tahun AND
					A.No_Pengesahan = B.No_SPJ
				WHERE
					B.Tahun = '$tahun' AND
					B.No_SPP = '$no_spp'
				GROUP BY A.Tahun, B.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}
		elseif($spp_query->No_SPP == $no_spp && $spp_query->Jn_SPP == '3')
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					A.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					MIN(Kd_Prog) AS Kd_Prog,
					MIN(ID_Prog) AS ID_Prog,
					MIN(Kd_Keg) AS Kd_Keg
				FROM
					Ta_SPP_Rinc A
				WHERE 
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}
		else
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					A.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg
				FROM
					Ta_SPP_Rinc A
				WHERE
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}

		if ($spp_query->Jn_SPP <> '1' AND $spp_query->Jn_SPP <> '6')
		{
			$tmpSP2D                                =
				("
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					ISNULL(SUM(A.SP2D_GU), 0) AS SP2D_GU,
					ISNULL(SUM(A.SP2D_LS1), 0) AS SP2D_LS1,
					ISNULL(SUM(A.SP2D_LS2), 0) AS SP2D_LS2,
					ISNULL(SUM(A.SP2D_TU), 0) AS SP2D_TU,
					ISNULL(SUM(A.SP2D_Nihil), 0) AS SP2D_Nihil
		        FROM
		            (
						SELECT
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							0 AS SP2D_GU,
							0 AS SP2D_LS1,
							0 AS SP2D_LS2,
							0 AS SP2D_TU,
							0 AS SP2D_NIHIL
                		FROM ($tmpSPP) AS A

                	UNION ALL

		                SELECT 
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							0 AS SP2D_GU,
							CASE
							   WHEN Kd_Rek_1 = 5 AND Kd_Rek_2 = 1 AND Kd_Rek_3 = 1 THEN A.Nilai
							   ELSE 0
							   END AS SP2D_LS1,
							CASE
							   WHEN Kd_Rek_1 = 5 AND Kd_Rek_2 = 1 AND Kd_Rek_3 = 1 THEN 0
							   ELSE A.Nilai
							   END AS SP2D_LS2,
							0 AS SP2D_TU,
							0 AS SP2D_NIHIL
		                FROM 
							Ta_SPM_Rinc A
						INNER JOIN
							Ta_SPM B ON A.Tahun = B.Tahun AND
							A.No_SPM = B.No_SPM
						INNER JOIN
							Ta_SP2D C ON B.Tahun = C.Tahun AND
							B.No_SPM = C.No_SPM
						INNER JOIN
							($tmpSPP) AS D ON A.Tahun = D.Tahun AND
							A.Kd_Urusan = D.Kd_Urusan AND
							A.Kd_Bidang = D.Kd_Bidang AND
							A.Kd_Unit = D.Kd_Unit AND
							A.Kd_Sub = D.Kd_Sub
						WHERE
							((C.Tgl_SP2D < $spp_query->Tgl_SPP) OR 
							((C.Tgl_SP2D = $spp_query->Tgl_SPP) AND
							(C.No_SP2D < $no_sp2d))) AND
							(B.Jn_SPM = 3)

                	UNION ALL

		                SELECT 
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							CASE C.Jn_SPM
							   WHEN 2 THEN A.Nilai_Setuju
							   ELSE 0
							   END AS SP2D_GU,
							0 AS SP2D_LS1,
							0 AS SP2D_LS2,
							CASE
							   WHEN (C.Jn_SPM = 5) AND (A.Jn_SPJ = 4) THEN A.Nilai_Setuju
							   ELSE 0
							   END AS SP2D_TU,
							CASE
							   WHEN (C.Jn_SPM = 5) AND (A.Jn_SPJ = 2) THEN A.Nilai_Setuju
							   ELSE 0
							   END AS SP2D_NIHIL
		                FROM
		                    (
		                        SELECT
									B.Tahun,
									B.No_Pengesahan,
									A.Kd_Urusan,
									A.Kd_Bidang,
									A.Kd_Unit,
									A.Kd_Sub,
									C.Jn_SPJ,
									SUM(A.Nilai_Setuju) AS Nilai_Setuju
		                        FROM
		                            Ta_Pengesahan_SPJ_Rinc A
								INNER JOIN
									Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun AND
									A.No_Pengesahan = B.No_Pengesahan
								INNER JOIN
									Ta_SPJ C ON B.Tahun = C.Tahun AND
									B.No_SPJ = C.No_SPJ
		                        WHERE C.Tahun = '$tahun' AND
		                              C.Kd_Urusan = '$spp_query->Kd_Urusan' AND
		                              C.Kd_Bidang = '$spp_query->Kd_Bidang' AND
		                              C.Kd_Unit = '$spp_query->Kd_Unit' AND
		                              C.Kd_Sub = '$spp_query->Kd_Sub'
		                        GROUP BY B.Tahun, B.No_Pengesahan, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, C.Jn_SPJ
		                    ) A
		                        INNER JOIN
									Ta_SPP B ON A.Tahun = B.Tahun AND
									A.No_Pengesahan = B.No_SPJ
								INNER JOIN
									Ta_SPM C ON B.Tahun = C.Tahun AND
									B.No_SPP = C.No_SPP
								INNER JOIN
									Ta_SP2D E ON C.Tahun = E.Tahun AND
									C.No_SPM = E.No_SPM
								INNER JOIN
		                    		($tmpSPP) AS D ON A.Tahun = D.Tahun AND
									A.Kd_Urusan = D.Kd_Urusan AND
									A.Kd_Bidang = D.Kd_Bidang AND
									A.Kd_Unit = D.Kd_Unit AND
									A.Kd_Sub = D.Kd_Sub
		                	WHERE
								((E.Tgl_SP2D < '$spp_query->Tgl_SPP') OR
								((E.Tgl_SP2D = '$spp_query->Tgl_SPP') AND
								(E.No_SP2D < '$no_sp2d')))

		            UNION ALL

		                SELECT 
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							CASE B.Jn_SPM
							   WHEN 2 THEN
							       CASE A.D_K
							           WHEN 'D' THEN A.Nilai
							           ELSE -A.Nilai
							           END
							   ELSE 0
							   END AS SP2D_GU,
							CASE B.Jn_SPM
							   WHEN 3 THEN
							           CASE A.D_K
							               WHEN 'D' THEN 1
							               ELSE -1
							               END *
							           CASE
							               WHEN Kd_Rek_1 = 5 AND Kd_Rek_2 = 1 AND Kd_Rek_3 = 1 THEN A.Nilai
							               ELSE 0
							               END
							   ELSE 0
							   END AS SP2D_LS1,
							CASE B.Jn_SPM
							   WHEN 3 THEN
							           CASE A.D_K
							               WHEN 'D' THEN 1
							               ELSE -1
							               END *
							           CASE
							               WHEN Kd_Rek_1 = 5 AND Kd_Rek_2 = 1 AND Kd_Rek_3 = 1 THEN 0
							               ELSE A.Nilai
							               END
							   ELSE 0
							   END AS SP2D_LS2,
							CASE B.Jn_SPM
							   WHEN 4 THEN
							       CASE A.D_K
							           WHEN 'D' THEN A.Nilai
							           ELSE -A.Nilai
							           END
							   ELSE 0
							   END AS SP2D_TU,
							CASE B.Jn_SPM
							   WHEN 5 THEN
							       CASE A.D_K
							           WHEN 'D' THEN A.Nilai
							           ELSE -A.Nilai
							           END
							   ELSE 0
							   END AS SP2D_NIHIL
						FROM 
							Ta_Penyesuaian_Rinc A
						INNER JOIN
		                     Ta_Penyesuaian B ON A.Tahun = B.Tahun AND
							A.No_Bukti = B.No_Bukti
						INNER JOIN
							($tmpSPP) AS D ON A.Tahun = D.Tahun AND 
							A.Kd_Urusan = D.Kd_Urusan AND 
							A.Kd_Bidang = D.Kd_Bidang AND 
							A.Kd_Unit = D.Kd_Unit AND 
							A.Kd_Sub = D.Kd_Sub
		                WHERE (B.Jns_P1 = 1) AND 
							(B.Jns_P2 IN (2, 3)) AND
							(B.Tgl_Bukti <= '$spp_query->Tgl_SPP')
		            ) A
		        GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}

		if ($spp_query->Jn_SPP <> '1' AND $spp_query->Jn_SPP = '6')
		{
			$tmpSP2D                                =
				("
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					ISNULL(SUM(A.SP2D_GU), 0) AS SP2D_GU,
					ISNULL(SUM(A.SP2D_LS1), 0) AS SP2D_LS1,
					ISNULL(SUM(A.SP2D_LS2), 0) AS SP2D_LS2,
					ISNULL(SUM(A.SP2D_TU), 0) AS SP2D_TU,
					ISNULL(SUM(A.SP2D_Nihil), 0) AS SP2D_Nihil
		        FROM
		            (
		                SELECT
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							0 AS SP2D_GU,
							0 AS SP2D_LS1,
							0 AS SP2D_LS2,
							0 AS SP2D_TU,
							0 AS SP2D_NIHIL
		                FROM ($tmpSPP) AS A
		
		                UNION ALL
		
		                SELECT
							A.Tahun,
							A.Kd_Urusan,
							A.Kd_Bidang,
							A.Kd_Unit,
							A.Kd_Sub,
							0 AS SP2D_GU,
							0 AS SP2D_LS1,
							CASE B.Jn_SPM
							   WHEN 3 THEN A.Nilai
							   ELSE 0
							   END AS SP2D_LS2,
							0 AS SP2D_TU,
							0 AS SP2D_NIHIL
		                FROM 
							Ta_SPM_Rinc A 
						INNER JOIN
							Ta_SPM B ON A.Tahun = B.Tahun AND
							A.No_SPM = B.No_SPM
						INNER JOIN
							Ta_SP2D C ON B.Tahun = C.Tahun AND
							B.No_SPM = C.No_SPM
						INNER JOIN
							($tmpSPP) AS D ON A.Tahun = D.Tahun AND
							A.Kd_Urusan = D.Kd_Urusan AND
							A.Kd_Bidang = D.Kd_Bidang AND
							A.Kd_Unit = D.Kd_Unit AND
							A.Kd_Sub = D.Kd_Sub
		                WHERE
							((C.Tgl_SP2D < '$spp_query->Tgl_SPP') OR
							((C.Tgl_SP2D = '$spp_query->Tgl_SPP') AND
							(C.No_SP2D < '$no_sp2d'))) AND
							(B.Jn_SPM = 3) AND
							(A.Kd_Rek_1 = 6)
		            ) A
		        GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}

		$data_query								    = $this->query
		("
			SELECT 
				D.Nm_Sub_Unit, B.Tgl_SPP,
				CASE
				WHEN B.Jn_SPP = 1 THEN 'UANG PERSEDIAAN (SPP-UP)'
				WHEN B.Jn_SPP = 2 THEN 'GANTI UANG PERSEDIAAN (SPP-GU)'
				WHEN B.Jn_SPP = 4 THEN 'TAMBAHAN UANG PERSEDIAAN (SPP-TU)'
				WHEN B.Jn_SPP = 5 THEN 'NIHIL (SPP-NIHIL)'
				WHEN B.Jn_SPP = 3 THEN
					CASE
						WHEN A.Rek_2 = '5.2' THEN 'LANGSUNG BARANG DAN JASA (SPP-LS BARANG DAN JASA)'
						WHEN A.Rek_3 = '5.1.1' THEN 'LANGSUNG GAJI DAN TUNJANGAN (SPP-LS-GAJI-TUNJANGAN)'
						WHEN A.Rek_2 = '6.2' THEN 'LANGSUNG PEMBIAYAAN (SPP-LS PEMBIAYAAN)'
					ELSE 'LANGSUNG BELANJA PENGELUARAN PPKD'
					END
				ELSE ''
				END AS Judul,
				B.Jn_SPP,
				A.Rek_2, 
				A.Rek_3,
				P.Kd_Prog_Gab,
				P.Kd_Keg_Gab,
				P.Ket_Program,
				P.Ket_Kegiatan,
				P.Status_Kegiatan,
				P.No_DPA,
				I.Tgl_DPA,
				R.Nama AS Nama_PT,
				R.Bentuk,
				R.Alamat AS Alamat_PT,
				R.Nm_Pimpinan AS Nm_Pimpinan_PT,
				ISNULL(R.Nm_Bank, '') + ' ' + ISNULL(R.No_Rekening, '') AS Bank_PT, R.No_Kontrak, R.No_Addendum, R.Waktu AS Waktu_Pelaksanaan, X.Waktu as Waktu_adendum,
				X.NO_ADDENDUM as NO_ADDENDUM_1, X.TGL_ADDENDUM,R.TGL_KONTRAK,Q.WAKTU AS WAKTU_AWAL,(Q.NILAI) AS Nilai_Awal,R.NILAI AS Nilai_Adendum,
				CASE
					WHEN R.Tahun IS NULL THEN B.Uraian
					ELSE R.Keperluan
				END AS Keperluan,
				L.Anggaran,
				M.No_SPD,
				M.Tgl_SPD,
				M.Nilai_SPD,
				O.SP2D_GU,
				O.SP2D_LS1,
				O.SP2D_LS2,
				O.SP2D_TU,
				O.SP2D_Nihil,
				O.SP2D_GU + O.SP2D_LS1 + O.SP2D_LS2 + O.SP2D_TU + O.SP2D_Nihil AS Nilai_Total,
				H.Nm_Bendahara,
				H.Nip_Bendahara,
				H.Jbt_Bendahara,
				A.Nilai_SPP,
				B.Nama_PPTK,
				B.NIP_PPTK,
				J.Ibukota					
			FROM
			    (
			        SELECT
						Tahun,
						No_SPP,
						SUM(Usulan) AS Nilai_SPP,
						MIN(CONVERT(varchar, Kd_Rek_1) + '.' + CONVERT(varchar, Kd_Rek_2)) AS Rek_2,
						MIN(CONVERT(varchar, Kd_Rek_1) + '.' + CONVERT(varchar, Kd_Rek_2) + '.' + CONVERT(varchar, Kd_Rek_3)) AS Rek_3
			        FROM Ta_SPP_Rinc
			        WHERE
						(Tahun = '$tahun') AND
						(No_SPP = '$no_spp')
			        GROUP BY Tahun, No_SPP
			    ) AS A
		        INNER JOIN
					Ta_SPP B ON A.Tahun = B.Tahun AND
					A.No_SPP = B.No_SPP
				INNER JOIN
					Ta_Sub_Unit C ON B.Tahun = C.Tahun AND
					B.Kd_Urusan = C.Kd_Urusan AND
					B.Kd_Bidang = C.Kd_Bidang AND
					B.Kd_Unit = C.Kd_Unit AND
					B.Kd_Sub = C.Kd_Sub
				INNER JOIN
					Ref_Sub_Unit D ON C.Kd_Urusan = D.Kd_Urusan
					AND C.Kd_Bidang = D.Kd_Bidang AND
					C.Kd_Unit = D.Kd_Unit AND
					C.Kd_Sub = D.Kd_Sub
				INNER JOIN
					Ref_Unit E ON D.Kd_Urusan = E.Kd_Urusan AND
					D.Kd_Bidang = E.Kd_Bidang AND
					D.Kd_Unit = E.Kd_Unit INNER JOIN
					Ref_Bidang F ON E.Kd_Urusan = F.Kd_Urusan AND
					E.Kd_Bidang = F.Kd_Bidang
				INNER JOIN
					Ref_Urusan G ON F.Kd_Urusan = G.Kd_Urusan
				INNER JOIN
			    (
			        SELECT
						A.Tahun,
						A.Kd_Urusan,
						A.Kd_Bidang,
						A.Kd_Unit,
						A.Kd_Sub,
						Nama AS Nm_Bendahara,
						Nip AS Nip_Bendahara,
						Jabatan AS Jbt_Bendahara
			        FROM 
						Ta_Sub_Unit_Jab AS A
                    INNER JOIN
					(
						SELECT
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub,
							Kd_Jab,
							MIN(No_Urut) AS No_Urut
						FROM
							Ta_Sub_Unit_Jab
						GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
					) B ON A.Tahun = B.Tahun AND
						A.Kd_Urusan = B.Kd_Urusan AND
						A.Kd_Bidang = B.Kd_Bidang AND
						A.Kd_Unit = B.Kd_Unit AND
						A.Kd_Sub = B.Kd_Sub AND
						A.Kd_Jab = B.Kd_Jab AND
						A.No_Urut = B.No_Urut
					WHERE
						(A.Tahun = '$tahun') AND
						(A.Kd_Jab = 4)
			    ) H ON C.Tahun = H.Tahun AND C.Kd_Urusan = H.Kd_Urusan AND C.Kd_Bidang = H.Kd_Bidang AND C.Kd_Unit = H.Kd_Unit AND C.Kd_Sub = H.Kd_Sub
				INNER JOIN
					Ta_Pemda J ON A.Tahun = J.Tahun 
				INNER JOIN
					Ref_Jenis_SPM K ON B.Jn_SPP = K. Jn_SPM 
		        INNER JOIN
				(
				    SELECT
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub,
						SUM(Anggaran) AS Anggaran
				    FROM
				        (
				            SELECT
								Tahun,
								Kd_Urusan,
								Kd_Bidang,
								Kd_Unit,
								Kd_Sub,
								SUM(Total) AS Anggaran
				            FROM
				                 Ta_RASK_Arsip
				            WHERE
								(Tahun = '$tahun') AND
								(Kd_Perubahan = (SELECT MAX(Kd_Perubahan) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$spp_query->Tgl_SPP' AND Kd_Perubahan IN (4, 6, 8))) AND
								(Kd_Rek_1 = 5) AND
								('$spp_query->Kd_Rek_1' <> 6)
				            GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub

				            UNION ALL

				            SELECT
								Tahun,
								Kd_Urusan,
								Kd_Bidang,
								Kd_Unit,
								Kd_Sub,
								SUM(Total) AS Anggaran
				            FROM
								Ta_RASK_Arsip
				            WHERE
								(Tahun = '$tahun') AND
								(Kd_Perubahan = (SELECT MAX(Kd_Perubahan) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$spp_query->Tgl_SPP' AND Kd_Perubahan IN (4, 6, 8))) AND (Kd_Rek_1 = 6 AND Kd_Rek_2 = 2) AND ('$spp_query->Kd_Rek_1' = 6)
				            GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub

                            UNION ALL

				            SELECT
								Tahun,
								Kd_Urusan,
								Kd_Bidang,
								Kd_Unit,
								Kd_Sub,
								0 AS Anggaran
				            	FROM ($tmpSPP) AS xl
				            GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
				        ) A
				    GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
				) L ON B.Tahun = L.Tahun AND B.Kd_Urusan = L.Kd_Urusan AND B.Kd_Bidang = L.Kd_Bidang AND B.Kd_Unit = L.Kd_Unit AND B.Kd_Sub = L.Kd_Sub 
				INNER JOIN
				(
					SELECT
						A.Tahun,
						A.Kd_Urusan,
						A.Kd_Bidang,
						A.Kd_Unit,
						A.Kd_Sub,
						B.No_SPD,
						B.Tgl_SPD,
						SUM(A.Nilai) AS Nilai_SPD
					FROM
						Ta_SPD_Rinc A
				    INNER JOIN
						Ta_SPD B ON A.Tahun = B.Tahun AND
						A.No_SPD = B.No_SPD
					WHERE
						(B.Tahun = '$tahun') AND
						(B.Tgl_SPD <= '$spp_query->Tgl_SPP') AND
						('$spp_query->Jn_SPP' <> 1) AND
						(A.Kd_Rek_1 = 5 AND '$spp_query->Kd_Rek_1' <> 6)
					GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, B.No_SPD, B.Tgl_SPD
				
					UNION ALL
				
					SELECT
						A.Tahun,
						A.Kd_Urusan,
						A.Kd_Bidang,
						A.Kd_Unit,
						A.Kd_Sub,
						B.No_SPD,
						B.Tgl_SPD,
						SUM(A.Nilai) AS Nilai_SPD
					FROM
						Ta_SPD_Rinc A
					INNER JOIN
						Ta_SPD B ON A.Tahun = B.Tahun AND
						A.No_SPD = B.No_SPD
					WHERE 
						(B.Tahun = '$tahun') AND
						(B.Tgl_SPD <= '$spp_query->Tgl_SPP') AND
						('$spp_query->Jn_SPP' <> 1) AND
						(A.Kd_Rek_1 = 6 AND
						'$spp_query->Kd_Rek_1' = 6)
					GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, B.No_SPD, B.Tgl_SPD
					
					UNION ALL
					
					SELECT
						A.Tahun,
						A.Kd_Urusan,
						A.Kd_Bidang,
						A.Kd_Unit,
						A.Kd_Sub,
						NULL,
						NULL,
						0 AS Nilai_SPD
					FROM
						Ta_SPP A
					WHERE 
						A.Tahun = '$tahun' AND
						A.No_SPP = '$no_spp' AND
						('$spp_query->Kd_Rek_1' = 1)
				) M ON B.Tahun = M.Tahun AND B.Kd_Urusan = M.Kd_Urusan AND B.Kd_Bidang = M.Kd_Bidang AND B.Kd_Unit = M.Kd_Unit AND B.Kd_Sub = M.Kd_Sub
				INNER JOIN
				(
				    SELECT
						A.Tahun,
						A.No_SPP,
						B.Ket_Kegiatan,
						C.Ket_Program,
						B.Status_Kegiatan,
						CASE
						   WHEN A.Kd_Prog = 0 THEN '-'
						   ELSE CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END
						   END AS Kd_Prog_Gab,
						CASE
						   WHEN A.Kd_Prog = 0 THEN '-'
						   ELSE CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END
						   END AS Kd_Keg_Gab,
						CASE
						   WHEN A.Kd_Prog = 0 AND '$spp_query->Kd_Rek_1' <> 6 THEN CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.00.00.5.1'
						   WHEN A.Kd_Prog = 0 AND '$spp_query->Kd_Rek_1' = 6 THEN CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.00.00.6.2'
						   ELSE CONVERT(varchar, C.Kd_Urusan1) + '.' + RIGHT('0' + CONVERT(varchar, C.Kd_Bidang1), 2) + ' . ' + CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + ' . ' +
						        CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + ' . ' +
						        CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END + ' . 5 . 2'
						   END AS No_DPA
				    FROM ($tmpSPP) AS A 
				    INNER JOIN
						Ta_Kegiatan B ON A.Tahun = B.Tahun AND
						A.Kd_Urusan = B.Kd_Urusan AND
						A.Kd_Bidang = B.Kd_Bidang AND
						A.Kd_Unit = B.Kd_Unit AND
						A.Kd_Sub = B.Kd_Sub AND
						A.Kd_Prog = B.Kd_Prog AND
						A.ID_Prog = B.ID_Prog AND
						A.Kd_Keg = B.Kd_Keg
					INNER JOIN
						Ta_Program C ON B.Tahun = C.Tahun AND
						B.Kd_Urusan = C.Kd_Urusan AND
						B.Kd_Bidang = C.Kd_Bidang AND
						B.Kd_Unit = C.Kd_Unit AND
						B.Kd_Sub = C.Kd_Sub AND
						B.Kd_Prog = C.Kd_Prog AND B.ID_Prog = C.ID_Prog
				) P ON B.Tahun = P.Tahun AND B.No_SPP = P.No_SPP 
				LEFT OUTER JOIN
    				($tmpSP2D) AS O ON B.Tahun = O.Tahun AND
                    B.Kd_Urusan = O.Kd_Urusan AND
                    B.Kd_Bidang = O.Kd_Bidang AND
                    B.Kd_Unit = O.Kd_Unit AND
                    B.Kd_Sub = O.Kd_Sub
		        LEFT OUTER JOIN
					Ta_SPP_Kontrak R ON B.Tahun = R.Tahun AND
					B.No_SPP = R.No_SPP
		        LEFT OUTER JOIN
				    Ta_DASK I ON C.Tahun = I.Tahun AND
					C.Kd_Urusan = I.Kd_Urusan AND
					C.Kd_Bidang = I.Kd_Bidang AND
					C.Kd_Unit = I.Kd_Unit AND
					C.Kd_Sub = I.Kd_Sub
        		LEFT OUTER JOIN TA_KONTRAK Q ON Q.Tahun = R.Tahun AND
                    Q.NO_KONTRAK= R.NO_KONTRAK
     			LEFT OUTER JOIN
			    (
					SELECT
						TOP 1 A.NO_ADDENDUM,
						A.TGL_ADDENDUM,
						A.WAKTU,A.KEPERLUAN,
						A.TAHUN,
						A.NO_KONTRAK
					FROM
					     Ta_Kontrak_Addendum A
					INNER JOIN TA_KONTRAK B ON A.TAHUN=B.TAHUN AND
						A.NO_KONTRAK=B.NO_KONTRAK
					INNER JOIN Ta_SPP_Kontrak C  ON A.TAHUN=C.TAHUN AND
						A.NO_KONTRAK=C.NO_KONTRAK
					INNER JOIN TA_SPP D ON C.TAHUN=D.TAHUN AND
						C.NO_SPP=D.NO_SPP
					WHERE D.TGL_SPP>=A.TGL_ADDENDUM AND 
						D.No_SPP = '$no_spp'
			     ORDER BY A.Tgl_Addendum, A.No_Addendum
			    ) X ON X.Tahun = R.Tahun AND X.No_Kontrak = R.No_Kontrak
			ORDER BY M.Tgl_SPD, M.No_SPD
		")
			->result();
		$output										= array
		(
			'data_query'							=> $data_query,
			'no_spp'							    => $params['no_spp'],
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

	public function spp3_permendagri($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spp                                     = $params['no_spp'];
		$spp_query								    = $this->query
		("
			SELECT 
				A.Kd_Urusan,
				A.Kd_Bidang,
				A.Kd_Unit,
				A.Kd_Sub,
				A.No_SPP,
				A.Tgl_SPP,
				A.Jn_SPP,
				A.Tahun,
		       	B.Kd_Rek_1
			FROM Ta_SPP A, Ta_SPP_Rinc B
			WHERE A.Tahun = '$tahun'
			  AND A.No_SPP = B.No_SPP
			  AND A.No_SPP = '$no_spp'
		")
			->row();

		$jn_in                                      = array('2', '5');
		if ($spp_query->No_SPP == $no_spp && in_array($spp_query->Jn_SPP, $jn_in))
		{
			$tmpSPP                                 =
				("
				SELECT
			       A.Tahun,
			       B.No_SPP,
			       A.Kd_Urusan,
			       A.Kd_Bidang,
			       A.Kd_Unit,
			       A.Kd_Sub,
			       A.Kd_Prog,
			       A.ID_Prog,
			       A.Kd_Keg,
			       A.Kd_Rek_1,
			       A.Kd_Rek_2,
			       A.Kd_Rek_3,
			       A.Kd_Rek_4,
			       A.Kd_Rek_5,
			       SUM(A.Nilai_Setuju) AS Nilai
				FROM
					Ta_Pengesahan_SPJ_Rinc A
				INNER JOIN
					Ta_SPP B ON A.Tahun = B.Tahun AND
					A.No_Pengesahan = B.No_SPJ
				WHERE B.Tahun = '$tahun' AND
					B.No_SPP = '$no_spp'
				GROUP BY A.Tahun, B.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
			");
		}
		elseif($spp_query->No_SPP == $no_spp && $spp_query->Jn_SPP == '4')
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					A.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					0 AS Kd_Prog,
					0 AS ID_Prog,
					0 AS Kd_Keg,
					1 AS Kd_Rek_1,
					1 AS Kd_Rek_2,
					1 AS Kd_Rek_3,
					3 AS Kd_Rek_4,
					1 AS Kd_Rek_5,
					SUM(A.Usulan) AS Nilai
				FROM Ta_SPP_Rinc A
				WHERE
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub
			");
		}
		else
		{
			$tmpSPP                                 =
				("
				SELECT
					A.Tahun,
					A.No_SPP,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Kd_Prog,
					A.ID_Prog,
					A.Kd_Keg,
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
					A.Kd_Rek_4,
					A.Kd_Rek_5,
					SUM(A.Usulan) AS Nilai
				FROM
					Ta_SPP_Rinc A
				WHERE
					A.Tahun = '$tahun' AND
					A.No_SPP = '$no_spp'
				GROUP BY A.Tahun, A.No_SPP, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
			");
		}

		$data_query								    = $this->query
		("
			SELECT
				B.No_SPP,
				B.Tgl_SPP,
				B.Jn_SPP,
				CONVERT(varchar, A.Kd_Rek_1) + '.' + CONVERT(varchar, A.Kd_Rek_2) AS Rek_2,
				CONVERT(varchar, A.Kd_Rek_1) + '.' + CONVERT(varchar, A.Kd_Rek_2) + '.' + CONVERT(varchar, A.Kd_Rek_3) AS Rek_3,
				CASE
				WHEN B.Jn_SPP = 1 THEN 'UANG PERSEDIAAN (SPP-UP)'
				WHEN B.Jn_SPP = 2 THEN 'GANTI UANG PERSEDIAAN (SPP-GU)'
				WHEN B.Jn_SPP = 4 THEN 'TAMBAHAN UANG PERSEDIAAN (SPP-TU)'
				WHEN B.Jn_SPP = 5 THEN 'NIHIL (SPP-NIHIL)'
				WHEN B.Jn_SPP = 3 THEN
					CASE
					WHEN A.Kd_Rek_1 = 5 AND A.Kd_Rek_2 = 2 THEN 'LANGSUNG BARANG DAN JASA (SPP-LS BARANG DAN JASA)'
					WHEN A.Kd_Rek_1 = 5 AND A.Kd_Rek_2 = 1 AND A.Kd_Rek_3 = 1 THEN 'LANGSUNG GAJI DAN TUNJANGAN (SPP-LS-GAJI-TUNJANGAN)'
					WHEN A.Kd_Rek_1 = 6 AND A.Kd_Rek_2 = 2 THEN 'LANGSUNG PEMBIAYAAN (SPP-LS PEMBIAYAAN)'
					ELSE 'LANGSUNG BELANJA PENGELUARAN PPKD'
					END
				ELSE ''
				END AS Judul,
				G.kd_program, G.kd_kegiatan, G.kd_sub_kegiatan,
				RIGHT('0' + CONVERT(varchar, G.kd_program), 2) AS Kd_Prog_Gab,
				RIGHT('0' + CONVERT(varchar, G.kd_program), 2) + ' . ' + G.kd_kegiatan AS Kd_Keg_Gab,
				RIGHT('0' + CONVERT(varchar, G.kd_program), 2) + ' . ' + G.kd_kegiatan  + ' . ' + RIGHT('0' + CONVERT(varchar, G.kd_sub_kegiatan), 2) AS Kd_Sub_Keg_Gab,
				J.nm_program, I.nm_kegiatan, G.nm_sub_kegiatan,
				CONVERT(varchar, K.Kd_Rek90_1) + '.' + CONVERT(varchar, K.Kd_Rek90_2) + '.' + CONVERT(varchar, K.Kd_Rek90_3) + '.' + RIGHT('0' + CONVERT(varchar, K.Kd_Rek90_4), 2) + '.' + RIGHT('0' + CONVERT(varchar, K.Kd_Rek90_5), 2) + '.' + RIGHT('0000' + CONVERT(varchar, K.Kd_Rek90_6), 4) AS Kd_Rek_Gab,
				K.Nm_Rek90_6, A.Nilai,
				F.Nm_Bendahara, F.Nip_Bendahara, F.Jbt_Bendahara,
				B.Nama_PPTK, B.Nip_PPTK, H.Ibukota
			FROM
			($tmpSPP) AS A 
			INNER JOIN
				Ta_SPP B ON A.Tahun = B.Tahun AND
			    A.No_SPP = B.No_SPP
		    INNER JOIN
				ref_rek_mapping C ON A.Kd_Rek_1 = C.Kd_Rek_1 AND
			    A.Kd_Rek_2 = C.Kd_Rek_2 AND
			    A.Kd_Rek_3 = C.Kd_Rek_3 AND
			    A.Kd_Rek_4 = C.Kd_Rek_4 AND
			    A.Kd_Rek_5 = C.Kd_Rek_5 
		    INNER JOIN
				ref_rek90_6 K ON C.kd_rek90_1 = K.kd_rek90_1 AND
			    C.kd_rek90_2 = K.kd_rek90_2 AND
			    C.kd_rek90_3 = K.kd_rek90_3 AND
			    C.kd_rek90_4 = K.kd_rek90_4 AND
			    C.kd_rek90_5 = K.kd_rek90_5 AND
			    C.kd_rek90_6 = K.kd_rek90_6 
		    INNER JOIN
				ta_program D ON A.tahun = D.tahun AND
			    A.kd_urusan = D.kd_urusan AND
			    A.kd_bidang = D.kd_bidang AND
			    A.kd_unit = D.kd_unit AND
			    A.kd_sub = D.kd_sub AND
			    A.kd_prog = D.kd_prog AND
			    A.id_prog = D.id_prog 
		    INNER JOIN
				ref_kegiatan_mapping E ON D.kd_urusan1 = E.kd_urusan AND
			    D.kd_bidang1 = E.kd_bidang AND
			    D.kd_prog = E.kd_prog AND
			    A.kd_keg = E.kd_keg
		    INNER JOIN
				ref_sub_kegiatan90 G ON E.kd_urusan90 = G.kd_urusan AND
				E.kd_bidang90 = G.kd_bidang AND
				E.kd_program90 = G.kd_program AND
				E.kd_kegiatan90 = G.kd_kegiatan AND
				E.kd_sub_kegiatan = G.kd_sub_kegiatan
		    INNER JOIN
				ref_kegiatan90 I ON G.kd_urusan = I.kd_urusan AND
				G.kd_bidang = I.kd_bidang AND
				G.kd_program = I.kd_program AND
				G.kd_kegiatan = I.kd_kegiatan
		    INNER JOIN
				ref_program90 J ON I.kd_urusan = J.kd_urusan AND
				I.kd_bidang = J.kd_bidang AND
				I.kd_program = J.kd_program
		    INNER JOIN
			(
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					Nama AS Nm_Bendahara,
					Nip AS Nip_Bendahara,
					Jabatan AS Jbt_Bendahara
				FROM
				    Ta_Sub_Unit_Jab A
			    INNER JOIN
				(
					SELECT
					    Tahun,
					    Kd_Urusan,
					    Kd_Bidang,
					    Kd_Unit,
					    Kd_Sub,
					    Kd_Jab,
					    MIN(No_Urut) AS No_Urut
					FROM
				    Ta_Sub_Unit_Jab
					GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
				) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Jab = B.Kd_Jab AND A.No_Urut = B.No_Urut
				WHERE (A.Tahun = '$tahun') AND (A.Kd_Jab = 4)
			) F ON A.Tahun = F.Tahun AND A.Kd_Urusan = F.Kd_Urusan AND A.Kd_Bidang = F.Kd_Bidang AND A.Kd_Unit = F.Kd_Unit AND A.Kd_Sub = F.Kd_Sub 
		    INNER JOIN Ta_Pemda H ON F.Tahun = H.Tahun
			ORDER BY A.Kd_Prog, A.ID_Prog, A.Kd_Keg, A.Kd_Rek_1, A.Kd_Rek_2, A.Kd_Rek_3, A.Kd_Rek_4, A.Kd_Rek_5
		")
			->result();
		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function register_spp($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$jn_spm                                     = $params['jn_spm'];
		$d1										    = '2021-01-01'; //$params['periode_awal'];
		$d2										    = '2021-12-31'; //$params['periode_akhir'];
		$kd_jab										= '4';
		$kd_edit									= '%';

		$data_query								    = $this->query
		("
			SELECT
				D.Kd_Urusan_Gab,
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
				E.Status,
				A.Tgl_SPP,
				A.No_SPP,
				B.Nm_Jn_SPM,
				D.Nm_Pimpinan,
				D.Nip_Pimpinan,
				D.Jbt_Pimpinan,
				D.Nm_Penandatangan,
				D.Nip_Penandatangan,
				D.Jbt_Penandatangan,
				A.Uraian, A.Nilai_SPP
			FROM
			(
			    SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					B.No_SPP,
					B.Tgl_SPP,
					B.Jn_SPP,
					B.Uraian,
					SUM(CASE '$kd_jab' WHEN '2' THEN A.Nilai ELSE A.Usulan END) AS Nilai_SPP
			    FROM
					Ta_SPP_Rinc A
				INNER JOIN
			         Ta_SPP B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
			    WHERE
					(B.Tahun = '$tahun') AND
					(B.Kd_Urusan LIKE '$kd_urusan') AND (B.Kd_Bidang LIKE $kd_bidang) AND
					(B.Kd_Unit LIKE '$kd_unit') AND (B.Kd_Sub LIKE '$kd_sub') AND
					(B.Kd_Edit LIKE '$kd_edit') AND (B.Jn_SPP LIKE '$jn_spm') AND
					(B.Tgl_SPP BETWEEN '$d1' AND '$d2')
			    GROUP BY A.Tahun, A.Kd_Urusan, A.Kd_Bidang, A.Kd_Unit, A.Kd_Sub, B.No_SPP, B.Tgl_SPP, B.Jn_SPP, B.Uraian
			) A
			INNER JOIN Ref_Jenis_SPM B ON A.Jn_SPP = B.Jn_SPM,
			(
				SELECT
					'$kd_urusan' AS Kd_UrusanA,
					$kd_bidang AS Kd_BidangA,
					'$kd_unit' AS Kd_UnitA,
					'$kd_sub' AS Kd_SubA,
					'$kd_urusan' AS Kd_Urusan_Gab,
					'$kd_urusan' + ' . ' + RIGHT('0' + $kd_bidang, 2) AS Kd_Bidang_Gab,
					'$kd_urusan' + ' . ' + RIGHT('0' + $kd_bidang, 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) AS Kd_Unit_Gab,
					'$kd_urusan' + ' . ' + RIGHT('0' + $kd_bidang, 2) + ' . ' + RIGHT('0' +  '$kd_unit', 2) + ' . ' + RIGHT('0' +  '$kd_sub', 2) AS Kd_Sub_Gab,
					E.Nm_Urusan AS Nm_Urusan_Gab,
					D.Nm_Bidang AS Nm_Bidang_Gab,
					C.Nm_Unit AS Nm_Unit_Gab,
					B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
					A.Nm_Pimpinan AS Nm_Pimpinan,
					A.Nip_Pimpinan AS Nip_Pimpinan,
					A.Jbt_Pimpinan AS Jbt_Pimpinan,
					G.Nm_Penandatangan,
					G.Nip_Penandatangan,
					G.Jbt_Penandatangan
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
					 WHERE 
						(A.Tahun = '$tahun') AND
						(A.Kd_Urusan LIKE '$kd_urusan') AND
						(A.Kd_Bidang LIKE $kd_bidang) AND
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
						MIN(Nama) AS Nm_Penandatangan,
						MIN(Nip) AS Nip_Penandatangan,
						MIN(Jabatan) AS Jbt_Penandatangan
					FROM
					    Ta_Sub_Unit_Jab A
					WHERE 
						(A.Kd_Jab = '$kd_jab') AND
						(A.Tahun = '$tahun') AND
						(A.Kd_Urusan LIKE '$kd_urusan') AND
						(A.Kd_Bidang LIKE $kd_bidang) AND
						(A.Kd_Unit LIKE '$kd_unit') AND
						(A.Kd_Sub LIKE '$kd_sub')
					GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub
				) G ON F.Tahun = G.Tahun AND F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND F.Kd_Unit = G.Kd_Unit AND F.Kd_Sub = G.Kd_Sub
			) D,
			(
			    SELECT
			        CASE '$kd_edit'
			            WHEN '%' THEN 'DRAFT, FINAL, BATAL'
			            ELSE UPPER(MIN(A.Nm_Edit))
			            END AS Status
			    FROM Ref_EditData A
			    WHERE A.Kd_Edit LIKE '$kd_edit'
			) E
			ORDER BY A.Tgl_SPP, A.No_SPP
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function s3tu($params)
	{
		$tahun                                      = $params['tahun'];
		$no_bukti                                   = $params['no_s3tu'];

		$data_query								    = $this->query
		("
			SELECT
				A.No_Bukti,
				A.Tgl_Bukti,
				ISNULL(C.Nm_Bank, '') + ' ' + ISNULL(No_Rekening, '') AS Rekening_Bank,
				CONVERT(varchar, B.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, B.Kd_Bidang), 2) AS Kd_Gab_Bidang,
				CONVERT(varchar, B.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, B.Kd_Bidang), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, B.Kd_Unit), 2) AS Kd_Gab_Unit,
				CONVERT(varchar, B.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, B.Kd_Bidang), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, B.Kd_Unit), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, B.Kd_Sub), 2) AS Kd_Gab_Sub,
				I.Nm_Urusan + ' ' + H.Nm_Bidang AS Nm_Bidang,
				G.Nm_Unit,
				F.Nm_Sub_Unit,
				ISNULL(J.Nm_Bendahara, '') AS Nm_Bendahara,
				ISNULL(J.Nip_Bendahara, '') AS Nip_Bendahara,
				ISNULL(J.Jbt_Bendahara, '') AS Jbt_Bendahara, E.Alamat,
				CONVERT(varchar, C.Kd_Rek_1) + ' . ' + CONVERT(varchar, C.Kd_Rek_2) + ' . ' + CONVERT(varchar, C.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, C.Kd_Rek_4), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, C.Kd_Rek_5), 2) AS Kd_Rek_Gab,
				D.Nm_Rek_5,
				Nilai,
				A.Keterangan
			FROM Ta_SPJ_Sisa A
			INNER JOIN
			     Ta_SPJ B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ
			INNER JOIN
			     Ref_Bank C ON A.Kd_Bank = C.Kd_Bank
			INNER JOIN
			     Ref_Rek_5 D ON C.Kd_Rek_1 = D.Kd_Rek_1 AND C.Kd_Rek_2 = D.Kd_Rek_2 AND C.Kd_Rek_3 = D.Kd_Rek_3 AND C.Kd_Rek_4 = D.Kd_Rek_4 AND C.Kd_Rek_5 = D.Kd_Rek_5
			INNER JOIN
			     Ta_Sub_Unit E ON B.Tahun = E.Tahun AND B.Kd_Urusan = E.Kd_Urusan AND B.Kd_Bidang = E.Kd_Bidang AND B.Kd_Unit = E.Kd_Unit AND B.Kd_Sub = E.Kd_Sub
			INNER JOIN
			     Ref_Sub_Unit F ON E.Kd_Urusan = F.Kd_Urusan AND E.Kd_Bidang = F.Kd_Bidang AND E.Kd_Unit = F.Kd_Unit AND E.Kd_Sub = F.Kd_Sub
			INNER JOIN
			     Ref_Unit G ON F.Kd_Urusan = G.Kd_Urusan AND F.Kd_Bidang = G.Kd_Bidang AND F.Kd_Unit = G.Kd_Unit
			INNER JOIN
			     Ref_Bidang H ON G.Kd_Urusan = H.Kd_Urusan AND G.Kd_Bidang = H.Kd_Bidang
			INNER JOIN
			     Ref_Urusan I ON H.Kd_Urusan = I.Kd_Urusan
			LEFT OUTER JOIN
			(
				SELECT
					A.Tahun,
					A.Kd_Urusan,
					A.Kd_Bidang,
					A.Kd_Unit,
					A.Kd_Sub,
					A.Nama AS Nm_Bendahara,
					A.Nip AS Nip_Bendahara,
					A.Jabatan AS Jbt_Bendahara
				FROM Ta_Sub_Unit_Jab A
				INNER JOIN
				(
					SELECT 
						Tahun, 
						Kd_Urusan, 
						Kd_Bidang, 
						Kd_Unit, 
						Kd_Sub, 
						Kd_Jab, 
						MIN(No_Urut) AS No_Urut
					FROM
						Ta_Sub_Unit_Jab
					WHERE
						Kd_Jab = 4
					GROUP BY Tahun, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Jab
				) B ON A.Tahun = B.Tahun AND A.Kd_Urusan = B.Kd_Urusan AND A.Kd_Bidang = B.Kd_Bidang AND A.Kd_Unit = B.Kd_Unit AND A.Kd_Sub = B.Kd_Sub AND A.Kd_Jab = B.Kd_Jab AND A.No_Urut = B.No_Urut
			) J ON E.Tahun = J.Tahun AND E.Kd_Urusan = J.Kd_Urusan AND E.Kd_Bidang = J.Kd_Bidang AND E.Kd_Unit = J.Kd_Unit AND E.Kd_Sub = J.Kd_Sub
			WHERE (A.Tahun = $tahun) AND (A.No_Bukti = '$no_bukti')
		")
			->row();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function pertanggungjawaban_tup($params)
	{
		$tahun                                      = $params['tahun'];
		$no_spj                                     = $params['no_spj'];

		$data_query								    = $this->query
		("
			SELECT
				CONVERT(varchar, I.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, I.Kd_Bidang), 2) AS Kd_Gab_Bidang,
				CONVERT(varchar, I.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, I.Kd_Bidang), 2) + ' . ' + CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) AS Kd_Gab_Unit,
				CONVERT(varchar, I.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, I.Kd_Bidang), 2) + ' . ' + CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2) AS Kd_Gab_Sub,
				CONVERT(varchar, I.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, I.Kd_Bidang), 2) + ' . ' + CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2) + ' . ' + CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END AS Kd_Gab_Prog,
				CONVERT(varchar, I.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, I.Kd_Bidang), 2) + ' . ' + CONVERT(varchar, A.Kd_Urusan) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Bidang), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Unit), 2) + '.' + RIGHT('0' + CONVERT(varchar, A.Kd_Sub), 2) + ' . ' + CASE LEN(CONVERT(varchar, A.Kd_Prog)) WHEN 3 THEN CONVERT(varchar, A.Kd_Prog) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Prog), 2) END + ' . ' + CASE LEN(CONVERT(varchar, A.Kd_Keg)) WHEN 3 THEN CONVERT(varchar, A.Kd_Keg) ELSE RIGHT('0' + CONVERT(varchar, A.Kd_Keg), 2) END AS Kd_Gab_Keg,
				CONVERT(varchar, A.Kd_Rek_1) + ' . ' + CONVERT(varchar, A.Kd_Rek_2) + ' . ' + CONVERT(varchar, A.Kd_Rek_3) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_4), 2) + ' . ' + RIGHT('0' + CONVERT(varchar, A.Kd_Rek_5), 2) AS Kd_Rek,
				J.Nm_Urusan + ' ' + I.Nm_Bidang AS Nm_Bidang, H.Nm_Unit, G.Nm_Sub_Unit, E.Ket_Program, D.Ket_Kegiatan, L.Tgl_SP2D, C.Nm_Rek_5, A.Nilai, K.Nilai_TU, N.Tgl_Bukti, ISNULL(N.Nilai, 0) AS Sisa,
				F.Nm_Pimpinan, F.Nip_Pimpinan, F.Jbt_Pimpinan, M.Nama, M.Nip, M.Jabatan, O.Ibukota
			FROM
			(
				SELECT
					Tahun,
					No_SPJ,
					Kd_Urusan,
					Kd_Bidang,
					Kd_Unit,
					Kd_Sub,
					Kd_Prog,
					ID_Prog,
					Kd_Keg,
					Kd_Rek_1,
					Kd_Rek_2,
					Kd_Rek_3,
					Kd_Rek_4,
					Kd_Rek_5,
					SUM(Nilai) AS Nilai
				FROM
					Ta_SPJ_Rinc
				WHERE
					(Tahun = '$tahun') AND
					(No_SPJ = '$no_spj')
				GROUP BY Tahun, No_SPJ, Kd_Urusan, Kd_Bidang, Kd_Unit, Kd_Sub, Kd_Prog, ID_Prog, Kd_Keg, Kd_Rek_1, Kd_Rek_2, Kd_Rek_3, Kd_Rek_4, Kd_Rek_5
				) A
				INNER JOIN
					Ta_SPJ B ON A.Tahun = B.Tahun AND A.No_SPJ = B.No_SPJ
				INNER JOIN
					Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 AND
					A.Kd_Rek_2 = C.Kd_Rek_2 AND
					A.Kd_Rek_3 = C.Kd_Rek_3 AND
					A.Kd_Rek_4 = C.Kd_Rek_4 AND
					A.Kd_Rek_5 = C.Kd_Rek_5 
				INNER JOIN
					Ta_Kegiatan D ON A.Tahun = D.Tahun AND
					A.Kd_Urusan = D.Kd_Urusan AND
					A.Kd_Bidang = D.Kd_Bidang AND
					A.Kd_Unit = D.Kd_Unit AND
					A.Kd_Sub = D.Kd_Sub AND
					A.Kd_Prog = D.Kd_Prog AND
					A.ID_Prog = D.ID_Prog AND
					A.Kd_Keg = D.Kd_Keg
				INNER JOIN
					Ta_Program E ON D.Tahun = E.Tahun AND
					D.Kd_Urusan = E.Kd_Urusan AND
					D.Kd_Bidang = E.Kd_Bidang AND
					D.Kd_Unit = E.Kd_Unit AND
					D.Kd_Sub = E.Kd_Sub AND
					D.Kd_Prog = E.Kd_Prog AND
					D.ID_Prog = E.ID_Prog
				INNER JOIN
					Ta_Sub_Unit F ON E.Tahun = F.Tahun AND
					E.Kd_Urusan = F.Kd_Urusan AND
					E.Kd_Bidang = F.Kd_Bidang AND
					E.Kd_Unit = F.Kd_Unit AND
					E.Kd_Sub = F.Kd_Sub
				INNER JOIN
					Ref_Sub_Unit G ON F.Kd_Urusan = G.Kd_Urusan AND
					F.Kd_Bidang = G.Kd_Bidang AND
					F.Kd_Unit = G.Kd_Unit AND
					F.Kd_Sub = G.Kd_Sub
				INNER JOIN
					Ref_Unit H ON G.Kd_Urusan = H.Kd_Urusan AND
					G.Kd_Bidang = H.Kd_Bidang AND G.Kd_Unit = H.Kd_Unit
				INNER JOIN
					Ref_Bidang I ON E.Kd_Urusan1 = I.Kd_Urusan AND E.Kd_Bidang1 = I.Kd_Bidang 
				INNER JOIN
					Ref_Urusan J ON I.Kd_Urusan = J.Kd_Urusan
				INNER JOIN
				(
					SELECT
						B.Tahun,
						B.No_SPM,
						SUM(A.Nilai) AS Nilai_TU
					FROM
						Ta_SPM_Rinc A
					INNER JOIN
						Ta_SPM B ON A.Tahun = B.Tahun AND
						A.No_SPM = B.No_SPM
					GROUP BY B.Tahun, B.No_SPM
				) K ON B.Tahun = K.Tahun AND B.No_SPM = K.No_SPM
				INNER JOIN
					Ta_SP2D L ON K.Tahun = L.Tahun AND K.No_SPM = L.No_SPM
				INNER JOIN
					Ta_Pemda O ON F.Tahun = O.Tahun
				LEFT OUTER JOIN
				(
					SELECT
						*
					FROM
						Ta_Sub_Unit_Jab
					WHERE
						(Tahun = '$tahun' AND Kd_Jab = 4)
			) M ON F.Tahun = M.Tahun AND F.Kd_Urusan = M.Kd_Urusan AND F.Kd_Bidang = M.Kd_Bidang AND F.Kd_Unit = M.Kd_Unit AND F.Kd_Sub = M.Kd_Sub
			LEFT OUTER JOIN
				Ta_SPJ_Sisa N ON B.Tahun = N.Tahun AND
				B.No_SPJ = N.No_SPJ
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

	// lewat query
	public function bku_pembantu_bank($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$cms    								    = $this->query
		("
			SELECT
				CMS2
			FROM
				Ref_Setting
			WHERE
				( Tahun = '$tahun' ) 
				AND ( Kd_Urusan LIKE '$kd_urusan' ) 
				AND ( Kd_Bidang LIKE '$kd_bidang' ) 
				AND ( Kd_Unit LIKE '$kd_unit' ) 
				AND ( Kd_Sub LIKE '$kd_sub' ) 
		")
			->row('CMS2');

//		$bku    								    =
//		("
//			SELECT
//				A.Tgl_SP2D AS Tgl_Bukti,
//				'2' AS Kode_P,
//				2 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				A.No_SP2D AS No_Bukti1,
//				A.No_SP2D AS No_Bukti,
//				0 AS Kd_Rek_1,
//				0 AS Kd_Rek_2,
//				0 AS Kd_Rek_3,
//				0 AS Kd_Rek_4,
//				0 AS Kd_Rek_5,
//				A.Keterangan AS Nm_Rek_5,
//				SUM ( C.Nilai ) AS Debet,
//				0 AS Kredit
//			FROM
//				Ta_SP2D A
//				INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun
//				AND A.No_SPM = B.No_SPM
//				INNER JOIN Ta_SPM_Rinc C ON B.Tahun = C.Tahun
//				AND B.No_SPM = C.No_SPM
//			WHERE
//				( B.Kd_Edit = 1 )
//				AND ( B.Jn_SPM IN ( 1, 2, 4 ) )
//				AND ( A.Tgl_SP2D <= '$d2' )
//				AND ( B.Tahun = '$tahun' )
//				AND ( B.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( B.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( B.Kd_Unit LIKE '$kd_unit' )
//				AND ( B.Kd_Sub LIKE '$kd_sub' )
//			GROUP BY
//				A.Tgl_SP2D,
//				A.No_SP2D,
//				A.Keterangan
//		");

		$bku								        = $this->query
		("
			SELECT
				A.Tgl_Bukti,
				A.Kd_Pembayaran,
				10 AS Kd_Trans1,
			CASE
					A.D_K
					WHEN 'K' THEN
					1 ELSE 2
				END AS Kd_Trans2,
				A.No_Bukti AS No_Bukti1,
				A.No_Bukti,
				0 AS Kd_Rek_1,
				0 AS Kd_Rek_2,
				0 AS Kd_Rek_3,
				0 AS Kd_Rek_4,
				0 AS Kd_Rek_5,
				A.Keterangan,
				SUM ( CASE A.D_K WHEN 'D' THEN 0 ELSE A.Nilai END ) AS Debet,
				SUM ( CASE A.D_K WHEN 'K' THEN 0 ELSE A.Nilai END ) AS Kredit
			FROM
				Ta_Panjar A
			WHERE
				( A.Tgl_Bukti <= '$d2' )
				AND ( A.Tahun = '$tahun' )
				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
				AND ( A.Kd_Unit LIKE '$kd_unit' )
				AND ( A.Kd_Sub LIKE '$kd_sub' )
				AND ( A.Kd_Pembayaran = 2 )
			GROUP BY
				A.Tgl_Bukti,
				A.No_Bukti,
				A.Keterangan,
				A.Kd_Pembayaran,
				A.D_K
		")
			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				B.Tgl_Bukti,
//				A.Kd_Pembayaran,
//				9 AS Kd_Trans1,
//				CASE
//					B.D_K
//					WHEN 'D' THEN
//					1 ELSE 2
//				END AS Kd_Trans2,
//				B.No_Bukti AS No_Bukti1,
//				B.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				D.Nm_Rek_5,
//				SUM ( CASE B.D_K WHEN 'K' THEN 0 ELSE A.Nilai END ) AS Debet,
//				SUM ( CASE B.D_K WHEN 'D' THEN 0 ELSE A.Nilai END ) AS Kredit
//			FROM
//				Ta_Pajak_Rinc A
//				INNER JOIN Ta_Pajak B ON A.Tahun = B.Tahun
//				AND A.No_Bukti = B.No_Bukti
//				INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1
//				AND A.Kd_Rek_2 = D.Kd_Rek_2
//				AND A.Kd_Rek_3 = D.Kd_Rek_3
//				AND A.Kd_Rek_4 = D.Kd_Rek_4
//				AND A.Kd_Rek_5 = D.Kd_Rek_5
//			WHERE
//				( B.Tgl_Bukti <= '$d2' )
//				AND ( B.Tahun = '$tahun' )
//				AND ( B.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( B.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( B.Kd_Unit LIKE '$kd_unit' )
//				AND ( B.Kd_Sub LIKE '$kd_sub' )
//				AND ( A.Kd_Pembayaran = 2 )
//			GROUP BY
//				B.Tgl_Bukti,
//				B.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				D.Nm_Rek_5,
//				A.Kd_Pembayaran,
//				B.D_K
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				C.Tgl_Bukti,
//				C.Kd_Pembayaran,
//				7 AS Kd_Trans1,
//				2 AS Kd_Trans2,
//				A.No_Bukti AS No_Bukti1,
//				A.No_Bukti,
//				B.Kd_Rek_1,
//				B.Kd_Rek_2,
//				B.Kd_Rek_3,
//				B.Kd_Rek_4,
//				B.Kd_Rek_5,
//				D.Nm_Rek_5,
//				SUM ( A.Nilai ) AS Debet,
//				SUM ( CASE WHEN '$cms' = 1 AND C.Cair = 1 THEN A.Nilai ELSE 0 END ) AS Kredit
//			FROM
//				Ta_SPJ_Pot A
//				INNER JOIN Ta_SPJ_Bukti C ON A.Tahun = C.Tahun
//				AND A.No_Bukti = C.No_Bukti
//				INNER JOIN Ref_Pot_SPM_Rek B ON A.Kd_Pot_Rek = B.Kd_Pot_Rek
//				INNER JOIN Ref_Rek_5 D ON B.Kd_Rek_1 = D.Kd_Rek_1
//				AND B.Kd_Rek_2 = D.Kd_Rek_2
//				AND B.Kd_Rek_3 = D.Kd_Rek_3
//				AND B.Kd_Rek_4 = D.Kd_Rek_4
//				AND B.Kd_Rek_5 = D.Kd_Rek_5
//			WHERE
//				( C.Tgl_Bukti <= '$d2' )
//				AND ( C.Tahun = '$tahun' )
//				AND ( C.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( C.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( C.Kd_Unit LIKE '$kd_unit' )
//				AND ( C.Kd_Sub LIKE '$kd_sub' )
//				AND ( C.Kd_Pembayaran = 2 )
//			GROUP BY
//				C.Tgl_Bukti,
//				A.No_Bukti,
//				B.Kd_Rek_1,
//				B.Kd_Rek_2,
//				B.Kd_Rek_3,
//				B.Kd_Rek_4,
//				B.Kd_Rek_5,
//				D.Nm_Rek_5,
//				C.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				A.Tgl_Bukti,
//				A.Kd_Pembayaran,
//				7 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				A.No_Bukti AS No_Bukti1,
//				A.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				CASE
//						LTRIM( RTRIM( ISNULL( A.Uraian, '' ) ) )
//						WHEN '' THEN
//						D.Nm_Rek_5 ELSE A.Uraian
//					END,
//					0 AS Debet,
//					SUM ( A.Nilai ) AS Kredit
//			FROM
//				Ta_SPJ_Bukti A
//				INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1
//				AND A.Kd_Rek_2 = D.Kd_Rek_2
//				AND A.Kd_Rek_3 = D.Kd_Rek_3
//				AND A.Kd_Rek_4 = D.Kd_Rek_4
//				AND A.Kd_Rek_5 = D.Kd_Rek_5
//			WHERE
//				( A.Tgl_Bukti <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND ( ISNULL( A.No_SPJ_Panjar, '' ) = '' )
//				AND ( A.Kd_Pembayaran = 2 )
//			GROUP BY
//				A.Tgl_Bukti,
//				A.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//			CASE
//					LTRIM( RTRIM( ISNULL( A.Uraian, '' ) ) )
//					WHEN '' THEN
//					D.Nm_Rek_5 ELSE A.Uraian
//				END,
//				A.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				B.Tgl_Pengesahan,
//				D.Kd_Pembayaran,
//				8 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				B.No_Pengesahan AS No_Bukti1,
//				B.No_Pengesahan,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				C.Nm_Rek_5,
//				SUM ( A.Nilai_Usulan - A.Nilai_Setuju ) AS Debet,
//				0 AS Kredit
//			FROM
//				Ta_Pengesahan_SPJ_Rinc A
//				INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun
//				AND A.No_Pengesahan = B.No_Pengesahan
//				INNER JOIN Ta_SPJ_Rinc D ON B.Tahun = D.Tahun
//				AND B.No_SPJ = D.No_SPJ
//				AND A.No_ID = D.No_ID
//				INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1
//				AND A.Kd_Rek_2 = C.Kd_Rek_2
//				AND A.Kd_Rek_3 = C.Kd_Rek_3
//				AND A.Kd_Rek_4 = C.Kd_Rek_4
//				AND A.Kd_Rek_5 = C.Kd_Rek_5
//			WHERE
//				( B.Tgl_Pengesahan <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND ( A.Nilai_Setuju <> A.Nilai_Usulan )
//				AND ( D.Kd_Pembayaran = 2 )
//			GROUP BY
//				B.Tgl_Pengesahan,
//				B.No_Pengesahan,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				C.Nm_Rek_5,
//				D.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				C.Tgl_SPJ,
//				A.Kd_Pembayaran,
//				6 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				C.No_SPJ AS No_Bukti1,
//				C.No_SPJ,
//				0 AS Kd_Rek_1,
//				0 AS Kd_Rek_2,
//				0 AS Kd_Rek_3,
//				0 AS Kd_Rek_4,
//				0 AS Kd_Rek_5,
//				'Pertanggungjawaban Panjar',
//				SUM ( A.Nilai ) AS Debet,
//				0 AS Kredit
//			FROM
//				Ta_SPJ_Bukti A
//				INNER JOIN Ta_SPJ_Panjar C ON A.Tahun = C.Tahun
//				AND A.No_SPJ_Panjar = C.No_SPJ
//			WHERE
//				( C.Tgl_SPJ <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND ( A.Kd_Pembayaran = 2 )
//			GROUP BY
//				C.Tgl_SPJ,
//				C.No_SPJ,
//				A.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				C.Tgl_SPJ AS Tgl_Bukti,
//				A.Kd_Pembayaran,
//				6 AS Kd_Trans1,
//				2 AS Kd_Trans2,
//				C.No_SPJ AS No_Bukti1,
//				A.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				CASE
//						LTRIM( RTRIM( ISNULL( A.Uraian, '' ) ) )
//						WHEN '' THEN
//						D.Nm_Rek_5 ELSE A.Uraian
//					END,
//					0 AS Debet,
//					SUM ( A.Nilai ) AS Kredit
//			FROM
//				Ta_SPJ_Bukti A
//				INNER JOIN Ta_SPJ_Panjar C ON A.Tahun = C.Tahun
//				AND A.No_SPJ_Panjar = C.No_SPJ
//				INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1
//				AND A.Kd_Rek_2 = D.Kd_Rek_2
//				AND A.Kd_Rek_3 = D.Kd_Rek_3
//				AND A.Kd_Rek_4 = D.Kd_Rek_4
//				AND A.Kd_Rek_5 = D.Kd_Rek_5
//			WHERE
//				( A.Tgl_Bukti <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND ( A.Kd_Pembayaran = 2 )
//			GROUP BY
//				C.No_SPJ,
//				C.Tgl_SPJ,
//				A.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//			CASE
//					LTRIM( RTRIM( ISNULL( A.Uraian, '' ) ) )
//					WHEN '' THEN
//					D.Nm_Rek_5 ELSE A.Uraian
//				END,
//				A.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				A.Tgl_Bukti,
//				A.Kd_Pembayaran,
//				11 AS Kd_Trans1,
//				2 AS Kd_Trans2,
//				A.No_Bukti AS No_Bukti1,
//				A.No_Bukti,
//				0 AS Kd_Rek_1,
//				0 AS Kd_Rek_2,
//				0 AS Kd_Rek_3,
//				0 AS Kd_Rek_4,
//				0 AS Kd_Rek_5,
//				'Penyetoran Sisa TU',
//				0 AS Debet,
//				SUM ( A.Nilai ) AS Kredit
//			FROM
//				Ta_SPJ_Sisa A
//				INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun
//				AND A.No_SPJ = B.No_SPJ
//			WHERE
//				( A.Tgl_Bukti <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( B.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( B.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( B.Kd_Unit LIKE '$kd_unit' )
//				AND ( B.Kd_Sub LIKE '$kd_sub' )
//				AND ( A.Kd_Pembayaran = 2 )
//			GROUP BY
//				A.Tgl_Bukti,
//				A.No_Bukti,
//				A.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				B.Tgl_Bukti,
//				2 AS Kode_P,
//				12 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				B.No_Bukti AS No_Bukti1,
//				B.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				D.Nm_Rek_5,
//				SUM ( CASE A.D_K WHEN 'K' THEN A.Nilai ELSE 0 END ) AS Debet,
//				SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE 0 END ) AS Kredit
//			FROM
//				Ta_Jurnal_Rinc A
//				INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun
//				AND A.No_Bukti = B.No_Bukti
//				INNER JOIN (
//				SELECT
//					A.Tahun,
//					A.No_Bukti
//				FROM
//					Ta_Jurnal_Rinc A
//					INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun
//					AND A.No_Bukti = B.No_Bukti
//				WHERE
//					( A.D_K = 'D' )
//					AND ( A.Kd_Rek_1 = 1 )
//					AND ( A.Kd_Rek_2 = 1 )
//					AND ( A.Kd_Rek_3 = 1 )
//					AND ( A.Kd_Rek_4 = 3 )
//					AND ( A.Kd_Rek_5 = 1 )
//					AND ( B.Tgl_Bukti <= '$d2' )
//					AND ( A.Tahun = '$tahun' )
//					AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//					AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//					AND ( A.Kd_Unit LIKE '$kd_unit' )
//					AND ( A.Kd_Sub LIKE '$kd_sub' )
//					AND ( B.Kd_SKPD = '1' )
//				GROUP BY
//					A.Tahun,
//					A.No_Bukti
//				) C ON B.Tahun = C.Tahun
//				AND B.No_Bukti = C.No_Bukti
//				INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1
//				AND A.Kd_Rek_2 = D.Kd_Rek_2
//				AND A.Kd_Rek_3 = D.Kd_Rek_3
//				AND A.Kd_Rek_4 = D.Kd_Rek_4
//				AND A.Kd_Rek_5 = D.Kd_Rek_5
//			WHERE
//				(
//					NOT (
//						( A.D_K = 'D' )
//						AND ( A.Kd_Rek_1 = 1 )
//						AND ( A.Kd_Rek_2 = 1 )
//						AND ( A.Kd_Rek_3 = 1 )
//						AND ( A.Kd_Rek_4 = 3 )
//						AND ( A.Kd_Rek_5 = 1 )
//					)
//				)
//			GROUP BY
//				B.Tgl_Bukti,
//				B.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				D.Nm_Rek_5
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				B.Tgl_Bukti,
//				2 AS Kode_P,
//				12 AS Kd_Trans1,
//				2 AS Kd_Trans2,
//				B.No_Bukti AS No_Bukti1,
//				B.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				D.Nm_Rek_5,
//				SUM ( CASE A.D_K WHEN 'K' THEN A.Nilai ELSE 0 END ) AS Debet,
//				SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE 0 END ) AS Kredit
//			FROM
//				Ta_Jurnal_Rinc A
//				INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun
//				AND A.No_Bukti = B.No_Bukti
//				INNER JOIN (
//				SELECT
//					A.Tahun,
//					A.No_Bukti
//				FROM
//					Ta_Jurnal_Rinc A
//					INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun
//					AND A.No_Bukti = B.No_Bukti
//				WHERE
//					( A.D_K = 'K' )
//					AND ( A.Kd_Rek_1 = 1 )
//					AND ( A.Kd_Rek_2 = 1 )
//					AND ( A.Kd_Rek_3 = 1 )
//					AND ( A.Kd_Rek_4 = 3 )
//					AND ( A.Kd_Rek_5 = 1 )
//					AND ( B.Tgl_Bukti <= '$d2' )
//					AND ( A.Tahun = '$tahun' )
//					AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//					AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//					AND ( A.Kd_Unit LIKE '$kd_unit' )
//					AND ( A.Kd_Sub LIKE '$kd_sub' )
//					AND ( B.Kd_SKPD = '1' )
//				GROUP BY
//					A.Tahun,
//					A.No_Bukti
//				) C ON B.Tahun = C.Tahun
//				AND B.No_Bukti = C.No_Bukti
//				INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1
//				AND A.Kd_Rek_2 = D.Kd_Rek_2
//				AND A.Kd_Rek_3 = D.Kd_Rek_3
//				AND A.Kd_Rek_4 = D.Kd_Rek_4
//				AND A.Kd_Rek_5 = D.Kd_Rek_5
//			WHERE
//				(
//					NOT (
//						( A.D_K = 'K' )
//						AND ( A.Kd_Rek_1 = 1 )
//						AND ( A.Kd_Rek_2 = 1 )
//						AND ( A.Kd_Rek_3 = 1 )
//						AND ( A.Kd_Rek_4 = 3 )
//						AND ( A.Kd_Rek_5 = 1 )
//					)
//				)
//			GROUP BY
//				B.Tgl_Bukti,
//				B.No_Bukti,
//				A.Kd_Rek_1,
//				A.Kd_Rek_2,
//				A.Kd_Rek_3,
//				A.Kd_Rek_4,
//				A.Kd_Rek_5,
//				D.Nm_Rek_5
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				A.Tgl_Bukti,
//				A.Kd_Pembayaran AS Kode_P,
//				14 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				A.No_Bukti AS No_Bukti1,
//				A.No_Bukti,
//				0 AS Kd_Rek_1,
//				0 AS Kd_Rek_2,
//				0 AS Kd_Rek_3,
//				0 AS Kd_Rek_4,
//				0 AS Kd_Rek_5,
//				A.Keterangan,
//				SUM ( CASE A.D_K WHEN 'D' THEN 0 ELSE A.Nilai END ) AS Debet,
//				SUM ( CASE A.D_K WHEN 'K' THEN 0 ELSE A.Nilai END ) AS Kredit
//			FROM
//				Ta_S3UP A
//			WHERE
//				( A.Tgl_Bukti <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND ( A.Kd_Pembayaran = 2 )
//			GROUP BY
//				A.Tgl_Bukti,
//				A.No_Bukti,
//				A.Keterangan,
//				A.Kd_Pembayaran
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				A.Tgl_Bukti,
//				'2' AS Kode_P,
//				14 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				A.No_Bukti AS No_Bukti1,
//				A.No_Bukti,
//				0 AS Kd_Rek_1,
//				0 AS Kd_Rek_2,
//				0 AS Kd_Rek_3,
//				0 AS Kd_Rek_4,
//				0 AS Kd_Rek_5,
//				A.Uraian,
//				0 AS Debet,
//				A.Nilai AS Kredit
//			FROM
//				Ta_Mutasi_Kas A
//			WHERE
//				( A.Tgl_Bukti <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND A.Kd_Mutasi = 1
//			GROUP BY
//				A.Tgl_Bukti,
//				A.No_Bukti,
//				A.Uraian,
//				A.Kd_Mutasi,
//				A.Nilai
//		")
//			->result();
//
//		$bku								        = $this->query
//		("
//			SELECT
//				A.Tgl_Bukti,
//				'2' AS Kode_P,
//				15 AS Kd_Trans1,
//				1 AS Kd_Trans2,
//				A.No_Bukti AS No_Bukti1,
//				A.No_Bukti,
//				0 AS Kd_Rek_1,
//				0 AS Kd_Rek_2,
//				0 AS Kd_Rek_3,
//				0 AS Kd_Rek_4,
//				0 AS Kd_Rek_5,
//				A.Uraian,
//				A.Nilai AS Debet,
//				0 AS Kredit
//			FROM
//				Ta_Mutasi_Kas A
//			WHERE
//				( A.Tgl_Bukti <= '$d2' )
//				AND ( A.Tahun = '$tahun' )
//				AND ( A.Kd_Urusan LIKE '$kd_urusan' )
//				AND ( A.Kd_Bidang LIKE '$kd_bidang' )
//				AND ( A.Kd_Unit LIKE '$kd_unit' )
//				AND ( A.Kd_Sub LIKE '$kd_sub' )
//				AND A.Kd_Mutasi = 2
//			GROUP BY
//				A.Tgl_Bukti,
//				A.No_Bukti,
//				A.Uraian,
//				A.Kd_Mutasi,
//				A.Nilai
//		")
//			->result();

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
				A.Tanggal,
				A.Kode,
				A.No_Bukti,
			CASE
					A.Kd_Rek_1 
					WHEN 0 THEN
					'' ELSE CONVERT ( VARCHAR, A.Kd_Rek_1 ) + '.' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + '.' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) 
				END AS Kd_Rek_5_Gab,
				A.Nm_Rek_5,
				A.Debet,
				A.Kredit,
				A.Saldo,
				A.Saldo_Tunai,
				A.Saldo_Bank,
				B.Nm_Pimpinan,
				B.Nip_Pimpinan,
				B.Jbt_Pimpinan,
				B.Nm_Bendahara,
				B.Nip_Bendahara,
				B.Jbt_Bendahara 
			FROM
				(
				SELECT
					'$d1' - 1 AS Tanggal,
					1 AS Kode,
					0 AS Kd_Trans1,
					0 AS Kd_Trans2,
					'' AS No_Bukti1,
					'' AS No_Bukti,
					0 AS Kd_Rek_1,
					0 AS Kd_Rek_2,
					0 AS Kd_Rek_3,
					0 AS Kd_Rek_4,
					0 AS Kd_Rek_5,
					'Saldo Awal' AS Nm_Rek_5,
					SUM ( Debet ) AS Debet,
					SUM ( Kredit ) AS Kredit,
					SUM ( Debet - Kredit ) AS Saldo,
					SUM ( CASE Kd_Pembayaran WHEN 1 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Tunai,
					SUM ( CASE Kd_Pembayaran WHEN 2 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Bank 
				FROM
					(
					SELECT
					CASE
						WHEN
							( A.Kd_Rek_5 = 1 ) THEN
								2 ELSE 1 
								END AS Kd_Pembayaran,
						CASE
								D_K 
								WHEN 'D' THEN
								Saldo ELSE 0 
							END AS Debet,
						CASE
								D_K 
								WHEN 'K' THEN
								Saldo ELSE 0 
							END AS Kredit 
						FROM
							Ta_Saldo_Awal A 
						WHERE
							( A.Tahun = '$tahun' - 1 ) 
							AND (
								( Kd_Rek_1 = 1 ) 
								AND ( Kd_Rek_2 = 1 ) 
								AND ( Kd_Rek_3 = 1 ) 
								AND ( Kd_Rek_4 = 3 ) 
								AND ( Kd_Rek_5 = 1 ) 
							) 
							AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
							AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
							AND ( A.Kd_Unit LIKE '$kd_unit' ) 
							AND ( A.Kd_Sub LIKE '$kd_sub' ) UNION ALL
						SELECT
							2,
							0,
							0 UNION ALL
						SELECT
							Kd_Pembayaran,
							SUM ( Debet ) AS Debet,
							SUM ( Kredit ) AS Kredit 
						FROM
							($bku) AS Xl
						WHERE
							Tanggal < '$d1' 
						GROUP BY
							Kd_Pembayaran 
						) A UNION ALL
					SELECT
						A.Tanggal,
						2 AS Kode,
						A.Kd_Trans1,
						A.Kd_Trans2,
						A.No_Bukti1,
						A.No_Bukti,
						A.Kd_Rek_1,
						A.Kd_Rek_2,
						A.Kd_Rek_3,
						A.Kd_Rek_4,
						A.Kd_Rek_5,
						A.Nm_Rek_5,
						SUM ( Debet ) AS Debet,
						SUM ( Kredit ) AS Kredit,
						SUM ( Debet - Kredit ) AS Saldo,
						SUM ( CASE Kd_Pembayaran WHEN 1 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Tunai,
						SUM ( CASE Kd_Pembayaran WHEN 2 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Bank 
					FROM
						($bku) AS A 
					WHERE
						Tanggal BETWEEN '$d1' 
						AND '$d2' 
					GROUP BY
						A.Tanggal,
						A.Kd_Trans1,
						A.Kd_Trans2,
						A.No_Bukti1,
						A.No_Bukti,
						A.Kd_Rek_1,
						A.Kd_Rek_2,
						A.Kd_Rek_3,
						A.Kd_Rek_4,
						A.Kd_Rek_5,
						A.Nm_Rek_5 
					) A,
					(
					SELECT
						'$kd_urusan' AS Kd_UrusanA,
						'$kd_bidang' AS Kd_BidangA,
						'$kd_unit' AS Kd_UnitA,
						'$kd_sub' AS Kd_SubA,
						'$kd_urusan' AS Kd_Urusan_Gab,
						'$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
						'$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) AS Kd_Unit_Gab,
						'$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' + '$kd_sub', 2 ) AS Kd_Sub_Gab,
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
						INNER JOIN Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan 
						AND A.Kd_Bidang = B.Kd_Bidang 
						AND A.Kd_Unit = B.Kd_Unit 
						AND A.Kd_Sub = B.Kd_Sub
						INNER JOIN Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan 
						AND B.Kd_Bidang = C.Kd_Bidang 
						AND B.Kd_Unit = C.Kd_Unit
						INNER JOIN Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan 
						AND C.Kd_Bidang = D.Kd_Bidang
						INNER JOIN Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
						INNER JOIN (
						SELECT TOP
							1 Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub 
						FROM
							Ta_Sub_Unit A 
						WHERE
							( A.Tahun = '$tahun' ) 
							AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
							AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
							AND ( A.Kd_Unit LIKE '$kd_unit' ) 
							AND ( A.Kd_Sub LIKE '$kd_sub' ) 
						ORDER BY
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub 
						) F ON A.Tahun = F.Tahun 
						AND A.Kd_Urusan = F.Kd_Urusan 
						AND A.Kd_Bidang = F.Kd_Bidang 
						AND A.Kd_Unit = F.Kd_Unit 
						AND A.Kd_Sub = F.Kd_Sub
						LEFT OUTER JOIN (
						SELECT
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub,
							MIN ( Nama ) AS Nm_Bendahara,
							MIN ( Nip ) AS Nip_Bendahara,
							MIN ( Jabatan ) AS Jbt_Bendahara 
						FROM
							Ta_Sub_Unit_Jab A 
						WHERE
							( A.Kd_Jab = 4 ) 
							AND ( A.Tahun = '$tahun' ) 
							AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
							AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
							AND ( A.Kd_Unit LIKE '$kd_unit' ) 
							AND ( A.Kd_Sub LIKE '$kd_sub' ) 
						GROUP BY
							Tahun,
							Kd_Urusan,
							Kd_Bidang,
							Kd_Unit,
							Kd_Sub 
						) G ON F.Tahun = G.Tahun 
						AND F.Kd_Urusan = G.Kd_Urusan 
						AND F.Kd_Bidang = G.Kd_Bidang 
						AND F.Kd_Unit = G.Kd_Unit 
						AND F.Kd_Sub = G.Kd_Sub 
					) B 
				ORDER BY
					A.Kode,
					A.Tanggal,
					A.Kd_Trans1,
					A.No_Bukti1,
					A.Kd_Trans2,
					A.No_Bukti,
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
				A.Kd_Rek_4,
				A.Kd_Rek_5
		")
			->result();

		var_dump($data_query);die;

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	// lewat query
	public function bku_pembantu_kas_tunai($params)
	{
		var_dump($params);die;
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$bku								        = $this->query
		("
			
		")
			->result();

		$data_query								    = $this->query
		("
			
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	// lewat query
	public function bku_pembantu_belanja_ls($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan									= $params['kd_urusan'];
		$kd_bidang									= $params['kd_bidang'];
		$kd_unit									= $params['kd_unit'];
		$kd_sub										= $params['kd_sub'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
		$d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

		$bku1								        =
		("
			SELECT
				A.Tgl_SP2D AS Tgl_Bukti,
				'2' AS Kode_P,
				1 AS Kd_Trans1,
				1 AS Kd_Trans2,
				A.No_SP2D AS No_Bukti1,
				A.No_SP2D AS No_Bukti,
				0 AS Kd_Rek_1,
				0 AS Kd_Rek_2,
				0 AS Kd_Rek_3,
				0 AS Kd_Rek_4,
				0 AS Kd_Rek_5,
				A.Keterangan AS Nm_Rek_5,
				SUM ( C.Nilai ) AS Debet,
				0 AS Kredit 
			FROM
				Ta_SP2D A
				INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
				AND A.No_SPM = B.No_SPM
				INNER JOIN Ta_SPM_Rinc C ON B.Tahun = C.Tahun 
				AND B.No_SPM = C.No_SPM 
			WHERE
				( B.Kd_Edit = 1 ) 
				AND ( B.Jn_SPM = 3 ) 
				AND ( A.Tgl_SP2D <= '$d2' ) 
				AND ( B.Tahun = '$tahun' ) 
				AND ( B.Kd_Urusan LIKE '$kd_urusan' ) 
				AND ( B.Kd_Bidang LIKE '$kd_bidang' ) 
				AND ( B.Kd_Unit LIKE '$kd_unit' ) 
				AND ( B.Kd_Sub LIKE '$kd_sub' ) 
			GROUP BY
				A.Tgl_SP2D,
				A.No_SP2D,
				A.Keterangan	
		");

		$bku2								        =
		("
			SELECT
				A.Tgl_SP2D AS Tgl_Bukti,
				'2' AS Kode_P,
				1 AS Kd_Trans1,
				2 AS Kd_Trans2,
				A.No_SP2D AS No_Bukti1,
				A.No_SP2D AS No_Bukti,
				C.Kd_Rek_1,
				C.Kd_Rek_2,
				C.Kd_Rek_3,
				C.Kd_Rek_4,
				C.Kd_Rek_5,
				D.Nm_Rek_5,
				0 AS Debet,
				SUM ( C.Nilai ) AS Kredit 
			FROM
				Ta_SP2D A
				INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
				AND A.No_SPM = B.No_SPM
				INNER JOIN Ta_SPM_Rinc C ON B.Tahun = C.Tahun 
				AND B.No_SPM = C.No_SPM
				INNER JOIN Ref_Rek_5 D ON C.Kd_Rek_1 = D.Kd_Rek_1 
				AND C.Kd_Rek_2 = D.Kd_Rek_2 
				AND C.Kd_Rek_3 = D.Kd_Rek_3 
				AND C.Kd_Rek_4 = D.Kd_Rek_4 
				AND C.Kd_Rek_5 = D.Kd_Rek_5 
			WHERE
				( B.Kd_Edit = 1 ) 
				AND ( B.Jn_SPM = 3 ) 
				AND ( A.Tgl_SP2D <= '$d2' ) 
				AND ( B.Tahun = '$tahun' ) 
				AND ( B.Kd_Urusan LIKE '$kd_urusan' ) 
				AND ( B.Kd_Bidang LIKE '$kd_bidang' ) 
				AND ( B.Kd_Unit LIKE '$kd_unit' ) 
				AND ( B.Kd_Sub LIKE '$kd_sub' ) 
			GROUP BY
				A.Tgl_SP2D,
				A.No_SP2D,
				C.Kd_Rek_1,
				C.Kd_Rek_2,
				C.Kd_Rek_3,
				C.Kd_Rek_4,
				C.Kd_Rek_5,
				D.Nm_Rek_5
		");

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
				A.Tanggal,
				A.Kode,
				A.No_Bukti,
			CASE
					A.Kd_Rek_1 
					WHEN 0 THEN
					'' ELSE CONVERT ( VARCHAR, A.Kd_Rek_1 ) + '.' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + '.' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) 
				END AS Kd_Rek_5_Gab,
				A.Nm_Rek_5,
				A.Debet,
				A.Kredit,
				A.Saldo,
				A.Saldo_Tunai,
				A.Saldo_Bank,
				B.Nm_Pimpinan,
				B.Nip_Pimpinan,
				B.Jbt_Pimpinan,
				B.Nm_Bendahara,
				B.Nip_Bendahara,
				B.Jbt_Bendahara 
			FROM
				(
				SELECT
					'$d1' - 1 AS Tanggal,
					1 AS Kode,
					0 AS Kd_Trans1,
					0 AS Kd_Trans2,
					'' AS No_Bukti1,
					'' AS No_Bukti,
					0 AS Kd_Rek_1,
					0 AS Kd_Rek_2,
					0 AS Kd_Rek_3,
					0 AS Kd_Rek_4,
					0 AS Kd_Rek_5,
					'Saldo Awal' AS Nm_Rek_5,
					SUM ( Debet ) AS Debet,
					SUM ( Kredit ) AS Kredit,
					SUM ( Debet - Kredit ) AS Saldo,
					SUM ( CASE Kd_Pembayaran WHEN 1 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Tunai,
					SUM ( CASE Kd_Pembayaran WHEN 2 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Bank 
				FROM
					( SELECT Kode_P AS Kd_Pembayaran, Tgl_Bukti AS Tanggal, SUM ( Debet ) AS Debet, SUM ( Kredit ) AS Kredit FROM ($bku1) AS Xl WHERE Tgl_Bukti < '$d1' GROUP BY Kode_P ) A UNION ALL
				SELECT
					A.Tanggal,
					2 AS Kode,
					A.Kd_Trans1,
					A.Kd_Trans2,
					A.No_Bukti1,
					A.No_Bukti,
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
					A.Kd_Rek_4,
					A.Kd_Rek_5,
					A.Nm_Rek_5,
					SUM ( Debet ) AS Debet,
					SUM ( Kredit ) AS Kredit,
					SUM ( Debet - Kredit ) AS Saldo,
					SUM ( CASE Kd_Pembayaran WHEN 1 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Tunai,
					SUM ( CASE Kd_Pembayaran WHEN 2 THEN Debet - Kredit ELSE 0 END ) AS Saldo_Bank 
				FROM
					($bku2) AS A 
				WHERE
					Tanggal BETWEEN '$d1' 
					AND '$d2' 
				GROUP BY
					A.Tanggal,
					A.Kd_Trans1,
					A.Kd_Trans2,
					A.No_Bukti1,
					A.No_Bukti,
					A.Kd_Rek_1,
					A.Kd_Rek_2,
					A.Kd_Rek_3,
					A.Kd_Rek_4,
					A.Kd_Rek_5,
					A.Nm_Rek_5 
				) A,
				(
				SELECT
					'$kd_urusan' AS Kd_UrusanA,
					'$kd_bidang' AS Kd_BidangA,
					'$kd_unit' AS Kd_UnitA,
					'$kd_sub' AS Kd_SubA,
					'$kd_urusan' AS Kd_Urusan_Gab,
					'$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
					'$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) AS Kd_Unit_Gab,
					'$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' + '$kd_sub', 2 ) AS Kd_Sub_Gab,
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
					INNER JOIN Ref_Sub_Unit B ON A.Kd_Urusan = B.Kd_Urusan 
					AND A.Kd_Bidang = B.Kd_Bidang 
					AND A.Kd_Unit = B.Kd_Unit 
					AND A.Kd_Sub = B.Kd_Sub
					INNER JOIN Ref_Unit C ON B.Kd_Urusan = C.Kd_Urusan 
					AND B.Kd_Bidang = C.Kd_Bidang 
					AND B.Kd_Unit = C.Kd_Unit
					INNER JOIN Ref_Bidang D ON C.Kd_Urusan = D.Kd_Urusan 
					AND C.Kd_Bidang = D.Kd_Bidang
					INNER JOIN Ref_Urusan E ON D.Kd_Urusan = E.Kd_Urusan
					INNER JOIN (
					SELECT TOP
						1 Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub 
					FROM
						Ta_Sub_Unit A 
					WHERE
						( A.Tahun = '$tahun' ) 
						AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
						AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
						AND ( A.Kd_Unit LIKE '$kd_unit' ) 
						AND ( A.Kd_Sub LIKE '$kd_sub' ) 
					ORDER BY
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub 
					) F ON A.Tahun = F.Tahun 
					AND A.Kd_Urusan = F.Kd_Urusan 
					AND A.Kd_Bidang = F.Kd_Bidang 
					AND A.Kd_Unit = F.Kd_Unit 
					AND A.Kd_Sub = F.Kd_Sub
					LEFT OUTER JOIN (
					SELECT
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub,
						MIN ( Nama ) AS Nm_Bendahara,
						MIN ( Nip ) AS Nip_Bendahara,
						MIN ( Jabatan ) AS Jbt_Bendahara 
					FROM
						Ta_Sub_Unit_Jab A 
					WHERE
						( A.Kd_Jab = 4 ) 
						AND ( A.Tahun = '$tahun' ) 
						AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
						AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
						AND ( A.Kd_Unit LIKE '$kd_unit' ) 
						AND ( A.Kd_Sub LIKE '$kd_sub' ) 
					GROUP BY
						Tahun,
						Kd_Urusan,
						Kd_Bidang,
						Kd_Unit,
						Kd_Sub 
					) G ON F.Tahun = G.Tahun 
					AND F.Kd_Urusan = G.Kd_Urusan 
					AND F.Kd_Bidang = G.Kd_Bidang 
					AND F.Kd_Unit = G.Kd_Unit 
					AND F.Kd_Sub = G.Kd_Sub 
				) B 
			ORDER BY
				A.Kode,
				A.Tanggal,
				A.Kd_Trans1,
				A.No_Bukti1,
				A.Kd_Trans2,
				A.No_Bukti,
				A.Kd_Rek_1,
				A.Kd_Rek_2,
				A.Kd_Rek_3,
				A.Kd_Rek_4,
				A.Kd_Rek_5
		")
			->result();

		var_dump($data_query);die;

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

	public function bku_pengeluaran_belanja($params)
	{
		var_dump($params);die;
		$tahun                                      = $params['tahun'];
		$no_spj                                     = $params['no_spj'];

		$data_query								    = $this->query
		("
			
		")
			->result();

		var_dump($data_query);die;

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);
		return $output;
	}

}
