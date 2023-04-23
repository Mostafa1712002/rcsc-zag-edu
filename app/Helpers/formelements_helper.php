<?php

	function spark_textFormGroup6($name,$label,$value='',$placeholder='',$attrs=array()){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>".spark_textFormGroup($name,$label,$value,$placeholder,$attrs)."</div>";
		return $text;
	}#textFormGroup6()

	function spark_recordMainPicFormGroup6($mainPic){
		$html = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center'>$mainPic</div>";
		return $html;
	}#spark_recordMainPicFormGroup;


	function spark_selectFormGroup6($name,$label,$options,$value='',$attrs=''){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>".spark_selectFormGroup($name,$label,$options,$value,$attrs)."</div>";
		return $text;
	}#selectFormGroup6()

	function spark_selectFormGroup6WithTextMuted($name,$label,$options,$value='',$attrs='',$textMuted=''){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'><div class='row'>".spark_selectFormGroup($name,$label,$options,$value,$attrs)."</div><div class='row'>".spark_mutedP($textMuted)."</div></div>";
		return $text;
	}#selectFormGroup6()



	function spark_textAreaFormGroup6($name,$label,$value='',$placeholder='',$class=''){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>".spark_textAreaFormGroup($name,$label,$value,$placeholder,$class)."</div>";
		return $text;
	}#textAreaFormGroup6()

	function spark_passwordFormGroup6($name,$label){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>".spark_passwordFormGroup($name,$label)."</div>";
		return $text;
	}#passwordFormGroup6()

	function spark_htmlInput($name,$value='',$placeholder='',$attrs=[]){
		$attrsText='';
		if(!isset($attrs['class'])){
			$attrs['class']='form-control';
		}else{
			$attrs['class'] .=' form-control';
		}

		foreach($attrs as $k=>$v){
			$attrsText .= " $k='$v' ";
		}
		return '<input '.$attrsText.' placeholder="'.$placeholder.'"  name="'.$name.'" value="'.$value.'"/>';
	}

	function spark_hiddenInput($name,$value){
		return spark_htmlInput($name,$value,'',$attrs=array('type'=>'hidden'));
	}#hiddenInput();

	function spark_textFormGroup($name,$label,$value='',$placeholder='',$attrs=array()){
		$text = '<div class="form-group ">';
		if(strlen(trim($label))){
			$text .= '<label class="pull-left">'.$label.':</label>';
		}
		$text .= spark_htmlInput($name,$value,$placeholder,$attrs).'<span class="invalid-feedback"></span></div><!-- form-group -->';
		return $text;
	}#textFormGroup()

	function spark_tagsInputFormGroup($name,$label,$value='',$placeholder='',$attrs=array()){
		$text = '<div class="form-group ">';
		if(strlen(trim($label))){
			$text .= '<div class="row"><label class="pull-right">'.$label.':</label></div>';
		}
		$text .= '<input style="width:100%" class="form-control" data-role="tagsinput" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'"/><span class="help-block"></span></div><!-- form-group -->';
		return $text;
	}#textFormGroup()

	function spark_datePickerFormGroup6($name,$label,$value=''){
		$text = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">'.spark_datePickerFormGroup($name,$label,$value,'YYYY-MM-DD').'</div><!-- col-lg-6-->';
		return $text;
	}#datePickerFormGroup6;

	function spark_datePickerFormGroup($name,$label,$value='',$placeholder='YYYY-MM-DD'){
		if(strstr($name, 'from') && strlen(trim($value)) == 0){
			$value = date('Y-m-d',strtotime('last month'));
		}elseif(strstr($name, 'to') && strlen(trim($value)) == 0){
			$value = date('Y-m-d');
		}

		$text = '<div class="form-group ">';
		if(strlen(trim($label))){
			$text .= '<label class="pull-left">'.$label.':</label>';
		}
		$text.= "<input class='form-control datepicker' placeholder='".$placeholder."' name='".$name."' value='".$value."'/><span class='help-block  invalid-feedback'></span></div><!-- form-group -->";
		return $text;
	}#textFormGroup()

	function spark_textAreaFormGroup($name,$label,$value='',$placeholder='',$class='',$id=''){
		$id = strlen($id)? $id : spark_generateRandomString(35);
		$text = "<div class='col-lg-12 col-sm-12 col-md-12 col-xs-12'><div class='form-group '><label>".$label.":</label><textarea style='direction:rtl;text-align:right' id='".$id."' placeholder='".$placeholder."' class='form-control ".$class."' name='".$name."'>".trim($value)."</textarea><span class='help-block invalid-feedback'></span></div></div>";
		return $text;
	}#textFormGroup()

	function spark_passwordFormGroup($name,$label){
		$text = '<div class="form-group "><label class="pull-left">'.$label.'</label><input type="password" class="form-control" name="'.$name.'"/><span class="help-block"></span></div><!-- form-group -->';
		return $text;
	}#textFormGroup()

	function spark_uploadFormGroup($name,$label,$existingFilePath=''){
		$text = '<div class="form-group "><label>'.$label.':</label><input class="form-control" type="file" name="'.$name.'"/>';
		if($existingFilePath){
			$existingFilePath = URL::to('storage/'.$existingFilePath);
			$text .= "<span><a href='$existingFilePath' target='_blank'>".__('general.preview')."</a></span>";
		}
		$text .= '<span class="help-block"></span></div>';
		return $text;
	}#uploadFormGroup

	function spark_uploadFormGroup6($name,$label){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>".spark_uploadFormGroup($name,$label).'</div>';
		return $text;
	}#uploadFormGroup6();

	function spark_uploadFormGroup6WithThumb($name,$label,$thumbSrc){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'><div class='col-lg-9 col-md-9 col-sm-9 col-xs-12'>".spark_uploadFormGroup($name,$label)."</div><div class='col-lg-3 col-md-3 col-sm-3 hidden-xs'>".spark_recordMainPicFormGroup6($thumbSrc).'</div></div>';
		return $text;
	}#uploadFormGroup6();


	function spark_uploadFormGroup6WithPreview($name,$label,$previewLink){
		$text = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'><div class='col-lg-9 col-md-9 col-sm-9 col-xs-12'>".spark_uploadFormGroup($name,$label)."</div><div class='col-lg-3 col-md-3 col-sm-3 hidden-xs'><a class='btn btn-sm btn-primary' href='".$previewLink."' target='_blank'><i class='glyphicon glyphicon-search'></i> View </a></div><span class='help-block'></span></div>";
		return $text;
	}#uploadFormGroup6();


	function spark_binaryFormGroup($name='',$label='',$value='',$class=''){
		$text = "
			<select name='".$name."' class='form-control ".$class."'>
				<option ".(($value==0)? "" : "selected='selected'")." value='0'>".lang('noSelection')."</option>
				<option ".(($value=='yes')? "" : "selected='selected'")." value='yes'>".lang('yes')."</option>
				<option ".(($value=='no')? "" : "selected='selected'")." value='no'>".lang('no')."</option>
			</select>
		";
		return $text;
	}/*binaryFormGroup*/


	function spark_selectFormGroup($name,$label,$options,$value=0,$attrs = "",$class='' ){
		$text = '<div class="form-group ">';
		$text .= strlen($label)? '<label>'.$label.':</label>' : '';
		$text .='<select class="form-control '.$class.'" name="'.$name.'" '.$attrs.' style="width:100%;">';
		$noSelectionBefore = 0;
		foreach($options as $k=>$v){
			$text .='<option ';
			if($noSelectionBefore==0){
				if($k===$value){
					$text .= 'selected="selected" ';
					$noSelectionBefore=1;
				}
			}
			$text .= 'value="'.$k.'">'.$v.'</option>';
		}#foreach();
		$text .= '</select><br/><span class="invalid-feedback"></span></div><!-- form-group -->';
		return $text;
	}#selectFormGroup()


	function spark_multipleSelectFormGroup($name,$label,$options,$value=[],$attrs = "",$class='' ){
		$text = '<div class="form-group ">';
		$text .= strlen($label)? '<label>'.$label.':</label>' : '';

		$text .='<select class="form-control '.$class.'" name="'.$name.'" '.$attrs.' style="width:100%;" multiple="multiple">';
		foreach($options as $k=>$v){
				$text .='<option ';
				if(array_key_exists($k,$value)){
					$text .= 'selected="selected" ';
			}
			$text .= 'value="'.$k.'">'.$v.'</option>';
		}#foreach();
		$text .= '</select><br/><span class="invalid-feedback"></span></div><!-- form-group -->';
		return $text;
	}#selectFormGroup()


	function spark_getEditModelLink($table,$id){
		?>
		<a class="btn btn-sm btn-info" href='<?php echo base_url('admin/'.$table.'/edit/'.$id); ?>'><i class="glyphicon glyphicon-pencil"></i></a>
		<?php
	}#getEditModelLink()

	function spark_getAjaxRemoveModelLink($table,$id,$msg=''){
		?>
		<a class="btn btn-sm btn-danger remove-<?php echo $table; ?>-btn" data-id='<?php echo $id; ?>' data-confirm-msg='<?php echo $msg; ?>' href='#'><i class="glyphicon glyphicon-remove"></i></a>
		<?php
	}#getEditModelLink()

	function spark_dateTimePicker($name='',$label='',$value=''){

		$text = '<div class="form-group "><label class="pull-left">'.$label.'":</label><input size="16" type="text" value="'.$value.'" readonly class="form-control dateTimePicker" name="'.$name.'"><span class="help-block"></span></div><!-- end form-group -->';


		return $text;
	}/*timePickerFormGroup*/


?>
