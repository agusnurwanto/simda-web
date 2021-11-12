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
                            SURAT PENGESAHAAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN
                            <br />
                            (SPJ BELANJA)
                        </h3>
                    </th>
                </tr>
            </thead>
        </table>
		<table class="table">
			<thead>
				<tr>
					<td colspan="3" class="border no-border-bottom">
						<table>
							<tr>
								<td class="text-sm-2 no-padding" width="14%">
									<b>Urusan Pemerintahaan</b>
								</td>
								<td class="text-sm-2 no-padding" width="1%">
									:
								</td>
								<td class="text-sm-2 no-padding" width="9%">
									<?php echo $results['data_query'][0]->Kd_Urusan_Gab; ?>
								</td>
								<td class="text-sm-2 no-padding">
									<?php echo ucwords(strtolower($results['data_query'][0]->Nm_Urusan_Gab)); ?>
								</td>
							</tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    <b>Bidang Pemerintahaan</b>
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding">
	                                <?php echo $results['data_query'][0]->Kd_Bidang_Gab; ?>
                                </td>
                                <td class="text-sm-2 no-padding">
	                                <?php echo ucwords(strtolower($results['data_query'][0]->Nm_Bidang_Gab)); ?>
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
	                                <?php echo ucwords(strtolower($results['data_query'][0]->Nm_Unit_Gab)); ?>
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
									<?php echo ucwords(strtolower($results['data_query'][0]->Nm_Sub_Unit_Gab)); ?>
                                </td>
                            </tr>
						</table>
					</td>
				</tr>
                <tr>
                    <td colspan="3" class="border no-border-top">
                        <table>
                            <tr>
                                <td width="28%" class="text-sm-2 no-padding">
                                    <b>Pengguna Anggaran/Kuasa Pengguna Anggaran</b>
                                </td>
                                <td width="2%" class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td width="70%" class="text-sm-2 no-padding">
									<?php echo $results['data_query'][0]->Nm_Pimpinan; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    <b>Bendahara Pengeluaran</b>
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding">
									<?php echo $results['data_query'][0]->Nm_Bendahara; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-sm-2 no-padding">
                                    <b>Bulan</b>
                                </td>
                                <td class="text-sm-2 no-padding">
                                    :
                                </td>
                                <td class="text-sm-2 no-padding">
			                        <?php echo ucwords(strtolower($results['bulan'])); ?>
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
						Kode
                        <br />
                        Rekeing
					</th>
					<th rowspan="4" class="border no-border-top text-sm-2" width="20%">
						Uraian
					</th>
					<th rowspan="4" class="border no-border-top text-sm-2" width="12%">
						Jumlah Anggaran
					</th>
					<th class="border no-border-top text-sm-2" width="12%">
                        s.d. Bulan lalu
					</th>
                    <th class="border no-border-top text-sm-2" width="12%">
                        Bulan ini
                    </th>
                    <th class="border no-border-top text-sm-2" width="12%">
                        s.d. Bulan ini
                    </th>
                    <th rowspan="4" class="border no-border-top text-sm-2" width="12%">
                        Jumlah SPJ
                        <br />
                        (LS + UP/GU/TU)
                        <br />
                        s.d. Bulan ini
                    </th>
                    <th rowspan="4" class="border no-border-top text-sm-2" width="12%">
                        Sisa Anggaran
                    </th>
				</tr>
				<tr>
					<th colspan="3" class="border dotted-bottom no-border-top text-sm">
						SPJ - LS Gaji
					</th>
				</tr>
				<tr>
					<th colspan="3" class="border dotted-bottom no-border-top text-sm">
                        SPJ - LS Barang & Jasa
					</th>
				</tr>
                <tr>
                    <th colspan="3" class="border no-border-top text-sm">
                        SPJ - LS UP/GU/TU
                    </th>
                </tr>
			</thead>
            <tbody>
            <?php
                $Kd_Rek_5_Gab						= 0;

                $gaji_l						        = 0;
                $gaji_i						        = 0;
                $gaji_t						        = 0;

                $ls_l						        = 0;
                $ls_i						        = 0;
                $ls_t						        = 0;

                $up_l						        = 0;
                $up_i						        = 0;
                $up_t						        = 0;

                $total_spj						    = 0;
                $total_sisa						    = 0;

                $nilai_anggaran						= 0;
                $jumlah_anggaran					= 0;

                $nilai_gaji_l						= 0;
                $jumlah_gaji_l					    = 0;

                $nilai_gaji_i						= 0;
                $jumlah_gaji_i					    = 0;

                $nilai_gaji_t						= 0;
                $jumlah_gaji_t					    = 0;

                $nilai_spj						    = 0;
                $jumlah_spj					        = 0;

                $nilai_sisa						    = 0;
                $jumlah_sisa					    = 0;

                $nilai_ls_l						    = 0;
                $jumlah_ls_l						= 0;

                $nilai_ls_i						    = 0;
                $jumlah_ls_i					    = 0;

                $nilai_ls_t						    = 0;
                $jumlah_ls_t					    = 0;

                $nilai_up_l						    = 0;
                $jumlah_up_l						= 0;

                $nilai_up_i						    = 0;
                $jumlah_up_i					    = 0;

                $nilai_up_t						    = 0;
                $jumlah_up_t					    = 0;
                foreach($results['data_query'] as $key => $val)
                {
	                $nilai_anggaran					= (($val->Anggaran) ? $val->Anggaran : null);
	                $jumlah_anggaran				+= $nilai_anggaran;

	                $nilai_gaji_l					= (($val->Gaji_L) ? $val->Gaji_L : null);
	                $jumlah_gaji_l				    += $nilai_gaji_l;

	                $nilai_gaji_i					= (($val->Gaji_I) ? $val->Gaji_I : null);
	                $jumlah_gaji_i				    += $nilai_gaji_i;

	                $nilai_gaji_t					= (($val->Gaji_T) ? $val->Gaji_T : null);
	                $jumlah_gaji_t				    += $nilai_gaji_t;

	                $nilai_spj					    = (($val->TOTAL_SPJ) ? $val->TOTAL_SPJ : null);
	                $jumlah_spj				        += $nilai_spj;

	                $nilai_sisa					    = (($val->SISA) ? $val->SISA : null);
	                $jumlah_sisa				    += $nilai_sisa;

	                $nilai_ls_l					    = (($val->LS_L) ? $val->LS_L : null);
	                $jumlah_ls_l				    += $nilai_ls_l;

	                $nilai_ls_i					    = (($val->LS_I) ? $val->LS_I : null);
	                $jumlah_ls_i				    += $nilai_ls_i;

	                $nilai_ls_t					    = (($val->LS_T) ? $val->LS_T : null);
	                $jumlah_ls_t				    += $nilai_ls_t;

	                $nilai_up_l					    = (($val->UP_L) ? $val->UP_L : null);
	                $jumlah_up_l				    += $nilai_up_l;

	                $nilai_up_i					    = (($val->UP_I) ? $val->UP_I : null);
	                $jumlah_up_i				    += $nilai_up_i;

	                $nilai_up_t					    = (($val->UP_T) ? $val->UP_T : null);
	                $jumlah_up_t				    += $nilai_up_t;

	                $jumlah_sp2d                    = $jumlah_anggaran - $jumlah_sisa;
	                $saldo_kas                      = $jumlah_spj;

                    if($val->Kd_Rek_5_Gab != $Kd_Rek_5_Gab) {
	                    echo '
                            <tr>
                                <td class="border no-border-top no-border-bottom text-sm">
                                    ' . $val->Kd_Rek_5_Gab . '
                                </td>
                                <td class="border no-border-top no-border-bottom text-sm">
                                    ' . $val->Nm_Rek_5 . '
                                </td>
                                <td class="border no-border-top no-border-bottom text-sm text-right">
                                    ' . number_format_indo($val->Anggaran, 2) . '
                                </td>
                        ';

	                    if($val->Gaji_L != $gaji_l || $val->Gaji_L == $gaji_l) {
		                    echo '
                                <td class="border no-border-top dotted-bottom text-sm text-right">
                                    ' . number_format_indo($val->Gaji_L, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->Gaji_I != $gaji_i || $val->Gaji_I == $gaji_i) {
		                    echo '
                                <td class="border no-border-top dotted-bottom text-sm text-right">
                                    ' . number_format_indo($val->Gaji_I, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->Gaji_T != $gaji_t || $val->Gaji_T == $gaji_t) {
		                    echo '
                                <td class="border no-border-top dotted-bottom text-sm text-right">
                                    ' . number_format_indo($val->Gaji_T, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->TOTAL_SPJ != $total_spj || $val->TOTAL_SPJ == $total_spj) {
		                    echo '
                                <td class="border no-border-top no-border-bottom text-sm text-right">
                                    ' . number_format_indo($val->TOTAL_SPJ, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->SISA != $total_sisa || $val->SISA == $total_sisa) {
		                    echo '
                                <td class="border no-border-top no-border-bottom text-sm text-right">
                                    ' . number_format_indo($val->SISA, 2) . '
                                </td>
                            </tr>
                            ';
	                    }

	                    echo '
                            <tr>
                                <td class="border no-border-top no-border-bottom text-sm">
                                    
                                </td>
                                <td class="border no-border-top no-border-bottom text-sm">
                                    
                                </td>
                                <td class="border no-border-top no-border-bottom text-sm">
                                    
                                </td>
                        ';

	                    if($val->LS_L != $ls_l || $val->LS_L == $ls_l) {
		                    echo '
                                <td class="border no-border-top dotted-bottom text-sm text-right">
                                    ' . number_format_indo($val->LS_L, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->LS_I != $ls_i || $val->LS_I == $ls_i) {
		                    echo '
                                <td class="border no-border-top dotted-bottom text-sm text-right">
                                    ' . number_format_indo($val->LS_I, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->LS_T != $ls_t || $val->LS_T == $ls_t) {
		                    echo '
                                <td class="border no-border-top dotted-bottom text-sm text-right">
                                    ' . number_format_indo($val->LS_T, 2) . '
                                </td>
                                <td class="border no-border-top no-border-bottom text-sm text-right">
                                    
                                </td>
                                <td class="border no-border-top no-border-bottom text-sm text-right">
                                    
                                </td>
                                </tr>
                            ';
	                    }

	                    echo '
                            <tr>
                                <td class="border no-border-top text-sm">
                                    
                                </td>
                                <td class="border no-border-top text-sm">
                                    
                                </td>
                                <td class="border no-border-top text-sm">
                                    
                                </td>
                        ';

	                    if($val->UP_L != $up_l || $val->UP_L == $up_l) {
		                    echo '
                                <td class="border no-border-top text-sm text-right">
                                    ' . number_format_indo($val->UP_L, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->UP_I != $up_i || $val->UP_I == $up_i) {
		                    echo '
                                <td class="border no-border-top text-sm text-right">
                                    ' . number_format_indo($val->UP_I, 2) . '
                                </td>
                            ';
	                    }

	                    if($val->UP_T != $up_t || $val->UP_T == $up_t) {
		                    echo '
                                <td class="border no-border-top text-sm text-right">
                                    ' . number_format_indo($val->UP_T, 2) . '
                                </td>
                                <td class="border no-border-top text-sm text-right">
                                    
                                </td>
                                <td class="border no-border-top text-sm text-right">
                                    
                                </td>
                            </tr>
                            ';
	                    }
                    }

                }

                $Kd_Rek_5_Gab                       = $val->Kd_Rek_5_Gab;
                $gaji_l                             = $val->Gaji_L;
                $gaji_i                             = $val->Gaji_I;
                $gaji_t                             = $val->Gaji_T;
                $ls_l                               = $val->LS_L;
                $ls_i                               = $val->LS_I;
                $ls_t                               = $val->LS_T;
                $up_l                               = $val->UP_L;
                $up_i                               = $val->UP_I;
                $up_t                               = $val->UP_T;
                $total_spj                          = $val->TOTAL_SPJ;
                $total_sisa                         = $val->SISA;
            ?>
			</tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="border text-center text-sm-2 no-border-bottom">
                    <b>JUMLAH</b>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_anggaran, 2) ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_gaji_l, 2) ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_gaji_i, 2) ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_gaji_t, 2) ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-bottom">
					<?php echo number_format_indo(str_replace("-", " ", $jumlah_spj), 2); ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-bottom">
		            <?php echo number_format_indo(str_replace("-", " ", $jumlah_sisa), 2); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="border text-right text-sm-2 no-border-top no-border-bottom">

                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-top no-border-bottom">

                </td>
                <td class="border text-sm-2 text-right no-border-top no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_ls_l, 2) ?>
                </td>
                <td class="border text-sm-2 text-right no-border-top no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_ls_i, 2) ?>
                </td>
                <td class="border text-sm-2 text-right no-border-top no-border-left no-border-bottom">
					<?php echo number_format_indo($jumlah_ls_t, 2) ?>
                </td>
                <td class="border no-border-left no-border-top no-border-bottom">

                </td>
                <td class="border no-border-left no-border-top no-border-bottom">

                </td>
            </tr>
            <tr>
                <td colspan="2" class="border text-right text-sm-2 no-border-top">

                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-top">

                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-top">
					<?php echo number_format_indo(str_replace("-", " ", $jumlah_up_l), 2); ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-top">
					<?php echo number_format_indo(str_replace("-", " ", $jumlah_up_i), 2); ?>
                </td>
                <td class="border text-sm-2 text-right no-border-left no-border-top">
					<?php echo number_format_indo(str_replace("-", " ", $jumlah_up_t), 2); ?>
                </td>
                <td class="border no-border-left no-border-top">

                </td>
                <td class="border no-border-left no-border-top">

                </td>
            </tr>
            </tfoot>
		</table>
        <table class="table">
            <tbody>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    <b>Penerimaan</b>
                </td>
                <td width="20%" class="border no-border-top no-border-bottom no-border-left no-border-right">

                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    - SP2D
                </td>
                <td width="20%" class="border text-right no-border-top no-border-bottom no-border-left no-border-right">
	                <?php echo number_format_indo($jumlah_sp2d, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    - Lain-lain
                </td>
                <td width="20%" class="border text-right no-border-top no-border-left no-border-right">
		            <?php echo number_format_indo(0, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    <b>Jumlah Penerimaan</b>
                </td>
                <td width="20%" class="border text-right no-border-top no-border-left no-border-right">
		            <?php echo number_format_indo($jumlah_sp2d, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    <b>Pengeluaran</b>
                </td>
                <td width="20%" class="border no-border-top no-border-bottom no-border-left no-border-right">

                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    - SPJ (LS + UP/GU/TU)
                </td>
                <td width="20%" class="border text-right no-border-top no-border-bottom no-border-left no-border-right">
		            <?php echo number_format_indo($jumlah_spj, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    - Lain-lain
                </td>
                <td width="20%" class="border text-right no-border-top no-border-left no-border-right">
		            <?php echo number_format_indo(0, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    <b>Jumlah Pengeluaran</b>
                </td>
                <td width="20%" class="border text-right no-border-top no-border-left no-border-right">
		            <?php echo number_format_indo($jumlah_spj, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            <tr>
                <td width="20%" class="border no-border-top no-border-bottom no-border-right" style="padding-left:20px">
                    <b>Saldo Kas</b>
                </td>
                <td width="20%" class="border text-right no-border-top no-border-left no-border-right">
		            <?php echo number_format_indo($saldo_kas, 2); ?>
                </td>
                <td width="60%" class="border no-border-top no-border-bottom no-border-left">

                </td>
            </tr>
            </tbody>
        </table>
		<table class="table" style="page-break-inside:avoid">
			<tbody>
				<tr>
					<td colspan="6" width="50%" class="border no-border-top no-border-right">
                        <img src="<?php echo $qrcode; ?>" alt="..." width="100" />
					</td>
					<td colspan="6" width="60%" class="text-center no-border-top border no-border-left">
						<?php echo (isset($nama_daerah) ? $nama_daerah : '-') ;?>, <?php echo $tanggal_cetak; ?>
						<br />
						<b><?php
							    echo strtoupper($results['data_query'][0]->Jbt_Bendahara);
							?></b>
						<br />
						<br />
						<br />
						<br />
						<br />
						<u><b><?php
									echo $results['data_query'][0]->Nm_Bendahara;
								?></b></u>
						<br />
						<?php
							echo 'NIP. '. $results['data_query'][0]->Nip_Bendahara;
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
								RKA Belanja SKPD - <?php echo (isset($title) ? $title : '-'); ?>
								<?php //echo phrase('document_has_generated_from') . ' ' . get_setting('app_name') . ' ' . phrase('at') . ' {DATE F d Y, H:i:s}'; ?>
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
