<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query'][0]->Nm_Unit));
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
							SURAT PEMERINTAH MEMBAYAR
						</h3>
                        <h6>
                            <?php echo $results['data_query'][0]->Uraian_SPM;?>
                            <br />
                            <b>Tahun Anggaran</b> <?php echo get_userdata('year'); ?>
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
                            <td class="text-sm-2 no-padding">
                                <b>No. SPM : </b> <?php echo $results['data_query'][0]->No_SPM;?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top">
                    <table>
                        <tr>
                            <td colspan="2" class="text-sm-2 no-padding">
                                KUASA BENDAHARA UMUM DAERAH PEMERINTAH KOTA BEKASI
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-sm-2 no-padding">
                                Supaya menerbitkan SP2D kepada :
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                SKPD
                            </td>
                            <td class="border text-sm-2 no-padding no-border-top dotted-bottom no-border-left no-border-right">
                                <?php echo $results['data_query'][0]->Nm_Unit; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                Bendahara / Pihak Ketiga *)
                            </td>
                            <td class="border text-sm-2 no-padding no-border-top dotted-bottom no-border-left no-border-right">
                                <?php echo $results['data_query'][0]->Nm_Penerima; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                No. Rekening Bank
                            </td>
                            <td class="border text-sm-2 no-padding no-border-top dotted-bottom no-border-left no-border-right">
                                <?php echo $results['data_query'][0]->Rek_Penerima; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                Nama Bank
                            </td>
                            <td class="border text-sm-2 no-padding no-border-top dotted-bottom no-border-left no-border-right">
                                <?php echo $results['data_query'][0]->Nama_Bank; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                NPWP
                            </td>
                            <td class="border text-sm-2 no-padding no-border-top dotted-bottom no-border-left no-border-right">
                                <?php echo $results['data_query'][0]->NPWP; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                Dasar Pembayaran
                            </td>
                            <td class="border text-sm-2 no-padding no-border-top dotted-bottom no-border-left no-border-right">
                                SPD No : <?php echo $results['data_query'][0]->No_SPD; ?>,
                                Tgl : <?php echo date_indo($results['data_query'][0]->Tgl_SPP); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-border-top no-border-bottom">
                    <table>
                        <tr>
                            <td class="text-sm-2 text-left no-padding">
                                Untuk Keperluan :
                            </td>
                            <td class="text-sm-2 text-left no-padding">
                                <?php echo $results['data_query'][0]->Uraian; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-sm-2 no-padding">
                                1. Belanja Tidak Langsung **)
                                <br />
                                2. Belanja Langsung **)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border no-padding">
                    <table>
                        <tr>
                            <td class="text-sm-2 text-left no-padding">
                                <b>Pembebanan pada Kode Rekening : </b>
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
                <th width="20%" class="border text-sm-2">
                    KODE REKENING
                </th>
                <th width="39%" class="border text-sm-2">
                    URAIAN
                </th>
                <th width="20%" class="border text-sm-2">
                    NILAI
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
                $num								= 1;
                $kd_rek_gab					        = 0;
                $nilai					            = 0;
                $jumlah_nilai					    = 0;
                foreach($results['data_query'] as $key => $val)
                {
                    $nilai						    = (($val->Nilai) ? $val->Nilai : null);
                    $jumlah_nilai					+= $nilai;
                    if($val->Kd_Rek_Gab != $kd_rek_gab)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Kd_Rek_Gab . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Nm_Rek_5 . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->Nilai, 2) . '
                                </td>
                            </tr>
                        ';
                    }

                    $kd_rek_gab                     = $val->Kd_Rek_Gab;
                    $num++;
                }

                echo '
                    <tr>
                        <td colspan="2" class="border text-sm text-right">
                            <b>Jumlah</b>
                        </td>
                        <td class="border text-sm text-right">
                            ' . number_format_indo($jumlah_nilai, 2) . '
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border text-sm text-right">
                            &nbsp;
                        </td>
                    </tr>
                ';
            ?>
            <tr>
                <td colspan="3" class="border text-sm-2">
                    <b>Potongan - Potongan</b>
                </td>
            </tr>
            <tr>
                <th class="border text-sm-2">
                    KODE REKENING
                </th>
                <th class="border text-sm-2">
                    URAIAN
                </th>
                <th class="border text-sm-2">
                    NILAI
                </th>
            </tr>
            <?php
                $num								= 1;
                $kd_rek_gab5					    = 0;
                $nilai_potongan					    = 0;
                $jumlah_potongan					= 0;
                foreach($results['potongan_query'] as $key => $val)
                {
                    $nilai_potongan						= (($val->Nilai) ? $val->Nilai : null);
                    $jumlah_potongan					+= $nilai_potongan;
                    if($val->Kd_Rek_Gab5 != $kd_rek_gab5)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Kd_Rek_Gab5 . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Nm_Pot . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->Nilai, 2) . '
                                </td>
                            </tr>
                        ';
                    }

                    $kd_rek_gab5                     = $val->Kd_Rek_Gab5;
                    $num++;
                }
                echo '
                    <tr>
                        <td colspan="2" class="border text-sm text-right">
                            <b>Jumlah Potongan</b>
                        </td>
                        <td class="border text-sm text-right">
                            ' . number_format_indo($jumlah_nilai, 2) . '
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border text-sm text-right">
                            &nbsp;
                        </td>
                    </tr>
                ';
            ?>
            <tr>
                <td colspan="3" class="border text-sm-2">
                    <b>Informasi</b> : <i>(tidak mengurangi jumlah pembayaran SPM)</i>
                </td>
            </tr>
            <tr>
                <th class="border text-sm-2">
                    KODE REKENING
                </th>
                <th class="border text-sm-2">
                    URAIAN
                </th>
                <th class="border text-sm-2">
                    NILAI
                </th>
            </tr>
            <?php
                $num								    = 1;
                $kd_rek_gab5					        = 0;
                $nilai_info					            = 0;
                $jumlah_info					        = 0;
                $nilai_dibayarkan					    = 0;
                $jumlah_dibayarkan					    = 0;
                foreach($results['informasi_query'] as $key => $val)
                {
                    $nilai_info						    = (($val->Nilai) ? $val->Nilai : null);
                    $jumlah_info					    += $nilai_info;
                    $nilai_dibayarkan					= (($val->Dibayarkan) ? $val->Dibayarkan : null);
                    $jumlah_dibayarkan					+= $nilai_dibayarkan;
                    if($val->Kd_Rek_Gab5 != $kd_rek_gab5)
                    {
                        echo '
                            <tr>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Kd_Rek_Gab5 . '
                                </td>
                                <td class="border text-sm no-border-top no-border-bottom">
                                    ' . $val->Nm_Pot . '
                                </td>
                                <td class="border text-sm text-right no-border-top no-border-bottom">
                                    ' . number_format_indo($val->Nilai, 2) . '
                                </td>
                            </tr>
                        ';
                    }

                    $kd_rek_gab5                     = $val->Kd_Rek_Gab5;
                    $num++;
                }
                echo '
                    <tr>
                        <td colspan="2" class="border text-sm text-right">
                            <b>
                                Jumlah Informasi
                            </b>
                        </td>
                        <td class="border text-sm text-right">
                            ' . number_format_indo($jumlah_info, 2) . '
                        </td>
                    </tr>
                ';
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="border text-sm-2 text-right">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="3" class="border text-sm-2">
                    <b>SPM yang Dibayarkan</b>
                </td>
            </tr>
            <tr>
                <td class="border text-sm">
                    Jumlah yang Diminta
                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($jumlah_nilai, 2); ?>
                </td>
                <td class="border text-sm">

                </td>
            </tr>
            <tr>
                <td class="border text-sm">
                    Jumlah Potongan
                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($jumlah_potongan, 2); ?>
                </td>
                <td class="border text-sm">

                </td>
            </tr>
            <tr>
                <td class="border text-sm">
                    Jumlah yang Dibayarkan
                </td>
                <td class="border text-sm text-right">

                </td>
                <td class="border text-sm text-right">
                    <?php echo number_format_indo($jumlah_dibayarkan, 2); ?>
                </td>
            </tr>
            <tr>
                <td class="border text-sm no-border-right">
                    Uang Sejumlah
                </td>
                <td colspan="2" class="border text-sm no-border-left">
                    <i><?php echo terbilang($jumlah_dibayarkan); ?></i>
                </td>
            </tr>
            </tfoot>
        </table>
        <table class="table">
            <tbody>
            <tr>
                <td colspan="2" class="text-sm border no-padding no-border-top no-border-bottom">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td width="21%" class="text-sm border no-padding no-border-top no-border-bottom no-border-right">
                    <b>Jumlah SPP yang diminta </b>
                </td>
                <td class="text-sm border no-padding no-border-top no-border-bottom no-border-left">
                    Rp. <?php echo number_format_indo($jumlah_nilai, 2);?>
                </td>
            </tr>
            <tr>
                <td width="21%" class="text-sm border no-padding no-border-top no-border-bottom no-border-right">

                </td>
                <td class="text-sm border no-padding no-border-top no-border-bottom no-border-left">
                    <i><?php echo terbilang($jumlah_nilai);?></i>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-sm border no-padding no-border-top no-border-bottom">
                   &nbsp;
                </td>
            </tr>
            <tr>
                <td width="21%" class="text-sm border no-padding no-border-top no-border-bottom no-border-right">
                    <b>Nomor dan Tanggal Spp : </b>
                </td>
                <td class="text-sm border no-padding no-border-top no-border-bottom no-border-left">
                    <?php echo $results['data_query'][0]->No_SPP. date_indo($results['data_query'][0]->Tgl_SPP); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-sm border no-padding no-border-top no-border-bottom">
                    &nbsp;
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td class="text-center border no-border-top no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-top no-border-left">
                    <?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['data_query'][0]->Jbt_Penandatangan ? date_indo($results['data_query'][0]->Tgl_SPM) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                    <br />
                    <b><?php
                        echo strtoupper($results['data_query'][0]->Jbt_Penandatangan);
                        ?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
                            echo $results['data_query'][0]->Nm_Penandatangan
                            ?></b></u>
                    <br />
                    <?php
                    echo 'NIP. '. $results['data_query'][0]->Nip_Penandatangan;
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
