<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo $title; ?>
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
							ALOKASI TRIWULAN
						</h4>
						<h4>
							TAHUN ANGGARAN <?php echo get_userdata('year'); ?>
						</h4>
					</th>
				</tr>
			</thead>
		</table>
		<table class="table">
			<tr>
				<td class="border no-border-bottom no-border-top no-border-right no-padding" style="padding-left:8px" width="15%">
					Urusan Pemerintahan
				</td>
				<td class="no-padding" align="center" width="3%">
					:
				</td>
				<td class="no-padding" width="12%">
					<?php echo $results['header']->kd_urusan; ?>
				</td>
				<td class="border no-border-bottom no-border-top no-border-left no-padding" width="70%">
					<?php echo $results['header']->nm_urusan; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-bottom no-border-top no-border-right no-padding" style="padding-left:8px">
					Bidang Pemerintahan
				</td>
				<td class="no-padding" align="center">
					:
				</td>
				<td class="no-padding">
					<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?>
				</td>
				<td class="border no-border-bottom no-border-top no-border-left no-padding">
					<?php echo $results['header']->nm_bidang; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-bottom no-border-top no-border-right no-padding" style="padding-left:8px">
					Unit Organisasi
				</td>
				<td class="no-padding" align="center">
					:
				</td>
				<td class="no-padding">
					<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit); ?>
				</td>
				<td class="border no-border-bottom no-border-top no-border-left no-padding">
					<?php echo $results['header']->nm_unit; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-bottom no-border-top no-border-right no-padding" style="padding-left:8px">
					Sub Unit Organisasi
				</td>
				<td class="no-padding" align="center">
					:
				</td>
				<td class="no-padding">
					<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . '.' . sprintf('%02d', $results['header']->kd_sub); ?>
				</td>
				<td class="border no-border-bottom no-border-top no-border-left no-padding">
					<?php echo $results['header']->nm_sub_unit; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-bottom no-border-top no-border-right no-padding" style="padding-left:8px">
					Program
				</td>
				<td class="no-padding" align="center">
					:
				</td>
				<td class="no-padding">
					<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . '.' . sprintf('%02d', $results['header']->kd_sub) . '.' . sprintf('%02d', $results['header']->kd_prog); ?>
				</td>
				<td class="border no-border-bottom no-border-top no-border-left no-padding">
					<?php echo $results['header']->nm_program; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-bottom no-border-top no-border-right no-padding" style="padding-left:8px">
					Kegiatan
				</td>
				<td class="no-padding" align="center">
					:
				</td>
				<td class="no-padding">
					<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . '.' . sprintf('%02d', $results['header']->kd_sub) . '.' . sprintf('%02d', $results['header']->kd_prog) . '.' . sprintf('%02d', $results['header']->kd_keg); ?>
				</td>
				<td class="border no-border-bottom no-border-top no-border-left no-padding">
					<?php echo $results['header']->nm_kegiatan; ?>
				</td>
			</tr>
			<tr>
				<td class="border no-border-top no-border-right no-padding" style="padding-left:8px">
					Pagu
				</td>
				<td class="border no-border-top no-border-left no-border-right no-padding" align="center">
					:
				</td>
				<td class="border no-border-top no-border-left no-border-right no-padding" style="padding-right:8px" align="right">
					<?php echo number_format_indo($results['header']->pagu, 2); ?>
				</td>
				<td class="border no-border-top no-border-left no-padding">
					<?php echo terbilang($results['header']->pagu); ?> Rupiah
				</td>
			</tr>
		</table>
		<table class="table">
			<thead>
				<tr>
					<th class="border" width="8%">
						KODE
					</th>
					<th class="border" width="32%">
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
			<tbody>
				<?php
					$id_rek_3						= 0;
					$id_rek_4						= 0;
					$id_rek_5						= 0;
					$total_rekening					= 0;
					$total_tw_1						= 0;
					$total_tw_2						= 0;
					$total_tw_3						= 0;
					$total_tw_4						= 0;
					$selisih_rek_3					= 0;
					$selisih_rek_4					= 0;
					$selisih_rek_5					= 0;
					$total_selisih					= 0;
					foreach($results['data'] as $key => $val)
					{
						if($val->id_rek_3 != $id_rek_3)
						{
							$selisih_rek_3				= $val->pagu_rek_3 - $val->rencana_rek_3_tw_1 - $val->rencana_rek_3_tw_2 - $val->rencana_rek_3_tw_3 - $val->rencana_rek_3_tw_4;
							echo '
								<tr>
									<td class="border">
										<b>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '</b>
									</td>
									<td class="border">
										<b>' . $val->uraian_rek_3 . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->pagu_rek_3, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_3_tw_1, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_3_tw_2, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_3_tw_3, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_3_tw_4, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($selisih_rek_3, 2) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_rek_4 != $id_rek_4)
						{
							$selisih_rek_4				= $val->pagu_rek_4 - $val->rencana_rek_4_tw_1 - $val->rencana_rek_4_tw_2 - $val->rencana_rek_4_tw_3 - $val->rencana_rek_4_tw_4;
							echo '
								<tr>
									<td class="border">
										<b>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '</b>
									</td>
									<td style="padding-left:8px" class="border">
										<b>' . $val->uraian_rek_4 . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->pagu_rek_4, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_4_tw_1, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_4_tw_2, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_4_tw_3, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($val->rencana_rek_4_tw_4, 2) . '</b>
									</td>
									<td class="border" align="right">
										<b>' . number_format_indo($selisih_rek_4, 2) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_rek_5 != $id_rek_5)
						{
							$selisih_rek_5					= $val->pagu_rek_5 - $val->rencana_rek_5_tw_1 - $val->rencana_rek_5_tw_2 - $val->rencana_rek_5_tw_3 - $val->rencana_rek_5_tw_4;
							echo '	
								<tr>
									<td class="border">
										' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . '
									</td>
									<td style="padding-left:13px" class="border">
										' . $val->uraian_rek_5 . '
									</td>
									<td class="border" align="right">
										' . number_format_indo($val->pagu_rek_5, 2) . '
									</td>
									<td class="border" align="right">
										' . number_format_indo($val->rencana_rek_5_tw_1, 2) . '
									</td>
									<td class="border" align="right">
										' . number_format_indo($val->rencana_rek_5_tw_2, 2) . '
									</td>
									<td class="border" align="right">
										' . number_format_indo($val->rencana_rek_5_tw_3, 2) . '
									</td>
									<td class="border" align="right">
										' . number_format_indo($val->rencana_rek_5_tw_4, 2) . '
									</td>
									<td class="border" align="right">
										' . number_format_indo($selisih_rek_5, 2) . '
									</td>
								</tr>
							';
						}
						$id_rek_3						= $val->id_rek_3;
						$id_rek_4						= $val->id_rek_4;
						$id_rek_5						= $val->id_rek_5;
						$total_rekening					+= $val->pagu_rek_5;
						$total_tw_1						+= $val->rencana_rek_5_tw_1;
						$total_tw_2						+= $val->rencana_rek_5_tw_2;
						$total_tw_3						+= $val->rencana_rek_5_tw_3;
						$total_tw_4						+= $val->rencana_rek_5_tw_4;
						$total_selisih					+= $selisih_rek_5;
					}
				?>
			</tbody>
				<tr>
					<td colspan="2" class="border text-center">
						<b>JUMLAH</b>
					</td>
					<td class="border" align="right">
						<b><?php echo number_format_indo($total_rekening, 2); ?></b>
					</td>
					<td class="border" align="right">
						<b><?php echo number_format_indo($total_tw_1, 2); ?></b>
					</td>
					<td class="border" align="right">
						<b><?php echo number_format_indo($total_tw_2, 2); ?></b>
					</td>
					<td class="border" align="right">
						<b><?php echo number_format_indo($total_tw_3, 2); ?></b>
					</td>
					<td class="border" align="right">
						<b><?php echo number_format_indo($total_tw_4, 2); ?></b>
					</td>
					<td class="border" align="right">
						<b><?php echo number_format_indo($total_selisih, 2); ?></b>
					</td>
				</tr>
		</table>
		<table class="table" style="page-break-inside:avoid">
			<tr>
				<td class="border no-border-right text-center" width="50%">

					<br />
					<b><?php //echo $header['jabatan_kpa']; ?></b>
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<u><b><?php //echo $header['kpa']; ?></b></u>
					<br />
					<?php //echo $header['nip_kpa']; ?>
				</td>
				<td class="border no-border-left text-center" width="50%">
					<?php echo $nama_daerah; ?>, <?php echo ($results['tanggal_anggaran_kas'] ? date_indo($results['tanggal_anggaran_kas']) : null); ?>
					<br />
					<b><?php //echo ($results['header']->jabatan_ppk_skpd ? $results['header']->jabatan_ppk_skpd : null); ?></b>
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<u><b><?php //echo ($results['header']->nama_ppk_skpd ? $results['header']->nama_ppk_skpd : null); ?></b></u>
					<br />
					<?php //echo ($results['header']->nip_ppk_skpd ? 'NIP. ' . $results['header']->nip_ppk_skpd : null); ?>
				</td>
			</tr>
		</table>
		<htmlpagefooter name="footer">
			<table class="print">
				<tr>
					<td class="border no-border-right text-muted text-sm">
						<i>
							<?php echo phrase('document_has_generated_from') . ' ' . get_setting('app_name') ?>
						</i>
					</td>
					<td class="border no-border-left text-muted text-sm text-right">
						<?php echo phrase('page') . ' {PAGENO} ' . phrase('of') . ' {nb}'; ?>
					</td>
				</tr>
			</table>
		</htmlpagefooter>
	</body>
</html>
