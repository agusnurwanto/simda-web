<?php
	$title = null;
	//foreach($results['header'] as $result);
	$title		= ucwords(strtolower($results['header']->nm_unit)) . ' - ' . $results['header']->kegiatan;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'RKA Kegiatan - ' . $title; ?>
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
						RENCANA KERJA DAN ANGGARAN
						<br />
						SATUAN KERJA PERANGKAT DAERAH
					</th>
					<th rowspan="2" width="120" class="border text-center">
						Formulir
						<br />
						RKA RINCIAN BELANJA
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
								<td width="22%" class="text-sm-2 no-padding">
									<b>Urusan Pemerintahan</b>
								</td>
								<td width="2%" class="text-sm-2 no-padding">
									:
								</td>
								<td width="19%" class="text-sm-2 no-padding">
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
									<?php echo ucwords(strtolower($results['header']->nm_sub)); ?>
								</td>
							</tr>
							<tr>
								<td class="text-sm-2 no-padding">
									<b>Program</b>
								</td>
								<td class="text-sm-2 no-padding">
									:
								</td>
								<td class="text-sm-2 no-padding">
									<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?> . <?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . ' . ' . sprintf('%02d', $results['header']->kd_program); ?>
								</td>
								<td class="text-sm-2 no-padding">
									<?php echo $results['header']->nm_program; ?>
								</td>
							</tr>
							<tr>
								<td class="text-sm-2 no-padding">
									<b>Capaian Program</b>
								</td>
								<td class="text-sm-2 no-padding">
									:
								</td>
								<td class="text-sm-2 no-padding" colspan="2">
									<?php
                                    echo $results['header']->tolak_ukur . ' ' . number_format_indo($results['header']->target, 2) . ' ' . $results['header']->satuan; ?>
								</td>
							</tr>
							<tr>
								<td class="text-sm-2 no-padding">
									<b>Kegiatan</b>
								</td>
								<td class="text-sm-2 no-padding">
									:
								</td>
								<td class="text-sm-2 no-padding">
									<?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang); ?> . <?php echo $results['header']->kd_urusan . '.' . sprintf('%02d', $results['header']->kd_bidang) . '.' . sprintf('%02d', $results['header']->kd_unit) . ' . ' . sprintf('%02d', $results['header']->kd_program) . '.' . sprintf('%02d', $results['header']->kd_keg); ?>
								</td>
								<td class="text-sm-2 no-padding">
									<?php echo $results['header']->kegiatan; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border">
						<table>
							<!--<tr>
								<td width="20%" class="text-sm-2">
									<b>Jumlah Tahun n - 1</b>
								</td>
								<td width="2%" class="text-sm-2">
									:
								</td>
								<td width="3%" class="text-sm-2">
									Rp
								</td>
								<td class="text-right text-sm-2" width="17%">
									0.00
								</td>
								<td width="58%" class="text-sm-2">
									<i>( <?php //echo 'Nol'; ?> Rupiah )</i>
								</td>
							</tr>-->
							<tr>
								<td width="21%" class="text-sm-2 no-padding">
									<b>Jumlah Tahun n</b>
								</td>
								<td width="2%" class="text-sm-2 no-padding">
									:
								</td>
								<td width="3%" class="text-sm-2 no-padding">
									Rp
								</td>
								<td width="16%" class="text-right text-sm-2 no-padding" style="padding-right:10px">
									<?php echo (isset($results['header']->total_pagu_kegiatan) ? number_format_indo($results['header']->total_pagu_kegiatan, 2) : 0); ?>
								</td>
								<td width="58%" class="text-sm-2 no-padding">
									<i>(<?php echo (isset($results['header']->total_pagu_kegiatan) && $results['header']->total_pagu_kegiatan > 0 ? terbilang($results['header']->total_pagu_kegiatan) : 'Nol'); ?> Rupiah )</i>
								</td>
							</tr>
							<tr>
								<td class="text-sm-2 no-padding">
									<b>Jumlah Tahun n + 1</b>
								</td>
								<td class="text-sm-2 no-padding">
									:
								</td>
								<td class="text-sm-2 no-padding">
									Rp
								</td>
								<td class="text-right text-sm-2 no-padding" style="padding-right:10px">
									<?php echo (isset($results['header']->total_pagu_kegiatan_1) ? number_format_indo($results['header']->total_pagu_kegiatan_1, 2) : 0); ?>
								</td>
								<td class="text-sm-2 no-padding">
									<i>(<?php echo (isset($results['header']->total_pagu_kegiatan_1) && $results['header']->total_pagu_kegiatan_1 > 0 ? terbilang($results['header']->total_pagu_kegiatan_1) : 'Nol'); ?> Rupiah )</i>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</thead>
		</table>
		<table class="table">
			<tr>
				<th colspan="5" class="border no-border-top">
					Indikator dan Tolak Ukur Kinerja Kegiatan
				</th>
			</tr>
			<tr>
				<th class="border" width="20%">
					Indikator
				</th>
				<th class="border" colspan="2" width="40%">
					Tolak Ukur Kinerja
				</th>
				<th class="border" colspan="2" width="40%">
					Target Kinerja
				</th>
			</tr>
			<?php
				$masukan			= null;
				$keluaran			= null;
				$hasil				= null;
				$kd_indikator		= 0;
				$masukan	.= '<td class="border text-sm" colspan="2">
									Jumlah Dana
								</td>
								<td class="border text-sm" colspan="2">
									Rp ' . (isset($results['header']->total_pagu_kegiatan) ? number_format_indo($results['header']->total_pagu_kegiatan, 2) : 0) . '
								</td>
								';
				foreach($results['indikator'] as $key => $val)
				{
				//print_r($results['indikator']);exit;
					if($val->jns_indikator == 1)
					{
						$masukan	.= ($masukan ? '<td class="border text-sm"></td>' : '') . '<td class="border text-sm">' . $val->tolak_ukur . '</td><td class="border text-sm">' . $val->satuan . ' ' . number_format_indo($val->target) . '</td></tr><tr>';
					}
					elseif($val->jns_indikator == 2)
					{
						//if($results['header']->pilihan == 0 or $results['header']->pilihan == 1)
						//{
							$keluaran	.= ($keluaran ? '
												<td class="border text-sm">
												</td>' : '') . '
												<td class="border text-sm" colspan="2">' . $val->tolak_ukur . '
												</td>
												<td class="border text-sm" colspan="2">' . (fmod($val->target, 1) !== 0.00 ? number_format_indo($val->target, 2) : number_format_indo($val->target, 0)) . ' ' . $val->satuan . '
												</td>
											</tr>
											<tr>';
						//}
					}
					elseif($val->jns_indikator == 3)
					{
						//if($results['header']->pilihan == 0 or $results['header']->pilihan == 1)
						//{
							$hasil		.= ($hasil ? '
												<td class="border text-sm">
												</td>' : '') . '
												<td class="border text-sm" colspan="2">' . $val->tolak_ukur . '
												</td>
												<td class="border text-sm" colspan="2">' . (fmod($val->target, 1) !== 0.00 ? number_format_indo($val->target, 2) : number_format_indo($val->target, 0)) . ' ' . $val->satuan . '
												</td>
											</tr>
											<tr>';
						//}
					}
					$kd_indikator	= $val->kd_indikator;
				}
				//print_r($keluaran);exit;
			?>
			<tr>
				<td class="border text-sm">
					<b>Capaian Kegiatan</b>
				</td>
				<td class="border text-sm" colspan="4">

				</td>
				<?php //echo ($capaian_kegiatan ? $capaian_kegiatan : '<td colspan="2" class="border text-sm"></td>'); ?>
				<!--<td class="border">
					Jumlah Dana
				</td>
				<td class="border">
					Rp. <?php //echo (isset($results['belanja']->subtotal_rek_1) ? number_format_indo($results['belanja']->subtotal_rek_1) : 0); ?>
				</td>-->
			</tr>
			<tr>
				<td class="border text-sm">
					<b>Masukan</b>
				</td>
				<?php echo ($masukan ? $masukan : '<td colspan="2" class="border text-sm"></td><td colspan="2" class="border text-sm"></td>'); ?>
				<!--<td class="border">
					Jumlah Dana
				</td>
				<td class="border">
					Rp. <?php //echo (isset($results['belanja']->subtotal_rek_1) ? number_format_indo($results['belanja']->subtotal_rek_1) : 0); ?>
				</td>-->
			</tr>
			<tr>
				<td class="border text-sm">
					<b>Keluaran</b>
				</td>
				<?php echo ($keluaran ? $keluaran : '<td colspan="2" class="border text-sm"></td><td colspan="2" class="border text-sm"></td>'); ?>
			</tr>
			<tr>
				<td class="border text-sm">
					<b>Hasil</b>
				</td>
				<?php echo ($hasil ? $hasil : '<td colspan="2" class="border text-sm"></td><td colspan="2" class="border text-sm"></td>'); ?>
			</tr>
			<tr>
				<td class="border no-border-bottom text-sm" colspan="5">
					<b>Kelompok Sasaran Kegiatan : <?php //echo $results['header']->kelompok_sasaran; ?></b>
				</td>
			</tr>
			<tr>
				<th class="border text-sm-2" colspan="5">
					Rincian Anggaran Belanja Kegiatan Satuan Kerja Perangkat Daerah
				</th>
			</tr>
		</table>
		<table class="table">
				<?php
					$id_keg_sub						= 0;
					$id_rek_1						= 0;
					$id_rek_2						= 0;
					$id_rek_3						= 0;
					$id_rek_4						= 0;
					$id_rek_5						= 0;
					$id_belanja_sub					= 0;
					$id_belanja_rinci				= 0;

					$tim_asistensi					= array();

					foreach($results['belanja'] as $key => $val)
					{
						$tim_asistensi[$val->id_keg_sub] = $val->id_belanja_rinci;
					}

					foreach($results['belanja'] as $key => $val)
					{
						if($val->id_keg_sub != $id_keg_sub)
						{
							echo '
								<tr>
									<td colspan="6"></td>
								</tr>
								<tr>
									<td class="border" colspan="6">
										<table class="table">
											<tr>
												<td class="no-padding">
													<b>Sub Kegiatan</b>
												</td>
												<td class="no-padding">
													:
												</td>
												<td class="no-padding" colspan="4">
													' . $val->kd_keg_sub . '. ' . $val->kegiatan_sub . '
												</td>
											</tr>
											<tr>
												<td class="no-padding" width="20%">
													<b>Sumber Dana</b>
												</td>
												<td class="no-padding" width="2%">
													:
												</td>
												<td class="no-padding" width="30%">
													' . $val->nama_sumber_dana . '
												</td>
												<td class="no-padding" width="13%">
													<b>Lokasi</b>
												</td>
												<td class="no-padding" width="2%">
													:
												</td>
												<td class="no-padding" width="33%">
													' . $val->kecamatan . ' ' . $val->kelurahan . ' ' . $val->alamat_detail . '
												</td>
											</tr>
											<tr>
												<td class="no-padding">
													<b>Sub Keluaran</b>
												</td>
												<td class="no-padding">
													:
												</td>
												<td class="no-padding" colspan="4">
													
												</td>
											</tr>
											<tr>
												<td class="no-padding">
													<b>waktu Pelaksanaan</b>
												</td>
												<td class="no-padding">
													:
												</td>
												<td class="no-padding">
													Mulai ' . date('F Y', strtotime($val->waktu_pelaksanaan_mulai)) . '
												</td>
												<td class="no-padding" colspan="3">
													Sampai ' . date('F Y', strtotime($val->waktu_pelaksanaan_sampai)) . '
												</td>
											</tr>
										</table>
									</td>
								</tr>
							';
						}
						if($val->id_keg_sub != $id_keg_sub || $val->id_rek_1 != $id_rek_1)
						{
				?>
							<thead>
								<tr>
									<th rowspan="2" class="border text-sm" width="12%">
										KODE
										<br />
										REKENING
									</th>
									<th rowspan="2" class="border text-sm" width="45%">
										URAIAN
									</th>
									<th colspan="3" class="border text-sm" width="30%">
										RINCIAN PERHITUNGAN
									</th>
									<th rowspan="2" class="border text-sm" width="13%">
										JUMLAH
										<br />
										(Rp)
									</th>
								</tr>
								<tr>
									<th class="border text-sm">
										Volume
									</th>
									<th class="border text-sm">
										Satuan
									</th>
									<th class="border text-sm">
										Harga Satuan
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
										6=3x5
									</th>
								</tr>
							</thead>
			<tbody>
				<?php
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_rek_1 . '</b>
									</td>
									<td class="border text-sm">
										<b>' . $val->nm_rek_1 . '</b>
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-center text-sm">
										
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_1) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_keg_sub != $id_keg_sub || $val->id_rek_2 != $id_rek_2)
						{
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '</b>
									</td>
									<td style="padding-left:5px" class="border text-sm">
										<b>' . $val->nm_rek_2 . '</b>
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-center text-sm">
										
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_2) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_keg_sub != $id_keg_sub || $val->id_rek_3 != $id_rek_3)
						{
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '</b>
									</td>
									<td style="padding-left:7px" class="border text-sm">
										<b>' . $val->nm_rek_3 . '</b>
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-center text-sm">
										
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_3) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_keg_sub != $id_keg_sub || $val->id_rek_4 != $id_rek_4)
						{
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '</b>
									</td>
									<td style="padding-left:9px" class="border text-sm">
										<b>' . $val->nm_rek_4 . '</b>
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-center text-sm">
										
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_4) . '</b>
									</td>
								</tr>
							';
						}
						if($val->id_keg_sub != $id_keg_sub || $val->id_rek_5 != $id_rek_5)
						{
							echo '
								<tr>
									<td class="border text-sm">
										<b>' . $val->kd_rek_1 . '.' . $val->kd_rek_2 . '.' . $val->kd_rek_3 . '.' . sprintf('%02d', $val->kd_rek_4) . '.' . sprintf('%02d', $val->kd_rek_5) . '</b>
									</td>
									<td style="padding-left:13px" class="border text-sm">
										<b>' . $val->nm_rek_5 . '</b>
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-center text-sm">
										
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-right text-sm">
										<b>' . number_format_indo($val->subtotal_rek_5) . '</b>
									</td>
								</tr>
							';
						}

						if($val->id_keg_sub != $id_keg_sub || $val->id_belanja_sub != $id_belanja_sub)
						{
							echo '
								<tr>
									<td class="border text-sm">
										
									</td>
									<td style="padding-left:15px" class="border text-sm">
										' . $val->nama_sub_rincian . '
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-sm">
										
									</td>
									<td class="border text-right text-sm">
										
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->subtotal_rinci) . '
									</td>
								</tr>
							';
						}
						if($val->id_keg_sub != $id_keg_sub || $val->id_belanja_rinci != $id_belanja_rinci)
						{
							echo '
								<tr>
									<td class="border text-sm">
										' . $val->id_keg_sub . '.' . $val->id_belanja_sub . '.' . $val->id_belanja_rinci . '
									</td>
									<td style="padding-left:15px" class="border text-sm">
										- ' . $val->nama_rincian . ' ( ' . (0 != $val->satuan_1 ? (0 != $val->satuan_2 ? number_format_indo($val->satuan_1) . ' ' . $val->vol_1 . ' x' : number_format_indo($val->satuan_1) . ' ' . $val->vol_1) : null) . '
										' . (0 != $val->satuan_2 ? (0 != $val->satuan_3 ? number_format_indo($val->satuan_2) . ' ' . $val->vol_2 . ' x' : number_format_indo($val->satuan_2) . ' ' . $val->vol_2) : null) . '
										' . (0 != $val->satuan_3 ? (number_format_indo($val->satuan_3) . ' ' . $val->vol_3) : null) . '
                                        )
									</td>
									<td class="border text-center text-sm">
										' . number_format_indo($val->vol_123)  . '
									</td>
									<td class="border text-center text-sm">
										' . $val->satuan_123 . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->nilai) . '
									</td>
									<td class="border text-right text-sm">
										' . number_format_indo($val->total) . '
									</td>
								</tr>
							';
						}

						if(isset($tim_asistensi[$val->id_keg_sub]) && $tim_asistensi[$val->id_keg_sub] == $val->id_belanja_rinci)
						{
							//$CI						=& get_instance();
							//$paraf					= $CI->get_tim_asistensi($val->id_keg_sub);
							$tim_anggaran			= null;

							foreach($results['tim_anggaran'] as $_key => $_val)
							{
								$id						= 'ttd_' . $_val->id;
								$ttd					= (isset($paraf->$id) && 1 == $paraf->$id && $_val->ttd ? '<img src="' . get_image('anggaran', $_val->ttd) . '" height="70" class="ttd absolute" style="' . (1 == $key ? 'top:0;right:0' : (2 == $key ? 'top:-20px;left:20px' : 'top:-20px')) . '" />' : null);
								$tim_anggaran		.=
								'
									<tr>
										<td class="border no-border-left no-border-bottom text-center text-sm-2">
											' . $_val->kode .'
										</td>
										<td class="border no-border-bottom text-sm-2">
											' . $_val->nama_tim .'
										</td>
										<td class="border no-border-bottom text-sm-2">
											' . $_val->nip_tim .'
										</td>
										<td class="border no-border-bottom text-sm-2">
											' . $_val->jabatan_tim .'
										</td>
										<td class="border no-border-bottom no-border-right relative" width="100" height="45">
											' . $ttd . '
										</td>
									</tr>
									';
							}

							echo '
								<tr>
									<td class="border no-padding" colspan="6">
										<table class="table">
											<tfoot>
												<tr>
													<td class="border no-border-top no-border-right no-border-left text-center text-sm" colspan="4">
														<b>PARAF TIM ASISTENSI</b>
													</td>
												</tr>
												<tr>
													<td class="border no-border-bottom no-border-left text-sm" width="33%">
														<b>1. ' . (isset($results['tim_anggaran'][0]->opd) ? $results['tim_anggaran'][0]->opd : 'BAPPEDA' ) . '</b>
														' . (isset($paraf->perencanaan) && 1 == $paraf->perencanaan ? '(Diverifikasi Oleh: <b>' . $paraf->nama_operator_perencanaan . '</b>)' : '') . '
													</td>
													<td class="border no-border-bottom text-sm" width="33%">
														<b>2. ' . (isset($results['tim_anggaran'][1]->opd) ? $results['tim_anggaran'][1]->opd : 'BPKAD' ) . '</b>
														' . (isset($paraf->keuangan) && 1 == $paraf->keuangan ? '(Diverifikasi Oleh: <b>' . $paraf->nama_operator_keuangan . '</b>)' : '') . '
													</td>
													<td class="border no-border-right no-border-bottom text-sm" width="34%" colspan="2">
														<b>3. ' . (isset($results['tim_anggaran'][2]->opd) ? $results['tim_anggaran'][2]->opd : 'Bagian Pembangunan Setda' ) . '</b>
														' . (isset($paraf->setda) && 1 == $paraf->setda ? '(Diverifikasi Oleh: <b>' . $paraf->nama_operator_setda . '</b>)' : '') . '
													</td>
												</tr>
											</tfoot>
										</table>
									</td>
								</tr>
								<tr>
									<td class="border no-padding" colspan="6">
										<table class="table">
											<tfoot>
												<tr>
													<td class="text-center text-sm" colspan="4">
														<b>TIM ANGGARAN PEMERINTAH DAERAH</b>
													</td>
												</tr>
												' . $tim_anggaran . '
											</tfoot>
										</table>
									</td>
								</tr>
							';
						}

						$id_keg_sub					= $val->id_keg_sub;
						$id_rek_1					= $val->id_rek_1;
						$id_rek_2					= $val->id_rek_2;
						$id_rek_3					= $val->id_rek_3;
						$id_rek_4					= $val->id_rek_4;
						$id_rek_5					= $val->id_rek_5;

						$id_belanja_sub				= $val->id_belanja_sub;
						$id_belanja_rinci			= $val->id_belanja_rinci;
					}
				?>
			</tbody>
		</table>
		<table class="table" width="100%" style="page-break-inside:avoid">
			<tbody>
				<tr>
					<td colspan="3" class="border">
						Keterangan : <?php //echo ($results['header']->pilihan == 1 ? ' Model ' . $results['header']->nm_model : NULL); ?>
						<br />
                        <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
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
			</tbody>
		</table>
		<htmlpagefooter name="footer">
			<table class="table print">
				<tfoot>
					<tr>
						<td class="border text-sm no-border-right" colspan="3">
							<i>
								RKA Rincian Belanja SKPD - <?php echo (isset($results['header']->kegiatan) ? $results['header']->kegiatan : '-'); ?>
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
