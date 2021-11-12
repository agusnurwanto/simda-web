<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit_Gab));
?>
<!DOCTYPE html>
<html>
    <head>
    <title>
		<?php echo 'Bendahara pengeluaran - ' . $title; ?>
    </title>
    <link rel="icon" type="image/x-icon" href="<?php echo get_image('settings', get_setting('app_icon'), 'icon'); ?>" />

    <style type="text/css">
        @page
        {
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
        <table class="table">
            <thead>
            <tr>
                <th width="100" class="border no-border-right">
                    <img src="<?php echo $logo_laporan; ?>" alt="..." width="80" />
                </th>
                <th class="border no-border-left" align="center">
                    <h5>
                        <?php echo (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'); ?>
                    </h5>
                    <h3>
                        SURAT PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN
                    </h3>
                    <h6>
                        ATAS SPJ NOMOR : <?php echo $nama_pemda; ?>
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
                            <td width="20%" class="text-sm-2 no-padding">
                                <b>Urusan Pemerintahan</b>
                            </td>
                            <td width="2%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td width="21%" class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Kd_Gab_Bidang; ?>
                            </td>
                            <td width="57%" class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Nm_Bidang_Gab; ?>
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
                                <?php echo $results['data_query'][0]->Kd_Gab_Unit; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Nm_Unit_Gab; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>Sub Unit</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Kd_Gab_Sub; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Nm_Sub_Unit_Gab; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top">
                    <table>
                        <tr>
                            <td width="43%" class="text-sm-2 no-padding">
                                <b>Pengguna Anggaran/Kuasa Pengguna Anggaran</b>
                            </td>
                            <td width="2%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Nm_Pimpinan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="43%" class="text-sm-2 no-padding">
                                <b>Bendahara Pengeluaran</b>
                            </td>
                            <td width="2%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
                                <?php echo $results['data_query'][0]->Nm_Bendahara; ?>
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
                <th rowspan="2" class="border text-sm-2" width="11%">
                    KODE
                </th>
                <th rowspan="2" class="border text-sm-2" width="30%">
                    URAIAN
                </th>
                <th rowspan="2" class="border text-sm-2">
                    JUMLAH
                    <br />
                    ANGGARAN
                </th>
                <th rowspan="2" class="border text-sm-2">
                    s.d. SPJ LALU
                </th>
                <th colspan="2" class="border text-sm-2">
                    SPJ INI
                </th>
                <th rowspan="2" class="border text-sm-2">
                    s.d. SPJ INI
                </th>
                <th rowspan="2" class="border text-sm-2">
                    s.d. SPJ INI
                </th>
            </tr>
            <tr>
                <th class="border no-border-top text-sm-2">
                    LS
                </th>
                <th class="border no-border-top text-sm-2">
                    GU / NIHIL
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
                $num								= 1;
                $nm_kode						    = 0;
                $kd_gab_prog					    = 0;
                $kd_sub_kegiatan					= 0;
                $kd_gab_keg						    = 0;
                $kd_gab_sub_keg						= 0;
                $kd_gab_rek						    = 0;
                $total_anggaran					    = 0;
                $total_SPJ_L					    = 0;
                $total_SPJ_I_LS					    = 0;
                $total_SPJ_I_GU					    = 0;
                $total_SPJ_T					    = 0;
                $total_Sisa					        = 0;
                foreach($results['data_query'] as $key => $val)
                {
	                $no_border_top                  = $val->Kode == '1' ? 'no-border-top' : '';
	                $no_border_bottom               = $val->Kode == '1' ? 'no-border-bottom' : '';
	                $dotted_bottom                  = $val->Kode == '2' ? 'dotted-bottom' : '';

                    if($val->Kode != $nm_kode)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    <b>' . $val->Nm_Kode . '</b>
                                </td>
                                <td class="border text-sm text-center no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm text-center no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm text-left no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm-2 text-right no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm-2 text-right no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm-2 text-right no-border-top no-border-bottom">

                                </td>
                            </tr>
                        ';
                    }

	                if($val->Kode != $nm_kode || $val->Kd_Gab_Prog != $kd_gab_prog)
	                {
		                echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Kd_Gab_Prog . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    <b>' . $val->nm_Program . '</b>
                                </td>
                                <td class="border text-sm ' . $no_border_top . ' '. $no_border_bottom .'">

                                </td>
                                <td class="border text-sm ' . $no_border_top . ' '. $no_border_bottom .'">

                                </td>
                                <td class="border text-sm ' . $no_border_top . ' '. $no_border_bottom .'">

                                </td>
                                <td class="border text-sm ' . $no_border_top . ' '. $no_border_bottom .'">

                                </td>
                                <td class="border text-sm ' . $no_border_top . ' '. $no_border_bottom .'">

                                </td>
                                <td class="border text-sm ' . $no_border_top . ' '. $no_border_bottom .'">

                                </td>
                            </tr>

                        ';
	                }

	                if($val->Kd_Gab_Keg != $kd_gab_keg)
	                {
		                echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Kd_Gab_Keg . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:10px">
                                    <b><i>' . $val->nm_Kegiatan . '</i></b>
                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">
                                    
                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">
  
                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">
                                    
                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">
                                    
                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">
                                    
                                </td>
                            </tr>
                        ';
	                }

	                if($val->Kd_Gab_Sub_Keg != $kd_gab_sub_keg)
	                {
		                $SPJ_I_LS                   = $val->Kode == '2' ? number_format_indo($val->SPJ_I_LS, 2) : '';
//		                $SPJ_I_LS                   = $val->SPJ_I_LS;
//		                $SPJ_I_LSaa                 += $SPJ_I_LS;
		                echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Kd_Gab_Sub_Keg . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:15px">
                                    <i>' . $val->nm_sub_kegiatan . '</i>
                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                                <td class="border text-sm text-center no-border-top '.$no_border_bottom.' '.$dotted_bottom.'">

                                </td>
                            </tr>
                        ';
	                }

	                if($val->Kode == 1 && $val->Kd_Gab_Rek != $kd_gab_rek)
	                {
		                $total_anggaran				+= $val->Anggaran;
		                $total_SPJ_L				+= $val->SPJ_L;
		                $total_SPJ_I_LS				+= $val->SPJ_I_LS;
		                $total_SPJ_I_GU				+= $val->SPJ_I_GU;
		                $total_SPJ_T				+= $val->SPJ_T;
		                $total_Sisa				    += $val->Sisa;
		                echo '
                            <tr>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . $val->Kd_Gab_Rek . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:20px">
                                    ' . $val->Nm_Rek90_6 . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->Anggaran, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->SPJ_L, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->SPJ_I_LS, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                   ' . number_format_indo($val->SPJ_I_GU, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                   ' . number_format_indo($val->SPJ_T, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                   ' . number_format_indo($val->Sisa, 2) . '
                                </td>
                            </tr>
                        ';
	                }

	                $nm_kode                        = $val->Kode;
	                $kd_gab_prog                    = $val->Kd_Gab_Prog;
	                $kd_sub_kegiatan                = $val->kd_sub_kegiatan;
	                $kd_gab_keg                     = $val->Kd_Gab_Keg;
	                $kd_gab_sub_keg                 = $val->Kd_Gab_Sub_Keg;
	                $kd_gab_rek                     = $val->Kd_Gab_Rek;
    	            $num++;
                }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="border text-sm text-center">
                        <b>
                            SUB TOTAL
                        </b>
                    </td>
                    <td class="border text-sm text-right">
                        <b>
                            <?php echo number_format_indo($total_anggaran, 2); ?>
                        </b>
                    </td>
                    <td class="border text-sm text-right">
                        <b>
                            <?php echo number_format_indo($total_SPJ_L, 2); ?>
                        </b>
                    </td>
                    <td class="border text-sm text-right">
                        <b>
                            <?php echo number_format_indo($total_SPJ_I_LS, 2); ?>
                        </b>
                    </td>
                    <td class="border text-sm text-right">
                        <b>
                            <?php echo number_format_indo($total_SPJ_I_GU, 2); ?>
                        </b>
                    </td>
                    <td class="border text-sm text-right">
                        <b>
                            <?php echo number_format_indo($total_SPJ_T, 2); ?>
                        </b>
                    </td>
                    <td class="border text-sm text-right">
                        <b>
                            <?php echo number_format_indo($total_Sisa, 2); ?>
                        </b>
                    </td>
                </tr>
            </tfoot>
        </table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td colspan="3" class="border no-border-top no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-top no-border-left">
                    <?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                    <br />
                    <b><?php
                        echo strtoupper($results['data_query'][0]->Jbt_Bendahara);
                        ?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
                            echo $results['data_query'][0]->Nm_Bendahara;
                            ?></b></u>
                    <br />
                    <?php
                    echo 'NIP. '. $results['data_query'][0]->Nip_Bendahara;
                    ?>
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
