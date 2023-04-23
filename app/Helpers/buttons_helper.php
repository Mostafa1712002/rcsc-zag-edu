<?php

	function spark_saveBtn($info=array()){
		$id = isset($info['id'])? $info['id'] : 'save-record-btn';
		$data = isset($info['data'])? $info['data'] : [];
		$size = isset($info['size'])? $info['size'] : 'lg';
		$pull = isset($info['pull'])? $info['pull'] : 'left';
		$icon = isset($info['icon'])? $info['icon'] : 'arrow-left';
		$class = isset($info['class'])? $info['class'] : 'success';
		$title = isset($info['title'])? $info['title'] : __('general.save');

		$btnInfo = [
			'title'=>$title,
			'class'=>$class,
			'size'=>$size,
			'pull'=>$pull,
			'icon'=>$icon,
			'id'=>$id,
			'data'=>$data
		];
		return spark_btn($btnInfo);
	}#save;

	function spark_getSearchBtn($info=[]){
		return spark_btn([
			'class'=>isset($info['class'])? $info['class'] : 'primary',
			'size'=>isset($info['size'])? $info['size'] : 'sm',
			'pull'=>isset($info['pull'])? $info['pull'] : 'no',
			'title'=>isset($info['title'])? $info['title'] : __('search'),
			'icon'=>isset($info['icon'])? $info['icon'] : 'search',
			'id'=>isset($info['id'])? $info['id'] : 'search-btn'
		]);
	}/*getSearchBtn*/

	function spark_getRemoveBtn($recordID=0,$class='remove-record-btn',$size='sm',$title=''){
		return spark_btn([
			'class'=>'danger '.$class,
			'pull'=>'no',
			'title'=>($title)? __('general.remove') : '',
			'icon'=>'trash',
			'size'=>$size,
			'data'=>['record-id'=>$recordID,'id'=>$recordID]
		]);
	}/*getremoveBtn*/

	function spark_removeBtn($recordID=0,$class='remove-record-btn'){
		return spark_getRemoveBtn($recordID,$class);
	}/*removeBtn*/

	function spark_getEditBtn($recordID=0,$class='edit-record-btn',$size='sm',$title=''){
		if(!strstr($class,' info') && !strstr($class,' success')){
			$class = 'info '.$class;
		}
		return spark_btn([
			'class'=>$class.' ml-1 mr-1',
			'pull'=>'no',
			'title'=>($title)?__('general.edit') : '',
			'icon'=>'pencil',
			'size'=>$size,
			'data'=>['record-id'=>$recordID,'id'=>$recordID]
		]);
	}/*getremoveBtn*/

	function spark_editBtn($recordID=0,$class='edit-record-btn'){
		return spark_getEditBtn($recordID,$class);
	}/**/

	function spark_getNewBtnInfo($info=[]){
		$class=isset($info['class'])? $info['class'] : 'edit-record-btn';
		$id=isset($info['id'])? $info['id'] : 'add-new-btn';
		return [
				'title'=>__('general.addNew'),
				'class'=>'success '.$class,
				'size'=>'sm',
				'pull'=>'left',
				'icon'=>'plus',
				'id'=>$id,
                'href'=>$info['href'],
				'data'=>['record-id'=>0,'id'=>0]
		];
	}#spark_getNewBtnInfo

	function spark_newBtn(){
		return spark_btn(spark_getNewBtnInfo());
	}#spark_newBtn;



	function spark_printBtn($info=[]){
		$id = isset($info['id'])? $info['id'] : '';
		$size = isset($info['size'])? $info['size'] : 'sm';
		$target = isset($info['target'])? $info['target'] : '';
		$href = isset($info['href'])? $info['href'] : '#';
		$pull = isset($info['pull'])? $info['pull'] : 'left';
		$title = isset($info['title'])? $info['title'] : __('print');
		$class = isset($info['class'])? $info['class'] : 'default';
		$icon = isset($info['icon'])? $info['icon'] : 'print';

		$btnInfo = array(
			'title'=>$title,
			'class'=>$class,
			'href'=>$href,
			'size'=>$size,
			'pull'=>$pull,
			'icon'=>$icon,
			'target'=>$target,
			'id'=>$id
		);
		return spark_btn($btnInfo);
	}#spark_printBtn;

	function spark_idWithPrintBtn($text,$href){
		return spark_tinyPrintBtn(['title'=>$text,'href'=>$href]);
	}/*idWithPrintBtn*/

	function spark_tinyPrintBtn($info=[]){
		$id = isset($info['id'])? $info['id'] : '';
		$size = 'sm';
		$href = isset($info['href'])? $info['href'] : '#';
		$pull = 'no';
		$title = isset($info['title'])? (strlen($info['title'])? '#'.$info['title'] : '') : __('print');
		$class = isset($info['class'])? $info['class'] : 'default';
		$target = isset($info['target'])? $info['target'] : '_blank';

		$btnInfo = [
			'class'=>$class,
			'size'=>$size,
			'pull'=>$pull,
			'icon'=>'print',
			'target'=>$target,
			'id'=>$id,
			'href'=>$href,
			'title'=>$title
		];
		return spark_btn($btnInfo);
	}#spark_printBtn;

	function spark_reportTinyPrintBtn($href){
		return "<a href='$href' target='_blank' class='hidden-print'><img src='".site_url('assets/img/print-icon.png')."'/></a> ";
	}#spark_reportTinyPrintBtn;

	function spark_getPrintBtnInfo($id){
		return [
			'title'=>__('print'),
			'icon'=>'print',
			'id'=>$id,
			'pull'=>'no',
			'size'=>'sm'
		];
	}#spark_getPrintBtnInfo

	function spark_filterBtn(){
		return spark_btn([
			'title'=>__('general.filter'),
			'icon'=>'filter',
			'id'=>'filter-records-btn',
			'pull'=>'left',
			'size'=>'sm'
		]);
	}

	function spark_resetBtn(){
		return spark_btn([
			'title'=>__('general.reset'),
			'icon'=>'reload',
			'id'=>'reset-filter-records-btn',
			'pull'=>'right',
			'size'=>'sm',
			'class'=>'danger'
		]);
	}



	function spark_printTermLocationBtns(){
		$btnInfo = [
			'class'=>'primary termLocation-btn',
			'size'=>'xs',
			'pull'=>'no',
			'icon'=>'no',
			'title'=>__('general.startsWith'),
			'data'=>['location'=>'startsWith']
		];
		$html= spark_btn($btnInfo);
		$btnInfo['title']=__('general.contains');
		$btnInfo['class'] = 'default termLocation-btn';
		$btnInfo['data'] = ['location'=>'contains'];
		$html.= spark_btn($btnInfo);
		return "<div class='text-center'>".$html."</div>";
	}






