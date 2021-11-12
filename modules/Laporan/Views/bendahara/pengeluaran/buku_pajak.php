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
							BUKU PEMBANTU PAJAK
						</h3>
                        <h5>
                            BENDAHARA PENGELUARAN
                        </h5>
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
                                <b>Urusan Pemerintahan</b>
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
                                <b>Bidang Urusan</b>
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
                                <b>Unit</b>
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
                                <b>Sub Unit</b>
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
                <th class="border no-border-top text-sm" width="5%">
                    NO
                </th>
                <th class="border no-border-top text-sm" width="13%">
                    TGL
                </th>
                <th class="border no-border-top text-sm" width="17%">
                    NO BUKTI
                </th>
                <th class="border no-border-top text-sm" width="20%">
                    URAIAN
                </th>
                <th class="border no-border-top text-sm" width="15%">
                    PEMOTONGAN
                </th>
                <th class="border no-border-top text-sm" width="15%">
                    PENYETORAN
                </th>
                <th class="border no-border-top text-sm" width="15%">
                    SALDO
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $num								    = 1;
            $kd_gab_keg					            = 0;
            $debet					                = 0;
            $kredit					                = 0;
            $saldo					                = 0;
            $total_debet					        = 0;
            $total_kredit					        = 0;
            $total_saldo						    = 0;
            $lewat_tanggal						    = 0;
            foreach($results['data_query'] as $key => $val)
            {
	            $debet						        = (($val->Debet) ? $val->Debet : null);
	            $kredit						        = (($val->Kredit) ? $val->Kredit : null);
	            $saldo						        = (($val->Saldo) ? $val->Saldo : null);
	            $total_debet				        += $debet;
	            $total_kredit				        += $kredit;
	            $total_saldo				        += $saldo;
	            if($val->Kd_Gab_Keg != $kd_gab_keg)
                {
                    echo '
                        <tr>
                            <td class="border text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border no-border-top no-border-bottom"> ';
                            if($val->Tanggal != $lewat_tanggal)
                            {
                                echo date_indo($val->Tanggal);
                            }
                            echo '
                            </td>
                            <td class="border small text-center no-border-top no-border-bottom">
                                ' . $val->No_Bukti . '
                            </td>
                                <td class="border no-border-top no-border-bottom">
                                    ' . $val->Kd_Gab_Keg . ' &nbsp; &nbsp; ' . $val->Keterangan . '
                                </td>
                                <td class="border text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->Debet, 2) . '
                                </td>
                                <td class="border text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->Kredit, 2) . '
                                </td>
                                <td class="border text-right no-border-top no-border-bottom">
                                    (' . number_format_indo($val->Saldo, 2) . ')
                                </td>
                        </tr>
                    ';
                }
	            $kd_gab_keg                         = $val->Kd_Gab_Keg;
	            $lewat_tanggal                      = $val->Tanggal;
	            $num++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" class="border text-sm text-center">
                    <b>
                        JUMLAH
                    </b>
                </td>
                <td class="border text-sm text-right">
                    <b>
				        <?php echo number_format_indo($total_debet, 2); ?>
                    </b>
                </td>
                <td class="border text-sm text-right">
                    <b>
				        <?php echo number_format_indo($total_kredit, 2); ?>
                    </b>
                </td>
                <td class="border text-sm text-right">
                    <b>
				        (<?php echo number_format_indo($total_saldo, 2); ?>)
                    </b>
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
				            echo $results['data_query'][0]->Nm_Pimpinan;
				            ?></b></u>
                    <br />
		            <?php
		            echo 'NIP. '. $results['data_query'][0]->Nip_Pimpinan;
		            ?>
                </td>
                <td class="text-center border no-border-top no-border-left no-border-right">
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
							echo $results['data_query'][0]->Nm_Bendahara
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
