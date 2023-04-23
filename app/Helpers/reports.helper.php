<?php 
	function dropDown($items,$dropDownTitle,$glyphicon=''){
		$text = '<div class="dropdown"><button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.( strlen($glyphicon)? glyph($glyphicon) : '' ).' '.$dropDownTitle.'<span class="caret"></span></button><ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
		foreach($items as $item){
			if($item['type']=='link'){
				$text .= '<li>'.blankAnchor($item['link'],$item['title']).'</li>';
			}elseif($item['type']=='datePickerModal'){
				$text .= '<li>'.modalAnchor('generalDatePickerModal',$item['title'],array('data-modal-title'=>$item['modal-title'],'class'=>'datepicker-modal-btn','data-report-link'=>$item['report-link'])).'</li>';
			}
		}# foreach items;
		$text .= '</ul></div>';
		return $text;
	}#dropDown();


?>