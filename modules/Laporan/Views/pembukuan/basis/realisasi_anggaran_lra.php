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
							LAPORAN REALISASI ANGGARAN
						</h3>
                        <h6>
                            <i>periode <?php echo get_userdata('year'); ?></i>
                        </h6>
					</th>
				</tr>
			</thead>
		</table>
        <?php
        if($results['kd_sub'] != '%')
        {
            echo '
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
		    ';
        }
        ?>
        <table class="table">
            <thead>
            <tr>
                <th class="border text-sm-2" width="3%">
                    NO URUT
                </th>
                <th class="border text-sm-2" width="9%">
                    URAIAN
                </th>
                <th class="border text-sm-2" width="12%">
                    ANGGARAN
                </th>
                <th class="border text-sm-2" width="19%">
                    REALISASI
                </th>
                <th class="border text-sm-2" width="5%">
                    LEBIH / (KURANG)
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $num								    = 1;
            $kd_rek_2					            = 0;
            $kd_gab_2					            = 0;
            $kd_gab_3					            = 0;
            $total_anggaran					        = 0;
            foreach($results['data_query'] as $key => $val)
            {
	            if($val->Kd_Rek_2 != $kd_rek_2)
                {
                    $total_anggaran				    += $val->Anggaran;
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                               ' . $val->Kd_Gab_1 . '
                            </td>';
                            if($val->Nm_Rek_1 == 'SURPLUS / (DEFISIT)' && $val->Kd_Rek_2 == '99')
                            {
                                echo '<td class="border text-sm text-right no-border-top no-border-bottom"><b>' . $val->Nm_Rek_1 . '</b></td>';
                            }
                            elseif($val->Nm_Rek_1 == 'SISA LEBIH PEMBIAYAAN ANGGARAN (SILPA)' && $val->Kd_Rek_2 == '4')
                            {
                                echo '<td class="border text-sm text-right no-border-top no-border-bottom"><b>' . $val->Nm_Rek_1 . '</b></td>';
                            }
                            else
                            {
                                echo '<td class="border text-sm no-border-top no-border-bottom"><b>' . $val->Nm_Rek_1 . '</b></td>';
                            }

                            if($val->Nm_Rek_1 == 'SURPLUS / (DEFISIT)' && $val->Kd_Rek_2 == '99' || $val->Nm_Rek_1 == 'SISA LEBIH PEMBIAYAAN ANGGARAN (SILPA)' && $val->Kd_Rek_2 == '4') {
                                echo '
                                <td class="border text-sm text-right">
                                    ' . number_format_indo(str_replace('-', '', $val->Anggaran), 2) . '
                                </td>
                                <td class="border text-sm text-right">
                                    ' . number_format_indo(str_replace('-', '', $val->Realisasi), 2) . '
                                </td>
                                <td class="border text-sm text-right">
                                    ' . number_format_indo(str_replace('-', '', $val->Selisih), 2) . '
                                </td>
                            ';
                            }
                            else
                            {
                                echo '
                                <td class="border text-sm text-right">
                                    
                                </td>
                                <td class="border text-sm text-right">
                                    
                                </td>
                                <td class="border text-sm text-right">
                                    
                                </td>
                            ';
                            }
                    echo ' 
                        </tr>
                    ';
                }

                if($val->Kd_Gab_2 != $kd_gab_2 && empty(!$val->Kd_Gab_2))
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                               ' . $val->Kd_Gab_2 . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom" style="padding-left:10px">
                                <b>' . $val->Nm_Rek_2 . '</b>
                            </td>
                            
                            <td class="border text-sm text-right no-border-top dotted-bottom">
                                
                            </td>
                            <td class="border text-sm text-right no-border-top dotted-bottom">
                                
                            </td>
                            <td class="border text-sm text-right no-border-top dotted-bottom">
                                
                            </td>
                        </tr>
                    ';
                }

                if($val->Kd_Gab_3 != $kd_gab_3 && empty(!$val->Kd_Gab_3))
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                               ' . $val->Kd_Gab_3 . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom" style="padding-left:15px">
                                ' . $val->Nm_Rek_3 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $val->Anggaran), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $val->Realisasi), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $val->Selisih), 2) . '
                            </td>
                        </tr>
                    ';
                }

                $kd_rek_2                           = $val->Kd_Rek_2;
                $kd_gab_2                           = $val->Kd_Gab_2;
                $kd_gab_3                           = $val->Kd_Gab_3;
            }
            ?>
            </tbody>
        </table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td class="border no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-left">
					<?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                    <br />
                    <b><?php
						echo strtoupper($results['data_query'][0]->Jbt_Pimpinan);
						?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
							echo $results['data_query'][0]->Nm_Pimpinan
							?></b></u>
                    <br />
					<?php
					echo 'NIP. '. $results['data_query'][0]->Nip_Pimpinan;
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
