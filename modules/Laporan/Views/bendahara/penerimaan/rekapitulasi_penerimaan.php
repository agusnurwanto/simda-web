<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit_Gab));
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
                    BUKU REKAPITULASI PENERIMAAN
                </h3>
                <h6>
                    <i>TAHUN ANGGARAN <?php echo get_userdata('year'); ?></i>
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
                        <td width="30%" class="text-sm-2 no-padding">
                            <b>Urusan Pemerintahan</b>
                        </td>
                        <td width="2%" class="text-sm-2 no-padding">
                            :
                        </td>
                        <td width="15%" class="text-sm-2 no-padding">
                            <?php echo $results['data_query'][0]->Kd_Urusan_Gab; ?>
                        </td>
                        <td width="53%" class="text-sm-2 no-padding">
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
                    <tr>
                        <td colspan="3" class="text-sm-2 no-padding">
                            <b>Penggunaan Anggaran/Kuasa Pengguna Anggaran</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <?php echo $results['data_query'][0]->Nm_Pimpinan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-sm-2 no-padding">
                            <b>Bendahara Penerimaan</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <?php echo $results['data_query'][0]->Nm_Bendahara; ?>
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
            <th class="border text-sm-2" width="15%">
                KODE REKENING
            </th>
            <th class="border text-sm-2" width="28%">
                URAIAN
            </th>
            <th class="border text-sm-2" width="14%">
                TANGGAL
            </th>
            <th class="border text-sm-2" width="18%">
                NO. BUKTI
            </th>
            <th class="border text-sm-2" width="20%">
                JUMLAH
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
	        <?php
	        $num								    = 1;
	        $kd_rek_2_gab						    = 0;
	        $kd_rek_3_gab						    = 0;
	        $kd_rek_4_gab						    = 0;
	        $kd_rek_5_gab						    = 0;
	        $no_bukti						        = 0;
	        $jumlah						            = 0;
	        $jtotal						            = 0;
	        foreach($results['data_query'] as $key => $val)
	        {
		        $jumlah						        = (($val->Jumlah) ? $val->Jumlah : null);
		        $jtotal				                += $jumlah;
		        if($val->Kd_Rek_2_Gab != $kd_rek_2_gab)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_2_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Nm_Rek_2 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-right">
                                &nbsp;
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                &nbsp;
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->Jumlah, 2) . '
                            </td>
                        </tr>
                    ';
		        }
		        if($val->Kd_Rek_3_Gab != $kd_rek_3_gab)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_3_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Nm_Rek_3 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-right">
                                &nbsp;
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                &nbsp;
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->Jumlah, 2) . '
                            </td>
                        </tr>
                    ';
		        }
		        if($val->Kd_Rek_4_Gab != $kd_rek_4_gab)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_4_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Nm_Rek_4 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-right">
                                &nbsp;
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                &nbsp;
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->Jumlah, 2) . '
                            </td>
                        </tr>
                    ';
		        }
		        if($val->Kd_Rek_5_Gab != $kd_rek_5_gab)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_5_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Nm_Rek_5 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-right dotted-bottom">
                                
                            </td>
                            <td class="border text-sm text-right no-border-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right no-border-top dotted-bottom">
                                ' . number_format_indo($val->Jumlah, 2) . '
                            </td>
                        </tr>
                    ';
		        }
		        if($val->No_Bukti != $no_bukti)
                {
	                echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom no-border-right">
                                ' . date_indo($val->Tgl_Bukti) . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . $val->No_Bukti . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo($val->Jumlah, 2) . '
                            </td>
                        </tr>
                    ';
                }
		        $kd_rek_2_gab					    = $val->Kd_Rek_2_Gab;
		        $kd_rek_3_gab					    = $val->Kd_Rek_3_Gab;
		        $kd_rek_4_gab					    = $val->Kd_Rek_4_Gab;
		        $kd_rek_5_gab					    = $val->Kd_Rek_5_Gab;
		        $no_bukti					        = $val->No_Bukti;
		        $num++;
	        }
	        ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="border text-right text-sm-2">
                <b>JUMLAH</b>
            </td>
            <td class="border text-right text-sm-2">
                <?php echo number_format_indo($jtotal, 2) ?>
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
	            <?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
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
