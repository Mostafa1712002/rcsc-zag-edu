function systemPath(lang='ar'){
 var the_path = window.location.href.substring(0,window.location.href.indexOf('/public/')); 
 let return_path = (lang=='')? the_path+'/public/' : the_path+'/public/'+lang+'/';
 return return_path;
}

function publicPath(url){
return systemPath()+url;
}

function apiPath(url){
 var the_path = window.location.href.substring(0,window.location.href.indexOf('/public/'));
 return the_path+'/public/api/v1/'+url;
}

function adminPath(url){
return systemPath()+'admin/'+url;
}
