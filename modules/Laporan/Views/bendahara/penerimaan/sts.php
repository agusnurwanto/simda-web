<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['header_query']->nm_sub_unit));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'Bendahara penerimaan - ' . $title; ?>
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
                    SURAT TANDA SETORAN
                    <br />
                    (STS)
                </h3>
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
                        <td colspan="2" class="text-sm-2 no-padding" style="padding-left:30px">
	                        STS No. <b><?php echo $results['data_query'][0]->No_STS; ?></b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            Bank
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <?php echo $results['data_query'][0]->Nm_Bank; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-sm-2 no-padding">

                        </td>
                        <td class="text-sm-2 no-padding">
                            No. Rekening
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <?php echo $results['data_query'][0]->No_Rekening; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding" style="padding-left:30px">
                            Harap diterima uang sebesar
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <b>Rp. <?php echo number_format_indo($results['data_query'][0]->Nilai, 2); ?></b>
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">

                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding" style="padding-left:30px">
                            (dengan huruf)
                        </td>
                        <td class="text-sm-2 no-padding">
                            <i><?php echo terbilang($results['data_query'][0]->Nilai); ?></i>
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">

                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-sm-2 no-padding">
                            Dengan rincian penerimaan sebagai berikut:
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
            <th class="border text-sm-2" width="5%">
                NO
            </th>
            <th class="border text-sm-2" width="20%">
                KODE REKENING
            </th>
            <th class="border text-sm-2" width="55%">
                URAIAN RINCIAN OBYEK
            </th>
            <th class="border text-sm-2" width="20%">
                JUMLAH (Rp.)
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
	        <?php
	        $num								    = 1;
	        $kd_rek_gab						        = 0;
	        $nilai						            = 0;
	        $jumlah_nilai						    = 0;
	        foreach($results['data_query'] as $key => $val)
	        {
		        $nilai						        = (($val->Nilai) ? $val->Nilai : null);
		        $jumlah_nilai				        += $nilai;
		        if($val->Kd_Rek_Gab != $kd_rek_gab)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Nm_Rek_5 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo($val->Nilai, 2) . '
                            </td>
                        </tr>
                    ';
		        }
		        $kd_rek_gab					        = $val->Kd_Rek_Gab;
		        $num++;
	        }
	        ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="border text-right text-sm-2">
                <b>JUMLAH</b>
            </td>
            <td class="border text-right text-sm-2">
                <?php echo number_format_indo($jumlah_nilai, 2) ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border text-center no-border-bottom text-sm-2">
                Uang tersebut diterima pada tanggal <b><?php echo date_indo($results['data_query'][0]->Tgl_STS) ?></b>
            </td>
        </tr>
        </tfoot>
    </table>
    <table class="table" width="100%" style="page-break-inside:avoid">
        <tbody>
        <tr>
            <td colspan="2" class="text-center border no-border-top no-border-right">
		        Mengetahui,
                <br />
                <b><?php echo $results['data_query'][0]->Jbt_Pimpinan; ?></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><?php echo $results['data_query'][0]->Nm_Pimpinan; ?></u>
                <br />
                Nip. <?php echo $results['data_query'][0]->Nip_Pimpinan; ?>
            </td>
            <td class="border text-center no-border-top no-border-left no-border-right">
                <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
            </td>
            <td colspan="2" class="text-center border no-border-top no-border-left">
                <br />
			    <b></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                </u>
                <br />
                Nip.
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
