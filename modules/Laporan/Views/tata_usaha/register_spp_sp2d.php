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
							REGISTER SPJ - SP2D (UP, TU, LS)
						</h3>
                        <h6>
                            <i>periode <?php echo get_userdata('year'); ?></i>
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
                                <b>Urusan</b>
                            </td>
                            <td width="2%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td width="21%" class="text-sm-2 no-padding">
								<?php echo $results['data_query'][0]->Kd_Urusan_Gab; ?>
                            </td>
                            <td width="57%" class="text-sm-2 no-padding">
								<?php echo $results['data_query'][0]->Nm_Urusan_Gab; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>Bidang</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Kd_Bidang_Gab; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
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
	                            <?php echo $results['data_query'][0]->Kd_Unit_Gab; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Nm_Unit_Gab; ?>
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
	                            <?php echo $results['data_query'][0]->Kd_Sub_Gab; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Nm_Sub_Unit_Gab; ?>
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
                <th rowspan="2" class="border no-border-top text-sm-2" width="5%">
                    NO
                </th>
                <th colspan="3" class="border no-border-top text-sm-2" width="35%">
                    SPP
                </th>
                <th colspan="3" class="border no-border-top text-sm-2" width="35%">
                    SPM
                </th>
                <th colspan="2" class="border no-border-top text-sm-2" width="25%">
                    SP2D
                </th>
            </tr>
            <tr>
                <th class="border no-border-top text-sm-2" width="8%">
                    TANGGAL
                </th>
                <th class="border no-border-top text-sm-2" width="15%">
                    NOMOR
                </th>
                <th class="border no-border-top text-sm-2" width="12%">
                    JUMLAH
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    TANGGAL
                </th>
                <th class="border no-border-top text-sm-2" width="15%">
                    NOMOR
                </th>
                <th class="border no-border-top text-sm-2" width="12%">
                    JUMLAH
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    TANGGAL
                </th>
                <th class="border no-border-top text-sm-2" width="17%">
                    NOMOR
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $num								    = 1;
            $no_sp2d					            = 0;
            $nilai_spp					            = 0;
            $total_nilai_spp					    = 0;
            $nilai_spm					            = 0;
            $total_nilai_spm					    = 0;
            $lewat_tanggal1						    = 0;
            $lewat_tanggal2						    = 0;
            $lewat_tanggal3						    = 0;
            foreach($results['data_query'] as $key => $val)
            {
                $nilai_spp						    = (($val->Nilai_SPP) ? $val->Nilai_SPP : null);
                $nilai_spm						    = (($val->Nilai_SPM) ? $val->Nilai_SPM : null);
                $total_nilai_spp				    += $nilai_spp;
                $total_nilai_spm				    += $nilai_spm;

	            if($val->No_SPP != $no_sp2d)
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">';
                            if($val->Tgl_SPP != $lewat_tanggal1)
                            {
                                echo date_indo($val->Tgl_SPP);
                            }
                            echo '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->No_SPP . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo($val->Nilai_SPP, 2) . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">';
                            if($val->Tgl_SPM != $lewat_tanggal2)
                            {
                                echo date_indo($val->Tgl_SPM);
                            }
                            echo '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->No_SPM . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo($val->Nilai_SPM, 2) . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">';
                            if($val->Tgl_SP2D != $lewat_tanggal3)
                            {
                                echo date_indo($val->Tgl_SP2D);
                            }
                            echo '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->No_SP2D . '
                            </td>
                        </tr>
                    ';
                }
                $no_sp2d                            = $val->No_SPP;
	            $lewat_tanggal1                     = $val->Tgl_SPP;
	            $lewat_tanggal2                     = $val->Tgl_SPM;
	            $lewat_tanggal3                     = $val->Tgl_SP2D;
	            $num++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="border text-sm text-right">
                    <b>TOTAL</b>
                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($total_nilai_spp, 2); ?>
                </td>
                <td colspan="2" class="border text-sm text-right">

                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($total_nilai_spm, 2); ?>
                </td>
                <td colspan="2" class="border text-sm text-right">

                </td>
            </tr>
            </tfoot>
        </table>
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
