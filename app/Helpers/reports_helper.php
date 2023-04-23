<?php
	function spark_printReportCols($colsHeadings,$showSeries=1){
		/*
		# Only cols that are inside $cols will appear, not all cols inside $records.
		*/
		$html=($showSeries)? '<th style="width:5%" class="text-center bordered-th"><center>'.lang('series').'</center></th>' : '';

		foreach($colsHeadings as $colTerm=>$colWidth){
			$dontLang = 0;
			if(intval($colTerm)  || $colTerm=='0'){
				$colTerm=$colWidth;
				if(strstr(strtolower($colTerm),'_plainnolang')){
					$dontLang = 1;	
					$colTerm = trim(str_replace('_plainNoLang', '', $colTerm));
				}
				
				$colWidth='';
			}else{
				$colWidth = (strstr($colWidth, '%'))? $colWidth : $colWidth.'px';
			}/*if colWidth wasn't set a value, then the term will be value*/

			$colTerm = ($dontLang==0)? lang($colTerm) : $colTerm;
			$html .= '<th style="width:'.$colWidth.'" class="text-center bordered-th"><center>'.$colTerm.'</center></th>';
		}/*foreach cols*/

		$html .= "</tr></thead><tbody>";

		return $html;
	}/*printReportCols*/

	function spark_printReportTotalsRow($mergeCount,$totalsValues){
		$html = "<tr class='totals-tr'>";
		$html .= "<td colspan='$mergeCount' class='bordered-td totals-td'><center>".lang('total')."<center></td>";
		foreach($totalsValues as $singleTotalValue){
			$html .= spark_reportsTdCenter($singleTotalValue);
		}/*foreach*/
		return $html;
	}/*printReportTotalsRow*/



	function spark_printTableRows($records,$cols,$showSeries=1,$startOffset=1){
		//$i=$startOffset;
		$i=0;

		$html = '';

		foreach($records as $record){
			$i++;
			$tr = ($showSeries)? spark_reportsTdCenter($i) : '';
			foreach($cols as $colName=>$colIsCentered){
				if(is_numeric($colName)){
						$colName=$colIsCentered;							
				}/*intval($colName)*/

				$tr .= spark_tdCenter($record[$colName]);
			}/*cols*/
			$html .= spark_tr($tr);
			
		}/*records*/

		return $html;
	}/*spark_printTableRows*/

	



	function spark_printReportTableRows($records,$cols,$showSeries=1,$startOffset=1){
			//$i=$startOffset;
			$i=0;

			$html = '';

			foreach($records as $record){
				$i++;
				$tr = ($showSeries)? spark_reportsTdCenter($i) : '';
				foreach($cols as $colName=>$colIsCentered){
					if(is_numeric($colName)){
							$colName=$colIsCentered;							
					}/*intval($colName)*/

					$tr .= spark_reportsTdCenter($record[$colName]);
				}/*cols*/
				$html .= spark_tr($tr);
				
			}/*records*/

			return $html;
		}/*printReportTableRows*/




	function spark_generateTotalsArray($records,$totalFieldNames){
		/*
		# Pass the first row of records to search inside for the first field name of totals.
		*/
		$mergeCount = spark_findArrayIndexNumber($records[0],$totalFieldNames[0]);
		$mergeCount += 1;
		$totalsValuesWithIndexes=spark_generateTotalsValues($totalFieldNames);
		return ['mergeCount'=>$mergeCount,'totals'=>$totalsValuesWithIndexes];
	}/*generateTotalsArray*/

	function spark_generateTotalsValues($totalFieldNames){
		$totalsValuesWithIndexes = [];
		foreach($totalFieldNames as $totalFieldName){
			$totalsValuesWithIndexes[$totalFieldName] = spark_getIndexSum($records,$totalFieldName);
		}/*foreach totalFieldNames*/
		return $totalsValuesWithIndexes;
	}/*generateTotalsValues*/

	function spark_findArrayIndexNumber($singleArrayRow,$index){
		$indexNumber=-1;
		$counter = 0;
		foreach($singleArrayRow as $k=>$v){
			if($k==$index){
				$indexNumber = $counter;
				break;
			}
			$counter ++;
		}/*foreach*/
		return $indexNumber;
	}/*findArrayIndexNumber*/

	function spark_getStringBetweenBrackets($rawString,$asArray=0,$separatedBy=','){
		preg_match_all("/\[[^\]]*\]/", $rawString, $resultArray);
		$resultString = $resultArray[0][0];
		$resultString = substr($resultString, 1);
		$resultString = substr($resultString,0, -1);

		return ($asArray==1) ? explode($separatedBy, $resultString) : $resultString;
	}/*getStringBetweenBrackets*/