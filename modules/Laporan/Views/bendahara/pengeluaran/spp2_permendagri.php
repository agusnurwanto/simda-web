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
            <th width="100" class="border no-border-right no-border-bottom">
                <img src="<?php echo $logo_laporan; ?>" alt="..." width="80" />
            </th>
            <th class="border no-border-left no-border-bottom" align="center">
                <h5>
					<?php echo (isset($nama_pemda) ? strtoupper($nama_pemda) : '-'); ?>
                </h5>
                <h3>
                    SURAT PERMINTAAN PEMBAYARAN <?php echo $results['data_query'][0]->Judul?>
                </h3>
                <h6>
		            NOMOR : <?php echo (isset($results['no_spp']) ? strtoupper($results['no_spp']) : '-'); ?> Tahun <?php echo get_userdata('year'); ?>
                </h6>
            </th>
        </tr>
        </thead>
    </table>
    <table class="table">
        <thead>
        <tr>
            <td colspan="5" class="border no-padding no-border-top">
                <table>
                    <tr>
                        <td class="text-center ">
                            <b>RINGKASAN</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="border no-border-top no-padding">
                <table>
                    <tr>
                        <td class="text-center">
                            <b>RINGKASAN DPA-/DPPA-/DPAL-SKPD</b>
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
            <td colspan="3" class="border text-sm-2 text-left" width="75%">
                Jumlah Dana DPA-SKPD/DDPA-SKPD/DPAL-SKPD
            </td>
            <td class="border text-sm-2 no-border-right no-border-left">
                Rp.
            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-right" width="20%">
	            <?php echo number_format_indo($results['data_query'][0]->Anggaran, 2) ?>
            </td>
            <td class="border text-sm-2 text-right no-border-left" width="5%">
                <b><i>(I)</i></b>
            </td>
        </tr>
        <tr>
            <th colspan="6" class="border text-sm-2 text-center">
                RINGKASAN SPD
            </th>
        </tr>
        <tr>
            <th class="border text-sm-2" width="5%">
                NO.
            </th>
            <th class="border text-sm-2 no-border-left no-border-right" width="55%">
                Nomor SPD
            </th>
            <th class="border text-sm-2 no-border-left no-border-right" width="20%">
                Tanggal SPD
            </th>
            <th colspan="3" class="border text-sm-2" width="20%">
                Jumlah Dana
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
	        <?php
	        $num								    = 1;
	        $No_SPD						            = 0;
	        $jumlah_nilai_spd						= 0;
	        $jumlah_nilai_spd2d						= 0;
	        foreach($results['data_query'] as $key => $val)
	        {
		        $nilai_spd						    = (($val->Nilai_SPD) ? $val->Nilai_SPD : null);
		        $jumlah_nilai_spd				    += $nilai_spd;
		        $nilai_total    					= (($val->Nilai_Total) ? $val->Nilai_Total : null);
		        $jumlah_nilai_spd2d					+= $nilai_total;
		        $sisa_spd				            = $val->Anggaran - $val->Nilai_SPD;
		        $sisa_sp2d				            = $jumlah_nilai_spd - $jumlah_nilai_spd2d;

		        if($val->No_SPD != $No_SPD)
		        {
			        echo '
                        <tr>
                            <td class="border text-sm-2 text-center no-border-top no-border-bottom">
                                ' . $num . '
                            </td>
                            <td class="border text-sm-2 no-border-top no-border-left no-border-right no-border-bottom">
                                ' . $val->No_SPD . '
                            </td>
                            
                            <td class="border text-sm-2 no-border-top no-border-bottom" style="padding-left:10px">
                                ' . date_indo($val->Tgl_SPD) . '
                            </td>
                            <td class="border text-sm-2 no-border-top no-border-left no-border-right no-border-bottom">
                                Rp.
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-right no-border-bottom">
                                ' . number_format_indo($val->Nilai_SPD) . '
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-bottom">

                            </td>
                        </tr>
                    ';
		        }
		        $No_SPD					            = $val->No_SPD;
		        $Anggaran					        = $val->Anggaran;
		        $tgl_spp					        = $val->Tgl_SPP;
		        $nm_bendahara					    = $val->Nm_Bendahara;
		        $jbt_bendahara					    = $val->Jbt_Bendahara;
		        $nip_bendahara					    = $val->Nip_Bendahara;
		        $num++;
	        }
	        ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="border text-right text-sm-2 no-border-right">
                <b>JUMLAH</b>
            </td>
            <td class="border text-sm-2 no-border-right">
                Rp.
            </td>
            <td class="border text-right no-border-left no-border-right text-sm-2">
	            <?php echo number_format_indo($jumlah_nilai_spd, 2) ?>
            </td>
            <td class="border text-right no-border-left text-sm-2">
		        <b><i>(II)</i></b>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="border text-right text-sm-2 no-border-right">
                <b><i>Sisa dana yang belum du SPD-kan (I-II)</i></b>
            </td>
            <td class="border text-sm-2 no-border-right">
                Rp.
            </td>
            <td class="border text-right no-border-left no-border-right text-sm-2">
		        <?php echo number_format_indo($sisa_spd, 2) ?>
            </td>
            <td class="border text-right no-border-left text-sm-2">

            </td>
        </tr>
        </tfoot>
    </table>
    <table class="table">
        <thead>
        <tr>
            <td colspan="3" class="border text-sm-2 no-border-right" width="75%">

            </td>
            <td class="border text-sm-2 no-border-left no-border-right">

            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-right" width="20%">

            </td>
            <td class="border text-sm-2 text-right no-border-left" width="5%">

            </td>
        </tr>
        <tr>
            <th colspan="6" class="border text-sm-2 text-center">
                <b>RINGKASAN BELANJA</b>
            </th>
        </tr>
        <tr>
            <th class="border text-sm-2 no-border-right" width="5%">

            </th>
            <th class="border text-sm-2 no-border-left no-border-right" width="55%">

            </th>
            <th class="border text-sm-2 no-border-left no-border-right " width="20%">

            </th>
            <th colspan="3" class="border text-sm-2 no-border-left" width="20%">

            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
		    <?php
		    $sp2d                                   = array('Belanja UP/GU', 'Belanja TU', 'Belanja LS Pembayaran Gaji dan Tunjangan', 'Belanja LS Pengadaan Barang dan Jasa', 'Belanja Nihil');
		    foreach ($sp2d as $key => $val) {
                if($key == '0')
                {
                    echo '
                        <tr>
                            <td class="border text-sm-2 text-center no-border-top no-border-right">

                            </td>
                            <td colspan="2" class="border text-sm-2 no-border-top no-border-left no-border-right" style="padding-left:10px">
                                ' . $val . '
                            </td>
                            <td class="border text-sm-2 no-border-right">
                                Rp.
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-right">
                                ' . number_format_indo($results['data_query'][0]->SP2D_GU, 2) . '
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left">

                            </td>
                        </tr>
                    ';
                }
			    if($key == '1')
			    {
				    echo '
                        <tr>
                            <td class="border text-sm-2 text-center no-border-top no-border-right">

                            </td>
                            <td colspan="2" class="border text-sm-2 no-border-top no-border-left no-border-right" style="padding-left:10px">
                                ' . $val . '
                            </td>
                            <td class="border text-sm-2 no-border-right">
                                Rp.
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-right">
                                ' . number_format_indo($results['data_query'][0]->SP2D_TU, 2) . '
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left">

                            </td>
                        </tr>
                    ';
			    }
			    if($key == '2')
			    {
				    echo '
                        <tr>
                            <td class="border text-sm-2 text-center no-border-top no-border-right">

                            </td>
                            <td colspan="2" class="border text-sm-2 no-border-top no-border-left no-border-right" style="padding-left:10px">
                                ' . $val . '
                            </td>
                            <td class="border text-sm-2 no-border-right">
                                Rp.
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-right">
                                ' . number_format_indo($results['data_query'][0]->SP2D_LS1, 2) . '
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left">

                            </td>
                        </tr>
                    ';
			    }
			    if($key == '3')
			    {
				    echo '
                        <tr>
                            <td class="border text-sm-2 text-center no-border-top no-border-right">

                            </td>
                            <td colspan="2" class="border text-sm-2 no-border-top no-border-left no-border-right" style="padding-left:10px">
                                ' . $val . '
                            </td>
                            <td class="border text-sm-2 no-border-right">
                                Rp.
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-right">
                                ' . number_format_indo($results['data_query'][0]->SP2D_LS2, 2) . '
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left">

                            </td>
                        </tr>
                    ';
			    }
			    if($key == '4')
			    {
				    echo '
                        <tr>
                            <td class="border text-sm-2 text-center no-border-top no-border-right no-border-bottom">

                            </td>
                            <td colspan="2" class="border text-sm-2 no-border-top no-border-left no-border-right no-border-bottom" style="padding-left:10px">
                                ' . $val . '
                            </td>
                            <td class="border text-sm-2 no-border-right no-border-bottom">
                                Rp.
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-right no-border-bottom">
                                ' . number_format_indo($results['data_query'][0]->SP2D_Nihil, 2) . '
                            </td>
                            <td class="border text-sm-2 text-right no-border-top no-border-left no-border-bottom">

                            </td>
                        </tr>
                    ';
			    }
		    }
		    ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="border text-right text-sm-2">
                <b>JUMLAH</b>
            </td>
            <td class="border text-sm-2 no-border-right">
                Rp.
            </td>
            <td class="border text-right no-border-left no-border-right text-sm-2">
			    <?php echo number_format_indo($jumlah_nilai_spd2d, 2) ?>
            </td>
            <td class="border text-right no-border-left text-sm-2">
                <b><i>(III)</i></b>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="border text-right text-sm-2">
                <b><i>Sisa SPD yang telah diterbitkan, belum dibelanjakan (II-III)</i></b>
            </td>
            <td class="border text-sm-2 no-border-right">
                Rp.
            </td>
            <td class="border text-right no-border-left no-border-right text-sm-2">
			    <?php echo number_format_indo($sisa_sp2d, 2) ?>
            </td>
            <td class="border text-right no-border-left text-sm-2">

            </td>
        </tr>
        </tfoot>
    </table>
    <table class="table" width="100%" style="page-break-inside:avoid">
        <tbody>
        <tr>
            <td class="border no-border-top no-border-right">
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
