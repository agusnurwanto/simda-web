<?php
    $title		                                    = ($results['kd_sub'] != '%' ? ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit_Gab)) : $title );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'Pembukuan - ' . $title; ?>
		</title>
		<link rel="icon" type="image/x-icon" href="<?php echo get_image('settings', get_setting('app_icon'), 'icon'); ?>" />

        <style type="text/css">
            @page
            {
                /*header: html_header;*/ /* !!! apply only when the htmlpageheader is sets !!! */
                footer: html_footer; /* !!! apply only when the htmlpagefooter is sets !!! */
                sheet-size: 13in 8.5in;
                margin: 50, 40, 40, 40
            }
            .print
            {
                display: none
            }
            @media print
            {
                .no-print
                {
                    display: none
                }
                .print
                {
                    display: block
                }
            }
            body
            {
                font-family: Tahoma
            }
            .divider
            {
                display: block;
                border-top: 3px solid #000;
                border-bottom: 1px solid #000;
                padding: 1px;
                margin-bottom: 15px
            }
            .text-sm-2
            {
                font-size: 10px
            }
            .text-sm
            {
                font-size: 8px
            }
            .text-uppercase
            {
                text-transform: uppercase
            }
            .text-muted
            {
                color: #888
            }
            .text-left
            {
                text-align: left
            }
            .text-right
            {
                text-align: right
            }
            .text-center
            {
                text-align: center
            }
            table
            {
                width: 100%
            }
            th
            {
                font-weight: bold;
                font-size: 12px;
                padding: 6px;
            }
            td
            {
                vertical-align: top;
                font-size: 10px;
                padding: 5px;
            }
            .v-middle
            {
                vertical-align: middle
            }
            .table
            {
                border-collapse: collapse
            }
            .border
            {
                border: 1px solid #000
            }
            .no-border-left
            {
                border-left: 0
            }
            .no-border-top
            {
                border-top: 0
            }
            .no-border-right
            {
                border-right: 0
            }
            .no-border-bottom
            {
                border-bottom: 0
            }
            .no-padding
            {
                padding: 0
            }
            .no-margin
            {
                margin: 0
            }
            h1
            {
                font-size: 18px
            }
            p
            {
                margin: 0
            }
            .dotted-bottom
            {
                border-bottom: 1px dotted #000
            }
        </style>
	</head>
	<body>
        <?php
        $num								= 1;
        $kd_reg_gab					        = 0;
        $lewat_tanggal      				= 0;
        $debet						        = 0;
        $kredit						        = 0;
        $saldo						        = 0;
        $total_debet				        = 0;
        $total_kredit				        = 0;
        $total_saldo				        = 0;
        foreach($results['data_query'] as $key => $val)
        {
            $netto                                  = $val->Kd_Rek_Gab == '5.3' ? '<pagebreak>' : '';
            $silpa                                  = $val->Kd_Rek_Gab == '5.3' || $val->Kd_Rek_Gab == '6.3' ? '<pagebreak>' : '';
            $debet					                = (($val->Debet) ? $val->Debet : null);
            $kredit					                = (($val->Kredit) ? $val->Kredit : null);
            $saldo					                = (($val->Saldo) ? $val->Saldo : null);
            $total_debet			                += $debet;
            $total_kredit			                += $kredit;
            $total_saldo			                += $saldo;

            //Surplus
            if($val->Kd_Rek_Gab == '5.3')
            {
                echo '
                ' . $silpa . '
                <table class="table">
                    <thead>
                        <tr>
                            <th width="100" class="border no-border-right">
                                <img src="' . $logo_laporan . '" alt="..." width="80" />
                            </th>
                            <th class="border no-border-left" align="center">
                                <h5>
                                    ' . (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'). '
                                </h5>
                                <h3>
                                    BUKU BESAR
                                </h3>
                                <h6>
                                    <i>periode . ' . get_userdata('year') . ' </i>
                                </h6>
                            </th>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="3" class="border no-border-top">
                            <table>
                                <tr>
                                    <td width="13%" class="text-sm-2 no-padding">
                                        <b>Urusan Pemerintahan</b>
                                    </td>
                                    <td width="2%" class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td width="15%" class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Urusan_Gab . '
                                    </td>
                                    <td width="70%" class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Urusan_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Bidang Pemerintahan</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Bidang_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Bidang_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Unit Organisasi</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Unit_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Unit_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Sub Unit Organisasi</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Sub_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Sub_Unit_Gab . '
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                    <td colspan="3" class="border no-border-top">
                        <table>
                            <tr>
                                <td width="15%" class="text-sm-2 no-padding">
                                    Kode Rekening Buku Besar
                                </td>
                                <td width="2%" class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td width="15%" class="text-sm-2 no-padding">
                                    ' . $val->Kd_Rek_Gab  . '
                                </td>
                                <td width="68%" class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Nama Rekening Buku Besar
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding">
                                    ' . $val->Nm_Rek  . '
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Pagu APBD
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding text-right">
                                    (' . number_format_indo($val->APBD, 2)  . ')
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Pagu Perubahan APBD
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding text-right">
                                    (' . number_format_indo($val->Perubahan, 2)  . ')
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </thead>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border text-sm-2" width="4%">
                            NO
                        </th>
                        <th class="border text-sm-2" width="10%">
                            TANGGAL
                        </th>
                        <th class="border text-sm-2" width="12%">
                            NO BUKTI
                        </th>
                        <th class="border text-sm-2" width="38%">
                            URAIAN
                        </th>
                        <th class="border text-sm-2" width="12%">
                            DEBET
                        </th>
                        <th class="border text-sm-2" width="12%">
                            KREDIT
                        </th>
                        <th class="border text-sm-2" width="12%">
                            SALDO
                        </th>
                    </tr>
                    </thead>
                    <tbody>';
                if($val->Kd_Rek_Gab != $kd_reg_gab)
                {
                    echo '
                                <tr>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $num . '
                                    </td>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                        ' . date_indo($val->Tgl_Bukti) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . $val->No_Bukti . '
                                    </td>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                        ' . $val->Keterangan . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Saldo, 2) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Kredit, 2) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Saldo, 2) . '
                                    </td>
                                </tr>
                            ';
                    //$num++;
                }
                echo'
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="border text-sm text-right">
                                <b>
                                    JUMLAH
                                </b>
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_debet, 2) . '
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_kredit, 2) . '
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_saldo, 2) . '
                            </td>
                        </tr>
                    </tfoot>
                </table>
                ';
            }

            //Netto
            if($val->Kd_Rek_Gab == '6.3')
            {
                echo '
                ' . $netto . '
                <table class="table">
                    <thead>
                        <tr>
                            <th width="100" class="border no-border-right">
                                <img src="' . $logo_laporan . '" alt="..." width="80" />
                            </th>
                            <th class="border no-border-left" align="center">
                                <h5>
                                    ' . (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'). '
                                </h5>
                                <h3>
                                    BUKU BESAR
                                </h3>
                                <h6>
                                    <i>periode . ' . get_userdata('year') . ' </i>
                                </h6>
                            </th>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="3" class="border no-border-top">
                            <table>
                                <tr>
                                    <td width="13%" class="text-sm-2 no-padding">
                                        <b>Urusan Pemerintahan</b>
                                    </td>
                                    <td width="2%" class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td width="15%" class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Urusan_Gab . '
                                    </td>
                                    <td width="70%" class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Urusan_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Bidang Pemerintahan</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Bidang_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Bidang_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Unit Organisasi</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Unit_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Unit_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Sub Unit Organisasi</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Sub_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Sub_Unit_Gab . '
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                    <td colspan="3" class="border no-border-top">
                        <table>
                            <tr>
                                <td width="15%" class="text-sm-2 no-padding">
                                    Kode Rekening Buku Besar
                                </td>
                                <td width="2%" class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td width="15%" class="text-sm-2 no-padding">
                                    ' . $val->Kd_Rek_Gab  . '
                                </td>
                                <td width="68%" class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Nama Rekening Buku Besar
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding">
                                    ' . $val->Nm_Rek  . '
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Pagu APBD
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding text-right">
                                    (' . number_format_indo($val->APBD, 2)  . ')
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Pagu Perubahan APBD
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding text-right">
                                    (' . number_format_indo($val->Perubahan, 2)  . ')
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </thead>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border text-sm-2" width="4%">
                            NO
                        </th>
                        <th class="border text-sm-2" width="10%">
                            TANGGAL
                        </th>
                        <th class="border text-sm-2" width="12%">
                            NO BUKTI
                        </th>
                        <th class="border text-sm-2" width="38%">
                            URAIAN
                        </th>
                        <th class="border text-sm-2" width="12%">
                            DEBET
                        </th>
                        <th class="border text-sm-2" width="12%">
                            KREDIT
                        </th>
                        <th class="border text-sm-2" width="12%">
                            SALDO
                        </th>
                    </tr>
                    </thead>
                    <tbody>';
                if($val->Kd_Rek_Gab != $kd_reg_gab)
                {
                    echo '
                                <tr>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $num . '
                                    </td>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                        ' . date_indo($val->Tgl_Bukti) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . $val->No_Bukti . '
                                    </td>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                        ' . $val->Keterangan . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Saldo, 2) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Kredit, 2) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Saldo, 2) . '
                                    </td>
                                </tr>
                            ';
                    //$num++;
                }
                echo'
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="border text-sm text-right">
                                <b>
                                    JUMLAH
                                </b>
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_debet, 2) . '
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_kredit, 2) . '
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_saldo, 2) . '
                            </td>
                        </tr>
                    </tfoot>
                </table>
                ';
            }

            //Silpa
            if($val->Kd_Rek_Gab == '6.4')
            {
                echo '
                ' . $silpa . '
                <table class="table">
                    <thead>
                        <tr>
                            <th width="100" class="border no-border-right">
                                <img src="' . $logo_laporan . '" alt="..." width="80" />
                            </th>
                            <th class="border no-border-left" align="center">
                                <h5>
                                    ' . (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'). '
                                </h5>
                                <h3>
                                    BUKU BESAR
                                </h3>
                                <h6>
                                    <i>periode . ' . get_userdata('year') . ' </i>
                                </h6>
                            </th>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="3" class="border no-border-top">
                            <table>
                                <tr>
                                    <td width="13%" class="text-sm-2 no-padding">
                                        <b>Urusan Pemerintahan</b>
                                    </td>
                                    <td width="2%" class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td width="15%" class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Urusan_Gab . '
                                    </td>
                                    <td width="70%" class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Urusan_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Bidang Pemerintahan</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Bidang_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Bidang_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Unit Organisasi</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Unit_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Unit_Gab . '
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm-2 no-padding">
                                        <b>Sub Unit Organisasi</b>
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        :
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Kd_Sub_Gab . '
                                    </td>
                                    <td class="text-sm-2 no-padding">
                                        ' . $results['data_query'][0]->Nm_Sub_Unit_Gab . '
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </thead>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                    <td colspan="3" class="border no-border-top">
                        <table>
                            <tr>
                                <td width="15%" class="text-sm-2 no-padding">
                                    Kode Rekening Buku Besar
                                </td>
                                <td width="2%" class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td width="15%" class="text-sm-2 no-padding">
                                    ' . $val->Kd_Rek_Gab  . '
                                </td>
                                <td width="68%" class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Nama Rekening Buku Besar
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding">
                                    ' . $val->Nm_Rek  . '
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Pagu APBD
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding text-right">
                                    (' . number_format_indo($val->APBD, 2)  . ')
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    Pagu Perubahan APBD
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding text-right">
                                    (' . number_format_indo($val->Perubahan, 2)  . ')
                                </td>
                                <td class="text-sm-2 no-padding">

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </thead>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border text-sm-2" width="4%">
                            NO
                        </th>
                        <th class="border text-sm-2" width="10%">
                            TANGGAL
                        </th>
                        <th class="border text-sm-2" width="12%">
                            NO BUKTI
                        </th>
                        <th class="border text-sm-2" width="38%">
                            URAIAN
                        </th>
                        <th class="border text-sm-2" width="12%">
                            DEBET
                        </th>
                        <th class="border text-sm-2" width="12%">
                            KREDIT
                        </th>
                        <th class="border text-sm-2" width="12%">
                            SALDO
                        </th>
                    </tr>
                    </thead>
                    <tbody>';
                        if($val->Kd_Rek_Gab != $kd_reg_gab)
                        {
                            echo '
                                <tr>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $num . '
                                    </td>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                        ' . date_indo($val->Tgl_Bukti) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . $val->No_Bukti . '
                                    </td>
                                    <td class="border text-sm no-border-top no-border-bottom">
                                        ' . $val->Keterangan . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Saldo, 2) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Kredit, 2) . '
                                    </td>
                                    <td class="border text-sm text-right no-border-top no-border-bottom">
                                        ' . number_format_indo($val->Saldo, 2) . '
                                    </td>
                                </tr>
                            ';
                            //$num++;
                        }
                        echo'
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="border text-sm text-right">
                                <b>
                                    JUMLAH
                                </b>
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_debet, 2) . '
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_kredit, 2) . '
                            </td>
                            <td class="border text-sm text-right">
                                ' . number_format_indo($total_saldo, 2) . '
                            </td>
                        </tr>
                    </tfoot>
                </table>
                ';
            }

            $kd_reg_gab                             = $val->Kd_Rek_Gab;
            $lewat_tanggal                          = $val->Tgl_Bukti;
        }
        ?>

        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td class="border no-border-top">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
            </tr>
            </tbody>
        </table>
		<htmlpagefooter name="footer">
			<table class="table print">
				<tfoot>
					<tr>
						<td class="border text-sm no-border-right" colspan="3">
							<i>
								Sumber Dana -
								<?php echo phrase('document_has_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' {DATE F d Y, H:i:s}'; ?>
							</i>
						</td>
						<td class="border text-sm text-right no-border-left">
							<?php echo phrase('page') . ' {PAGENO} dari {nb}'; ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</htmlpagefooter>
	</body>
</html>
