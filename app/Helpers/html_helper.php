<?php

	function spark_tdCenter($text,$class=''){
		$class .= ' text-center';
		return spark_td($text,$class);
	}

	function spark_reportsTdCenter($text,$class=''){
		return "<td class='bordered-td $class'><center>$text</center></td>";
	}/*reportsTdCenter*/

	function spark_reportsTd($text){
		return "<td class='bordered-td' dir='rtl' style='text-align:right'>$text</td>";
	}/*reportsTdCenter*/

	function spark_td($text,$classes=''){
		$text = strlen($text)>30 && !strstr($text,'html-dont-clip')? substr($text,0,30).'..' : $text;
		return "<td class='$classes' style='width:20%;word-break: break-all'>$text</td>";
	}


	function spark_label($text,$class='primary'){
		return "<span class='btn btn-xs btn-$class'>$text</span>";
	}#spaek_label;



	function spark_tr($html,$class=''){
		return "<tr class='$class'>$html</tr>";
	}

	function spark_p($text,$attrs=''){
		return "<p $attrs >$text</p>";
	}#spark_p
	function spark_mutedP($text){
		return spark_p($text,"class='text-muted text-italic'");
	}#spark_mutedP;

	function spark_hr(){
		return "</hr>";
	}#spark_hr;


	function spark_drawHRTable($trsArray = array(),$dir='rtl'){
		$text = "<table class='table table-hover table-striped table-responsive' dir='$dir'>";
		foreach($trsArray as $k=>$tr){
			$text .= "<tr>";
			$counter= 0;
			foreach($tr as $k=>$td){

				$tdID = $td[0];
				$tdValue = $td[1];

				/*[Start] bolden, and attach ':' */
				$class = '';
				if($counter%2 == 0){
					$class = 'text-bold';
					$tdValue .= ':';
				}
				$counter++;
				/*[End] bolden, and attach ':' */


				if(!isset($td['type'])){
					$td['type'] = 'rawText';
				}

				if($td['type']=='rawText'){
					$text .="<td class='$class' id='$tdID'>$tdValue</td>";
				}elseif($td['type']=='select'){
					$options = $td['options'];
					$text .= "<td class='$class' id='$tdID'>".spark_selectFormGroup($tdID,'',$options,$tdValue)."</td>";
				}
			}#foreach($tds);
			$text .= "<tr/>";
		}#foreach();

		$text .= "</table>";
		return $text;
	}#drawHRTable();


	function spark_startTableFormatted($ths=[],$dir='rtl',$attrs='',$class=''){
		foreach($ths as $k=>$v){
			unset($ths[$k]);
			$cant_order = strstr($v,'_cant_order');
			$ths[$v] = __('general.'.str_replace('_cant_order','',$v)) . ($cant_order? '_cant_order' : '');
		}/*foreach ths*/
		return spark_startTable($ths,$dir,$attrs,$class);
	}/*spark_startTableFormatted*/

	function spark_startTable($theads=[],$dir='',$attrs=''){
		$dir = (app()->getLocale()=='ar')? 'rtl' : 'ltr';
		$text = "<table class='table table-hover table-striped ' style='width:100%' dir='".$dir."' $attrs><thead>";
		$theads = array_merge([__('general.series')],$theads);
		foreach($theads as $k=>$thead){
			$ignore_order = 0;
			if(strstr($k,'_cant_order')){
				$ignore_order=1;
				$thead = str_replace('_cant_order','',$thead);
			}
			$text .= "<th scope= 'col' class='text-center'>";
			if(!$ignore_order){
				$text .= "<a href='#' class='order-th' data-order-by='$k'>$thead <i class='fas fa-sort'></i></a></th>";
			}else{
				$text .= $thead."</th>";
			}

		}#foreach();
		$text .= "</thead><tbody>";
		return $text;
	}#startTable()


	function spark_printTableRows($records,$cols,$showSeries=1,$startOffset=1){
		//$i=$startOffset;
		$i=0;

		$html = '';

		foreach($records as $record){
			$i++;
			$tr = ($showSeries)? spark_reportsTdCenter($i) : '';
			foreach($cols as $colName){
				if(strstr($colName,'.')){
								$relationParts = explode('.',$colName);
								$res = $record[$relationParts[0]];
								foreach($relationParts as $k=>$part){
												if($k==0){
																continue;
												}
												$res = $res[$part];
								}
								$value = $res;
				}else{
								$value = $record[$colName];
				}

				$tr .= spark_tdCenter($value);
			}/*cols*/
			$html .= spark_tr($tr);

		}/*records*/

		return $html;
	}/*spark_printTableRows*/



	function spark_endTable(){
		return "</tbody></table>";
	}#endTable()


	function spark_startModal($modalInfo = array()){
		if(!isset($modalInfo['id'])){
			$modalInfo['id'] = spark_generateRandomString(25);
		}

		if(!isset($modalInfo['icon'])){
			$modalInfo['icon'] = 'th-list';
		}

		if(!isset($modalInfo['title'])){
			$modalInfo['title'] = '';
		}


		$text = "<div class='modal fade' id='".$modalInfo['id']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button><h4 class='modal-title' id='myModalLabel'> ".spark_glyph($modalInfo['icon'])." ".$modalInfo['title']."</h4></div><div class='modal-body'>";
		$text .= spark_alertOK('',$modalInfo['id']);
		$text .= spark_alertError('',$modalInfo['id']);
		return $text;
	}#startModal()

	function spark_endModal($btnInfo=array()){
		if(!isset($btnInfo['id'])){
			$btnInfo['id'] = spark_generateRandomString(20);
		}

		if(!isset($btnInfo['containsBtn'])){
			$btnInfo['containsBtn'] = true;
		}

		if(!isset($btnInfo['title'])){
			$btnInfo['title'] = line('save');
		}

		if(!isset($btnInfo['icon'])){
			$btnInfo['icon'] = 'arrow-left';
		}

		if(!isset($btnInfo['class'])){
			$btnInfo['class'] = 'success disabled';
		}

		if(!isset($btnInfo['pull'])){
			$btnInfo['pull'] = 'left';
		}

		$btnInfo['pull-text'] = 'pull-'.$btnInfo['pull'];



		$text = "</div><div class='modal-footer'>";

		/*
			# If a btnID contains '-', that means an id was writtern manually, NOT by spark_generateRandomString();
			# To append a button to modal footer, just provide its id, otherwise: no button will appear.
		*/
		if(strstr($btnInfo['id'], '-')){
			$text .= "<button type='button' id='".$btnInfo['id']."' class='btn btn-sm btn-".$btnInfo['class']." ".$btnInfo['pull-text']."'>".spark_glyph($btnInfo['icon'])." ".$btnInfo['title']."</button><div class='clearfix'></div>";
		}#end if btnID
		$text .= "</div></div></div></div>";
		return $text;
	}#endModal()


	function spark_alertAny($msg,$class,$alertID='',$icon='ok'){
		$text = "<div style='display:none' class='alert alert-".$class."' id='".$alertID."'>".spark_glyph($icon)."<span style='text-align:".(app()->getLocale()== 'en'? 'left' : 'right')."'>".$msg."</span></div>";
		return $text;
	}#alertAny();


	function spark_alertAnyVisible($msg,$class,$alertID='',$icon='ok'){
		$text = "<div class='alert alert-".$class."' id='".$alertID."'>".spark_glyph($icon)."<span dir='ltr'>".$msg."</span></div>";
		return $text;
	}#alertAny();

	function spark_alertOKVisible($msg,$alertID=''){
		return spark_alertAnyVisible($msg,'success',$alertID,'ok');
	}#alertOKVisible

	function spark_alertErrorVisible($msg,$alertID=''){
		return spark_alertAnyVisible($msg,'danger',$alertID,'remove');
	}#alertErrorVisible

	function spark_alertInfoVisible($msg,$alertID=''){
		return spark_alertAnyVisible($msg,'info',$alertID,'info-sign');
	}#alertInfoVisible

	function spark_alertWarningVisible($msg,$alertID=''){
		return spark_alertAnyVisible($msg,'warning',$alertID,'info-sign');
	}#alertWarningVisible





	function spark_alertError($msg,$alertID=''){
		$alertID = strlen($alertID)? $alertID.'-alert-error' : spark_generateRandomString(10).'-alert-error';
		return spark_alertAny($msg,'danger',$alertID,'remove');
	}#alertError()

	function spark_alertWarning($msg,$alertID=''){
		$alertID = strlen($alertID)? $alertID.'-alert-warning' : spark_generateRandomString(10).'-alert-error';
		return spark_alertAny($msg,'warning',$alertID,'info-sign');
	}#alertError()


	function spark_alertOK($msg,$alertID=''){
		$alertID = strlen($alertID)? $alertID.'-alert-ok' : spark_generateRandomString(10).'-alert-success';
		return spark_alertAny($msg,'success',$alertID,'ok');
	}#alertOK()


	function spark_panelStartSimple($id,$title,$class='default'){
		$text = "<div class='panel panel-$class' id='$id'>";
		$text .= "<div class='panel-heading'>";
		$text .= "<h3 class='panel-title'>$title</h3>";
		$text .= "</div>";
		$text .= "<div class='panel-body'>";

		return $text;
	}#panelStart();

	function spark_panelEndSimple(){
		$text = "</div>";
		return $text;
	}#panelEnd();

	function spark_endPanelWithHTML($html){
		return spark_panelEndWithHTML($html);
	}/*endPanelWithHTML*/

	function spark_endPanelWithPrintBtn($info=[]){
		$id= isset($info['id'])? $info['id'] : 'print-btn';
		return spark_endPanelWithHTML(spark_printBtn(['id'=>$id]));
	}/*endPanelWithPrintBtn*/

	function spark_panelEndWithHTML($html){
		$text = "</div>";
		$text .="<div class='panel-footer'>$html";
		$text .= spark_clearfixDiv();
		$text .="</div>";
		$text .= spark_panelEndSimple();
		return $text;
	}#panelEndWithFooter();



	function spark_pagingHTML($pagesCount){
		$text = "";
		if($pagesCount>0){
			$text .= "<ul class='pagination'>";
			for($i=0;$i<$pagesCount;$i++){
				$text .= "<li><a href='?p=$i'>".($i+1)."</a></li>";
			}#for;
			$text .= "</ul>";
		}
		return $text;
	}#pagingHTML();

	function spark_attrsRow($html,$attrs){
		return "<div $attrs>$html</div>";
	}#attrsRow;

	function spark_row($html){
		return "<div class='row'>$html</div>";
	}#row()

	function spark_centeredRow($html){
		return "<div class='row text-center'>$html</div>";
	}#centeredRow()

	function spark_centeredH3($text){
		return "<h3 class='text-center'>$text</h3>";
	}/*centeredH3*/
	function spark_centeredP($text){
		return "<p class='text-center'>$text</p>";
	}/*centeredP*/



	function spark_startPanel($title,$class,$model='',$btnInfo=array()){
		if(count($btnInfo)){
			$btnText = spark_btn($btnInfo);
		}else{
			$btnText = strlen($btnInfo)? $btnInfo : '';
		}

		$text = "
			<div class='panel panel-".$class."' id='".$model."-panel'>
			<div class='panel-heading'>
				<h3 class='panel-title pull-right' dir='ltr'>".$title."</h3>
				".$btnText."
				<div class='clearfix'></div>
			</div><!-- End panel-heading-->
			<div class='panel-body'>
		";
		return $text;

	}#startPanel();


	function spark_startCard($title,$class='default',$btnInfo=[]){
		$btnText = '';
		if(is_array($btnInfo) && count($btnInfo)){
			$btnText = spark_btn($btnInfo);
		}

        $text='';
        $c_url = url()->current();
        $pull_direction = app()->getLocale()=='ar'? 'left' : 'right';
        $opposite_direction = app()->getLocale()=='en'? 'left' : 'right';


        if(strstr($c_url,'edit') || strstr($c_url,'create') || strstr($c_url,'setting')){
            $text = '

            ';
            $col_html = '<div class="col-lg-11"></div>';
            $text = app()->getLocale()=='en'? $text.$col_html : $col_html.$text;
            $text = '<div class="row">'.$text.'</div>';
        }


        $text .='
		<div class="card card-'.$class.'">
				<div class="card-header">
						<h5 dir="rtl" class="card-title m-0 '.app()->getLocale().' float-'.$pull_direction.'">'.$title.'</h5>
						'.$btnText.'
						<div class="clearfix"></div>
				</div>
				<div class="card-body">
		';
		return $text;
	}#startPanel();



	function spark_dropdownBtnOld($btnTitle,$items,$btnClass='default',$pull='',$icon=''){
		$text= '
			<div class="btn-group">
					<button type="button" class="btn btn-'.$btnClass.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							'.$btnTitle.'
					</button>
					<div class="dropdown-menu">';
				foreach($items as $itemTitle=>$itemLink){
					$text .= '<a class="dropdown-item" href="'.$itemLink.'">'.__('general'.$itemTitle).'</a>';
				}


		$text='
				</div>
			</div>
		';
		return $text;
	}#dropdownBtn;

	function spark_startPanelWithHTML($title,$class,$model,$html){
		$text = "
			<div class='panel panel-".$class."' id='".$model."-panel'>
			<div class='panel-heading'>
				<h3 class='panel-title pull-right' dir='ltr'>".$title."</h3>
				".$html."
				<div class='clearfix'></div>
			</div><!-- End panel-heading-->
			<div class='panel-body'>
		";
		return $text;

	}#startPanel();

	function spark_btn($info){

		if(!count($info)){
			return;
		}

		if(!isset($info['pull'])){
			$info['pull'] = 'left';
		}

		if(strlen($info['pull'])==0){
			$info['pull-text'] = '';
		}else{
			$info['pull-text'] = 'float-'.$info['pull'];
		}



		if(!isset($info['href'])){
			$info['href'] = '#';
		}

		if(!isset($info['size'])){
			$info['size'] = 'sm';
		}

		if(!isset($info['class'])){
			$info['class'] = 'default';
		}

		if(!isset($info['title'])){
			$info['title'] = '';
		}

		if(!isset($info['icon'])){
			$info['icon'] = 'arrow-left';
		}

		if(!isset($info['target'])){
			$info['target'] = '_self';
		}

		if(!isset($info['id'])){
			$info['id'] = spark_generateRandomString(5);
		}



		$dataText = '';
		if(isset($info['data'])){
			$dataText = '';
			foreach($info['data'] as $k=>$v){
				$dataText .= "data-$k='$v' ";
			}
		}#end if no btn data was provided


		$disabledText = "";
		if(isset($info['disabled']) && @$info['disabled'] != 0){
			$disabledText = "disabled='disabled'";
		}


		$text = "<a $disabledText target='".$info['target']."' $dataText href='".$info['href']."' id='".$info['id']."' class='html-dont-clip text-bold btn ".$info['pull-text']." btn-".$info['size']." btn-".$info['class']."'>".spark_glyph($info['icon']).' '.$info['title']."</a>";
		return $text;
	}#btn();

	function spark_endPanel($type='',$model=''){
		$text = "</div><!-- End panel-body-->";


		if($type=="save"){
			$text .= "<div class='panel-footer'>";
			$btnInfo = array('title'=>'حفظ','id'=>"save-$model-btn",'pull'=>'left','class'=>'success','icon'=>'arrow-left');
			$text .= btn($btnInfo);

			$text .= "<div class='clearfix'></div>";
			$text .= "</div>";
		}else{
			$text .= $type;
		}#if html is provided as $type
		$text .= "</div>";

		return $text;
	}#endPanel();

	function spark_endCard(){
		return '</div></div>';
	}

	function spark_endCardWithPaging($pagesCount=0,$currentPage=0){
		$text = spark_printPagination($pagesCount,$currentPage);
		return spark_endCardWithHTML($text);
	}

	function spark_endCardWithHTML($text=''){
		return $text . spark_endCard();
	}


	function spark_endPanelWithPaging($pagesCount=1,$currentPage=0){
		return spark_endPanelPaging($pagesCount,'',$URIParams,$currentPage);
	}#endPanelWithPaging();

	function spark_printPaginationPages($pagesCount=0,$currentPage=0){
		$pagesHTML = '';
		for($i=0;$i<$pagesCount;$i++){
			$class = '';
			if($i==$currentPage){
				$class='active';
			}
			$pagesHTML .="<li class= 'page-item $class'><a href='#' class='page-link pagination-btn' data-page='".$i."'>".($i+1)."</a></li>";
		}#for();
		return $pagesHTML;
	}//

	function spark_printPagination($pagesCount=0,$currentPage=0){
		$pages = spark_printPaginationPages($pagesCount,$currentPage);
		return "<div class='pagination pagination-primary'>".$pages."</div>";
	}//


	function spark_endPanelPaging($pagesCount,$controller='',$URIParams='',$currentPage=0){

		$pagesHTML = '';
		$ci = &get_instance();
		$currentURL = base_url('admin/'.$ci->uri->segment(2).'/index');

		for($i=0;$i<$pagesCount;$i++){
			$class = '';
			if($i==$currentPage){
				$class='active';
			}
			$pagesHTML .="<li class= '$class'><a class='pagination-btn' data-page='".$i."' href='". $currentURL."/$i'>".($i+1)."</a></li>";
		}#for();
		$text = "
			</div><!-- End panel-body-->
			<div class='panel-footer text-center'>
				<ul class='pagination'>
					".$pagesHTML."
				</ul>
			</div><!-- End panel-footer-->
			</div><!-- End panel-->
		";
		return $text;
	}#endPanel();


	function spark_showUploadedImg($src,$class=''){
		return '<img src="'. site_url('uploads/pics/'). $src.'" class="'.$class.'" />';
	}#showUploadedImg();

	function spark_controlLinks($modelName,$id){
		$text = "<a class='btn btn-sm btn-info' href='man-".$modelName.".php?id=".$id."'>".spark_glyph('pencil')."</a><a class='btn btn-sm btn-danger remove-".$modelName."-btn' href='#' data-model-id='".$id."' data-model-name='".$modelName."' data-model-id='".$id."'>".spark_glyph('remove')."</a>";
		return $text;
	}#controlLinks();

	function spark_modalControlLinks($controllerName,$modelID,$modalTitle=''){
		$text = "<a href='#' data-toggle='modal' data-modal-title='$modalTitle' data-controller-name='$controllerName' data-target='#general-model-management-modal'	data-model-id='$modelID' class='btn btn-sm btn-info manage-model-btn'>".spark_glyph('pencil')."</a><a href='#' class='btn btn-sm btn-danger remove-model-btn' data-model-id='$modelID'  data-controller-name='$controllerName'>".spark_glyph('trash')."</a>";
		return $text;
	}#modalControlLinks();

	function spark_glyph($class){
		$class = spark_mapIcon($class);
		return '<i class="fas fa-'.$class.'"></i>';
		return '<i class="'.spark_glyphName($class).'"></i>';
	}#glyph();

	function spark_glyphName($name){
		return 'glyphicon glyphicon-'.$name;
	}#glyphName();


	function spark_defaultAnchorBtn($title,$link,$icon,$isBlank=0){
		$target = ($isBlank)? '_target' : '_self';
		$class = 'default';
		return spark_anchorBtn($title,$link,$class,$icon,$target);
	}#defaultAnchorBtn();


	function spark_successAnchorBtn($title,$link,$icon,$isBlank=0){
		$target = ($isBlank)? '_target' : '_self';
		$class = 'success';
		return spark_anchorBtn($title,$link,$class,$icon,$target);
	}#successAnchorBtn();


	function spark_infoAnchorBtn($title,$link,$icon,$isBlank=0){
		$target = ($isBlank)? '_target' : '_self';
		$class = 'info';
		return spark_anchorBtn($title,$link,$class,$icon,$target);
	}#infoAnchorBtn();


	function spark_primaryAnchorBtn($title,$link,$icon,$isBlank=0){
		$target = ($isBlank)? '_target' : '_self';
		$class = 'primary';
		return spark_anchorBtn($title,$link,$class,$icon,$target);
	}#primaryAnchorBtn();



	function spark_anchorBtn($title,$link,$class,$icon,$target='_self'){
		return spark_myAnchor($link,$title,array('class'=>'btn btn-sm btn-'.$class,'target'=>$target),$icon);
	}

	function spark_myAnchor($link,$title,$attrs=array(),$icon=''){
		$attrsText = '';
		foreach($attrs as $k=>$v){
			$attrsText .= " $k='$v' ";
		}
		if(strlen($icon)){
			$icon = spark_glyph($icon);
		}
		return "<a href='".$link."' $attrsText> $icon ".$title."</a>";
	}#myAnchor();

	function spark_modalAnchor($modalID,$title,$attrs=array()){
		$attrs['data-toggle']='modal';
		$attrs['data-target']='#'.$modalID;
		return spark_myAnchor('#',$title,$attrs);
	}#modalAnchor();

	function spark_myBlankAnchor($link,$title){
		$attrs = array('target'=>'_blank');
		return spark_myAnchor($link,$title,$attrs);
	}#myBlankAnchor();

	function spark_startForm($action='',$params=[],$id=''){
		return "<form action='".route($action,$params)."' method='POST' enctype='multipart/form-data' id='".$id."-form'>";
	}

	function spark_endForm(){
		return "</form>";
	}

	function spark_startCol($colsInfo,$attrs=''){
		$lg = isset($colsInfo[0])? $colsInfo[0] : 12;
		$md = isset($colsInfo[1])? $colsInfo[1] : 12;
		$sm = isset($colsInfo[2])? $colsInfo[2] : 12;
		$xs = isset($colsInfo[3])? $colsInfo[3] : 12;
		return "<div $attrs class='col-lg-$lg col-md-$md col-sm-$sm col-xs-$xs'>";
	}#startCol();

	function spark_endCol(){
		return '</div><!-- End cold-->';
	}#endCol();

	function spark_wrapErrors($errors){
		$text = "<ul>";
		foreach($errors as $error){
			$text .="<li>$error</li>";
		}#foreach();
		$text .= "</ul>";
		return $text;
	}#wrapErrors();

	function spark_wrapWithVoidAnchor($text){
		return spark_myAnchor('#',$text);
	}

	function spark_itemThumb($title,$desc,$main_pic,$href,$colSizes=array(3,3,6,12)){
		$btnInfo = array('href'=>$href,'class'=>'primary','title'=>'المزيد');
		$text = '
			 <div class="col-sm-'.$colSizes[2].' col-xs-'.$colSizes[3].' col-lg-'.$colSizes[0].' col-md-'.$colSizes[1].'">
		    <div class="thumbnail">
		    	<a href="'.$href.'">
		      '.spark_showUploadedImg($main_pic,'img-md img-rounded img-thumbnail').'
		     </a>
		      <div class="caption">
		        <h3 class="text-center">
		        	<a href="'.$href.'">
		        		'.$title.'
		        	</a>
		        </h3>
		        <p class="text-center">
		        	<a href="'.$href.'">
		        	'.btn($btnInfo).'
		        	</a>
		        </p>
		      </div>
		    </div>
		  </div>
		';
		return $text;
	}


	function spark_anchor($title='',$href='',$target='_blank'){
		return "<a target='".$target."' href='".$href."'>$title</a>";
	}

	function spark_clearfixDiv(){
		return "<div class='clearfix'></div>";
	}

	function spark_arrayToUL($array){
		$text = "<ul>";
		foreach($array as $k=>$v){
			$text .= "<li>$v</li>";
		}#foreach();
		$text .= "</ul>";
		return $text;
	}#arrayToUL();



	function spark_systemImg($imgName){
		return "<img src='".site_url('assets/img/'.$imgName)."'/>";
	}#systemImg;

	function spark_imgSrc($imageName){
		return config_item('base_url').'uploads/'.$imageName;
	}#spark_imgSrc();

	function spark_img($imageName,$classes=array()){
		$classesStr = implode(' ', $classes);
		return "<img class='".$classesStr."' src='".spark_imgSrc($imageName)."'/>";
	}#spark_img


	function spark_startThumbnail(){
		return "<div class'thumbnail'>";
	}#startThumbnail();

	function spark_endThumbnail(){
		return spark_clearfixDiv()."</div>";
	}/*endThumbnail*/

	function spark_printModal($modalID,$modalTitle,$btnsHTML){
		return '
		<div class="modal fade" id="'.$modalID.'-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">'.$modalTitle.'</h4>
	      </div>
	      <div class="modal-body">
	        ...
	      </div>
	      <div class="modal-footer">
	        "'.$btnsHTML.'"
	        <div class="clearfix"></div>
	      </div>
	    </div>
	  </div>
		</div>
';
	}/*spark_printModal*/


	function spark_badge($text,$class=''){
		return '<span class="badge $class">'.$text.'</span>';
	}/*badge*/

	function spark_countBadge($number){
		$html='';
		if($number){
			$html = spark_badge($number);
		}
		return $html;
	}/*spark_countBadge*/

	function spark_olFormatted($items=[]){
		$html = "<ol dir='rtl'>";
		foreach($items as $item){
			$term = __('general'.$item);
			$html .= "<li>$term</li>";
		}/*foreach*/
		return $html.'</ol>';
	}/*olFormatted*/

	function spark_ol($items=[]){
		$html = "<ol dir='rtl'>";
		foreach($items as $item){
			$html .= "<li>$item</li>";
		}/*foreach*/
		return $html.'</ol>';
	}

	function spark_ulFromArray($items=[]){
		$html = '<ul>';
		foreach($items as $item){
			$html .= "<li>$item</li>";
		}/*foreach*/
		return $html.'</ul>';
	}/*ulFromArray*/


	function spark_alerts($id=''){
		return spark_alertOK('',$id).spark_alertError('',$id);
	}/**/


	function spark_getPagingHTML(
		$pagesCount=0,
		$currentPage=0,
		$pagingURL='',
		$pagingParams=[],
		$currentPageParamIndex=0
	){

		$pagingHTML = '<div class="row text-center">';
		$pagingHTML.= '<ul class="pagination text-center">';
		$noSelectionBefore=1;

		for($i=0;$i<$pagesCount;$i++){
			$selectedHTML='';
			if($currentPage==$i && $noSelectionBefore==1){
				$selectedHTML = ' class="active"';
				$noSelectionBefore=0;
			}
			$pagingParams[$currentPageParamIndex]=$i;
			$theHref = spark_replaceR($pagingURL,$pagingParams);
			$anchorHTML = '<a href="'.$theHref.'">'.($i+1).'</a>';
			$pagingHTML .= '<li '.$selectedHTML.'>'.$anchorHTML.'</li>';
		}/*for pagesCount*/
		$pagingHTML .= '</ul>';
		$pagingHTML .= '</div>';

		return $pagingHTML;
	}/*pagingHTML*/


    function spark_submitBtn($info=[]){
        return "<button type='submit' name='".$info['name']."' class='btn btn-".$info['class']."'>".$info['title']."</button>";
    }
