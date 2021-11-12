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
				margin: 50
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
				padding: 2px;
				margin-bottom: 15px
			}
			.text-sm
			{
				font-size: 12px
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
				padding: 6px
			}
			td
			{
				vertical-align: top;
				padding: 6px
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
		<table>
			<tr>
				<td width="80">
					<img src="<?php echo get_image('settings', get_setting('reports_logo'), 'thumb'); ?>" alt="..." width="80" />
				</td>
				<td align="center">
					<h2>
						KARTU KENDALI KEGIATAN
					</h2>
					<p>
						<i>
							per <?php echo date_indo(date('Y-m-d')); ?>
						</i>
					</p>
				</td>
			</tr>
		</table>
		
		<div class="divider"></div>
		
		<!-- DESCRIPTION -->
		
		<table class="table">
			<tr>
				<td width="220">
					<b>
						Urusan Pemerintahan
					</b>
				</td>
				<td width="10">
					:
				</td>
				<td width="200">
					<?php echo $results['data'][0]->Kd_Urusan_Gab; ?>
				</td>
				<td>
					<?php echo $results['data'][0]->Nm_Urusan_Gab; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						Bidang Pemerintahan
					</b>
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['data'][0]->Kd_Bidang_Gab; ?>
				</td>
				<td>
					<?php echo $results['data'][0]->Nm_Bidang_Gab; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						Unit Organisasi
					</b>
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['data'][0]->Kd_Unit_Gab; ?>
				</td>
				<td>
					<?php echo $results['data'][0]->Nm_Unit_Gab; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						Sub Unit Organisasi
					</b>
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['data'][0]->Kd_Sub_Gab; ?>
				</td>
				<td>
					<?php echo $results['data'][0]->Nm_Sub_Unit_Gab; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						Program
					</b>
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['data'][0]->Kd_Prog_Gab; ?>
				</td>
				<td>
					<?php echo $results['data'][0]->Ket_Program_Gab; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						Kegiatan
					</b>
				</td>
				<td>
					:
				</td>
				<td>
					<?php echo $results['data'][0]->Kd_Keg_Gab; ?>
				</td>
				<td>
					<?php echo $results['data'][0]->Ket_Kegiatan_Gab; ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						Nama PPTK
					</b>
				</td>
				<td>
					:
				</td>
				<td>
					&nbsp;
				</td>
				<td>
					&nbsp;
				</td>
			</tr>
		</table>
		
		<!-- CONTENT -->
		
		<table class="table">
			<thead>
				<tr>
					<th rowspan="2" class="border" width="3%">
						NO
					</th>
					<th rowspan="2" class="border" width="10%">
						KODE REKENING
					</th>
					<th rowspan="2" class="border" width="22%">
						URAIAN
					</th>
					<th rowspan="2" class="border" width="13%">
						PAGU ANGGARAN
						<br />
						MURNI/INDUK
					</th>
					<th rowspan="2" class="border" width="13%">
						PAGU ANGGARAN
						<br />
						MURNI/PERGESERAN /PERUBAHAN
					</th>
					<th colspan="2" class="border" width="26%">
						REALISASI KEGIATAN
						<br />
						(SP2D
					</th>
					<th rowspan="2" class="border" width="13%">
						SISA PAGU
						<br />
						ANGGARAN
					</th>
				</tr>
				<tr>
					<th class="border">
						UP/GU/TU
					</th>
					<th class="border">
						LS
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- DATA LOOPING -->
				<?php
					$num						= 1;
					$total_anggaran				= 0;
					$total_murni				= 0;
					$total_up					= 0;
					$total_ls					= 0;
					$total_sisa					= 0;
					foreach($results['data'] as $key => $val)
					{
						$total_anggaran			+= $val->Anggaran;
						$total_murni			+= $val->MURNI;
						$total_up				+= $val->UP;
						$total_ls				+= $val->LS;
						$total_sisa				+= $val->Sisa;
						echo '
							<tr>
								<td class="border text-center">
									' . $num++ . '
								</td>
								<td class="border text-center">
									' . $val->Kd_Rek_5_Gab . '
								</td>
								<td class="border">
									' . $val->Nm_Rek_5 . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->MURNI) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->Anggaran) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->UP) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->LS) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->Sisa) . '
								</td>
							</tr>
						';
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3" class="border text-right">
						<b>
							JUMLAH
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_murni); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_anggaran); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_up); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_ls); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_sisa); ?>
						</b>
					</td>
				</tr>
			</tfoot>
		</table>
		
		<!-- TTD -->
		
		<br />
		<br />
		
		<table class="table">
			<tr>
				<td width="50%" class="text-center">
					<p>
						Mengetahui,
					</p>
					<b>
						<?php echo $results['data'][0]->Jbt_Pimpinan; ?>
					</b>
					<br />
					<br />
					<br />
					<br />
					<br />
					<b>
						<u>
							<?php echo $results['data'][0]->Nm_Pimpinan; ?>
						</u>
					</b>
					<br />
					NIP. <?php echo $results['data'][0]->Nip_Pimpinan; ?>
				</td>
				<td width="50%" class="text-center">
					<p>
						<?php echo get_setting('nama_daerah'); ?>, <?php echo date_indo(date('Y-m-d')); ?>
					</p>
					<b>
						Pejabat Pelaksana Teknis Kegiatan
					</b>
				</td>
			</tr>
		</table>
		
		<htmlpagefooter name="footer">
			<table class="table">
				<tfoot>
					<tr>
						<td class="text-sm text-muted">
							<i>
								<?php echo phrase('document_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' ' . date('F d Y, H:i:s'); ?>
							</i>
						</td>
						<td class="text-sm text-muted text-right print">
							<?php echo phrase('page') . ' {PAGENO} ' . phrase('of') . ' {nb}'; ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</htmlpagefooter>
	</body>
</html>