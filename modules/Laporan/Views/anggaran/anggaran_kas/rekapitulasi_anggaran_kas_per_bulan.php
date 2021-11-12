<!DOCTYPE html>
<html>
	<head>
		<title>
			Anggaran Kas per Sub Unit Per Bulan
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
						<h4>
							<?php echo (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'); ?>
						</h4>
						<h4>
							ANGGARAN KAS PER SUB UNIT PER BULAN
						</h4>
						<h4>
							TAHUN ANGGARAN <?php echo get_userdata('year'); ?>
						</h4>
					</th>
				</tr>
			</thead>
		</table>
		<table class="table">
			<thead>
				<tr>
					<th class="border" width="8%">
						KODE
					</th>
					<th class="border" width="32%">
						ORGANISASI
					</th>
					<th class="border" width="10%">
						Pagu
					</th>
					<th class="border" width="10%">
						Januari
					</th>
					<th class="border" width="10%">
						Februari
					</th>
					<th class="border" width="10%">
						Maret
					</th>
					<th class="border" width="10%">
						April
					</th>
					<th class="border" width="10%">
						Mei
					</th>
					<th class="border" width="10%">
						Juni
					</th>
					<th class="border" width="10%">
						Juli
					</th>
					<th class="border" width="10%">
						Agustus
					</th>
					<th class="border" width="10%">
						September
					</th>
					<th class="border" width="10%">
						Oktober
					</th>
					<th class="border" width="10%">
						Nopember
					</th>
					<th class="border" width="10%">
						Desember
					</th>
					<th class="border" width="10%">
						Selisih
					</th>
				</tr>
			</thead>
				<?php
					$total_pagu						= 0;
					$total_jan						= 0;
					$total_feb						= 0;
					$total_mar						= 0;
					$total_apr						= 0;
					$total_mei						= 0;
					$total_jun						= 0;
					$total_jul						= 0;
					$total_agt						= 0;
					$total_sep						= 0;
					$total_okt						= 0;
					$total_nop						= 0;
					$total_des						= 0;
					$selisih						= 0;
					$total_selisih					= 0;
					foreach($results['data'] as $key => $val)
					{
						$selisih					= $val->plafon - $val->jan - $val->feb - $val->mar - $val->apr - $val->mei - $val->jun - $val->jul - $val->agt - $val->sep - $val->okt - $val->nop - $val->des;
						echo '	
							<tr>
								<td class="border text-sm">
									' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . $val->kd_unit . '.' . $val->kd_sub . '
								</td>
								<td class="border text-sm">
									' . $val->nm_sub . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->plafon) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->jan) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->feb) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->mar) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->apr) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->mei) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->jun) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->jul) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->agt) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->sep) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->okt) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->nop) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->des) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($selisih) . '
								</td>
							</tr>
						';
						$total_pagu						+= $val->plafon;
						$total_jan						+= $val->jan;
						$total_feb						+= $val->feb;
						$total_mar						+= $val->mar;
						$total_apr						+= $val->apr;
						$total_mei						+= $val->mei;
						$total_jun						+= $val->jun;
						$total_jul						+= $val->jul;
						$total_agt						+= $val->agt;
						$total_sep						+= $val->sep;
						$total_okt						+= $val->okt;
						$total_nop						+= $val->nop;
						$total_des						+= $val->des;
						$total_selisih					+= $selisih;
					}
				?>
				<tr>
					<td colspan="2" class="border text-center">
						<b>JUMLAH</b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_pagu); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_jan); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_feb); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_mar); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_apr); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_mei); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_jun); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_jul); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_agt); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_sep); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_okt); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_nop); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_des); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_selisih); ?></b>
					</td>
				</tr>
		</table>
		<table class="table" style="page-break-inside:avoid">
			<tr>
				<td class="border no-border-right" width="50%">
<!--					<img src="--><?php //echo get_image('___qrcode', sha1(current_page() . SALT) . '.png'); ?><!--" alt="..." width="100" />-->
				</td>
				<td class="border no-border-left text-center" width="50%">
					<?php echo $nama_daerah; ?>, <?php echo ($tanggal_cetak ? $tanggal_cetak : null); ?>
					<br />
					<b><?php //echo ($results['header']->jabatan_sekretaris_daerah ? $results['header']->jabatan_sekretaris_daerah : null); ?></b>
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<u><b><?php //echo ($results['header']->nama_sekretaris_daerah ? $results['header']->nama_sekretaris_daerah : null); ?></b></u>
					<br />
					<?php //echo ($results['header']->nip_sekretaris_daerah ? 'NIP. ' . $results['header']->nip_sekretaris_daerah : null); ?>
				</td>
			</tr>
		</table>
		<htmlpagefooter name="footer">
			<table class="print">
				<tr>
					<td class="text-muted text-sm">
						<i>
							<?php //echo phrase('document_has_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' {DATE F d Y, H:i:s}'; ?>
						</i>
					</td>
					<td class="text-muted text-sm text-right">
						<?php echo phrase('page') . ' {PAGENO} ' . phrase('of') . ' {nb}'; ?>
					</td>
				</tr>
			</table>
		</htmlpagefooter>
	</body>
</html>
