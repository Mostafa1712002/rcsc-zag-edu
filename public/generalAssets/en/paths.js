function systemPath(lang='en'){
 var the_path = window.location.href.substring(0,window.location.href.indexOf('/public/'));
 return the_path+'/public/'+lang+'/';

}

function publicPath(url){
 return systemPath()+url;
}


function apiPath(url){
 var the_path = window.location.href.substring(0,window.location.href.indexOf('/public/'));
 return the_path+'/api/'+url;
}

function adminPath(url){
 return systemPath()+'admin/'+url;
}
