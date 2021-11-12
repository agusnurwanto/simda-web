<!DOCTYPE html>
<html>
	<head>
		<title>
			Anggaran Kas per Sub Kegiatan
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
							ANGGARAN KAS PER SUB KEGIATAN
						</h4>
						<h4>
							TAHUN ANGGARAN <?php echo get_userdata('year'); ?>
						</h4>
					</th>
				</tr>
			</thead>
		</table>
		<?php
			if(isset($results['unit']->kd_urusan))
			{
		?>
		<table class="table">
			<tr>
				<td class="border no-border-top no-border-right no-border-bottom" width="180">
					Urusan Pemerintahan
				</td>
				<td width="1">
					:
				</td>
				<td width="100">
					<?php echo $results['unit']->kd_urusan; ?>
				</td>
				<td class="border no-border-top no-border-left no-border-bottom">
					<?php echo $results['unit']->nm_urusan; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-top no-border-right no-border-bottom">
					Bidang Pemerintahan
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['unit']->kd_urusan . '.' . sprintf('%02d', $results['unit']->kd_bidang); ?>
				</td>
				<td class="border no-border-top no-border-left no-border-bottom">
					<?php echo $results['unit']->nm_bidang; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-top no-border-right no-border-bottom">
					Unit
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['unit']->kd_urusan . '.' . sprintf('%02d', $results['unit']->kd_bidang) . '.' . sprintf('%02d', $results['unit']->kd_unit); ?>
				</td>
				<td class="border no-border-top no-border-left no-border-bottom">
					<?php echo $results['unit']->nm_unit; ?>
				</td>
			</tr>
		</table>
		<?php
			}
		?>
		<table class="table">
			<thead>
				<tr>
					<th class="border" width="10%">
						KODE
					</th>
					<th class="border" width="30%">
						URAIAN
					</th>
					<th class="border" width="10%">
						PAGU
					</th>
					<th class="border" width="10%">
						TW I
					</th>
					<th class="border" width="10%">
						TW II
					</th>
					<th class="border" width="10%">
						TW III
					</th>
					<th class="border" width="10%">
						TW IV
					</th>
					<th class="border" width="10%">
						SELISIH
					</th>
				</tr>
			</thead>
				<?php
					$total_pagu						= 0;
					$total_tw_1						= 0;
					$total_tw_2						= 0;
					$total_tw_3						= 0;
					$total_tw_4						= 0;
					$selisih						= 0;
					foreach($results['data'] as $key => $val)
					{
						$selisih					= $val->pagu - $val->tw_1 - $val->tw_2 - $val->tw_3 - $val->tw_4;
						echo '	
							<tr>
								<td class="border text-sm">
									' . $val->kode_urusan . '.' . sprintf('%02d', $val->kode_bidang) . '.' . sprintf('%02d', $val->kode_unit) . '.' . sprintf('%02d', $val->kode_sub) . '.' . sprintf('%02d', $val->kode_program) . '.' . sprintf('%02d', $val->kode_kegiatan) . '
								</td>
								<td class="border text-sm">
									' . $val->nama_kegiatan . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->pagu) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->tw_1) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->tw_2) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->tw_3) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($val->tw_4) . '
								</td>
								<td class="border text-sm" align="right">
									' . number_format_indo($selisih) . '
								</td>
							</tr>
						';
						$total_pagu						+= $val->pagu;
						$total_tw_1						+= $val->tw_1;
						$total_tw_2						+= $val->tw_2;
						$total_tw_3						+= $val->tw_3;
						$total_tw_4						+= $val->tw_4;
						$selisih						+= $selisih;
					}
				?>
				<tr>
					<td colspan="2" class="border text-sm text-center">
						<b>JUMLAH</b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_pagu); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_tw_1); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_tw_2); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_tw_3); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($total_tw_4); ?></b>
					</td>
					<td class="border text-sm" align="right">
						<b><?php echo number_format_indo($selisih); ?></b>
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
					<b><?php echo ($results['unit']->jabatan ? $results['unit']->jabatan : null); ?></b>
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<u><b><?php echo ($results['unit']->nama_pejabat ? $results['unit']->nama_pejabat : null); ?></b></u>
					<br />
					<?php echo ($results['unit']->nip_pejabat ? 'NIP. ' . $results['unit']->nip_pejabat : null); ?>
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
