<?php
    $title                                          = null;
    $title		                                    = ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit_Gab));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo 'Bendahara penerimaan - ' . $title; ?>
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
                    BUKU PENDAPATAN HARIAN
                </h3>
                <h6>
		            <i>periode <?php //echo (isset($results['data_query'][0]->No_Bukti) ? strtoupper($results['data_query'][0]->No_Bukti) : '-'); ?></i>
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
                        <td width="30%" class="text-sm-2 no-padding">
                            <b>Urusan Pemerintahan</b>
                        </td>
                        <td width="2%" class="text-sm-2 no-padding">
                            :
                        </td>
                        <td width="15%" class="text-sm-2 no-padding">
			                <?php echo $results['data_query'][0]->Kd_Urusan_Gab; ?>
                        </td>
                        <td width="53%" class="text-sm-2 no-padding">
			                <?php echo $results['data_query'][0]->Nm_Urusan_Gab; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-sm-2 no-padding">
                            <b>Bidang Pemerintahan</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            :
                        </td>
                        <td class="text-sm-2 no-padding">
			                <?php echo $results['data_query'][0]->Kd_Bidang_Gab; ?>
                        </td>
                        <td class="text-sm-2 no-padding">
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
                    <tr>
                        <td colspan="3" class="text-sm-2 no-padding">
                            <b>Penggunaan Anggaran/Kuasa Pengguna Anggaran</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <?php echo $results['data_query'][0]->Nm_Pimpinan; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-sm-2 no-padding">
                            <b>Bendahara Penerimaan</b>
                        </td>
                        <td class="text-sm-2 no-padding">
                            : <?php echo $results['data_query'][0]->Nm_Bendahara; ?>
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
            <th rowspan="4" class="border no-border-top text-sm-2" width="8%">
                KODE
                <br />
                REKENING
            </th>
            <th rowspan="4" class="border no-border-top text-sm-2" width="25%">
                URAIAN
            </th>
            <th rowspan="4" class="border no-border-top text-sm-2" width="10%">
                JUMLAH ANGGARAN
            </th>
            <th class="border no-border-top text-sm-2">
                S/D PERIODE LALU
            </th>
            <th class="border no-border-top text-sm-2">
                PERIODE INI
            </th>
            <th class="border no-border-top text-sm-2">
                S/D PERIODE INI
            </th>
            <th rowspan="4" class="border no-border-top text-sm-2">
                SISA ANGGARAN YANG
                <br />
                BELUM TEREALISASI /
                <br />
                PELAMPAUAN ANGGARAN
            </th>
        </tr>
        <tr>
            <th colspan="3" class="border dotted-bottom no-border-top text-sm">
                PENERIMAAN
            </th>
        </tr>
        <tr>
            <th colspan="3" class="border no-border-top text-sm">
                PENYETORAN
            </th>
        </tr>
        <tr>
            <th colspan="3" class="border no-border-top text-sm">
                SISA
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
	        <?php
	        $num								    = 1;
	        $kd_rek_5_gab						    = 0;
	        $terima_lalu						    = 0;
	        $setor_lalu						        = 0;
	        $sisa_lalu						        = 0;
	        $terima_ini						        = 0;
	        $setor_ini						        = 0;
	        $sisa_ini						        = 0;
	        $tot_terima						        = 0;
	        $tot_setor						        = 0;
	        $tot_sisa						        = 0;
	        $nilai_anggaran						    = 0;
	        $jumlah_anggaran						= 0;

	        $nilai_terima_lalu						= 0;
	        $jumlah_terima_lalu						= 0;

	        $nilai_terima_ini						= 0;
	        $jumlah_terima_ini						= 0;

	        $nilai_tot_terima						= 0;
	        $jumlah_tot_terima						= 0;

	        $nilai_setor_lalu                       = 0;
            $jumlah_setor_lalu                      = 0;

            $nilai_setor_ini                        = 0;
            $jumlah_setor_ini                       = 0;

            $nilai_tot_setor                        = 0;
            $jumlah_tot_setor                       = 0;

            $nilai_sisa_lalu                        = 0;
            $jumlah_sisa_lalu                       = 0;

            $nilai_sisa_ini                         = 0;
            $jumlah_sisa_ini                        = 0;

            $nilai_tot_sisa                         = 0;
            $jumlah_tot_sisa                        = 0;

	        $nilai_sisa_anggaran					= 0;
	        $jumlah_sisa_anggaran					= 0;
	        foreach($results['data_query'] as $key => $val)
	        {
		        $nilai_anggaran						= (($val->Anggaran) ? $val->Anggaran : null);
		        $jumlah_anggaran				    += $nilai_anggaran;

		        $nilai_terima_lalu					= (($val->Terima_Lalu) ? $val->Terima_Lalu : null);
		        $jumlah_terima_lalu				    += $nilai_terima_lalu;

		        $nilai_terima_ini					= (($val->Terima_Ini) ? $val->Terima_Ini : null);
		        $jumlah_terima_ini				    += $nilai_terima_ini;

		        $nilai_tot_terima					= (($val->Tot_Terima) ? $val->Tot_Terima : null);
		        $jumlah_tot_terima				    += $nilai_tot_terima;

		        $nilai_setor_lalu                   = (($val->Setor_Lalu) ? $val->Setor_Lalu : null);
		        $jumlah_setor_lalu                  += $nilai_setor_lalu;

		        $nilai_setor_ini                    = (($val->Setor_Ini) ? $val->Setor_Ini : null);
		        $jumlah_setor_ini                   += $nilai_setor_ini;

		        $nilai_tot_setor                    = (($val->Tot_Setor) ? $val->Tot_Setor : null);
		        $jumlah_tot_setor                   += $nilai_tot_setor;

		        $nilai_sisa_lalu                    = (($val->Sisa_Lalu) ? $val->Sisa_Lalu : null);
		        $jumlah_sisa_lalu                   += $nilai_sisa_lalu;

		        $nilai_sisa_ini                     = (($val->Sisa_Ini) ? $val->Sisa_Ini : null);
		        $jumlah_sisa_ini                    += $nilai_sisa_ini;

		        $nilai_tot_sisa                     = (($val->Tot_Sisa) ? $val->Tot_Sisa : null);
		        $jumlah_tot_sisa                    += $nilai_tot_sisa;

		        $nilai_sisa_anggaran				= (($val->Sisa_Anggaran) ? $val->Sisa_Anggaran : null);
		        $jumlah_sisa_anggaran				+= $nilai_sisa_anggaran;

		        if($val->Kd_Rek_5_Gab != $kd_rek_5_gab)
		        {
			        echo '
			            <tr>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Kd_Rek_5_Gab . '
                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                                ' . $val->Nm_Rek_5 . '
                            </td>
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo($val->Anggaran, 2) . '
                            </td>                           
                            
                            <td class="border text-sm text-right no-border-top dotted-bottom">';
                                if($val->Terima_Lalu == $terima_lalu || $val->Terima_Lalu != $terima_lalu)
                                {
                                    echo number_format_indo($val->Terima_Lalu, 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top dotted-bottom">';
                                if($val->Terima_Ini == $terima_ini || $val->Terima_Ini != $terima_ini)
                                {
                                    echo number_format_indo($val->Terima_Ini, 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top dotted-bottom">';
                                if($val->Tot_Terima == $tot_terima || $val->Tot_Terima != $tot_terima)
                                {
                                    echo number_format_indo($val->Tot_Terima, 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                ' . number_format_indo(str_replace("-", " ", $val->Sisa_Anggaran), 2) . '
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">

                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">

                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                            
                            </td>
                            
                            <td class="border text-sm text-right no-border-top">';
                                if($val->Setor_Lalu == $setor_lalu || $val->Setor_Lalu != $setor_lalu)
                                {
                                    echo number_format_indo($val->Setor_Lalu, 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top">';
                                if($val->Setor_Ini == $setor_ini || $val->Setor_Ini != $setor_ini)
                                {
                                    echo number_format_indo($val->Setor_Ini, 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top">';
                                if($val->Tot_Setor == $tot_setor || $val->Tot_Setor != $tot_setor)
                                {
                                    echo number_format_indo($val->Tot_Setor, 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="border text-sm no-border-top no-border-bottom">

                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">

                            </td>
                            <td class="border text-sm no-border-top no-border-bottom">
                            
                            </td>
                            
                            <td class="border text-sm text-right no-border-top no-border-bottom">';
                                if($val->Sisa_Lalu == $sisa_lalu || $val->Sisa_Lalu != $sisa_lalu)
                                {
                                    echo number_format_indo(str_replace("-", " ", $val->Sisa_Lalu), 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top no-border-bottom">';
                                if($val->Sisa_Ini == $sisa_ini || $val->Sisa_Ini != $sisa_ini)
                                {
                                    echo number_format_indo(str_replace("-", " ", $val->Sisa_Ini), 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top no-border-bottom">';
                                if($val->Tot_Sisa == $tot_sisa || $val->Tot_Sisa != $tot_sisa)
                                {
                                    echo number_format_indo(str_replace("-", " ", $val->Tot_Sisa), 2);
                                }
                            echo '  </td>
  
                            <td class="border text-sm text-right no-border-top no-border-bottom">
                                
                            </td>
                        </tr>
                    ';
		        }
		        $terima_lalu					    = $val->Terima_Lalu;
		        $setor_lalu					        = $val->Setor_Lalu;
		        $sisa_lalu					        = $val->Sisa_Lalu;
		        $terima_ini					        = $val->Terima_Ini;
		        $setor_ini				            = $val->Setor_Ini;
		        $sisa_ini				            = $val->Sisa_Ini;
		        $tot_terima					        = $val->Tot_Terima;
		        $tot_setor				            = $val->Tot_Setor;
		        $tot_sisa					        = $val->Tot_Sisa;
		        $kd_rek_5_gab					    = $val->Kd_Rek_5_Gab;
		        $num++;
	        }
	        ?>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="border text-center text-sm-2 no-border-bottom">
                <b>JUMLAH</b>
            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-bottom">
	            <?php echo number_format_indo($jumlah_anggaran, 2) ?>
            </td>
            <td class="border text-sm-2 text-right dotted-bottom no-border-left">
		        <?php echo number_format_indo($jumlah_terima_lalu, 2) ?>
            </td>
            <td class="border text-sm-2 text-right dotted-bottom no-border-left">
		        <?php echo number_format_indo($jumlah_terima_ini, 2) ?>
            </td>
            <td class="border text-sm-2 text-right dotted-bottom no-border-left">
		        <?php echo number_format_indo($jumlah_tot_terima, 2) ?>
            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-bottom">
		        <?php echo number_format_indo(str_replace("-", " ", $jumlah_sisa_anggaran), 2); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border text-right text-sm-2 no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-top no-border-bottom">

            </td>
            <td class="border text-sm-2 text-right no-border-top no-border-left">
		        <?php echo number_format_indo($jumlah_setor_lalu, 2) ?>
            </td>
            <td class="border text-sm-2 text-right no-border-top no-border-left">
		        <?php echo number_format_indo($jumlah_setor_ini, 2) ?>
            </td>
            <td class="border text-sm-2 text-right no-border-top no-border-left">
		        <?php echo number_format_indo($jumlah_tot_setor, 2) ?>
            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-top no-border-bottom">

            </td>
        </tr>
        <tr>
            <td colspan="2" class="border text-right text-sm-2 no-border-top">

            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-top">

            </td>
            <td class="border text-sm-2 text-right no-border-left">
	            <?php echo number_format_indo(str_replace("-", " ", $jumlah_sisa_lalu), 2); ?>
            </td>
            <td class="border text-sm-2 text-right no-border-left">
	            <?php echo number_format_indo(str_replace("-", " ", $jumlah_sisa_ini), 2); ?>
            </td>
            <td class="border text-sm-2 text-right no-border-left">
	            <?php echo number_format_indo(str_replace("-", " ", $jumlah_tot_sisa), 2); ?>
            </td>
            <td class="border text-sm-2 text-right no-border-left no-border-top">

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
                <b><?php echo $results['data_query'][0]->Jbt_Pimpinan; ?></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><?php echo $results['data_query'][0]->Nm_Pimpinan; ?></u>
                <br />
                Nip. <?php echo $results['data_query'][0]->Nip_Pimpinan; ?>
            </td>
            <td class="border text-center no-border-top no-border-left no-border-right">
                <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
            </td>
            <td colspan="2" class="text-center border no-border-top no-border-left">
			    <?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo ($results['tanggal'] ? date_indo($results['tanggal']) : date('d') . '' . phrase(date('F')) . '' . date('Y') ); ?>
                <br />
                <b><?php echo $results['data_query'][0]->Jbt_Bendahara; ?></b>
                <br />
                <br />
                <br />
                <br />
                <br />
                <u><?php echo $results['data_query'][0]->Nm_Bendahara; ?></u>
                <br />
                Nip. <?php echo $results['data_query'][0]->Nip_Bendahara; ?>
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
