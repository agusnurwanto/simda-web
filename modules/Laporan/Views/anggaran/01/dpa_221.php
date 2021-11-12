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
		
		<!-- HEADER -->
		
		<table class="table">
			<tr>
				<td rowspan="2" class="border text-center v-middle" width="100">
					<img src="<?php echo get_image('settings', get_setting('reports_logo'), 'thumb'); ?>" alt="..." width="80" />
				</td>
				<td rowspan="2" class="border text-center v-middle" width="60%">
					<h4>
						DOKUMEN PELAKSANAAN ANGGARAN
					</h4>
					<h4>
						SATUAN KERJA PERANGKAT DAERAH
					</h4>
				</td>
				<td colspan="6" class="border text-center v-middle">
					<h4>
						NOMOR DPA SKPD
					</h4>
				</td>
				<td rowspan="2" class="border text-center v-middle" width="100">
					<h4>
						Formulir
						<br />
						DPA SKPD
						<br />
						2.2.1
					</h4>
				</td>
			</tr>
			<tr>
				<td class="border text-center v-middle">
					<b>
						<?php echo $results['data'][0]->Kd_UrusanA . '.' . sprintf('%02d', $results['data'][0]->Kd_BidangA); ?>
					</b>
				</td>
				<td class="border text-center v-middle">
					<b>
						<?php echo sprintf('%02d', $results['data'][0]->Kd_UnitA); ?>
					</b>
				</td>
				<td class="border text-center v-middle">
					<b>
						<?php echo sprintf('%02d', $results['data'][0]->Kd_SubA); ?>
					</b>
				</td>
				<td class="border text-center v-middle">
					<b>
						<?php echo sprintf('%02d', $results['data'][0]->Kd_KegA); ?>
					</b>
				</td>
				<td class="border text-center v-middle">
					<b>
						<?php echo $results['data'][0]->Kd_Rek_1; ?>
					</b>
				</td>
				<td class="border text-center v-middle">
					<b>
						<?php echo $results['data'][0]->Kd_Rek_2; ?>
					</b>
				</td>
			</tr>
			<tr>
				<td colspan="9" class="border text-center">
					<h4>
						<?php echo $results['data'][0]->Nm_Pemda; ?>
					</h4>
					<p>
						Tahun Anggaran <?php echo get_userdata('year'); ?>
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="9" class="border no-padding">
					<table class="table">
						<tr>
							<td width="200">
								<b>
									Urusan Pemerintahan
								</b>
							</td>
							<td width="10">
								:
							</td>
							<td width="200">
								<?php echo $results['data'][0]->Kd_Bidang_Gab; ?>
							</td>
							<td>
								<?php echo $results['data'][0]->Nm_Bidang_Gab; ?>
							</td>
						</tr>
						<tr>
							<td>
								<b>
									Organisasi
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
							<td class="border no-border-left no-border-right">
								<b>
									Lokasi Kegiatan
								</b>
							</td>
							<td class="border no-border-left no-border-right">
								:
							</td>
							<td colspan="2" class="border no-border-left no-border-right">
								<?php echo $results['data'][0]->Lokasi; ?>
							</td>
						</tr>
						<tr>
							<td class="border no-border-left no-border-right">
								<b>
									Sumber Dana
								</b>
							</td>
							<td class="border no-border-left no-border-right">
								:
							</td>
							<td colspan="2" class="border no-border-left no-border-right">
								sumber dana
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<!-- INDIKATOR -->
		
		<?php
			$capaian_program					= null;
			$capaian_program_rowspan			= 0;
			$masukan							= null;
			$masukan_rowspan					= 0;
			$keluaran							= null;
			$keluaran_rowspan					= 0;
			$hasil								= null;
			$hasil_rowspan						= 0;
			$kelompok_sasaran					= null;
			$kelompok_sasaran_rowspan			= 0;
			foreach($results['indikator'] as $key => $val)
			{
				if(2 == $val->Kd_Indikator)
				{
					$masukan					.= '
						' . ($masukan_rowspan ? '<tr>' : null) . '
							<td class="border">
								' . $val->Tolak_Ukur . '
							</td>
							<td class="border">
								' . $val->Target_Uraian . '
							</td>
						' . ($masukan_rowspan ? '</tr>' : null) . '
					';
					$masukan_rowspan++;
				}
				elseif(3 == $val->Kd_Indikator)
				{
					$keluaran					.= '
						' . ($keluaran_rowspan ? '<tr>' : null) . '
							<td class="border">
								' . $val->Tolak_Ukur . '
							</td>
							<td class="border">
								' . $val->Target_Uraian . '
							</td>
						' . ($keluaran_rowspan ? '</tr>' : null) . '
					';
					$keluaran_rowspan++;
				}
				elseif(4 == $val->Kd_Indikator)
				{
					$hasil						.= '
						' . ($hasil_rowspan ? '<tr>' : null) . '
							<td class="border">
								' . $val->Tolak_Ukur . '
							</td>
							<td class="border">
								' . $val->Target_Uraian . '
							</td>
						' . ($hasil_rowspan ? '</tr>' : null) . '
					';
					$hasil_rowspan++;
				}
				else
				{
					$capaian_program			.= '
						' . ($capaian_program_rowspan ? '<tr>' : null) . '
							<td class="border">
								' . $val->Tolak_Ukur . '
							</td>
							<td class="border">
								' . $val->Target_Uraian . '
							</td>
						' . ($capaian_program_rowspan ? '</tr>' : null) . '
					';
					$capaian_program_rowspan++;
				}
			}
		?>
		
		<table class="table">
			<tr>
				<th colspan="3" class="border">
					INDIKATOR & TOLOK UKUR KINERJA BELANJA LANGSUNG
				</th>
			</tr>
			<tr>
				<th class="border" width="205">
					INDIKATOR
				</th>
				<th class="border">
					TOLOK UKUR KINERJA
				</th>
				<th class="border">
					TARGET KINERJA
				</th>
			</tr>
			<tr>
				<td <?php echo ($capaian_program_rowspan > 1 ? ' rowspan="' . $capaian_program_rowspan . '" ' : null); ?>class="border">
					<b>
						CAPAIAN PROGRAM
					</b>
				</td>
				<?php echo $capaian_program; ?>
			</tr>
			<tr>
				<td  <?php echo ($masukan_rowspan > 1 ? ' rowspan="' . $masukan_rowspan . '" ' : null); ?>class="border">
					<b>
						MASUKAN
					</b>
				</td>
				<?php echo $masukan; ?>
			</tr>
			<tr>
				<td  <?php echo ($keluaran_rowspan > 1 ? ' rowspan="' . $keluaran_rowspan . '" ' : null); ?>class="border">
					<b>
						KELUARAN
					</b>
				</td>
				<?php echo $keluaran; ?>
			</tr>
			<tr>
				<td  <?php echo ($hasil_rowspan > 1 ? ' rowspan="' . $hasil_rowspan . '" ' : null); ?>class="border">
					<b>
						HASIL
					</b>
				</td>
				<?php echo $hasil; ?>
			</tr>
			<tr>
				<td colspan="3" class="border">
					<table class="table">
						<tr>
							<td width="260">
								<b>
									Kelompok Sasaran Kinerja
								</b>
							</td>
							<td width="10">
								:
							</td>
							<td>
								<?php echo $results['data'][0]->Kelompok_Sasaran; ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<!-- CONTENT -->
		
		<table class="table">
			<thead>
				<tr>
					<th colspan="6" class="border">
						RINCIAN DOKUMEN PELAKSANAAN ANGGARAN BELANJA LANGSUNG MENURUT PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGKAT DAERAH
					</th>
				</tr>
				<tr>
					<th rowspan="2" class="border">
						KODE
						<br />
						REKENING
					</th>
					<th rowspan="2" class="border">
						URAIAN
					</th>
					<th colspan="3" class="border">
						RINCIAN PERHITUNGAN
					</th>
					<th rowspan="2" class="border">
						JUMLAH
						<br />
						(Rp)
					</th>
				</tr>
				<tr>
					<th class="border">
						Volume
					</th>
					<th class="border">
						Satuan
					</th>
					<th class="border">
						Harga
						<br />
						Satuan
					</th>
				</tr>
				<tr>
					<th class="border">
						1
					</th>
					<th class="border">
						2
					</th>
					<th class="border">
						3
					</th>
					<th class="border">
						4
					</th>
					<th class="border">
						5
					</th>
					<th class="border">
						6 = 3x5
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- DATA LOOPING -->
				<?php
					$Kd_Rek_1_Gab					= 0;
					$Kd_Rek_2_Gab					= 0;
					$Kd_Rek_3_Gab					= 0;
					$Kd_Rek_4_Gab					= 0;
					$Kd_Rek_5_Gab					= 0;
					foreach($results['data'] as $key => $val)
					{
						if($Kd_Rek_1_Gab != $val->Kd_Rek_1_Gab)
						{
							echo '
								<tr>
									<td class="border">
										' . str_replace(' ', null, $val->Kd_Rek_1_Gab) . '
									</td>
									<td class="border">
										<b>
											' . $val->Nm_Rek_1 . '
										</b>
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['total'][$val->Kd_Rek_1_Gab]) ? number_format(array_sum($results['total'][$val->Kd_Rek_1_Gab])) : 0) . '
										</b>
									</td>
								</tr>
							';
						}
						
						if($Kd_Rek_2_Gab != $val->Kd_Rek_2_Gab)
						{
							echo '
								<tr>
									<td class="border">
										' . str_replace(' ', null, $val->Kd_Rek_2_Gab) . '
									</td>
									<td class="border" style="padding-left:10px">
										<b>
											' . $val->Nm_Rek_2 . '
										</b>
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['total'][$val->Kd_Rek_2_Gab]) ? number_format(array_sum($results['total'][$val->Kd_Rek_2_Gab])) : 0) . '
										</b>
									</td>
								</tr>
							';
						}
						
						if($Kd_Rek_3_Gab != $val->Kd_Rek_3_Gab)
						{
							echo '
								<tr>
									<td class="border">
										' . str_replace(' ', null, $val->Kd_Rek_3_Gab) . '
									</td>
									<td class="border" style="padding-left:15px">
										<b>
											' . $val->Nm_Rek_3 . '
										</b>
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['total'][$val->Kd_Rek_3_Gab]) ? number_format(array_sum($results['total'][$val->Kd_Rek_3_Gab])) : 0) . '
										</b>
									</td>
								</tr>
							';
						}
						
						if($Kd_Rek_4_Gab != $val->Kd_Rek_4_Gab)
						{
							echo '
								<tr>
									<td class="border">
										' . str_replace(' ', null, $val->Kd_Rek_4_Gab) . '
									</td>
									<td class="border" style="padding-left:20px">
										<b>
											' . $val->Nm_Rek_4 . '
										</b>
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['total'][$val->Kd_Rek_4_Gab]) ? number_format(array_sum($results['total'][$val->Kd_Rek_4_Gab])) : 0) . '
										</b>
									</td>
								</tr>
							';
						}
						
						if($Kd_Rek_5_Gab != $val->Kd_Rek_5_Gab)
						{
							echo '
								<tr>
									<td class="border">
										' . str_replace(' ', null, $val->Kd_Rek_5_Gab) . '
									</td>
									<td class="border" style="padding-left:25px">
										<b>
											' . $val->Nm_Rek_5 . '
										</b>
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border text-right">
										<b>
											' . (isset($results['total'][$val->Kd_Rek_5_Gab]) ? number_format(array_sum($results['total'][$val->Kd_Rek_5_Gab])) : 0) . '
										</b>
									</td>
								</tr>
							';
						}
						
						if($Kd_Rek_5_Gab != $val->Kd_Rek_5_Gab)
						{
							echo '
								<tr>
									<td class="border">
										&nbsp;
									</td>
									<td class="border" style="padding-left:30px">
										' . $val->Keterangan_Rinc . '
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border">
										&nbsp;
									</td>
									<td class="border text-right">
										' . (isset($results['total'][$val->Kd_Rek_5_Gab . '.' . $val->No_Rinc]) ? number_format(array_sum($results['total'][$val->Kd_Rek_5_Gab . '.' . $val->No_Rinc])) : 0) . '
									</td>
								</tr>
							';
						}
						
						echo '
							<tr>
								<td class="border">
									&nbsp;
								</td>
								<td class="border" style="padding-left:35px">
									<ul class="no-margin">
										<li>
											' . $val->Keterangan . '
										</li>
									</ul>
								</td>
								<td class="border text-center">
									' . number_format($val->Jml_Satuan) . '
								</td>
								<td class="border text-center">
									' . $val->Satuan123 . '
								</td>
								<td class="border text-right">
									' . number_format($val->Nilai_Rp) . '
								</td>
								<td class="border text-right">
									' . number_format($val->Total) . '
								</td>
							</tr>
						';
						
						$Kd_Rek_1_Gab				= $val->Kd_Rek_1_Gab;
						$Kd_Rek_2_Gab				= $val->Kd_Rek_2_Gab;
						$Kd_Rek_3_Gab				= $val->Kd_Rek_3_Gab;
						$Kd_Rek_4_Gab				= $val->Kd_Rek_4_Gab;
						$Kd_Rek_5_Gab				= $val->Kd_Rek_5_Gab;
					}
				?>
			</tbody>
		</table>
		
		<!-- FOOTER -->
		
		<htmlpagefooter name="footer">
			<table class="table">
				<tfoot>
					<tr>
						<td colspan="3" class="border text-center">
							<b>
								PARAF TIM VERIFIKASI TAPD
							</b>
						</td>
					</tr>
					<tr>
						<td class="border">
							<b>
								1. BAPPEDA:
							</b>
						</td>
						<td class="border">
							<b>
								2. BPKAD:
							</b>
						</td>
						<td class="border">
							<b>
								3. Bagian Pembangunan Setda:
							</b>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="border text-sm text-muted">
							<i>
								<?php echo phrase('document_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' ' . date('F d Y, H:i:s'); ?>
							</i>
						</td>
						<td class="border text-sm text-muted text-right print">
							<?php echo phrase('page') . ' {PAGENO} ' . phrase('of') . ' {nb}'; ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</htmlpagefooter>
	</body>
</html>