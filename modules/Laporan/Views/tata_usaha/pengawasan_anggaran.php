<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit_Gab));
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
							REALISASI BELANJA LANGSUNG PER KEGIATAN
						</h3>
                        <h5>
                            TAHUN ANGGARAN <?php echo get_userdata('year'); ?>
                        </h5>
                        <h6>
                            <i>periode 31 Desember 2021</i>
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
                            <td width="20%" class="text-sm-2 no-padding">
                                <b>Urusan Pemerintahaan</b>
                            </td>
                            <td width="2%" class="text-sm-2 no-padding">
                                :
                            </td>
                            <td width="21%" class="text-sm-2 no-padding">
								<?php echo $results['data_query'][0]->Kd_Bidang_Gab; ?>
                            </td>
                            <td width="57%" class="text-sm-2 no-padding">
								<?php echo $results['data_query'][0]->Nm_Bidang_Gab; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>Unit Organisasi</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Kd_Unit_Gab; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Nm_Unit_Gab; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm-2 no-padding">
                                <b>Sub Unit Organisasi</b>
                            </td>
                            <td class="text-sm-2 no-padding">
                                :
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Kd_Sub_Gab; ?>
                            </td>
                            <td class="text-sm-2 no-padding">
	                            <?php echo $results['data_query'][0]->Nm_Sub_Unit_Gab; ?>
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
                <th rowspan="2" class="border text-sm-2" width="12%">
                    KODE
                </th>
                <th rowspan="2" class="border text-sm-2" width="31%">
                    URAIAN
                </th>
                <th colspan="2" class="border text-sm-2" width="10%">
                    ANGGARAN
                </th>
                <th colspan="5" class="border text-sm-2" width="37%">
                    REALISASI
                </th>
                <th rowspan="2" class="border text-sm-2" width="10%">
                    SISA ANGGARAN
                </th>
            </tr>
            <tr>
                <th class="border no-border-top text-sm-2" width="8%">
                    MURNI
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    PERUBAHAN
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    PEGAWAI DLL
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    BARANG & JASA
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    MODAL
                </th>
                <th class="border no-border-top text-sm-2" width="8%">
                    TOTAL
                </th>
                <th class="border no-border-top text-sm-2" width="5%">
                    %
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $num								    = 1;
            $kd_gab_prog					        = 0;
            $kd_gab_keg					            = 0;
//            $nilai					                = 0;
			$total_anggaran					        = 0;
            foreach($results['data_query'] as $key => $val)
            {
	            //$nilai						        = (($val->Total) ? $val->Total : null);

	            if($val->Kd_Gab_Prog != $kd_gab_prog)
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-bottom">
                                ' . $val->Kd_Gab_Prog . '
                            </td>
                            <td class="border text-sm no-border-bottom">
                                <b>' . $val->Ket_Program . '</b>
                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                            <td class="border text-sm text-right dotted-top dotted-bottom">

                            </td>
                        </tr>
                    ';
                }

                if($val->Kd_Gab_Keg != $kd_gab_keg)
                {
                    echo '
                        <tr>
                            <td class="border text-sm no-border-top">
                                ' . $val->Kd_Gab_Keg . '
                            </td>
                            <td class="border text-sm no-border-top" style="padding-left:10px">
                                ' . $val->Ket_Kegiatan . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->Anggaran, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->Anggaran, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->S_BL1, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->S_BL2, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->S_BL3, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->S_Total, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo(0, 2) . '
                            </td>
                            <td class="border text-sm text-right no-border-top">
                                ' . number_format_indo($val->Sisa, 2) . '
                            </td>
                        </tr>
                    ';
                }

                $kd_gab_prog                        = $val->Kd_Gab_Prog;
                $kd_gab_keg                         = $val->Kd_Gab_Keg;
	            $total_anggaran				        += $val->Anggaran;
	            $num++;
            }
            ?>
            </tbody>
            <tfoot>
				<tr>	
					<td colspan="2" class="border text-center">
						<b>TOTAL</b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_anggaran, 2); ?></b>
					</td>
					<td class="border text-sm text-right">
						<b><?php echo number_format_indo($total_anggaran, 2); ?></b>
					</td>
					<td class="border text-sm text-right">
						
					</td>
					<td class="border text-sm text-right">
						
					</td>
					<td class="border text-sm text-right">
						
					</td>
					<td class="border text-sm text-right">
						
					</td>
					<td class="border text-sm text-right">
						
					</td>
					<td class="border text-sm text-right">
						
					</td>
            </tr>
            </tfoot>
        </table>
        <table class="table" width="100%" style="page-break-inside:avoid">
            <tbody>
            <tr>
                <td class="text-center border no-border-right">
                    <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
                </td>
                <td colspan="2" class="text-center border no-border-left">
					<?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                    <br />
                    <b><?php
						echo strtoupper($results['data_query'][0]->Jbt_Pimpinan);
						?></b>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <u><b><?php
							echo $results['data_query'][0]->Nm_Pimpinan
							?></b></u>
                    <br />
					<?php
					echo 'NIP. '. $results['data_query'][0]->Nip_Pimpinan;
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
