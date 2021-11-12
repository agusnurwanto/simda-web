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
					<h2 class="no-margin">
						REALISASI BELANJA LANGSUNG PER KEGIATAN
					</h2>
					<h4 class="no-margin">
						TAHUN ANGGARAN <?php echo get_userdata('year'); ?>
					</h4>
					<p>
						<i>
							per <?php echo date_indo(date('Y-m-d')); ?>
						</i>
					</p>
				</td>
			</tr>
		</table>
		
		<div class="divider"></div>
		
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
				<td width="150">
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
		</table>
		
		<table class="table">
			<thead>
				<tr>
					<th rowspan="2" class="border">
						KODE
					</th>
					<th rowspan="2" class="border">
						URAIAN
					</th>
					<th rowspan="2" class="border">
						ANGGARAN
					</th>
					<th colspan="5" class="border">
						REALISASI
					</th>
					<th rowspan="2" class="border">
						SISA ANGGARAN
					</th>
				</tr>
				<tr>
					<th class="border">
						PEGAWAI
					</th>
					<th class="border">
						BARANG & JASA
					</th>
					<th class="border">
						MODAL
					</th>
					<th class="border">
						TOTAL
					</th>
					<th class="border">
						%
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$Kd_Gab_Prog					= 0;
					$total_anggaran					= 0;
					$total_bl1						= 0;
					$total_bl2						= 0;
					$total_bl3						= 0;
					$total_realisasi				= 0;
					$total_sisa						= 0;
					foreach($results['data'] as $key => $val)
					{
						if($val->Kd_Gab_Prog != $Kd_Gab_Prog)
						{
							$total_anggaran			+= (isset($results['leading_row'][$val->Kd_Gab_Prog]['Anggaran']) ? $results['leading_row'][$val->Kd_Gab_Prog]['Anggaran'] : 0);
							$total_bl1				+= (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_BL1']) ? $results['leading_row'][$val->Kd_Gab_Prog]['S_BL1'] : 0);
							$total_bl2				+= (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_BL2']) ? $results['leading_row'][$val->Kd_Gab_Prog]['S_BL2'] : 0);
							$total_bl3				+= (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_BL3']) ? $results['leading_row'][$val->Kd_Gab_Prog]['S_BL3'] : 0);
							$total_realisasi		+= (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_Total']) ? $results['leading_row'][$val->Kd_Gab_Prog]['S_Total'] : 0);
							$total_sisa				+= (isset($results['leading_row'][$val->Kd_Gab_Prog]['Sisa']) ? $results['leading_row'][$val->Kd_Gab_Prog]['Sisa'] : 0);
							
							echo '
								<tr>
									<td class="border">
										' . str_replace(' ', '', $val->Kd_Gab_Prog) . '
									</td>
									<td class="border">
										<b>
											' . $val->Ket_Program . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['Anggaran']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['Anggaran']) : 0) . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_BL1']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['S_BL1']) : 0) . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_BL2']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['S_BL2']) : 0) . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_BL3']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['S_BL3']) : 0) . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_Total']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['S_Total']) : 0) . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['S_Total']) && isset($results['leading_row'][$val->Kd_Gab_Prog]['Anggaran']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['S_Total'] / $results['leading_row'][$val->Kd_Gab_Prog]['Anggaran'] * 100, 2) : 0) . '
										</b>
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['leading_row'][$val->Kd_Gab_Prog]['Sisa']) ? number_format_indo($results['leading_row'][$val->Kd_Gab_Prog]['Sisa']) : 0) . '
										</b>
									</td>
								</tr>
							';
						}
						echo '
							<tr>
								<td class="border">
									' . str_replace(' ', '', $val->Kd_Gab_Keg) . '
								</td>
								<td class="border" style="padding-left:20px">
									' . $val->Ket_Kegiatan . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->Anggaran) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->S_BL1) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->S_BL2) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->S_BL3) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->S_Total) . '
								</td>
								<td class="border text-right">
									' . number_format_indo(($val->S_Total / $val->Anggaran * 100), 2) . '
								</td>
								<td class="border text-right">
									' . number_format_indo($val->Sisa) . '
								</td>
							</tr>
						';
						$Kd_Gab_Prog				= $val->Kd_Gab_Prog;
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" class="border text-right">
						<b>
							JUMLAH
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_anggaran); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_bl1); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_bl2); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_bl3); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_realisasi); ?>
						</b>
					</td>
					<td class="border text-right">
						<b>
							<?php echo number_format_indo($total_realisasi / $total_anggaran * 100, 2); ?>
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
					&nbsp;
				</td>
				<td width="50%" class="text-center">
					<p>
						<?php echo get_setting('nama_daerah'); ?>, <?php echo date_indo(date('Y-m-d')); ?>
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