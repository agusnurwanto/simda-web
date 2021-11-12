<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query']->Nm_Sub_Unit));
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
							SURAT PERMINTAAN PEMBAYARAN
                            <br />
                            <?php echo $results['data_query']->Judul; ?>
						</h3>
						<h6>
                            NOMOR <i><?php echo $results['no_spp']; ?></i> Tahun <?php echo get_userdata('year'); ?>
						</h6>
					</th>
				</tr>
			</thead>
		</table>
		<table class="table">
			<thead>
            <tr>
                <td colspan="3" class="border no-border-top no-border-bottom">
                    <table>
                        <tr>
                            <td class="text-sm-2 text-center">
                                <br />
                                <b><h3>SURAT PENGANTAR</h3></b>
                                <br />
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                Kepada Yth.
                                <br />
                                Pengguna Anggaran / Kuasa Pengguna Anggaran
                                <br />
                                SKPD <b><?php echo $results['data_query']->Nm_Sub_Unit; ?></b>
                                <br />
                                Di Tempat
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <br />
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Dengan memperhatikan <?php echo $results['data_query']->Ur_Peraturan; ?> <?php echo $results['data_query']->No_Peraturan; ?>, tentang <?php echo $results['data_query']->Nm_Peraturan; ?>, bersama ini kami mengajukan Surat Permintaan Pembayaran <?php echo $results['data_query']->Judul2; ?> sebagai berikut:
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top no-border-bottom">
                    <table>
                        <tr>
                            <td class="text-sm-2">
                                a.
                            </td>
                            <td class="text-sm-2">
                                Urusan Pemerintahan
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo $results['data_query']->Kd_Urusan; ?> &nbsp; &nbsp; <?php echo $results['data_query']->Nm_Urusan; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                b.
                            </td>
                            <td class="text-sm-2">
                                SKPD
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo $results['data_query']->Kd_Sub; ?> &nbsp; &nbsp; <?php echo $results['data_query']->Nm_Sub_Unit; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                c.
                            </td>
                            <td class="text-sm-2">
                                Tahun Anggaran
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo get_userdata('year'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                d.
                            </td>
                            <td class="text-sm-2">
                                Dasar Pengeluaran SPD Nomor
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo $results['data_query']->No_SPD; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                e.
                            </td>
                            <td class="text-sm-2">
                                Jumlah Sisa Dana SPD
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            Rp. <?php echo number_format_indo($results['data_query']->Nilai_SPD); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                (terbilang : <i><?php echo terbilang($results['data_query']->Nilai_SPD); ?></i>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                f.
                            </td>
                            <td class="text-sm-2">
                                Untuk Keperluan
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo $results['data_query']->Uraian; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                g.
                            </td>
                            <td class="text-sm-2">
                                Nama Bendahara Pengeluaran
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo $results['data_query']->Nm_Bendahara; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2">
                                h.
                            </td>
                            <td class="text-sm-2">
                                Jumlah Pembayaran Yang Diminta
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            Rp. <?php echo number_format_indo($results['data_query']->Nilai_SPP); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
	                            (terbilang : <i><?php echo terbilang($results['data_query']->Nilai_SPP); ?></i>)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-border-bottom">
                                i.
                            </td>
                            <td class="text-sm-2">
                                Nama dan Nomor Rekening Bank
                            </td>
                            <td class="text-sm-2">
                                :
                            </td>
                            <td class="text-sm-2">
	                            <?php echo $results['data_query']->Bank_Penerima; ?> <?php echo $results['data_query']->Rek_Penerima; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top no-border-bottom">
                    <table>
                        <tr>
                            <td class="text-sm-2">
                                &nbsp;
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
                <td class="border no-border-top no-border-right">
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
