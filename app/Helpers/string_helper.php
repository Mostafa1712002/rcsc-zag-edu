<?php
	function spark_toArabicNumber($enNumber=0){
		$western_arabic = array('0','1','2','3','4','5','6','7','8','9');
		$eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

		if(strstr($enNumber, '.')){
			$parts = explode('.', $enNumber);
			$parts[0] = str_replace($western_arabic, $eastern_arabic, $parts[0]);
			$parts[1] = str_replace($western_arabic, $eastern_arabic, $parts[1]);
			$res = implode(',', $parts);
		}else{
			$res = str_replace($western_arabic, $eastern_arabic, $enNumber);
		}/*if Integer*/

		return $res;
	}/*toArabicNumber*/


	function spark_breakTextIntoLines($text='',$charsPerLine=0,$breakBy='</br>'){
		$res = '';
		$length = strlen($text);//10
		$lines = ceil($length/($charsPerLine));//4		

		for($i=1;$i<=$lines;$i++){
			$lineEnd = $i*$charsPerLine;//3;			

			for($j=$i;$j<=$lineEnd;$j++){
				$currentChar = $j-1;
				$res .= $text[$currentChar];				
			}/*for characters*/
			$res .= $breakBy;			
		}/*for*/


		return trim($res);
	}/*breakTextIntoLines*/



	function spark_addClass($text='',$class=''){
		return '<span class="'.$class.'">'.$text.'</span>';
	}/*addClass*/


