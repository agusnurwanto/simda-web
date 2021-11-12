<?php
    $title                                      = null;
    $title		                                = ucwords(strtolower($results['data_query']->Nm_Unit));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'Bendahara pengeluaran - ' . $title; ?>
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
					<th width="100" class="border no-border-right">
                        <img src="<?php echo $logo_laporan; ?>" alt="..." width="80" />
					</th>
					<th class="border no-border-left" align="center">
						<h5>
							<?php echo (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'); ?>
						</h5>
						<h3>
							SURAT PERMINTAAN PEMBAYARAN (SPP)
						</h3>
						<h6>
                            NOMOR <?php echo $results['data_query']->No_SPP; ?>
						</h6>
					</th>
				</tr>
			</thead>
		</table>
		<table class="table">
			<thead>
            <tr>
                <td colspan="3" class="border no-border-top">
                    <table>
                        <tr>
                            <td class="text-sm-2 text-center no-padding">
                                <b> SPP <?php echo $results['data_query']->Nm_Jn_SPM; ?></b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top">
                    <table>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                &nbsp;
                            </td>
                            <td class="text-sm-2 no-padding">
                                &nbsp;
                            </td>
                            <td class="text-sm-2 no-padding">
                                &nbsp;
                            </td>
                            <td class="text-sm-2 text-center no-padding">
                               <b>Kode</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                1.
                            </td>
                            <td class="text-sm-2 no-padding">
                                SKPD
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo ucwords(strtolower($results['data_query']->Nm_Unit)); ?>
                            </td>
                            <td class="text-sm-2 text-center no-padding">
	                            (<?php echo $results['data_query']->Kd_Unit_Gab; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                2.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Unit Kerja
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
			                    <?php echo ucwords(strtolower($results['data_query']->Nm_Unit)); ?>
                            </td>
                            <td class="text-sm-2 text-center no-padding">
                                (<?php echo $results['data_query']->Kd_Sub_Gab; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                3.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Alamat
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
			                    <?php echo ucwords(strtolower($results['data_query']->Alamat)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                4.
                            </td>
                            <td class="text-sm-2 no-padding">
                                SKPD/DPAL-SKPD/DDPA-
                                <br />
                                SKPD/DPAL-SKPD
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
                                <?php echo $results['data_query']->No_DPA; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                Tanggal DPA-SKPD/DDPA-
                                <br />
                                SKPD/DPAL-SKPD
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
			                    <?php echo date_indo($results['data_query']->Tgl_DPA); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                5.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Tahun Anggaran
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo date('Y', strtotime($results['data_query']->Tgl_DPA)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                6.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Bulan
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo date('F', strtotime($results['data_query']->Tgl_DPA)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                7.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Urusan Pemerintahan
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query']->Nm_Bidang_Gab; ?>
                            </td>
                            <td class="text-sm-2 text-center no-padding">
		                        (<?php echo $results['data_query']->Kd_Bidang_Gab; ?>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                8.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Nama Program
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query']->Ket_Program; ?>
                            </td>
                            <td class="text-sm-2 text-center no-padding">
                                (<?php echo sprintf('%02d', $results['data_query']->Kd_Prog_Gab); ?>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                9.
                            </td>
                            <td class="text-sm-2 no-padding">
                                Nama Kegiatan
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query']->Ket_Kegiatan; ?>
                            </td>
                            <td class="text-sm-2 text-center no-padding">
                                (<?php echo sprintf('%02d', $results['data_query']->Kd_Keg_Gab); ?>)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top no-border-bottom">
                    <table>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td colspan="2" width="43%" class="text-sm-2 text-left no-padding">
                                Kepada Yth.
                                <br />
                                Pengguna Anggaran / Kuasa Pengguna Anggaran
                                <br />
                                SKPD <b><?php echo ucwords(strtolower($results['data_query']->Nm_Unit)); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-sm-2 no-padding">
                                <br />
                                <br />
                                Dengan memperhatikan Peraturan Walikota Bekasi Nomor <?php echo ucwords(strtolower($results['data_query']->No_Peraturan)); ?>, Tentang <?php echo ucwords(strtolower($results['data_query']->Nm_Peraturan)); ?>, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut:
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top no-border-bottom">
                    <table>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">
                                a.
                            </td>
                            <td width="39%" class="text-sm-2 no-padding">
                                Jumlah Pembayaran Yang Diminta
                            </td>
                            <td width="3%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td width="5%" class="text-sm-2 no-padding">
                                Rp.
                            </td>
                            <td width="50%" class="text-sm-2 no-padding">
			                    <?php echo number_format_indo($results['data_query']->Nilai_SPP); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">

                            </td>
                            <td width="39%" class="text-sm-2 no-padding">

                            </td>
                            <td width="3%" class="text-sm-2 no-padding">

                            </td>
                            <td colspan="2" class="text-sm-2 small no-padding">
	                            <i><?php echo ucwords(strtolower(terbilang($results['data_query']->Nilai_SPP))); ?></i>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">
                                b.
                            </td>
                            <td width="39%" class="text-sm-2 no-padding">
                                Untuk Keperluan
                            </td>
                            <td width="3%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
	                            <?php echo ucwords(strtolower($results['data_query']->Uraian)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">
                                c.
                            </td>
                            <td width="39%" class="text-sm-2 no-padding">
                                Nama Bendahara Pengeluaran / Pihak Ketiga
                            </td>
                            <td width="3%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
	                            <?php echo ucwords(strtolower($results['data_query']->Nm_Penerima)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">
                                d.
                            </td>
                            <td width="39%" class="text-sm-2 no-padding">
                                Alamat
                            </td>
                            <td width="3%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
	                            <?php echo ucwords(strtolower($results['data_query']->Alamat_Penerima)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">
                                e.
                            </td>
                            <td width="39%" class="text-sm-2 no-padding">
                                No. Rekening Bank
                            </td>
                            <td width="3%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
	                            <?php echo ucwords(strtolower($results['data_query']->Rek_Penerima)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%" class="text-sm-2 no-padding">

                            </td>
                            <td width="39%" class="text-sm-2 no-padding">
                                Nama Bank
                            </td>
                            <td width="3%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
	                            <?php echo ucwords(strtolower($results['data_query']->Bank_Penerima)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			</thead>
		</table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td colspan="2" class="text-center border no-border-top no-border-right">
		            Mengetahui,
                    <br />
                    <b>Pejabat Pelaksana Teknis Kegiatan</b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
				            echo $results['data_query']->Nama_PPTK;
				            ?></b></u>
                    <br />
		            <?php
		            echo 'NIP. '. $results['data_query']->Nip_PPTK;
		            ?>
                </td>
                <td class="text-center border no-border-top no-border-left no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-top no-border-left">
					<?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['data_query']->Tgl_SPP ? date_indo($results['data_query']->Tgl_SPP) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                    <br />
                    <b><?php
						echo strtoupper($results['data_query']->Jbt_Bendahara);
						?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
							echo $results['data_query']->Nm_Bendahara;
							?></b></u>
                    <br />
					<?php
					echo 'NIP. '. $results['data_query']->Nip_Bendahara;
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
								Sumber Dana -
								<?php echo phrase('document_has_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' {DATE F d Y, H:i:s}'; ?>
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
