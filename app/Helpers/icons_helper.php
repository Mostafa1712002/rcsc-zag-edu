<?php
 function spark_mapIcon($glyphicon=''){
  
  $materialIcons = [
   'pencil'=>'pencil-alt',
   'trash'=>'trash-alt',   
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   ''=>'',
   
   'plus'=>'add',
   'error'=>'error',
   'ok'=>'check_circle_outline',
   'orders'=>'',
   'globe'=>'',
   'location'=>'',
   'port'=>''
  ];
  return isset($materialIcons[$glyphicon])? $materialIcons[$glyphicon] : $glyphicon;
 }