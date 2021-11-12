<?php
	$title = null;
	$title		= ucwords(strtolower($results['header']->nm_unit));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'DPA Pembiayaan SKPD - ' . $title; ?>
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
						DPA	PEMBIAYAAN
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
									<?php //echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?> . <?php //echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . ' . ' . sprintf('%02d', $results['header']->kd_sub); ?>
								</td>
								<td class="text-sm-2 no-padding">
									<?php //echo ucwords(strtolower($results['header']->nm_sub)); ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</thead>
		</table>
		<table class="table">
			<tr>
				<th class="border text-sm-2" colspan="5">
					Ringkasan Anggaran Pendapatan dan Belanja
					<br />
					Satuan Kerja Perangkat Daerah
				</th>
			</tr>
		</table>
		<table class="table">
			<thead>
				<tr>
					<th class="border text-sm" width="10%">
						KODE
						<br />
						REKENING
					</th>
					<th class="border text-sm" width="47%">
						URAIAN
					</th>
					<th class="border text-sm" width="13%">
						JUMLAH
						<br />
						(Rp)
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
				</tr>
			</thead>
			<tbody>
				<?php
					$id_rek_1						= 0;
					$id_rek_2						= 0;
					$id_rek_3						= 0;
					$penerimaan_pembiayaan			= 0;
					$pengeluaran_pembiayaan			= 0;
					foreach($results['pembiayaan'] as $key => $val)
					{
						if($val->id_rek_1 != $id_rek_1)
						{
							echo '
								<tr>
									<td style="padding-left:10px" class="border text-sm">
										<b>' . $val->kd_rek_1 . '</b>
									</td>
									<td class="border text-sm">
										<b>' . $val->nm_rek_1 . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_1, 2) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_rek_2 != $id_rek_2)
						{
							echo '
								<tr>
									<td style="padding-left:10px" class="border text-sm">
										<b>' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . '</b>
									</td>
									<td style="padding-left:8px" class="border text-sm">
										<b>' . $val->nm_rek_2 . '</b>
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_2, 2) . '</b>
									</td>
								</tr>
							';
							if($val->kd_rek_2 == 1)
							{
								$penerimaan_pembiayaan			= ($val->subtotal_rek_2 ? $val->subtotal_rek_2 : 0);
							}
							else
							{
								$pengeluaran_pembiayaan			= ($val->subtotal_rek_2 ? $val->subtotal_rek_2 : 0);
							}
						}
						if($val->id_rek_3 != $id_rek_3)
						{
							echo '
								<tr>
									<td style="padding-left:10px" class="border text-sm">
										' . $val->kd_rek_1 . ' . ' . $val->kd_rek_2 . ' . ' . $val->kd_rek_3 . '
									</td>
									<td style="padding-left:13px" class="border text-sm">
										' . $val->nm_rek_3 . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->subtotal_rek_3, 2) . '
									</td>
								</tr>
							';
						}
						$id_rek_1					= $val->id_rek_1;
						$id_rek_2					= $val->id_rek_2;
						$id_rek_3					= $val->id_rek_3;
					}
					$surplus		= 	$penerimaan_pembiayaan - $pengeluaran_pembiayaan;
					if($surplus < 0)
					{
						$surplus	= '(' . number_format_indo($surplus * -1, 2) . ')';
					}
					else
					{
						$surplus	= number_format_indo($surplus, 2);
					}
				?>
				<tr>
					<td style="padding-left:10px" class="border text-sm">

					</td>
					<td style="padding-right:10px" class="border text-sm text-right">
						<b>Pembiayaan Netto</i></b>
					</td>
					<td class="border text-right text-sm">
						<b><?php echo $surplus; ?></b>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table" width="100%" style="page-break-inside:avoid">
			<tbody>
				<tr>
					<td colspan="3" class="border">
						Keterangan :
						<br />
<!--						<img src="--><?php //echo get_image('___qrcode', sha1(current_page() . SALT) . '.png'); ?><!--" alt="..." width="100" />-->
					</td>
					<td colspan="2" class="text-center border">
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
				<tr>
					<th colspan="5" class="border">
						<b>TIM ANGGARAN PEMERINTAH DAERAH</b>
					</th>
				</tr>
				<tr>
					<th class="border text-sm-2" width="5%">
						NO
					</th>
					<th class="border text-sm-2" width="28%">
						NAMA
					</th>
					<th class="border text-sm-2" width="22%">
						NIP
					</th>
					<th class="border text-sm-2" width="28%">
						JABATAN
					</th>
					<th class="border text-sm-2" width="20%">
						TANDA TANGAN
					</th>
				</tr>
				<?php
				foreach($results['tim_anggaran'] as $key => $val)
				{
					$id							= 'ttd_' . $val->id;
					$ttd						= (isset($results['approval']->$id) && 1 == $results['approval']->$id && $val->ttd ? '<img src="' . get_image('anggaran', $val->ttd) . '" height="70" class="ttd absolute" style="' . (1 == $key ? 'top:0;right:0' : (2 == $key ? 'top:-20px;left:20px' : 'top:-20px')) . '" />' : null);
					echo '
						<tr>
							<td class="border text-center text-sm-2">
								' . $val->kode .'
							</td>
							<td class="border text-sm-2">
								' . $val->nama_tim .'
							</td>
							<td class="border text-sm-2">
								' . $val->nip_tim .'
							</td>
							<td class="border text-sm-2">
								' . $val->jabatan_tim .'
							</td>
							<td class="border relative" height="45">
								' . $ttd . '
							</td>
						</tr>
						';
				}
				?>
			</tbody>
		</table>
		<htmlpagefooter name="footer">
			<table class="table print">
				<tfoot>
					<tr>
						<td class="border text-center text-sm" colspan="3">
							<b>PARAF TIM ASISTENSI</b>
						</td>
					</tr>
					<tr>
						<td class="border text-sm text-center">
							<b>1. BAPPELITBANGDA</b>
							<p class="verifikatur text-center">
								<?php echo (isset($results['approval']->perencanaan) && 1 == $results['approval']->perencanaan ? 'Diverifikasi oleh <b>' . $results['approval']->nama_operator_perencanaan . '</b> pada ' . date_indo($results['approval']->waktu_verifikasi_perencanaan, 3, '-') : null); ?>
							</p>
						</td>
						<td class="border text-sm text-center">
							<b>2. BPKAD</b>
							<p class="verifikatur text-center">
								<?php echo (isset($results['approval']->keuangan) && 1 == $results['approval']->keuangan ? 'Diverifikasi oleh <b>' . $results['approval']->nama_operator_keuangan . '</b> pada ' . date_indo($results['approval']->waktu_verifikasi_keuangan, 3, '-') : null); ?>
							</p>
						</td>
						<td class="border text-sm text-center">
							<b>3. Bagian Pembangunan Setda</b>
							<p class="verifikatur text-center">
								<?php echo (isset($results['approval']->setda) && 1 == $results['approval']->setda ? 'Diverifikasi oleh <b>' . $results['approval']->nama_operator_setda . '</b> pada ' . date_indo($results['approval']->waktu_verifikasi_setda, 3, '-'): null); ?>
							</p>
						</td>
					</tr>
				</tfoot>
			</table>
		</htmlpagefooter>
	</body>
</html>
