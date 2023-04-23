<?php 
	function spark_isValidDate($date, $format = 'Y-m-d'){
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) == $date;
	}#isValidDate;

	function spark_getLastMonthDate(){ 
		return date('Y-m-d',strtotime('-1 months'));
	}#getLastMonthDate;

	function getInstallationDate(){
		return '2017-01-01';
	}

	function spark_toArabicDate($date=''){
		$parts = explode('-', $date);
		return spark_toArabicNumber($parts[0]).'/'.spark_toArabicNumber($parts[1]).'/'.spark_toArabicNumber($parts[2]);
	}/*toArabicDate*/

	function spark_emptyDate(){
		return '0000-00-00 00:00:00';
	}#emptyDate;

	function spark_currentDate(){
		return date('Y-m-d H:i:s');
	}#currentDate();

	function spark_getCurrentDate($splitter='-'){
		return date('Y'.$splitter.'m'.$splitter.'d');
	}#currentDate();

	function spark_getCurrentDateTime($splitter='-'){
		return date('Y-m-d H:i:s');
	}#currentDate();


function spark_getAgeFromBirthYear($birthYear){
	$currentYear = date('Y');
	return $currentYear-$birthYear;
}#getAgeFromBirthYear;

function spark_diffInWeeks($from,$to){
	$day   = 24 * 3600;
 $from  = strtotime($from);
 $to    = strtotime($to) + $day;
 $diff  = abs($to - $from);
 $weeks = floor($diff / $day / 7);
 $days  = $diff / $day - $weeks * 7;
 $out   = array();
 return $weeks;
}#diffInWeeks;

function spark_validateDate($date){
	return spark_isValidDate($date)? $date : spark_getCurrentDate();
}#spark_validateDate


function spark_formatDateHTML($dateTime){
	$date = date('Y-m-d',strtotime($dateTime));
	return "<span data-toggle='tooltip' data-placement='top' title='$dateTime'>$date ".spark_glyph('time')."</span>";
}#spark_formatDateHTML;

function spark_getCurrentMonthNumber(){
	return date('n');
}#getCUrrentMonthNumber

function spark_getMonthName($monthNumber){
	$months = array(
		1=>lang('january'),
		2=>lang('february'),
		3=>lang('march'),
		4=>lang('april'),
		5=>lang('may'),
		6=>lang('june'),
		7=>lang('july'),
		8=>lang('august'),
		9=>lang('september'),
		10=>lang('october'),
		11=>lang('november'),
		12=>lang('december')
	);
	return $months[$monthNumber];
}#getMonthArabicName;

function spark_formatDateTime($dateTime,$format=''){
	$format = strlen($format)? $format : _DATETIME_FORMAT_;
	return date($format,strtotime($dateTime));
}/*formatDateTime*/

function spark_validateDateParams(&$from,&$to){
	$to = spark_validateDate($to);
	$from = spark_isValidDate($from)? $from : spark_getLastMonthDate();
}/*validateDateParams*/




