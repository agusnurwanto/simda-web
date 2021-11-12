<?php
	$title = null;
	$title		= ucwords(strtolower($results['header']->nm_unit));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'DPA - ' . $title; ?>
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
					<th rowspan="2" width="100" class="border">
                        <img src="<?php echo $logo_laporan; ?>" alt="..." width="80" />
					</th>
					<th class="border text-center">
						DOKUMEN PELAKSANAAN ANGGARAN
						<br />
						SATUAN KERJA PERANGKAT DAERAH
					</th>
					<th rowspan="2" width="120" class="border text-center">
						Formulir
						<br />
						DPA BELANJA
						<br />
						SKPD
					</th>
				</tr>
				<tr>
					<th class="border" align="center">
						<h4>
							<?php echo (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'); ?>
						</h4>
						<h5>
							TAHUN ANGGARAN <?php echo get_userdata('year'); ?>
						</h5>
					</th>
				</tr>
				<tr>
					<td colspan="3" class="border">
						<table>
							<tr>
								<td class="text-sm-2 no-padding" width="7%">
									<b>Unit</b>
								</td>
								<td class="text-sm-2 no-padding" width="5%">
									:
								</td>
								<td class="text-sm-2 no-padding" width="8%">
									<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?> . <?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit); ?>
								</td>
								<td class="text-sm-2 no-padding" width="80%">
									<?php echo ucwords(strtolower($results['header']->nm_unit)); ?>
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
					<th rowspan="3" class="border text-sm-2" width="8%">
						Kode
					</th>
					<th rowspan="3" class="border text-sm-2" width="25%">
						Uraian
					</th>
					<th rowspan="3" class="border text-sm-2" width="10%">
						Sumber Dana
					</th>
					<th rowspan="3" class="border text-sm-2" width="12%">
						Lokasi
					</th>
					<th colspan="7" class="border text-sm-2" width="45%">
						Jumlah
					</th>
				</tr>
				<tr>
					<th rowspan="2" class="border text-sm">
						T - 1
					</th>
					<th colspan="5" class="border text-sm">
						T
					</th>
					<th rowspan="2" class="border text-sm">
						T + 1
					</th>
				</tr>
				<tr>
					<th class="border text-sm">
						Belanja
						<br />
						Operasi
					</th>
					<th class="border text-sm">
						Belanja
						<br />
						Modal
					</th>
					<th class="border text-sm">
						Belanja
						<br />
						Tidak
						<br />
						Terduga
					</th>
					<th class="border text-sm">
						Belanja
						<br />
						Transfer
					</th>
					<th class="border text-sm">
						Jumlah
					</th>
				</tr>
				<tr bgcolor="gray">
					<th class="border text-sm">
						1
					</th>
					<th class="border text-sm">
						2
					</th>
					<th class="border text-sm">
						3
					</th>
					<th class="border text-sm">
						4
					</th>
					<th class="border text-sm">
						5
					</th>
					<th class="border text-sm">
						6
					</th>
					<th class="border text-sm">
						7
					</th>
					<th class="border text-sm">
						8
					</th>
					<th class="border text-sm">
						9
					</th>
					<th class="border text-sm">
						10
					</th>
					<th class="border text-sm">
						11
					</th>
				</tr>
			</thead>
				<?php
					$id_urusan						= 0;
					$id_bidang						= 0;
					$id_program						= 0;
					$id_kegiatan					= 0;

					foreach($results['data'] as $key => $val)
					{
						if($val->id_urusan != $id_urusan)
						{
							$jumlah_belanja_urusan	=	$val->belanja_operasi_urusan + $val->belanja_modal_urusan + $val->belanja_tidak_terduga_urusan + $val->belanja_transfer_urusan;
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_urusan . '</b>
									</td>
									<td class="border text-sm" colspan="3">
										<b>' . $val->nm_urusan . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo(0) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_operasi_urusan) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_modal_urusan) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_tidak_terduga_urusan) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_transfer_urusan) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($jumlah_belanja_urusan) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->pagu_1_urusan) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_bidang != $id_bidang)
						{
							$jumlah_belanja_bidang	=	$val->belanja_operasi_bidang + $val->belanja_modal_bidang + $val->belanja_tidak_terduga_bidang + $val->belanja_transfer_bidang;
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_urusan . '.' . $val->kd_bidang . '</b>
									</td>
									<td style="padding-left:5px" class="border text-sm" colspan="3">
										<b>' . $val->nm_bidang . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo(0) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_operasi_bidang) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_modal_bidang) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_tidak_terduga_bidang) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_transfer_bidang) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($jumlah_belanja_bidang) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->pagu_1_bidang) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_program != $id_program)
						{
							$jumlah_belanja_program	=	$val->belanja_operasi_program + $val->belanja_modal_program + $val->belanja_tidak_terduga_program + $val->belanja_transfer_program;
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . sprintf('%02d', $val->kd_program) . '</b>
									</td>
									<td style="padding-left:7px" class="border text-sm" colspan="3">
										<b>' . $val->nm_program . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo(0) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_operasi_program) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_modal_program) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_tidak_terduga_program) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->belanja_transfer_program) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($jumlah_belanja_program) . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->pagu_1_program) . '</b>
									</td>
								</tr>
							';
						}
//						if($val->id_kegiatan != $id_kegiatan)
//						{
//							$jumlah_belanja_kegiatan	=	$val->belanja_operasi_kegiatan + $val->belanja_modal_kegiatan + $val->belanja_tidak_terduga_kegiatan + $val->belanja_transfer_kegiatan;
//							echo '
//								<tr>
//									<td class="border text-sm">
//										<b>' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . sprintf('%02d', $val->kd_program) . '.' . sprintf('%02d', $val->kd_keg) . '</b>
//									</td>
//									<td style="padding-left:9px" class="border text-sm" colspan="3">
//										<b>' . $val->kegiatan . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo(0) . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->belanja_operasi_kegiatan) . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->belanja_modal_kegiatan) . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->belanja_tidak_terduga_kegiatan) . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->belanja_transfer_kegiatan) . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($jumlah_belanja_kegiatan) . '</b>
//									</td>
//									<td class="border text-right text-sm">
//										<b>' . number_format_indo($val->pagu_1_kegiatan) . '</b>
//									</td>
//								</tr>
//							';
//						}
						if($val->id_kegiatan != $id_kegiatan)
						{
							$jumlah_belanja_kegiatan	=	$val->belanja_operasi_kegiatan + $val->belanja_modal_kegiatan + $val->belanja_tidak_terduga_kegiatan + $val->belanja_transfer_kegiatan;
							echo '
								<tr>
									<td class="border text-sm">
										' . $val->kd_urusan . '.' . $val->kd_bidang . '.' . sprintf('%02d', $val->kd_program) . '.' . sprintf('%02d', $val->kd_keg) . '
									</td>
									<td style="padding-left:11px" class="border text-sm">
										' . $val->kegiatan . '
									</td>
									<td class="border text-sm">
										' . sprintf('%02d', $val->kode) . '.' . $val->nama_sumber_dana . '
									</td>
									<td class="border text-sm">
										' . $val->map_address . ' ' . $val->alamat_detail . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo(0) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->belanja_operasi_kegiatan) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->belanja_modal_kegiatan) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->belanja_tidak_terduga_kegiatan) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->belanja_transfer_kegiatan) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($jumlah_belanja_kegiatan) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->pagu_1_kegiatan) . '
									</td>
								</tr>
							';
						}
						$id_urusan					= $val->id_urusan;
						$id_bidang					= $val->id_bidang;
						$id_program					= $val->id_program;
						$id_kegiatan				= $val->id_kegiatan;
					}
				?>
			</tbody>
		</table>
		<table class="table" style="page-break-inside:avoid">
			<tbody>
				<tr>
					<td colspan="6" width="50%" class="border no-border-right">
						&nbsp;
						<br />
						&nbsp;
					</td>
					<td colspan="6" width="60%" class="text-center border no-border-left">
						<?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
						<br />
						<b><?php
							//echo strtoupper($results['header']->nama_jabatan);
							?></b>
						<br />
						<br />
						<br />
						<br />
						<br />
						<u><b><?php
									//echo $results['header']->nama_pejabat;
								?></b></u>
						<br />
						<?php
							//echo 'NIP. '. $results['header']->nip_pejabat;
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
								DPA Belanja SKPD - <?php echo (isset($results['header']->nm_unit) ? $results['header']->nm_unit : '-'); ?>
								<?php //echo phrase('document_has_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' {DATE F d Y, H:i:s}'; ?>
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
