<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Penerimaan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Dokumen_kendali extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Dokumen Kendali
	 */
	public function kartu_kendali($params)
	{
		$tahun                                      = $params['tahun'];
		$kd_urusan                                  = $params['kd_urusan'];
		$kd_bidang                                  = $params['kd_bidang'];
		$kd_unit                                    = $params['kd_unit'];
		$kd_sub                                     = $params['kd_sub'];
		$kd_prog                                    = $params['kd_prog'];
		$id_prog                                    = $params['id_prog'];
		$kd_keg                                     = $params['kd_keg'];
		$d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

		$tmpKendali								    =
		("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                SUM ( A.Total ) AS Anggaran,
                0 AS UP,
                0 AS LS 
            FROM
                Ta_RASK_Arsip A 
            WHERE
                ( A.Tahun = '$tahun' ) 
                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                AND ( A.ID_Prog LIKE '$id_prog' ) 
                AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                AND ( A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d1' ) ) 
                AND ( A.Kd_Prog <> 0 ) 
                AND ( A.Kd_Keg <> 0 ) 
            GROUP BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		");

		$data_query								    = $this->query
		("
			SELECT
                D.Kd_UrusanA,
                D.Kd_BidangA,
                D.Kd_UnitA,
                D.Kd_SubA,
                C.Kd_ProgA,
                C.Kd_KegA,
                D.Kd_Urusan_Gab,
                D.Kd_Bidang_Gab,
                D.Kd_Unit_Gab,
                D.Kd_Sub_Gab,
                C.Kd_Prog_Gab,
                C.Kd_Keg_Gab,
                D.Nm_Urusan_Gab,
                D.Nm_Bidang_Gab,
                D.Nm_Unit_Gab,
                D.Nm_Sub_Unit_Gab,
                C.Ket_Program_Gab,
                C.Ket_Kegiatan_Gab,
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Kd_Rek_5_Gab,
                B.Nm_Rek_5,
                A.Anggaran,
                A.UP,
                A.LS,
                A.Anggaran - ( A.UP + A.LS ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.UP ) AS UP,
                    SUM ( A.LS ) AS LS 
                FROM
                    ( $tmpKendali ) AS A 
                GROUP BY
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5 
                ) A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    1 AS Kode,
                    '$kd_prog' AS Kd_ProgA,
                    '$kd_keg' AS Kd_KegA,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' + '$kd_sub', 2 ) + ' . ' +
                CASE
                        LEN( '$kd_prog' ) 
                        WHEN 3 THEN
                        '$kd_prog' ELSE RIGHT ( '0' + '$kd_prog', 2 ) 
                    END AS Kd_Prog_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' + '$kd_sub', 2 ) + ' . ' +
                CASE
                        LEN( '$kd_prog' ) 
                        WHEN 3 THEN
                        '$kd_prog' ELSE RIGHT ( '0' + '$kd_prog', 2 ) 
                    END + ' . ' +
            CASE
                LEN( '$kd_keg' ) 
                WHEN 3 THEN
                '$kd_keg' ELSE RIGHT ( '0' + '$kd_keg', 2 ) 
                END AS Kd_Keg_Gab,
                C.Ket_Program AS Ket_Program_Gab,
                B.Ket_Kegiatan AS Ket_Kegiatan_Gab,
                B.Lokasi,
                B.Kelompok_Sasaran 
            FROM
                Ta_Kegiatan B
                INNER JOIN Ta_Program C ON B.Tahun = C.Tahun 
                AND B.Kd_Urusan = C.Kd_Urusan 
                AND B.Kd_Bidang = C.Kd_Bidang 
                AND B.Kd_Unit = C.Kd_Unit 
                AND B.Kd_Sub = C.Kd_Sub 
                AND B.Kd_Prog = C.Kd_Prog 
                AND B.ID_Prog = C.ID_Prog
                INNER JOIN (
                SELECT TOP
                    1 Tahun,
                    Kd_Urusan,
                    Kd_Bidang,
                    Kd_Unit,
                    Kd_Sub,
                    Kd_Prog,
                    ID_Prog,
                    Kd_Keg 
                FROM
                    Ta_Kegiatan A 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                    AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                    AND ( A.ID_Prog LIKE '$id_prog' ) 
                    AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                ORDER BY
                    Tahun,
                    Kd_Urusan,
                    Kd_Bidang,
                    Kd_Unit,
                    Kd_Sub,
                    Kd_Prog,
                    ID_Prog,
                    Kd_Keg 
                ) D ON B.Tahun = D.Tahun 
                AND B.Kd_Urusan = D.Kd_Urusan 
                AND B.Kd_Bidang = D.Kd_Bidang 
                AND B.Kd_Unit = D.Kd_Unit 
                AND B.Kd_Sub = D.Kd_Sub 
                AND B.Kd_Prog = D.Kd_Prog 
                AND B.ID_Prog = D.ID_Prog 
                AND B.Kd_Keg = D.Kd_Keg 
                ) C,
                (
                SELECT
                    1 AS Kode,
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
                    A.Jbt_Pimpinan AS Jbt_Pimpinan 
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
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		")
			->result();

		$output										= array
		(
			'data_query'							=> $data_query,
			'tanggal'								=> $params['tahun']
		);

		return $output;
	}

    public function kartu_kendali_btl($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $tmpKendali								    =
        ("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                SUM ( A.Total ) AS Anggaran,
                0 AS UP,
                0 AS LS
            FROM
                Ta_RASK_Arsip A 
            WHERE
                ( A.Tahun = '$tahun' ) 
                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                AND (
                    A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d1' ) 
                ) 
                AND ( A.Kd_Prog = 0 ) 
                AND ( A.Kd_Keg = 0 ) 
                AND ( A.Kd_Rek_1 = 5 ) 
            GROUP BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		");

        $data_query								    = $this->query
        ("
			SELECT
                D.Kd_UrusanA,
                D.Kd_BidangA,
                D.Kd_UnitA,
                D.Kd_SubA,
                D.Kd_Urusan_Gab,
                D.Kd_Bidang_Gab,
                D.Kd_Unit_Gab,
                D.Kd_Sub_Gab,
                D.Nm_Urusan_Gab,
                D.Nm_Bidang_Gab,
                D.Nm_Unit_Gab,
                D.Nm_Sub_Unit_Gab,
                A.Kd_Rek_5_Gab,
                B.Nm_Rek_5,
                A.Anggaran,
                A.UP,
                A.LS,
                A.Anggaran - ( A.UP + A.LS ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.UP ) AS UP,
                    SUM ( A.LS ) AS LS 
                FROM
                    ($tmpKendali) AS A 
                GROUP BY
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5 
                ) A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    1 AS Kode, '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                    '$kd_urusan' AS Kd_Urusan_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
                    E.Nm_Urusan AS Nm_Urusan_Gab,
                    D.Nm_Bidang AS Nm_Bidang_Gab,
                    C.Nm_Unit AS Nm_Unit_Gab,
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                    A.Nm_Pimpinan AS Nm_Pimpinan,
                    A.Nip_Pimpinan AS Nip_Pimpinan,
                    A.Jbt_Pimpinan AS Jbt_Pimpinan 
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
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function kartu_kendali_pembiayaan($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $tmpKendali								    =
        ("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                SUM ( A.Total ) AS Anggaran,
                0 AS UP,
                0 AS LS
            FROM
                Ta_RASK_Arsip A 
            WHERE
                ( A.Tahun = '$tahun' ) 
                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                AND (
                    A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d1' ) 
                ) 
                AND ( A.Kd_Rek_1 = 6 ) 
                AND ( A.Kd_Rek_2 = 2 ) 
            GROUP BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		");

        $data_query								    = $this->query
        ("
			SELECT
                D.Kd_UrusanA,
                D.Kd_BidangA,
                D.Kd_UnitA,
                D.Kd_SubA,
                D.Kd_Urusan_Gab,
                D.Kd_Bidang_Gab,
                D.Kd_Unit_Gab,
                D.Kd_Sub_Gab,
                D.Nm_Urusan_Gab,
                D.Nm_Bidang_Gab,
                D.Nm_Unit_Gab,
                D.Nm_Sub_Unit_Gab,
                A.Kd_Rek_5_Gab,
                B.Nm_Rek_5,
                A.Anggaran,
                A.UP,
                A.LS,
                A.Anggaran - ( A.UP + A.LS ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.UP ) AS UP,
                    SUM ( A.LS ) AS LS 
                FROM
                    ($tmpKendali) AS A 
                GROUP BY
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5 
                ) A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    1 AS Kode, '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                    '$kd_urusan' AS Kd_Urusan_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
                    E.Nm_Urusan AS Nm_Urusan_Gab,
                    D.Nm_Bidang AS Nm_Bidang_Gab,
                    C.Nm_Unit AS Nm_Unit_Gab,
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                    A.Nm_Pimpinan AS Nm_Pimpinan,
                    A.Nip_Pimpinan AS Nip_Pimpinan,
                    A.Jbt_Pimpinan AS Jbt_Pimpinan 
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
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function rincian_kartu_kendali_kegiatan($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $kd_prog                                    = $params['kd_prog'];
        $id_prog                                    = $params['id_prog'];
        $kd_keg                                     = $params['kd_keg'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $tmpKendali								    =
        ("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                NULL AS Tgl_SP2D,
                NULL AS No_SP2D,
                NULL AS Keterangan,
                SUM ( A.Total ) AS Anggaran,
                0 AS Pergeseran,
                0 AS UP,
                0 AS LS
            FROM
                Ta_RASK_Arsip A 
            WHERE
                ( A.Tahun = '$tahun' ) 
                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                AND ( A.Id_Prog LIKE '$id_prog' ) 
                AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                AND (
                    A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$d1' AND Kd_Perubahan IN ( 4, 6, 8 ) ) 
                ) 
                AND NOT ( A.Kd_Prog = 0 AND A.Kd_Keg = 0 AND A.Kd_Rek_1 = 5 AND A.Kd_Rek_2 = 1 AND A.Kd_Rek_3 = 1 ) 
                AND ( A.Kd_Rek_1 = 5 ) 
            GROUP BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		");

        $data_query								    = $this->query
        ("
			SELECT
                D.Kd_UrusanA,
                D.Kd_BidangA,
                D.Kd_UnitA,
                D.Kd_SubA,
                C.Kd_ProgA,
                C.Kd_KegA,
                D.Kd_Bidang_Gab,
                D.Kd_Unit_Gab,
                D.Kd_Sub_Gab,
                C.Kd_Prog_Gab,
                C.Kd_Keg_Gab,
                D.Nm_Bidang_Gab,
                D.Nm_Unit_Gab,
                D.Nm_Sub_Unit_Gab,
                C.Ket_Program_Gab,
                C.Ket_Kegiatan_Gab,
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Kd_Rek_5_Gab,
                B.Nm_Rek_5,
                A.Tgl_SP2D,
                A.No_SP2D,
                A.Keterangan,
                A.Anggaran,
                A.Pergeseran,
                A.UP,
                A.LS,
                A.Anggaran - ( A.UP + A.LS ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan,
                ISNULL(
                    (
                    SELECT MAX
                        ( Kd_Perubahan ) 
                    FROM
                        Ta_RASK_Arsip_Perubahan 
                    WHERE
                        Tahun = '$tahun' 
                        AND Kd_Perubahan IN ( 5, 7 ) 
                        AND Tgl_Perda <= '$d1' 
                        AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d1' ) 
                    ),
                    0 
                ) AS Kd_Geser 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    A.Tgl_SP2D,
                    A.No_SP2D,
                    A.Keterangan,
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.Pergeseran ) AS Pergeseran,
                    SUM ( A.UP ) AS UP,
                    SUM ( A.LS ) AS LS 
                FROM
                    ($tmpKendali) AS A 
                GROUP BY
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    A.Tgl_SP2D,
                    A.No_SP2D,
                    A.Keterangan 
                ) A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    1 AS Kode, '$kd_prog' AS Kd_ProgA, '$kd_keg' AS Kd_KegA, 
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) + ' . ' +
                CASE
                        LEN( '$kd_prog' ) 
                        WHEN 3 THEN
                        '$kd_prog' ELSE RIGHT ( '0' +  '$kd_prog', 2 ) 
                    END AS Kd_Prog_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) + ' . ' +
                CASE
                        LEN( '$kd_prog' ) 
                        WHEN 3 THEN
                        '$kd_prog' ELSE RIGHT ( '0' +  '$kd_prog', 2 ) 
                    END + ' . ' +
            CASE
                LEN( '$kd_keg' ) 
                WHEN 3 THEN
                '$kd_keg' ELSE RIGHT ( '0' +  '$kd_keg', 2 ) 
                END AS Kd_Keg_Gab,
                C.Ket_Program AS Ket_Program_Gab,
                B.Ket_Kegiatan AS Ket_Kegiatan_Gab,
                B.Lokasi,
                B.Kelompok_Sasaran 
            FROM
                Ta_Kegiatan B
                INNER JOIN Ta_Program C ON B.Tahun = C.Tahun 
                AND B.Kd_Urusan = C.Kd_Urusan 
                AND B.Kd_Bidang = C.Kd_Bidang 
                AND B.Kd_Unit = C.Kd_Unit 
                AND B.Kd_Sub = C.Kd_Sub 
                AND B.Kd_Prog = C.Kd_Prog 
                AND B.Id_Prog = C.Id_Prog
                INNER JOIN (
                SELECT TOP
                    1 Tahun,
                    Kd_Urusan,
                    Kd_Bidang,
                    Kd_Unit,
                    Kd_Sub,
                    Kd_Prog,
                    Id_Prog,
                    Kd_Keg 
                FROM
                    Ta_Kegiatan A 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                    AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                    AND ( A.Id_Prog LIKE '$id_prog' ) 
                    AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                ORDER BY
                    Tahun,
                    Kd_Urusan,
                    Kd_Bidang,
                    Kd_Unit,
                    Kd_Sub,
                    Kd_Prog,
                    Id_Prog,
                    Kd_Keg 
                ) D ON B.Tahun = D.Tahun 
                AND B.Kd_Urusan = D.Kd_Urusan 
                AND B.Kd_Bidang = D.Kd_Bidang 
                AND B.Kd_Unit = D.Kd_Unit 
                AND B.Kd_Sub = D.Kd_Sub 
                AND B.Kd_Prog = D.Kd_Prog 
                AND B.Id_Prog = D.Id_Prog 
                AND B.Kd_Keg = D.Kd_Keg 
                ) C,
                (
                SELECT
                    1 AS Kode, '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
                    E.Nm_Urusan + ' ' + D.Nm_Bidang AS Nm_Bidang_Gab,
                    C.Nm_Unit AS Nm_Unit_Gab,
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                    A.Nm_Pimpinan AS Nm_Pimpinan,
                    A.Nip_Pimpinan AS Nip_Pimpinan,
                    A.Jbt_Pimpinan AS Jbt_Pimpinan 
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
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Tgl_SP2D,
                A.No_SP2D
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function rincian_kartu_kendali_btl($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $tmpKendali								    =
        ("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                NULL AS Tgl_SP2D,
                NULL AS No_SP2D,
                NULL AS Keterangan,
                SUM ( A.Total ) AS Anggaran,
                0 AS Pergeseran,
                0 AS UP,
                0 AS LS
            FROM
                Ta_RASK_Arsip A 
            WHERE
                ( A.Tahun = '$tahun' ) 
                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                AND (
                    A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$d1' AND Kd_Perubahan IN ( 4, 6, 8 ) ) 
                ) 
                AND ( A.Kd_Prog = 0 ) 
                AND ( A.Kd_Keg = 0 ) 
                AND ( A.Kd_Rek_1 = 5 ) 
            GROUP BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		");

        $data_query								    = $this->query
        ("
            SELECT
                D.Kd_UrusanA,
                D.Kd_BidangA,
                D.Kd_UnitA,
                D.Kd_SubA,
                D.Kd_Bidang_Gab,
                D.Kd_Unit_Gab,
                D.Kd_Sub_Gab,
                D.Nm_Bidang_Gab,
                D.Nm_Unit_Gab,
                D.Nm_Sub_Unit_Gab,
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Kd_Rek_5_Gab,
                B.Nm_Rek_5,
                A.Tgl_SP2D,
                A.No_SP2D,
                A.Keterangan,
                A.Anggaran,
                A.Pergeseran,
                A.UP,
                A.LS,
                A.Anggaran - ( A.UP + A.LS ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan,
                D.Nm_Bendahara,
                D.Nip_Bendahara,
                D.Jbt_Bendahara,
                ISNULL(
                    (
                    SELECT MAX
                        ( Kd_Perubahan ) 
                    FROM
                        Ta_RASK_Arsip_Perubahan 
                    WHERE
                        Tahun = '$tahun' 
                        AND Kd_Perubahan IN ( 5, 7 ) 
                        AND Tgl_Perda <= '$d1' 
                        AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d1' ) 
                    ),
                    0 
                ) AS Kd_Geser 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    A.Tgl_SP2D,
                    A.No_SP2D,
                    A.Keterangan,
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.Pergeseran ) AS Pergeseran,
                    SUM ( A.UP ) AS UP,
                    SUM ( A.LS ) AS LS 
                FROM
                    ($tmpKendali) AS A 
                GROUP BY
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    A.Tgl_SP2D,
                    A.No_SP2D,
                    A.Keterangan 
                ) A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    1 AS Kode, '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
                    E.Nm_Urusan + ' ' + D.Nm_Bidang AS Nm_Bidang_Gab,
                    C.Nm_Unit AS Nm_Unit_Gab,
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                    A.Nm_Pimpinan AS Nm_Pimpinan,
                    A.Nip_Pimpinan AS Nip_Pimpinan,
                    A.Jbt_Pimpinan AS Jbt_Pimpinan,
                    H.Nm_Bendahara,
                    H.Nip_Bendahara,
                    H.Jbt_Bendahara 
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
                        INNER JOIN (
                        SELECT
                            Tahun,
                            Kd_Urusan,
                            Kd_Bidang,
                            Kd_Unit,
                            Kd_Sub,
                            Kd_Jab,
                            MIN ( No_Urut ) AS No_Urut 
                        FROM
                            Ta_Sub_Unit_Jab 
                        GROUP BY
                            Tahun,
                            Kd_Urusan,
                            Kd_Bidang,
                            Kd_Unit,
                            Kd_Sub,
                            Kd_Jab 
                        ) B ON A.Tahun = B.Tahun 
                        AND A.Kd_Urusan = B.Kd_Urusan 
                        AND A.Kd_Bidang = B.Kd_Bidang 
                        AND A.Kd_Unit = B.Kd_Unit 
                        AND A.Kd_Sub = B.Kd_Sub 
                        AND A.Kd_Jab = B.Kd_Jab 
                        AND A.No_Urut = B.No_Urut 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Jab = 4 ) 
                    ) H ON A.Tahun = H.Tahun 
                    AND A.Kd_Urusan = H.Kd_Urusan 
                    AND A.Kd_Bidang = H.Kd_Bidang 
                    AND A.Kd_Unit = H.Kd_Unit 
                    AND A.Kd_Sub = H.Kd_Sub 
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Tgl_SP2D,
                A.No_SP2D
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function rincian_kartu_kendali_pembiayaan($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $tmpKendali								    =
        ("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                NULL AS Tgl_SP2D,
                NULL AS No_SP2D,
                NULL AS Keterangan,
                SUM ( A.Total ) AS Anggaran,
                0 AS Pergeseran,
                0 AS UP,
                0 AS LS
            FROM
                Ta_RASK_Arsip A 
            WHERE
                ( A.Tahun = '$tahun' ) 
                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                AND (
                    A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Tgl_Perda <= '$d1' AND Kd_Perubahan IN ( 4, 6, 8 ) ) 
                ) 
                AND ( A.Kd_Prog = 0 ) 
                AND ( A.Kd_Keg = 0 ) 
                AND ( A.Kd_Rek_1 = 6 ) 
                AND ( A.Kd_Rek_2 = 2 ) 
            GROUP BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		");

        $data_query								    = $this->query
        ("
			SELECT
                D.Kd_UrusanA,
                D.Kd_BidangA,
                D.Kd_UnitA,
                D.Kd_SubA,
                D.Kd_Bidang_Gab,
                D.Kd_Unit_Gab,
                D.Kd_Sub_Gab,
                D.Nm_Bidang_Gab,
                D.Nm_Unit_Gab,
                D.Nm_Sub_Unit_Gab,
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Kd_Rek_5_Gab,
                B.Nm_Rek_5,
                A.Tgl_SP2D,
                A.No_SP2D,
                A.Keterangan,
                A.Anggaran,
                A.Pergeseran,
                A.UP,
                A.LS,
                A.Anggaran - ( A.UP + A.LS ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan,
                D.Nm_Bendahara,
                D.Nip_Bendahara,
                D.Jbt_Bendahara,
                ISNULL(
                    (
                    SELECT MAX
                        ( Kd_Perubahan ) 
                    FROM
                        Ta_RASK_Arsip_Perubahan 
                    WHERE
                        Tahun = '$tahun' 
                        AND Kd_Perubahan IN ( 5, 7 ) 
                        AND Tgl_Perda <= '$d1' 
                        AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d1' ) 
                    ),
                    0 
                ) AS Kd_Geser 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    A.Tgl_SP2D,
                    A.No_SP2D,
                    A.Keterangan,
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.Pergeseran ) AS Pergeseran,
                    SUM ( A.UP ) AS UP,
                    SUM ( A.LS ) AS LS 
                FROM
                    ($tmpKendali) AS A 
                GROUP BY
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    A.Tgl_SP2D,
                    A.No_SP2D,
                    A.Keterangan 
                ) A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    1 AS Kode, '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
                    E.Nm_Urusan + ' ' + D.Nm_Bidang AS Nm_Bidang_Gab,
                    C.Nm_Unit AS Nm_Unit_Gab,
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab,
                    A.Nm_Pimpinan AS Nm_Pimpinan,
                    A.Nip_Pimpinan AS Nip_Pimpinan,
                    A.Jbt_Pimpinan AS Jbt_Pimpinan,
                    H.Nm_Bendahara,
                    H.Nip_Bendahara,
                    H.Jbt_Bendahara 
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
                        INNER JOIN (
                        SELECT
                            Tahun,
                            Kd_Urusan,
                            Kd_Bidang,
                            Kd_Unit,
                            Kd_Sub,
                            Kd_Jab,
                            MIN ( No_Urut ) AS No_Urut 
                        FROM
                            Ta_Sub_Unit_Jab 
                        GROUP BY
                            Tahun,
                            Kd_Urusan,
                            Kd_Bidang,
                            Kd_Unit,
                            Kd_Sub,
                            Kd_Jab 
                        ) B ON A.Tahun = B.Tahun 
                        AND A.Kd_Urusan = B.Kd_Urusan 
                        AND A.Kd_Bidang = B.Kd_Bidang 
                        AND A.Kd_Unit = B.Kd_Unit 
                        AND A.Kd_Sub = B.Kd_Sub 
                        AND A.Kd_Jab = B.Kd_Jab 
                        AND A.No_Urut = B.No_Urut 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Jab = 4 ) 
                    ) H ON A.Tahun = H.Tahun 
                    AND A.Kd_Urusan = H.Kd_Urusan 
                    AND A.Kd_Bidang = H.Kd_Bidang 
                    AND A.Kd_Unit = H.Kd_Unit 
                    AND A.Kd_Sub = H.Kd_Sub 
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Tgl_SP2D,
                A.No_SP2D
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function rekap_pengeluaran($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

        $query_covid								= $this->query
        ("
            SELECT
                Kd_Urusan
            FROM
                Ref_BLU
            WHERE 
                Jenis = 4
              AND Kd_Urusan = '$kd_urusan'
              AND Kd_Bidang = '$kd_bidang'
              AND Kd_Unit = '$kd_unit'
              AND Kd_Sub = '$kd_sub'
        ")
            ->row('Kd_Urusan');
        $covid                                      = $query_covid;

        $Peny_SPJ								    = $this->query
        ("
            SELECT 
                Peny_SPJ
            FROM 
                Ref_Setting
            WHERE
                Tahun = '$tahun'
		")
            ->row('Peny_SPJ');

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
                A.Kode,
                A.No_BKU,
                A.No_Bukti,
                A.Kd_Rek_5_Gab,
                A.Nm_Rek_5,
                A.Anggaran,
                A.Pergeseran,
                A.UP,
                A.LS,
                A.Jumlah,
                B.Nm_Pimpinan,
                B.Nip_Pimpinan,
                B.Jbt_Pimpinan,
                B.Nm_Bendahara,
                B.Nip_Bendahara,
                B.Jbt_Bendahara,
                ISNULL(
                    (
                    SELECT MAX
                        ( Kd_Perubahan ) 
                    FROM
                        Ta_RASK_Arsip_Perubahan 
                    WHERE
                        Tahun = '$tahun' 
                        AND Kd_Perubahan IN ( 5, 7 ) 
                        AND Tgl_Perda <= '$d2' 
                        AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d2' ) 
                    ),
                    0 
                ) AS Kd_Geser 
            FROM
                (
                SELECT
                    1 AS Kode,
                    '' AS No_BKU,
                    '' AS No_Bukti,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    B.Nm_Rek_5,
                    A.Anggaran,
                    A.Pergeseran,
                    A.UP,
                    A.LS,
                    A.Jumlah 
                FROM
                    (
                    SELECT
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        SUM ( A.Anggaran ) AS Anggaran,
                        SUM ( A.Pergeseran ) AS Pergeseran,
                        SUM ( A.UP ) AS UP,
                        SUM ( A.LS ) AS LS,
                        SUM ( A.UP + A.LS ) AS Jumlah 
                    FROM
                        (
                        SELECT
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5,
                            0 AS Anggaran,
                            0 AS Pergeseran,
                            0 AS UP,
                            A.Nilai AS LS 
                        FROM
                            Ta_SPM_Rinc A
                            INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                            AND A.No_SPM = B.No_SPM
                            INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                            AND B.No_SPM = C.No_SPM 
                        WHERE
                            ( B.Jn_SPM = 3 ) 
                            AND ( B.Kd_Edit <> 2 ) 
                            AND ( C.Tgl_SP2D < '$d1' ) 
                            AND ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                            AND ( '$covid' = 0 ) UNION ALL
                        SELECT
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5,
                            0 AS Anggaran,
                            0 AS Pergeseran,
                            A.Nilai_Setuju AS UP,
                            0 AS LS 
                        FROM
                            Ta_Pengesahan_SPJ_Rinc A
                            INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                            AND A.No_Pengesahan = B.No_Pengesahan 
                        WHERE
                            ( B.Tgl_Pengesahan < '$d1' ) 
                            AND ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                            AND ( '$covid' = 0 ) UNION ALL
                        SELECT
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5,
                            0 AS Anggaran,
                            0 AS Pergeseran,
                        CASE
                                B.Jn_SPM 
                                WHEN 3 THEN
                                0 ELSE
                            CASE
                                    A.D_K 
                                    WHEN 'D' THEN
                                    A.Nilai ELSE - A.Nilai 
                                END 
                                END AS UP,
                            CASE
                                    B.Jn_SPM 
                                    WHEN 3 THEN
                                CASE
                                        A.D_K 
                                        WHEN 'D' THEN
                                        A.Nilai ELSE - A.Nilai 
                                    END ELSE 0 
                                END AS LS 
                            FROM
                                Ta_Penyesuaian_Rinc A
                                INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                                AND A.No_Bukti = B.No_Bukti 
                            WHERE
                                ( B.Tgl_Bukti < '$d1' ) 
                                AND ( A.Tahun = '$tahun' ) 
                                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                AND ( B.Jns_P1 = 1 ) 
                                AND ( '$covid' = 0 ) UNION ALL
                            SELECT
                                A.Kd_Rek_1,
                                A.Kd_Rek_2,
                                A.Kd_Rek_3,
                                A.Kd_Rek_4,
                                A.Kd_Rek_5,
                                0 AS Anggaran,
                                0 AS Pergeseran,
                                0 AS UP,
                            CASE
                                    A.D_K 
                                    WHEN 'D' THEN
                                    A.Nilai ELSE - A.Nilai 
                                END AS LS 
                            FROM
                                Ta_Jurnal_Rinc A
                                INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                                AND A.No_Bukti = B.No_Bukti 
                            WHERE
                                ( B.Tgl_Bukti < '$d1' ) 
                                AND ( A.Tahun = '$tahun' ) 
                                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                AND ( A.Kd_Rek_1 = 5 ) 
                                AND ( '$Peny_SPJ' = 1 ) 
                                AND ( B.No_BKU <> 9999 ) 
                                AND ( '$covid' = 0 ) UNION ALL
                            SELECT
                                A.Kd_Rek_1,
                                A.Kd_Rek_2,
                                A.Kd_Rek_3,
                                A.Kd_Rek_4,
                                A.Kd_Rek_5,
                                0 AS Anggaran,
                                0 AS Pergeseran,
                                A.Nilai AS UP,
                                0 AS LS 
                            FROM
                                Ta_SPJC_Bukti A 
                            WHERE
                                ( A.Tgl_Bukti < '$d1' ) 
                                AND ( A.Tahun = '$tahun' ) 
                                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                AND ( '$covid' = 1 ) UNION ALL
                            SELECT
                                A.Kd_Rek_1,
                                A.Kd_Rek_2,
                                A.Kd_Rek_3,
                                A.Kd_Rek_4,
                                A.Kd_Rek_5,
                                SUM ( A.Total ),
                                0,
                                0,
                                0 
                            FROM
                                Ta_RASK_Arsip A 
                            WHERE
                                ( ( A.Kd_Rek_1 = 5 ) OR ( ( A.Kd_Rek_1 = 6 ) AND ( A.Kd_Rek_2 = 2 ) ) ) 
                                AND ( A.Tahun = '$tahun' ) 
                                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                AND (
                                    A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d2' ) 
                                ) 
                            GROUP BY
                                A.Kd_Rek_1,
                                A.Kd_Rek_2,
                                A.Kd_Rek_3,
                                A.Kd_Rek_4,
                                A.Kd_Rek_5 UNION ALL
                            SELECT
                                A.Kd_Rek_1,
                                A.Kd_Rek_2,
                                A.Kd_Rek_3,
                                A.Kd_Rek_4,
                                A.Kd_Rek_5,
                                0,
                                SUM ( A.Total ),
                                0,
                                0 
                            FROM
                                Ta_RASK_Arsip A 
                            WHERE
                                ( ( A.Kd_Rek_1 = 5 ) OR ( ( A.Kd_Rek_1 = 6 ) AND ( A.Kd_Rek_2 = 2 ) ) ) 
                                AND ( A.Tahun = '$tahun' ) 
                                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                AND (
                                    A.Kd_Perubahan = (
                                    SELECT MAX
                                        ( Kd_Perubahan ) 
                                    FROM
                                        Ta_RASK_Arsip_Perubahan 
                                    WHERE
                                        Tahun = '$tahun' 
                                        AND Kd_Perubahan IN ( 5, 7 ) 
                                        AND Tgl_Perda <= '$d2' 
                                        AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= '$d2' ) 
                                    ) 
                                ) 
                            GROUP BY
                                A.Kd_Rek_1,
                                A.Kd_Rek_2,
                                A.Kd_Rek_3,
                                A.Kd_Rek_4,
                                A.Kd_Rek_5 
                            ) A 
                        GROUP BY
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5 
                        ) A
                        INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                        AND A.Kd_Rek_2 = B.Kd_Rek_2 
                        AND A.Kd_Rek_3 = B.Kd_Rek_3 
                        AND A.Kd_Rek_4 = B.Kd_Rek_4 
                        AND A.Kd_Rek_5 = B.Kd_Rek_5 UNION ALL
                    SELECT
                        2 AS Kode,
                        CONVERT ( VARCHAR, C.No_BKU ),
                        C.No_SP2D,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                        D.Nm_Rek_5,
                        0 AS Anggaran,
                        0 AS Pergeseran,
                    CASE
                            B.Jn_SPM 
                            WHEN 1 THEN
                            A.Nilai 
                            WHEN 2 THEN
                            A.Nilai 
                            WHEN 4 THEN
                            A.Nilai ELSE 0 
                        END AS UP,
                    CASE
                            B.Jn_SPM 
                            WHEN 3 THEN
                            A.Nilai ELSE 0 
                        END AS LS,
                        A.Nilai 
                    FROM
                        Ta_SPM_Rinc A
                        INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                        AND A.No_SPM = B.No_SPM
                        INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                        AND B.No_SPM = C.No_SPM
                        INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1 
                        AND A.Kd_Rek_2 = D.Kd_Rek_2 
                        AND A.Kd_Rek_3 = D.Kd_Rek_3 
                        AND A.Kd_Rek_4 = D.Kd_Rek_4 
                        AND A.Kd_Rek_5 = D.Kd_Rek_5 
                    WHERE
                        ( B.Jn_SPM = 3 ) 
                        AND ( B.Kd_Edit <> 2 ) 
                        AND ( C.Tgl_SP2D BETWEEN '$d1' AND '$d2' ) 
                        AND ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( '$covid' = 0 ) UNION ALL
                    SELECT
                        2 AS Kode,
                        CONVERT ( VARCHAR, B.No_BKU ),
                        B.No_Pengesahan,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                        C.Nm_Rek_5,
                        0 AS Anggaran,
                        0 AS Pergeseran,
                        SUM ( A.Nilai_Setuju ) AS UP,
                        0 AS LS,
                        SUM ( A.Nilai_Setuju ) AS Nilai 
                    FROM
                        Ta_Pengesahan_SPJ_Rinc A
                        INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                        AND A.No_Pengesahan = B.No_Pengesahan
                        INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                        AND A.Kd_Rek_2 = C.Kd_Rek_2 
                        AND A.Kd_Rek_3 = C.Kd_Rek_3 
                        AND A.Kd_Rek_4 = C.Kd_Rek_4 
                        AND A.Kd_Rek_5 = C.Kd_Rek_5 
                    WHERE
                        ( B.Tgl_Pengesahan BETWEEN '$d1' AND '$d2' ) 
                        AND ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( '$covid' = 0 ) 
                    GROUP BY
                        B.No_BKU,
                        B.No_Pengesahan,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        C.Nm_Rek_5 UNION ALL
                    SELECT
                        2 AS Kode,
                        CONVERT ( VARCHAR, B.No_BKU ),
                        B.No_Bukti,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                        C.Nm_Rek_5,
                        0 AS Anggaran,
                        0 AS Pergeseran,
                        SUM ( CASE B.Jn_SPM WHEN 3 THEN 0 ELSE CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END END ) AS UP,
                        SUM ( CASE B.Jn_SPM WHEN 3 THEN CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ELSE 0 END ) AS LS,
                        SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ) AS Nilai 
                    FROM
                        Ta_Penyesuaian_Rinc A
                        INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                        AND A.No_Bukti = B.No_Bukti
                        INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                        AND A.Kd_Rek_2 = C.Kd_Rek_2 
                        AND A.Kd_Rek_3 = C.Kd_Rek_3 
                        AND A.Kd_Rek_4 = C.Kd_Rek_4 
                        AND A.Kd_Rek_5 = C.Kd_Rek_5 
                    WHERE
                        ( B.Tgl_Bukti BETWEEN '$d1' AND '$d2' ) 
                        AND ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( B.Jns_P1 = 1 ) 
                        AND ( '$covid' = 0 ) 
                    GROUP BY
                        B.No_BKU,
                        B.No_Bukti,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        C.Nm_Rek_5 UNION ALL
                    SELECT
                        2 AS Kode,
                        CONVERT ( VARCHAR, B.No_BKU ),
                        B.No_Bukti,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                        C.Nm_Rek_5,
                        0 AS Anggaran,
                        0 AS Pergeseran,
                        0 AS UP,
                        SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ) AS LS,
                        SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ) AS Nilai 
                    FROM
                        Ta_Jurnal_Rinc A
                        INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                        AND A.No_Bukti = B.No_Bukti
                        INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                        AND A.Kd_Rek_2 = C.Kd_Rek_2 
                        AND A.Kd_Rek_3 = C.Kd_Rek_3 
                        AND A.Kd_Rek_4 = C.Kd_Rek_4 
                        AND A.Kd_Rek_5 = C.Kd_Rek_5 
                    WHERE
                        ( B.Tgl_Bukti BETWEEN '$d1' AND '$d2' ) 
                        AND ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( A.Kd_Rek_1 = 5 ) 
                        AND ( '$Peny_SPJ' = 1 ) 
                        AND ( B.No_BKU <> 9999 ) 
                        AND ( '$covid' = 0 ) 
                    GROUP BY
                        B.No_BKU,
                        B.No_Bukti,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        C.Nm_Rek_5 UNION ALL
                    SELECT
                        2 AS Kode,
                        CONVERT ( VARCHAR, A.No_BKU ),
                        A.No_Bukti,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                        C.Nm_Rek_5,
                        0 AS Anggaran,
                        0 AS Pergeseran,
                        SUM ( A.Nilai ) AS UP,
                        0 AS LS,
                        SUM ( A.Nilai ) AS Nilai 
                    FROM
                        Ta_SPJC_Bukti A
                        INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                        AND A.Kd_Rek_2 = C.Kd_Rek_2 
                        AND A.Kd_Rek_3 = C.Kd_Rek_3 
                        AND A.Kd_Rek_4 = C.Kd_Rek_4 
                        AND A.Kd_Rek_5 = C.Kd_Rek_5 
                    WHERE
                        ( A.Tgl_Bukti BETWEEN '$d1' AND '$d2' ) 
                        AND ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( '$covid' = 1 ) 
                    GROUP BY
                        A.No_BKU,
                        A.No_Bukti,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        C.Nm_Rek_5 
                    ) A,
                    (
                    SELECT
                        '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                        '$kd_urusan' AS Kd_Urusan_Gab,
                        '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                        '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                        '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
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
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    A.Kode,
                A.No_BKU,
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

    public function bku_rincian_obyek($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $Peny_SPJ								    = $this->query
        ("
            SELECT 
                Peny_SPJ
            FROM 
                Ref_Setting
            WHERE
                Tahun = '$tahun'
		")
            ->row('Peny_SPJ');

        $kd_perubahan								= $this->query
        ("
            SELECT
                MAX(Kd_Perubahan) AS Kd_Perubahan
            FROM
                Ta_RASK_Arsip_Perubahan
            WHERE
                Tahun = '$tahun'
            AND Kd_Perubahan IN (4, 6, 8)
            AND Tgl_Perda <= '$d1'
		")
            ->row('Kd_Perubahan');

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
                A.Kode,
                A.No_BKU,
                A.Keterangan,
                A.Tgl_Bukti,
                A.Kd_Rek_5_Gab,
                A.Nm_Rek_5,
                A.Anggaran,
                A.Pergeseran,
                A.UP,
                A.LS,
                A.TU,
                A.Jumlah, @Perubahan AS Kd_Ubah,
                B.Nm_Pimpinan,
                B.Nip_Pimpinan,
                B.Jbt_Pimpinan,
                B.Nm_Bendahara,
                B.Nip_Bendahara,
                B.Jbt_Bendahara 
            FROM
                (
                SELECT
                    1 AS Kode,
                    '' AS No_BKU,
                    '' AS Keterangan,
                    CONVERT ( datetime, NULL ) AS Tgl_Bukti,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    B.Nm_Rek_5,
                    A.Anggaran,
                    A.Pergeseran,
                    0 AS UP,
                    0 AS LS,
                    0 AS Jumlah,
                    0 AS TU 
                FROM
                    (
                    SELECT
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        SUM ( A.Anggaran ) AS Anggaran,
                        SUM ( A.Pergeseran ) AS Pergeseran 
                    FROM
                        (
                        SELECT
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5,
                            SUM ( A.Total ) Anggaran,
                            0 AS Pergeseran 
                        FROM
                            Ta_RASK_Arsip A 
                        WHERE
                            ( ( A.Kd_Rek_1 = 5 ) OR ( ( A.Kd_Rek_1 = 6 ) AND ( A.Kd_Rek_2 = 2 ) ) ) 
                            AND ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                            AND ( A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan = 4 AND Tgl_Perda <= '$d1' ) ) 
                        GROUP BY
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5 UNION ALL
                        SELECT
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5,
                            0,
                            SUM ( A.Total ) 
                        FROM
                            Ta_RASK_Arsip A 
                        WHERE
                            ( ( A.Kd_Rek_1 = 5 ) OR ( ( A.Kd_Rek_1 = 6 ) AND ( A.Kd_Rek_2 = 2 ) ) ) 
                            AND ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                            AND (
                                A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 6, 8 ) AND Tgl_Perda <= '$d1' ) 
                            ) 
                        GROUP BY
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5 
                        ) A 
                    GROUP BY
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5 
                    ) A
                    INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                    AND A.Kd_Rek_2 = B.Kd_Rek_2 
                    AND A.Kd_Rek_3 = B.Kd_Rek_3 
                    AND A.Kd_Rek_4 = B.Kd_Rek_4 
                    AND A.Kd_Rek_5 = B.Kd_Rek_5 UNION ALL
                SELECT
                    2 AS Kode,
                    CONVERT ( VARCHAR, C.No_SP2D ) AS No_BKU,
                    C.Keterangan,
                    C.Tgl_SP2D,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    D.Nm_Rek_5,
                    0 AS Anggaran,
                    0 AS Pergeseran,
                CASE
                        B.Jn_SPM 
                        WHEN 1 THEN
                        A.Nilai 
                        WHEN 2 THEN
                        A.Nilai 
                        WHEN 4 THEN
                        A.Nilai ELSE 0 
                    END AS UP,
                CASE
                        B.Jn_SPM 
                        WHEN 3 THEN
                        A.Nilai ELSE 0 
                    END AS LS,
                    A.Nilai AS Jumlah,
                    0 AS TU 
                FROM
                    Ta_SPM_Rinc A
                    INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM
                    INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                    AND B.No_SPM = C.No_SPM
                    INNER JOIN Ref_Rek_5 D ON A.Kd_Rek_1 = D.Kd_Rek_1 
                    AND A.Kd_Rek_2 = D.Kd_Rek_2 
                    AND A.Kd_Rek_3 = D.Kd_Rek_3 
                    AND A.Kd_Rek_4 = D.Kd_Rek_4 
                    AND A.Kd_Rek_5 = D.Kd_Rek_5 
                WHERE
                    ( B.Jn_SPM = 3 ) 
                    AND ( B.Kd_Edit <> 2 ) 
                    AND ( C.Tgl_SP2D <= '$d1' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) UNION ALL
                SELECT
                    2 AS Kode,
                    CONVERT ( VARCHAR, B.No_Pengesahan ),
                    B.Keterangan,
                    B.Tgl_Pengesahan,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    C.Nm_Rek_5,
                    0 AS Anggaran,
                    0 AS Pergeseran,
                    SUM ( CASE D.Jn_SPJ WHEN 2 THEN A.Nilai_Setuju ELSE 0 END ) AS UP,
                    0 AS LS,
                    SUM ( A.Nilai_Setuju ) AS Nilai,
                    SUM ( CASE D.Jn_SPJ WHEN 4 THEN A.Nilai_Setuju ELSE 0 END ) AS TU 
                FROM
                    Ta_Pengesahan_SPJ_Rinc A
                    INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_Pengesahan = B.No_Pengesahan
                    INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                    AND A.Kd_Rek_2 = C.Kd_Rek_2 
                    AND A.Kd_Rek_3 = C.Kd_Rek_3 
                    AND A.Kd_Rek_4 = C.Kd_Rek_4 
                    AND A.Kd_Rek_5 = C.Kd_Rek_5
                    INNER JOIN Ta_SPJ D ON B.Tahun = D.Tahun 
                    AND B.No_SPJ = D.No_SPJ 
                WHERE
                    ( B.Tgl_Pengesahan <= '$d1' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                GROUP BY
                    B.No_Pengesahan,
                    B.Keterangan,
                    B.Tgl_Pengesahan,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    C.Nm_Rek_5 UNION ALL
                SELECT
                    2 AS Kode,
                    CONVERT ( VARCHAR, B.No_Bukti ),
                    B.Keterangan,
                    B.Tgl_Bukti,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    C.Nm_Rek_5,
                    0 AS Anggaran,
                    0 AS Pergeseran,
                    SUM ( CASE B.Jn_SPM WHEN 3 THEN 0 ELSE CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END END ) AS UP,
                    SUM ( CASE B.Jn_SPM WHEN 3 THEN CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ELSE 0 END ) AS LS,
                    SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ) AS Nilai,
                    0 AS TU 
                FROM
                    Ta_Penyesuaian_Rinc A
                    INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                    AND A.No_Bukti = B.No_Bukti
                    INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                    AND A.Kd_Rek_2 = C.Kd_Rek_2 
                    AND A.Kd_Rek_3 = C.Kd_Rek_3 
                    AND A.Kd_Rek_4 = C.Kd_Rek_4 
                    AND A.Kd_Rek_5 = C.Kd_Rek_5 
                WHERE
                    ( B.Tgl_Bukti <= '$d1' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                    AND ( B.Jns_P1 = 1 ) 
                GROUP BY
                    B.No_Bukti,
                    B.Keterangan,
                    B.Tgl_Bukti,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    C.Nm_Rek_5 UNION ALL
                SELECT
                    2 AS Kode,
                    CONVERT ( VARCHAR, B.No_Bukti ),
                    B.Keterangan,
                    B.Tgl_Bukti,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                    C.Nm_Rek_5,
                    0 AS Anggaran,
                    0 AS Pergeseran,
                    0 AS UP,
                    SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ) AS LS,
                    SUM ( CASE A.D_K WHEN 'D' THEN A.Nilai ELSE - A.Nilai END ) AS Nilai,
                    0 AS TU 
                FROM
                    Ta_Jurnal_Rinc A
                    INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                    AND A.No_Bukti = B.No_Bukti
                    INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                    AND A.Kd_Rek_2 = C.Kd_Rek_2 
                    AND A.Kd_Rek_3 = C.Kd_Rek_3 
                    AND A.Kd_Rek_4 = C.Kd_Rek_4 
                    AND A.Kd_Rek_5 = C.Kd_Rek_5 
                WHERE
                    ( B.Tgl_Bukti <= '$d1' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                    AND ( A.Kd_Rek_1 = 5 ) 
                    AND ( '$Peny_SPJ' = 1 ) 
                    AND ( B.No_BKU <> 9999 ) 
                GROUP BY
                    B.No_Bukti,
                    B.Keterangan,
                    B.Tgl_Bukti,
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    C.Nm_Rek_5 
                ) A,
                (
                SELECT
                    '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                    '$kd_urusan' AS Kd_Urusan_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
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
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                A.Kode,
                A.Tgl_Bukti,
                A.No_BKU,
                A.Keterangan
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function posisi_Kas($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $Peny_SPJ								    = $this->query
        ("
            SELECT 
                Peny_SPJ
            FROM 
                Ref_Setting
            WHERE
                Tahun = '$tahun'
		")
            ->row('Peny_SPJ');

        $tmpSPJ								        =
        ("
            SELECT
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                SUM ( A.Anggaran ),
                SUM ( A.Gaji_L ),
                SUM ( A.Gaji_I ),
                SUM ( A.LS_L ),
                SUM ( A.LS_I ),
                SUM ( A.UP_L ),
                SUM ( A.UP_I ) 
            FROM
                (
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    A.Total AS Anggaran,
                    0 AS Gaji_L,
                    0 AS Gaji_I,
                    0 AS LS_L,
                    0 AS LS_I,
                    0 AS UP_L,
                    0 AS UP_I 
                FROM
                    Ta_RASK_Arsip A 
                WHERE
                    ( A.Kd_Rek_1 = 5 ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND (
                        A.Kd_Perubahan = (
                        SELECT MAX
                            ( Kd_Perubahan ) 
                        FROM
                            Ta_RASK_Arsip_Perubahan 
                        WHERE
                            ( Kd_Perubahan IN ( 4, 6, 8 ) ) 
                            AND (
                                LEFT ( CONVERT ( VARCHAR, Tgl_Perda, 112 ), 6 ) <= ( '$tahun' + RIGHT ( '0' + CONVERT ( VARCHAR, @Bulan ), 2 ) ) 
                            ) 
                            AND ( Tahun = '$tahun' ) 
                        ) 
                    ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) UNION ALL
                SELECT
                    A.Kd_Rek_1,
                    A.Kd_Rek_2,
                    A.Kd_Rek_3,
                    A.Kd_Rek_4,
                    A.Kd_Rek_5,
                    0,
                CASE
                        
                        WHEN B.Jn_SPM IN ( 1, 2, 4 ) THEN
                        0 
                        WHEN ( A.Kd_Rek_1 = 5 ) 
                        AND ( A.Kd_Rek_2 = 1 ) 
                        AND ( A.Kd_Rek_3 = 1 ) 
                        AND ( A.Kd_Rek_4 = 1 ) THEN
                            A.Nilai ELSE 0 
                        END AS Gaji_L,
                        0 AS Gaji_I,
                    CASE
                            
                            WHEN B.Jn_SPM IN ( 1, 2, 4 ) THEN
                            0 
                            WHEN ( A.Kd_Rek_1 = 5 ) 
                            AND ( A.Kd_Rek_2 = 1 ) 
                            AND ( A.Kd_Rek_3 = 1 ) 
                            AND ( A.Kd_Rek_4 = 1 ) THEN
                                0 ELSE A.Nilai 
                            END AS LS_L,
                            0 AS LS_I,
                            0 UP_L,
                            0 AS UP_I 
                        FROM
                            Ta_SPM_Rinc A
                            INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                            AND A.No_SPM = B.No_SPM
                            INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                            AND B.No_SPM = C.No_SPM 
                        WHERE
                            ( B.Jn_SPM = 3 ) 
                            AND ( B.Kd_Edit <> 2 ) 
                            AND ( MONTH ( C.Tgl_SP2D ) < @Bulan ) 
                            AND ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                            AND ( A.Kd_Rek_1 = 5 ) UNION ALL
                        SELECT
                            A.Kd_Rek_1,
                            A.Kd_Rek_2,
                            A.Kd_Rek_3,
                            A.Kd_Rek_4,
                            A.Kd_Rek_5,
                            0,
                            0 AS Gaji_L,
                        CASE
                                
                                WHEN ( A.Kd_Rek_1 = 5 ) 
                                AND ( A.Kd_Rek_2 = 1 ) 
                                AND ( A.Kd_Rek_3 = 1 ) 
                                AND ( A.Kd_Rek_4 = 1 ) THEN
                                    A.Nilai ELSE 0 
                                END AS Gaji_I,
                                0 AS LS_L,
                            CASE
                                    
                                    WHEN ( A.Kd_Rek_1 = 5 ) 
                                    AND ( A.Kd_Rek_2 = 1 ) 
                                    AND ( A.Kd_Rek_3 = 1 ) 
                                    AND ( A.Kd_Rek_4 = 1 ) THEN
                                        0 ELSE A.Nilai 
                                    END AS LS_I,
                                    0 AS UP_L,
                                    0 AS UP_I 
                                FROM
                                    Ta_SPM_Rinc A
                                    INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                                    AND A.No_SPM = B.No_SPM
                                    INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                                    AND B.No_SPM = C.No_SPM 
                                WHERE
                                    ( B.Jn_SPM = 3 ) 
                                    AND ( B.Kd_Edit <> 2 ) 
                                    AND ( MONTH ( C.Tgl_SP2D ) = @Bulan ) 
                                    AND ( A.Tahun = '$tahun' ) 
                                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                    AND ( A.Kd_Rek_1 = 5 ) UNION ALL
                                SELECT
                                    A.Kd_Rek_1,
                                    A.Kd_Rek_2,
                                    A.Kd_Rek_3,
                                    A.Kd_Rek_4,
                                    A.Kd_Rek_5,
                                    0 AS Anggaran,
                                    0 AS Gaji_L,
                                    0 AS Gaji_I,
                                    0 AS LS_L,
                                    0 AS LS_I,
                                    A.Nilai AS UP_L,
                                    0 AS UP_I 
                                FROM
                                    Ta_SPJ_Rinc A
                                    INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                                    AND A.No_SPJ = B.No_SPJ 
                                WHERE
                                    ( MONTH ( B.Tgl_SPJ ) < @Bulan ) 
                                    AND ( A.Tahun = '$tahun' ) 
                                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                    AND ( A.Kd_Sub LIKE '$kd_sub' ) UNION ALL
                                SELECT
                                    A.Kd_Rek_1,
                                    A.Kd_Rek_2,
                                    A.Kd_Rek_3,
                                    A.Kd_Rek_4,
                                    A.Kd_Rek_5,
                                    0 AS Anggaran,
                                    0 AS Gaji_L,
                                    0 AS Gaji_I,
                                    0 AS LS_L,
                                    0 AS LS_I,
                                    0 AS UP_L,
                                    A.Nilai AS UP_I 
                                FROM
                                    Ta_SPJ_Rinc A
                                    INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                                    AND A.No_SPJ = B.No_SPJ 
                                WHERE
                                    ( MONTH ( B.Tgl_SPJ ) = @Bulan ) 
                                    AND ( A.Tahun = '$tahun' ) 
                                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                    AND ( A.Kd_Sub LIKE '$kd_sub' ) UNION ALL
                                SELECT
                                    A.Kd_Rek_1,
                                    A.Kd_Rek_2,
                                    A.Kd_Rek_3,
                                    A.Kd_Rek_4,
                                    A.Kd_Rek_5,
                                    0,
                                CASE
                                        
                                        WHEN B.Jn_SPM IN ( 2, 5 ) THEN
                                        0 
                                        WHEN ( A.Kd_Rek_1 = 5 ) 
                                        AND ( A.Kd_Rek_2 = 1 ) 
                                        AND ( A.Kd_Rek_3 = 1 ) 
                                        AND ( A.Kd_Rek_4 = 1 ) THEN
                                        CASE
                                                A.D_K 
                                                WHEN 'D' THEN
                                                A.Nilai ELSE - A.Nilai 
                                            END ELSE 0 
                                        END AS Gaji_L,
                                        0 AS Gaji_I,
                                    CASE
                                            
                                            WHEN B.Jn_SPM IN ( 2, 5 ) THEN
                                            0 
                                            WHEN ( A.Kd_Rek_1 = 5 ) 
                                            AND ( A.Kd_Rek_2 = 1 ) 
                                            AND ( A.Kd_Rek_3 = 1 ) 
                                            AND ( A.Kd_Rek_4 = 1 ) THEN
                                                0 ELSE
                                            CASE
                                                    A.D_K 
                                                    WHEN 'D' THEN
                                                    A.Nilai ELSE - A.Nilai 
                                                END 
                                                END AS LS_L,
                                                0 AS LS_I,
                                            CASE
                                                    
                                                    WHEN B.Jn_SPM IN ( 2, 5 ) THEN
                                                CASE
                                                        A.D_K 
                                                        WHEN 'D' THEN
                                                        A.Nilai ELSE - A.Nilai 
                                                    END ELSE 0 
                                                END AS UP_L,
                                                0 AS UP_I 
                                            FROM
                                                Ta_Penyesuaian_Rinc A
                                                INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                                                AND A.No_Bukti = B.No_Bukti 
                                            WHERE
                                                ( A.Tahun = '$tahun' ) 
                                                AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                                AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                                AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                                AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                                AND ( B.Jns_P1 = 1 ) 
                                                AND ( MONTH ( B.Tgl_Bukti ) < @Bulan ) 
                                                AND ( '$Peny_SPJ' = 1 ) UNION ALL
                                            SELECT
                                                A.Kd_Rek_1,
                                                A.Kd_Rek_2,
                                                A.Kd_Rek_3,
                                                A.Kd_Rek_4,
                                                A.Kd_Rek_5,
                                                0,
                                                0 AS Gaji_L,
                                            CASE
                                                    
                                                    WHEN B.Jn_SPM IN ( 2, 5 ) THEN
                                                    0 
                                                    WHEN ( A.Kd_Rek_1 = 5 ) 
                                                    AND ( A.Kd_Rek_2 = 1 ) 
                                                    AND ( A.Kd_Rek_3 = 1 ) 
                                                    AND ( A.Kd_Rek_4 = 1 ) THEN
                                                    CASE
                                                            A.D_K 
                                                            WHEN 'D' THEN
                                                            A.Nilai ELSE - A.Nilai 
                                                        END ELSE 0 
                                                    END AS Gaji_I,
                                                    0 AS LS_L,
                                                CASE
                                                        
                                                        WHEN B.Jn_SPM IN ( 2, 5 ) THEN
                                                        0 
                                                        WHEN ( A.Kd_Rek_1 = 5 ) 
                                                        AND ( A.Kd_Rek_2 = 1 ) 
                                                        AND ( A.Kd_Rek_3 = 1 ) 
                                                        AND ( A.Kd_Rek_4 = 1 ) THEN
                                                            0 ELSE
                                                        CASE
                                                                A.D_K 
                                                                WHEN 'D' THEN
                                                                A.Nilai ELSE - A.Nilai 
                                                            END 
                                                            END AS LS_I,
                                                            0 AS UP_L,
                                                        CASE
                                                                
                                                                WHEN B.Jn_SPM IN ( 2, 5 ) THEN
                                                            CASE
                                                                    A.D_K 
                                                                    WHEN 'D' THEN
                                                                    A.Nilai ELSE - A.Nilai 
                                                                END ELSE 0 
                                                            END AS UP_I 
                                                        FROM
                                                            Ta_Penyesuaian_Rinc A
                                                            INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                                                            AND A.No_Bukti = B.No_Bukti 
                                                        WHERE
                                                            ( A.Tahun = '$tahun' ) 
                                                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                                            AND ( B.Jns_P1 = 1 ) 
                                                            AND ( MONTH ( B.Tgl_Bukti ) = @Bulan ) 
                                                            AND ( '$Peny_SPJ' = 1 ) UNION ALL
                                                        SELECT
                                                            A.Kd_Rek_1,
                                                            A.Kd_Rek_2,
                                                            A.Kd_Rek_3,
                                                            A.Kd_Rek_4,
                                                            A.Kd_Rek_5,
                                                            0,
                                                        CASE
                                                                
                                                                WHEN ( A.Kd_Rek_1 = 5 ) 
                                                                AND ( A.Kd_Rek_2 = 1 ) 
                                                                AND ( A.Kd_Rek_3 = 1 ) 
                                                                AND ( A.Kd_Rek_4 = 1 ) THEN
                                                                CASE
                                                                        A.D_K 
                                                                        WHEN 'D' THEN
                                                                        A.Nilai ELSE - A.Nilai 
                                                                    END ELSE 0 
                                                                END AS Gaji_L,
                                                                0 AS Gaji_I,
                                                            CASE
                                                                    
                                                                    WHEN ( A.Kd_Rek_1 = 5 ) 
                                                                    AND ( A.Kd_Rek_2 = 1 ) 
                                                                    AND ( A.Kd_Rek_3 = 1 ) 
                                                                    AND ( A.Kd_Rek_4 = 1 ) THEN
                                                                        0 ELSE
                                                                    CASE
                                                                            A.D_K 
                                                                            WHEN 'D' THEN
                                                                            A.Nilai ELSE - A.Nilai 
                                                                        END 
                                                                        END AS LS_L,
                                                                        0 AS LS_I,
                                                                        0 AS UP_L,
                                                                        0 AS UP_I 
                                                                    FROM
                                                                        Ta_Jurnal_Rinc A
                                                                        INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                                                                        AND A.No_Bukti = B.No_Bukti 
                                                                    WHERE
                                                                        ( A.Tahun = '$tahun' ) 
                                                                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                                                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                                                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                                                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                                                        AND ( MONTH ( B.Tgl_Bukti ) < @Bulan ) 
                                                                        AND ( '$Peny_SPJ' = 1 ) 
                                                                        AND ( A.Kd_Rek_1 = 5 ) 
                                                                        AND ( B.No_BKU <> 9999 ) UNION ALL
                                                                    SELECT
                                                                        A.Kd_Rek_1,
                                                                        A.Kd_Rek_2,
                                                                        A.Kd_Rek_3,
                                                                        A.Kd_Rek_4,
                                                                        A.Kd_Rek_5,
                                                                        0,
                                                                        0 AS Gaji_L,
                                                                    CASE
                                                                            
                                                                            WHEN ( A.Kd_Rek_1 = 5 ) 
                                                                            AND ( A.Kd_Rek_2 = 1 ) 
                                                                            AND ( A.Kd_Rek_3 = 1 ) 
                                                                            AND ( A.Kd_Rek_4 = 1 ) THEN
                                                                            CASE
                                                                                    A.D_K 
                                                                                    WHEN 'D' THEN
                                                                                    A.Nilai ELSE - A.Nilai 
                                                                                END ELSE 0 
                                                                            END AS Gaji_I,
                                                                            0 AS LS_L,
                                                                        CASE
                                                                                
                                                                                WHEN ( A.Kd_Rek_1 = 5 ) 
                                                                                AND ( A.Kd_Rek_2 = 1 ) 
                                                                                AND ( A.Kd_Rek_3 = 1 ) 
                                                                                AND ( A.Kd_Rek_4 = 1 ) THEN
                                                                                    0 ELSE
                                                                                CASE
                                                                                        A.D_K 
                                                                                        WHEN 'D' THEN
                                                                                        A.Nilai ELSE - A.Nilai 
                                                                                    END 
                                                                                    END AS LS_I,
                                                                                    0 AS UP_L,
                                                                                    0 AS UP_I 
                                                                                FROM
                                                                                    Ta_Jurnal_Rinc A
                                                                                    INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                                                                                    AND A.No_Bukti = B.No_Bukti 
                                                                                WHERE
                                                                                    ( A.Tahun = '$tahun' ) 
                                                                                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                                                                                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                                                                                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                                                                                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                                                                                    AND ( MONTH ( B.Tgl_Bukti ) = @Bulan ) 
                                                                                    AND ( '$Peny_SPJ' = 1 ) 
                                                                                    AND ( A.Kd_Rek_1 = 5 ) 
                                                                                    AND ( B.No_BKU <> 9999 ) 
                                                                                ) A 
                                                                            GROUP BY
                                                                                A.Kd_Rek_1,
                                                                                A.Kd_Rek_2,
                                                                                A.Kd_Rek_3,
                                                                            A.Kd_Rek_4,
                A.Kd_Rek_5
            ");

        $data_query								    = $this->query
        ("
			SELECT
                C.Kd_UrusanA,
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
                CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                A.Anggaran,
                A.Gaji_L,
                A.Gaji_I,
                A.Gaji_L + A.Gaji_I AS Gaji_T,
                A.LS_L,
                A.LS_I,
                A.LS_L + A.LS_I AS LS_T,
                A.UP_L,
                A.UP_I,
                A.UP_L + A.UP_I AS UP_T,
                A.Gaji_L + A.Gaji_I + A.LS_L + A.LS_I + A.UP_L + A.UP_I AS TOTAL_SPJ,
                A.Anggaran - ( A.Gaji_L + A.Gaji_I + A.LS_L + A.LS_I + A.UP_L + A.UP_I ) AS SISA,
                C.Nm_Pimpinan,
                C.Nip_Pimpinan,
                C.Jbt_Pimpinan,
                C.Nm_Bendahara,
                C.Nip_Bendahara,
                C.Jbt_Bendahara,
                D.Nm_Pemda,
                D.Ibukota,
                D.Logo 
            FROM
                @tmpSPJ A
                INNER JOIN Ref_Rek_5 B ON A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5,
                (
                SELECT
                    '$kd_urusan' AS Kd_UrusanA, '$kd_bidang' AS Kd_BidangA, '$kd_unit' AS Kd_UnitA, '$kd_sub' AS Kd_SubA,
                CASE
                        '$kd_urusan' 
                        WHEN '%' THEN
                        '0' ELSE '$kd_urusan' 
                    END AS Kd_UrusanB,
                CASE
                        '$kd_bidang' 
                        WHEN '%' THEN
                        '00' ELSE RIGHT ( '0' + '$kd_bidang', 2 ) 
                    END AS Kd_BidangB,
                CASE
                        '$kd_unit' 
                        WHEN '%' THEN
                        '00' ELSE RIGHT ( '0' +  '$kd_unit', 2 ) 
                    END AS Kd_UnitB,
                CASE
                        '$kd_sub' 
                        WHEN '%' THEN
                        '00' ELSE RIGHT ( '0' +  '$kd_sub', 2 ) 
                    END AS Kd_SubB,
                    '$kd_urusan' AS Kd_Urusan_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) AS Kd_Unit_Gab,
                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' +  '$kd_sub', 2 ) AS Kd_Sub_Gab,
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
                ) C,
                (
                SELECT UPPER
                    ( A.Nm_Pemda ) AS Nm_Pemda,
                    A.Ibukota,
                    A.Nm_Sekda,
                    A.Nip_Sekda,
                    A.Jbt_Sekda,
                    A.Nm_Ka_Keu,
                    A.Nip_Ka_Keu,
                    A.Jbt_Ka_Keu,
                    A.Logo 
                FROM
                    Ta_Pemda A 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                ) D 
            ORDER BY
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5
		")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function kartu_kendali_penyediaan($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $kd_prog                                    = $params['kd_prog'];
        $id_prog                                    = $params['id_prog'];
        $kd_keg                                     = $params['kd_keg'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $data_query								    = $this->query
        ("
			SELECT CONVERT
                ( VARCHAR, I.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Bidang ), 2 ) AS Kd_Gab_Bidang,
                CONVERT ( VARCHAR, I.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Bidang ), 2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Bidang ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Unit ), 2 ) AS Kd_Gab_Unit,
                CONVERT ( VARCHAR, I.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Bidang ), 2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Bidang ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Unit ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Sub ), 2 ) AS Kd_Gab_Sub,
                CONVERT ( VARCHAR, I.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Bidang ), 2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Bidang ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Unit ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Sub ), 2 ) + ' . ' +
            CASE
                    LEN( CONVERT ( VARCHAR, A.Kd_Prog ) ) 
                    WHEN 3 THEN
                    CONVERT ( VARCHAR, A.Kd_Prog ) ELSE RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Prog ), 2 ) 
                END AS Kd_Gab_Prog,
                CONVERT ( VARCHAR, I.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Bidang ), 2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Bidang ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Unit ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Sub ), 2 ) + ' . ' +
            CASE
                    LEN( CONVERT ( VARCHAR, A.Kd_Prog ) ) 
                    WHEN 3 THEN
                    CONVERT ( VARCHAR, A.Kd_Prog ) ELSE RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Prog ), 2 ) 
                END + ' . ' +
            CASE
                LEN( CONVERT ( VARCHAR, A.Kd_Keg ) ) 
                WHEN 3 THEN
                CONVERT ( VARCHAR, A.Kd_Keg ) ELSE RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Keg ), 2 ) 
                END AS Kd_Gab_Keg,
                J.Nm_Urusan + ' ' + I.Nm_Bidang AS Nm_Bidang,
                H.Nm_Unit,
                G.Nm_Sub_Unit,
                E.Ket_Program,
                D.Ket_Kegiatan,
                CONVERT ( VARCHAR, A.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Rek_3 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_4 ), 2 ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Rek_5 ), 2 ) AS Kd_Rek_5_Gab,
                C.Nm_Rek_5,
                ISNULL( B.Anggaran, 0 ) AS Anggaran,
                ISNULL( B.Pergeseran, 0 ) AS Pergeseran,
                A.No_Bukti,
                A.Tgl_Bukti,
                A.SPD,
                A.SPJ_Sah,
                A.SPJ,
                A.LS,
                A.SPP,
                A.SPD - A.SPJ_Sah - A.SPJ - A.LS - A.SPP AS Sisa,
                ISNULL(
                    (
                    SELECT MAX
                        ( Kd_Perubahan ) 
                    FROM
                        Ta_RASK_Arsip_Perubahan 
                    WHERE
                        Tahun = '$tahun' 
                        AND Kd_Perubahan IN ( 5, 7 ) 
                        AND Tgl_Perda <= @Tgl_Dok 
                        AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= @Tgl_Dok ) 
                    ),
                    0 
                ) AS Kd_Geser 
            FROM
                (
                SELECT
                    A.Urut,
                    A.Tahun,
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
                    A.No_Bukti,
                    A.Tgl_Bukti,
                    SUM ( A.SPD ) AS SPD,
                    SUM ( A.SPJ_Sah ) AS SPJ_Sah,
                    SUM ( A.SPJ ) AS SPJ,
                    SUM ( A.LS ) AS LS,
                    SUM ( A.SPP ) AS SPP 
                FROM
                    (--Nilai SPD
                    SELECT
                        1 AS Urut,
                        A.Tahun,
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
                        B.No_SPD AS No_Bukti,
                        B.Tgl_SPD AS Tgl_Bukti,
                        A.Nilai AS SPD,
                        0 AS SPJ_Sah,
                        0 AS SPJ,
                        0 AS LS,
                        0 AS SPP 
                    FROM
                        Ta_SPD_Rinc A
                        INNER JOIN Ta_SPD B ON A.Tahun = B.Tahun 
                        AND A.No_SPD = B.No_SPD 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Tgl_SPD <= @Tgl_Dok ) 
                        AND ( B.Kd_Edit = 1 ) UNION ALL--SPJ yang disetujui
                    SELECT
                        2 AS Urut,
                        A.Tahun,
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
                        A.No_Pengesahan,
                        B.Tgl_Pengesahan,
                        0 AS SPD,
                        A.Nilai_Setuju AS SPJ_Sah,
                        0 AS SPJ,
                        0 AS LS,
                        0 AS SPP 
                    FROM
                        Ta_Pengesahan_SPJ_Rinc A
                        INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                        AND A.No_Pengesahan = B.No_Pengesahan 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Tgl_Pengesahan <= @Tgl_Dok ) UNION ALL
                    SELECT
                        2 AS Urut,
                        A.Tahun,
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
                        A.No_Bukti,
                        B.Tgl_Bukti,
                        0 AS SPD,
                    CASE
                            A.D_K 
                            WHEN 'D' THEN
                            A.Nilai ELSE - A.Nilai 
                        END AS SPJ_Sah,
                        0 AS SPJ,
                        0 AS LS,
                        0 AS SPP 
                    FROM
                        Ta_Penyesuaian_Rinc A
                        INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                        AND A.No_Bukti = B.No_Bukti 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Tgl_Bukti <= @Tgl_Dok ) 
                        AND ( B.Jns_P1 = '1' ) 
                        AND ( B.Jn_SPM <> 3 ) UNION ALL--SPJ yang belum disahkan
                    SELECT
                        3 AS Urut,
                        A.Tahun,
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
                        A.No_SPJ,
                        B.Tgl_SPJ,
                        0 AS SPD,
                        0 AS SPJ_Sah,
                        A.Nilai AS SPJ,
                        0 AS LS,
                        0 AS SPP 
                    FROM
                        Ta_SPJ_Rinc A
                        INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                        AND A.No_SPJ = B.No_SPJ
                        LEFT OUTER JOIN Ta_Pengesahan_SPJ C ON B.Tahun = C.Tahun 
                        AND B.No_SPJ = C.No_SPJ 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( C.Tahun IS NULL ) 
                        AND ( B.Tgl_SPJ <= @Tgl_Dok ) UNION ALL--SP2D LS
                    SELECT
                        4 AS Urut,
                        A.Tahun,
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
                        C.No_SP2D,
                        C.Tgl_SP2D,
                        0 AS SPD,
                        0 AS SPJ_Sah,
                        0 AS SPJ,
                        A.Nilai AS LS,
                        0 AS SPP 
                    FROM
                        Ta_SPM_Rinc A
                        INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                        AND A.No_SPM = B.No_SPM
                        INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                        AND B.No_SPM = C.No_SPM 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Jn_SPM = 3 ) 
                        AND ( B.Kd_Edit <> 2 ) 
                        AND ( C.Tgl_SP2D <= @Tgl_Dok ) UNION ALL
                    SELECT
                        4 AS Urut,
                        A.Tahun,
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
                        A.No_Bukti,
                        B.Tgl_Bukti,
                        0 AS SPD,
                        0 AS SPJ_Sah,
                        0 AS SPJ,
                    CASE
                            A.D_K 
                            WHEN 'D' THEN
                            A.Nilai ELSE - A.Nilai 
                        END AS LS,
                        0 AS SPP 
                    FROM
                        Ta_Penyesuaian_Rinc A
                        INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                        AND A.No_Bukti = B.No_Bukti 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Tgl_Bukti <= @Tgl_Dok ) 
                        AND ( B.Jns_P1 = '1' ) 
                        AND ( B.Jn_SPM = 3 ) UNION ALL
                    SELECT
                        4 AS Urut,
                        A.Tahun,
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
                        A.No_Bukti,
                        B.Tgl_Bukti,
                        0 AS SPD,
                        0 AS SPJ_Sah,
                        0 AS SPJ,
                    CASE
                            A.D_K 
                            WHEN 'D' THEN
                            A.Nilai ELSE - A.Nilai 
                        END AS LS,
                        0 AS SPP 
                    FROM
                        Ta_Jurnal_Rinc A
                        INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                        AND A.No_Bukti = B.No_Bukti 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Tgl_Bukti <= @Tgl_Dok ) 
                        AND ( A.Kd_Rek_1 = 5 ) 
                        AND ( B.Kd_Jurnal <> 8 ) 
                        AND ( B.Kd_Jurnal <> 10 ) 
                        AND ( B.No_BKU <> 9999 ) UNION ALL--Outstanding SPP
                    SELECT
                        5 AS Urut,
                        A.Tahun,
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
                        B.No_SPP,
                        B.Tgl_SPP,
                        0 AS SPD,
                        0 AS SPJ_Sah,
                        0 AS SPJ,
                        0 AS LS,
                        A.Nilai AS SPP 
                    FROM
                        Ta_SPP_Rinc A
                        INNER JOIN Ta_SPP B ON A.Tahun = B.Tahun 
                        AND A.No_SPP = B.No_SPP
                        LEFT OUTER JOIN Ta_SPM C ON B.Tahun = C.Tahun 
                        AND B.No_SPP = C.No_SPP
                        LEFT OUTER JOIN Ta_SP2D D ON C.No_SPM = D.No_SPM 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND ( B.Jn_SPP = 3 ) 
                        AND ( B.Kd_Edit <> 2 ) 
                        AND ( A.No_SPP NOT IN ( SELECT No_SPP FROM Ta_SPM_Tolak WHERE Tahun = '$tahun' ) ) 
                        AND ( D.Tahun IS NULL ) 
                        AND ( B.Tgl_SPP <= @Tgl_Dok ) 
                    ) A 
                GROUP BY
                    A.Urut,
                    A.Tahun,
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
                    A.No_Bukti,
                    A.Tgl_Bukti 
                ) A
                FULL OUTER JOIN (
                SELECT
                    A.Tahun,
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
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( Pergeseran ) AS Pergeseran 
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
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        SUM ( A.Total ) AS Anggaran,
                        0 AS Pergeseran 
                    FROM
                        Ta_RASK_Arsip A 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND (
                            A.Kd_Perubahan = ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= @Tgl_Dok ) 
                        ) 
                    GROUP BY
                        A.Tahun,
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
                        A.Kd_Rek_5 UNION ALL
                    SELECT
                        A.Tahun,
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
                        0 AS Anggaran,
                        SUM ( A.Total ) AS Pergeseran 
                    FROM
                        Ta_RASK_Arsip A 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$kd_urusan' ) 
                        AND ( A.Kd_Bidang = '$kd_bidang' ) 
                        AND ( A.Kd_Unit = '$kd_unit' ) 
                        AND ( A.Kd_Sub = '$kd_sub' ) 
                        AND ( A.Kd_Prog LIKE '$kd_prog' ) 
                        AND ( A.Id_Prog LIKE '$id_prog' ) 
                        AND ( A.Kd_Keg LIKE '$kd_keg' ) 
                        AND (
                            A.Kd_Perubahan = (
                            SELECT MAX
                                ( Kd_Perubahan ) 
                            FROM
                                Ta_RASK_Arsip_Perubahan 
                            WHERE
                                Tahun = '$tahun' 
                                AND Kd_Perubahan IN ( 5, 7 ) 
                                AND Tgl_Perda <= @Tgl_Dok 
                                AND Kd_Perubahan > ( SELECT MAX ( Kd_Perubahan ) FROM Ta_RASK_Arsip_Perubahan WHERE Tahun = '$tahun' AND Kd_Perubahan IN ( 4, 6, 8 ) AND Tgl_Perda <= @Tgl_Dok ) 
                            ) 
                        ) 
                    GROUP BY
                        A.Tahun,
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
                        A.Kd_Rek_5 
                    ) A 
                GROUP BY
                    A.Tahun,
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
                    A.Kd_Rek_5 
                ) B ON A.Tahun = B.Tahun 
                AND A.Kd_Urusan = B.Kd_Urusan 
                AND A.Kd_Bidang = B.Kd_Bidang 
                AND A.Kd_Unit = B.Kd_Unit 
                AND A.Kd_Sub = B.Kd_Sub 
                AND A.Kd_Prog = B.Kd_Prog 
                AND A.ID_Prog = B.ID_Prog 
                AND A.Kd_Keg = B.Kd_Keg 
                AND A.Kd_Rek_1 = B.Kd_Rek_1 
                AND A.Kd_Rek_2 = B.Kd_Rek_2 
                AND A.Kd_Rek_3 = B.Kd_Rek_3 
                AND A.Kd_Rek_4 = B.Kd_Rek_4 
                AND A.Kd_Rek_5 = B.Kd_Rek_5
                INNER JOIN Ref_Rek_5 C ON A.Kd_Rek_1 = C.Kd_Rek_1 
                AND A.Kd_Rek_2 = C.Kd_Rek_2 
                AND A.Kd_Rek_3 = C.Kd_Rek_3 
                AND A.Kd_Rek_4 = C.Kd_Rek_4 
                AND A.Kd_Rek_5 = C.Kd_Rek_5
                INNER JOIN Ta_Kegiatan D ON A.Tahun = D.Tahun 
                AND A.Kd_Urusan = D.Kd_Urusan 
                AND A.Kd_Bidang = D.Kd_Bidang 
                AND A.Kd_Unit = D.Kd_Unit 
                AND A.Kd_Sub = D.Kd_Sub 
                AND A.Kd_Prog = D.Kd_Prog 
                AND A.ID_Prog = D.ID_Prog 
                AND A.Kd_Keg = D.Kd_Keg
                INNER JOIN Ta_Program E ON D.Tahun = E.Tahun 
                AND D.Kd_Urusan = E.Kd_Urusan 
                AND D.Kd_Bidang = E.Kd_Bidang 
                AND D.Kd_Unit = E.Kd_Unit 
                AND D.Kd_Sub = E.Kd_Sub 
                AND D.Kd_Prog = E.Kd_Prog 
                AND D.ID_Prog = E.ID_Prog
                INNER JOIN Ta_Sub_Unit F ON E.Tahun = F.Tahun 
                AND E.Kd_Urusan = F.Kd_Urusan 
                AND E.Kd_Bidang = F.Kd_Bidang 
                AND E.Kd_Unit = F.Kd_Unit 
                AND E.Kd_Sub = F.Kd_Sub
                INNER JOIN Ref_Sub_Unit G ON F.Kd_Urusan = G.Kd_Urusan 
                AND F.Kd_Bidang = G.Kd_Bidang 
                AND F.Kd_Unit = G.Kd_Unit 
                AND F.Kd_Sub = G.Kd_Sub
                INNER JOIN Ref_Unit H ON G.Kd_Urusan = H.Kd_Urusan 
                AND G.Kd_Bidang = H.Kd_Bidang 
                AND G.Kd_Unit = H.Kd_Unit
                INNER JOIN Ref_Bidang I ON E.Kd_Urusan1 = I.Kd_Urusan 
                AND E.Kd_Bidang1 = I.Kd_Bidang
                INNER JOIN Ref_Urusan J ON I.Kd_Urusan = J.Kd_Urusan 
            ORDER BY
                A.Tgl_Bukti,
                A.Urut,
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

}
