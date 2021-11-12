<?php
    $title		                                    = ($results['kd_sub'] != '%' ? ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit)) : $title );
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
							LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA DAERAH
						</h3>
                        <h6>
                            <i>Periode 31 DESEMBER <?php echo get_userdata('year'); ?></i>
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
                                    ' . $results['data_query'][0]->Kd_Gab_Bidang . '
                                </td>
                                <td width="70%" class="text-sm-2 no-padding">
                                    ' . $results['data_query'][0]->Nm_Bidang . '
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
                                    ' . $results['data_query'][0]->Kd_Gab_Unit . '
                                </td>
                                <td class="text-sm-2 no-padding">
                                    ' . $results['data_query'][0]->Nm_Unit . '
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
                                    ' . $results['data_query'][0]->Kd_Gab_Sub . '
                                </td>
                                <td class="text-sm-2 no-padding">
                                    ' . $results['data_query'][0]->Nm_Sub_Unit . '
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
                <th rowspan="2" class="border text-sm-2" width="10%">
                    KODE REKENING
                </th>
                <th rowspan="2" class="border text-sm-2" width="30%">
                    URAIAN
                </th>
                <th rowspan="2" class="border text-sm-2" width="12%">
                    ANGGARAN
                </th>
                <th colspan="3" class="border text-sm-2" width="36%">
                    REALISASI
                </th>
                <th rowspan="2" class="border text-sm-2" width="12%">
                    LEBIH / (KURANG)
                </th>
            </tr>
            <tr>
                <th class="border text-sm-2" width="12%">
                    s/d PERIODE LALU
                </th>
                <th class="border text-sm-2" width="12%">
                    PERIODE INI
                </th>
                <th class="border text-sm-2" width="12%">
                    TOTAL
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($results['belanja_query'] as $keyBelanja => $valBelanja)
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                               ' . $valBelanja->Kd_Rek . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                               <b>' . $valBelanja->Nm_Rek . '</b>
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valBelanja->Anggaran), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valBelanja->Realisasi_Lalu), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valBelanja->Realisasi_Ini), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valBelanja->Realiasi_Total), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valBelanja->Sisa), 2) . '
                            </td>
                        </tr>
                    ';
                }

                $kd_rek_data					    = 0;
                foreach($results['data_query'] as $keyData => $valData)
                {
                    if($valData->Kd_Rek != $kd_rek_data)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                   ' . $valData->Kd_Rek . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:10px">
                                   <b>' . $valData->Nm_Rek . '</b>
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo(str_replace('-', '', $valData->Anggaran), 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo(str_replace('-', '', $valData->Realisasi_Lalu), 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo(str_replace('-', '', $valData->Realisasi_Ini), 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo(str_replace('-', '', $valData->Realiasi_Total), 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo(str_replace('-', '', $valData->Sisa), 2) . '
                                </td>
                            </tr>
                        ';
                    }

                    $kd_rek_data                        = $valData->Kd_Rek;
                }

                foreach($results['surplus_query'] as $keySurplus => $valSurplus)
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                            
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom" style="padding-left:10px">
                               <b>' . $valSurplus->Nm_Rek . '</b>
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSurplus->Anggaran), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSurplus->Realisasi_Lalu), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSurplus->Realisasi_Ini), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSurplus->Realiasi_Total), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSurplus->Sisa), 2) . '
                            </td>
                        </tr>
                    ';
                }

                foreach($results['sisa_query'] as $keySisa => $valSisa)
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                            
                            </td>
                            <td class="border text-right text-sm no-border-top no-border-bottom" style="padding-left:10px">
                               <b>' . $valSisa->Nm_Rek . '</b>
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSisa->Anggaran), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSisa->Realisasi_Lalu), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSisa->Realisasi_Ini), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSisa->Realiasi_Total), 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace('-', '', $valSisa->Sisa), 2) . '
                            </td>
                        </tr>
                    ';
                }
            ?>
            </tbody>
        </table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td class="text-left border">
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
