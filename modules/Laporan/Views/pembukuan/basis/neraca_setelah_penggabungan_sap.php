<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'Pembukuan Basis Neraca Setelah Penggabungan' ?>
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
							NERACA
						</h3>
                        <h6>
                            <i>Tahun Anggaran <?php echo get_userdata('year'); ?></i>
                        </h6>
					</th>
				</tr>
			</thead>
		</table>
        <table class="table">
            <thead>
            <tr>
                <th class="border text-sm-2" width="60%">
                    URAIAN
                </th>
                <th class="border text-sm-2" width="20%">
                    2021
                </th>
                <th class="border text-sm-2" width="20%">
                    2020
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
                $kd_rek_1                           = 0;
                $kd_rek_2                           = 0;
                $kd_rek_3                           = 0;
                $kd_rek_4                           = 0;
                $saldox1                            = 0;
                $saldox0                            = 0;
                $saldox1_jumlah                     = 0;
                $saldox0_jumlah                     = 0;
                foreach($results['data_query'] as $key => $val)
                {
                    $saldox1_jumlah                 += $val->SaldoX1;
                    $saldox0_jumlah                 += $val->SaldoX0;

                    if($val->Kd_Rek_1 != $kd_rek_1)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    <b>' . $val->Nm_Rek_1 . '</b>
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
    
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
    
                                </td>
                            </tr>
                        ';
                    }

                    if($val->Kd_Rek_2 != $kd_rek_2)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:15px">
                                    ' . $val->Nm_Rek_2 . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">

                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">

                                </td>
                            </tr>
                        ';
                    }

                    if($val->Kd_Rek_3 != $kd_rek_3)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:25px">
                                    ' . $val->Nm_Rek_3 . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->SaldoX1, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->SaldoX0, 2) . '
                                </td>
                            </tr>
                        ';
                    }

                    if($val->Kd_Rek_4 != $kd_rek_4)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom" style="padding-left:25px">
                                    ' . $val->Nm_Rek_4 . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->SaldoX1, 2) . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->SaldoX0, 2) . '
                                </td>
                            </tr>
                        ';
                    }

                    $kd_rek_1                       = $val->Kd_Rek_1;
                    $kd_rek_2                       = $val->Kd_Rek_2;
                    $kd_rek_3                       = $val->Kd_Rek_3;
                    $kd_rek_4                       = $val->Kd_Rek_4;
                }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="border text-sm text-right">
                    <b>
                        JUMLAH KEWAJIBAN DAN EKUITAS DANA
                    </b>
                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($saldox1_jumlah, 2); ?>
                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($saldox0_jumlah, 2); ?>
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
