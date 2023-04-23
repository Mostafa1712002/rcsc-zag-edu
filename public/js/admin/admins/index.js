$(document).ready(function(){      
 window.pageData={
   controller:'admins',
   currentPage:0,
   confirmMsg:'Are you sure?'
 };

 window.pageMethods={
   filterRecords(){     
     $.ajax({
       url:adminPath(window.pageData.controller+'/filter'),
       dataType:'HTML',
       type:'POST',
       data:{
         'name':$('[name=filter-name]').val(),
         'mobile':$('[name=filter-mobile]').val(),
         'email':$('[name=filter-email]').val(),
         'is_active':$('[name=filter-is_active]').val(),
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
 });/*save-record-btn*/

 $('body').delegate('[name=country_code]','change',function(e){   
   $('#country_code_span').text($(this).find(':selected').data('phone-code'));
 });/**/

 $(window).on('shown.bs.modal', function() { 
  $('#country_code_span').text($('[name=country_code]').find(':selected').data('phone-code'));
});/*modal shown*/

$('body').delegate('.show-eye-btn','click',function(e){
  e.preventDefault();
  let icon = $(this).find('i.fas');
  let span = $(this);
  if(icon.hasClass('fa-eye')){
    icon.removeClass('fa-eye').addClass('fa-eye-slash');
    $('[name='+span.data('related-element')+']').attr('type','text');
  }else{
    icon.removeClass('fa-eye-slash').addClass('fa-eye');
    $('[name='+span.data('related-element')+']').attr('type','password');
  }
   
});/*del*/



});