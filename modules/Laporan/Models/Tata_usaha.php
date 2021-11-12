<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Tata Usaha
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Tata_usaha extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Tata Usaha
	 */
	public function register_spp($params)
	{
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $jn_spm										= $params['jn_spm'];
        $kd_edit 									= $params['jn_dok'];
        $kd_jab 									= 2;

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
                A.Uraian,
                A.Nilai_SPP 
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
                    SUM ( CASE '$kd_jab' WHEN '2' THEN A.Nilai ELSE A.Usulan END ) AS Nilai_SPP 
                FROM
                    Ta_SPP_Rinc A
                    INNER JOIN Ta_SPP B ON A.Tahun = B.Tahun 
                    AND A.No_SPP = B.No_SPP 
                WHERE
                    ( B.Tahun = '$tahun' ) 
                    AND ( B.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( B.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( B.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( B.Kd_Sub LIKE '$kd_sub' ) 
                    AND ( B.Kd_Edit LIKE '$kd_edit' ) 
                    AND ( B.Jn_SPP LIKE '$jn_spm' ) 
                    AND ( B.Tgl_SPP BETWEEN '$d1' AND '$d2' ) 
                GROUP BY
                    A.Tahun,
                    A.Kd_Urusan,
                    A.Kd_Bidang,
                    A.Kd_Unit,
                    A.Kd_Sub,
                    B.No_SPP,
                    B.Tgl_SPP,
                    B.Jn_SPP,
                    B.Uraian 
                ) A
                INNER JOIN Ref_Jenis_SPM B ON A.Jn_SPP = B.Jn_SPM,
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
                    G.Nm_Penandatangan,
                    G.Nip_Penandatangan,
                    G.Jbt_Penandatangan 
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
                        MIN ( Nama ) AS Nm_Penandatangan,
                        MIN ( Nip ) AS Nip_Penandatangan,
                        MIN ( Jabatan ) AS Jbt_Penandatangan 
                    FROM
                        Ta_Sub_Unit_Jab A 
                    WHERE
                        ( A.Kd_Jab = '$kd_jab' ) 
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
                ) D,
                (
                SELECT
                CASE
                        '$kd_edit' 
                        WHEN '%' THEN
                        'DRAFT, FINAL, BATAL' ELSE UPPER ( MIN ( A.Nm_Edit ) ) 
                    END AS Status 
                FROM
                    Ref_EditData A 
                WHERE
                    A.Kd_Edit LIKE '$kd_edit' 
                ) E 
            ORDER BY
                A.Tgl_SPP,
                A.No_SPP
        ")
			->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );
		return $output;
	}

    public function spm_anggaran($params)
    {
        $tahun                                      = $params['tahun'];
        $no_spm										= $params['no_spm'];
        $kd_spm										= 1;

        if($kd_spm == 1)
        {
            $tgl_dok								= $this->query
            ("
                SELECT
                    A.Tgl_SPP
                FROM
                     Ta_SPP A
                INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun AND A.No_SPP = B.No_SPP
                WHERE
                    (A.Tahun = '$tahun') AND
                    (B.No_SPM = '$no_spm')
            ")
                ->row('Tgl_SPP');

            $ta_spm								    = $this->query
            ("
                SELECT
                    Kd_Urusan,
                    Kd_Bidang,
                    Kd_Unit,
                    Kd_Sub,
                    Jn_SPM
                FROM
                    Ta_SPM
                WHERE
                    (Tahun = '$tahun') AND
                    (No_SPM = '$no_spm')
            ")
                ->row();

            if($ta_spm->Jn_SPM == 1)
            {
                $no_spd_1							= $this->query
                ("
                    SELECT TOP
                        1 A.No_SPD 
                    FROM
                        Ta_SPD_Rinc A
                        INNER JOIN Ta_SPD B ON A.Tahun = B.Tahun 
                        AND A.No_SPD = B.No_SPD 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan = '$ta_spm->Kd_Urusan' ) 
                        AND ( A.Kd_Bidang = '$ta_spm->Kd_Bidang' ) 
                        AND ( A.Kd_Unit = '$ta_spm->Kd_Unit' ) 
                        AND ( A.Kd_Sub = '$ta_spm->Kd_Sub' ) 
                        AND ( NOT ( ( A.Kd_Prog = 0 ) AND ( A.ID_Prog = 0 ) AND ( A.Kd_Keg = 0 ) ) ) 
                        AND ( B.Tgl_SPD <= '$tgl_dok' ) 
                    ORDER BY
                        B.Tgl_SPD DESC,
                        A.No_SPD DESC
                ")
                    ->row();
            }
            else
            {
                $no_spd_1							= $this->query
                ("
                    SELECT TOP
                        1 A.No_SPD 
                    FROM
                        Ta_SPD_Rinc A
                        INNER JOIN Ta_SPD B ON A.Tahun = B.Tahun 
                        AND A.No_SPD = B.No_SPD
                        INNER JOIN (
                            SELECT
                                Tahun,
                                Kd_Urusan,
                                Kd_Bidang,
                                Kd_Unit,
                                Kd_Sub,
                                Kd_Prog,
                                ID_Prog,
                                Kd_Keg 
                            FROM
                                Ta_SPM_Rinc 
                            WHERE
                                ( Tahun = '$tahun' ) 
                                AND ( No_SPM = '$no_spm' ) 
                            GROUP BY
                                Tahun,
                                Kd_Urusan,
                                Kd_Bidang,
                                Kd_Unit,
                                Kd_Sub,
                                Kd_Prog,
                                ID_Prog,
                                Kd_Keg 
                        ) C ON A.Tahun = C.Tahun 
                        AND A.Kd_Urusan = C.Kd_Urusan 
                        AND A.Kd_Bidang = C.Kd_Bidang 
                        AND A.Kd_Unit = C.Kd_Unit 
                        AND A.Kd_Sub = C.Kd_Sub 
                        AND A.Kd_Prog = C.Kd_Prog 
                        AND A.Id_Prog = C.Id_Prog 
                        AND A.Kd_Keg = C.Kd_Keg 
                    WHERE
                        ( B.Tgl_SPD <= '$tgl_dok' ) 
                    ORDER BY
                        B.Tgl_SPD DESC,
	                A.No_SPD DESC
                ")
                    ->row();
            }

            $data_query								= $this->query
            ("
                SELECT
                    C.No_SPP,
                    C.Tgl_SPP,
                    ISNULL( E.No_SPD, '$no_spd_1->No_SPD' ) AS No_SPD,
                    A.No_SPM,
                CASE
                        WHEN UPPER ( RTRIM( H.Nm_Unit ) ) = UPPER ( RTRIM( G.Nm_Sub_Unit ) ) THEN
                        UPPER ( RTRIM( H.Nm_Unit ) ) ELSE UPPER ( RTRIM( G.Nm_Sub_Unit ) ) + ' ' + UPPER ( RTRIM( H.Nm_Unit ) ) 
                    END AS Nm_Unit,
                    UPPER ( J.Nm_Jn_SPM ) AS Uraian_SPM,
                    B.Tgl_SPM,
                    ISNULL(
                        RIGHT ( '0' + CONVERT ( VARCHAR, L.kd_program90 ), 2 ) + '.' + L.kd_kegiatan90 + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, L.kd_sub_kegiatan ), 2 ) + '.',
                        '' 
                    ) + CONVERT ( VARCHAR, D.Kd_Rek90_1 ) + '.' + CONVERT ( VARCHAR, D.Kd_Rek90_2 ) + '.' + CONVERT ( VARCHAR, D.Kd_Rek90_3 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, D.Kd_Rek90_4 ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, D.Kd_Rek90_5 ), 2 ) + '.' + RIGHT ( '0000' + CONVERT ( VARCHAR, D.Kd_Rek90_6 ), 4 ) AS Kd_Rek_Gab,
                    D.Nm_Rek90_6 AS Nm_Rek_5,
                    A.Nilai,
                    N.Nilai_SPP,
                    B.Uraian,
                    UPPER ( K.Nm_Pemda ) AS Nm_Pemda,
                    B.Bank_Penerima AS Nama_Bank,
                    B.Nm_Penerima,
                    B.Rek_Penerima,
                    B.Nm_Penandatangan,
                    B.Nip_Penandatangan,
                    B.Jbt_Penandatangan,
                    B.NPWP,
                    B.Kd_Edit,
                    K.Ibukota 
                FROM
                    (
                    SELECT
                        A.Tahun,
                        A.No_SPM,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.Id_Prog,
                        A.Kd_Keg,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5,
                        SUM ( A.Nilai ) AS Nilai 
                    FROM
                        Ta_SPM_Rinc A
                        INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                        AND A.No_SPM = B.No_SPM 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( B.No_SPM = '$no_spm' ) 
                        AND ( B.Jn_SPM IN ( 2, 3, 5 ) ) 
                    GROUP BY
                        A.Tahun,
                        A.No_SPM,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.Id_Prog,
                        A.Kd_Keg,
                        A.Kd_Rek_1,
                        A.Kd_Rek_2,
                        A.Kd_Rek_3,
                        A.Kd_Rek_4,
                        A.Kd_Rek_5 UNION ALL
                    SELECT
                        A.Tahun,
                        A.No_SPM,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.Id_Prog,
                        A.Kd_Keg,
                        1 AS Kd_Rek_1,
                        1 AS Kd_Rek_2,
                        1 AS Kd_Rek_3,
                        3 AS Kd_Rek_4,
                        1 AS Kd_Rek_5,
                        SUM ( A.Nilai ) AS Nilai 
                    FROM
                        Ta_SPM_Rinc A
                        INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                        AND A.No_SPM = B.No_SPM 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( B.No_SPM = '$no_spm' ) 
                        AND ( B.Jn_SPM IN ( 1, 4 ) ) 
                    GROUP BY
                        A.Tahun,
                        A.No_SPM,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.Id_Prog,
                        A.Kd_Keg 
                    ) A
                    INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM
                    INNER JOIN Ta_SPP C ON B.Tahun = C.Tahun 
                    AND B.No_SPP = C.No_SPP
                    INNER JOIN ( SELECT Tahun, No_SPP, SUM ( Nilai ) AS Nilai_SPP FROM Ta_SPP_Rinc WHERE ( Tahun = '$tahun' ) GROUP BY Tahun, No_SPP ) N ON C.Tahun = N.Tahun 
                    AND C.No_SPP = N.No_SPP
                    INNER JOIN Ta_Sub_Unit F ON C.Tahun = F.Tahun 
                    AND C.Kd_Urusan = F.Kd_Urusan 
                    AND C.Kd_Bidang = F.Kd_Bidang 
                    AND C.Kd_Unit = F.Kd_Unit 
                    AND C.Kd_Sub = F.Kd_Sub
                    INNER JOIN Ref_Sub_Unit G ON F.Kd_Urusan = G.Kd_Urusan 
                    AND F.Kd_Bidang = G.Kd_Bidang 
                    AND F.Kd_Unit = G.Kd_Unit 
                    AND F.Kd_Sub = G.Kd_Sub
                    INNER JOIN Ref_Unit H ON G.Kd_Urusan = H.Kd_Urusan 
                    AND G.Kd_Bidang = H.Kd_Bidang 
                    AND G.Kd_Unit = H.Kd_Unit
                    INNER JOIN ref_rek_mapping I ON A.Kd_Rek_1 = I.Kd_Rek_1 
                    AND A.Kd_Rek_2 = I.Kd_Rek_2 
                    AND A.Kd_Rek_3 = I.Kd_Rek_3 
                    AND A.Kd_Rek_4 = I.Kd_Rek_4 
                    AND A.Kd_Rek_5 = I.Kd_Rek_5
                    INNER JOIN ref_rek90_6 D ON I.kd_rek90_1 = D.kd_rek90_1 
                    AND I.kd_rek90_2 = D.kd_rek90_2 
                    AND I.kd_rek90_3 = D.kd_rek90_3 
                    AND I.kd_rek90_4 = D.kd_rek90_4 
                    AND I.kd_rek90_5 = D.kd_rek90_5 
                    AND I.kd_rek90_6 = D.kd_rek90_6
                    INNER JOIN Ref_Jenis_SPM J ON B.Jn_SPM = J.Jn_SPM
                    INNER JOIN Ta_Pemda K ON F.Tahun = K.Tahun
                    INNER JOIN Ta_Program O ON A.Tahun = O.Tahun 
                    AND A.Kd_Urusan = O.Kd_Urusan 
                    AND A.Kd_Bidang = O.Kd_Bidang 
                    AND A.Kd_Unit = O.Kd_Unit 
                    AND A.Kd_Sub = O.Kd_Sub 
                    AND A.Kd_Prog = O.Kd_Prog 
                    AND A.ID_Prog = O.ID_Prog
                    LEFT OUTER JOIN ref_kegiatan_mapping L ON O.Kd_Urusan1 = L.kd_urusan 
                    AND O.kd_bidang1 = L.kd_bidang 
                    AND O.kd_prog = L.kd_prog 
                    AND A.kd_keg = L.kd_keg
                    LEFT OUTER JOIN Ta_SPD E ON C.Tahun = E.Tahun 
                    AND C.No_SPD = E.No_SPD 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.No_SPM = '$no_spm' ) 
                ORDER BY
                    Kd_Rek_Gab
            ")
                ->result();

            $potongan_query						    = $this->query
            ("
                SELECT
                    CONVERT
                    ( VARCHAR, B.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_3 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_4 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_5 ) AS Kd_Rek_Gab5,
                    C.Nm_Pot + ISNULL( ' (' + A.Kd_Billing + ')', '' ) AS Nm_Pot,
                    A.Nilai 
                FROM
                    Ta_SPM_Pot A
                    INNER JOIN Ref_Pot_SPM_Rek B ON A.Kd_Pot_Rek = B.Kd_Pot_Rek
                    INNER JOIN Ref_Pot_SPM C ON B.Kd_Pot = C.Kd_Pot 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.No_SPM = '$no_spm' )
            ")
                ->result();

            $informasi_query						= $this->query
            ("
                SELECT
                    A.Kd_Rek_Gab5,
                    B.Nm_Pot,
                    A.Nilai,
                    ISNULL( C.Diminta, 0 ) AS Diminta,
                    ISNULL( D.Potongan, 0 ) AS Potongan,
                CASE
                        '$ta_spm->Jn_SPM' 
                        WHEN 5 THEN
                        0 ELSE ISNULL( C.Diminta, 0 ) - ISNULL( D.Potongan, 0 ) 
                    END AS Dibayarkan 
                FROM
                    (
                    SELECT
                        A.No_SPM,
                        B.Kd_Pot,
                        CONVERT ( VARCHAR, B.Kd_Rek_1 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_2 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_3 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_4 ) + ' . ' + CONVERT ( VARCHAR, B.Kd_Rek_5 ) AS Kd_Rek_Gab5,
                        A.Nilai 
                    FROM
                        Ta_SPM_Info A
                        INNER JOIN Ref_Pot_SPM_Rek B ON A.Kd_Pot_Rek = B.Kd_Pot_Rek 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.No_SPM = '$no_spm' ) 
                    ) A
                    INNER JOIN Ref_Pot_SPM B ON A.Kd_Pot = B.Kd_Pot
                    FULL OUTER JOIN (
                    SELECT
                        A.No_SPM,
                        ISNULL( SUM ( A.Nilai ), 0 ) AS Diminta 
                    FROM
                        Ta_SPM_Rinc A 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.No_SPM = '$no_spm' ) 
                    GROUP BY
                        A.No_SPM 
                    ) C ON A.No_SPM = C.No_SPM
                    FULL OUTER JOIN (
                    SELECT
                        A.No_SPM,
                        ISNULL( SUM ( A.Nilai ), 0 ) AS Potongan 
                    FROM
                        Ta_SPM_Pot A 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.No_SPM = '$no_spm' ) 
                    GROUP BY
                    A.No_SPM 
                    ) D ON C.No_SPM = D.No_SPM
            ")
                ->result();
        }
        else if($kd_spm == 2)
        {
            $data_query								= $this->query
            ("
                SELECT
                    C.No_SPP,
                    C.Tgl_SPP,
                    '' AS No_SPD,
                    A.No_SPM,
                CASE
                        WHEN UPPER ( RTRIM( H.Nm_Unit ) ) = UPPER ( RTRIM( G.Nm_Sub_Unit ) ) THEN
                        UPPER ( RTRIM( H.Nm_Unit ) ) ELSE UPPER ( RTRIM( G.Nm_Sub_Unit ) ) + ' ' + UPPER ( RTRIM( H.Nm_Unit ) ) 
                    END AS Nm_Unit,
                    'Langsung' AS Uraian_SPM,
                    B.Tgl_SPM,
                    CONVERT ( VARCHAR, I.Kd_Rek_1 ) + '.' + CONVERT ( VARCHAR, I.Kd_Rek_2 ) + '.' + CONVERT ( VARCHAR, I.Kd_Rek_3 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Rek_4 ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, I.Kd_Rek_5 ), 2 ) AS Kd_Rek_Gab,
                    I.Nm_Rek_5,
                    A.Nilai,
                    D.Nilai_SPP,
                    B.Uraian,
                    UPPER ( J.Nm_Pemda ) AS Nm_Pemda,
                    B.Bank_Penerima AS Nama_Bank,
                    B.Nm_Penerima,
                    B.Rek_Penerima,
                    B.Nm_Penandatangan,
                    B.Nip_Penandatangan,
                    B.Jbt_Penandatangan,
                    B.NPWP,
                    B.Kd_Edit,
                    J.Ibukota 
                FROM
                    Ta_SPM_Non_Rinc A
                    INNER JOIN Ta_SPM_Non B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM
                    INNER JOIN Ta_SPP_Non C ON B.Tahun = C.Tahun 
                    AND B.No_SPP = C.No_SPP
                    INNER JOIN ( SELECT Tahun, No_SPP, SUM ( Nilai ) AS Nilai_SPP FROM Ta_SPP_Non_Rinc WHERE ( Tahun = '$tahun' ) GROUP BY Tahun, No_SPP ) D ON C.Tahun = D.Tahun 
                    AND C.No_SPP = D.No_SPP
                    INNER JOIN Ref_Sub_Unit G ON B.Kd_Urusan = G.Kd_Urusan 
                    AND B.Kd_Bidang = G.Kd_Bidang 
                    AND B.Kd_Unit = G.Kd_Unit 
                    AND B.Kd_Sub = G.Kd_Sub
                    INNER JOIN Ref_Unit H ON G.Kd_Urusan = H.Kd_Urusan 
                    AND G.Kd_Bidang = H.Kd_Bidang 
                    AND G.Kd_Unit = H.Kd_Unit
                    INNER JOIN Ref_Rek_5 I ON A.Kd_Rek_1 = I.Kd_Rek_1 
                    AND A.Kd_Rek_2 = I.Kd_Rek_2 
                    AND A.Kd_Rek_3 = I.Kd_Rek_3 
                    AND A.Kd_Rek_4 = I.Kd_Rek_4 
                    AND A.Kd_Rek_5 = I.Kd_Rek_5
                    INNER JOIN Ta_Pemda J ON D.Tahun = J.Tahun 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.No_SPM = '$no_spm' ) 
                ORDER BY
                    Kd_Rek_Gab
            ")
                ->result();

            $potongan_query						    = $this->query
            ("
                SELECT
                    NULL  AS Kd_Rek_Gab5,
                    NULL AS Nm_Pot,
                    NULL AS Nilai
		        FROM
                    Ta_SPM_Non A
		        WHERE
                    (A.Tahun = '$tahun') AND
                    (A.No_SPM = '$no_spm')
            ")
                ->result();

            $informasi_query						= $this->query
            ("
                SELECT
                    NULL AS
                    Kd_Rek_Gab5,
                    NULL AS Nm_Pot,
                    NULL AS Nilai,
                    ISNULL( C.Diminta, 0 ) AS Diminta,
                    ISNULL( C.Diminta, 0 ) - ISNULL( C.Diminta, 0 ) AS Potongan,
                    ISNULL( C.Diminta, 0 ) AS Dibayarkan 
                FROM
                    (
                    SELECT
                        A.No_SPM,
                        ISNULL( SUM ( A.Nilai ), 0 ) AS Diminta 
                    FROM
                        Ta_SPM_Non_Rinc A 
                    WHERE
                        A.Tahun = '$tahun' 
                        AND A.No_SPM = '$no_spm' 
                    GROUP BY
                    A.No_SPM 
                    ) C
            ")
                ->result();
        }

        $output										= array
        (
            'data_query'							=> $data_query,
            'potongan_query'						=> $potongan_query,
            'informasi_query'						=> $informasi_query,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_spm($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $jn_spm										= $params['jn_spm'];
        $kd_edit 									= $params['jn_dok'];

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
                A.Tgl_SPM,
                A.No_SPM,
                B.Nm_Jn_SPM,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan,
                D.Nm_Penandatangan,
                D.Nip_Penandatangan,
                D.Jbt_Penandatangan,
                A.Uraian,
                A.Nilai_SPM 
            FROM
                (
                SELECT
                    A.Tahun,
                    A.Kd_Urusan,
                    A.Kd_Bidang,
                    A.Kd_Unit,
                    A.Kd_Sub,
                    B.No_SPM,
                    B.Tgl_SPM,
                    B.Jn_SPM,
                    B.Uraian,
                    SUM ( A.Nilai ) AS Nilai_SPM 
                FROM
                    Ta_SPM_Rinc A
                    INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM 
                WHERE
                    ( B.Tahun = '$tahun' ) 
                    AND ( B.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( B.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( B.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( B.Kd_Sub LIKE '$kd_sub' ) 
                    AND ( B.Kd_Edit LIKE '$kd_edit' ) 
                    AND ( B.Jn_SPM LIKE '$jn_spm' ) 
                    AND ( B.Tgl_SPM BETWEEN '$d1' AND '$d2' ) 
                GROUP BY
                    A.Tahun,
                    A.Kd_Urusan,
                    A.Kd_Bidang,
                    A.Kd_Unit,
                    A.Kd_Sub,
                    B.No_SPM,
                    B.Tgl_SPM,
                    B.Jn_SPM,
                    B.Uraian 
                ) A
                INNER JOIN Ref_Jenis_SPM B ON A.Jn_SPM = B.Jn_SPM,
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
                    G.Nm_Penandatangan,
                    G.Nip_Penandatangan,
                    G.Jbt_Penandatangan 
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
                        MIN ( Nama ) AS Nm_Penandatangan,
                        MIN ( Nip ) AS Nip_Penandatangan,
                        MIN ( Jabatan ) AS Jbt_Penandatangan 
                    FROM
                        Ta_Sub_Unit_Jab A 
                    WHERE
                        ( A.Kd_Jab = 2 ) 
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
                ) D,
                (
                SELECT
                CASE
                        '$kd_edit' 
                        WHEN '%' THEN
                        'DRAFT, FINAL, BATAL' ELSE UPPER ( MIN ( A.Nm_Edit ) ) 
                    END AS Status 
                FROM
                    Ref_EditData A 
                WHERE
                    A.Kd_Edit LIKE '$kd_edit' 
                ) E 
            ORDER BY
                A.Tgl_SPM,
                A.No_SPM,
                A.Kd_Urusan,
                A.Kd_Bidang,
                A.Kd_Unit,
                A.Kd_Sub
        ")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );
        return $output;
    }

    public function register_penolakan_penerbitan_spm($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

/*        $data_query								    = $this->query
        ("

        ")
            ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_penerimaan_spj($params)
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
                A.Tgl_SPJ,
                A.No_SPJ,
                A.Keterangan,
                A.Total,
                B.Nm_Pimpinan,
                B.Nip_Pimpinan,
                B.Jbt_Pimpinan,
                B.Nm_PPK_SKPD,
                B.Nip_PPK_SKPD,
                B.Jbt_PPK_SKPD 
            FROM
                (
                SELECT
                    B.Tgl_SPJ,
                    B.No_SPJ,
                    B.Keterangan,
                    SUM ( A.Nilai ) AS Total 
                FROM
                    Ta_SPJ_Rinc A
                    INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_SPJ = B.No_SPJ 
                WHERE
                    ( B.Tgl_SPJ BETWEEN '$d1' AND '$d2' ) 
                    AND ( B.Tahun = '$tahun' ) 
                    AND ( B.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( B.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( B.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( B.Kd_Sub LIKE '$kd_sub' ) 
                GROUP BY
                    B.Tgl_SPJ,
                    B.No_SPJ,
                    B.Keterangan 
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
                    G.Nm_PPK_SKPD,
                    G.Nip_PPK_SKPD,
                    G.Jbt_PPK_SKPD 
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
                        MIN ( Nama ) AS Nm_PPK_SKPD,
                        MIN ( Nip ) AS Nip_PPK_SKPD,
                        MIN ( Jabatan ) AS Jbt_PPK_SKPD 
                    FROM
                        Ta_Sub_Unit_Jab A 
                    WHERE
                        ( A.Kd_Jab = 2 ) 
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
                A.Tgl_SPJ,
                A.No_SPJ
        ")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_pengesahan_spj($params)
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
                A.Tgl_Pengesahan,
                A.No_Pengesahan,
                A.Keterangan,
                A.Total,
                B.Nm_Pimpinan,
                B.Nip_Pimpinan,
                B.Jbt_Pimpinan,
                B.Nm_PPK_SKPD,
                B.Nip_PPK_SKPD,
                B.Jbt_PPK_SKPD 
            FROM
                (
                SELECT
                    B.Tgl_Pengesahan,
                    B.No_Pengesahan,
                    B.Keterangan,
                    SUM ( A.Nilai_Setuju ) AS Total 
                FROM
                    Ta_Pengesahan_SPJ_Rinc A
                    INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_Pengesahan = B.No_Pengesahan 
                WHERE
                    ( B.Tgl_Pengesahan BETWEEN '$d1' AND '$d2' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                    AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                    AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                    AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                GROUP BY
                    B.Tgl_Pengesahan,
                    B.No_Pengesahan,
                    B.Keterangan 
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
                    G.Nm_PPK_SKPD,
                    G.Nip_PPK_SKPD,
                    G.Jbt_PPK_SKPD 
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
                        MIN ( Nama ) AS Nm_PPK_SKPD,
                        MIN ( Nip ) AS Nip_PPK_SKPD,
                        MIN ( Jabatan ) AS Jbt_PPK_SKPD 
                    FROM
                        Ta_Sub_Unit_Jab A 
                    WHERE
                        ( A.Kd_Jab = 2 ) 
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
                A.Tgl_Pengesahan,
                A.No_Pengesahan
        ")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_penolakan_spj($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

/*        $data_query								    = $this->query
        ("

        ")
            ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_sp2d($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $jn_spm										= $params['jn_spm'];

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
                A.Tgl_SP2D,
                A.No_SP2D,
                B.Nm_Jn_SPM,
                C.Nm_Ka_BUD,
                C.Nip_Ka_BUD,
                C.Jbt_Ka_BUD,
                A.Uraian,
                A.Nilai_SPM 
            FROM
                (
                SELECT
                    A.Tahun,
                    A.Kd_Urusan,
                    A.Kd_Bidang,
                    A.Kd_Unit,
                    A.Kd_Sub,
                    A.Jn_SPM,
                    A.Uraian,
                    B.No_SP2D,
                    B.Tgl_SP2D,
                    A.Nilai_SPM 
                FROM
                    (
                    SELECT
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        B.No_SPM,
                        B.Tgl_SPM,
                        B.Jn_SPM,
                        B.Uraian,
                        SUM ( A.Nilai ) AS Nilai_SPM 
                    FROM
                        Ta_SPM_Rinc A
                        INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                        AND A.No_SPM = B.No_SPM 
                    WHERE
                        ( B.Tahun = '$tahun' ) 
                        AND ( B.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( B.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( B.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( B.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( B.Jn_SPM LIKE '$jn_spm' ) 
                    GROUP BY
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        B.No_SPM,
                        B.Tgl_SPM,
                        B.Jn_SPM,
                        B.Uraian 
                    ) A
                    INNER JOIN Ta_SP2D B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM 
                WHERE
                    ( B.Tgl_SP2D BETWEEN '$d1' AND '$d2' ) 
                ) A
                INNER JOIN Ref_Jenis_SPM B ON A.Jn_SPM = B.Jn_SPM
                INNER JOIN Ta_Pemda C ON A.Tahun = C.Tahun,
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
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab 
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

    public function register_sp2d_tu($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

        /*        $data_query								    = $this->query
                ("

                ")
                    ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_spj_sp2d($params)
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
                C.Kd_UrusanA,
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
                A.No_SPJ,
                A.Tgl_SPJ,
                A.Nilai,
                A.No_SPP,
                A.Tgl_SPP,
                A.No_SPM,
                A.Tgl_SPM,
                A.No_SP2D,
                A.Tgl_SP2D 
            FROM
                (
                SELECT
                    A.Tahun,
                    A.No_SPJ,
                    A.Tgl_SPJ,
                    A.Nilai,
                    ISNULL( C.No_SPP, '' ) AS No_SPP,
                    C.Tgl_SPP,
                    ISNULL( D.No_SPM, '' ) AS No_SPM,
                    D.Tgl_SPM,
                    ISNULL( E.No_SP2D, '' ) AS No_SP2D,
                    E.Tgl_SP2D 
                FROM
                    (
                    SELECT
                        A.Tahun,
                        A.No_SPJ,
                        B.Tgl_SPJ,
                        SUM ( A.Nilai ) AS Nilai 
                    FROM
                        Ta_SPJ_Rinc A
                        INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                        AND A.No_SPJ = B.No_SPJ 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( B.Tgl_SPJ BETWEEN '$d1' AND '$d2' ) 
                    GROUP BY
                        A.Tahun,
                        A.No_SPJ,
                        B.Tgl_SPJ 
                    ) A
                    LEFT OUTER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_SPJ = B.No_SPJ
                    LEFT OUTER JOIN Ta_SPP C ON B.Tahun = C.Tahun 
                    AND B.No_Pengesahan = C.No_SPJ
                    LEFT OUTER JOIN Ta_SPM D ON C.Tahun = D.Tahun 
                    AND C.No_SPP = D.No_SPP
                    LEFT OUTER JOIN Ta_SP2D E ON D.Tahun = E.Tahun 
                    AND D.No_SPM = E.No_SPM 
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
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab 
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
                ) C 
            ORDER BY
            CASE
                    
                    WHEN A.No_SP2D = '' THEN
                    1 
                    WHEN A.No_SPM = '' THEN
                    2 
                    WHEN A.No_SPP = '' THEN
                    3 ELSE 4 
                END,
            CASE
                
                WHEN A.No_SPM = '' THEN
                1 
                WHEN A.No_SPP = '' THEN
                2 ELSE 3 
                END,
            CASE
                
                WHEN A.No_SPP = '' THEN
                1 ELSE 2 
                END,
                A.Tgl_SPJ,
                A.No_SPJ,
                A.Tgl_SPP,
                A.No_SPP,
                A.Tgl_SPM,
                A.No_SPM,
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

    public function register_spp_sp2d($params)
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
                C.Kd_UrusanA,
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
                A.No_SPP,
                A.Tgl_SPP,
                A.Nilai_SPP,
                A.No_SPM,
                A.Tgl_SPM,
                A.Nilai_SPM,
                A.No_SP2D,
                A.Tgl_SP2D 
            FROM
                (
                SELECT
                    A.Tahun,
                    A.No_SPP,
                    A.Tgl_SPP,
                    A.Nilai_SPP,
                    ISNULL( B.No_SPM, '' ) AS No_SPM,
                    B.Tgl_SPM,
                    B.Nilai_SPM,
                    ISNULL( C.No_SP2D, '' ) AS No_SP2D,
                    C.Tgl_SP2D 
                FROM
                    (
                    SELECT
                        A.Tahun,
                        A.No_SPP,
                        B.Tgl_SPP,
                        SUM ( A.Nilai ) AS Nilai_SPP 
                    FROM
                        Ta_SPP_Rinc A
                        INNER JOIN Ta_SPP B ON A.Tahun = B.Tahun 
                        AND A.No_SPP = B.No_SPP 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                        AND ( B.Tgl_SPP BETWEEN '$d1' AND '$d2' ) 
                        AND ( B.Jn_SPP IN ( 1, 3, 4 ) ) 
                    GROUP BY
                        A.Tahun,
                        A.No_SPP,
                        B.Tgl_SPP 
                    ) A
                    LEFT OUTER JOIN (
                    SELECT
                        A.Tahun,
                        A.No_SPM,
                        B.Tgl_SPM,
                        B.No_SPP,
                        SUM ( A.Nilai ) AS Nilai_SPM 
                    FROM
                        Ta_SPM_Rinc A
                        INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                        AND A.No_SPM = B.No_SPM 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                    GROUP BY
                        A.Tahun,
                        A.No_SPM,
                        B.Tgl_SPM,
                        B.No_SPP 
                    ) B ON A.Tahun = B.Tahun 
                    AND A.No_SPP = B.No_SPP
                    LEFT OUTER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                    AND B.No_SPM = C.No_SPM 
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
                    B.Nm_Sub_Unit AS Nm_Sub_Unit_Gab 
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
                ) C 
            ORDER BY
            CASE
                    
                    WHEN A.No_SP2D = '' THEN
                    1 
                    WHEN A.No_SPM = '' THEN
                    2 
                    WHEN A.No_SPP = '' THEN
                    3 ELSE 4 
                END,
            CASE
                
                WHEN A.No_SPM = '' THEN
                1 
                WHEN A.No_SPP = '' THEN
                2 ELSE 3 
                END,
            CASE
                
                WHEN A.No_SPP = '' THEN
                1 ELSE 2 
                END,
                A.Tgl_SPP,
                A.No_SPP,
                A.Tgl_SPM,
                A.No_SPM,
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

    // jumlah sp2d belum
    public function pengesahan_spj($params)
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
    public function laporan_pengesahan_spj($params)
    {
        $tahun                                      = $params['tahun'];
        $no_pengesahan								= $params['no_pengesahan'];

        $peny_query								    = $this->query
        ('
			SELECT
				Peny_SPJ
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $tahun . '
		')
            ->row('Peny_SPJ');

        $pengesahan_query							= $this->query
        ("
            SELECT
                B.Kd_Urusan,
                B.Kd_Bidang,
                B.Kd_Unit,
                B.Kd_Sub,
                A.Tgl_Pengesahan,
                A.No_SPJ,
                A.No_Pengesahan
            FROM
                Ta_Pengesahan_SPJ A
            INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                AND A.No_SPJ = B.No_SPJ 
            WHERE
                A.Tahun = '$tahun' 
            AND A.No_Pengesahan = '$no_pengesahan'
		")
            ->row();

        $tgl_pengesahan_lalu_query					= $this->query
        ("
            SELECT
                A.Tgl_Pengesahan 
            FROM
                (
                SELECT TOP
                    1 Tgl_Pengesahan 
                FROM
                    Ta_Pengesahan_SPJ A
                    INNER JOIN Ta_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_SPJ = B.No_SPJ 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( B.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( B.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( B.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( B.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                    AND ( ( A.Tgl_Pengesahan < '$pengesahan_query->Tgl_Pengesahan' ) OR ( ( A.Tgl_Pengesahan = '$pengesahan_query->Tgl_Pengesahan' ) AND ( A.No_Pengesahan < '$pengesahan_query->No_Pengesahan' ) ) ) 
                ORDER BY
                    A.Tgl_Pengesahan DESC,
                A.No_Pengesahan DESC 
                ) A
		")
            ->row('A.Tgl_Pengesahan ');

        $tmpspj								        =
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
                A.Kd_Rek_1,
                A.Kd_Rek_2,
                A.Kd_Rek_3,
                A.Kd_Rek_4,
                A.Kd_Rek_5,
                SUM ( Anggaran ) AS Anggaran,
                SUM ( A.SPJ_L ) AS SPJ_L,
                SUM ( A.SPJ_I_LS ) AS SPJ_I_LS,
                SUM ( A.SPJ_I_GU ) AS SPJ_I_GU 
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
                    A.Total AS Anggaran,
                    0 AS SPJ_L,
                    0 AS SPJ_I_LS,
                    0 AS SPJ_I_GU 
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
                            AND ( Tahun = '$tahun' ) 
                            AND ( Tgl_Perda <= '$pengesahan_query->Tgl_Pengesahan' ) 
                        ) 
                    ) 
                    AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) UNION ALL
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
                    0,
                    A.Nilai_Setuju,
                    0,
                    0 
                FROM
                    Ta_Pengesahan_SPJ_Rinc A
                    INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_Pengesahan = B.No_Pengesahan 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                    AND ( ( B.Tgl_Pengesahan < '$pengesahan_query->Tgl_Pengesahan' ) OR ( B.Tgl_Pengesahan = '$pengesahan_query->Tgl_Pengesahan' AND B.No_Pengesahan < '$pengesahan_query->No_Pengesahan' ) ) UNION ALL
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
                    0,
                    A.Nilai,
                    0,
                    0 
                FROM
                    Ta_SPM_Rinc A
                    INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM
                    INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                    AND B.No_SPM = C.No_SPM 
                WHERE
                    ( B.Jn_SPM = 3 ) 
                    AND ( B.Kd_Edit <> 2 ) 
                    AND ( C.Tgl_SP2D <= '$tgl_pengesahan_lalu_query' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                    AND ( A.Kd_Rek_1 = 5 ) UNION ALL
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
                    0,
                    0,
                    A.Nilai,
                    0 
                FROM
                    Ta_SPM_Rinc A
                    INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                    AND A.No_SPM = B.No_SPM
                    INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                    AND B.No_SPM = C.No_SPM 
                WHERE
                    ( B.Jn_SPM = 3 ) 
                    AND ( B.Kd_Edit <> 2 ) 
                    AND ( C.Tgl_SP2D BETWEEN '$tgl_pengesahan_lalu_query' + 1 AND '$pengesahan_query->Tgl_Pengesahan' ) 
                    AND ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                    AND ( A.Kd_Rek_1 = 5 ) UNION ALL
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
                    0,
                    0,
                    0,
                    A.Nilai_Setuju 
                FROM
                    Ta_Pengesahan_SPJ_Rinc A
                    INNER JOIN Ta_Pengesahan_SPJ B ON A.Tahun = B.Tahun 
                    AND A.No_Pengesahan = B.No_Pengesahan 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( B.No_Pengesahan = '$pengesahan_query->No_Pengesahan' ) UNION ALL
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
                    0,
                CASE
                        A.D_K 
                        WHEN 'D' THEN
                        A.Nilai ELSE - A.Nilai 
                    END,
                    0,
                    0 
                FROM
                    Ta_Penyesuaian_Rinc A
                    INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                    AND A.No_Bukti = B.No_Bukti 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                    AND ( B.Jns_P1 = 1 ) 
                    AND ( B.Tgl_Bukti <= '$tgl_pengesahan_lalu_query' ) UNION ALL
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
                    0,
                    0,
                CASE
                        B.Jn_SPM 
                        WHEN 3 THEN
                    CASE
                            A.D_K 
                            WHEN 'D' THEN
                            A.Nilai ELSE - A.Nilai 
                        END ELSE 0 
                    END,
                CASE
                        B.Jn_SPM 
                        WHEN 3 THEN
                        0 ELSE
                    CASE
                            A.D_K 
                            WHEN 'D' THEN
                            A.Nilai ELSE - A.Nilai 
                        END 
                        END 
                        FROM
                            Ta_Penyesuaian_Rinc A
                            INNER JOIN Ta_Penyesuaian B ON A.Tahun = B.Tahun 
                            AND A.No_Bukti = B.No_Bukti 
                        WHERE
                            ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                            AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                            AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                            AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                            AND ( B.Jns_P1 = 1 ) 
                            AND ( B.Tgl_Bukti BETWEEN '$tgl_pengesahan_lalu_query' + 1 AND '$pengesahan_query->Tgl_Pengesahan' ) UNION ALL
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
                            0,
                        CASE
                                A.D_K 
                                WHEN 'D' THEN
                                A.Nilai ELSE - A.Nilai 
                            END,
                            0,
                            0 
                        FROM
                            Ta_Jurnal_Rinc A
                            INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                            AND A.No_Bukti = B.No_Bukti 
                        WHERE
                            ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                            AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                            AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                            AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                            AND ( B.Tgl_Bukti <= '$tgl_pengesahan_lalu_query' ) 
                            AND ( A.Kd_Rek_1 = 5 ) 
                            AND ( '$peny_query' = 1 ) 
                            AND ( B.No_BKU <> 9999 ) UNION ALL
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
                            0,
                            0,
                        CASE
                                A.D_K 
                                WHEN 'D' THEN
                                A.Nilai ELSE - A.Nilai 
                            END,
                            0 
                        FROM
                            Ta_Jurnal_Rinc A
                            INNER JOIN Ta_Jurnal B ON A.Tahun = B.Tahun 
                            AND A.No_Bukti = B.No_Bukti 
                        WHERE
                            ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                            AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                            AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                            AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                            AND ( B.Tgl_Bukti BETWEEN '$tgl_pengesahan_lalu_query' + 1 AND '$pengesahan_query->Tgl_Pengesahan' ) 
                            AND ( A.Kd_Rek_1 = 5 ) 
                            AND ( '$peny_query' = 1 ) 
                            AND ( B.No_BKU <> 9999 ) 
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
		");

        $data_query								    = $this->query
        ("
            SELECT
                L.kd_program,
                L.kd_kegiatan,
                L.kd_sub_kegiatan,
                E.Kd_Gab_Bidang,
                E.Kd_Gab_Unit,
                E.Kd_Gab_Sub,
                RIGHT ( '0' + CONVERT ( VARCHAR, L.kd_program ), 2 ) AS Kd_Gab_Prog,
                RIGHT ( '0' + CONVERT ( VARCHAR, L.kd_program ), 2 ) + ' . ' + L.kd_kegiatan AS Kd_Gab_Keg,
                RIGHT ( '0' + CONVERT ( VARCHAR, L.kd_program ), 2 ) + ' . ' + L.kd_kegiatan + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, L.kd_sub_kegiatan ), 2 ) AS Kd_Gab_Sub_Keg,
                E.Nm_Bidang_Gab,
                E.Nm_Unit_Gab,
                E.Nm_Sub_Unit_Gab,
                N.nm_Program,
                M.nm_Kegiatan,
                L.nm_sub_kegiatan,
                '$pengesahan_query->Tgl_Pengesahan' AS Tgl_Pengesahan,
                E.Nm_Pimpinan,
                E.Nip_Pimpinan,
                E.Jbt_Pimpinan,
                E.Nm_Bendahara,
                E.Nip_Bendahara,
                E.Jbt_Bendahara,
                A.Kode,
            CASE
                    A.Kode 
                    WHEN 1 THEN
                    'I.  Yang Di-SPJ-kan saat ini' ELSE 'II. Yang Tidak Di-SPJ-kan saat ini' 
                END AS Nm_Kode, '$pengesahan_query->No_SPJ' AS No_SPJ,
                CONVERT ( VARCHAR, D.Kd_Rek90_1 ) + '.' + CONVERT ( VARCHAR, D.Kd_Rek90_2 ) + '.' + CONVERT ( VARCHAR, D.Kd_Rek90_3 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, D.Kd_Rek90_4 ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, D.Kd_Rek90_5 ), 2 ) + '.' + RIGHT ( '0000' + CONVERT ( VARCHAR, D.Kd_Rek90_6 ), 4 ) AS Kd_Gab_Rek,
                O.Nm_Rek90_6,
                A.Anggaran,
                A.SPJ_L,
                A.SPJ_I_LS,
                A.SPJ_I_GU,
                A.SPJ_L + A.SPJ_I_LS + A.SPJ_I_GU AS SPJ_T,
                A.Anggaran - ( A.SPJ_L + A.SPJ_I_LS + A.SPJ_I_GU ) AS Sisa,
                I.Ibukota 
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
                    A.Anggaran,
                    A.SPJ_L,
                    A.SPJ_I_LS,
                    A.SPJ_I_GU,
                    1 AS Kode 
                FROM
                    ($tmpspj) AS A
                    INNER JOIN (
                    SELECT
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.ID_Prog,
                        A.Kd_Keg 
                    FROM
                        Ta_Pengesahan_SPJ_Rinc A 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.No_Pengesahan = '$pengesahan_query->No_Pengesahan' ) 
                    GROUP BY
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.ID_Prog,
                        A.Kd_Keg 
                    ) B ON A.Tahun = B.Tahun 
                    AND A.Kd_Urusan = B.Kd_Urusan 
                    AND A.Kd_Bidang = B.Kd_Bidang 
                    AND A.Kd_Unit = B.Kd_Unit 
                    AND A.Kd_Sub = B.Kd_Sub 
                    AND A.Kd_Prog = B.Kd_Prog 
                    AND A.ID_Prog = B.ID_Prog 
                    AND A.Kd_Keg = B.Kd_Keg UNION ALL
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
                    A.Anggaran,
                    A.SPJ_L,
                    A.SPJ_I_LS,
                    A.SPJ_I_GU,
                    2 AS Kode 
                FROM
                    ($tmpspj) AS A
                    LEFT OUTER JOIN (
                    SELECT
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.ID_Prog,
                        A.Kd_Keg 
                    FROM
                        Ta_Pengesahan_SPJ_Rinc A 
                    WHERE
                        ( A.Tahun = '$tahun' ) 
                        AND ( A.No_Pengesahan = '$pengesahan_query->No_Pengesahan' ) 
                    GROUP BY
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.ID_Prog,
                        A.Kd_Keg 
                    ) B ON A.Tahun = B.Tahun 
                    AND A.Kd_Urusan = B.Kd_Urusan 
                    AND A.Kd_Bidang = B.Kd_Bidang 
                    AND A.Kd_Unit = B.Kd_Unit 
                    AND A.Kd_Sub = B.Kd_Sub 
                    AND A.Kd_Prog = B.Kd_Prog 
                    AND A.ID_Prog = B.ID_Prog 
                    AND A.Kd_Keg = B.Kd_Keg 
                WHERE
                    B.Tahun IS NULL 
                ) A
                INNER JOIN ref_rek_mapping D ON A.kd_rek_1 = D.kd_rek_1 
                AND A.kd_rek_2 = D.kd_rek_2 
                AND A.kd_rek_3 = D.kd_rek_3 
                AND A.kd_rek_4 = D.kd_rek_4 
                AND A.kd_rek_5 = D.kd_rek_5
                INNER JOIN ref_rek90_6 O ON D.kd_rek90_1 = O.kd_rek90_1 
                AND D.kd_rek90_2 = O.kd_rek90_2 
                AND D.kd_rek90_3 = O.kd_rek90_3 
                AND D.kd_rek90_4 = O.kd_rek90_4 
                AND D.kd_rek90_5 = O.kd_rek90_5 
                AND D.kd_rek90_6 = O.kd_rek90_6
                INNER JOIN ta_program C ON A.tahun = C.tahun 
                AND A.kd_urusan = C.kd_urusan 
                AND A.kd_bidang = C.kd_bidang 
                AND A.kd_unit = C.kd_unit 
                AND A.kd_sub = C.kd_sub 
                AND A.kd_prog = C.kd_prog 
                AND A.id_prog = C.id_prog
                INNER JOIN ref_kegiatan_mapping B ON C.kd_urusan1 = B.kd_urusan 
                AND C.kd_bidang1 = B.kd_bidang 
                AND C.kd_prog = B.kd_prog 
                AND A.kd_keg = B.kd_keg
                INNER JOIN ref_sub_kegiatan90 L ON B.kd_urusan90 = L.kd_urusan 
                AND B.kd_bidang90 = L.kd_bidang 
                AND B.kd_program90 = L.kd_program 
                AND B.kd_kegiatan90 = L.kd_kegiatan 
                AND B.kd_sub_kegiatan = L.kd_sub_kegiatan
                INNER JOIN ref_kegiatan90 M ON L.kd_urusan = M.kd_urusan 
                AND L.kd_bidang = M.kd_bidang 
                AND L.kd_program = M.kd_program 
                AND L.kd_kegiatan = M.kd_kegiatan
                INNER JOIN ref_program90 N ON M.kd_urusan = N.kd_urusan 
                AND M.kd_bidang = N.kd_bidang 
                AND M.kd_program = N.kd_program
                INNER JOIN Ta_Pemda I ON A.Tahun = I.Tahun,
                (
                SELECT CONVERT
                    ( VARCHAR, D.Kd_Urusan ) + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, D.Kd_Bidang ), 2 ) AS Kd_Gab_Bidang,
                    C.kd_unit90 AS Kd_Gab_Unit,
                    C.kd_unit90 + ' . ' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Sub ), 2 ) AS Kd_Gab_Sub,
                    E.Nm_Urusan + ' ' + D.Nm_Bidang AS Nm_Bidang_Gab,
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
                    INNER JOIN ref_bidang_mapping CC ON C.kd_urusan = CC.kd_urusan 
                    AND C.kd_bidang = CC.kd_bidang
                    INNER JOIN ref_bidang90 D ON CC.kd_urusan90 = D.kd_urusan 
                    AND CC.kd_bidang90 = D.kd_bidang
                    INNER JOIN ref_urusan90 E ON D.kd_urusan = E.kd_urusan
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
                        AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                        AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                        AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                        AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                    GROUP BY
                        Tahun,
                        Kd_Urusan,
                        Kd_Bidang,
                        Kd_Unit,
                        Kd_Sub 
                    ) G ON A.Tahun = G.Tahun 
                    AND A.Kd_Urusan = G.Kd_Urusan 
                    AND A.Kd_Bidang = G.Kd_Bidang 
                    AND A.Kd_Unit = G.Kd_Unit 
                    AND A.Kd_Sub = G.Kd_Sub 
                WHERE
                    ( A.Tahun = '$tahun' ) 
                    AND ( A.Kd_Urusan = '$pengesahan_query->Kd_Urusan' ) 
                    AND ( A.Kd_Bidang = '$pengesahan_query->Kd_Bidang' ) 
                    AND ( A.Kd_Unit = '$pengesahan_query->Kd_Unit' ) 
                    AND ( A.Kd_Sub = '$pengesahan_query->Kd_Sub' ) 
                ) E 
            ORDER BY
                A.Kode,
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
        ")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'no_pengesahan'							=> $no_pengesahan,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    // jumlah REALISASI belum
    public function pengawasan_anggaran($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];

        $peny_query								    = $this->query
        ('
			SELECT
				Peny_SPJ
			FROM
				Ref_Setting
			WHERE
				Tahun = ' . $tahun . '
		')
            ->row('Peny_SPJ');

        $kd_perubahan_query							= $this->query
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
                CONVERT ( VARCHAR, C.Kd_Urusan1 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, C.Kd_Bidang1 ), 2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Bidang ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Unit ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Sub ), 2 ) + ' . ' +
            CASE
                    LEN( CONVERT ( VARCHAR, A.Kd_Prog ) ) 
                    WHEN 3 THEN
                    CONVERT ( VARCHAR, A.Kd_Prog ) ELSE RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Prog ), 2 ) 
                END AS Kd_Gab_Prog,
                CONVERT ( VARCHAR, C.Kd_Urusan1 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, C.Kd_Bidang1 ), 2 ) + ' . ' + CONVERT ( VARCHAR, A.Kd_Urusan ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Bidang ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Unit ), 2 ) + '.' + RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Sub ), 2 ) + ' . ' +
            CASE
                    LEN( CONVERT ( VARCHAR, A.Kd_Prog ) ) 
                    WHEN 3 THEN
                    CONVERT ( VARCHAR, A.Kd_Prog ) ELSE RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Prog ), 2 ) 
                END + '.' +
            CASE
                LEN( CONVERT ( VARCHAR, A.Kd_Keg ) ) 
                WHEN 3 THEN
                CONVERT ( VARCHAR, A.Kd_Keg ) ELSE RIGHT ( '0' + CONVERT ( VARCHAR, A.Kd_Keg ), 2 ) 
                END AS Kd_Gab_Keg,
                C.Ket_Program,
                B.Ket_Kegiatan,
                A.Anggaran,
                A.S_BL1,
                A.S_BL2,
                A.S_BL3,
                A.S_BL1 + A.S_BL2 + A.S_BL3 AS S_Total,
                A.Anggaran - ( A.S_BL1 + A.S_BL2 + A.S_BL3 ) AS Sisa,
                D.Nm_Pimpinan,
                D.Nip_Pimpinan,
                D.Jbt_Pimpinan 
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
                    SUM ( A.Anggaran ) AS Anggaran,
                    SUM ( A.S_BL1 ) AS S_BL1,
                    SUM ( A.S_BL2 ) AS S_BL2,
                    SUM ( A.S_BL3 ) AS S_BL3 
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
                        SUM ( A.Total ) AS Anggaran,
                        0 AS S_BL1,
                        0 AS S_BL2,
                        0 AS S_BL3 
                    FROM
                        Ta_RASK_Arsip A 
                    WHERE
                        ( A.Kd_Perubahan = '$kd_perubahan_query' ) 
                        AND ( A.Kd_Rek_1 = 5 ) 
                        AND ( A.Kd_Rek_2 = 2 ) 
                        AND ( A.Tahun = '$tahun' ) 
                        AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                        AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                        AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                        AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                    GROUP BY
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.ID_Prog,
                        A.Kd_Keg UNION ALL
                    SELECT
                        A.Tahun,
                        A.Kd_Urusan,
                        A.Kd_Bidang,
                        A.Kd_Unit,
                        A.Kd_Sub,
                        A.Kd_Prog,
                        A.ID_Prog,
                        A.Kd_Keg,
                        0 AS Anggaran,
                        SUM ( A.S_BL1 ) AS S_BL1,
                        SUM ( A.S_BL2 ) AS S_BL2,
                        SUM ( A.S_BL3 ) AS S_BL3 
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
                            SUM ( CASE WHEN A.Kd_Rek_1 = 5 AND A.Kd_Rek_2 = 2 AND A.Kd_Rek_3 = 1 THEN A.Nilai ELSE 0 END ) AS S_BL1,
                            SUM ( CASE WHEN A.Kd_Rek_1 = 5 AND A.Kd_Rek_2 = 2 AND A.Kd_Rek_3 = 2 THEN A.Nilai ELSE 0 END ) AS S_BL2,
                            SUM ( CASE WHEN A.Kd_Rek_1 = 5 AND A.Kd_Rek_2 = 2 AND A.Kd_Rek_3 = 3 THEN A.Nilai ELSE 0 END ) AS S_BL3 
                        FROM
                            Ta_SPM_Rinc A
                            INNER JOIN Ta_SPM B ON A.Tahun = B.Tahun 
                            AND A.No_SPM = B.No_SPM
                            INNER JOIN Ta_SP2D C ON B.Tahun = C.Tahun 
                            AND B.No_SPM = C.No_SPM 
                        WHERE
                            ( A.Tahun = '$tahun' ) 
                            AND ( A.Kd_Urusan LIKE '$kd_urusan' ) 
                            AND ( A.Kd_Bidang LIKE '$kd_bidang' ) 
                            AND ( A.Kd_Unit LIKE '$kd_unit' ) 
                            AND ( A.Kd_Sub LIKE '$kd_sub' ) 
                            AND ( B.Kd_Edit = 1 ) 
                            AND ( C.Tgl_SP2D <= '$d1' ) 
                            AND ( A.Kd_Rek_1 = 5 ) 
                            AND ( A.Kd_Rek_2 = 2 ) 
                            AND ( B.Jn_SPM IN ( 2, 3, 5 ) ) 
                        GROUP BY
                            A.Tahun,
                            A.Kd_Urusan,
                            A.Kd_Bidang,
                            A.Kd_Unit,
                            A.Kd_Sub,
                            A.Kd_Prog,
                            A.ID_Prog,
                            A.Kd_Keg UNION ALL
                        SELECT
                            A.Tahun,
                            A.Kd_Urusan,
                            A.Kd_Bidang,
                            A.Kd_Unit,
                            A.Kd_Sub,
                            A.Kd_Prog,
                            A.ID_Prog,
                            A.Kd_Keg,
                            SUM (
                            CASE
                                    
                                    WHEN A.Kd_Rek_1 = 5 
                                    AND A.Kd_Rek_2 = 1 THEN
                                    CASE
                                            A.D_K 
                                            WHEN 'D' THEN
                                            A.Nilai ELSE - A.Nilai 
                                        END ELSE 0 
                                    END 
                                    ) AS S_BL1,
                                    SUM (
                                    CASE
                                            
                                            WHEN A.Kd_Rek_1 = 5 
                                            AND A.Kd_Rek_2 = 2 
                                            AND A.Kd_Rek_3 = 1 THEN
                                            CASE
                                                    A.D_K 
                                                    WHEN 'D' THEN
                                                    A.Nilai ELSE - A.Nilai 
                                                END ELSE 0 
                                            END 
                                            ) AS S_BL2,
                                            SUM (
                                            CASE
                                                    
                                                    WHEN A.Kd_Rek_1 = 5 
                                                    AND A.Kd_Rek_2 = 2 
                                                    AND A.Kd_Rek_3 > 1 THEN
                                                    CASE
                                                            A.D_K 
                                                            WHEN 'D' THEN
                                                            A.Nilai ELSE - A.Nilai 
                                                        END ELSE 0 
                                                    END 
                                                    ) AS S_BL3 
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
                                                    AND ( B.Tgl_Bukti <= '$d1' ) 
                                                    AND ( B.Jns_P1 = 1 ) 
                                                    AND ( A.Kd_Rek_1 = 5 ) 
                                                    AND ( A.Kd_Rek_2 = 2 ) 
                                                    AND ( '$peny_query' = 1 ) 
                                                GROUP BY
                                                    A.Tahun,
                                                    A.Kd_Urusan,
                                                    A.Kd_Bidang,
                                                    A.Kd_Unit,
                                                    A.Kd_Sub,
                                                    A.Kd_Prog,
                                                    A.ID_Prog,
                                                    A.Kd_Keg UNION ALL
                                                SELECT
                                                    A.Tahun,
                                                    A.Kd_Urusan,
                                                    A.Kd_Bidang,
                                                    A.Kd_Unit,
                                                    A.Kd_Sub,
                                                    A.Kd_Prog,
                                                    A.ID_Prog,
                                                    A.Kd_Keg,
                                                    SUM (
                                                    CASE
                                                            
                                                            WHEN A.Kd_Rek_1 = 5 
                                                            AND A.Kd_Rek_2 = 2 
                                                            AND A.Kd_Rek_3 = 1 THEN
                                                            CASE
                                                                    A.D_K 
                                                                    WHEN 'D' THEN
                                                                    A.Nilai ELSE - A.Nilai 
                                                                END ELSE 0 
                                                            END 
                                                            ) AS S_BL1,
                                                            SUM (
                                                            CASE
                                                                    
                                                                    WHEN A.Kd_Rek_1 = 5 
                                                                    AND A.Kd_Rek_2 = 2 
                                                                    AND A.Kd_Rek_3 = 2 THEN
                                                                    CASE
                                                                            A.D_K 
                                                                            WHEN 'D' THEN
                                                                            A.Nilai ELSE - A.Nilai 
                                                                        END ELSE 0 
                                                                    END 
                                                                    ) AS S_BL2,
                                                                    SUM (
                                                                    CASE
                                                                            
                                                                            WHEN A.Kd_Rek_1 = 5 
                                                                            AND A.Kd_Rek_2 = 2 
                                                                            AND A.Kd_Rek_3 = 3 THEN
                                                                            CASE
                                                                                    A.D_K 
                                                                                    WHEN 'D' THEN
                                                                                    A.Nilai ELSE - A.Nilai 
                                                                                END ELSE 0 
                                                                            END 
                                                                            ) AS S_BL3 
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
                                                                            AND ( B.Tgl_Bukti <= '$d1' ) 
                                                                            AND ( A.Kd_Rek_1 = 5 ) 
                                                                            AND ( A.Kd_Rek_2 = 2 ) 
                                                                            AND ( '$peny_query' = 1 ) 
                                                                            AND ( B.No_BKU <> 9999 ) 
                                                                        GROUP BY
                                                                            A.Tahun,
                                                                            A.Kd_Urusan,
                                                                            A.Kd_Bidang,
                                                                            A.Kd_Unit,
                                                                            A.Kd_Sub,
                                                                            A.Kd_Prog,
                                                                            A.ID_Prog,
                                                                            A.Kd_Keg 
                                                                        ) A 
                                                                    GROUP BY
                                                                        A.Tahun,
                                                                        A.Kd_Urusan,
                                                                        A.Kd_Bidang,
                                                                        A.Kd_Unit,
                                                                        A.Kd_Sub,
                                                                        A.Kd_Prog,
                                                                        A.ID_Prog,
                                                                        A.Kd_Keg 
                                                                    ) A 
                                                                GROUP BY
                                                                    A.Tahun,
                                                                    A.Kd_Urusan,
                                                                    A.Kd_Bidang,
                                                                    A.Kd_Unit,
                                                                    A.Kd_Sub,
                                                                    A.Kd_Prog,
                                                                    A.ID_Prog,
                                                                    A.Kd_Keg 
                                                                ) A
                                                                INNER JOIN Ta_Kegiatan B ON A.Tahun = B.Tahun 
                                                                AND A.Kd_Urusan = B.Kd_Urusan 
                                                                AND A.Kd_Bidang = B.Kd_Bidang 
                                                                AND A.Kd_Unit = B.Kd_Unit 
                                                                AND A.Kd_Sub = B.Kd_Sub 
                                                                AND A.Kd_Prog = B.Kd_Prog 
                                                                AND A.ID_Prog = B.ID_Prog 
                                                                AND A.Kd_Keg = B.Kd_Keg
                                                                INNER JOIN Ta_Program C ON B.Tahun = C.Tahun 
                                                                AND B.Kd_Urusan = C.Kd_Urusan 
                                                                AND B.Kd_Bidang = C.Kd_Bidang 
                                                                AND B.Kd_Unit = C.Kd_Unit 
                                                                AND B.Kd_Sub = C.Kd_Sub 
                                                                AND B.Kd_Prog = C.Kd_Prog 
                                                                AND B.ID_Prog = C.ID_Prog,
                                                                (
                                                                SELECT
                                                                    '$kd_urusan' AS Kd_UrusanA,
                                                                    '$kd_bidang' AS Kd_BidangA,
                                                                    '$kd_unit' AS Kd_UnitA,
                                                                    '$kd_sub' AS Kd_SubA,
                                                                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) AS Kd_Bidang_Gab,
                                                                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) AS Kd_Unit_Gab,
                                                                    '$kd_urusan' + ' . ' + RIGHT ( '0' + '$kd_bidang', 2 ) + ' . ' + RIGHT ( '0' + '$kd_unit', 2 ) + ' . ' + RIGHT ( '0' + '$kd_sub', 2 ) AS Kd_Sub_Gab,
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
        ")
            ->result();

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_kontrak($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

/*        $data_query								    = $this->query
        ("

        ")
            ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function daftar_realisasi($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

/*        $data_query								    = $this->query
        ("

        ")
            ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function realisasi_pembayaran($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

/*        $data_query								    = $this->query
        ("

        ")
            ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function register_sp3b($params)
    {
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

/*        $data_query								    = $this->query
        ("

        ")
            ->result();*/

        $output										= array
        (
            'data_query'							=> 0,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

    public function kendali_rincian_kegiatan_per_opd($params)
    {
		//print_r($params);exit;
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		error_reporting(E_ALL);
		ini_set('display_error', 1);
		ini_set('sqlsrv.ClientBufferMaxKBSize', '512M');
        $tahun                                      = $params['tahun'];
        $kd_urusan                                  = $params['kd_urusan'];
        $kd_bidang                                  = $params['kd_bidang'];
        $kd_unit                                    = $params['kd_unit'];
        $kd_sub                                     = $params['kd_sub'];
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

        $data_query								    = $this->query
        ('
				SELECT
					Ta_RASK_Arsip.Kd_Urusan,
					Ta_RASK_Arsip.Kd_Bidang,
					Ta_RASK_Arsip.Kd_Unit,
					Ref_Unit.Nm_Unit,
					Ta_RASK_Arsip.Kd_Sub,
					Ref_Sub_Unit.Nm_Sub_Unit,
					Ta_RASK_Arsip.Kd_Prog,
					Ta_RASK_Arsip.ID_Prog,
					Ta_Program.Ket_Program,
					Ta_RASK_Arsip.Kd_Keg,
					Ta_Kegiatan.Ket_Kegiatan,
					ref_kegiatan_mapping.kd_urusan90,
					ref_kegiatan_mapping.kd_bidang90,
					ref_kegiatan_mapping.kd_program90,
					ref_kegiatan_mapping.kd_kegiatan90,
					ref_kegiatan_mapping.kd_sub_kegiatan,
					ref_program90.nm_program,
					ref_kegiatan90.nm_kegiatan,
					ref_sub_kegiatan90.nm_sub_kegiatan,
					ref_rek90_6.kd_rek90_1,
					ref_rek90_6.kd_rek90_2,
					ref_rek90_6.kd_rek90_3,
					ref_rek90_6.kd_rek90_4,
					ref_rek90_6.kd_rek90_5,
					ref_rek90_6.kd_rek90_6,
					ref_rek90_6.nm_rek90_6,
					SUM (CASE WHEN Ta_RASK_Arsip.Kd_Perubahan = 4 THEN Ta_RASK_Arsip.Total ELSE 0 END) AS anggaran_murni,
					SUM (CASE WHEN Ta_RASK_Arsip.Kd_Perubahan = 5 THEN Ta_RASK_Arsip.Total ELSE 0 END) AS anggaran_pergeseran,
					SUM (CASE WHEN Ta_RASK_Arsip.Kd_Perubahan = 6 THEN Ta_RASK_Arsip.Total ELSE 0 END) AS anggaran_perubahan,
					realisasi.up_gu_tu,
					realisasi.ls,
					spj_dalam_perjalanan.perjalanan_gu_tu,
					perjalanan_ls.perjalanan_ls
				FROM
					Ta_RASK_Arsip
				INNER JOIN Ref_Unit ON Ta_RASK_Arsip.Kd_Urusan = Ref_Unit.Kd_Urusan
					AND Ta_RASK_Arsip.Kd_Bidang = Ref_Unit.Kd_Bidang
					AND Ta_RASK_Arsip.Kd_Unit = Ref_Unit.Kd_Unit
				INNER JOIN Ref_Sub_Unit ON Ta_RASK_Arsip.Kd_Urusan = Ref_Sub_Unit.Kd_Urusan
					AND Ta_RASK_Arsip.Kd_Bidang = Ref_Sub_Unit.Kd_Bidang
					AND Ta_RASK_Arsip.Kd_Unit = Ref_Sub_Unit.Kd_Unit
					AND Ta_RASK_Arsip.Kd_Sub = Ref_Sub_Unit.Kd_Sub
				INNER JOIN Ta_Program ON Ta_RASK_Arsip.Tahun = Ta_Program.Tahun
					AND Ta_RASK_Arsip.Kd_Urusan = Ta_Program.Kd_Urusan
					AND Ta_RASK_Arsip.Kd_Bidang = Ta_Program.Kd_Bidang
					AND Ta_RASK_Arsip.Kd_Unit = Ta_Program.Kd_Unit
					AND Ta_RASK_Arsip.Kd_Sub = Ta_Program.Kd_Sub
					AND Ta_RASK_Arsip.Kd_Prog = Ta_Program.Kd_Prog
					AND Ta_RASK_Arsip.ID_Prog = Ta_Program.ID_Prog
				INNER JOIN Ta_Kegiatan ON Ta_RASK_Arsip.Tahun = Ta_Kegiatan.Tahun
					AND Ta_RASK_Arsip.Kd_Urusan = Ta_Kegiatan.Kd_Urusan
					AND Ta_RASK_Arsip.Kd_Bidang = Ta_Kegiatan.Kd_Bidang
					AND Ta_RASK_Arsip.Kd_Unit = Ta_Kegiatan.Kd_Unit
					AND Ta_RASK_Arsip.Kd_Sub = Ta_Kegiatan.Kd_Sub
					AND Ta_RASK_Arsip.Kd_Prog = Ta_Kegiatan.Kd_Prog
					AND Ta_RASK_Arsip.ID_Prog = Ta_Kegiatan.ID_Prog
					AND Ta_RASK_Arsip.Kd_Keg = Ta_Kegiatan.Kd_Keg
				INNER JOIN Ref_Rek_5 ON Ta_RASK_Arsip.Kd_Rek_1 = Ref_Rek_5.Kd_Rek_1
					AND Ta_RASK_Arsip.Kd_Rek_2 = Ref_Rek_5.Kd_Rek_2
					AND Ta_RASK_Arsip.Kd_Rek_3 = Ref_Rek_5.Kd_Rek_3
					AND Ta_RASK_Arsip.Kd_Rek_4 = Ref_Rek_5.Kd_Rek_4
					AND Ta_RASK_Arsip.Kd_Rek_5 = Ref_Rek_5.Kd_Rek_5
				INNER JOIN ref_rek_mapping ON ta_rask_arsip.kd_rek_1 = ref_rek_mapping.kd_rek_1
					AND ta_rask_arsip.kd_rek_2 = ref_rek_mapping.kd_rek_2
					AND ta_rask_arsip.kd_rek_3 = ref_rek_mapping.kd_rek_3
					AND ta_rask_arsip.kd_rek_4 = ref_rek_mapping.kd_rek_4
					AND ta_rask_arsip.kd_rek_5 = ref_rek_mapping.kd_rek_5
				INNER JOIN ref_rek90_6 ON ref_rek_mapping.kd_rek90_1 = ref_rek90_6.kd_rek90_1
					AND ref_rek_mapping.kd_rek90_2 = ref_rek90_6.kd_rek90_2
					AND ref_rek_mapping.kd_rek90_3 = ref_rek90_6.kd_rek90_3
					AND ref_rek_mapping.kd_rek90_4 = ref_rek90_6.kd_rek90_4
					AND ref_rek_mapping.kd_rek90_5 = ref_rek90_6.kd_rek90_5
					AND ref_rek_mapping.kd_rek90_6 = ref_rek90_6.kd_rek90_6
				INNER JOIN ref_kegiatan_mapping ON ta_program.kd_urusan1 = ref_kegiatan_mapping.kd_urusan 
					AND ta_program.kd_bidang1 = ref_kegiatan_mapping.kd_bidang AND ta_rask_arsip.kd_prog = ref_kegiatan_mapping.kd_prog AND ta_rask_arsip.kd_keg = ref_kegiatan_mapping.kd_keg
				INNER JOIN ref_sub_kegiatan90 ON ref_kegiatan_mapping.kd_urusan90 = ref_sub_kegiatan90.kd_urusan 
					AND ref_kegiatan_mapping.kd_bidang90 = ref_sub_kegiatan90.kd_bidang AND ref_kegiatan_mapping.kd_program90 = ref_sub_kegiatan90.kd_program AND ref_kegiatan_mapping.kd_kegiatan90 = ref_sub_kegiatan90.kd_kegiatan AND ref_kegiatan_mapping.kd_sub_kegiatan = ref_sub_kegiatan90.kd_sub_kegiatan
				INNER JOIN ref_kegiatan90 ON ref_sub_kegiatan90.kd_urusan = ref_kegiatan90.kd_urusan 
					AND ref_sub_kegiatan90.kd_bidang = ref_kegiatan90.kd_bidang AND ref_sub_kegiatan90.kd_program = ref_kegiatan90.kd_program AND ref_sub_kegiatan90.kd_kegiatan = ref_kegiatan90.kd_kegiatan
				INNER JOIN ref_program90 ON ref_kegiatan90.kd_urusan = ref_program90.kd_urusan 
					AND ref_kegiatan90.kd_bidang = ref_program90.kd_bidang AND ref_kegiatan90.kd_program = ref_program90.kd_program
				LEFT JOIN (
					SELECT
						Ta_SPM_Rinc.Kd_Urusan,
						Ta_SPM_Rinc.Kd_Bidang,
						Ta_SPM_Rinc.Kd_Unit,
						Ta_SPM_Rinc.Kd_Sub,
						Ta_SPM_Rinc.Kd_Prog,
						Ta_SPM_Rinc.ID_Prog,
						Ta_SPM_Rinc.Kd_Keg,
						ref_rek_mapping.kd_rek90_1,
						ref_rek_mapping.kd_rek90_2,
						ref_rek_mapping.kd_rek90_3,
						ref_rek_mapping.kd_rek90_4,
						ref_rek_mapping.kd_rek90_5,
						ref_rek_mapping.kd_rek90_6,
						Sum(case when (Ta_SPM.Jn_SPM = 1 OR Ta_SPM.Jn_SPM = 2 OR Ta_SPM.Jn_SPM = 4) then Ta_SPM_Rinc.Nilai else 0 end) AS up_gu_tu,
						Sum(case when Ta_SPM.Jn_SPM = 3 then Ta_SPM_Rinc.Nilai else 0 end) AS ls
					FROM
						Ta_SPM_Rinc 
					INNER JOIN Ta_SPM ON Ta_SPM_Rinc.Tahun = Ta_SPM.Tahun AND Ta_SPM_Rinc.No_SPM = Ta_SPM.No_SPM 
					INNER JOIN Ta_SP2D ON Ta_SPM.Tahun = Ta_SP2D.Tahun AND Ta_SPM.No_SPM = Ta_SP2D.No_SPM
					INNER JOIN ref_rek_mapping ON 
						ta_spm_rinc.kd_rek_1 = ref_rek_mapping.kd_rek_1 AND 
						ta_spm_rinc.kd_rek_2 = ref_rek_mapping.kd_rek_2 AND 
						ta_spm_rinc.kd_rek_3 = ref_rek_mapping.kd_rek_3 AND 
						ta_spm_rinc.kd_rek_4 = ref_rek_mapping.kd_rek_4 AND 
						ta_spm_rinc.kd_rek_5 = ref_rek_mapping.kd_rek_5
					WHERE 
						(NOT (Ta_SP2D.No_SP2D IS NULL)) AND 
						/*(Ta_SPM.Jn_SPM <> 4) AND */
						(Ta_SPM_Rinc.Kd_Rek_1 <> 6) AND 
						(Ta_SPM_Rinc.Kd_Prog > 0) AND 
						(Tgl_SP2D >= CONVERT(DATETIME, \'' . $params['tahun'] . '-01-01 00:00:00\', 102)) AND
						(Tgl_SP2D <= CONVERT(DATETIME, \'' . $params['tahun'] . '-12-31 00:00:00\', 102)) AND
						Ta_SPM_Rinc.Kd_Urusan LIKE ' . $params['kd_urusan'] . ' AND
						Ta_SPM_Rinc.Kd_Bidang LIKE ' . $params['kd_bidang'] . ' AND
						Ta_SPM_Rinc.Kd_Unit LIKE ' . $params['kd_unit'] . '
					GROUP BY 
						Ta_SPM_Rinc.Kd_Urusan, 
						Ta_SPM_Rinc.Kd_Bidang, 
						Ta_SPM_Rinc.Kd_Unit, 
						Ta_SPM_Rinc.Kd_Sub,
						Ta_SPM_Rinc.Kd_Prog,
						Ta_SPM_Rinc.ID_Prog,
						Ta_SPM_Rinc.Kd_Keg,
						ref_rek_mapping.kd_rek90_1,
						ref_rek_mapping.kd_rek90_2,
						ref_rek_mapping.kd_rek90_3,
						ref_rek_mapping.kd_rek90_4,
						ref_rek_mapping.kd_rek90_5,
						ref_rek_mapping.kd_rek90_6
				) AS realisasi ON
					Ta_RASK_Arsip.Kd_Urusan 	= realisasi.Kd_Urusan AND
					Ta_RASK_Arsip.Kd_Bidang 	= realisasi.Kd_Bidang AND
					Ta_RASK_Arsip.Kd_Unit 		= realisasi.Kd_Unit AND
					Ta_RASK_Arsip.Kd_Sub 		= realisasi.Kd_Sub AND
					Ta_RASK_Arsip.Kd_Prog 		= realisasi.Kd_Prog AND
					Ta_RASK_Arsip.ID_Prog 		= realisasi.ID_Prog AND
					Ta_RASK_Arsip.Kd_Keg 		= realisasi.Kd_Keg AND
					ref_rek90_6.kd_rek90_1 		= realisasi.kd_rek90_1 AND
					ref_rek90_6.kd_rek90_2 		= realisasi.kd_rek90_2 AND
					ref_rek90_6.kd_rek90_3 		= realisasi.kd_rek90_3 AND
					ref_rek90_6.kd_rek90_4 		= realisasi.kd_rek90_4 AND
					ref_rek90_6.kd_rek90_5 		= realisasi.kd_rek90_5 AND
					ref_rek90_6.kd_rek90_6 		= realisasi.kd_rek90_6
				LEFT JOIN (
					SELECT
						ta_spj_bukti.tahun,
						ta_spj_bukti.kd_urusan,
						ta_spj_bukti.kd_bidang,
						ta_spj_bukti.kd_unit,
						ta_spj_bukti.kd_sub,
						ta_spj_bukti.kd_prog,
						ta_spj_bukti.id_prog,
						ta_spj_bukti.kd_keg,
						ref_rek_mapping.kd_rek90_1,
						ref_rek_mapping.kd_rek90_2,
						ref_rek_mapping.kd_rek90_3,
						ref_rek_mapping.kd_rek90_4,
						ref_rek_mapping.kd_rek90_5,
						ref_rek_mapping.kd_rek90_6,
						SUM (ta_spj_bukti.nilai) AS perjalanan_gu_tu
					FROM
						ta_spj_bukti
					LEFT JOIN ta_spj_rinc ON ta_spj_bukti.tahun = ta_spj_rinc.tahun
						AND ta_spj_bukti.kd_urusan = ta_spj_rinc.kd_urusan
						AND ta_spj_bukti.kd_bidang = ta_spj_rinc.kd_bidang
						AND ta_spj_bukti.kd_unit = ta_spj_rinc.kd_unit
						AND ta_spj_bukti.kd_sub = ta_spj_rinc.kd_sub
						AND ta_spj_bukti.kd_prog = ta_spj_rinc.kd_prog
						AND ta_spj_bukti.id_prog = ta_spj_rinc.id_prog
						AND ta_spj_bukti.kd_keg = ta_spj_rinc.kd_keg
						AND ta_spj_bukti.kd_rek_1 = ta_spj_rinc.kd_rek_1
						AND ta_spj_bukti.kd_rek_2 = ta_spj_rinc.kd_rek_2
						AND ta_spj_bukti.kd_rek_3 = ta_spj_rinc.kd_rek_3
						AND ta_spj_bukti.kd_rek_4 = ta_spj_rinc.kd_rek_4
						AND ta_spj_bukti.kd_rek_5 = ta_spj_rinc.kd_rek_5
						AND ta_spj_bukti.no_bukti = ta_spj_rinc.no_bukti
						AND ta_spj_bukti.tgl_bukti = ta_spj_rinc.tgl_bukti
					LEFT JOIN ta_pengesahan_spj ON 
						ta_spj_rinc.tahun = ta_pengesahan_spj.tahun
						AND ta_spj_rinc.no_spj = ta_pengesahan_spj.no_spj
					LEFT JOIN ta_spp ON ta_spj_rinc.tahun = ta_spp.tahun
					AND ta_spj_rinc.kd_urusan = ta_spp.kd_urusan
					AND ta_spj_rinc.kd_bidang = ta_spp.kd_bidang
					AND ta_spj_rinc.kd_unit = ta_spp.kd_unit
					AND ta_spj_rinc.kd_sub = ta_spp.kd_sub
					AND ta_pengesahan_spj.no_pengesahan = ta_spp.no_spj
					LEFT JOIN ta_spm ON ta_spp.tahun = ta_spm.tahun
					AND ta_spp.no_spp = ta_spm.no_spp
					AND ta_spp.kd_urusan = ta_spm.kd_urusan
					AND ta_spp.kd_bidang = ta_spm.kd_bidang
					AND ta_spp.kd_unit = ta_spm.kd_unit
					AND ta_spp.kd_sub = ta_spm.kd_sub
					LEFT JOIN ta_sp2d ON ta_spm.tahun = ta_sp2d.tahun
					AND ta_spm.no_spm = ta_sp2d.no_spm
					INNER JOIN ref_rek_mapping ON ta_spj_bukti.kd_rek_1 = ref_rek_mapping.kd_rek_1
					AND ta_spj_bukti.kd_rek_2 = ref_rek_mapping.kd_rek_2
					AND ta_spj_bukti.kd_rek_3 = ref_rek_mapping.kd_rek_3
					AND ta_spj_bukti.kd_rek_4 = ref_rek_mapping.kd_rek_4
					AND ta_spj_bukti.kd_rek_5 = ref_rek_mapping.kd_rek_5
					WHERE
						ta_spj_bukti.tahun = ' . $params['tahun'] . '
					AND ta_spj_bukti.kd_urusan LIKE ' . $params['kd_urusan'] . '
					AND ta_spj_bukti.kd_bidang LIKE ' . $params['kd_bidang'] . '
					AND ta_spj_bukti.kd_unit LIKE ' . $params['kd_unit'] . '
					AND (
						ta_spj_bukti.jn_spm = 2
						OR ta_spj_bukti.jn_spm = 4
					)
					AND ta_sp2d.no_sp2d IS NULL
					GROUP BY
						ta_spj_bukti.tahun,
						ta_spj_bukti.kd_urusan,
						ta_spj_bukti.kd_bidang,
						ta_spj_bukti.kd_unit,
						ta_spj_bukti.kd_sub,
						ta_spj_bukti.kd_prog,
						ta_spj_bukti.id_prog,
						ta_spj_bukti.kd_keg,
						ref_rek_mapping.kd_rek90_1,
						ref_rek_mapping.kd_rek90_2,
						ref_rek_mapping.kd_rek90_3,
						ref_rek_mapping.kd_rek90_4,
						ref_rek_mapping.kd_rek90_5,
						ref_rek_mapping.kd_rek90_6
				) AS spj_dalam_perjalanan ON
					Ta_RASK_Arsip.kd_urusan 	= spj_dalam_perjalanan.kd_urusan AND
					Ta_RASK_Arsip.kd_bidang 	= spj_dalam_perjalanan.kd_bidang AND
					Ta_RASK_Arsip.kd_unit 		= spj_dalam_perjalanan.kd_unit AND
					Ta_RASK_Arsip.kd_sub 		= spj_dalam_perjalanan.kd_sub AND
					Ta_RASK_Arsip.kd_prog 		= spj_dalam_perjalanan.kd_prog AND
					Ta_RASK_Arsip.id_prog 		= spj_dalam_perjalanan.id_prog AND
					Ta_RASK_Arsip.kd_keg 		= spj_dalam_perjalanan.kd_keg AND
					ref_rek90_6.kd_rek90_1 		= spj_dalam_perjalanan.kd_rek90_1 AND
					ref_rek90_6.kd_rek90_2 		= spj_dalam_perjalanan.kd_rek90_2 AND
					ref_rek90_6.kd_rek90_3 		= spj_dalam_perjalanan.kd_rek90_3 AND
					ref_rek90_6.kd_rek90_4 		= spj_dalam_perjalanan.kd_rek90_4 AND
					ref_rek90_6.kd_rek90_5 		= spj_dalam_perjalanan.kd_rek90_5 AND
					ref_rek90_6.kd_rek90_6 		= spj_dalam_perjalanan.kd_rek90_6
				LEFT JOIN (
					SELECT
						ta_spp.tahun,
						ta_spp.kd_urusan,
						ta_spp.kd_bidang,
						ta_spp.kd_unit,
						ta_spp.kd_sub,
						ta_spp_rinc.kd_prog,
						ta_spp_rinc.id_prog,
						ta_spp_rinc.kd_keg,
						ref_rek_mapping.kd_rek90_1,
						ref_rek_mapping.kd_rek90_2,
						ref_rek_mapping.kd_rek90_3,
						ref_rek_mapping.kd_rek90_4,
						ref_rek_mapping.kd_rek90_5,
						ref_rek_mapping.kd_rek90_6,
						SUM (ta_spp_rinc.nilai) AS perjalanan_ls
					FROM
						ta_spp
					INNER JOIN ta_spp_rinc ON ta_spp.tahun = ta_spp_rinc.tahun
					AND ta_spp.no_spp = ta_spp_rinc.no_spp
					AND ta_spp.kd_urusan = ta_spp_rinc.kd_urusan
					AND ta_spp.kd_bidang = ta_spp_rinc.kd_bidang
					AND ta_spp.kd_unit = ta_spp_rinc.kd_unit
					AND ta_spp.kd_sub = ta_spp_rinc.kd_sub
					INNER JOIN ref_rek_mapping ON ta_spp_rinc.kd_rek_1 = ref_rek_mapping.kd_rek_1
					AND ta_spp_rinc.kd_rek_2 = ref_rek_mapping.kd_rek_2
					AND ta_spp_rinc.kd_rek_3 = ref_rek_mapping.kd_rek_3
					AND ta_spp_rinc.kd_rek_4 = ref_rek_mapping.kd_rek_4
					AND ta_spp_rinc.kd_rek_5 = ref_rek_mapping.kd_rek_5
					LEFT JOIN ta_spm ON ta_spp_rinc.tahun = ta_spm.tahun
					AND ta_spp_rinc.no_spp = ta_spm.no_spp
					AND ta_spp_rinc.kd_urusan = ta_spm.kd_urusan
					AND ta_spp_rinc.kd_bidang = ta_spm.kd_bidang
					AND ta_spp_rinc.kd_unit = ta_spm.kd_unit
					AND ta_spp_rinc.kd_sub = ta_spm.kd_sub
					LEFT JOIN ta_sp2d ON ta_spm.tahun = ta_sp2d.tahun
					AND ta_spm.no_spm = ta_sp2d.no_spm
					WHERE
						ta_spp.tahun = ' . $params['tahun'] . '
					AND ta_spp.kd_urusan LIKE ' . $params['kd_urusan'] . '
					AND ta_spp.kd_bidang LIKE ' . $params['kd_bidang'] . '
					AND ta_spp.kd_unit LIKE ' . $params['kd_unit'] . '
					AND ta_spp.jn_spp = 3
					AND ta_sp2d.no_sp2d IS NULL
					GROUP BY
						ta_spp.tahun,
						ta_spp.kd_urusan,
						ta_spp.kd_bidang,
						ta_spp.kd_unit,
						ta_spp.kd_sub,
						ta_spp_rinc.kd_prog,
						ta_spp_rinc.id_prog,
						ta_spp_rinc.kd_keg,
						ref_rek_mapping.kd_rek90_1,
						ref_rek_mapping.kd_rek90_2,
						ref_rek_mapping.kd_rek90_3,
						ref_rek_mapping.kd_rek90_4,
						ref_rek_mapping.kd_rek90_5,
						ref_rek_mapping.kd_rek90_6
				) AS perjalanan_ls ON 
					Ta_RASK_Arsip.kd_urusan 	= perjalanan_ls.kd_urusan AND
					Ta_RASK_Arsip.kd_bidang 	= perjalanan_ls.kd_bidang AND
					Ta_RASK_Arsip.kd_unit 		= perjalanan_ls.kd_unit AND
					Ta_RASK_Arsip.kd_sub 		= perjalanan_ls.kd_sub AND
					Ta_RASK_Arsip.kd_prog 		= perjalanan_ls.kd_prog AND
					Ta_RASK_Arsip.id_prog 		= perjalanan_ls.id_prog AND
					Ta_RASK_Arsip.kd_keg 		= perjalanan_ls.kd_keg AND
					ref_rek90_6.kd_rek90_1 		= perjalanan_ls.kd_rek90_1 AND
					ref_rek90_6.kd_rek90_2 		= perjalanan_ls.kd_rek90_2 AND
					ref_rek90_6.kd_rek90_3 		= perjalanan_ls.kd_rek90_3 AND
					ref_rek90_6.kd_rek90_4 		= perjalanan_ls.kd_rek90_4 AND
					ref_rek90_6.kd_rek90_5 		= perjalanan_ls.kd_rek90_5 AND
					ref_rek90_6.kd_rek90_6 		= perjalanan_ls.kd_rek90_6
				WHERE
					Ta_RASK_Arsip.Tahun = ' . $params['tahun'] . '
				AND Ta_RASK_Arsip.Kd_Urusan LIKE ' . $params['kd_urusan'] . '
				AND Ta_RASK_Arsip.Kd_Bidang LIKE ' . $params['kd_bidang'] . '
				AND Ta_RASK_Arsip.Kd_Unit LIKE ' . $params['kd_unit'] . '
				AND Ta_RASK_Arsip.Kd_Prog > 0
				GROUP BY
					Ta_RASK_Arsip.Kd_Urusan,
					Ta_RASK_Arsip.Kd_Bidang,
					Ta_RASK_Arsip.Kd_Unit,
					Ref_Unit.Nm_Unit,
					Ta_RASK_Arsip.Kd_Sub,
					Ref_Sub_Unit.Nm_Sub_Unit,
					Ta_RASK_Arsip.Kd_Prog,
					Ta_RASK_Arsip.ID_Prog,
					Ta_Program.Ket_Program,
					Ta_RASK_Arsip.Kd_Keg,
					Ta_Kegiatan.Ket_Kegiatan,
					ref_kegiatan_mapping.kd_urusan90,
					ref_kegiatan_mapping.kd_bidang90,
					ref_kegiatan_mapping.kd_program90,
					ref_kegiatan_mapping.kd_kegiatan90,
					ref_kegiatan_mapping.kd_sub_kegiatan,
					ref_program90.nm_program,
					ref_kegiatan90.nm_kegiatan,
					ref_sub_kegiatan90.nm_sub_kegiatan,
					ref_rek90_6.kd_rek90_1,
					ref_rek90_6.kd_rek90_2,
					ref_rek90_6.kd_rek90_3,
					ref_rek90_6.kd_rek90_4,
					ref_rek90_6.kd_rek90_5,
					ref_rek90_6.kd_rek90_6,
					ref_rek90_6.nm_rek90_6,
					realisasi.up_gu_tu,
					realisasi.ls,
					spj_dalam_perjalanan.perjalanan_gu_tu,
					perjalanan_ls.perjalanan_ls
				ORDER BY
					Ta_RASK_Arsip.Kd_Urusan ASC,
					Ta_RASK_Arsip.Kd_Bidang ASC,
					Ta_RASK_Arsip.Kd_Unit ASC,
					Ta_RASK_Arsip.Kd_Sub ASC,
					Ta_RASK_Arsip.Kd_Prog ASC,
					Ta_RASK_Arsip.ID_Prog ASC,
					Ta_RASK_Arsip.Kd_Keg ASC,
					ref_rek90_6.kd_rek90_1 ASC,
					ref_rek90_6.kd_rek90_2 ASC,
					ref_rek90_6.kd_rek90_3 ASC,
					ref_rek90_6.kd_rek90_4 ASC,
					ref_rek90_6.kd_rek90_5 ASC,
					ref_rek90_6.kd_rek90_6 ASC
        ')
         ->result();

        $output										= array
        (
            'data'									=> $data_query,
            'tanggal'								=> $params['tahun']
        );
        return $output;
    }

}
