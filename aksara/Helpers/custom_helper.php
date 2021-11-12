<?php
/**
 * Custom Helper
 *
 * @author			Aby Dahana
 * @profile			abydahana.github.io
 * @website			www.aksaracms.com
 * @since			version 4.2.4
 * @copyright		(c) 2021 - Aksara Laboratory
 */

if(!function_exists('terbilang'))
{
	function terbilang($number = null)
	{
		$huruf										= array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
		if($number < 12)
		{
			return (isset($huruf[$number]) ? ' ' . $huruf[$number] : 'Nol');
		}
		elseif($number < 20)
		{
			return terbilang($number - 10) . ' Belas';
		}
		elseif($number < 100)
		{
			return terbilang($number / 10) . ' Puluh' . terbilang($number % 10);
		}
		elseif($number < 200)
		{
			return ' Seratus' . terbilang($number - 100);
		}
		elseif($number < 1000)
		{
			return terbilang($number / 100) . ' Ratus' . terbilang($number % 100);
		}
		elseif($number < 2000)
		{
			return ' Seribu' . terbilang($number - 1000);
		}
		elseif($number < 1000000)
		{
			return terbilang($number / 1000) . ' Ribu' . terbilang($number % 1000);
		}
		elseif($number < 1000000000)
		{
			return terbilang($number / 1000000) . ' Juta' . terbilang($number % 1000000);
		}
		elseif($number < 1000000000000)
		{
			return terbilang($number / 1000000000) . ' Milyar' . terbilang($number % 1000000000);
		}
		elseif($number < 1000000000000000)
		{
			return terbilang($number / 1000000000000) . ' Trilyun' . terbilang($number % 1000000000000);
		}
		elseif($number <= 1000000000000000)
		{
			return 'Maaf Tidak Dapat di Proses Karena Jumlah Uang Terlalu Besar ';
		}
		return false;
	}
}

if(!function_exists('date_indo'))
{
	function date_indo($date = null, $day_name = false, $separator = ' ', $hour = false)
	{
		$date							= strtotime($date);
		$day							= ucwords(phrase(date('l', $date)));
		$month							= (3 == $day_name ? phrase(date('M', $date)) : phrase(date('F', $date)));
		$year						 	= date('Y', $date);
		return ($day_name && 3 != $day_name ? $day . ', ' : '') . date('d', $date) . $separator . $month . $separator . ($year > 0 ? $year : 1970) . ($hour ? ' ' . date('H:i:s', $date) : null);
	}
}

if(!function_exists('get_begin_month'))
{
	function get_begin_month($date = null)
	{
		$date										= strtotime($date);
		$month										= date('n', $date);
		$year										= date('Y', $date);
		return $year .'-' . $month . '-01';
	}
}

if(!function_exists('get_last_month'))
{
	function get_last_month($date = null)
	{
		$date										= strtotime($date);
		$month										= date('n', $date);
		$year										= date('Y', $date);
		if ($month == 1)
		{
			return $year .'-01-31';
		}
		elseif ($month == 2)
		{
			return $year .'-02-29';
		}
		elseif ($month == 3)
		{
			return $year .'-03-31';
		}
		elseif ($month == 4)
		{
			return $year .'-04-30';
		}
		elseif ($month == 5)
		{
			return $year .'-05-31';
		}
		elseif ($month == 6)
		{
			return $year .'-06-30';
		}
		elseif ($month == 7)
		{
			return $year .'-07-31';
		}
		elseif ($month == 8)
		{
			return $year .'-08-31';
		}
		elseif ($month == 9)
		{
			return $year .'-09-30';
		}
		elseif ($month == 10)
		{
			return $year .'-10-31';
		}
		elseif ($month == 11)
		{
			return $year .'-11-30';
		}
		elseif ($month == 12)
		{
			return $year .'-12-31';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('spell_triwulan'))
{
	function spell_triwulan($date = null)
	{
		$date										= strtotime($date);
		$month										= date('n', $date);
		if ($month == 1)
		{
			return 'Triwulan 1';
		}
		elseif ($month == 4)
		{
			return 'Triwulan 2';
		}
		elseif ($month == 7)
		{
			return 'Triwulan 3';
		}
		elseif ($month == 10)
		{
			return 'Triwulan 4';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_begin_periode_triwulan'))
{
	function get_begin_periode_triwulan($date = null)
	{
		$date										= strtotime($date);
		$month										= date('n', $date);
		$year										= date('Y', $date);
		if ($month < 4)
		{
			return $year .'-01-01';
		}
		elseif ($month < 7)
		{
			return $year .'-04-01';
		}
		elseif ($month < 10)
		{
			return $year .'-07-01';
		}
		elseif ($month > 9)
		{
			return $year .'-10-01';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_last_periode_triwulan'))
{
	function get_last_periode_triwulan($date = null)
	{
		$date										= strtotime($date);
		$month										= date('n', $date);
		$year										= date('Y', $date);
		if ($month < 4)
		{
			return $year .'-03-31';
		}
		elseif ($month < 7)
		{
			return $year .'-06-30';
		}
		elseif ($month < 10)
		{
			return $year .'-09-30';
		}
		elseif ($month > 9)
		{
			return $year .'-12-31';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('spell_caturwulan'))
{
	function spell_caturwulan($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		if ($month == 1)
		{
			return 'Caturwulan 1';
		}
		elseif ($month == 5)
		{
			return 'Caturwulan 2';
		}
		elseif ($month == 9)
		{
			return 'Caturwulan 3';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_begin_periode_caturwulan'))
{
	function get_begin_periode_caturwulan($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		$year							= date('Y', $date);
		if ($month < 5)
		{
			return $year .'-01-01';
		}
		elseif ($month < 9)
		{
			return $year .'-05-01';
		}
		elseif ($month > 8)
		{
			return $year .'-09-01';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_last_periode_caturwulan'))
{
	function get_last_periode_caturwulan($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		$year							= date('Y', $date);
		if ($month < 5)
		{
			return $year .'-04-30';
		}
		elseif ($month < 9)
		{
			return $year .'-08-31';
		}
		elseif ($month > 8)
		{
			return $year .'-12-31';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('spell_tahap'))
{
	function spell_tahap($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		if ($month == 1)
		{
			return 'Tahap 1';
		}
		elseif ($month == 4)
		{
			return 'Tahap 2';
		}
		elseif ($month == 9)
		{
			return 'Tahap 3';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_begin_periode_tahap'))
{
	function get_begin_periode_tahap($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		$year							= date('Y', $date);
		if ($month < 4)
		{
			return $year .'-01-01';
		}
		elseif ($month < 9)
		{
			return $year .'-04-01';
		}
		elseif ($month > 8)
		{
			return $year .'-09-01';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_last_periode_tahap'))
{
	function get_last_periode_tahap($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		$year							= date('Y', $date);
		if ($month < 4)
		{
			return $year .'-03-31';
		}
		elseif ($month < 8)
		{
			return $year .'-08-31';
		}
		elseif ($month >= 8)
		{
			return $year .'-12-31';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('spell_semester'))
{
	function spell_semester($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		if ($month == 1)
		{
			return 'Semester 1';
		}
		elseif ($month == 7)
		{
			return 'Semester 2';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_begin_periode_semester'))
{
	function get_begin_periode_semester($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		$year							= date('Y', $date);
		if ($month < 7)
		{
			return $year .'-01-01';
		}
		elseif ($month < 12)
		{
			return $year .'-07-01';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('get_last_periode_semester'))
{
	function get_last_periode_semester($date = null)
	{
		$date							= strtotime($date);
		$month							= date('n', $date);
		$year							= date('Y', $date);
		if ($month < 7)
		{
			return $year .'-06-30';
		}
		elseif ($month < 12)
		{
			return $year .'-12-31';
		}
		elseif ($month == 0)
		{
			return 'Belum diset';
		}
	}
}

if(!function_exists('number_format_indo'))
{
	function number_format_indo($number = null, $decimal = null)
	{
		$output										= number_format($number, $decimal, ',', '.');
		return $output;
	}
}
