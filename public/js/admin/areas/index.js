$(document).ready(function(){      
 window.pageData={
   controller:'area',
   currentPage:0
 };

 window.pageMethods={
   filterRecords(){
     $.ajax({
       url:adminPath(window.pageData.controller+'/filter'),
       dataType:'HTML',
       type:'POST',
       data:{
         'title_ar':$('[name=filter-title_ar]').val(),
         'title_en':$('[name=filter-title_en]').val(),
         'city_id':$('[name=filter-city_id]').val(),
         'termLocation':termLocation,
         filterPage:window.pageData.currentPage,
         order_by:window.pageData.order_by,
         order_type:window.pageData.order_type
       },
       success:function(res){
         $('#filter-results').html(res);
       }
     });/*ajax*/
   }
 }/*filterRecords*/

 pageMethods.filterRecords();


 $('body').delegate('#save-record-btn','click',function(e){
   e.preventDefault();
   var route = 
     (current_record)?
       adminPath(window.pageData.controller+'/'+current_record) : adminPath(window.pageData.controller);

   var type = (current_record)? 'PUT' : 'POST';
   $.ajax({
     url:route,
     type:type,
     data:$('#man-'+window.pageData.controller+'-form').serialize(),
     success:function(res){
       var alertType = (res.status)? 'ok' : 'error';
       showAlert(alertType,'man-'+window.pageData.controller,res.msg);
       setTimeout(function(){
         $('#edit-record-modal').modal('hide');
       },2000);
       pageMethods.filterRecords();
     }/**/
   });/*Ajax*/
 });


});