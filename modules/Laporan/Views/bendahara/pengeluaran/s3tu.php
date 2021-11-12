<?php
    $title                                      = null;
    $title		                                = ucwords(strtolower($results['data_query']->Nm_Sub_Unit));
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
            <th rowspan="2" width="100" class="border">
                <img src="<?php echo $logo_laporan; ?>" alt="..." width="80" />
            </th>
            <th class="border text-center">
                <h4>
		            <?php echo (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'); ?>
                </h4>
                SURAT SETORAN SISA
                <br />
                TAMBAHAN UANG PERSEDIAAN
                <br />
                (S3TU)
            </th>
            <th rowspan="2" width="120" class="border text-sm text-center">
                Lembar Untuk
                <br />
                WAJIB SETOR /
                <br />
                BENDAHARA
                <br />
                PENGELUARAN
                <br />
                SEBAGAI
                <br />
                BUKTI SETOR
            </th>
        </tr>
        <tr>
            <th class="border text-left">
                <h4>
					Nomor : <?php echo $results['data_query']->No_Bukti; ?>
                </h4>
                <h5>
                    Tanggal : <?php echo date_indo($results['data_query']->Tgl_Bukti); ?>
                </h5>
            </th>
        </tr>
    </thead>
    </table>
		<table class="table">
			<thead>
            <tr bgcolor="gray">
                <td colspan="3" class="border no-border-top">
                    <table>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>KE REKENING KAS DAERAH : </b> <?php echo $results['data_query']->Rekening_Bank; ?>
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

                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding" width="5%">
                                <b>A.</b>
                            </td>
                            <td class="text-sm-2 no-padding" width="5%">
                                <b>1.</b>
                            </td>
                            <td class="text-sm-2 no-padding" width="20%">
                                <b>Urusan Pemerintahan</b>
                            </td>
                            <td class="text-sm-2 no-padding" width="5%">
                                :
                            </td>
                            <td class="text-sm-2 no-padding" width="15%">
					            <?php echo $results['data_query']->Kd_Gab_Bidang; ?>
                            </td>
                            <td class="text-sm-2 no-padding" width="50%">
					            <?php echo $results['data_query']->Nm_Bidang; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>2.</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>Urusan Organisasi</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
					            <?php echo $results['data_query']->Kd_Gab_Unit; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
					            <?php echo $results['data_query']->Nm_Unit; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b></b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>3.</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>Sub Unir Organisasi</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
					            <?php echo $results['data_query']->Kd_Gab_Sub; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
					            <?php echo $results['data_query']->Nm_Sub_Unit; ?>
                            </td>
                        </tr>
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

                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>B.</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>1.</b>
                            </td>
                            <td colspan="3" class="text-sm-2 no-padding">
                                <b>Wajib Setor/Bendahara Pengeluaran</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>Nama</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
			                    <?php echo $results['data_query']->Nm_Bendahara; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>Jabatan</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
			                    <?php echo $results['data_query']->Jbt_Bendahara; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>2.</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>Alamat</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
			                    <?php echo $results['data_query']->Alamat; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td class="text-sm-2 no-padding">
                                <b>Jabatan</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
			                    <?php echo $results['data_query']->Jbt_Bendahara; ?>
                            </td>
                        </tr>
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

                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>C.</b>
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
                                <b>Kode Rekening</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
			                    <?php echo $results['data_query']->Kd_Rek_Gab; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
		                        <?php echo $results['data_query']->Nm_Rek_5; ?>
                            </td>
                        </tr>
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

                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>D.</b>
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
                                <b>Jumlah Setoran</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
			                    Rp.
                            </td>
                            <td class="text-sm-2 no-padding">
			                    <?php echo number_format_indo($results['data_query']->Nilai,2); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">

                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
                                <b>Dengan Huruf</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
			                    <i><?php echo terbilang($results['data_query']->Nilai,2); ?></i>
                            </td>
                        </tr>
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

                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>E.</b>
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
                                <b>Untuk Keperluan</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td colspan="2" class="text-sm-2 no-padding">
			                    <?php echo $results['data_query']->Keterangan; ?>
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
                <td class="text-center border no-border-top no-border-left no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-top no-border-left">
                    Diterima oleh :
                    <br />
                    REKENING KAS UMUM DAERAH
                    <br />
                    BANK PERSEPSI
                    <br />
                    Tanggal :
                    <br />
                    <br />
                    <br />
                    <br />
                    <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u>
                    <br />
					<?php
					//echo 'NIP. '. $results['data_query'][0]->Nip_Bendahara;
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
