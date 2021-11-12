<?php
    $title                                      = null;
    $title		                                = ucwords(strtolower($results['header']->nm_unit));
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
								<?php echo $results['header']->kd_urusan; ?>
                            </td>
                            <td width="57%" class="text-sm-2 no-padding">
								<?php echo $results['header']->nm_urusan; ?>
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
								<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?>
                            </td>
                            <td class="text-sm-2 no-padding">
								<?php echo $results['header']->nm_bidang; ?>
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
								<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?> . <?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit); ?>
                            </td>
                            <td class="text-sm-2 no-padding">
								<?php echo ucwords(strtolower($results['header']->nm_unit)); ?>
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
								<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?> . <?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . ' . ' . sprintf('%02d', $results['header']->kd_sub); ?>
                            </td>
                            <td class="text-sm-2 no-padding">
								<?php echo ucwords(strtolower($results['header']->nm_sub_unit)); ?>
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
	                            <?php echo $results['header']->nama_pejabat; ?>
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
	                            <?php echo $results['header']->nama_bendahara; ?>
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
                <th class="border no-border-top text-sm" width="10%">
                    NO
                </th>
                <th class="border no-border-top text-sm" width="10%">
                    TGL
                </th>
                <th class="border no-border-top text-sm" width="35%">
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
<!--			--><?php
//			$id_rek_1						= 0;
//			$id_rek_2						= 0;
//			$id_rek_3						= 0;
//			$penerimaan_pembiayaan			= 0;
//			$pengeluaran_pembiayaan			= 0;
//			foreach($results['pendapatan'] as $key => $val)
//			{
//				if($val->id_rek_1 != $id_rek_1)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										<b>' . $val->kd_rek_1 . '</b>
//									</td>
//									<td class="border text-sm">
//										<b>' . $val->nm_rek_1 . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->subtotal_rek_1, 2) . '</b>
//									</td>
//								</tr>
//							';
//				}
//				if($val->id_rek_2 != $id_rek_2)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										<b>' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . '</b>
//									</td>
//									<td style="padding-left:8px" class="border text-sm">
//										<b>' . $val->nm_rek_2 . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->subtotal_rek_2, 2) . '</b>
//									</td>
//								</tr>
//							';
//				}
//				if($val->id_rek_3 != $id_rek_3)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . ' . ' . $val->kd_rek_3 . '
//									</td>
//									<td style="padding-left:13px" class="border text-sm">
//										' . $val->nm_rek_3 . '
//									</td>
//									<td class="border text-right text-sm">
//										' . number_format_indo($val->subtotal_rek_3, 2) . '
//									</td>
//								</tr>
//							';
//				}
//				$id_rek_1					= $val->id_rek_1;
//				$id_rek_2					= $val->id_rek_2;
//				$id_rek_3					= $val->id_rek_3;
//			}
//			?>
<!--			--><?php
//			$id_rek_1						= 0;
//			$id_rek_2						= 0;
//			$id_rek_3						= 0;
//			foreach($results['belanja'] as $key => $val)
//			{
//				if($val->id_rek_1 != $id_rek_1)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										<b>' . $val->kd_rek_1 . '</b>
//									</td>
//									<td class="border text-sm">
//										<b>' . $val->nm_rek_1 . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->subtotal_rek_1, 2) . '</b>
//									</td>
//								</tr>
//							';
//				}
//				if($val->id_rek_2 != $id_rek_2)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										<b>' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . '</b>
//									</td>
//									<td style="padding-left:8px" class="border text-sm">
//										<b>' . $val->nm_rek_2 . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->subtotal_rek_2, 2) . '</b>
//									</td>
//								</tr>
//							';
//				}
//				if($val->id_rek_3 != $id_rek_3)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . ' . ' . $val->kd_rek_3 . '
//									</td>
//									<td style="padding-left:13px" class="border text-sm">
//										' . $val->nm_rek_3 . '
//									</td>
//									<td class="border text-right text-sm">
//										' . number_format_indo($val->subtotal_rek_3, 2) . '
//									</td>
//								</tr>
//							';
//				}
//				$id_rek_1					= $val->id_rek_1;
//				$id_rek_2					= $val->id_rek_2;
//				$id_rek_3					= $val->id_rek_3;
//			}
//			$surplus		= 	(isset($results['pendapatan'][0]->subtotal_rek_1) ? $results['pendapatan'][0]->subtotal_rek_1 : 0) -
//				(isset($results['belanja'][0]->subtotal_rek_1) ? $results['belanja'][0]->subtotal_rek_1 : 0);
//			if($surplus < 0)
//			{
//				$surplus	= '(' . number_format_indo($surplus * -1, 2) . ')';
//			}
//			else
//			{
//				$surplus	= number_format_indo($surplus, 2);
//			}
//			?>
<!--            <tr>-->
<!--                <td style="padding-left:10px" class="border text-sm">-->
<!---->
<!--                </td>-->
<!--                <td style="padding-right:10px" class="border text-sm text-right">-->
<!--                    <b>Surplus / <i>(Defisit)</i></b>-->
<!--                </td>-->
<!--                <td class="border text-right text-sm">-->
<!--                    <b>--><?php //echo $surplus; ?><!--</b>-->
<!--                </td>-->
<!--            </tr>-->
<!--			--><?php
//			$id_rek_1						= 0;
//			$id_rek_2						= 0;
//			$id_rek_3						= 0;
//			foreach($results['pembiayaan'] as $key => $val)
//			{
//				if($val->id_rek_1 != $id_rek_1)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										<b>' . $val->kd_rek_1 . '</b>
//									</td>
//									<td class="border text-sm">
//										<b>' . $val->nm_rek_1 . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->subtotal_rek_1, 2) . '</b>
//									</td>
//								</tr>
//							';
//				}
//				if($val->id_rek_2 != $id_rek_2)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										<b>' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . '</b>
//									</td>
//									<td style="padding-left:8px" class="border text-sm">
//										<b>' . $val->nm_rek_2 . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->subtotal_rek_2, 2) . '</b>
//									</td>
//								</tr>
//							';
//					if($val->kd_rek_2 == 1)
//					{
//						$penerimaan_pembiayaan			= ($val->subtotal_rek_2 ? $val->subtotal_rek_2 : 0);
//					}
//					else
//					{
//						$pengeluaran_pembiayaan			= ($val->subtotal_rek_2 ? $val->subtotal_rek_2 : 0);
//					}
//				}
//				if($val->id_rek_3 != $id_rek_3)
//				{
//					echo '
//								<tr>
//									<td style="padding-left:10px" class="border text-sm">
//										' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . ' . ' . $val->kd_rek_3 . '
//									</td>
//									<td style="padding-left:13px" class="border text-sm">
//										' . $val->nm_rek_3 . '
//									</td>
//									<td class="border text-right text-sm">
//										' . number_format_indo($val->subtotal_rek_3, 2) . '
//									</td>
//								</tr>
//							';
//				}
//				$id_rek_1					= $val->id_rek_1;
//				$id_rek_2					= $val->id_rek_2;
//				$id_rek_3					= $val->id_rek_3;
//			}
//			$surplus		= 	$penerimaan_pembiayaan - $pengeluaran_pembiayaan;
//			if($surplus < 0)
//			{
//				$surplus	= '(' . number_format_indo($surplus * -1, 2) . ')';
//			}
//			else
//			{
//				$surplus	= number_format_indo($surplus, 2);
//			}
//			?>
<!--            <tr>-->
<!--                <td style="padding-left:10px" class="border text-sm">-->
<!--                    &nbsp;-->
<!--                </td>-->
<!--                <td style="padding-right:10px" class="border text-sm text-right">-->
<!--                    <b>Pembiayaan Netto</i></b>-->
<!--                </td>-->
<!--                <td class="border text-right text-sm">-->
<!--                    <b>--><?php //echo $surplus; ?><!--</b>-->
<!--                </td>-->
<!--            </tr>-->
            </tbody>
        </table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td colspan="2" class="text-center border no-border-top no-border-right">
		            Mengetahui,
                    <br />
                    <b><?php
			            echo strtoupper($results['header']->nama_jabatan);
			            ?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
				            echo $results['header']->nama_pejabat;
				            ?></b></u>
                    <br />
		            <?php
		            echo 'NIP. '. $results['header']->nip_pejabat;
		            ?>
                </td>
                <td class="text-center border no-border-top no-border-left no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-top no-border-left">
					<?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                    <br />
                    <b><?php
						echo strtoupper($results['header']->nama_jabatan_bendahara);
						?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
							echo $results['header']->nama_bendahara;
							?></b></u>
                    <br />
					<?php
					echo 'NIP. '. $results['header']->nip_bendahara;
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
