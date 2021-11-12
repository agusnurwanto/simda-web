<?php
    $title                                      = null;
    $title		                                = ucwords(strtolower($results['header_query']->nm_sub_unit));
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
                            <b>SPP <?php echo $results['data_query'][0]->Nm_Jn_SPM?></b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border no-border-top">
                <table>
                    <tr>
                        <td class="text-center">
                            <b>RINCIAN (RENCANA) PENGGUNAAN TAHUN ANGGARAN <?php echo get_userdata('year'); ?></b>
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
            <th class="border text-sm-2" width="20%">
                KODE REKENING
            </th>
            <th class="border text-sm-2" width="55%">
                URAIAN
            </th>
            <th class="border text-sm-2" width="20%">
                JUMLAH (Rp.)
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
	        <?php
	        $num								    = 1;
	        $kd_program						        = 0;
	        $kd_kegiatan						    = 0;
	        $kd_sub_kegiatan					    = 0;
	        $Kd_Rek_Gab					            = 0;
	        $jumlah_nilai                           = 0;
	        $nilai                                  = 0;
	        foreach($results['data_query'] as $key => $val)
	        {
		        $nilai						        = (($val->Nilai) ? $val->Nilai : null);
		        $jumlah_nilai				        += $nilai;
		        if($val->ID_Prog != $kd_program)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">

                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Prog_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom" style="padding-left:10px">
                                <b><i>' . $val->Ket_Program . '</i></b>
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">

                            </td>
                        </tr>
                    ';
		        }
		        if($val->Kd_Keg != $kd_kegiatan)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">

                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Keg_Gab .  '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom" style="padding-left:15px">
                                <i>' . $val->Ket_Kegiatan . '</i>
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">

                            </td>
                        </tr>
                    ';
		        }
		        if($val->Kd_Rek_Gab != $Kd_Rek_Gab)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom" style="padding-left:20px">
                                ' . $val->Nm_Rek_5 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo($nilai, 2) . '
                            </td>
                        </tr>
                    ';
		        }

		        $kd_program					        = $val->ID_Prog;
		        $kd_kegiatan					    = $val->Kd_Keg;
		        $Kd_Rek_Gab					        = $val->Kd_Rek_Gab;
		        $tgl_spp					        = $val->Tgl_SPP;
		        $nm_bendahara					    = $val->Nm_Bendahara;
		        $jbt_bendahara					    = $val->Jbt_Bendahara;
		        $nip_bendahara					    = $val->Nip_Bendahara;
		        $nm_pptk    					    = $val->Nama_PPTK;
		        $nip_pptk					        = $val->Nip_PPTK;
		        $num++;
	        }
	        ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="border text-right text-sm-2">
                <b>JUMLAH</b>
            </td>
            <td class="border text-right text-sm-2">
                <?php echo number_format_indo($jumlah_nilai, 2) ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border text-sm-2">
                Terbilang : <i><?php echo terbilang($jumlah_nilai, 2) ?></i>
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
                <b>Pejabat Pelaksana Tekhnis Kegiatan</b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><b><?php
				            echo $nm_pptk;
				        ?></b></u>
                <br />
		        <?php
		            echo 'NIP. '. $nip_pptk;
		        ?>
            </td>
            <td class="border text-center no-border-top no-border-left no-border-right">
                <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
            </td>
            <td colspan="2" class="text-center border no-border-top no-border-left">
			    <?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($tgl_spp ? date_indo($tgl_spp) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                <br />
                <b><?php
				        echo strtoupper($jbt_bendahara);
				    ?></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><b><?php
					        echo $nm_bendahara;
					    ?></b></u>
                <br />
			    <?php
			        echo 'NIP. '. $nip_bendahara;
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
