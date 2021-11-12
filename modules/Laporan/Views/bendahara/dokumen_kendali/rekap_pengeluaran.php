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
                sheet-size: 8.5in 13in;
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
							BUKU RINCIAN OBYEK BELANJA
						</h3>
                        <h5>
                            BENDAHARA PENGELUARAN
                        </h5>
						<h6>
                            <i>periode 31 Desember <?php echo get_userdata('year'); ?></i>
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
                            <td width="20%" class="text-sm-2 no-padding">
								<?php echo $results['data_query'][0]->Kd_Urusan_Gab; ?>
                            </td>
                            <td width="58%" class="text-sm-2 no-padding">
								<?php echo $results['data_query'][0]->Nm_Urusan_Gab; ?>
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
        <?php
            $total_pendapatan					    = 0;
            $kd_rek_5_gab					        = 0;
            $no_bku					                = 0;
            foreach($results['data_query'] as $key => $val)
            {
                if($val->Kd_Rek_5_Gab != $kd_rek_5_gab)
                {
                    echo '
                        <page_break>
                        <table class="table">
                            <thead>
                            <tr>
                                <td colspan="3" class="border">
                                    <table>
                                        <tr>
                                            <td width="14%" class="text-sm-2 no-padding">
                                                <b>Kode Rekening</b>
                                            </td>
                                            <td width="1%" class="text-sm-2 no-padding">
                                                :
                                            </td>
                                            <td width="80%" class="text-sm-2 no-padding">
                                                ' . $val->Kd_Rek_5_Gab . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm-2 no-padding">
                                                <b>Nama Rekening</b>
                                            </td>
                                            <td class="text-sm-2 no-padding">
                                                :
                                            </td>
                                            <td class="text-sm no-padding">
                                                ' . $val->Nm_Rek_5 . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm-2 no-padding">
                                                <b>Kredit APBD</b>
                                            </td>
                                            <td class="text-sm-2 no-padding">
                                                :
                                            </td>
                                            <td class="text-sm-2 no-padding" style="padding-left:20px">
                                                ' . number_format_indo($val->Anggaran, 2) . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm-2 no-padding">
                                                <b>Tahun Anggaran</b>
                                            </td>
                                            <td class="text-sm-2 no-padding">
                                                :
                                            </td>
                                            <td class="text-sm-2 no-padding">
                                                ' . get_userdata('year') . '
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
                                <th rowspan="2" class="border no-border-top text-sm-2" width="10%">
                                    NO. BKU
                                </th>
                                <th rowspan="2" class="border no-border-top text-sm-2" width="30%">
                                    NO. BUKTI
                                </th>
                                <th colspan="3" class="border no-border-top text-sm-2">
                                    PENGELUARAN
                                </th>
                            </tr>
                            <tr>
                                <th class="border no-border-top text-sm-2" width="20%">
                                    LS
                                </th>
                                <th class="border no-border-top text-sm-2" width="20%">
                                    UP/GU/TU
                                </th>
                                <th class="border no-border-top text-sm-2" width="20%">
                                    JUMLAH
                                </th>
                            </tr>
                            </thead>
                        </table>
                        </page_break>
                    ';
                }

                if($val->No_BKU != $no_bku)
                {
                    echo '
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="border text-sm text-center no-border-top no-border-bottom" width="10%">
                                    ' . $val->No_BKU . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom" width="30%">
                                    ' . $val->No_Bukti . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom" width="20%">
                                    ' . number_format_indo($val->LS, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom" width="20%">
                                    ' . number_format_indo($val->UP, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom" width="20%">
                                    ' . number_format_indo($val->Jumlah, 2) . '
                                </td>
                            </tr>
                        </tbody>
                    </table>
                        ';
                }

                $kd_rek_5_gab                       = $val->Kd_Rek_5_Gab;
                $no_bku                             = $val->No_BKU;
            }

            ?>
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
