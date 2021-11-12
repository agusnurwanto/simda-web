<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit));
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
                    LAPORAN PERTANGGUNGJAWABAN TAMBAHAN UANG PERSEDIAAN
                </h3>
                <h6>
		            BENDAHARA PENGELUARAN
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
                        <td width="22%" class="text-sm-2 no-padding">
                            <b>Urusan Pemerintahan</b>
                        </td>
                        <td width="2%" class="text-sm-2 no-padding">
                            :
                        </td>
                        <td width="26%" class="text-sm-2 no-padding">
						    <?php echo $results['data_query'][0]->Kd_Gab_Bidang; ?>
                        </td>
                        <td width="50%" class="text-sm-2 no-padding">
						    <?php echo $results['data_query'][0]->Nm_Bidang; ?>
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
						    <?php echo $results['data_query'][0]->Kd_Gab_Unit; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
						    <?php echo $results['data_query'][0]->Nm_Unit; ?>
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
						    <?php echo $results['data_query'][0]->Kd_Gab_Sub; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
						    <?php echo $results['data_query'][0]->Nm_Sub_Unit; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            <b>Tahun</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
	                        <?php echo get_userdata('year'); ?>
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
			                <?php echo $results['data_query'][0]->Kd_Gab_Prog; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
			                <?php echo $results['data_query'][0]->Ket_Program; ?>
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
			                <?php echo $results['data_query'][0]->Kd_Gab_Keg; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
			                <?php echo $results['data_query'][0]->Ket_Kegiatan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            <b>Tanggal SP2D</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td colspan="2" class="text-sm-2 no-padding">
			                <?php echo date_indo($results['data_query'][0]->Tgl_SP2D); ?>
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
            <th class="border text-sm-2" width="20%">
                KODE
                <br />
                REKENING
            </th>
            <th class="border text-sm-2" width="60%">
                URAIAN
            </th>
            <th class="border text-sm-2" width="20%">
                JUMLAH
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
	        <?php
	        $num								    = 1;
            $nilai                                  = 0;
	        $tu                                     = 0;
            $sisa                                   = 0;
	        $jumlah_nilai                           = 0;
	        $jumlah_tu                              = 0;
	        $jumlah_sisa                            = 0;
	        foreach($results['data_query'] as $key => $val)
	        {
		        $nilai						        = (($val->Nilai) ? $val->Nilai : null);
		        $jumlah_nilai				        += $nilai;
		        $tu						            = (($val->Nilai_TU) ? $val->Nilai_TU : null);
		        $jumlah_tu				            += $tu;
		        $sisa						        = (($val->Sisa) ? $val->Sisa : null);
		        $jumlah_sisa				        += $sisa;
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $val->Kd_Rek . '
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

		        $num++;
	        ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="border text-right text-sm-2">
                <b><i>Total</i></b>
            </td>
            <td class="border text-right text-sm-2">
                <?php echo number_format_indo($jumlah_nilai, 2) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border text-right text-sm-2">
                <b><i>Tambahan Uang Persediaan</i></b>
            </td>
            <td class="border text-right text-sm-2">
		        <?php echo number_format_indo($jumlah_tu, 2) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border text-right text-sm-2">
                <b><i>Sisa Tambahan Uang Persediaan</i></b>
            </td>
            <td class="border text-right text-sm-2">
		        <?php echo number_format_indo($jumlah_sisa, 2) ?>
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
		            echo strtoupper($results['data_query'][0]->Jbt_Pimpinan);
		            ?></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><b><?php
				            echo $results['data_query'][0]->Nm_Pimpinan;
				        ?></b></u>
                <br />
		        <?php
		            echo 'NIP. '. $results['data_query'][0]->Nip_Pimpinan;
		        ?>
            </td>
            <td class="border text-center no-border-top no-border-left no-border-right">
                <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
            </td>
            <td colspan="2" class="text-center border no-border-top no-border-left">
	            <?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                <br />
                <b><?php
				        echo strtoupper($results['data_query'][0]->Jabatan);
				    ?></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><b><?php
					        echo $results['data_query'][0]->Nama;
					    ?></b></u>
                <br />
			    <?php
			        echo 'NIP. '. $results['data_query'][0]->Nip;
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
