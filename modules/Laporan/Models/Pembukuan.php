<?php namespace Modules\Laporan\Models;
/**
 * Laporan > Models > Pembukuan
 *
 * @since			version 1.0.0
 * @author			GeekTech Karya Indonesia, Ltd.
 * @website			www.geektech.id
 */
class Pembukuan extends \Aksara\Laboratory\Model
{
	public function __construct()
	{
		parent::__construct();

		$this->database_config('default');
	}

	/**
	 * Query Pembukuan/basis
	 */
    public function rekening($params)
    {
        $data_query									= $this->query
		(
			"BEGIN SET NOCOUNT ON EXEC RptRekening ?, ? END",
			array
			(
                $params['tahun'],
                $params['rekening']
			)
		)
		->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function jurnal($params)
    {
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $kd_skpd								    = '1';

        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptJurnal ?, ?, ?, ?, ?, ?, ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['kd_urusan'],
                $params['kd_bidang'],
                $params['kd_unit'],
                $params['kd_sub'],
                $params['jenis_jurnal'],
                $kd_skpd,
                $d1,
                $d2,
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function buku_besar($params)
    {
        $kd_skpd								    = '1';
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptBukuBesar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['kd_urusan'],
                $params['kd_bidang'],
                $params['kd_unit'],
                $params['kd_sub'],
                $kd_skpd,
                $params['level_rekening'],
                $d1,
                $d2,
                $params['kd_akun'],
                $params['kd_kelompok'],
                $params['kd_jenis']
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function buku_besar_pembantu($params)
    {
        $kd_skpd								    = '1';
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptBukuBesarPembantu ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['kd_urusan'],
                $params['kd_bidang'],
                $params['kd_unit'],
                $params['kd_sub'],
                $kd_skpd,
                $params['level_rekening'],
                $d1,
                $d2,
                $params['kd_akun'],
                $params['kd_kelompok'],
                $params['kd_jenis'],
                $params['kd_obyek'],
                $params['kd_rincian']
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function buku_besar_pembantu_bukti($params)
    {
        $kd_skpd								    = '1';
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];

        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptBukuBesarPembantu_Ket ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['kd_urusan'],
                $params['kd_bidang'],
                $params['kd_unit'],
                $params['kd_sub'],
                $kd_skpd,
                $params['level_rekening'],
                $d1,
                $d2,
                $params['kd_akun'],
                $params['kd_kelompok'],
                $params['kd_jenis'],
                $params['kd_obyek'],
                $params['kd_rincian']
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function neraca($params)
    {
        $kd_skpd								    = '1';
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $data_query                                 = 0;

        if($params['jenis_laporan'] == 1)
        {
            $data_query								= $this->query
            (
                "BEGIN SET NOCOUNT ON EXEC RptNeraca ?, ?, ?, ?, ?, ?, ? END",
                array
                (
                    $params['tahun'],
                    $params['kd_urusan'],
                    $params['kd_bidang'],
                    $params['kd_unit'],
                    $params['kd_sub'],
                    $kd_skpd,
                    $d1
                )
            )
                ->result();
        }
        elseif($params['jenis_laporan'] == 2)
        {
            $data_query								= $this->query
            (
                "BEGIN SET NOCOUNT ON EXEC RptNeracaSAP ?, ?, ?, ?, ?, ?, ? END",
                array
                (
                    $params['tahun'],
                    $params['kd_urusan'],
                    $params['kd_bidang'],
                    $params['kd_unit'],
                    $params['kd_sub'],
                    $kd_skpd,
                    $d1
                )
            )
                ->result();
        }
        elseif($params['jenis_laporan'] == 5)
        {
            $data_query								= $this->query
            (
                "BEGIN SET NOCOUNT ON EXEC RptNeracaSblm ?, ?, ?, ?, ?, ?, ? END",
                array
                (
                    $params['tahun'],
                    $params['kd_urusan'],
                    $params['kd_bidang'],
                    $params['kd_unit'],
                    $params['kd_sub'],
                    $kd_skpd,
                    $d1
                )
            )
                ->result();
        }
        elseif($params['jenis_laporan'] == 6)
        {
            $data_query								= $this->query
            (
                "BEGIN SET NOCOUNT ON EXEC RptNeracaSblmSAP ?, ?, ?, ?, ?, ?, ? END",
                array
                (
                    $params['tahun'],
                    $params['kd_urusan'],
                    $params['kd_bidang'],
                    $params['kd_unit'],
                    $params['kd_sub'],
                    $kd_skpd,
                    $d1
                )
            )
                ->result();
        }
        elseif($params['jenis_laporan'] == 7)
        {
            $data_query								= $this->query
            (
                "BEGIN SET NOCOUNT ON EXEC RptNeracaLajur ?, ?, ?, ?, ?, ?, ? END",
                array
                (
                    $params['tahun'],
                    $params['kd_urusan'],
                    $params['kd_bidang'],
                    $params['kd_unit'],
                    $params['kd_sub'],
                    $kd_skpd,
                    $d1
                )
            )
                ->result();
        }
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function memo_pembukuan($params)
    {
        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptMemoJurnal ?, ? END",
            array
            (
                $params['tahun'],
                $params['jenis_jurnal']
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function memo_jural($params)
    {
        $kd_skpd								    = '1';
        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptMemoJurnalSemua ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['jenis_jurnal'],
                $kd_skpd
            )
        )
            ->result();
        print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

    public function saldo_buku_besar($params)
    {
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $kd_skpd								    = '1';

        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptSaldoBukuBesar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['kd_urusan'],
                $params['kd_bidang'],
                $params['kd_unit'],
                $params['kd_sub'],
                $kd_skpd,
                $params['level_rekening'],
                $d1,
                $params['kd_akun'],
                $params['kd_kelompok'],
                $params['kd_jenis']
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function rincian_saldo_buku_besar($params)
    {
        $d1										    = $params['tahun'] . '-01-01'; //$params['periode_awal'];
        $d2										    = $params['tahun'] . '-12-31'; //$params['periode_akhir'];
        $kd_skpd								    = '1';

        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptRincianSaldoBukuBesar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? END",
            array
            (
                $params['tahun'],
                $params['kd_urusan'],
                $params['kd_bidang'],
                $params['kd_unit'],
                $params['kd_sub'],
                $kd_skpd,
                $params['level_rekening'],
                $d1,
                $params['kd_akun'],
                $params['kd_kelompok'],
                $params['kd_jenis'],
                $params['kd_jenis'],
                $params['kd_jenis']
            )
        )
            ->result();
        //print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun'],
            'kd_sub'								=> $params['kd_sub']
        );

        return $output;
    }

    public function saldo_bb_sap($params)
    {
        $data_query									= $this->query
        (
            "BEGIN SET NOCOUNT ON EXEC RptSaldoBB_SAP ?, ? END",
            array
            (
                $params['tahun'],
                $params['jenis_jurnal']
            )
        )
            ->result();
        print_r($data_query); exit;

        $output										= array
        (
            'data_query'							=> $data_query,
            'tanggal'								=> $params['tahun']
        );

        return $output;
    }

}
