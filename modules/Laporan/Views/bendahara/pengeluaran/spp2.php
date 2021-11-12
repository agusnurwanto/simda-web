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
		            NOMOR : <?php echo (isset($results['no_spp']) ? strtoupper($results['no_spp']) : '-'); ?>
                </h6>
            </th>
        </tr>
        </thead>
    </table>
    <table class="table">
        <thead>
        <tr>
            <td colspan="2" class="border no-border-top">
                <table>
                    <tr>
                        <td class="text-center">
                            <b>SPP <?php echo $results['data_query']->Nm_Jn_SPM?></b>
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
                        <td class="text-sm-2 no-padding" width="5%">
                            1.
                        </td>
                        <td class="text-sm-2 no-padding" width="27%">
                            Jenis Kegiatan
                        </td>
                        <td class="text-sm-2 no-padding" width="3%">
                            :
                        </td>
                        <td class="text-sm-2 no-padding" width="25%">
						    a. Gaji dan Tunjangan
                        </td>
                        <td class="text-sm-2 no-padding" width="40%">
                            b. Barang dan Jasa
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
                            c. Pengembalian Pendapatan
                        </td>
                        <td class="text-sm-2 no-padding">
                            d. Lainnya
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            2.
                        </td>
                        <td class="text-sm-2 no-padding">
                            SKPD
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td class="text-sm-2 no-padding">
						    <?php echo $results['data_query']->Kd_Unit_Gab; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Nm_Unit; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            3.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Unit Kerja
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Kd_Sub_Gab; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
		                    <?php echo $results['data_query']->Nm_Sub_Unit; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            4.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Alamat SKPD / Unit Kerja
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
                            5.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Urusan Pemerintahaan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Kd_Bidang_Gab; ?> &nbsp; &nbsp; <?php echo $results['data_query']->Nm_Bidang_Gab; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            6.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Nama Program
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Kd_Prog_Gab; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
                            <?php echo $results['data_query']->Ket_Program; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            7.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Nama Kegiatan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Kd_Keg_Gab; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
		                    <?php echo $results['data_query']->Ket_Kegiatan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            8.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Nama Perusahaan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td class="text-sm-2 no-padding">
						    <?php echo $results['data_query']->Nama_PT; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            9.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Bentuk Perusahaan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Bentuk; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            10.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Alamat Perusahaan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
	                        <?php echo $results['data_query']->Alamat_PT; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            11.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Nama Pimpinan Perusahaan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
						    <?php echo $results['data_query']->Nm_Pimpinan_PT; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            12.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Nama dan No. Rekening Bank
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
			                <?php echo $results['data_query']->Bank_PT; ?> <?php echo $results['data_query']->No_Addendum; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            13.
                        </td>
                        <td class="text-sm-2 no-padding">
                            No. Kontrak
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
			                <?php echo $results['data_query']->No_Kontrak; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            14.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Untuk Pekerjaan/Keperluan
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
			                <?php echo $results['data_query']->Keperluan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            15.
                        </td>
                        <td class="text-sm-2 no-padding">
                            Dasar Pengeluaran
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
			                SPD Nomor <?php echo $results['data_query']->No_SPD; ?> Tanggal <?php echo date_indo($results['data_query']->Tgl_SPD); ?>
                            <br />
                            Sebesar : Rp. <?php echo number_format_indo($results['data_query']->Nilai_Dasar); ?> <?php echo terbilang($results['data_query']->Nilai_Dasar); ?>
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
            <th class="border text-sm-2" width="5%">
                NO
            </th>
            <th class="border text-sm-2 no-border-left no-border-right" width="55%">

            </th>
            <th class="border text-sm-2 no-border-left no-border-right" width="20%">

            </th>
            <th class="border text-sm-2 no-border-left" width="20%">

            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border text-sm-2 text-center no-padding no-border-top no-border-bottom">
                <b>I</b>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                <b>DPA-SKPD/DPPA-SKPD/DPAL-SKPD</b>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                Tanggal : <?php echo date_indo($results['data_query']->Tgl_SPD); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                Nomor : <?php echo $results['data_query']->No_DPA; ?>
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->Anggaran); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 text-center no-padding no-border-top no-border-bottom">
                &nbsp;
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">
                &nbsp;
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">
                &nbsp;
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 text-center no-padding no-border-top no-border-bottom">
                <b>II</b>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                <b>SPD</b>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                Tanggal : <?php echo date_indo($results['data_query']->Tgl_SPD); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                Nomor : <?php echo $results['data_query']->No_DPA; ?>
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_Dasar); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_SPD); ?>
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top">
                Rp. <?php $tot = $results['data_query']->Anggaran-$results['data_query']->Nilai_SPD; echo number_format_indo($tot); ?>1
            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 text-center no-padding no-border-top no-border-bottom">
                <b>III</b>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                <b>SP2D</b>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                SP2D Peruntukan GU
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_GU); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                SP2D Peruntukan LS
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_LS); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                SP2D Peruntukan TU
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_TU); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom" style="padding-left:10px">
                SP2D Peruntukan Nihil
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_Nihil); ?>
            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td class="border text-sm-2 no-padding text-center no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 no-padding text-right no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->SP2D_Total); ?>
            </td>
            <td class="border text-sm-2 no-padding text-right no-border-top no-border-bottom">
                Rp. <?php echo number_format_indo($results['data_query']->Nilai_SPD); ?>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" class="border text-sm-2">
                Pada SPP ini ditetapkan lampiran-lampiran yang diperlukan sebagaimana tertera pada daftar kelengkapan dokumen SPP-1
            </td>
        </tr>
        </tfoot>
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
				        echo $results['data_query']->Nama_PPTK;
				        ?></b></u>
                <br />
		        <?php
		        echo 'NIP. '. $results['data_query']->Nip_PPTK;
		        ?>
            </td>
            <td class="border text-center no-border-top no-border-left no-border-right">
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
