<?php 
	function numberFormatPrecision($number, $precision = 2, $separator = '.'){
	 /*return number_format($number, $precision, '.', $separator) ;	 */
	 return round(abs($number),2);

	}#numberFormatPrecision.

	function spark_formatMoney($money,$withLabel=0){

		$res = numberFormatPrecision($money,3);
		return abs($res);
		if($withLabel==1){
			$transactionType = ($money>0)? lang('income') : lang('outgoing');
			$res .= '['.$transactionType.']';
		}/*required amount with label : income or outgoing*/
		
		return $res;
		//return numberFormatPrecision($money,2,',');
	}



	function spark_roundPrice($price){
		return floor($price*100)/100;
	}#spark_roundPrice...

	function spark_isValidPaymentMethod($methodTitle){
		$res = '';
		if(
				$methodTitle=='cash' ||
				$methodTitle=='chequeTransfer' ||
				$methodTitle=='bankTransfer'
			){
			$res = $methodTitle;
		}
		return $res;
	}/*isValidPaymentMethod*/

?>