$(document).ready(function(){      
 window.pageData={
   controller:'admins',
   currentPage:0,
   confirmMsg:'Are you sure?'
 };






 $('body').delegate('#save-profile-btn','click',function(e){
   e.preventDefault();  
  let route = adminPath('setProfile');

   var type = 'PUT' ;
   $.ajax({
     url:route,
     type:type,
     data:$('#man-'+window.pageData.controller+'-form').serialize(),
     success:function(res){
       var alertType = (res.status)? 'ok' : 'error';
       showAlert(alertType,'man-'+window.pageData.controller,res.msg);
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