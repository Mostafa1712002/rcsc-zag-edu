<?php

use Illuminate\Support\Facades\Storage;
	function spark_hashPassword($password){
  $salt = 'bn6mr4i5lzn1jj2ctnqp4n47oe';
  $password = trim($password);
  return hash("sha256", $password . $salt);
	}#spark_hashPassword();


	function spark_isValidEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}#isValidEmail;

	function spark_validateEmail($email=''){
		return spark_isValidEmail($email)? $email : '';
	}/*spark_validateEmail*/


	function spark_redirect($to){
		//die('To='.$to);
		echo '<meta http-equiv="refresh" content="0; url='.$to.'" />';
		die();
	}//spark_redirect();

	function spark_printR2($a,$die=0){
		echo '<pre>';
		print_r($a);
		echo '</pre>';
		if($die){
			die('-------- printed and dead ---------');
		}
	}

	function spark_dd($thing){
		var_dump($thing);
		die();
	}

	function spark_generateRandomString($length=10){
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		$randomString = '';

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $randomString;
	}#generateRandomString();

	function spark_generateRandomNumber($length){
		$characters = '123456789';
		$randomNumber = '';

		for ($i = 0; $i < $length; $i++) {
			$randomNumber .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $randomNumber;
	}#generateRandomNumber();


	function spark_detectBoolean($cond,$ifTrue,$ifFalse){
		return ($cond)? $ifTrue : $ifFalse;
	}#detectBoolean;

	/*
	# Convert multi-dimensional array (Returned from DB ) to flat array (to use in spark_selectFormGroup).
	*/
	function spark_toFlatArray($m){
		$flat = array();
		foreach($m as $k=>$v){
			$flat[$v['id']] = $v['value'];
		}#foreach;
		return $flat;
	}#toFlatArray;


 	function getIndexSum($records,$index='totalPrice'){
			$total = 0;
			foreach($records as $record){
				$total += $record[$index];
			}#foreach;
			return $total;
	}#getInvoiceTotal

	function spark_getIndexSum($records,$index='totalPrice'){
		$total = 0;
		foreach($records as $record){
			$total += $record[$index];
		}#foreach;
		return $total;
	}#getInvoiceTotal

		function spark_safeString($str=''){
			return $str;
		}#spark_safeString

		function spark_addOptionZero($array,$term=''){
			$secondArray = strlen(trim($term)) ? [$term] : [__('general.noSelection')];
			return array_merge($secondArray,$array);
		}#addOptionZero


		function spark_removeOption($records,$optionValue){
			foreach($records as $k=>$v){
				if($k==$optionValue){
					unset($records[$k]);
				}
			}
			return $records;
		}#spark_removeOption;

		function spark_generateLangArray($a){
			foreach($a as $k=>$v){
				$a[$k]=lang($v);
			}//foreach
			return $a;
		}#spark_generateLangArray;

		function spark_getURISegment($segmentNumber){
			$uri = $_SERVER['REQUEST_URI'];
			$parts = explode('/', $uri);
			return isset($parts[$segmentNumber+1])? $parts[$segmentNumber+1] :0;
		}#getURISegment;

	function spark_extractArrayKeys($a){
		$res = [];
		foreach($a as $k=>$v){
			$res[] = $k;
		}/*foreach*/
		return $res;
	}/*extractArrayKeys*/

	function spark_getDateRangeWhere($from,$to){
		return "DATE(`whenMade`)>='$from' AND DATE(whenMade)<='$to'";
	}/*getDateRangeWhere*/


	function spark_unsetArrayKeys($records,$ks){
		foreach($records as $k=>$record){
			foreach($ks as $singleKey){
				if(isset($record[$singleKey])){
					unset($record[$singleKey]);
					$records[$k] = $record;
				}
			}/*foreach keys*/
		}/*foreach records*/

		return $records;
	}/*unsetArrayKeys*/

	function spark_getRangeForSelect($from=0,$to=20){
		$records = [];
		for($i=$from;$i<=$to;$i++){
			$records[] = ['id'=>$i,'value'=>$i];
		}/*for*/
		return spark_toFlatArray($records);
	}/**/


	function spark_arrayValueExists($a,$v){
		foreach($a as $k=>$kVal){
			if($kVal==$v){
				return true;
			}
		}
		return false;
	}/*arrayValueExists*/

	function spark_putLeadingZeros($number=0,$outputLength=5){
		return str_pad($number,$outputLength,"0",STR_PAD_LEFT);
	}/**/

	function spark_isEnglish($str){
		if (!preg_match('/[^A-Za-z]/', $str)){
			return true;
		}
		return false;
	}/*isEnglish*/

	function spark_isArabic($subject){
  $list = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','z',1,2,3,4,5,6,7,8,9,0];
  return (spark_stringHas($subject,$list))? false : true;
	}/*isArabic*/

	function spark_stringHas($string,$list){
		$string = str_split($string);
		foreach($string as $l){
			if(spark_arrayValueExists($list,$l)){
				return true;
			}
		}
		return false;
	}/*stringHas*/

	function spark_removeArrayPrefix($a=[],$prefix=''){
		foreach($a as $k=>$v){
			$newK = str_replace($prefix, '', $k);
			$a[$newK] = $v;
			unset($a[$k]);
		}/*foreach*/
		return $a;
	}/*removeArrayPrefix*/



	function spark_addArrayPrefix($a=[],$prefix=''){
		foreach($a as $k=>$v){
			$newK = $prefix.$k;
			$a[$newK] = $v;
			unset($a[$k]);
		}/*foreach*/
		return $a;
	}/*addArrayPrefix*/

	function spark_getCurrentIP(){
		return '192.168.1.12';
	}/*getCurrentIP*/


	function spark_getThumbName($mainPic=''){
		$picNameParts = explode('.', $mainPic);
		$picName = $picNameParts[0].'_thumb';
		$picExt = $picNameParts[1];
		$picNameArray= [$picName,$picExt];
		return implode('.', $picNameArray);
	}/*getThumbName*/



	function spark_replaceR($context='',$replacementArray=[]){
		return vsprintf($context, $replacementArray);
	}/*recursive sprintf*/


	function spark_upload($file,$file_type){
		if($file_type=='image'){
			return uploadImgFromMobile($file);
		}
		return spark_uploadFile($file);
	}

function uploadImgFromMobile($img, $tag=''){
	$year_path = public_path('/uploads/'.date('Y'));
	if(!file_exists($year_path)){
		mkdir($year_path);
	}

	$month_path = $year_path.'/'.date('m');
	if(!file_exists($month_path)){
		mkdir($month_path);
	}

	$day_path = $month_path.'/'.date('d');
	if(!file_exists($day_path)){
		mkdir($day_path);
	}

	$path = $day_path.'/';


	$fullName = $tag.'_'.Str::random(50).date('Y-m-d').'.jpeg';
	$img = Image::make($img)->save($path.$fullName);
	$img = Image::make($img)->resize(200,200)->save($path.'thumb_'.$fullName);

	return date('Y/m/d').'/'.$fullName;
}


function spark_uploadFile($img, $tag=''){
	$year_path = public_path('/uploads/'.date('Y'));
	if(!file_exists($year_path)){
		mkdir($year_path);
	}

	$month_path = $year_path.'/'.date('m');
	if(!file_exists($month_path)){
		mkdir($month_path);
	}

	$day_path = $month_path.'/'.date('d');
	if(!file_exists($day_path)){
		mkdir($day_path);
	}

	$path = $day_path.'/';


	$full_name = $tag.'_'.Str::random(50).date('Y-m-d').'.pdf';
	$img = $img->move($path,$full_name);
	//$img = Storage::disk('local')->put($full_name, file_get_contents($img));

	return $path.$full_name;
}

function uploadImage($img, $tag)
{
    $fullName = $tag.'_'.mt_rand(10, 100).date('Y-m-d').'.jpeg';
    $path = public_path('/uploads/');
    $img = Image::make($img)->save($path.$fullName);

    return config('APP_URL').'/public/uploads/'.$fullName;
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    $lang = request()->header('Accept-Language') ? request()->header('Accept-Language') : 'ar';
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        if ($lang == 'ar') {
            return number_format(($miles * 1.609344)) . ' ك.م';
        } else {
            return number_format(($miles * 1.609344)) . ' km';
        }
    } elseif ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }



    function shiasha($tokens=[],$notification=[],$data=[])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';


        $FcmKey = env('FCM_SERVER_KEY');

        $data = [
            "registration_ids" => $tokens,
            "notification" => $notification,
            'data'=>$data
        ];

        $RESPONSE = json_encode($data);

        $headers = [
            'Authorization:key=' . $FcmKey,
            'Content-Type: application/json',
        ];

        // CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $output = curl_exec($ch);
        if ($output === FALSE) {
            die('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $output;
    }
}


