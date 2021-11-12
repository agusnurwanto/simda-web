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
            .dotted-top
            {
                border-top: 1px dotted #000
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
                        <img src="<?php echo $logo_laporan; ?>" alt="..." width="80" />
				</td>
				<td align="center">
					<h2>
						KENDALI RINCIAN KEGIATAN PER OPD
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
		
		<!-- CONTENT -->
		
		<table class="table">
			<thead>
				<tr>
					<th rowspan="2" class="border text-sm" width="3%">
						NO
					</th>
					<th rowspan="2" class="border text-sm" width="10%">
						Kode
						<br />
						OPD
					</th>
					<th rowspan="2" class="border text-sm" width="22%">
						Nama OPD
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Kode
						<br />
						Sub Unit
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Nama Sub Unit
					</th>
					<th rowspan="2" class="border text-sm" width="26%">
						Kode
						<br />
						Program
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						ID
						<br />
						Program
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Program
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Kode
						<br />
						Kegiatan
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Kegiatan
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Kode
						<br />
						Sub Kegiatan
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Sub Kegiatan
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Kode Rekening
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Rekening
					</th>
					<th colspan="3" class="border text-sm" width="13%">
						Anggaran
					</th>
					<th colspan="2" class="border text-sm" width="13%">
						Realisasi
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Sisa Pagu
						<br />
						Anggaran (SP2D)
					</th>
					<th colspan="2" class="border text-sm" width="13%">
						SPJ dalam
						<br />
						Perjalanan
					</th>
					<th rowspan="2" class="border text-sm" width="13%">
						Sisa Pagu
						<br />
						Anggaran (ALL)
					</th>
				</tr>
				<tr>
					<th class="border text-sm">
						Murni
					</th>
					<th class="border text-sm">
						Pergeseran
					</th>
					<th class="border text-sm">
						Perubahan
					</th>
					<th class="border text-sm">
						UP/GU/TU
					</th>
					<th class="border text-sm">
						LS
					</th>
					<th class="border text-sm">
						GU/TU
					</th>
					<th class="border text-sm">
						LS
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- DATA LOOPING -->
				<?php
					$num						= 1;
					$anggaran					= 0;
					$selisih					= 0;
					
					$total_murni				= 0;
					$total_pergeseran			= 0;
					$total_perubahan			= 0;
					$total_up					= 0;
					$total_ls					= 0;
					$total_perjalanan_gu_tu		= 0;
					$total_perjalanan_ls		= 0;
					$total_selisih_sp2d			= 0;
					$total_selisih				= 0;
					foreach($results['data'] as $key => $val)
					{
						if($val->anggaran_murni == 0 AND $val->anggaran_pergeseran == 0 AND $val->anggaran_perubahan == 0)
						{
							continue;
						}
						$anggaran				= ($val->anggaran_perubahan > 0 ? $val->anggaran_perubahan : ($val->anggaran_pergeseran > 0 ? $val->anggaran_pergeseran : ($val->anggaran_murni > 0 ? $val->anggaran_murni : 0)));
						$realisasi				= $val->up_gu_tu + $val->ls;
						$perjalanan_realisasi	= $val->perjalanan_gu_tu + $val->perjalanan_ls;
						$selisih_sp2d			= $anggaran - $realisasi;
						$selisih				= $anggaran - $realisasi - $perjalanan_realisasi;
						echo '
							<tr>
								<td class="border text-sm text-center">
									' . $num++ . '
								</td>
								<td class="border text-sm text-center">
									' . $val->Kd_Urusan . '.' . $val->Kd_Bidang . '.' . $val->Kd_Unit . '
								</td>
								<td class="border text-sm">
									' . $val->Nm_Unit . '
								</td>
								<td class="border text-sm text-center">
									' . $val->Kd_Sub . '
								</td>
								<td class="border text-sm">
									' . $val->Nm_Sub_Unit . '
								</td>
								<td class="border text-sm text-center">
									' . $val->kd_program90 . '
								</td>
								<td class="border text-sm text-center">
									' . $val->ID_Prog . '
								</td>
								<td class="border text-sm">
									' . $val->nm_program . '
								</td>
								<td class="border text-sm text-center">
									' . $val->kd_kegiatan90 . '
								</td>
								<td class="border text-sm">
									' . $val->nm_kegiatan . '
								</td>
								<td class="border text-sm text-center">
									' . $val->kd_sub_kegiatan . '
								</td>
								<td class="border text-sm">
									' . $val->nm_sub_kegiatan . '
								</td>
								<td class="border text-sm text-center">
									' . $val->kd_rek90_1 . '.' . $val->kd_rek90_2 . '.' . $val->kd_rek90_3 . '.' . $val->kd_rek90_4 . '.' . $val->kd_rek90_5 . '.' . $val->kd_rek90_6 . '
								</td>
								<td class="border text-sm">
									' . $val->nm_rek90_6 . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->anggaran_murni) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->anggaran_pergeseran) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->anggaran_perubahan) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->up_gu_tu) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->ls) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($selisih_sp2d) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->perjalanan_gu_tu) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($val->perjalanan_ls) . '
								</td>
								<td class="border text-sm text-right">
									' . number_format_indo($selisih) . '
								</td>
							</tr>
						';
						$total_murni				+= $val->anggaran_murni;
						$total_pergeseran			+= $val->anggaran_pergeseran;
						$total_perubahan			+= $val->anggaran_perubahan;
						$total_up					+= $val->up_gu_tu;
						$total_ls					+= $val->ls;
						$total_perjalanan_gu_tu		+= $val->perjalanan_gu_tu;
						$total_perjalanan_ls		+= $val->perjalanan_ls;
						$total_selisih_sp2d			+= $selisih_sp2d;
						$total_selisih				+= $selisih;
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="14" class="border text-sm text-center">
						<b>JUMLAH</b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_murni); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_pergeseran); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_perubahan); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_up); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_ls); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_selisih_sp2d); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_perjalanan_gu_tu); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_perjalanan_ls); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_selisih); ?></b>
					</td>
				</tr>
			</tfoot>
		</table>
		
		<!-- TTD -->
		<!--
		<br />
		<br />
		
		<table class="table">
			<tr>
				<td width="50%" class="text-center">
					<p>
						Mengetahui,
					</p>
					<b>
						<?php //echo $results['data'][0]->Jbt_Pimpinan; ?>
					</b>
					<br />
					<br />
					<br />
					<br />
					<br />
					<b>
						<u>
							<?php //echo $results['data'][0]->Nm_Pimpinan; ?>
						</u>
					</b>
					<br />
					NIP. <?php //echo $results['data'][0]->Nip_Pimpinan; ?>
				</td>
				<td width="50%" class="text-center">
					<p>
						<?php //echo get_setting('nama_daerah'); ?>, <?php echo date_indo(date('Y-m-d')); ?>
					</p>
					<b>
						Pejabat Pelaksana Teknis Kegiatan
					</b>
				</td>
			</tr>
		</table>-->
		
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